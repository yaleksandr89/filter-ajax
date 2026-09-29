<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

final readonly class ProductRepository
{
    public function __construct(
        private PDO $pdo,
        private ProductQueryBuilder $queryBuilder,
    ) {
    }

    /**
     * @param array<string, string> $criteria
     * @return list<array{category: string, title: string, color: string, weight: string}>
     */
    public function products(array $criteria): array
    {
        [$sql, $parameters] = $this->queryBuilder->build($criteria);
        $statement = $this->pdo->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchAll();
    }

    /**
     * @return list<array{category: string}>
     */
    public function categories(): array
    {
        return $this->pdo->query('SELECT category FROM categories ORDER BY id_category')->fetchAll();
    }

    /**
     * @return list<array{color: string}>
     */
    public function colors(): array
    {
        return $this->pdo->query('SELECT color FROM colors ORDER BY id_color')->fetchAll();
    }

    /**
     * @return list<array{weight: string}>
     */
    public function weights(): array
    {
        return $this->pdo->query('SELECT weight FROM weights ORDER BY id_weight')->fetchAll();
    }
}
