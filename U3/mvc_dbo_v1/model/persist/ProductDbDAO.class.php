<?php

require_once "model/persist/ConnectDb.class.php";

class ProductDbDAO {

    private static $instance = NULL; // instancia de la clase
    private $connect; // conexión actual

    public function __construct() {
        $this->connect = (new ConnectDb())->getConnection();
    }

    public static function getInstance(): ProductDbDAO {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function listAll(): array {
        $result = array();

        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $result;
        };

        try {
            $sql = <<<SQL
                SELECT id,name,price,description,category FROM product;
SQL;

            $stmt = $this->connect->query($sql); // devuelve los datos

            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');

            $result = $stmt->fetchAll();
            
            return $result;
            
        } catch (PDOException $e) {
 
            return $result;
        }
    }
    
    public function searchById($id){
        $product = NULL;
        
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $product;
        };
        
        try {
            $sql = <<<SQL
                SELECT id,name,price,description,category FROM product
                    WHERE id=:id;
SQL;
             $stml = $this->connect->prepare($sql);
             $stml->bindParam(":id", $id, PDO::PARAM_STR);
             $stml->execute();
             $stml->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');
             $product = $stml->fetch();
             return $product;
             
        } catch (Exception $ex) {
            return $product;
        }   
    }
    
    public function add($product): bool{
        $result = FALSE;
        
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $result;
        };
        
        try {
            $sql = <<<SQL
                    INSERT INTO product (id, name, price, description, category)
                    VALUES (:id, :name, :price, :description, :category);
SQL;
            $id = $product->getId();
            $name = $product->getName();
            $price = $product->getPrice();
            $description = $product->getDescription();
            $category = $product->getCategory();
            
            
            $stml = $this->connect->prepare($sql);
            $stml->bindParam(":id",$id , PDO::PARAM_INT);
            $stml->bindParam(":name", $name, PDO::PARAM_STR);
            $stml->bindParam(":price",$price , PDO::PARAM_STR);
            $stml->bindParam(":description",$description , PDO::PARAM_STR);
            $stml->bindParam(":category", $category, PDO::PARAM_STR);
            $stml->execute();
            $result = TRUE;
            return $result;
        } catch (Exception $ex) {
            return $result;
        }   
    }
    
    public function modify($product) : bool {
        $result = FALSE;
        
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $result;
        };
        
        try {
            $sql=<<<SQL
                    UPDATE product SET name=:name, price=:price, 
                        description=:description, category=:category 
                            WHERE id=:id;
SQL;
            $id = $product->getId();
            $name = $product->getName();
            $price = $product->getPrice();
            $description = $product->getDescription();
            $category = $product->getCategory();
            
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(":id",$id , PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":price",$price , PDO::PARAM_STR);
            $stmt->bindParam(":description",$description , PDO::PARAM_STR);
            $stmt->bindParam(":category", $category, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount()){
                $result = TRUE;
                return $result;
            } else {
                return $result;
            }
            
        } catch (Exception $ex) {
            return $result;
        }
    }

}
