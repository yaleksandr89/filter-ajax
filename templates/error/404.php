<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="msapplication-config" content="/assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#f5f5f3">
    <script src="/assets/js/ui.js"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <title data-i18n="notFoundDocumentTitle">404 — Страница не найдена</title>
    <meta
        name="description"
        content="Запрошенная страница не найдена."
        data-i18n-content="notFoundDescription"
    >
</head>
<body class="page-404">
<header class="app-header">
    <div class="shell app-header__inner">
        <a class="brand" href="/" aria-label="Ajax filter — на главную" data-i18n-aria-label="homeAria">
            <img class="brand__mark" src="/assets/logotype.png" width="48" height="48" alt="">
            <span class="brand__text">
                <strong>Ajax filter</strong>
                <span data-i18n="brandSubtitle">Каталог товаров на чистом PHP</span>
            </span>
        </a>

        <div class="app-header__actions">
            <div
                class="language-control"
                role="group"
                aria-label="Язык интерфейса"
                data-i18n-aria-label="languageControl"
            >
                <span class="language-control__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" focusable="false">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M3 12h18M12 3c2.4 2.5 3.6 5.5 3.6 9S14.4 18.5 12 21M12 3C9.6 5.5 8.4 8.5 8.4 12S9.6 18.5 12 21"></path>
                    </svg>
                </span>
                <button type="button" data-language-option="ru" aria-pressed="true">RU</button>
                <button type="button" data-language-option="en" aria-pressed="false">EN</button>
            </div>

            <div
                class="theme-control"
                role="group"
                aria-label="Цветовая тема"
                data-i18n-aria-label="themeControl"
            >
                <button
                    type="button"
                    data-theme-option="light"
                    aria-pressed="false"
                    aria-label="Светлая"
                    data-i18n-aria-label="themeLight"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="12" cy="12" r="3.5"></circle>
                        <path d="M12 2.75v2M12 19.25v2M2.75 12h2M19.25 12h2M5.46 5.46l1.41 1.41M17.13 17.13l1.41 1.41M18.54 5.46l-1.41 1.41M6.87 17.13l-1.41 1.41"></path>
                    </svg>
                </button>

                <button
                    type="button"
                    data-theme-option="system"
                    aria-pressed="true"
                    aria-label="Система"
                    data-i18n-aria-label="themeSystem"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <rect x="3.5" y="4.5" width="17" height="12" rx="1.5"></rect>
                        <path d="M9 20h6M12 16.5V20"></path>
                    </svg>
                </button>

                <button
                    type="button"
                    data-theme-option="dark"
                    aria-pressed="false"
                    aria-label="Тёмная"
                    data-i18n-aria-label="themeDark"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M20.25 14.25A8.25 8.25 0 0 1 9.75 3.75a8.25 8.25 0 1 0 10.5 10.5Z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<main class="shell not-found">
    <section class="not-found__panel" aria-labelledby="not-found-title">
        <p class="not-found__code" aria-hidden="true">404</p>
        <p class="eyebrow" data-i18n="notFoundEyebrow">За пределами каталога</p>
        <h1 id="not-found-title" data-i18n="notFoundTitle">Страница не найдена</h1>
        <p class="not-found__message" data-i18n="notFoundMessage">
            Возможно, страница была перемещена или адрес указан не полностью.
        </p>

        <div class="not-found__actions">
            <a class="primary-button" href="/" data-i18n="backHome">На главную</a>
            <a
                class="text-link"
                href="mailto:yaleksandr89@gmail.com?subject=Letter%20from%20the%20site%20ajax%20filter%20(Error%20404)&amp;body=Hello!"
                data-i18n="contactAuthor"
            >
                Написать автору
            </a>
        </div>

        <p class="redirect-note">
            <span data-i18n="redirectPrefix">Автоматический возврат на главную через</span>
            <strong data-redirect-countdown="10">10</strong>
            <span data-countdown-unit>секунд</span>.
        </p>
    </section>
</main>

<footer class="app-footer">
    <div class="shell app-footer__inner">
        <p>
            <a href="https://yaleksandr89.github.io/" target="_blank" rel="me noopener" data-i18n="authorName">Александр Юрченко</a>
            <span aria-hidden="true">•</span>
            <a
                href="https://github.com/yaleksandr89/filter-ajax"
                target="_blank"
                rel="noopener"
                data-i18n="sourceCode"
            >Исходный код на GitHub</a>
        </p>
    </div>
</footer>
</body>
</html>
