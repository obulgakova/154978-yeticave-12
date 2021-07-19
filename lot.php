<?php
require 'init.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    http_response_code(404);
    die();
}

$user_id = $_SESSION['user']['id'] ?? null;

$errors = [];

$sql = 'SELECT DISTINCT l.title,
       l.img,
       l.price_add,
       l.step_rate,
       c.title category_title,
       dt_finish,
       l.description,
       c.symbol_code,
       l.user_id,
       l.user_win_id
FROM lots l
       JOIN categories c ON l.category_id = c.id
WHERE l.id = ?';

$lot_info = db_get_assoc($db, $sql, [$id]);

if (!$lot_info) {
    http_response_code(404);
    die();
};

$sql = 'SELECT dt_add,
        price_add, 
        r.user_id, 
        lot_id, 
        u.name
FROM rates r
        JOIN users u ON r.user_id = u.id
WHERE lot_id = ?
ORDER BY dt_add DESC';

$rates_info = db_get_all($db, $sql, [$id]);


$current_price = $rates_info ? $rates_info[0]['price_add'] : $lot_info['price_add'];
$min_rate = $current_price + $lot_info['step_rate'];

$is_auth = boolval($user_id);
$is_date_expired = time() >= strtotime($lot_info['dt_finish']);
$is_lot_owner = $user_id == $lot_info['user_id'];
$is_last_bet_user = $rates_info && ($user_id == $rates_info[0]['user_id']);

$is_allowed_to_bet = $is_auth && !$is_date_expired && !$is_lot_owner && !$is_last_bet_user;


if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

    if (!$is_allowed_to_bet) {
        http_response_code(403);
        die();
    }

    $form = [
        'cost' => is_numeric($_POST['cost']) ? $_POST['cost'] + 0 : $_POST['cost'],
    ];

    $required_fields = [
        'cost'
    ];

    $rules = [
        'cost' => function ($value) use ($min_rate) {
            if (!is_int($value) || $value <= 0 || $value < $min_rate) {
                return $errors['cost'] = 'Введите целое число, которое больше либо равно минимальной ставке';
            }
        }
    ];

    $errors = form_validation($form, $rules, $required_fields);

    if (!$errors) {
        $sql = 'INSERT INTO rates (dt_add, price_add, user_id, lot_id) VALUES (NOW(), ?, ?, ?)';

        db_get_prepare_stmt($db, $sql, [$form['cost'], $user_id, $id]);

        header("Location: /lot.php?id=$id");
        die();
    }
}


$lot_tpl = include_template('lot.tpl.php', [
    'nav_list' => $nav_list,
    'lot_info' => $lot_info,
    'errors' => $errors,
    'min_rate' => $min_rate,
    'id' => $id,
    'rates_info' => $rates_info,
    'user_id' => $user_id,
    'is_allowed_to_bet' => $is_allowed_to_bet,
    'current_price' => $current_price
]);

$layout_content = include_template('layout.tpl.php', [
    'nav_list' => $nav_list,
    'content' => $lot_tpl,
    'title' => $lot_info['title']
]);
echo $layout_content;
