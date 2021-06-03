<?php
require 'init.php';

$errors = [];

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

    $cats_ids = [];
    foreach ($nav_list as $value) {
        $cats_ids[] = $value['id'];
    };

    $lot = [
        'lot-name' => $_POST['lot-name'],
        'category' => intval($_POST['category']),
        'message' => $_POST['message'],
        'lot-rate' => is_numeric($_POST['lot-rate']) ? floatval($_POST['lot-rate']) : $_POST['lot-rate'],
        'lot-step' => is_numeric($_POST['lot-step']) ? $_POST['lot-step'] + 0 : $_POST['lot-step'],
        'lot-date' => $_POST['lot-date'],
        'lot-img' => $_FILES['lot-img']
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
        'category' => function ($value) use ($cats_ids){
            return validate_category_id($value, $cats_ids);
        },
        'lot-img' => function ($value) {
            return validate_file($value);
        },

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
        $file_name = $_FILES['lot-img']['name'];
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;
        move_uploaded_file($tmp_name, $file_path . $file_name);
        $lot ['lot-img'] = $file_url;

        $sql = 'INSERT INTO lots (title, category_id, description, price_add, step_rate, dt_finish, img, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)';

        $stmt = db_get_prepare_stmt($db, $sql, $lot);
        mysqli_stmt_execute($stmt);

        $lot_id = mysqli_insert_id($db);
        header("Location: lot.php?id=" . $lot_id);
        die();
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
