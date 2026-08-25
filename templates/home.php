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
<section class="filter-panel" aria-labelledby="filter-title">
    <div class="filter-panel__heading">
        <div>
            <p class="eyebrow">Refine results</p>
            <h2 id="filter-title">Filter products</h2>
        </div>
        <p>Each selection updates the results automatically.</p>
    </div>

    <div class="filter-grid">
        <div class="filter-field">
            <label for="categories">Category</label>
            <div class="select-wrap">
                <select id="categories" name="category">
                    <option value="all" <?= isset($activeFilters['category']) ? '' : 'selected' ?>>All categories</option>
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

        <div class="filter-field">
            <label for="colors">Color</label>
            <div class="select-wrap">
                <select id="colors" name="color">
                    <option value="all" <?= isset($activeFilters['color']) ? '' : 'selected' ?>>All colors</option>
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

        <div class="filter-field">
            <label for="weights">Weight</label>
            <div class="select-wrap">
                <select id="weights" name="weight">
                    <option value="all" <?= isset($activeFilters['weight']) ? '' : 'selected' ?>>All weights</option>
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
</section>

<section class="product-grid" data-filters-block aria-label="Product results" aria-live="polite">
    <?= $productsHtml ?>
</section>
