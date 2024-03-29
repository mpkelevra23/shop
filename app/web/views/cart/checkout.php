<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Каталог</h2>
                    <div class="panel-group category-products">
                        <?php foreach ($categories as $categoryItem): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="/category/<?= $categoryItem['id']; ?>">
                                            <?= $categoryItem['name']; ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Корзина</h2>


                    <?php if ($result): ?>

                        <p>Заказ оформлен. Мы Вам перезвоним.</p>

                    <?php else: ?>

                        <p>Выбрано товаров: <?= $totalQuantity; ?>, на сумму: <?= $totalPrice; ?> &#8381;</p><br/>

                        <div class="col-sm-4">

                            <p>Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>

                            <div class="login-form">
                                <form action="#" method="post">

                                    <p>Ваша имя</p>

                                    <input type="text" name="userName" placeholder="" value="<?= $userName; ?>"/>
                                    <?php if (isset($errors['name'])): ?>
                                        <p><?= $errors['name']; ?></p>
                                    <?php endif; ?>

                                    <p>Номер телефона</p>

                                    <input type="text" name="userPhone" placeholder="" value="<?= $userPhone; ?>"/>
                                    <?php if (isset($errors['phone'])): ?>
                                        <p><?= $errors['phone']; ?></p>
                                    <?php endif; ?>

                                    <p>Комментарий к заказу</p>
                                    <input type="text" name="userComment" placeholder="Сообщение"
                                           value="<?= $userComment; ?>"/>

                                    <input type="submit" name="submit" class="btn btn-default" value="Оформить"/>
                                </form>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>