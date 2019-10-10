<?php
declare(strict_types=1);

function changeKeyExistArray(array $array, array $tplSearch = [], array $tplReplace = []): array
{
    $resultArray = array_flip($array);
    $result = str_replace($tplSearch, $tplReplace, $resultArray);
    $resultArray = array_flip($result);
    return $resultArray;
}