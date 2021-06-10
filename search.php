<?php
require 'init.php';

$search = trim($_GET['search'] ?? '');
$cur_page = $_GET['page'] ?? 1;

$page_items = 9;
$pages = [];
$pages_count = 0;
$lots_list = [];

if ($search) {
    $sql = 'SELECT COUNT(*) as cnt 
            FROM lots 
            WHERE dt_finish > NOW() 
            AND MATCH(title, description)
            AGAINST(?)';

    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $result = $stmt->get_result();

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
           l.description,
           (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) current_price,
           c.title                                                      category_title
            FROM lots l 
            JOIN categories c ON l.category_id = c.id
            WHERE dt_finish > NOW() 
            AND MATCH(l.title, description)
            AGAINST(?)
            ORDER BY dt_add ASC
            LIMIT ?
            OFFSET ?';

    $stmt = $db->prepare($sql);
    $stmt->bind_param('sss', $search, $page_items, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $lots_list = $result->fetch_all(MYSQLI_ASSOC);
}

if ($cur_page < 1 || ($cur_page > $pages_count && $pages_count != 0)) {
    http_response_code(404);
    die();
}

$search_content = include_template('search.tpl.php', [
    'lots_list' => $lots_list,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'search' => $search
]);

$layout_content = include_template('layout.tpl.php', [
    'nav_list' => $nav_list,
    'content' => $search_content,
    'title' => 'Поиск',
    'search' => $search
]);

echo $layout_content;
