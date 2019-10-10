<?php
function generateId(string $string = '', int $len = 8): string
{
    $letters = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
    $x = 0;
    while ($x < $len) {
        $string .= $letters[array_rand($letters)];
        $x++;
    }
    return $string;
}

function checkingCreatedId(string $string): bool
{
    $db_check = db_query("select count(*) from short where short_key = '$string'")->fetchColumn();
    if ($db_check) {
        return true;
    }
    return false;
}

function getIdShortLink(int $id_length): string
{
    $getId = generateId('', $id_length);
    if (checkingCreatedId($getId)) {
        getIdShortLink($id_length);
    }
    return $getId;
}