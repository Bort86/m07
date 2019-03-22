<?php

require_once "view/UsuariView.class.php";
require_once "model/UsuariModel.class.php";
require_once "model/Usuari.class.php";
require_once "util/UsuariMessage.class.php";
require_once "util/UsuariFormValidation.class.php";

class UsuariController {

    private $view;
    private $model;

    public function __construct() {
        // carga la vista
        $this->view = new UsuariView();

        // carga el modelo de datos
        $this->model = new UsuariModel();
    }

    // carga la vista según la opción o ejecuta una acción específica
    public function processRequest() {

        $request = NULL;
        $_SESSION['info'] = array();
        $_SESSION['error'] = array();

        // recupera la acción de un formulario
        if (filter_has_var(INPUT_POST, 'action')) {
            $request = filter_has_var(INPUT_POST, 'action') ? filter_input(INPUT_POST, 'action') : NULL;
        }
        // recupera la opción de un menú
        else {
            $request = filter_has_var(INPUT_GET, 'option') ? filter_input(INPUT_GET, 'option') : NULL;
        }

        switch ($request) {
            case "list_user":
                $this->listUser();
                break;
            default:
                $this->view->display();
        }
    }
    
    public function listUser() {
        $usuaris = $this->model->listUser();

        if (!empty($usuaris)) { 
            $_SESSION['info'] = UsuariMessage::INF_FORM['found'];
        } else {
            $_SESSION['error'] = UsuariMessage::ERR_FORM['not_found'];
        }
        
        
        $this->view->display("view/form/UsuariList.php", $usuaris);
    }

}