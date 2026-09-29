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
            <p class="eyebrow" data-i18n="refineEyebrow">Настройте выдачу</p>
            <h2 id="filter-title" data-i18n="filterTitle">Фильтр товаров</h2>
        </div>
        <div class="filter-panel__meta">
            <p data-i18n="filterHint">Каждое изменение автоматически обновляет результаты.</p>
            <button
                class="reset-button"
                type="button"
                data-filter-reset
                aria-controls="product-results"
                <?= $activeFilters === [] ? 'disabled' : '' ?>
            >
                <span class="reset-button__icon" aria-hidden="true">↺</span>
                <span data-i18n="resetFilters">Сбросить</span>
            </button>
        </div>
    </div>

    <div class="filter-grid">
        <div class="filter-field">
            <label for="categories" data-i18n="category">Категория</label>
            <div class="select-wrap">
                <select id="categories" name="category">
                    <option value="all" <?= isset($activeFilters['category']) ? '' : 'selected' ?> data-i18n="allCategories">Все категории</option>
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
            <label for="colors" data-i18n="color">Цвет</label>
            <div class="select-wrap">
                <select id="colors" name="color">
                    <option value="all" <?= isset($activeFilters['color']) ? '' : 'selected' ?> data-i18n="allColors">Все цвета</option>
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
            <label for="weights" data-i18n="weight">Вес</label>
            <div class="select-wrap">
                <select id="weights" name="weight">
                    <option value="all" <?= isset($activeFilters['weight']) ? '' : 'selected' ?> data-i18n="allWeights">Любой вес</option>
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

<section
    id="product-results"
    class="product-grid"
    data-filters-block
    aria-label="Результаты фильтрации"
    data-i18n-aria-label="productResults"
    aria-live="polite"
>
    <?= $productsHtml ?>
</section>
