<?php

/**
 * @var \App\View\ViewRenderer $this
 * @var list<array{category: string, title: string, color: string, weight: string}> $products
 */

if ($products === []):
?>
    <div class="col-12 text-center">
        <div class="alert alert-warning" role="alert">
            <span>According to the filter, no products were found.</span>
        </div>
    </div>
<?php endif; ?>

<?php foreach ($products as $product): ?>
    <div class="col-sm-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title animate-txt">
                    <?= $this->escape($product['category']) ?> • <?= $this->escape($product['title']) ?>
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <code>Цвет:</code> <?= $this->escape($product['color']) ?>
                    </li>
                    <li class="list-group-item">
                        <code>Вес:</code> <?= $this->escape($product['weight']) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach; ?>
