<?php
require 'init.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    http_response_code(404);
    die();
}

$errors = [];

$sql = 'SELECT l.title,
       l.price_add,
       img,
       (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) current_price,
       l.step_rate,
       c.title                                                      category_title,
       dt_finish,
       l.description,
       symbol_code
FROM lots l
       JOIN categories c ON l.category_id = c.id
WHERE l.id = ?';

$stmt = $db->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$lot_info = $result->fetch_assoc();

$min_rate = $lot_info['current_price'] + $lot_info['step_rate'];


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
        JOIN users u ON  r.user_id = u.id
WHERE lot_id = ?
ORDER BY dt_add DESC';

$stmt = $db->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$rates_info = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

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

        $stmt = $db->prepare($sql);
        $stmt->bind_param('sss', $form['cost'], $_SESSION['user']['id'], $id);
        $stmt->execute();

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
    'rates_info' => $rates_info
]);

$layout_content = include_template('layout.tpl.php', [
    'nav_list' => $nav_list,
    'content' => $lot_tpl,
    'title' => $lot_info['title']
]);
echo $layout_content;
