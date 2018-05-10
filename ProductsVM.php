<?php

/**
 * View model for the featured products.
 *
 * @author jam
 * @version 180428
 */
class ProductsVM {

    public $featuredProductIds;
    public $errorMsg;
    public $products;
    public $product;
    public $category;
    private $productDAM;
    private $categoryDAM;

    public function __construct() {
        $this->productDAM = new ProductDAM();
        $this->categoryDAM = new CategoryDAM();
        $this->errorMsg = '';
        $this->featuredProductIds = array(1, 7, 9);
        $this->products = array();
        $this->product = '';
        $this->category = '';
    }

    public static function getFeaturedInstance() {
        $vm = new self();
        foreach ($vm->featuredProductIds as $productId) {
            $product = $vm->productDAM->readProduct($productId);

            // Add product to array
            $vm->products[] = $product;
        }
        return $vm;
    }

    public static function getCategoryInstance($deletedProductCategoryId = null) {
        $vm = new self();
        if ($deletedProductCategoryId === null) {
            $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($categoryId === null) {
                $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        } else {
            $categoryId = $deletedProductCategoryId;
        }
        if ($categoryId === null) {
            $categoryId = 1;
        }
        $vm->products = $vm->productDAM->readProductsByCategoryId($categoryId);
        $vm->category = $vm->categoryDAM->readCategory($categoryId);
        return $vm;
    }

    public static function getProductInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vm->product = $vm->productDAM->readProduct($productId);
        return $vm;
    }

    public static function getEditProductInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vm->product = $vm->productDAM->readProduct($productId);
        return $vm;
    }

    public static function getDeleteInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($productId == null) {
            $productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        $vm->productDAM->deleteProductById($productId);
        $vm->category = $vm->categoryDAM->readCategory($categoryId);
        return $vm;
    }

    public static function getAddEditInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_POST,'productId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($productId === null) {
            $productId = '';
        }
        $varArray = array('id' => $productId,
            'categoryId' => filter_input(INPUT_POST,'categoryId', FILTER_VALIDATE_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'productCode' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'listPrice' => filter_input(INPUT_POST,'price', FILTER_VALIDATE_FLOAT, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'discountPercent' => filter_input(INPUT_POST, 'discountPercent', FILTER_VALIDATE_FLOAT, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $vm->product = new Product($varArray);
        $vm->category = $vm->categoryDAM->readCategory($vm->product->categoryId);
        $vm->productDAM->writeProduct($vm->product);
        return $vm;
    }

}
