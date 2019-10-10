<?php
function db_connect()
{
    $db_host = 'localhost';
    $db_name = 'ajax_filter';
    $db_charset = 'utf8';
    $db_user = 'root';
    $db_password = 'buLDog89!';
    static $pdh;
    if ($pdh === null) {
        $dns = sprintf('mysql:host=%s;dbname=%s;charset=%s', $db_host, $db_name, $db_charset);
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdh = new PDO($dns, $db_user, $db_password, $options);
        } catch (PDOException $exception) {
            echo 'Technical troubles in the site. Soon all fix.';
            file_put_contents(__DIR__ . '/../../logs/Errors_system.txt', date('Y-m-d H:i:s') . ': ' . $exception->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }
    return $pdh;
}

// Request processing
function db_query(string $sql_query, array $params_execute = [])
{
    $pdh = db_connect();
    $sth = $pdh->prepare($sql_query);
    $verifiedParams = [];
    foreach ($params_execute as $placeholder => $item) {
        if (is_int($item)) {
            $sth->bindParam(count($params_execute), $placeholder, PDO::PARAM_INT);
            $verifiedParams[] = $item;
        } elseif (is_string($item)) {
            $sth->bindParam(count($params_execute), $placeholder, PDO::PARAM_STR);
            $verifiedParams[] = $item;
        }
    }
    try {
        $sth->execute($verifiedParams);
    } catch (PDOException $exception){
        echo 'Technical troubles in the site. Soon all fix.';
        file_put_contents(__DIR__ . '/../../logs/Errors_system.txt', date('Y-m-d H:i:s') . ': ' . $exception->getMessage() . PHP_EOL, FILE_APPEND);
    }
    return $sth;
}