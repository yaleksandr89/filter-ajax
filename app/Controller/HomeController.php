<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\ProductRepository;
use App\Filter\ProductFilter;
use App\View\ViewRenderer;
use Throwable;

final readonly class HomeController
{
    public function __construct(
        private ProductRepository $repository,
        private ProductFilter $filter,
        private ViewRenderer $renderer,
    ) {
    }

    /**
     * @param array<string, mixed> $session
     * @throws Throwable When persistence or template rendering fails.
     */
    public function index(array $session): string
    {
        $activeFilters = $this->filter->activeCriteria($session);
        $products = $this->repository->products($activeFilters);
        $productsHtml = $this->renderer->render('products', ['products' => $products]);
        $content = $this->renderer->render('home', [
            'categories' => $this->repository->categories(),
            'colors' => $this->repository->colors(),
            'weights' => $this->repository->weights(),
            'activeFilters' => $activeFilters,
            'productsHtml' => $productsHtml,
        ]);

        return $this->renderer->render('layout', [
            'title' => 'Ajax filter',
            'content' => $content,
        ]);
    }
}
