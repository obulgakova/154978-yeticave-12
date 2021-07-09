<?php
require 'init.php';

if (isset($_GET['category_title'])) {
    $category_title = $_GET['category_title'];
} else {
    http_response_code(404);
    die();
}
$cur_page = $_GET['page'] ?? 1;

$page_items = 9;
$pages = [];
$pages_count = 0;
$lots_list = [];

if ($category_title) {
    $sql = 'SELECT COUNT(*) as cnt 
            FROM lots l
                JOIN categories c ON l.category_id = c.id
            WHERE dt_finish > NOW()
            AND c.title = ?';

    $result = db_get_prepare_stmt($db, $sql, [$category_title])->get_result();
    $items_count = $result->fetch_assoc()['cnt'];
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

    if ($pages_count > 0) {
        $pages = range(1, $pages_count);
    }


    $sql = 'SELECT l.id, 
        l.title,
        l.price_add,
        img,
        dt_finish,
        (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) current_price,
        c.title                                                      category_title
        FROM lots l 
            JOIN categories c ON l.category_id = c.id
        WHERE dt_finish > NOW()
        AND c.title = ?
        ORDER BY dt_add ASC
        LIMIT ?
        OFFSET ?';

    $result = db_get_prepare_stmt($db, $sql, [$category_title, $page_items, $offset])->get_result();

    $lots_list = $result->fetch_all(MYSQLI_ASSOC);
}

if ($cur_page < 1 || ($cur_page > $pages_count && $pages_count != 0)) {
    http_response_code(404);
    die();
}


$all_lots_content = include_template('all_lots.tpl.php', [
    'lots_list' => $lots_list,
    'category_title' => $category_title,
    'pages' => $pages,
    'cur_page' => $cur_page
]);

$layout_content = include_template('layout.tpl.php', [
    'nav_list' => $nav_list,
    'content' => $all_lots_content,
    'title' => 'Все лоты',
    'category_title' => $category_title
]);

echo $layout_content;
