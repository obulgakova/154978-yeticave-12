<?php
require 'init.php';

$errors = [];

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required_fields = [
        'email',
        'password',
        'name',
        'message'
    ];

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Введите коректный email";
    } else {
        $email = mysqli_real_escape_string($db, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($db, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = "Такой email уже существует";
        };
    }

    foreach ($form as $key => $value) {
        if (in_array($key, $required_fields) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        };
    };

    if (empty($errors)) {
        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (dt_reg, email, password, name, message) VALUES (NOW(), ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($db, $sql, $form);
        mysqli_stmt_execute($stmt);

        header("Location: /index.php");
        die();
    };
};


$sign_up_tpl = include_template('sign_up.tpl.php', [
    'errors' => $errors
]);

$layout_content = include_template('layout.tpl.php', [
    'content' => $sign_up_tpl,
    'nav_list' => $nav_list,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Регистрация'
]);

echo $layout_content;
