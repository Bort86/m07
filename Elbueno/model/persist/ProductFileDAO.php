
<?php

require_once "model/ModelInterface.class.php";
require_once "model/persist/ConnectFile.class.php";

class ProductFileDAO implements ModelInterface {

    private static $instance = NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE = "model/resource/product.txt";

    public function __construct() {
        //hacemos la clase para que sea modular con las operaciones basicas 
        //el open,close file...
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
     * @param $id string Product Id to delete
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
     * obtain the list
     * @param void
     * @return array of Product objects or array void
     */
    public function listAll(): array {
        $result = array();

        // abre el fichero en modo read. Propiedad de categoryfileDAO. Read
        if ($this->connect->openFile("r")) {
            //mientras no sea end of file
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    //el explode te pone en un array los diferentes campos 
                    //separados por el delimitador que le pongas(;)
                    //implode es el contrario que explode --> de arraya string
                    $fields = explode(";", $line);
                    //creamos un nuevo producto
                    //dentro de Product.class
                    $product = new Product($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                    array_push($result, $product);
                    //equivalente array_push($result,new Product($fields[0], $fields[1]));
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

        // abre el fichero en modo read. Propiedad de categoryfileDAO. Read
        if ($this->connect->openFile("r")) {
            //mientras no sea end of file
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

    /**
     * select a product by Id from file
     * @param $id string Product Id
     * @return Product object or NULL
     */
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

    /**
     * select a product by Id from file
     * @param $id string Product Id
     * @return Product object or NULL
     */
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
