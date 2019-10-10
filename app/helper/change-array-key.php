<?php

function changeKeyExistArray($array, $tplSearch = [], $tplReplace = [])
{
    $resultArray = array_flip($array);
    $result = str_replace($tplSearch, $tplReplace, $resultArray);
    $resultArray = array_flip($result);
    return $resultArray;
}

/**
 * Draft function (function too long, but work_
$test = changeKeyExistArray($sth);
var_dump($test);
exit;
function changeKeyExistArray($array_key)
{
switch ($array_key) {
case ($array_key === 'url'):
$array_key = 'external_link';
return $array_key;
break;
case ($array_key === 'short_key'):
$array_key = 'short_link';
return $array_key;
break;
default:
return $array_key;
}
}
$new = array_flip(array_map('changeKeyExistArray', array_flip($response)));
 */