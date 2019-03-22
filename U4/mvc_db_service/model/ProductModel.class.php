<?php

require_once "model/persist/ProductDbDAO.class.php";

class ProductModel {

    private $dataProduct;

    public function __construct() {

        $this->dataProduct = ProductDbDAO::getInstance();
    }

    public function listAll(): array {
        $result = array();
        //dataProduct instancia de la clase DAO
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

    public function listCategories(): array {

        $categoryModel = new CategoryModel();
        $result = $categoryModel->listAll();

        return $result;
    }

    /**
     * select a product by Id
     * @param $id string Product Id
     * @return Product object or NULL
     */
    public function searchById($id) {

        $product = $this->dataProduct->searchById($id);

        return $product;
    }

    public function add($product): bool {
        $result = $this->dataProduct->add($product);

        if ($result == FALSE) {
            $_SESSION['error'] = ProductMessage::ERR_DAO['insert'];
        }

        return $result;
    }

    public function categoryInProduct($id): bool {

        $result = $this->dataProduct->categoryInProduct($id);

        return $result;
    }

    public function delete($id): bool {
        $result = FALSE;

        $result = $this->dataProduct->delete($id);

        if ($result == FALSE) {
            $_SESSION['error'] = CategoryMessage::ERR_DAO['delete'];
        }

        return $result;
    }
    
    public function modify($product):bool {
        $result=$this->dataProduct->modify($product);
        
        if ($result==FALSE) {
            $_SESSION['error']=ProductMessage::ERR_DAO['update'];
        } 
        
        return $result;
    }

}
