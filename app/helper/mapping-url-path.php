<?php

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/ajax-filter' === $urlPath) {
    include_once PATH_ROOT . '/app/helper/ajax-filter.php';
    die;
}
