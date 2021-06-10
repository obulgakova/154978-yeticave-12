<form class="form form--add-lot container  <?= esc(!empty($errors) ? 'form--invalid' : ''); ?>" action="add.php"
      method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item  <?= esc(!empty($errors['lot-name']) ? 'form__item--invalid' : ''); ?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                   value="<?= esc(getPostVal('lot-name')); ?>">
            <?php if (!empty($errors['lot-name'])): ?>
                <span class="form__error"><?= esc($errors['lot-name']); ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item <?= esc(!empty($errors['category']) ? 'form__item--invalid' : ''); ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select
                id="category"
                name="category"
            >
                <option>Выберите категорию</option>
                <?php foreach ($nav_list as $value): ?>
                    <option
                        value="<?= esc($value['id']); ?>"
                        <?= esc($value['id'] == getPostVal('category') ? 'selected' : ''); ?>
                    >
                        <?= esc($value['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['category'])): ?>
                <span class="form__error"><?= esc($errors['category']); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form__item form__item--wide <?= esc(!empty($errors['message']) ? 'form__item--invalid' : ''); ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message"
                  placeholder="Напишите описание лота"><?= esc(getPostVal('message')); ?></textarea>
        <?php if (!empty($errors['message'])): ?>
            <span class="form__error"><?= esc($errors['message']); ?></span>
        <?php endif; ?>
    </div>
    <div class="form__item form__item--file">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file <?= esc(!empty($errors['lot-img']) ? 'form__item--invalid' : ''); ?>">
            <input class="visually-hidden" type="file" id="lot-img" name="lot-img" value="">
            <label for="lot-img">
                Добавить
            </label>
            <?php if (!empty($errors['lot-img'])): ?>
                <span class="form__error"><?= esc($errors['lot-img']); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= esc(!empty($errors['lot-rate']) ? 'form__item--invalid' : ''); ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= esc(getPostVal('lot-rate')); ?>">
            <?php if (!empty($errors['lot-rate'])): ?>
                <span class="form__error"><?= esc($errors['lot-rate']); ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item form__item--small <?= esc(!empty($errors['lot-step']) ? 'form__item--invalid' : ''); ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= esc(getPostVal('lot-step')); ?>">
            <?php if (!empty($errors['lot-step'])): ?>
                <span class="form__error"><?= esc($errors['lot-step']); ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item <?= esc(!empty($errors['lot-date']) ? 'form__item--invalid' : ''); ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="lot-date"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= esc(getPostVal('lot-date')); ?>">
            <?php if (!empty($errors['lot-date'])): ?>
                <span class="form__error"><?= esc($errors['lot-date']); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>

