<?php

require_once('app/helper/system.php');
require_once('app/helper/verify.php');
require_once('app/helper/timer.php');
require_once('app/helper/get-tmp-name.php');

session_start();
$controller = trim($get_tpl[0] ?? 'main');

// Connecting necessary controller
try {
    if ($controller === '' || !file_exists("app/controllers/{$controller}.php") || checkController('app/controllers/' . "{$controller}.php")) {
        throw new \RuntimeException('Ошибка при подключении: [' . getTemplateName() . ']');
    }
    require_once('app/controllers/' . "{$controller}.php");
} catch (Exception $exception) {
    file_put_contents(
        __DIR__ . '/logs/Errors_system.txt',
        date('Y-m-d H:i:s') . ': ' . $exception->getMessage() . PHP_EOL,
        FILE_APPEND
    );
    redirect_404();
}

$infoBlock = viewsConnect('info-block.php', [
    'infoBlock' => $_POST['product_info_error'] ?? null,
]);

// The formation of the page
echo viewsConnect('index.php', [
    'title' => $title ?? null,
    'navigationMenu' => $navigationMenu ?? null,
    'ajaxFilter' => $ajaxFilter ?? null,
]);
