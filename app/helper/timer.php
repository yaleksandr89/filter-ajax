<?php
function goIndex(int $second, string $backUrl)
{
    header("refresh: {$second}; url={$backUrl}");
    exit;
}