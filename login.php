<?php
require 'init.php';

$errors = [];

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required_fields = [
        'email',
        'password'
    ];

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Введите коректный email";
    } else {
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
            };
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        };
    };

    foreach ($form as $key => $value) {
        if (in_array($key, $required_fields) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        };
    };
};


$login_tpl = include_template('login.tpl.php', [
    'errors' => $errors
]);
if (isset($_SESSION['user'])) {
    header("Location: /index.php");
    die();
}

$layout_content = include_template('layout.tpl.php', [
    'content' => $login_tpl,
    'nav_list' => $nav_list,
    'title' => 'Вход'
]);

echo $layout_content;
