<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                <?php if ($result): ?>
                    <p>Данные отредактированы</p>
                <?php endif; ?>
                <div class="signup-form">
                    <h2>Регистрация на сайте</h2>
                    <form action="#" method="post">
                        <?php if (isset($errors['name'])): ?>
                            <p><?= $errors['name']; ?></p>
                        <?php endif; ?>
                        <input type="text" name="name" placeholder="Имя" value="<?= $name; ?>"/>
                        <?php if (isset($errors['password'])): ?>
                            <p><?= $errors['password']; ?></p>
                        <?php endif; ?>
                        <input type="password" name="password" placeholder="Пароль"
                               value="<?= $password; ?>"/>
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>