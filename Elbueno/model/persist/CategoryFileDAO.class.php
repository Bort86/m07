<?php
require_once "model/ModelInterface.class.php";
require_once "model/persist/ConnectFile.class.php";

class CategoryFileDAO implements ModelInterface {

    private static $instance=NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE="model/resource/categories.txt";    
    
    public function __construct() {
        //hacemos la clase para que sea modular con las operaciones basicas 
        //el open,close file...
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
        $result=FALSE;
        $fileData=array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    
                    if ($category->getId() == $fields[0]) {
                        array_push($fileData, $category->__toString());
                    }
                    else {
                        array_push($fileData, $line . "\n");                        
                    }
                }
            }
            $this->connect->closeFile();            
        }

        if ($this->connect->writeFile($fileData)) {
            $result=TRUE;
        }
        
        return $result;
    }

    /**
     * delete a category in file
     * @param $id string Category Id to delete
     * @return TRUE or FALSE
     */    
    public function delete($id):bool {
        $result=FALSE;
        $fileData=array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    
                    if ($id != $fields[0]) {
                        array_push($fileData, $line . "\n");                        
                    }
                }
            }
            $this->connect->closeFile();            
        }

        if ($this->connect->writeFile($fileData)) {
            $result=TRUE;
        }
        
        return $result;
    }

    /**
     * select all categories from file 
     * obtiene la lista
     * @param void
     * @return array of Category objects or array void
     */    
    public function listAll():array {
        $result=array();

        // abre el fichero en modo read. Propiedad de categoryfileDAO. Read
        if ($this->connect->openFile("r")) {
            //mientras no sea end of file
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    //el explode te pone en un array los diferentes campos 
                    //separados por el delimitador que le pongas(;)
                    //implode es el contrario que explode --> de arraya string
                    $fields=explode(";", $line);
                    //creamos una nueva categoria
                    //dentro de Category.class
                    $category=new Category($fields[0], $fields[1]);
                    array_push($result, $category);
                    //equivalente array_push($result,new Category($fields[0], $fields[1]));
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
        $category=NULL;

        // abre el fichero en modo read. Propiedad de categoryfileDAO. Read
        if ($this->connect->openFile("r")) {
            //mientras no sea end of file
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    
                    $fields=explode(";", $line);
                    
                    if($id==$fields[0]){
                        $category=new Category($fields[0], $fields[1]);
                        break;
                    }
                    
                }
            }
            $this->connect->closeFile();
        }

        return $category;
    }
    
    
    /**
    * select a category by Id from file
    * @param $id string Category Id
    * @return Category object or NULL
    */
    public function searchByName($name) {
        $result=array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while(!feof($this->connect->getHandle())) {
                $line=trim(fgets($this->connect->getHandle()));
                if ($line!="") {
                    $fields=explode(";", $line);
                    
                    if (is_numeric(strpos(strtolower($fields[1]), strtolower($name)))) {
                        $category=new Category($fields[0], $fields[1]);
                        array_push($result, $category);
                    }      
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }

}
