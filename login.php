<?php
require 'init.php';

if (isset($_SESSION['user'])) {
    http_response_code(403);
    die();
}

$errors = [];

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required_fields = [
        'email',
        'password'
    ];

    $rules = [
        'email' => function ($value) {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return $errors['email'] = "Введите коректный email";
            }
        }
    ];

    $errors = form_validation($form, $rules, $required_fields);

    $sql = 'SELECT *
            FROM users
            WHERE email = ?';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $form['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$errors and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /index.php");
            die();

        } else {
            $errors['password'] = 'Вы ввели неверный пароль';
        }
    } else if (!$errors and !$user) {
        $errors['email'] = 'Такой пользователь не найден';
    }
}


$login_tpl = include_template('login.tpl.php', [
    'errors' => $errors
]);

$layout_content = include_template('layout.tpl.php', [
    'content' => $login_tpl,
    'nav_list' => $nav_list,
    'title' => 'Вход'
]);

echo $layout_content;
