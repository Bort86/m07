<?php
require_once "model/ModelInterface.class.php";
require_once "model/persist/ConnectFile.class.php";

class CategoryFileDAO implements ModelInterface {

    private static $instance=NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE="model/resource/categories.txt";    
    
    public function __construct() {
        $this->connect=new ConnectFile(self::FILE);
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    public static function getInstance():CategoryFileDAO {
        if (is_null(self::$instance)) {
            self::$instance=new self();
        }
        return self::$instance;
    }

    /**
     * insert a category in file
     * @param $category Category object to insert
     * @return TRUE or FALSE
     */    
    public function add($category):bool {
        $result=FALSE;

        // abre el fichero en modo append
        if ($this->connect->openFile("a+")) {
            fputs($this->connect->getHandle(), $category->__toString());
            $this->connect->closeFile();
            $result=TRUE;
        }

        return $result;
    }

    /**
     * update a category in file
     * @param $category Category object to update
     * @return TRUE or FALSE
     */
    public function modify($category):bool {
         /*TODO*/
    }

    /**
     * delete a category in file
     * @param $id string Category Id to delete
     * @return TRUE or FALSE
     */    
    public function delete($id):bool {
         /*TODO*/
    }

    /**
     * select all categories from file
     * @param void
     * @return array of Category objects or array void
     */    
    public function listAll():array {
        $result=array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    $category=new Category($fields[0], $fields[1]);
                    array_push($result, $category);
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }    

    /**
    * select a category by Id from file
    * @param $id string Category Id
    * @return Category object or NULL
    */
    public function searchById($id) {
         /*TODO*/
    }
    
}
