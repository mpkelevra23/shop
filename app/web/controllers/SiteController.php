<?php

/**
 * Class SiteController
 */
class SiteController
{

    /**
     * Action для главной страницы
     * @return bool
     */
    public function actionIndex()
    {
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();

        // Список последних товаров
        $latestProducts = Product::getLatestProducts(6);

        // Список товаров для слайдера
        $recommendedProducts = Product::getRecommendedProducts();

        // Подключаем вид
        require_once(ROOT . '/views/site/index.php');

        return true;
    }

    /**
     * Action для страницы "Контакты" (Надо подключить отправку сообщений)
     * @return bool
     */
    public function actionContact()
    {

        // Переменные для формы
        $userEmail = false;
        $userText = false;
        $result = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if ($errors == false) {
                // Если ошибок нет
                // Отправляем письмо администратору
                $adminEmail = 'mpkelevra23@gmail.com';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }

        }

        // Подключаем вид
        require_once(ROOT . '/views/site/contact.php');

        return true;
    }

    /**
     * Action для страницы "О магазине"
     * @return bool
     */
    public function actionAbout()
    {
        // Подключаем вид
        require_once(ROOT . '/views/site/about.php');
        return true;
    }
}
