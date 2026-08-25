<?php

declare(strict_types=1);

namespace App\Database;

final class ProductQueryBuilder
{
    private const array ALLOWED_IDENTIFIERS = ['category', 'color', 'weight'];

    /**
     * @param array<string, mixed> $criteria
     * @return array{0: string, 1: array<string, scalar>}
     */
    public function build(array $criteria): array
    {
        $clauses = [];
        $parameters = [];

        foreach (self::ALLOWED_IDENTIFIERS as $identifier) {
            if (!array_key_exists($identifier, $criteria) || !is_scalar($criteria[$identifier])) {
                continue;
            }

            $clauses[] = sprintf('%s = :%s', $identifier, $identifier);
            $parameters[$identifier] = $criteria[$identifier];
        }

        $sql = 'SELECT * FROM products';
        if ($clauses !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $clauses);
        }

        return [$sql, $parameters];
    }
}
