<?php

require_once('helpers.php');


$is_auth = rand(0, 1);

$user_name = 'Оксана';

$nav_list = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

$lots_list = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'url' => 'img/lot-1.jpg',
        'date_remaining' => '2021-04-09 16:30:00'
    ], [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'url' => 'img/lot-2.jpg',
        'date_remaining' => '2021-04-11'
    ], [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'url' => 'img/lot-3.jpg',
        'date_remaining' => '2021-04-12'
    ], [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'url' => 'img/lot-4.jpg',
        'date_remaining' => '2021-04-13'
    ], [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'url' => 'img/lot-5.jpg',
        'date_remaining' => '2021-04-14'
    ], [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'url' => 'img/lot-6.jpg',
        'date_remaining' => '2021-04-15'
    ]
];
['a', 'b'];

$main_content = include_template('main.php', [
    'nav_list' => $nav_list,
    'lots_list' => $lots_list
]);
$layout_content = include_template('layout.php', [
    'nav_list' => $nav_list,
    'content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Главная'
]);

echo $layout_content;

?>
