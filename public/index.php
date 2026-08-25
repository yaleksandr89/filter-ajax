<?php

declare(strict_types=1);

use App\Controller\FilterController;
use App\Controller\HomeController;
use App\Database\ConnectionFactory;
use App\Database\DatabaseConfig;
use App\Database\ProductQueryBuilder;
use App\Database\ProductRepository;
use App\Filter\ProductFilter;
use App\View\ViewRenderer;

$projectRoot = require dirname(__DIR__) . '/app/bootstrap.php';

date_default_timezone_set('Europe/Moscow');
ini_set('display_errors', '0');

try {
    if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
        throw new RuntimeException('The application session could not be started.');
    }

    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if (!is_string($requestPath) || !in_array($requestPath, ['/', '/ajax-filter'], true)) {
        http_response_code(404);
        header('Content-Type: text/html; charset=UTF-8');
        header('Refresh: 10; url=/');

        require __DIR__ . '/assets/404/index.php';
        exit;
    }

    $config = DatabaseConfig::load($projectRoot . '/config/database.php');
    $pdo = new ConnectionFactory($config)->create();
    $queryBuilder = new ProductQueryBuilder();
    $repository = new ProductRepository($pdo, $queryBuilder);
    $filter = new ProductFilter();
    $renderer = new ViewRenderer($projectRoot . '/templates');
    $homeController = new HomeController($repository, $filter, $renderer);
    $filterController = new FilterController($repository, $filter, $renderer);

    header('Content-Type: text/html; charset=UTF-8');

    if ($requestPath === '/ajax-filter') {
        echo $filterController->filter($_GET, $_SESSION);
        exit;
    }

    echo $homeController->index($_SESSION);
} catch (Throwable $exception) {
    error_log(sprintf(
        'Unhandled %s in %s:%d: %s',
        $exception::class,
        $exception->getFile(),
        $exception->getLine(),
        $exception->getMessage(),
    ));

    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
    }

    echo 'Technical troubles in the site. Soon all fix.';
}
