<?php

if (!file_exists('config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}
$config = require 'config.php';
require_once('helpers.php');

$db_host = $config['db']['host'];
$db_username = $config['db']['username'];
$db_password = $config['db']['password'];
$db_database = $config['db']['dbname'];
$db_port = $config['db']['port'];
$db_charset = $config['db']['charset'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);
$db->set_charset($db_charset);


$sql = 'SELECT * FROM categories';
$result = $db->query($sql);
$nav_list = $result->fetch_all(MYSQLI_ASSOC);

$sql = 'SELECT l.title,
       l.price_add,
       img,
       dt_finish,
       (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) current_price,
       c.title                                                      category_title
FROM lots l 
         JOIN categories c ON l.category_id = c.id
WHERE dt_finish > NOW()
ORDER BY dt_add DESC';
$result = $db->query($sql);
$lots_list = $result->fetch_all(MYSQLI_ASSOC);



$is_auth = rand(0, 1);
$user_name = 'Оксана';

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
