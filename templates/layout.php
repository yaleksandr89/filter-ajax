<?php

/**
 * @var \App\View\ViewRenderer $this
 * @var string $title
 * @var string $content Trusted, already-rendered HTML.
 */
?>
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
    <title><?= $this->escape($title) ?></title>
    <meta
        name="description"
        content="Каталог товаров с AJAX-фильтрацией на PHP."
        data-i18n-content="documentDescription"
    >
</head>
<body>
<header class="app-header">
    <div class="shell app-header__inner">
        <a class="brand" href="/" aria-label="Ajax filter — на главную" data-i18n-aria-label="homeAria">
            <img
                class="brand__mark"
                src="/assets/logotype.png"
                width="48"
                height="48"
                alt=""
            >
            <span class="brand__text">
                <strong><?= $this->escape($title) ?></strong>
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

<main class="shell app-main">
    <section class="page-intro" aria-labelledby="page-title">
        <p class="eyebrow" data-i18n="catalogEyebrow">Каталог товаров</p>
        <h1 id="page-title"><?= $this->escape($title) ?></h1>
        <p data-i18n="catalogIntro">Выберите одно или несколько свойств, чтобы мгновенно сузить каталог.</p>
    </section>

    <?= $content ?>
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

<script src="/assets/js/ajax-filter.js"></script>
</body>
</html>
