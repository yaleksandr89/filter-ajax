<?php
declare(strict_types=1);

function checkSelectAttribute(string $session_key, string $filter_name)
{
    if (isset($_SESSION[$session_key]) && $_SESSION[$session_key] === $filter_name) {
        return 'selected';
    }
    return null;
}