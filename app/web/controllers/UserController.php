<?php

class UserController
{

    public function actionRegistration()
    {
        $name = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

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
                $result = User::registration($name, $email, $password);
            }

        }

        require_once(ROOT . '/views/user/registration.php');

        return true;
    }

}
