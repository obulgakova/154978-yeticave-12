<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
        горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->

        <?php
        foreach ($nav_list as $value): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= esc($value); ?></a>
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
                    <img src="<?= esc($item['url']); ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= esc($item['category']); ?></span>
                    <h3 class="lot__title"><a class="text-link"
                                              href="pages/lot.html"><?= esc($item['title']); ?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= esc(price_formatting($item['price'])); ?></span>
                        </div>

                        <?
                            $date = dt_remaining($item['date_remaining']);
                            if ($date[0] < 1):
                        ?>
                            <div class="lot__timer timer timer--finishing">
                                <?= $date[0] . " : " . $date[1]; ?>
                            </div>
                        <? else: ?>
                            <div class=" lot__timer timer">
                                <?= $date[0] . " : " . $date[1]; ?>
                            </div>
                        <? endif ?>

                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
