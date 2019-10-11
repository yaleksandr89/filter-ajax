<!doctype html>
<html lang="ru" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <!-- realfavicongenerator START-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon-16x16.png">
    <link rel="manifest" href="assets/site.webmanifest">
    <link rel="mask-icon" href="assets/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="assets/favicon.ico">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="msapplication-config" content="assets/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- realfavicongenerator END-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/404/error_404.css">
    <title>Error 404-page not found</title>
</head>
<body id="er403" class="h-100">
<section class="h-100">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-md-12">
                <div id="app" class="mx-auto">
                    <div><span class="numberErr">404</span></div>
                    <div class="txt">
                        <p>The requested page does not exist or has been deleted.</p>
                        <p>If you are sure otherwise, please contact me<span class="blink">_</span></p>
                        <form class="form-group text-center">
                            <button type="button" class="btn btn-outline-secondary" onclick="location.href='/php/ajax-filter'">
                                Back to home
                            </button>
                            <button type="button" class="btn btn-outline-warning"
                                    onclick="location.href='mailto:yaleksandr89@gmail.com?subject=Letter%20from%20the%20site%20ajax%20filter(Error%20404)&body=Hello!'">
                                Write a letter
                            </button>
                        </form>
                        <p class="mt-5">Automatic redirection to the main page <span class="timer">10</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/404/error_404.js"></script>
</body>
</html>
<?php goIndex(10,'/'); ?>