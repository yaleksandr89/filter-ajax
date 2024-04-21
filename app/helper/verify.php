<?php

// Validation ot the controller
function checkController(string $controller): int
{
    return (preg_match('~^\w+$~', $controller));
}

function checkTitle(string $title): int
{
    return preg_match('~^[a-z0-9_\-]*$~i', $title);
}

function prepareUserString(string $link): string
{
    $result = trim($link);

    return htmlspecialchars($result);
}

function prepareExternalLink(string $link)
{
    try {
        $result = trim($link);
        $result = htmlspecialchars($result);
        if (filter_var($result !== '' && $result, FILTER_VALIDATE_URL) === false) {
            throw new \RuntimeException(
                "Ошибка! Некорректно указан url, повторите ввод. Пользователь (IP: {$_SERVER['REMOTE_ADDR']}) ввел в поле: [{$link}]"
            );
        }

        return $result;
    } catch (Exception $exception) {
        unset($_POST['external_link']);
        echo 'Ошибка! Некорректно указан url, повторите ввод.<br><br>';
        file_put_contents(
            PATH_ROOT . '/logs/user_errors.txt',
            date('D, Y-m-d H:i:s') . ': ' . $exception->getMessage() . PHP_EOL,
            FILE_APPEND
        );
    }

    return null;
}
