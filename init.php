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
