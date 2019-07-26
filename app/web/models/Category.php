<?php

/**
 * Class Category
 * Модель для работы с категориями товаров
 */
class Category
{

    /**
     * Возвращает массив категорий для списка на сайте
     * @return array
     */
    public static function getCategoriesList()
    {

        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT `id`, `name` FROM `category` '
            . 'ORDER BY `sort_order`');

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает массив категорий для списка в админпанели
     * (при этом в результат попадают и включенные и выключенные категории)
     * @return array
     */
    public static function getCategoriesListAdmin()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT id, name, sort_order, status FROM category ORDER BY sort_order');

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Удаляет категорию с заданным id
     * @param $id
     * @return bool
     */
    public static function deleteCategoryById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('DELETE FROM category WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редактирование категории с заданным id
     * @param $id
     * @param $name
     * @param $sortOrder
     * @param $status
     * @return bool
     */
    public static function updateCategoryById($id, $name, $sortOrder, $status)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('UPDATE category
            SET 
                name = :name, 
                sort_order = :sort_order, 
                status = :status
            WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Возвращает категорию с указанным id
     * @param $id
     * @return mixed
     */
    public static function getCategoryById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Используется подготовленный запрос
        $result = $db->prepare('SELECT * FROM category WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Выполняем запрос
        $result->execute();

        // Возвращаем данные
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает текстое пояснение статуса для категории (0 - Скрыта, 1 - Отображается)
     * @param $status
     * @return string
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }

    /**
     * Добавляет новую категорию
     * @param $name
     * @param $sortOrder
     * @param $status
     * @return bool
     */
    public static function createCategory($name, $sortOrder, $status)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('INSERT INTO category (name, sort_order, status) '
            . 'VALUES (:name, :sort_order, :status)');
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
}