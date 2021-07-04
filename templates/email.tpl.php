    <h1>Поздравляем с победой</h1>
    <p>Здравствуйте, <?= esc($value['user_winner_name']); ?></p>
    <p>Ваша ставка для лота <a
            href="yeticave/lot.php?id=<?= esc($value['lot_id']); ?>"><?= esc($value['title']); ?></a> победила.</p>
    <p>Перейдите по ссылке <a href="yeticave/my_bets.php">мои ставки</a>,
        чтобы связаться с автором объявления</p>
    <small>Интернет-Аукцион "YetiCave"</small>
