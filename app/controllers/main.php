<?php
// Controllers
require_once(PATH_ROOT . '/app/models/database.php');
require_once(PATH_ROOT . '/app/helper/check-selected.php');

// Unloading all data from the table 'products'
$products = db_query('SELECT * FROM products')->fetchAll();

// Unloading all data from the table 'categories'
$categories = db_query('SELECT * FROM categories')->fetchAll();

// Unloading all data from the table 'colors'
$colors = db_query('SELECT * FROM colors')->fetchAll();

// Unloading all data from the table 'weights'
$weights = db_query('SELECT * FROM weights')->fetchAll();

// Connect title
$title = 'Ajax filter';

$navigationMenu = viewsConnect('front-page/menu.php');

// Connect data field
$data = viewsConnect('front-page/list.php', [
    'products' => $products,
    'categories' => $categories,
    'colors' => $colors,
    'weights' => $weights,
]);
