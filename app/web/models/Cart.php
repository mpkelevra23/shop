<?php

/**
 * Class Cart
 * Корзина
 */
class Cart
{

    /**
     * Добавление товара в корзину (сессию)
     * @param $id
     * @return int
     */
    public static function addProduct($id)
    {
        // Приводим $id к типу integer
        $id = intval($id);

        // Проверяем есть ли уже такой товар в корзине
        if (isset($_SESSION['products'][$id])) {
            // Если такой товар есть в корзине, но был добавлен еще раз, увеличим количество на 1
            $_SESSION['products'][$id]++;
        } // Если нет, добавляем id нового товара в корзину с количеством 1
        else $_SESSION['products'][$id] = 1;

        return self::countItems();
    }


    /**
     * Удаляет товар с указанным id из корзины
     * @param $id
     */
    public static function deleteProduct($id)
    {
        $id = intval($id);

        // Проверяем существет ли товар с указанным id
        if (isset($_SESSION['products'][$id])) {
            // Удаляем товар
            unset($_SESSION['products'][$id]);
        }
    }

    /**
     * Подсчет количество товаров в корзине (в сессии)
     * @return int
     */
    public static function countItems()
    {
        // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            return array_sum($_SESSION['products']);
        } else {
            // Если товаров нет, вернем 0
            return 0;
        }
    }

    /**
     * Возвращает массив с идентификаторами и количеством товаров в корзине
     * Если товаров нет, возвращает false;
     * @return bool|mixed
     */
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /**
     * Получаем общую стоимость переданных товаров
     * @param $products
     * @return float|int
     */
    public static function getTotalPrice($products)
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();

        // Подсчитываем общую стоимость
        $total = 0;

        if ($productsInCart) {
            // Если в корзине не пусто
            // Проходим по переданному в метод массиву товаров
            foreach ($products as $item) {
                // Находим общую стоимость: цена товара * количество товара
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    /**
     * Очищаем корзину
     */
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

}
