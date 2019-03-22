<?php

require_once "model/persist/CategoryFileDAO.class.php";

//require_once "model/persist/CategoryDbDAO.class.php";

class CategoryModel {

    private $dataCategory;

    public function __construct() {
        // File
        //Coge una instancia
        $this->dataCategory = CategoryFileDAO::getInstance();

        // Database
        //$this->dataCategory=CategoryDbDAO::getInstance();
    }

    /**
     * insert a category
     * @param $category Category object to insert
     * @return TRUE or FALSE
     */
    public function add($category): bool {
        $result = $this->dataCategory->add($category);

        if ($result == FALSE) {
            $_SESSION['error'] = CategoryMessage::ERR_DAO['insert'];
        }

        return $result;
    }

    /**
     * update a category
     * @param $category Category object to update
     * @return TRUE or FALSE
     */
    public function modify($category): bool {
        $result = $this->dataCategory->modify($category);

        if ($result == FALSE) {
            $_SESSION['error'] = CategoryMessage::ERR_DAO['update'];
        }

        return $result;
    }

    /**
     * delete a category
     * @param $id string Category Id to delete
     * @return TRUE or FALSE
     */
    public function delete($id): bool {
        $result = FALSE;

        $productModel = new ProductModel();
        $categoryUsed = $productModel->categoryInProduct($id);

        if (!$categoryUsed) {
            $result = $this->dataCategory->delete($id);

            if ($result == FALSE) {
                $_SESSION['error'] = CategoryMessage::ERR_DAO['delete'];
            }
        } else {
            $_SESSION['error'] = CategoryMessage::ERR_DAO['used'];
        }

        return $result;
    }

    /**
     * select all categories
     * @param void
     * @return array of Category objects or array void
     */
    public function listAll(): array {
        //dataCategory instancia de la clase DAO
        $categories = $this->dataCategory->listAll();

        /* $productModel=new ProductModel();

          foreach ($categories as $category) {
          $products=$productModel->listByCategory($category->getId());
          $category->setProductList($products);
          } */

        return $categories;
    }

    /**
     * select a category by Id
     * @param $id string Category Id
     * @return Category object or NULL
     */
    public function searchById($id) {
        $category = $this->dataCategory->searchById($id);
        return $category;
    }

    /**
     * select products by Category Name
     * @param $categoryName string Category Name
     * @return array of Product objects or array void
     */
    public function listProducts($categoryName): array {
        $result = array();

        $categories = $this->dataCategory->searchByName($categoryName);

        if (!empty($categories)) { // array void or array of Category objects?
            $productModel = new ProductModel();

            foreach ($categories as $category) {
                $products = $productModel->listByCategory($category->getId());

                foreach ($products as $product) {
                    $product->setCategory($category);
                    array_push($result, $product);
                }
            }
        }

        sort($result);

        return $result;
    }

}
