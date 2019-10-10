<?php
ini_set('date.timezone', 'Europe/Moscow');

// Defining constants
define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SERVER_NAME', $_SERVER['SERVER_NAME']);
define('SCRIPT_FILENAME', $_SERVER['SCRIPT_FILENAME']);

// Conversion dates: 2015-12-12 12:12:12 (MySQL) to 12.12.2015 в 12:12 (PHP)
function dateMysqlConvert($public_date)
{
    return date('d-m-Y', strtotime($public_date));
}

// The calculation of the algorithmic cost
function algorithmic_cost()
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

function viewsConnect(string $view_name, array $tpl = [])
{
    extract($tpl, EXTR_OVERWRITE);
    // Data buffering
    ob_start();
    include("app/views/{$view_name}");
    return ob_get_clean();
}

function redirect_404()
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    require_once('assets/404/index.php');
    exit;
}

function redirect_403()
{
    header('HTTP/1.1 403 FORBIDDEN');
    header('Status: 403 You Do Not Have Access To This Page');
    require_once('assets/403/index.php');
    exit;
}