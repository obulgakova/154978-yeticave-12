<form class="form container <?= esc(!empty($errors) ? 'form--invalid' : ''); ?>" action="login.php" method="post">
      <h2>Вход</h2>
      <div class="form__item <?= esc(!empty($errors['email']) ? 'form__item--invalid' : ''); ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= esc(getPostVal('email')); ?>">
          <?php if (!empty($errors['email'])): ?>
              <span class="form__error"><?= esc($errors['email']); ?></span>
          <?php endif; ?>
      </div>
      <div class="form__item form__item--last <?= esc(!empty($errors['password']) ? 'form__item--invalid' : ''); ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= esc(getPostVal('password')); ?>">
          <?php if (!empty($errors['password'])): ?>
              <span class="form__error"><?= esc($errors['password']); ?></span>
          <?php endif; ?>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
