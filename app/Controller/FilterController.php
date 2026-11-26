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
    ) {}

    /**
     * RU: Исключение возникает при ошибке фильтрации, работы с данными или вывода шаблона.
     * EN: An exception is thrown when filtering, persistence, or template rendering fails.
     *
     * @param array<string, mixed> $query
     * @param array<string, mixed> $session
     * @throws Throwable
     */
    public function filter(array $query, array &$session): string
    {
        $this->filter->apply($session, $this->filter->normalize($query));
        $products = $this->repository->products($this->filter->activeCriteria($session));

        return $this->renderer->render('products', ['products' => $products]);
    }
}
