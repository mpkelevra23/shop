<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                <div class="login-form">
                    <h2>Вход</h2>
                    <?php if (isset($errors['userId'])): ?>
                        <p><?= $errors['userId']; ?></p>
                    <?php endif; ?>
                    <form action="#" method="post">
                        <?php if (isset($errors['email'])): ?>
                            <p><?= $errors['email']; ?></p>
                        <?php endif; ?>
                        <input type="email" name="email" placeholder="E-mail" value="<?= $email; ?>"/>
                        <?php if (isset($errors['password'])): ?>
                            <p><?= $errors['password']; ?></p>
                        <?php endif; ?>
                        <input type="password" name="password" placeholder="Пароль"
                               value="<?= $password; ?>"/>
                        <input type="submit" name="submit" class="btn btn-default" value="Вход"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>