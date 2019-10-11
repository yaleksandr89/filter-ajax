<?php
// Controllers
require_once('app/models/database.php');
require_once('app/helper/check-selected.php');

// Unloading all data from the table 'products'
$products = db_query('SELECT id_product,category,title,color,weight FROM products')->fetchAll();

// Unloading all data from the table 'categories'
$categories = db_query('SELECT id_category,category FROM categories')->fetchAll();

// Unloading all data from the table 'colors'
$colors = db_query('SELECT id_color,color FROM colors')->fetchAll();

// Unloading all data from the table 'weights'
$weights = db_query('SELECT id_weight,weight FROM weights')->fetchAll();

// Connect title
$title = 'Ajax filter';

$navigationMenu = viewsConnect('front-page/menu.php');

// Connect data field
$ajaxFilter = viewsConnect('front-page/list.php', [
    'products' => $products,
    'categories' => $categories,
    'colors' => $colors,
    'weights' => $weights,
]);