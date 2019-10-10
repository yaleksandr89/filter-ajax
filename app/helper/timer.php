<?php
function goIndex(int $second)
{
    header("refresh: {$second}; url=/");
    exit;
}