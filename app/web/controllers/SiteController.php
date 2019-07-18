<?php

class SiteController
{

    public function actionIndex()
    {
        $categories = Category::getCategoriesList();

        $latestProducts = Product::getLatestProducts(6);

        require_once(ROOT . '/views/site/index.php');

        return true;
    }

    /*
     * Надо подключить отправку сообщений
     */

    public function actionContact()
    {

        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {

            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;

            // Валидация полей
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if ($errors == false) {
                $adminEmail = 'mpkelevra23@gmail.com';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }

        }

        require_once(ROOT . '/views/site/contact.php');

        return true;
    }

}
