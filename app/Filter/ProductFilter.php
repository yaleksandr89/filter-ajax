<?php

declare(strict_types=1);

namespace App\Filter;

final class ProductFilter
{
    private const array ALLOWED_KEYS = ['category', 'color', 'weight'];

    /**
     * @return array<string, string>
     */
    public function normalize(array $query): array
    {
        $filters = [];

        foreach (self::ALLOWED_KEYS as $key) {
            if (!array_key_exists($key, $query) || !is_scalar($query[$key])) {
                continue;
            }

            $value = trim((string) $query[$key]);
            if ($value !== '') {
                $filters[$key] = $value;
            }
        }

        return $filters;
    }

    /**
     * @param array<string, mixed> $session
     * @param array<string, mixed> $filters
     */
    public function apply(array &$session, array $filters): void
    {
        foreach (self::ALLOWED_KEYS as $key) {
            if (!array_key_exists($key, $filters) || !is_string($filters[$key])) {
                continue;
            }

            if ($filters[$key] === 'all') {
                unset($session[$key]);
                continue;
            }

            if ($filters[$key] !== '') {
                $session[$key] = $filters[$key];
            }
        }
    }

    /**
     * @param array<string, mixed> $session
     * @return array<string, string>
     */
    public function activeCriteria(array $session): array
    {
        $criteria = [];

        foreach (self::ALLOWED_KEYS as $key) {
            if (!isset($session[$key]) || !is_scalar($session[$key])) {
                continue;
            }

            $value = trim((string) $session[$key]);
            if ($value !== '' && $value !== 'all') {
                $criteria[$key] = $value;
            }
        }

        return $criteria;
    }
}
