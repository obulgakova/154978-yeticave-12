<?php
require_once('init.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    http_response_code(404);
}


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

if (!$lot_info) {
    http_response_code(404);
}


$lot_content = include_template('lot-layout.php', [
    'nav_list' => $nav_list,
    'lot_info' => $lot_info
]);
echo $lot_content;
