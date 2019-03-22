<?php
require_once "model/persist/ProductFileDAO.class.php";

class ProductModel {

    private $dataProduct;

    public function __construct() {
        // File
        //Coge una instancia
        $this->dataProduct= ProductFileDAO::getInstance();
    }

    /**
     * insert a product
     * @param $product Product object to insert
     * @return TRUE or FALSE
     */
    public function add($product):bool {
        $result=$this->dataProduct->add($product);
        
        if ($result==FALSE) {
            $_SESSION['error']=ProductMessage::ERR_DAO['insert'];
        }
        
        return $result;
    }

    /**
     * update a product
     * @param $product Product object to update
     * @return TRUE or FALSE
     */
    public function modify($product):bool {
        $result=$this->dataProduct->modify($product);
        
        if ($result==FALSE) {
            $_SESSION['error']=ProductMessage::ERR_DAO['update'];
        } 
        
        return $result;
    }

    /**
     * delete a product
     * @param $id string Product Id to delete
     * @return TRUE or FALSE
     */    
    public function delete($id):bool {
        $result=FALSE;
        
        $result=$this->dataProduct->delete($id);

        if ($result==FALSE) {
            $_SESSION['error']=CategoryMessage::ERR_DAO['delete'];
        } 
     
        return $result;
    }

    /**
     * select all products
     * @param void
     * @return array of Product objects or array void
     */    
    public function listAll():array {
        $result=array();
        //dataProduct instancia de la clase DAO
        $product=$this->dataProduct->listAll();
        
        
        $categoryModel = new CategoryModel();
        
        foreach ($product as $product){
            $category=$categoryModel->searchById($product->getCategory());
            
            if(isset($category)){
                
                $product->setCategory($category);
                
            }
            else{
                
                $product->setCategory(new Category);
                
            }
            
            array_push($result, $product);
        }
        
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
    
    /**
    * select a product by Id from file
    * @param $id string Product Id
    * @return Product object or NULL
    */
    public function listByCategory($id):array {
        
        $result=$this->dataProduct->listByCategory($id);
                
        return $result;
    }

    /**
    * select a product by Id from file
    * @param $id string Product Id
    * @return Product object or NULL
    */
    public function categoryInProduct($id):bool {
        
        $result=$this->dataProduct->categoryInProduct($id);
                
        return $result;
    }    
    
    public function listCategories(): array{
        
        $categoryModel = new CategoryModel();
        $result = $categoryModel->listAll();
        
        return $result;
    }

}