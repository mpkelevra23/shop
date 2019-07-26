<?php

/**
 * Class Product
 * Модель для работы с товарами
 */
class Product
{
    // Количество отображаемых товаров по умолчанию
    const SHOW_BY_DEFAULT = 6;

    /**
     * Возвращает массив последних товаров
     * @param int $count
     * @return array
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('SELECT `id`, `name`, `price`, `image`, `is_new` FROM `product` '
            . 'WHERE `status` = 1 '
            . 'ORDER BY `id` DESC '
            . 'LIMIT ' . $count);
        $result->bindParam(':count', $count, PDO::PARAM_INT);

        // Выполнение команды
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Добавляет новый товар
     * @param $options
     * @return int|string
     */
    public static function createProduct($options)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('INSERT INTO product '
            . '(name, code, price, category_id, brand, availability,'
            . 'description, is_new, is_recommended, status, image)'
            . 'VALUES '
            . '(:name, :code, :price, :category_id, :brand, :availability,'
            . ':description, :is_new, :is_recommended, :status, :image)');
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        $result->bindParam(':image', $options['image'], PDO::PARAM_STR);
        return $result->execute();
    }


    /**
     * Редактирует товар с заданным id
     * @param $id
     * @param $options
     * @return bool
     */
    public static function updateProductById($id, $options)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare("UPDATE product
            SET 
                name = :name, 
                code = :code, 
                price = :price, 
                category_id = :category_id, 
                brand = :brand, 
                availability = :availability, 
                description = :description, 
                is_new = :is_new, 
                is_recommended = :is_recommended, 
                status = :status,
                image = :image
            WHERE id = :id");
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        $result->bindParam(':image', $options['image'], PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Возвращает список товаров в указанной категории
     * @param bool $categoryId
     * @param int $page
     * @return array|bool
     */
    public static function getProductsListByCategory($categoryId, $page = 1)
    {
        $limit = Product::SHOW_BY_DEFAULT;
        // Смещение (для запроса)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        // Соединение с БД
        $db = Db::getConnection();

        // Используется подготовленный запрос
        $result = $db->prepare('SELECT id, name, price, is_new, image FROM product '
            . 'WHERE status = 1 AND category_id = :category_id '
            . 'ORDER BY id ASC LIMIT :limit OFFSET :offset');
        $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        // Выполнение коменды
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает продукт с указанным id
     * @param $id
     * @return mixed
     */
    public static function getProductById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Используется подготовленный запрос
        $result = $db->prepare('SELECT * FROM product WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает массив товаров
     * @return array
     */
    public static function getProductsList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id');

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Возвращает список рекомендуемых товаров
     * @return array
     */
    public static function getRecommendedProducts()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT `id`, `name`, `price`, `image`, `is_new` FROM `product` '
            . 'WHERE `status` = 1 AND `is_recommended` = 1 '
            . 'ORDER BY `id` DESC ');

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращаем количество товаров в указанной категории
     * @param $categoryId
     * @return mixed
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Используется подготовленный запрос
        $result = $db->prepare('SELECT count(id) AS count FROM product WHERE status= 1 AND category_id = :category_id');
        $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

        // Выполнение коменды
        $result->execute();

        // Возвращаем значение count - количество
        $row = $result->fetch();
        return $row['count'];
    }

    /**
     * Возвращает список товаров с указанными индентификторами
     * @param $idsArray
     * @return array
     */
    public static function getProductsByIds($idsArray)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Превращаем массив в строку для формирования условия в запросе
        $idsString = implode(',', $idsArray);

        // Получение и возврат результатов
        $result = $db->query("SELECT `id`, `code`, `name`, `price` FROM product WHERE status='1' AND id IN ($idsString)");

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Удаляет товар с указанным id
     * @param $id
     * @return bool
     */
    public static function deleteProductById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare('DELETE FROM product WHERE id = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
}