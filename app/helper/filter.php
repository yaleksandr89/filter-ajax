<?php

function filterAllowedKeys(): array
{
    return ['category', 'color', 'weight'];
}

function normalizeFilterRequest(array $query): array
{
    $filters = [];

    foreach (filterAllowedKeys() as $key) {
        if (!array_key_exists($key, $query) || !is_string($query[$key])) {
            continue;
        }

        $value = trim($query[$key]);
        if ($value === '') {
            continue;
        }

        $filters[$key] = $value;
    }

    return $filters;
}

function applyFiltersToSession(array &$session, array $filters): void
{
    $allowedKeys = array_flip(filterAllowedKeys());

    foreach ($filters as $key => $value) {
        if (!isset($allowedKeys[$key]) || !is_string($value)) {
            continue;
        }

        if ($value === 'all') {
            unset($session[$key]);
            continue;
        }

        $session[$key] = $value;
    }
}

function buildProductFilterQuery(array $session): array
{
    $clauses = [];
    $params = [];

    foreach (filterAllowedKeys() as $key) {
        if (!isset($session[$key]) || !is_string($session[$key])) {
            continue;
        }

        $value = trim($session[$key]);
        if ($value === '' || $value === 'all') {
            continue;
        }

        $clauses[] = "$key = :$key";
        $params[$key] = $value;
    }

    $sql = 'SELECT * FROM products';
    if ($clauses !== []) {
        $sql .= ' WHERE ' . implode(' AND ', $clauses);
    }

    return [$sql, $params];
}

function escapeHtml(mixed $value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}
