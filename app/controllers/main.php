<?php
// Controllers
require_once('app/models/database.php');
// Helpers
require_once('app/helper/auth.php');
require_once('app/helper/verify.php');
require_once('app/helper/generate-id.php');
require_once('app/helper/change-array-key.php');

$isAuth = isAuth();

$str = $_SERVER['REQUEST_URI'];
$replaceStrUri = substr_replace($str, '', 0, 1);
$_SESSION['returnUrl'] = $replaceStrUri ?? null;

$cookieLogin = $_COOKIE['login'] ?? null;
$cookiePass = $_COOKIE['pass'] ?? null;

// Start URL Shortener
//$externalLink = $_POST['external_link'] ?? '';
//$preparedLink = prepareExternalLink($externalLink);
//
//$sth = db_query("SELECT url, short_key FROM short WHERE url= '" . $preparedLink . "'")->fetch();
//$response = $sth;
//
//$url = $sth['url'];
//$short_url = "http://{$_SERVER['HTTP_HOST']}/{$sth['short_key']}";
//
//if ($response !== false){
//    $response = array_merge($response,['short_link' => $short_url]);
//    $response = changeKeyExistArray($response,['url','short_key','short_link'],['External-url','ID-shortened-url','Shortened-url']);
//}

// Connect navigation menu
$navBar = viewsConnect('front-page/menu.php', [
    'isAuth' => $isAuth,
]);

//Connect a block to display information: warning or error
//$infoBlock = viewsConnect('info.php', [
//    'infoBlock' => $_POST['infoBlock']
//]);

// Connect title
$title = 'Ajax filter';

// Подключение имеющихся статей
$urlShortener = viewsConnect('front-page/list.php', [
    'isAuth' => $isAuth,
    //'response' => $response,
    //'url' => $url,
    //'short_url' => $short_url,
//    'infoBlock' => $infoBlock
]);