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
AND user_win_id IS NULL
AND r.price_add = (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id)';

$result = $db->query($sql);
$lots_to_update = $result->fetch_all(MYSQLI_ASSOC);

$lot_id_array = array_column($lots_to_update, 'lot_id');
$win_array = array_column($lots_to_update, 'last_bet_user');
$lot_win_array = array_combine($lot_id_array, $win_array);

if ($lot_id_array) {
    $sql = 'UPDATE lots
        SET user_win_id = ?
        WHERE id = ?';

    foreach ($lot_win_array as $lot_id => $winner_id) {
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss', $winner_id, $lot_id);
        $stmt->execute();
    }

    foreach ($lots_to_update as $key => $value) {
        $transport = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
        $transport->setUsername('test@gmail.com');
        $transport->setPassword('test');

        $mailer = new Swift_Mailer($transport);

        $email_content = include_template('email.tpl.php', [
            'value' => $value
        ]);
        $message = new Swift_Message();
        $message->setSubject('Ваша ставка победила');
        $message->setFrom("keks@phpdemo.ru", "Yeticave");
        $message->setTo($value['user_winner_email'], $value['user_winner_name']);
        $message->setBody($email_content, 'text/html');
        $result = $mailer->send($message);
    }
}










