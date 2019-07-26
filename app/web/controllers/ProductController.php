<?php

/**
 * Class ProductController
 * Товар
 */
class ProductController
{
    /**
     * Action для страницы просмотра товара
     * @param $productId
     * @return bool
     */
    public function actionView($productId)
    {
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();

        // Получаем инфомрацию о товаре
        $product = Product::getProductById($productId);

        // Подключаем вид
        require_once(ROOT . '/views/product/view.php');

        return true;
    }

}
