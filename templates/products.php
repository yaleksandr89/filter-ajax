<?php

/**
 * @var \App\View\ViewRenderer $this
 * @var list<array{category: string, title: string, color: string, weight: string}> $products
 */

if ($products === []):
?>
    <div class="no-results" role="status">
        <span class="no-results__mark" aria-hidden="true">0</span>
        <div>
            <h2>No matching products</h2>
            <p>Try another filter value to broaden the results.</p>
        </div>
    </div>
<?php endif; ?>

<?php foreach ($products as $product): ?>
    <article class="product-card">
        <div class="product-card__heading">
            <p class="product-card__category"><?= $this->escape($product['category']) ?></p>
            <h2><?= $this->escape($product['title']) ?></h2>
        </div>
        <dl class="product-card__details">
            <div>
                <dt>Цвет</dt>
                <dd><?= $this->escape($product['color']) ?></dd>
            </div>
            <div>
                <dt>Вес</dt>
                <dd><?= $this->escape($product['weight']) ?></dd>
            </div>
        </dl>
    </article>
<?php endforeach; ?>
