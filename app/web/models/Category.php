<?php

class Category
{

    /**
     * @return array
     * Returns an array of categories
     */
    public static function getCategoriesList()
    {

        $db = Db::getConnection();

        $result = $db->query('SELECT `id`, `name` FROM `category` '
            . 'ORDER BY `sort_order`')->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}