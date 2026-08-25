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
    <title>404 — Page not found</title>
    <meta name="description" content="The requested page could not be found.">
</head>
<body class="page-404">
<header class="app-header">
    <div class="shell app-header__inner">
        <a class="brand" href="/" aria-label="Ajax filter — home">
            <img class="brand__mark" src="/assets/logotype.png" width="48" height="48" alt="">
            <span class="brand__text">
                <strong>Ajax filter</strong>
                <span>Native PHP product explorer</span>
            </span>
        </a>

        <div class="theme-control" role="group" aria-label="Color theme">
            <button type="button" data-theme-option="light" aria-pressed="false">Light</button>
            <button type="button" data-theme-option="system" aria-pressed="true">System</button>
            <button type="button" data-theme-option="dark" aria-pressed="false">Dark</button>
        </div>
    </div>
</header>

<main class="shell not-found">
    <section class="not-found__panel" aria-labelledby="not-found-title">
        <p class="not-found__code" aria-hidden="true">404</p>
        <p class="eyebrow">Outside the catalogue</p>
        <h1 id="not-found-title">Page not found</h1>
        <p class="not-found__message">
            The page may have moved, or the address may be incomplete.
        </p>

        <div class="not-found__actions">
            <a class="primary-button" href="/">Back to home</a>
            <a
                class="text-link"
                href="mailto:yaleksandr89@gmail.com?subject=Letter%20from%20the%20site%20ajax%20filter%20(Error%20404)&amp;body=Hello!"
            >
                Contact the author
            </a>
        </div>

        <p class="redirect-note">
            Automatic return home in
            <strong data-redirect-countdown="10">10</strong>
            <span data-countdown-unit>seconds</span>.
        </p>
    </section>
</main>
</body>
</html>
