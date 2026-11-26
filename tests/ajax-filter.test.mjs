import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {setImmediate} from 'node:timers/promises';
import test from 'node:test';
import {runInNewContext} from 'node:vm';

const source = readFileSync(new URL('../public/assets/js/ajax-filter.js', import.meta.url), 'utf8');
const empty = {category: 'all', color: 'all', weight: 'all'};

function mount() {
    const selects = Object.keys(empty).map(function(name) {
        return Object.assign(new EventTarget(), {name, value: 'all'});
    });
    const reset = new EventTarget();
    const requests = [];
    const renders = [];
    const language = [];
    const errors = [];
    const session = {};
    const attributes = new Map();
    const results = {
        set innerHTML(html) {
            renders.push(html);
        },
        setAttribute: (key, value) => attributes.set(key, value),
        removeAttribute: (key) => attributes.delete(key)
    };

    const document = Object.assign(new EventTarget(), {
        querySelectorAll: () => selects,
        querySelector: (selector) => ({
            '[data-filters-block]': results,
            '[data-filter-reset]': reset
        })[selector]
    });

    function fetch(path, {signal} = {}) {
        const url = new URL(path, 'https://example.test');
        assert.equal(url.pathname, '/ajax-filter');
        const criteria = Object.fromEntries(url.searchParams);
        return new Promise(function(resolve, reject) {
            signal?.addEventListener('abort', () => reject(new DOMException('Aborted', 'AbortError')));
            requests.push({
                criteria,
                deliver({writeAfterAbort = false} = {}) {
                    if (!signal?.aborted || writeAfterAbort) {
                        for (const [key, value] of Object.entries(criteria)) {
                            if (value === 'all') {
                                delete session[key];
                            } else {
                                session[key] = value;
                            }
                        }
                        const body = JSON.stringify(session);
                        resolve({ok: true, text: async () => body});
                    }
                },
                httpError: () => resolve({ok: false, status: 503}),
                networkError: () => reject(new TypeError('Network unavailable'))
            });
        });
    }

    runInNewContext(source, {
        document, fetch, URLSearchParams, AbortController,
        window: {FilterAjaxUi: {refreshLanguage(block) {
            assert.equal(block, results);
            language.push(renders.at(-1));
        }}},
        console: {error: (error) => errors.push(error.message)}
    }, {filename: 'ajax-filter.js'});
    document.dispatchEvent(new Event('DOMContentLoaded'));

    return {
        requests, renders, language, errors, reset, session,
        busy: () => attributes.get('aria-busy'),
        change(name, value) {
            const select = selects.find((item) => item.name === name);
            select.value = value;
            select.dispatchEvent(new Event('change'));
        }
    };
}

test('rapid changes preserve the complete selection and render only the current response', async () => {
    const ui = mount();
    assert.equal(ui.reset.disabled, true);
    ui.change('category', 'Laptop');
    assert.equal(ui.reset.disabled, false);
    ui.change('weight', '3kg');
    ui.change('color', 'Black');
    const requestsBeforeDelivery = ui.requests.length;

    // Deliver the first request after the other changes. An aborted request
    // that never reached PHP contributes no criteria to the session.
    ui.requests[0].deliver();
    await setImmediate();
    assert.equal(ui.busy(), 'true');
    assert.deepEqual(ui.renders, []);
    assert.deepEqual(ui.language, []);
    assert.deepEqual(ui.requests.at(-1).criteria, {category: 'Laptop', color: 'Black', weight: '3kg'});
    assert.equal(requestsBeforeDelivery, 1);
    assert.deepEqual(ui.requests[0].criteria, {...empty, category: 'Laptop'});
    assert.deepEqual(ui.session, {category: 'Laptop'});
    assert.equal(ui.requests.length, 2);
    ui.requests[1].deliver();
    await setImmediate();

    assert.deepEqual(ui.session, {category: 'Laptop', color: 'Black', weight: '3kg'});
    assert.deepEqual(ui.renders.map(JSON.parse), [ui.session]);
    assert.deepEqual(ui.language, ui.renders);
    assert.equal(ui.busy(), undefined);
});

test('reset waits for a request that can still write session state', async () => {
    const ui = mount();
    ui.change('category', 'Laptop');
    ui.change('color', 'Black');
    ui.reset.dispatchEvent(new Event('click'));
    assert.equal(ui.reset.disabled, true);

    // If the client sent reset already, it can reach PHP before the older
    // request, even if the older browser promise was aborted.
    if (ui.requests.length > 1) {
        ui.requests.at(-1).deliver();
    }
    ui.requests[0].deliver({writeAfterAbort: true});
    await setImmediate();

    assert.deepEqual(ui.renders, []);
    assert.equal(ui.busy(), 'true');
    assert.equal(ui.requests.length, 2);
    assert.deepEqual(ui.requests[1].criteria, empty);
    ui.requests[1].deliver();
    await setImmediate();
    assert.deepEqual(ui.session, {});
    assert.deepEqual(ui.renders, ['{}']);
    assert.deepEqual(ui.language, ['{}']);
    assert.equal(ui.busy(), undefined);
});

test('HTTP and network errors are logged and a later change submits the full selection', async () => {
    const ui = mount();
    ui.change('category', 'Laptop');
    ui.change('color', 'Black');
    ui.requests[0].httpError();
    await setImmediate();
    assert.equal(ui.busy(), 'true');
    assert.equal(ui.requests.length, 2);
    ui.requests[1].networkError();
    await setImmediate();

    assert.deepEqual(ui.errors, ['Error when executing the request: 503', 'Network unavailable']);
    assert.equal(ui.busy(), undefined);
    assert.deepEqual(ui.renders, []);
    assert.deepEqual(ui.language, []);
    assert.equal(ui.requests.length, 2);

    ui.change('weight', '3kg');
    assert.deepEqual(ui.requests[2].criteria, {category: 'Laptop', color: 'Black', weight: '3kg'});
    ui.requests[2].deliver();
    await setImmediate();
    assert.deepEqual(ui.renders.map(JSON.parse), [ui.session]);
});
