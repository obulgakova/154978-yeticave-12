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

            </div>
        </div>
    </div>

</section>
