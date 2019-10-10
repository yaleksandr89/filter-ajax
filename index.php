<?php
require_once('app/helper/system.php');
require_once('app/helper/verify.php');

//session_start();
$err404 = false;
$controller = trim($get_tpl[0] ?? 'main');

// Connecting necessary controller
if ($controller === '' || !file_exists("app/controllers/{$controller}.php") || checkController('app/controllers/' . "{$controller}.php")) {
    $err404 = true;
    exit('err404 = true');
} else {
    include 'app/controllers/' . "{$controller}.php";
}

//if ($err404) {
//    redirect_404();
//}

// Формирование страницы
echo viewsConnect('index.php', [
    'title' => $title,
    'navBar' => $navBar,
    'urlShortener'=>$urlShortener,
    //'infoBlock' => $infoBlock
]);