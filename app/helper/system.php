<?php

use JetBrains\PhpStorm\NoReturn;

ini_set('date.timezone', 'Europe/Moscow');

// Defining constants
define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SERVER_NAME', $_SERVER['SERVER_NAME']);
define('SCRIPT_FILENAME', $_SERVER['SCRIPT_FILENAME']);

// Conversion dates: 2015-12-12 12:12:12 (MySQL) to 12.12.2015 в 12:12 (PHP)
function dateMysqlConvert($public_date): string
{
    return date('d-m-Y', strtotime($public_date));
}

// The calculation of the algorithmic cost
function algorithmic_cost(): array
{
    return ['cost' => 10];
}

// Split $_GET request
$get_tpl = explode('/', $_GET['get_tpl'] ?? '');

// Delete the last, empty element of the array
$lastElement = count($get_tpl) - 1;
if ($get_tpl[$lastElement] === '') {
    unset($get_tpl[$lastElement]);
    $lastElement--;
}

function viewsConnect(string $view_name, array $tpl = []): false|string
{
    extract($tpl);
    ob_start();
    include("app/views/$view_name");

    return ob_get_clean();
}

#[NoReturn]
function redirect_404(): void
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    require_once('assets/404/index.php');
    exit;
}
