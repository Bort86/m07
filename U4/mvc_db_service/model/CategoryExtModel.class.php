<?php
// File
//require_once "model/persist/CategoryFileDAO.class.php";

// Database
//require_once "model/persist/CategoryDbDAO.class.php";

//WS
require_once "model/wsclient/CategoryWsDAO.class.php";

class CategoryExtModel {

    private $dataCategory;

    public function __construct() {
        // File
        //$this->dataCategory=CategoryFileDAO::getInstance();
        
        // Database
        //$this->dataCategory=CategoryDbDAO::getInstance();
        
        // WS - TODO - authenticacion using JWT (JSON Token)
        $this->dataCategory=CategoryWsDAO::getInstance();
    }

    /**
     * insert a category
     * @param $category Category object to insert
     * @return TRUE or FALSE
     */
    public function add($category):bool {
        $result=$this->dataCategory->add($category);
        
        if ($result==FALSE && empty($_SESSION['error'])) {
            $_SESSION['error']=CategoryMessage::ERR_DAO['insert'];
        }
        
        return $result;
    }

    /**
     * update a category
     * @param $category Category object to update
     * @return TRUE or FALSE
     */
    public function modify($category):bool {
        $result=$this->dataCategory->modify($category);
        
        if ($result==FALSE && empty($_SESSION['error'])) {
            $_SESSION['error']=CategoryMessage::ERR_DAO['update'];
        } 
        
        return $result;
    }

    /**
     * delete a category
     * @param $id string Category Id to delete
     * @return TRUE or FALSE
     */    
    public function delete($id):bool {
        $result=FALSE;

        //TODO product part
        //$productModel=new ProductModel();
        //$categoryUsed=$productModel->categoryInProduct($id);
        $categoryUsed = FALSE;
        
        
        if (!$categoryUsed) {
            $result=$this->dataCategory->delete($id);
            
            if ($result==FALSE && empty($_SESSION['error'])) {
                $_SESSION['error']=CategoryMessage::ERR_DAO['delete'];
            } 
        }
        else {
            $_SESSION['error']=CategoryMessage::ERR_DAO['used'];
        }
        
        return $result;
    }

    /**
     * select all categories
     * @param void
     * @return array of Category objects or array void
     */    
    public function listAll():array {
        $categories=$this->dataCategory->listAll();
        
        return $categories;
    }

    /**
    * select a category by Id
    * @param $id string Category Id
    * @return Category object or NULL
    */
    public function searchById($id) {
        $result=$this->dataCategory->searchById($id);
                
        return $result;
    }    
    
}
