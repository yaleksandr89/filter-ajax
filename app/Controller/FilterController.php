<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\ProductRepository;
use App\Filter\ProductFilter;
use App\View\ViewRenderer;
use Throwable;

final readonly class FilterController
{
    public function __construct(
        private ProductRepository $repository,
        private ProductFilter $filter,
        private ViewRenderer $renderer,
    ) {
    }

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $session
     * @throws Throwable When filtering, persistence, or template rendering fails.
     */
    public function filter(array $query, array &$session): string
    {
        $this->filter->apply($session, $this->filter->normalize($query));
        $products = $this->repository->products($this->filter->activeCriteria($session));

        return $this->renderer->render('products', ['products' => $products]);
    }
}
