<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if (!file_exists('config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}
$config = require 'config.php';
require 'helpers.php';
require 'vendor/autoload.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['dbname'], $config['db']['port']);
$db->set_charset($config['db']['charset']);

$sql = 'SELECT * FROM categories';
$result = $db->query($sql);
$nav_list = $result->fetch_all(MYSQLI_ASSOC);


$email_transport = new Swift_SmtpTransport($config['email_transport']['host'], $config['email_transport']['port'], $config['email_transport']['encryption']);
$email_transport->setUsername($config['email_transport']['username']);
$email_transport->setPassword($config['email_transport']['password']);

