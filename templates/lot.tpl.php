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
                ?>
                <div class="lot-item__timer timer <?= esc($date[0] < 1 ? 'timer--finishing' : ''); ?>">
                    <?= esc($date[0]) . " : " . esc($date[1]); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span
                            class="lot-item__cost"><?= esc(price_formatting($lot_info['current_price'])); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= esc(price_formatting($lot_info['step_rate'])); ?></span>
                    </div>
                </div>
                <?php if (isset($_SESSION['user'])) : ?>
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item form__item--invalid">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="12 000">
                            <span class="form__error">Введите наименование лота</span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section>
