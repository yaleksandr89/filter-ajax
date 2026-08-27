(function() {
    'use strict';

    const themeStorageKey = 'filter-ajax-theme';
    const languageStorageKey = 'filter-ajax-language';
    const allowedThemes = ['light', 'system', 'dark'];
    const allowedLanguages = ['ru', 'en'];
    const colorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');
    const translations = {
        ru: {
            documentDescription: 'Каталог товаров с AJAX-фильтрацией на PHP.',
            homeAria: 'Ajax filter — на главную',
            brandSubtitle: 'Каталог товаров на чистом PHP',
            languageControl: 'Язык интерфейса',
            themeControl: 'Цветовая тема',
            themeLight: 'Светлая',
            themeSystem: 'Система',
            themeDark: 'Тёмная',
            catalogEyebrow: 'Каталог товаров',
            catalogIntro: 'Выберите одно или несколько свойств, чтобы мгновенно сузить каталог.',
            refineEyebrow: 'Настройте выдачу',
            filterTitle: 'Фильтр товаров',
            filterHint: 'Каждое изменение автоматически обновляет результаты.',
            resetFilters: 'Сбросить',
            category: 'Категория',
            allCategories: 'Все категории',
            color: 'Цвет',
            allColors: 'Все цвета',
            weight: 'Вес',
            allWeights: 'Любой вес',
            productResults: 'Результаты фильтрации',
            noResultsTitle: 'Ничего не найдено',
            noResultsText: 'Сбросьте или измените фильтры, чтобы увидеть больше товаров.',
            authorName: 'Александр Юрченко',
            sourceCode: 'Исходный код на GitHub',
            notFoundDocumentTitle: '404 — Страница не найдена',
            notFoundDescription: 'Запрошенная страница не найдена.',
            notFoundEyebrow: 'За пределами каталога',
            notFoundTitle: 'Страница не найдена',
            notFoundMessage: 'Возможно, страница была перемещена или адрес указан не полностью.',
            backHome: 'На главную',
            contactAuthor: 'Написать автору',
            redirectPrefix: 'Автоматический возврат на главную через'
        },
        en: {
            documentDescription: 'PHP product catalogue with AJAX filtering.',
            homeAria: 'Ajax filter — home',
            brandSubtitle: 'Native PHP product explorer',
            languageControl: 'Interface language',
            themeControl: 'Color theme',
            themeLight: 'Light',
            themeSystem: 'System',
            themeDark: 'Dark',
            catalogEyebrow: 'Product catalogue',
            catalogIntro: 'Choose one or more properties to narrow the catalogue instantly.',
            refineEyebrow: 'Refine results',
            filterTitle: 'Filter products',
            filterHint: 'Each selection updates the results automatically.',
            resetFilters: 'Reset',
            category: 'Category',
            allCategories: 'All categories',
            color: 'Color',
            allColors: 'All colors',
            weight: 'Weight',
            allWeights: 'All weights',
            productResults: 'Product results',
            noResultsTitle: 'No matching products',
            noResultsText: 'Reset or change the filters to see more products.',
            authorName: 'Aleksandr Yurchenko',
            sourceCode: 'Source code on GitHub',
            notFoundDocumentTitle: '404 — Page not found',
            notFoundDescription: 'The requested page could not be found.',
            notFoundEyebrow: 'Outside the catalogue',
            notFoundTitle: 'Page not found',
            notFoundMessage: 'The page may have moved, or the address may be incomplete.',
            backHome: 'Back to home',
            contactAuthor: 'Contact the author',
            redirectPrefix: 'Automatic return home in'
        }
    };
    let languagePreference = storedLanguage();

    function storedTheme() {
        try {
            const value = window.localStorage.getItem(themeStorageKey);

            return allowedThemes.includes(value) ? value : 'system';
        } catch (error) {
            return 'system';
        }
    }

    function storedLanguage() {
        try {
            const value = window.localStorage.getItem(languageStorageKey);

            return allowedLanguages.includes(value) ? value : 'ru';
        } catch (error) {
            return 'ru';
        }
    }

    function storedLanguage() {
        try {
            const value = window.localStorage.getItem(languageStorageKey);

            return allowedLanguages.includes(value) ? value : 'ru';
        } catch (error) {
            return 'ru';
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
            window.localStorage.setItem(themeStorageKey, preference);
        } catch (error) {
            // The selected theme still applies for the current page view.
        }
    }

    function updateThemeControls(preference) {
        document.querySelectorAll('[data-theme-option]').forEach(function(button) {
            button.setAttribute(
                'aria-pressed',
                String(button.dataset.themeOption === preference)
            );
        });
    }

    function initializeThemeControls() {
        let preference = storedTheme();

        updateThemeControls(preference);

        document.querySelectorAll('[data-theme-option]').forEach(function(button) {
            button.addEventListener('click', function() {
                const selectedTheme = button.dataset.themeOption;

                if (!allowedThemes.includes(selectedTheme)) {
                    return;
                }

                preference = selectedTheme;
                saveTheme(preference);
                applyTheme(preference);
                updateThemeControls(preference);
            });
        });

        colorSchemeQuery.addEventListener('change', function() {
            if (preference === 'system') {
                applyTheme(preference);
            }
        });
    }

    function saveLanguage(preference) {
        try {
            window.localStorage.setItem(languageStorageKey, preference);
        } catch (error) {
            // The selected language still applies for the current page view.
        }
    }

    function updateLanguageControls(preference) {
        document.querySelectorAll('[data-language-option]').forEach(function(button) {
            button.setAttribute(
                'aria-pressed',
                String(button.dataset.languageOption === preference)
            );
        });
    }

    function translateElements(root, selector, attribute, translationAttribute) {
        root.querySelectorAll(selector).forEach(function(element) {
            const key = element.getAttribute(translationAttribute);
            const value = translations[languagePreference][key];

            if (typeof value !== 'string') {
                return;
            }

            if (attribute) {
                element.setAttribute(attribute, value);
            } else {
                element.textContent = value;
            }
        });
    }

    function refreshLanguage(root) {
        const scope = root || document;

        translateElements(scope, '[data-i18n]', null, 'data-i18n');
        translateElements(scope, '[data-i18n-aria-label]', 'aria-label', 'data-i18n-aria-label');
        translateElements(scope, '[data-i18n-content]', 'content', 'data-i18n-content');
        updateCountdownUnit();
    }

    function applyLanguage(preference) {
        languagePreference = preference;
        document.documentElement.lang = preference;
        document.documentElement.dataset.language = preference;
        refreshLanguage(document);
        updateLanguageControls(preference);
    }

    function initializeLanguageControls() {
        applyLanguage(languagePreference);

        document.querySelectorAll('[data-language-option]').forEach(function(button) {
            button.addEventListener('click', function() {
                const selectedLanguage = button.dataset.languageOption;

                if (!allowedLanguages.includes(selectedLanguage)) {
                    return;
                }

                saveLanguage(selectedLanguage);
                applyLanguage(selectedLanguage);
            });
        });
    }

    function countdownUnit(seconds) {
        if (languagePreference === 'en') {
            return seconds === 1 ? 'second' : 'seconds';
        }

        const lastTwoDigits = seconds % 100;
        const lastDigit = seconds % 10;

        if (lastTwoDigits >= 11 && lastTwoDigits <= 14) {
            return 'секунд';
        }

        if (lastDigit === 1) {
            return 'секунда';
        }

        if (lastDigit >= 2 && lastDigit <= 4) {
            return 'секунды';
        }

        return 'секунд';
    }

    function updateCountdownUnit() {
        const countdown = document.querySelector('[data-redirect-countdown]');
        const unit = document.querySelector('[data-countdown-unit]');

        if (!countdown || !unit) {
            return;
        }

        const seconds = Number.parseInt(countdown.textContent, 10);
        if (Number.isInteger(seconds)) {
            unit.textContent = countdownUnit(seconds);
        }
    }

    function initializeCountdown() {
        const countdown = document.querySelector('[data-redirect-countdown]');

        if (!countdown) {
            return;
        }

        let seconds = Number.parseInt(countdown.dataset.redirectCountdown, 10);

        if (!Number.isInteger(seconds) || seconds < 1) {
            return;
        }

        updateCountdownUnit();

        const timer = window.setInterval(function() {
            seconds -= 1;
            countdown.textContent = String(seconds);
            updateCountdownUnit();

            if (seconds === 0) {
                window.clearInterval(timer);
            }
        }, 1000);
    }

    applyTheme(storedTheme());
    document.documentElement.lang = languagePreference;
    document.documentElement.dataset.language = languagePreference;

    window.FilterAjaxUi = {
        currentLanguage: function() {
            return languagePreference;
        },
        refreshLanguage: refreshLanguage
    };

    window.addEventListener('DOMContentLoaded', function() {
        initializeThemeControls();
        initializeLanguageControls();
        initializeCountdown();
    });
})();
