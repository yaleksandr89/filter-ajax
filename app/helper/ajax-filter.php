<?php

unset($_GET['get_tpl']);

if (count($_GET) > 0) {
    require_once(PATH_ROOT . '/app/models/database.php');

    $filters = $_GET ?? [];

    foreach ($filters as $key => $value) {
        $currentKey = $key;
        $currentValue = $value;
    }

    if (isset($currentKey, $currentValue)) {
        $_SESSION[$currentKey] = $currentValue;
    }
}

$filterQuery = 'SELECT * FROM products WHERE';
foreach ($_SESSION as $key => $value) {
    if ($value !== 'all') {
        $filterQuery .= " $key='$value' AND";
    }
}

$filterQuery = trim($filterQuery, ' AND');
$filterQuery = trim($filterQuery, ' WHERE');

$productsResult = db_query($filterQuery)->fetchAll();
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
                    <?= $product['category'] . ' • ' . $product['title'] ?>
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <code>Цвет:</code> <?= $product['color'] ?>
                    </li>
                    <li class="list-group-item">
                        <code>Вес:</code> <?= $product['weight'] ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach; ?>
