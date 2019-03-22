<?php

require_once "model/ModelInterface.class.php";
require_once "model/persist/ConnectFile.class.php";

class ProductFileDAO implements ModelInterface {

    private static $instance = NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE = "model/resource/products.txt";

    public function __construct() {
        $this->connect = new ConnectFile(self::FILE);
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    public static function getInstance(): ProductFileDAO {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * insert a product in file
     * @param $product Product object to insert
     * @return TRUE or FALSE
     */
    public function add($product): bool {
        $result = FALSE;

        // abre el fichero en modo append
        if ($this->connect->openFile("a+")) {
            fputs($this->connect->getHandle(), $product->__toString());
            $this->connect->closeFile();
            $result = TRUE;
        }

        return $result;
    }

    /**
     * update a product in file
     * @param $product Product object to update
     * @return TRUE or FALSE
     */
    public function modify($product): bool {
        $result = FALSE;
        $fileData = array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);

                    if ($product->getId() == $fields[0]) {
                        array_push($fileData, $product->__toString());
                    } else {
                        array_push($fileData, $line . "\n");
                    }
                }
            }
            $this->connect->closeFile();
        }

        if ($this->connect->writeFile($fileData)) {
            $result = TRUE;
        }

        return $result;
    }

    /**
     * delete a product in file
     * @param $id string product Id to delete
     * @return TRUE or FALSE
     */
    public function delete($id): bool {
        $result = FALSE;
        $fileData = array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);

                    if ($id != $fields[0]) {
                        array_push($fileData, $line . "\n");
                    }
                }
            }
            $this->connect->closeFile();
        }

        if ($this->connect->writeFile($fileData)) {
            $result = TRUE;
        }

        return $result;
    }

    /**
     * select all products from file
     * @param void
     * @return array of products objects or array void
     */
    public function listAll(): array {
        $result = array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);
                    $product = new Product($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                    array_push($result, $product);
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }

    /**
     * select a product by Id from file
     * @param $id string Product Id
     * @return Product object or NULL
     */
    public function searchById($id) {
        $product = NULL;

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);

                    if ($id == $fields[0]) {
                        $product = new Product($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                        break;
                    }
                }
            }
            $this->connect->closeFile();
        }

        return $product;
    }

    public function listByCategory($id) {
        $result = array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);

                    if ($id == $fields[4]) {
                        $product = new Product($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                        array_push($result, $product);
                    }
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }

    public function categoryInProduct($id): bool {
        $result = FALSE;

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);

                    if ($id == $fields[4]) {
                        $result = TRUE;
                        break;
                    }
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }

}
