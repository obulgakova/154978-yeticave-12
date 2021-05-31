<?php
require 'init.php';

$errors = [];

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

    if (!empty($_FILES['lot-img']['tmp_name'])) {
        $file_name = $_FILES['lot-img']['name'];
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;

        $file_type = strtolower(pathinfo($file_url, PATHINFO_EXTENSION));
        if (($file_type !== "jpeg") && ($file_type !== "jpg") && ($file_type !== "png")) {
            $errors['lot-img'] = 'Загрузите картинку в формате JPG, JPEG или PNG';
        }
    }


    $lot = [
        'lot-name' => $_POST['lot-name'],
        'category' => intval($_POST['category']),
        'message' => $_POST['message'],
        'lot-rate' => $_POST['lot-rate'],
        'lot-step' => intval($_POST['lot-step']),
        'lot-date' => $_POST['lot-date'],
        'lot-img' => isset($file_url) ? $file_url : null,
    ];

    $required_fields = [
        'lot-name',
        'category',
        'message',
        'lot-rate',
        'lot-step',
        'lot-date',
        'lot-img',
    ];
    $rules = [
        'lot-rate' => function ($value) {
            return validate_price($value);
        },
        'lot-date' => function ($value) {
            return validate_current_date($value);
        },
        'lot-step' => function ($value) {
            return validate_step_rate($value);
        },
        'category' => function ($value) {
            return validate_category_id($value);
        }
    ];

    foreach ($lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $validationResult = $rule($value);
            if ($validationResult) {
                $errors[$key] = $validationResult;
            }
        }
        if (in_array($key, $required_fields) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        }
    }

    if (count($errors) <= 0) {
        move_uploaded_file($tmp_name, $file_path . $file_name);

        $sql = 'INSERT INTO lots (title, category_id, description, price_add, step_rate, dt_finish, img, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)';

        $stmt = db_get_prepare_stmt($db, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($db);
            header("Location: lot.php?id=" . $lot_id);
        }
    }
}


$add_lot_tpl = include_template('add_lot.tpl.php', [
    'nav_list' => $nav_list,
    'errors' => $errors
]);

$layout_content = include_template('layout.tpl.php', [
    'nav_list' => $nav_list,
    'content' => $add_lot_tpl,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'lot-name' => 'Добавление лота',
    'title' => 'Добавление лота'
]);

echo $layout_content;
