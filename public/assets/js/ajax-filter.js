document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const selects = Array.from(document.querySelectorAll('.filter-field select'));
    const resultsBlock = document.querySelector('[data-filters-block]');
    const resetButton = document.querySelector('[data-filter-reset]');
    let requestInFlight = false;
    let pendingQuery = null;

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

    async function refreshResults() {
        updateResetState();
        pendingQuery = new URLSearchParams(selects.map(function(select) {
            return [select.name, select.value];
        }));

        if (requestInFlight) {
            return;
        }

        requestInFlight = true;
        resultsBlock.setAttribute('aria-busy', 'true');

        while (pendingQuery !== null) {
            const query = pendingQuery;
            pendingQuery = null;

            try {
                const response = await fetch('/ajax-filter?' + query.toString());
                if (!response.ok) {
                    throw new Error('Error when executing the request: ' + response.status);
                }

                const result = await response.text();
                if (pendingQuery === null) {
                    resultsBlock.innerHTML = result;

                    if (window.FilterAjaxUi) {
                        window.FilterAjaxUi.refreshLanguage(resultsBlock);
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }

        requestInFlight = false;
        resultsBlock.removeAttribute('aria-busy');
    }

    selects.forEach(function(select) {
        select.addEventListener('change', refreshResults);
    });

    if (resetButton) {
        resetButton.addEventListener('click', function() {
            selects.forEach(function(select) {
                select.value = 'all';
            });

            refreshResults();
        });
    }

    updateResetState();
});
