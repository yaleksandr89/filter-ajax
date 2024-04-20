<?php

unset($_GET['get_tpl']);

if (count($_GET) > 0) {
    session_start();
    require_once('../models/database.php');

    foreach ($_GET as $key => $value) {
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
        <div class="alert alert-warning pl-2 pr-2" role="alert">
            <?= '<span>' . $infoBlock . '</span>' ?>
        </div>
    </div>
<?php endif; ?>

<?php foreach ($productsResult as $product): ?>
    <div class="col-xl-3 col-md-4">
        <div class="card item_card">
            <h5 class="card-title text-center mt-2">
                <?= $product['category'] ?>
                <?= $product['title'] ?>
            </h5>
            <div class="card-body">
                <ul>
                    <li><strong>Цвет</strong>: <?= $product['color'] ?></li>
                    <li><strong>Вес</strong>: <?= $product['weight'] ?></li>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach;
