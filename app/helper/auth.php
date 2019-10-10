<?php
// Authorization verification
function isAuth()
{
    $isAuth = false;
    // If everything is OK in the, then access allowed
    if (isset($_SESSION['is_auth']) && $_SESSION['is_auth']) {
        $isAuth = true;
        // If not, check out the cookies
//    } elseif (isset($_COOKIE['login']) && isset($_COOKIE['pass'])) {
    } elseif (isset($_COOKIE['login'], $_COOKIE['pass'])) {
        if (
            $_POST['login'] === password_hash('1', PASSWORD_DEFAULT) && $_POST['pass'] === password_hash('2',PASSWORD_DEFAULT)) {
            $_SESSION['is_auth'] = true;
            $isAuth = true;
        }
    }
    return $isAuth;
}