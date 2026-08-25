<?php

/**
 * @var \App\View\ViewRenderer $this
 * @var list<array{category: string}> $categories
 * @var list<array{color: string}> $colors
 * @var list<array{weight: string}> $weights
 * @var array<string, string> $activeFilters
 * @var string $productsHtml Trusted, already-rendered product-list HTML.
 */
?>
<div class="row mb-3">
    <a
        href="https://github.com/yaleksandr89/filter-ajax"
        target="_blank"
        rel="nofollow noopener"
        class="link-underline-warning font-monospace display-6 animate-txt"
    >
        Source code(GitHub)
    </a>
</div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="form-group">
            <label for="categories"><code>Category</code></label>
            <select id="categories" class="form-control outline-customize" name="category">
                <option value="all" <?= isset($activeFilters['category']) ? '' : 'selected' ?>>All category</option>
                <?php foreach ($categories as $category): ?>
                    <?php $categoryValue = $category['category']; ?>
                    <option
                        value="<?= $this->escape($categoryValue) ?>"
                        <?= ($activeFilters['category'] ?? null) === $categoryValue ? 'selected' : '' ?>
                    >
                        <?= $this->escape($categoryValue) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="colors"><code>Colors</code></label>
            <select id="colors" class="form-control outline-customize" name="color">
                <option value="all" <?= isset($activeFilters['color']) ? '' : 'selected' ?>>All category</option>
                <?php foreach ($colors as $color): ?>
                    <?php $colorValue = $color['color']; ?>
                    <option
                        value="<?= $this->escape($colorValue) ?>"
                        <?= ($activeFilters['color'] ?? null) === $colorValue ? 'selected' : '' ?>
                    >
                        <?= $this->escape($colorValue) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="weights"><code>Weight</code></label>
            <select id="weights" class="form-control outline-customize" name="weight">
                <option value="all" <?= isset($activeFilters['weight']) ? '' : 'selected' ?>>All weight</option>
                <?php foreach ($weights as $weight): ?>
                    <?php $weightValue = $weight['weight']; ?>
                    <option
                        value="<?= $this->escape($weightValue) ?>"
                        <?= ($activeFilters['weight'] ?? null) === $weightValue ? 'selected' : '' ?>
                    >
                        <?= $this->escape($weightValue) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="row" data-filters-block>
    <?= $productsHtml ?>
</div>
