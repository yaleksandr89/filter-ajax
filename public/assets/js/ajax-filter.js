document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const selects = Array.from(document.querySelectorAll('.filter-field select'));
    const resultsBlock = document.querySelector('[data-filters-block]');
    const resetButton = document.querySelector('[data-filter-reset]');
    let activeRequest = null;

    if (!resultsBlock || selects.length === 0) {
        return;
    }

    function updateResetState() {
        if (!resetButton) {
            return;
        }

        resetButton.disabled = selects.every(function(select) {
            return select.value === 'all';
        });
    }

    function refreshResults(query) {
        if (activeRequest) {
            activeRequest.abort();
        }

        const controller = new AbortController();
        activeRequest = controller;
        resultsBlock.setAttribute('aria-busy', 'true');

        return fetch('/ajax-filter?' + query.toString(), {signal: controller.signal})
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Error when executing the request: ' + response.status);
                }

                return response.text();
            })
            .then(function(result) {
                resultsBlock.innerHTML = result;

                if (window.FilterAjaxUi) {
                    window.FilterAjaxUi.refreshLanguage(resultsBlock);
                }
            })
            .catch(function(error) {
                if (error.name !== 'AbortError') {
                    console.error(error);
                }
            })
            .finally(function() {
                if (activeRequest === controller) {
                    activeRequest = null;
                    resultsBlock.removeAttribute('aria-busy');
                }
            });
    }

    selects.forEach(function(select) {
        select.addEventListener('change', function() {
            const query = new URLSearchParams({
                [select.name]: select.value
            });

            updateResetState();
            refreshResults(query);
        });
    });

    if (resetButton) {
        resetButton.addEventListener('click', function() {
            const query = new URLSearchParams();

            selects.forEach(function(select) {
                select.value = 'all';
                query.set(select.name, 'all');
            });

            updateResetState();
            refreshResults(query);
        });
    }

    updateResetState();
});
