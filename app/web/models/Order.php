<?php

/**
 * Class Order
 * Модель для работы с заказами
 */
class Order
{

    /**
     * Сохранение заказа
     * @param $userName
     * @param $userPhone
     * @param $userComment
     * @param $userId
     * @param $products
     * @return bool
     */
    public static function save($userName, $userPhone, $userComment, $userId, $products)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Преобразуем список товаров в json формат
        $products = json_encode($products);

        $result = $db->prepare('INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
            . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)');
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':products', $products, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Возвращает список заказов
     * @return array
     */
    public static function getOrdersList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC');

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает текстое пояснение статуса для заказа (1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт)
     * @param $status
     * @return string
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Новый заказ';
                break;
            case '2':
                return 'В обработке';
                break;
            case '3':
                return 'Доставляется';
                break;
            case '4':
                return 'Закрыт';
                break;
        }
    }

    /**
     * Возвращает заказ с указанным id
     * @param $id
     * @return mixed
     */
    public static function getOrderById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('SELECT * FROM product_order WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        // Возвращаем данные
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Удаляет заказ с заданным id
     * @param $id
     * @return bool
     */
    public static function deleteOrderById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('DELETE FROM product_order WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редактирует заказ с заданным id
     * @param $id
     * @param $userName
     * @param $userPhone
     * @param $userComment
     * @param $date
     * @param $status
     * @return bool
     */
    public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('UPDATE product_order
            SET 
                user_name = :user_name, 
                user_phone = :user_phone, 
                user_comment = :user_comment, 
                date = :date, 
                status = :status 
            WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
}
