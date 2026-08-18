<?php

require_once dirname(__DIR__) . '/app/helper/filter.php';
require_once dirname(__DIR__) . '/app/helper/verify.php';

function assertSameValue(mixed $expected, mixed $actual, string $message): void
{
    if ($expected === $actual) {
        return;
    }

    fwrite(
        STDERR,
        $message . PHP_EOL
        . 'Expected: ' . var_export($expected, true) . PHP_EOL
        . 'Actual:   ' . var_export($actual, true) . PHP_EOL
    );
    exit(1);
}

function assertTrueValue(bool $actual, string $message): void
{
    assertSameValue(true, $actual, $message);
}

function assertFalseValue(bool $actual, string $message): void
{
    assertSameValue(false, $actual, $message);
}

$normalized = normalizeFilterRequest([
    'category' => ' Laptop ',
    'color' => ['Black'],
    'weight' => '',
    'unexpected' => 'ignored',
]);

assertSameValue(
    ['category' => 'Laptop'],
    $normalized,
    'Only scalar, non-empty allowlisted filters must be accepted.'
);

$session = [
    'category' => 'Laptop',
    'color' => 'Black',
    'unrelated' => 'keep',
];

applyFiltersToSession($session, [
    'category' => 'all',
    'weight' => '5kg',
]);

assertSameValue(
    [
        'color' => 'Black',
        'unrelated' => 'keep',
        'weight' => '5kg',
    ],
    $session,
    'The all sentinel must clear only the selected filter.'
);

[$sql, $params] = buildProductFilterQuery([
    'category' => "Laptop' OR 1=1 --",
    'weight' => '5kg',
    'unexpected' => 'ignored',
]);

assertSameValue(
    'SELECT * FROM products WHERE category = :category AND weight = :weight',
    $sql,
    'SQL must contain only allowlisted identifiers and placeholders.'
);

assertSameValue(
    [
        'category' => "Laptop' OR 1=1 --",
        'weight' => '5kg',
    ],
    $params,
    'User values must stay in the parameter array instead of SQL text.'
);

[$sqlWithoutFilters, $paramsWithoutFilters] = buildProductFilterQuery([
    'unexpected' => 'ignored',
]);

assertSameValue(
    'SELECT * FROM products',
    $sqlWithoutFilters,
    'No WHERE clause must be emitted when no supported filters are active.'
);
assertSameValue([], $paramsWithoutFilters, 'No parameters are expected without filters.');

assertTrueValue(checkController('main'), 'A simple controller name must be accepted.');
assertTrueValue(checkController('front_page'), 'Underscores in controller names must be accepted.');
assertFalseValue(checkController('../main'), 'Path traversal must not be accepted as a controller.');
assertFalseValue(checkController('main.php'), 'File extensions must not be accepted as a controller.');

assertSameValue(
    '&lt;script&gt;&quot;&amp;',
    escapeHtml('<script>"&'),
    'HTML output must escape markup and quotes.'
);

fwrite(STDOUT, "Filter regression tests passed.\n");
