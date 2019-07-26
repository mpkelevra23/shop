<?php

/**
 * Class AdminProductController
 * Управление товарами в админпанели
 */
class AdminProductController extends AdminBase
{

    /**
     * Action для страницы "Управление товарами"
     * @return bool
     */
    public function actionIndex()
    {
        // Проверка доступа
        if (self::checkAdmin()) {

            // Получаем список товаров
            $productsList = Product::getProductsList();

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/index.php');
            return true;
        }
        die('Access denied');
    }

    /**
     * Action для страницы "Добавить товар"
     * @return bool
     */
    public function actionCreate()
    {
        // Проверка доступа
        if (self::checkAdmin()) {

            // Получаем список категорий для выпадающего списка
            $categoriesList = Category::getCategoriesListAdmin();

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Получаем данные из формы
                $options['name'] = $_POST['name'];
                $options['code'] = $_POST['code'];
                $options['price'] = $_POST['price'];
                $options['category_id'] = $_POST['category_id'];
                $options['brand'] = $_POST['brand'];
                $options['availability'] = $_POST['availability'];
                $options['description'] = $_POST['description'];
                $options['is_new'] = $_POST['is_new'];
                $options['is_recommended'] = $_POST['is_recommended'];
                $options['status'] = $_POST['status'];

                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    $options['image'] = '/upload/images/products/' . Transfer::getTranslate(basename($_FILES['image']['name']));
                } else $options['image'] = '/upload/images/products/no-image.jpg';


                // Флаг ошибок в форме
                $errors = false;

                // При необходимости можно валидировать значения нужным образом
                if (!isset($options['name']) || empty($options['name'])) {
                    $errors[] = 'Заполните поля';
                }

                if ($errors == false) {
                    // Если ошибок нет
                    // Добавляем новый товар
                    Product::createProduct($options);

                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // Если загружалось, переместим его в нужную папке, дадим новое имя
                        move_uploaded_file($_FILES["image"]["tmp_name"], ROOT . $options['image']);
                    }

                    // Перенаправляем пользователя на страницу управлениями товарами
                    header("Location: /admin/product");
                }
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/create.php');
            return true;
        }
        die('Access denied');
    }

    /**
     * Action для страницы "Редактировать товар"
     * @param $id
     * @return bool
     */
    public function actionUpdate($id)
    {
        // Проверка доступа
        if (self::checkAdmin()) {

            // Получаем список категорий для выпадающего списка
            $categoriesList = Category::getCategoriesListAdmin();

            // Получаем данные о конкретном заказе
            $product = Product::getProductById($id);

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Получаем данные из формы редактирования. При необходимости можно валидировать значения
                $options['name'] = $_POST['name'];
                $options['code'] = $_POST['code'];
                $options['price'] = $_POST['price'];
                $options['category_id'] = $_POST['category_id'];
                $options['brand'] = $_POST['brand'];
                $options['availability'] = $_POST['availability'];
                $options['description'] = $_POST['description'];
                $options['is_new'] = $_POST['is_new'];
                $options['is_recommended'] = $_POST['is_recommended'];
                $options['status'] = $_POST['status'];


                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    $options['image'] = '/upload/images/products/' . Transfer::getTranslate(basename($_FILES['image']['name']));
                } else $options['image'] = $product['image'];

                // Сохраняем изменения
                if (Product::updateProductById($id, $options)) {

                    // Если запись сохранена
                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // Если загружалось, переместим его в нужную папке, дадим новое имя
                        move_uploaded_file($_FILES["image"]["tmp_name"], ROOT . $options['image']);
                        unlink($product['image']);
                    }
                }

                // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/update.php');
            return true;
        }
        die('Access denied');
    }

    /**
     * Action для страницы "Удалить товар"
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {
        // Проверка доступа
        if (self::checkAdmin()) {

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Удаляем товар
                Product::deleteProductById($id);

                // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/delete.php');
            return true;
        }
        die('Access denied');
    }
}
