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
    <meta name="description" content="<?= $this->escape($title) ?>">
</head>
<body>
<header class="app-header">
    <div class="shell app-header__inner">
        <a class="brand" href="/" aria-label="Ajax filter — home">
            <img
                class="brand__mark"
                src="/assets/logotype.png"
                width="48"
                height="48"
                alt=""
            >
            <span class="brand__text">
                <strong><?= $this->escape($title) ?></strong>
                <span>Native PHP product explorer</span>
            </span>
        </a>

        <div class="app-header__actions">
            <a
                class="source-link"
                href="https://github.com/yaleksandr89/filter-ajax"
                target="_blank"
                rel="nofollow noopener"
            >
                Source code <span aria-hidden="true">↗</span>
            </a>

            <div class="theme-control" role="group" aria-label="Color theme">
                <button type="button" data-theme-option="light" aria-pressed="false">Light</button>
                <button type="button" data-theme-option="system" aria-pressed="true">System</button>
                <button type="button" data-theme-option="dark" aria-pressed="false">Dark</button>
            </div>
        </div>
    </div>
</header>

<main class="shell app-main">
    <section class="page-intro" aria-labelledby="page-title">
        <p class="eyebrow">Product catalogue</p>
        <h1 id="page-title"><?= $this->escape($title) ?></h1>
        <p>Choose one or more properties to narrow the catalogue instantly.</p>
    </section>

    <?= $content ?>
</main>

<script src="/assets/js/ajax-filter.js"></script>
</body>
</html>
