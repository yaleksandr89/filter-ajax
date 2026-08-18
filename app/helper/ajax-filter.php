<?php

unset($_GET['get_tpl']);

require_once(PATH_ROOT . '/app/models/database.php');

if ($_GET !== []) {
    $filters = normalizeFilterRequest($_GET);
    applyFiltersToSession($_SESSION, $filters);
}

[$filterQuery, $filterParams] = buildProductFilterQuery($_SESSION);
$productsResult = db_query($filterQuery, $filterParams)->fetchAll();
$infoBlock = 'According to the filter, no products were found.';
?>

<?php if (!$productsResult) : ?>
    <div class="col-12 text-center">
        <div class="alert alert-warning" role="alert">
            <?= '<span>' . $infoBlock . '</span>' ?>
        </div>
    </div>
<?php endif; ?>

<?php foreach ($productsResult as $product): ?>
    <div class="col-sm-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title animate-txt">
                    <?= escapeHtml($product['category']) . ' • ' . escapeHtml($product['title']) ?>
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <code>Цвет:</code> <?= escapeHtml($product['color']) ?>
                    </li>
                    <li class="list-group-item">
                        <code>Вес:</code> <?= escapeHtml($product['weight']) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach; ?>
