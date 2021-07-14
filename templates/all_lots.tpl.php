<div class="container">
    <section class="lots">
        <h2>Все лоты в категории «<span><?= esc($category_title) ?></span>»</h2>
        <ul class="lots__list">
            <?php if (!$lots_list): ?>
                <span>На данный момент в этой категории нет открытых лотов</span>
            <?php endif; ?>
            <?php foreach ($lots_list as $key => $item): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= esc($item['img']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($item['category_title']); ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= esc($item['id']); ?>"><?= esc($item['title']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= esc(price_formatting($item['current_price'])); ?></span>
                            </div>
                            <?php
                            $date = dt_remaining($item['dt_finish']);
                            ?>
                            <div class="lot__timer timer <?= esc($date[0] < 1 ? 'timer--finishing' : ''); ?>">
                                <?= esc($date[0]) . " : " . esc($date[1]) . " : " . esc($date[2]); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <?php if (count($pages) > 1) : ?>
        <ul class="pagination-list">

            <li class="pagination-item pagination-item-prev">
                <?php if ($cur_page > 1): ?>
                    <a href="/all_lots.php?category_title=<?= esc($category_title); ?>&page=<?= esc($cur_page - 1); ?>">Назад</a>
                <?php else: ?>
                    <a>Назад</a>
                <?php endif; ?>
            </li>

            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $cur_page): ?> pagination-item-active" <?php endif; ?>">
                <a href="/all_lots.php?category_title=<?= esc($category_title); ?>&page=<?= esc($page); ?>"><?= esc($page); ?></a>
                </li>
            <?php endforeach; ?>

            <li class="pagination-item pagination-item-next">
                <?php if ($cur_page < count($pages)) : ?>
                    <a href="/all_lots.php?category_title=<?= esc($category_title); ?>&page=<?= esc($cur_page + 1); ?>">Вперед</a>
                <?php else: ?>
                    <a>Вперед</a>
                <?php endif; ?>
            </li>

        </ul>
    <?php endif; ?>
</div>

