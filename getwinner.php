<?php

$sql = 'SELECT
        l.id lot_id,
        l.title,
        l.dt_finish,
        r.dt_add latest_bet,
        r.price_add bet_price,
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

if ($lots_to_update) {
    $sql = 'UPDATE lots
        SET user_win_id = ?
        WHERE id = ?';

    $mailer = new Swift_Mailer($email_transport);


    foreach ($lots_to_update as $lot => $value) {

        $stmt = db_get_prepare_stmt($db, $sql, [$value['last_bet_user'], $value['lot_id']]);

        if ($stmt->affected_rows >= 1) {
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
}

