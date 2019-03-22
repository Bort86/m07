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

    public function searchById($id) {
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

    public function add($product): bool {
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
            $stml->bindParam(":id", $id, PDO::PARAM_INT);
            $stml->bindParam(":name", $name, PDO::PARAM_STR);
            $stml->bindParam(":price", $price, PDO::PARAM_STR);
            $stml->bindParam(":description", $description, PDO::PARAM_STR);
            $stml->bindParam(":category", $category, PDO::PARAM_STR);
            $stml->execute();
            $result = TRUE;
            return $result;
        } catch (Exception $ex) {
            return $result;
        }
    }

    public function categoryInProduct($id): bool {
        $result = FALSE;

        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $result;
        };

        try {
            $sql = <<<SQL
               SELECT id,name,price,description,category FROM product
                    WHERE category=:category;
SQL;
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(":category", $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $result = TRUE;
                return $result;
            } else {
                return $result;
            }
        } catch (Exception $ex) {
            return $result;
        }
    }

    public function delete($id): bool {
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return FALSE;
        };

        try {
            $sql = <<<SQL
                    DELETE FROM product WHERE id=:id;
SQL;

            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute(); // devuelve TRUE o FALSE
            if ($stmt->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    
    public function modify($product): bool {
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return FALSE;
        };
        
        
        try {
            $sql = <<<SQL
                UPDATE product SET name=:name, price=:price, description=:description, category=:category WHERE ID=:id;
SQL;

            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $product->getId(), PDO::PARAM_INT);
            $stmt->bindValue(":name", $product->getName(), PDO::PARAM_STR);
            $stmt->bindValue(":price", $product->getPrice(), PDO::PARAM_STR);
            $stmt->bindValue(":description", $product->getDescription(), PDO::PARAM_STR);
            $stmt->bindValue(":category", $product->getCategory(), PDO::PARAM_STR);

            $stmt->execute(); // devuelve TRUE o FALSE
            
            if ($stmt->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            
            return FALSE;
        }
    }

}
