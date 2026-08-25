(function() {
    'use strict';

    const storageKey = 'filter-ajax-theme';
    const allowedThemes = ['light', 'system', 'dark'];
    const colorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');

    function storedTheme() {
        try {
            const value = window.localStorage.getItem(storageKey);

            return allowedThemes.includes(value) ? value : 'system';
        } catch (error) {
            return 'system';
        }
    }

    function resolvedTheme(preference) {
        if (preference === 'system') {
            return colorSchemeQuery.matches ? 'dark' : 'light';
        }

        return preference;
    }

    function applyTheme(preference) {
        const theme = resolvedTheme(preference);
        const themeColor = theme === 'dark' ? '#18191a' : '#f5f5f3';

        document.documentElement.dataset.theme = theme;
        document.documentElement.style.colorScheme = theme;

        const themeColorMeta = document.querySelector('meta[name="theme-color"]');
        if (themeColorMeta) {
            themeColorMeta.setAttribute('content', themeColor);
        }
    }

    function saveTheme(preference) {
        try {
            window.localStorage.setItem(storageKey, preference);
        } catch (error) {
            // The selected theme still applies for the current page view.
        }
    }

    function updateControls(preference) {
        document.querySelectorAll('[data-theme-option]').forEach(function(button) {
            button.setAttribute(
                'aria-pressed',
                String(button.dataset.themeOption === preference)
            );
        });
    }

    function initializeThemeControls() {
        let preference = storedTheme();

        updateControls(preference);

        document.querySelectorAll('[data-theme-option]').forEach(function(button) {
            button.addEventListener('click', function() {
                const selectedTheme = button.dataset.themeOption;

                if (!allowedThemes.includes(selectedTheme)) {
                    return;
                }

                preference = selectedTheme;
                saveTheme(preference);
                applyTheme(preference);
                updateControls(preference);
            });
        });

        colorSchemeQuery.addEventListener('change', function() {
            if (preference === 'system') {
                applyTheme(preference);
            }
        });
    }

    function initializeCountdown() {
        const countdown = document.querySelector('[data-redirect-countdown]');

        if (!countdown) {
            return;
        }

        const unit = document.querySelector('[data-countdown-unit]');
        let seconds = Number.parseInt(countdown.dataset.redirectCountdown, 10);

        if (!Number.isInteger(seconds) || seconds < 1) {
            return;
        }

        const timer = window.setInterval(function() {
            seconds -= 1;
            countdown.textContent = String(seconds);

            if (unit) {
                unit.textContent = seconds === 1 ? 'second' : 'seconds';
            }

            if (seconds === 0) {
                window.clearInterval(timer);
            }
        }, 1000);
    }

    applyTheme(storedTheme());

    window.addEventListener('DOMContentLoaded', function() {
        initializeThemeControls();
        initializeCountdown();
    });
})();
