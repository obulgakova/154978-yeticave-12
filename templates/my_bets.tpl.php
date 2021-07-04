<section class="rates container">
    <h2>Мои ставки</h2>
    <?php if (!$my_bets_list) : ?>
        <span>У вас еще нет ставок</span>
    <?php endif; ?>
    <table class="rates__list">
        <?php foreach ($my_bets_list as $key => $lot): ?>
            <?php
            $date = dt_remaining($lot['dt_finish']);
            $ts = time();
            $end_ts = strtotime($lot['dt_finish']);
            ?>
            <tr class="rates__item <?= esc($ts > $end_ts && $lot['user_win_id'] == $user_id ? 'rates__item--win' : ''); ?><?= esc($ts > $end_ts && $lot['user_win_id'] !== $user_id ? 'rates__item--end' : ''); ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src=<?= esc($lot['img']); ?> width="54" height="40" alt="<?= esc($lot['cat_title']); ?>">
                    </div>
                    <div>
                        <h3 class="rates__title"><a class="text-link"
                                                    href="lot.php?id=<?= esc($lot['id']); ?>"><?= esc($lot['title']); ?></a>
                        </h3>
                        <?php if ($lot['user_win_id'] == $user_id): ?>
                            <p><?= esc($lot['message']); ?></p>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="rates__category">
                    <?= esc($lot['cat_title']); ?>
                </td>
                <td class="rates__timer">
                    <?php if ($ts > $end_ts && $lot['user_win_id'] == $user_id) : ?>
                        <div class="timer timer--win">
                            Ставка выиграла
                        </div>
                    <?php elseif ($ts > $end_ts && $lot['user_win_id'] !== $user_id): ?>
                        <div class="timer timer--end">Торги окончены</div>
                    <?php else: ?>
                        <div class="timer <?= esc($date[0] < 1 ? 'timer--finishing' : ''); ?>">
                            <?= esc($date[0]) . " : " . esc($date[1]); ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="rates__price">
                    <?= esc(price_formatting($lot['max_price'])); ?>
                </td>
                <td class="rates__time">
                    <?= esc(rate_dt_add($lot['latest_date'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
