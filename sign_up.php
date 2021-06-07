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
        'password',
        'name',
        'message'
    ];

    $rules = [
        'email' => function ($value) use ($db) {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return $errors['email'] = "Введите корректный email";
            } else {
                $sql = 'SELECT id
                FROM users 
                WHERE email = ?';

                $stmt = $db->prepare($sql);
                $stmt->bind_param('s', $value);
                $stmt->execute();
                $result = $stmt->get_result();
                $user_id = $result->fetch_assoc();

                if ($user_id > 0) {
                    return $errors['email'] = "Пользователь с этим email уже зарегистрирован";
                }
            }
        }

    ];

    foreach ($form as $key => $value) {
        if (in_array($key, $required_fields) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        } elseif (isset($rules[$key])) {
            $rule = $rules[$key];
            $validationResult = $rule($value);
            if ($validationResult) {
                $errors[$key] = $validationResult;
            }
        }
    }

    if (!$errors) {
        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (dt_reg, email, password, name, message) VALUES (NOW(), ?, ?, ?, ?)';

        $stmt = $db->prepare($sql);
        $stmt->bind_param('ssss', $form['email'], $password, $form['name'], $form['message']);
        $stmt->execute();

        header("Location: /login.php");
        die();
    }

}


$sign_up_tpl = include_template('sign_up.tpl.php', [
    'errors' => $errors
]);

$layout_content = include_template('layout.tpl.php', [
    'content' => $sign_up_tpl,
    'nav_list' => $nav_list,
    'title' => 'Регистрация'
]);

echo $layout_content;
