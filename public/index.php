<?php

ini_set('date.timezone', 'Europe/Moscow');
session_start();

define('PATH_ROOT', dirname(__DIR__));

require_once(PATH_ROOT . '/app/helper/system.php');
require_once(PATH_ROOT . '/app/helper/verify.php');
require_once(PATH_ROOT . '/app/helper/timer.php');
require_once(PATH_ROOT . '/app/helper/get-tmp-name.php');
require_once(PATH_ROOT . '/app/helper/mapping-url-path.php');

try {
    $controller = trim($get_tpl[0] ?? 'main');

    if (
        $controller === '' ||
        !file_exists(PATH_ROOT . "/app/controllers/$controller.php") ||
        checkController(PATH_ROOT . "/app/controllers/$controller.php")
    ) {
        throw new RuntimeException('Ошибка при подключении: [' . getTemplateName() . ']');
    }
    require_once(PATH_ROOT . '/app/controllers/' . "$controller.php");
} catch (Exception $exception) {
    file_put_contents(
        PATH_ROOT . '/logs/system-errors.txt',
        date('Y-m-d H:i:s') . ': ' . $exception->getMessage() . PHP_EOL,
        FILE_APPEND
    );
    redirect_404();
}

$infoBlock = viewsConnect('info-block.php', [
    'infoBlock' => $_POST['product_info_error'] ?? null,
]);

echo viewsConnect('index.php', [
    'title' => $title ?? null,
    'navigationMenu' => $navigationMenu ?? null,
    'data' => $data ?? null,
]);
