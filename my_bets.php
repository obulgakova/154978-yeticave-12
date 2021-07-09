<?php
require 'init.php';

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    die();
}

$user_id = $_SESSION['user']['id'];

$sql = 'SELECT DISTINCT
        l.id,
        l.title,
        l.img,
        u.message,
        c.title cat_title,
        l.dt_finish,
        r.user_id,
        l.user_win_id,
        (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) max_price,
        (SELECT MAX(r.dt_add) FROM rates r WHERE r.lot_id = l.id) latest_date
FROM lots l
        JOIN rates r ON l.id = r.lot_id
        JOIN users u ON l.user_id = u.id
        JOIN categories c ON l.category_id = c.id
WHERE r.user_id = ?
ORDER BY latest_date DESC';

$result = db_get_prepare_stmt($db, $sql, [$user_id])->get_result();
$my_bets_list = $result->fetch_all(MYSQLI_ASSOC);


$my_bets_tpl = include_template('my_bets.tpl.php', [
    'my_bets_list' => $my_bets_list,
    'user_id' => $user_id
]);

$layout_content = include_template('layout.tpl.php', [
    'nav_list' => $nav_list,
    'content' => $my_bets_tpl,
    'title' => 'Мои ставки'
]);

echo $layout_content;
