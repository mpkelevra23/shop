<?php

/**
 * Контроллер AdminController
 * Главная страница в админпанели
 */
class AdminController extends AdminBase
{
    /**
     * Action для стартовой страницы "Панель администратора"
     */
    public function actionIndex()
    {
        // Проверка доступа
        if (self::checkAdmin()) {

            // Подключаем вид
            require_once(ROOT . '/views/admin/index.php');
            return true;
        }
        die('Access denied');
    }
}
