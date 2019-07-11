<?php

class Product
{

    const SHOW_BY_DEFAULT = 6;

    /**
     * @param int $count
     * @return array
     * Returns an array of products
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();

        $result = $db->query('SELECT `id`, `name`, `price`, `image`, `is_new` FROM `product` '
            . 'WHERE `status` = 1 '
            . 'ORDER BY `id` DESC '
            . 'LIMIT ' . $count)->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param bool $categoryId
     * @param int $page
     * @return array|bool
     * Returns an array of products
     */
    public static function getProductsListByCategory($categoryId = false, $page = 1)
    {
        if ($categoryId) {

            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();
            $result = $db->query("SELECT `id`, `name`, `price`, `image`, `is_new` FROM `product` "
                . "WHERE `status` = 1 AND `category_id` = '$categoryId' "
                . "ORDER BY `id` DESC "
                . "LIMIT " . self::SHOW_BY_DEFAULT
                . " OFFSET " . $offset)->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } else return false;
    }


    /**
     * @param $id
     * @return mixed
     */
    public static function getProductById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM `product` WHERE `id`=' . $id)->fetch(PDO::FETCH_ASSOC);

            return $result;
        } else return false;
    }


    /**
     * @return array
     * Returns an array of recommended products
     */
    public static function getRecommendedProducts()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT `id`, `name`, `price`, `is_new` FROM `product` '
            . 'WHERE `status` = 1 AND `is_recommended` = 1 '
            . 'ORDER BY `id` DESC ')->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param $categoryId
     * @return array
     * Returns total products
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(`id`) AS `count` FROM `product` '
            . 'WHERE `status` = 1 AND `category_id` =' . $categoryId)->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

}