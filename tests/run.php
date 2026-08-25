<?php

declare(strict_types=1);

use App\Database\DatabaseConfig;
use App\Database\ProductQueryBuilder;
use App\Filter\ProductFilter;
use App\View\ViewRenderer;

require dirname(__DIR__) . '/app/bootstrap.php';

$assertionCount = 0;

function assertSameValue(mixed $expected, mixed $actual, string $message): void
{
    global $assertionCount;
    $assertionCount++;

    if ($expected === $actual) {
        return;
    }

    fwrite(
        STDERR,
        $message . PHP_EOL
        . 'Expected: ' . var_export($expected, true) . PHP_EOL
        . 'Actual:   ' . var_export($actual, true) . PHP_EOL,
    );
    exit(1);
}

function assertThrows(string $exceptionClass, callable $callback, string $message): void
{
    global $assertionCount;
    $assertionCount++;

    try {
        $callback();
    } catch (Throwable $exception) {
        if ($exception instanceof $exceptionClass) {
            return;
        }

        fwrite(STDERR, $message . PHP_EOL . 'Unexpected exception: ' . $exception::class . PHP_EOL);
        exit(1);
    }

    fwrite(STDERR, $message . PHP_EOL . 'No exception was thrown.' . PHP_EOL);
    exit(1);
}

function writeTemporaryDatabaseConfig(string $path, array $values): void
{
    $source = "<?php\n\ndeclare(strict_types=1);\n\nreturn " . var_export($values, true) . ";\n";

    if (file_put_contents($path, $source) === false) {
        throw new RuntimeException('Unable to write a temporary database configuration.');
    }
}

$filter = new ProductFilter();
$queryBuilder = new ProductQueryBuilder();
$renderer = new ViewRenderer(dirname(__DIR__) . '/templates');

assertSameValue(
    ['category' => 'Laptop'],
    $filter->normalize([
        'category' => ' Laptop ',
        'color' => ['Black'],
        'weight' => '   ',
        'unexpected' => 'ignored',
    ]),
    'Only scalar, non-empty allowlisted filters must survive normalization.',
);

assertSameValue(
    ['weight' => '5'],
    $filter->normalize(['weight' => 5]),
    'Supported scalar filter values must be normalized to strings.',
);

$session = [
    'category' => 'Laptop',
    'color' => 'Black',
    'unrelated' => 'keep',
];

$filter->apply($session, [
    'category' => 'all',
    'weight' => '5kg',
    'unexpected' => 'ignored',
]);

assertSameValue(
    [
        'color' => 'Black',
        'unrelated' => 'keep',
        'weight' => '5kg',
    ],
    $session,
    'The all sentinel must clear only the selected filter and preserve unrelated session data.',
);

assertSameValue(
    [
        'color' => 'Black',
        'weight' => '5kg',
    ],
    $filter->activeCriteria($session),
    'Active criteria must contain only normalized supported session filters.',
);

[$sql, $parameters] = $queryBuilder->build([
    'category' => "Laptop' OR 1=1 --",
    'weight' => '5kg',
    'unexpected' => 'ignored',
]);

assertSameValue(
    'SELECT category, title, color, weight FROM products WHERE category = :category AND weight = :weight ORDER BY id_product',
    $sql,
    'SQL must contain only approved identifiers and placeholders.',
);

assertSameValue(
    [
        'category' => "Laptop' OR 1=1 --",
        'weight' => '5kg',
    ],
    $parameters,
    'User values must remain in the parameter array.',
);

[$sqlWithoutCriteria, $parametersWithoutCriteria] = $queryBuilder->build([
    'unexpected' => 'ignored',
]);

assertSameValue(
    'SELECT category, title, color, weight FROM products ORDER BY id_product',
    $sqlWithoutCriteria,
    'No WHERE clause must be emitted without approved criteria.',
);
assertSameValue([], $parametersWithoutCriteria, 'No parameters are expected without criteria.');

$environmentKeys = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_CHARSET'];
$originalEnvironment = [];
foreach ($environmentKeys as $environmentKey) {
    $originalEnvironment[$environmentKey] = getenv($environmentKey);
    putenv($environmentKey);
}

$temporaryDirectory = sys_get_temp_dir() . '/filter-ajax-config-' . bin2hex(random_bytes(8));
if (!mkdir($temporaryDirectory, 0700)) {
    throw new RuntimeException('Unable to create a temporary database configuration directory.');
}

$localConfigFile = $temporaryDirectory . '/database.php';
$unsupportedConfigFile = $temporaryDirectory . '/unsupported.php';
$invalidPortConfigFile = $temporaryDirectory . '/invalid-port.php';

try {
    writeTemporaryDatabaseConfig($localConfigFile, [
        'host' => 'local-host',
        'port' => 3307,
        'name' => 'local-name',
        'user' => 'local-user',
        'password' => 'local-password',
        'charset' => 'utf8mb4',
    ]);

    $localConfig = DatabaseConfig::load($localConfigFile);
    assertSameValue(
        ['local-host', 3307, 'local-name', 'local-user', 'local-password', 'utf8mb4'],
        [$localConfig->host(), $localConfig->port(), $localConfig->name(), $localConfig->user(), $localConfig->password(), $localConfig->charset()],
        'A complete local database configuration must load successfully.',
    );

    $environmentValues = [
        'DB_HOST' => 'environment-host',
        'DB_PORT' => '3308',
        'DB_NAME' => 'environment-name',
        'DB_USER' => 'environment-user',
        'DB_PASSWORD' => 'environment-password',
        'DB_CHARSET' => 'utf8mb4',
    ];
    foreach ($environmentValues as $environmentKey => $environmentValue) {
        putenv($environmentKey . '=' . $environmentValue);
    }

    $overriddenConfig = DatabaseConfig::load($localConfigFile);
    assertSameValue(
        ['environment-host', 3308, 'environment-name', 'environment-user', 'environment-password', 'utf8mb4'],
        [$overriddenConfig->host(), $overriddenConfig->port(), $overriddenConfig->name(), $overriddenConfig->user(), $overriddenConfig->password(), $overriddenConfig->charset()],
        'Environment database configuration must override local-file values.',
    );

    $environmentOnlyConfig = DatabaseConfig::load($temporaryDirectory . '/missing.php');
    assertSameValue(
        ['environment-host', 3308, 'environment-name', 'environment-user', 'environment-password', 'utf8mb4'],
        [$environmentOnlyConfig->host(), $environmentOnlyConfig->port(), $environmentOnlyConfig->name(), $environmentOnlyConfig->user(), $environmentOnlyConfig->password(), $environmentOnlyConfig->charset()],
        'Environment-only database configuration must work without a local file.',
    );

    foreach ($environmentKeys as $environmentKey) {
        putenv($environmentKey);
    }

    writeTemporaryDatabaseConfig($unsupportedConfigFile, [
        'host' => 'local-host',
        'port' => 3307,
        'name' => 'local-name',
        'user' => 'local-user',
        'password' => 'local-password',
        'charset' => 'utf8mb4',
        'unsupported' => 'value',
    ]);
    assertThrows(
        RuntimeException::class,
        static fn (): DatabaseConfig => DatabaseConfig::load($unsupportedConfigFile),
        'Unsupported local database configuration keys must fail explicitly.',
    );

    writeTemporaryDatabaseConfig($invalidPortConfigFile, [
        'host' => 'local-host',
        'port' => 0,
        'name' => 'local-name',
        'user' => 'local-user',
        'password' => 'local-password',
        'charset' => 'utf8mb4',
    ]);
    assertThrows(
        RuntimeException::class,
        static fn (): DatabaseConfig => DatabaseConfig::load($invalidPortConfigFile),
        'Invalid database ports must fail explicitly.',
    );
} finally {
    foreach ($originalEnvironment as $environmentKey => $environmentValue) {
        putenv($environmentValue === false ? $environmentKey : $environmentKey . '=' . $environmentValue);
    }

    foreach ([$localConfigFile, $unsupportedConfigFile, $invalidPortConfigFile] as $temporaryFile) {
        if (is_file($temporaryFile)) {
            unlink($temporaryFile);
        }
    }
    rmdir($temporaryDirectory);
}

assertSameValue(
    '&lt;script&gt;&quot;&#039;&amp;',
    $renderer->escape('<script>"\'&'),
    'HTML special characters and both quote styles must be escaped.',
);

assertSameValue(
    true,
    class_exists(ProductFilter::class)
        && class_exists(ProductQueryBuilder::class)
        && class_exists(ViewRenderer::class),
    'Production classes must resolve through the native App autoloader.',
);

fwrite(STDOUT, sprintf("Application regression tests passed (%d checks).\n", $assertionCount));
