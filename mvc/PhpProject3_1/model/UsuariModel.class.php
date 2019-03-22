<?php

require_once "model/persist/UsuariFileDAO.class.php";

class UsuariModel {

    private $dataUsuari;

    public function __construct() {
        // File
        $this->dataUsuari = UsuariFileDAO::getInstance();

        
    }
    
    public function listUser(): array {
        
        $usuaris = $this->dataUsuari->listUser();
        
        return $usuaris;
    }

}
