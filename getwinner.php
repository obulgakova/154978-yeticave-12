<?php
require 'init.php';
require 'vendor/autoload.php';

$sql = 'SELECT
        l.id lot_id,
        l.title,
        l.dt_finish,
        (SELECT MAX(r.dt_add) FROM rates r WHERE r.lot_id = l.id) latest_bet,
        (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) bet_price,
        r.user_id last_bet_user,
        u.name user_winner_name,
        u.email user_winner_email,
        l.user_win_id
FROM lots l
        JOIN rates r ON l.id = r.lot_id
        JOIN users u ON r.user_id = u.id
WHERE dt_finish <= NOW()
AND user_win_id = 50
AND r.price_add = (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id)';

$result = $db->query($sql);
$lots_to_update = $result->fetch_all(MYSQLI_ASSOC);

if ($lots_to_update) {
    $sql = 'UPDATE lots
        SET user_win_id = ?
        WHERE id = ?';

    $transport = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
    $transport->setUsername('test@gmail.com');
    $transport->setPassword('test');

    $mailer = new Swift_Mailer($transport);

    $message = new Swift_Message();
    $message->setSubject('Ваша ставка победила');
    $message->setFrom("keks@phpdemo.ru", "Yeticave");

    foreach ($lots_to_update as $lot => $value) {
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss', $value['last_bet_user'], $value['lot_id']);
        $stmt->execute();

        $email_content = include_template('email.tpl.php', [
            'value' => $value
        ]);

        $message->setTo($value['user_winner_email'], $value['user_winner_name']);
        $message->setBody($email_content, 'text/html');
        $result = $mailer->send($message);
    }
}

