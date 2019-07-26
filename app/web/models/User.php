<?php

/**
 * Class User
 * Модель для работы с пользователями
 */
class User
{
    /**
     * Регестрируем пользователя
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     */
    public static function registration($name, $email, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
        $result->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
        $result->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
        $result->bindParam(':password', $password, PDO::PARAM_STR_CHAR);

        return $result->execute();
    }

    /**
     * Редактирование данных пользователя
     * @param $id
     * @param $name
     * @param $password
     * @return bool
     */
    public static function edit($id, $name, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('UPDATE user SET name = :name, password = :password WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
        $result->bindParam(':password', $password, PDO::PARAM_STR_CHAR);

        return $result->execute();
    }

    /**
     * Аутентификация пользователя
     * @param $email
     * @param $password
     * @return bool
     */
    public static function authentication($email, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('SELECT * FROM user WHERE email = :email AND password = :password');
        $result->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
        $result->bindParam(':password', $password, PDO::PARAM_STR_CHAR);
        $result->execute();

        // Обращаемся к записи
        $user = $result->fetch();

        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }

        return false;
    }

    /**
     * Авторизация пользователя
     * @param $userId
     */
    public static function authorization($userId)
    {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }

    /**
     * Возвращает идентификатор пользователя, если он авторизирован. Иначе перенаправляет на страницу входа
     * @return mixed
     */

    public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Проверяет телефон: не меньше, чем 10 символов
     * @param $phone
     * @return bool
     */
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    /**
     * Проверяем авторизован ли пользователь
     * @return bool
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет имя: не меньше, чем 2 символа
     * @param $name
     * @return bool
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет пароль: не меньше, чем 6 символов
     * @param $password
     * @return bool
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет email
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет не занят ли email другим пользователем
     * @param $email
     * @return bool
     */

    public static function checkEmailExists($email)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
        $result->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Возвращает пользователя с указанным id
     * @param $id
     * @return mixed
     */
    public static function getUserById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('SELECT * FROM user WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }
}