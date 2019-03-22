<?php
// File
require_once "model/persist/UserDbDAO.class.php";

/**
 * métodos del modelo: añadir, modificar,buscar por username y listar
 * todos funcionan de la misma manera: buscan su método en el dbDAO, si da error
 * printan el mensaje de error
 */
class UserModel {

    private $dataUser;

    public function __construct() {
        // File
        $this->dataUser=UserDbDAO::getInstance();        
    }

    public function add($user):bool {
        $result = $this->dataUser->add($user);

        if ($result == FALSE && empty($_SESSION['error'])) {
            $_SESSION['error'] = UserMessage::ERR_DAO['insert'];
        }

        return $result;
    }

    public function modify($user):bool {
        $result=$this->dataUser->modify($user);
        
        if ($result==FALSE) {
            $_SESSION['error']=UserMessage::ERR_DAO['update'];
        } 
        
        return $result;
    }

    public function searchByUsername($username) {
        $result=$this->dataUser->searchByUsername($username);
        
        return $result;
    }

    public function listAll():array {
        $users = $this->dataUser->listAll();

        return $users;
    }
    
}
