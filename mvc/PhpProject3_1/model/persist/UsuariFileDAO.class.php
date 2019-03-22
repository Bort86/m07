<?php

require_once "model/persist/ConnectFile.class.php";

class UsuariFileDAO {

    private static $instance = NULL; // instancia de la clase
    private $connect; // conexión actual

    const FILE = "model/resource/usuaris.txt";

    public function __construct() {
        $this->connect = new ConnectFile(self::FILE);
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    public static function getInstance(): UsuariFileDAO {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
        public function listUser(): array {
        $result = array();

        // abre el fichero en modo read
        if ($this->connect->openFile("r")) {
            while (!feof($this->connect->getHandle())) {
                $line = trim(fgets($this->connect->getHandle()));
                if ($line != "") {
                    $fields = explode(";", $line);
                    $usuari = new Usuari($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]);
                    array_push($result, $usuari);
                }
            }
            $this->connect->closeFile();
        }

        return $result;
    }

}
