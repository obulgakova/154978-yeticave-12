<section class="lot-item container">
    <h2><?= esc($lot_info['title']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= esc($lot_info['img']); ?>" width="730" height="548"
                     alt="<?= esc($lot_info['category_title']); ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= esc($lot_info['category_title']); ?></span></p>
            <p class="lot-item__description"><?= esc($lot_info['description']); ?></p>
        </div>
        <div class="lot-item__right">

            <div class="lot-item__state">
                <?php
                $date = dt_remaining($lot_info['dt_finish']);
                $ts = time();
                $end_ts = strtotime($lot_info['dt_finish']);
                ?>
                <div class="rates__timer">
                    <?php if ($ts > $end_ts && $lot_info['user_win_id'] == $user_id) : ?>
                        <div class="timer timer--win">
                            Ставка выиграла
                        </div>
                    <?php elseif ($ts > $end_ts && $lot_info['user_win_id'] !== $user_id): ?>
                        <div class="timer timer--end">Торги окончены</div>
                    <?php else: ?>
                        <div class="timer <?= esc($date[0] < 1 ? 'timer--finishing' : ''); ?>">
                            <?= esc($date[0]) . " : " . esc($date[1]); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span
                            class="lot-item__cost"><?= esc(price_formatting($lot_info['current_price'])); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= esc(price_formatting($min_rate)); ?></span>
                    </div>
                </div>
                <?php if ((isset($_SESSION['user'])) && (time() < strtotime($lot_info['dt_finish'])) && ($user_id != $lot_info['user_id'])): ?>
                    <form class="lot-item__form <?= esc(!empty($errors) ? 'form--invalid' : ''); ?>"
                          action="lot.php?id=<?= esc($id); ?>" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item <?= esc(!empty($errors['cost']) ? 'form__item--invalid' : ''); ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost"
                                   placeholder="<?= esc(price_formatting($min_rate)); ?>" value="">
                            <?php if (!empty($errors['cost'])): ?>
                                <span class="form__error"><?= esc($errors['cost']); ?></span>
                            <?php endif; ?>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= esc(count($rates_info)); ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($rates_info as $rate): ?>
                        <tr class="history__item">
                            <td class="history__name"><?= esc($rate['name']); ?></td>
                            <td class="history__price"><?= esc(price_formatting($rate['price_add'])); ?></td>
                            <td class="history__time"><?= esc(rate_dt_add($rate['dt_add'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
