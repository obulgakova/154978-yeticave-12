<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if (!file_exists('config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}
$config = require 'config.php';
require 'helpers.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['dbname'], $config['db']['port']);
$db->set_charset($config['db']['charset']);
