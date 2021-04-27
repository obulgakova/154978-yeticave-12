<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
        горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->

        <?php
        foreach ($nav_list as $value): ?>
            <li class="promo__item promo__item--<?= $value['symbol_code'] ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= esc($value['title']); ?></a>
            </li>
        <?php endforeach; ?>

    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($lots_list as $key => $item): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= esc($item['img']); ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= esc($item['category_title']); ?></span>
                    <h3 class="lot__title"><a class="text-link"
                                              href="pages/lot.html"><?= esc($item['title']); ?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= esc(price_formatting($item['current_price'])); ?></span>
                        </div>
                        <?php
                            $date = dt_remaining($item['dt_finish']);
                        ?>
                            <div class="lot__timer timer <?= $date[0] < 1 ? 'timer--finishing' : ''; ?>">
                                <?= esc($date[0]) . " : " . esc($date[1]); ?>
                            </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
