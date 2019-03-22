<?php

require_once "model/persist/ProductFileDAO.class.php";

//require_once "model/persist/CategoryDbDAO.class.php";

class ProductModel {

    private $dataProduct;

    public function __construct() {
        // File
        $this->dataProduct = ProductFileDAO::getInstance();

        // Database
        //$this->dataCategory=CategoryDbDAO::getInstance();
    }

    /**
     * insert a product
     * @param $category Category object to insert
     * @return TRUE or FALSE
     */
    public function add($product): bool {
        $result = $this->dataProduct->add($product);

        if ($result == FALSE) {
            $_SESSION['error'] = ProductMessage::ERR_DAO['insert'];
        }

        return $result;
    }

    /**
     * update a category
     * @param $category Category object to update
     * @return TRUE or FALSE
     */
    public function modify($product): bool {
        $result = $this->dataProduct->modify($product);

        if ($result == FALSE) {
            $_SESSION['error'] = ProductMessage::ERR_DAO['update'];
        }

        return $result;
    }

    /**
     * delete a product
     * @param $id string Product Id to delete
     * @return TRUE or FALSE
     */
    public function delete($id): bool {
        $result = $this->dataProduct->delete($id);

        if ($result == FALSE) {
            $_SESSION['error'] = ProductMessage::ERR_DAO['delete'];
        }

        return $result;
    }

    /**
     * select all categories
     * @param void
     * @return array of Category objects or array void
     */
    public function listAll(): array {

        $result = array();
        $products = $this->dataProduct->listAll();


        $categoryModel = new CategoryModel();

        foreach ($products as $product) {
            $category = $categoryModel->searchById($product->getCategory());

            if (isset($category)) {
                $product->setCategory($category);
            } else {
                $product->setCategory(new Category);
            }

            array_push($result, $product);
        }
        
        return $result;
    }

    

    /**
     * select a category by Id
     * @param $id string Category Id
     * @return Category object or NULL
     */
    public function searchById($id) {
        $product = $this->dataProduct->searchById($id);
        return $product;
    }

    public function listCategories(): array {
        $categoryModel = new CategoryModel();
        $result = $categoryModel->listAll();

        return $result;
    }

    public function listByCategory($id): array {
        $result = $this->dataProduct->listByCategory($id);

        return $result;
    }

    public function categoryInProduct($id): bool {
        $result = $this->dataProduct->categoryInProduct($id);

        return $result;
    }

}
