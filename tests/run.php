<?php

declare(strict_types=1);

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
    'SELECT * FROM products WHERE category = :category AND weight = :weight',
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
    'SELECT * FROM products',
    $sqlWithoutCriteria,
    'No WHERE clause must be emitted without approved criteria.',
);
assertSameValue([], $parametersWithoutCriteria, 'No parameters are expected without criteria.');

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
