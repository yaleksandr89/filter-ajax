<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn]
function goIndex(int $second, string $backUrl): void
{
    header("refresh: $second; url=$backUrl");
    exit;
}
