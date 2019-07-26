<?php

/**
 * Class UserController
 */
class UserController
{
    /**
     * Производим регистрацию пользователя
     * @return bool
     */
    public function actionRegistration()
    {
        // Переменные для формы
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Валидация полей
            if (!User::checkName($name)) {
                $errors['name'] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors['email'] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors['email'] = 'Такой email уже используется';
            }

            if (!isset($errors)) {
                // Если ошибок нет
                // Регистрируем пользователя
                $result = User::registration($name, $email, $password);
            }

        }

        // Подключаем вид
        require_once(ROOT . '/views/user/registration.php');

        return true;
    }

    /**
     * Производим аутентификацию и авторизацию пользователя
     * @return bool
     */
    public function actionLogin()
    {
        // Переменные для формы
        $email = false;
        $password = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkEmail($email)) {
                $errors['email'] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }

            // Проверяем существует ли пользователь
            $userId = User::authentication($email, $password);

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors['userId'] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::authorization($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет
                header("Location: /cabinet/");
            }
        }

        // Подключаем вид
        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        session_start();

        // Удаляем все переменные сессии.
        $_SESSION = [];

        // Если требуется уничтожить сессию, также необходимо удалить сессионные cookie.
        // Замечание: Это уничтожит сессию, а не только данные сессии!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Наконец, уничтожаем сессию.
        session_destroy();
        header('Location: /');
    }

}
