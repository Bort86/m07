<?php

require_once "controller/ControllerInterface.php";
require_once "view/ProductView.class.php";
require_once "model/ProductExtModel.class.php";
require_once "model/Product.class.php";
require_once "util/ProductMessage.class.php";
require_once "util/ProductFormValidation.php";

/**
 * Description of ProductExtController
 *
 * @author Pablo Rodriguez
 */
class ProductExtController implements ControllerInterface {

    private $view;
    private $model;

    public function __construct() {
        // carga la vista
        $this->view = new ProductView();

        // carga el modelo de datos
        $this->model = new ProductExtModel();
    }

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
            case "list_all":
                $this->listAll();
                break;
            case "search":
                $this->searchById();
                break;
            default:
                $this->view->display();
        }
    }

    public function listAll() {
        $products = $this->model->listAll();

        if (empty($_SESSION['error'])) {
            if (!empty($products)) { // array void or array of Category objects?
                $_SESSION['info'] = CategoryMessage::INF_FORM['found'];
            } else {
                $_SESSION['error'] = CategoryMessage::ERR_FORM['not_found'];
            }
        }

        $this->view->display("view/form/ProductList.php", $products);
    }

    public function add() {
        
    }

    public function delete() {
        
    }

    public function modify() {
        
    }

    public function searchById() {
        
    }

}
