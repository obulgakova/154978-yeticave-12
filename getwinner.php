<?php
require 'init.php';
require 'vendor/autoload.php';

if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
    die();
}

$user_id = $_SESSION['user']['id'];

$sql = 'SELECT DISTINCT
        l.id lot_id,
        l.title,
        l.dt_finish,
        (SELECT MAX(r.dt_add) FROM rates r WHERE r.lot_id = l.id) latest_bet,
        (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) bet_price,
        r.user_id,
        u.email,
        u.name user_win_name,
        user_win_id
FROM lots l
        JOIN rates r ON l.id = r.lot_id
        JOIN users u ON r.user_id = u.id
WHERE dt_finish <= NOW()
AND user_win_id IS NULL
AND r.user_id = ?';

$stmt = $db->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$win_lots = $result->fetch_assoc();

if ($win_lots) {

    $sql = 'UPDATE lots
        SET user_win_id = ? 
        WHERE id = ?';

    $stmt = $db->prepare($sql);
    $stmt->bind_param('ss', $win_lots['user_id'], $win_lots['lot_id']);
    $stmt->execute();

    $email_content = include_template('email.tpl.php', [
        'win_lots' => $win_lots
    ]);

    $transport = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
    $transport->setUsername('test@gmail.com');
    $transport->setPassword('test');

    $mailer = new Swift_Mailer($transport);

    $message = new Swift_Message();
    $message->setSubject('Ваша ставка победила');
    $message->setFrom("keks@phpdemo.ru", "Yeticave");
    $message->setTo("test.@gmail.com", $win_lots['user_win_name']);
    $message->setBody($email_content, 'text/html');
    $result = $mailer->send($message);
}












