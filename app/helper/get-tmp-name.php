<?php
declare(strict_types=1);

function getTemplateName(): string
{
    $result = str_replace($_SERVER['HTTP_HOST'], '', $_SERVER['QUERY_STRING']);
    $result = explode('=', $result);
    $result = array_pop($result);
    return $result;
}