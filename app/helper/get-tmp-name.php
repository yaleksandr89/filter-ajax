<?php

function getTemplateName(): string
{
    $result = str_replace($_SERVER['HTTP_HOST'], '', $_SERVER['QUERY_STRING']);
    $result = explode('=', $result);

    return array_pop($result);
}
