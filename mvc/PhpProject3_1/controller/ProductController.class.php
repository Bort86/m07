<?php

require_once "controller/ControllerInterface.php";
require_once "view/ProductView.class.php";
require_once "model/ProductModel.class.php";
require_once "model/Product.class.php";
require_once "util/ProductMessage.class.php";
require_once "util/ProductFormValidation.class.php";

class ProductController implements ControllerInterface {

    private $view;
    private $model;

    public function __construct() {
        // carga la vista
        $this->view = new ProductView();

        // carga el modelo de datos
        $this->model = new ProductModel();
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
            case "form_add":
                $this->formAdd();
                break;
            case "add":
                $this->add();
                break;
            case "form_modify":
                $this->formModify();
                break;
            case "search":
                $this->searchById();
                break;
            case "list_all":
                $this->listAll();
                break;
            case "modify":
                $this->modify();
                break;
            case "delete":
                $this->delete();
                break;
            default:
                $this->view->display();
        }
    }

    // carga el formulario de insertar categoría
    public function formAdd() {
        $cat = $this->model->listCategories();
        $this->view->display("view/form/ProductFormAdd.php", NULL, $cat);
    }

    // ejecuta la acción de insertar producto
    public function add() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::ADD_FIELDS);

        if (empty($_SESSION['error'])) {
            $product = $this->model->searchById($productValid->getId());

            if (is_null($product)) {
                $result = $this->model->add($productValid);

                if ($result == TRUE) {
                    $_SESSION['info'] = CategoryMessage::INF_FORM['insert'];
                    $productValid = NULL;
                }
            } else {
                $_SESSION['error'] = CategoryMessage::ERR_FORM['exists_id'];
            }
        }

        $cat = $this->model->listCategories();
        $this->view->display("view/form/ProductFormAdd.php", $productValid, $cat);
    }

    // ejecuta la acción de mostrar todos los productos
    public function listAll() {
        $products = $this->model->listAll();

        if (!empty($products)) { // array void or array of Product objects?
            $_SESSION['info'] = ProductMessage::INF_FORM['found'];
        } else {
            $_SESSION['error'] = ProductMessage::ERR_FORM['not_found'];
        }
        
        
        $this->view->display("view/form/ProductList.php", $products);
    }

    // ejecuta la acción de buscar producto por id de producto
    public function searchById() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::SEARCH_FIELDS);

        if (empty($_SESSION['error'])) {
            $product = $this->model->searchById($productValid->getId());

            if (!is_null($product)) { // is NULL or Category object?
                $_SESSION['info'] = ProductMessage::INF_FORM['found'];
                $productValid = $product;
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['not_found'];
            }
        }
        $cat = $this->model->listCategories();
        $this->view->display("view/form/ProductFormModify.php", $productValid, $cat);
    }

    // carga el formulario de modificar producto
    public function formModify() {
        $cat = $this->model->listCategories();
        $this->view->display("view/form/ProductFormModify.php", NULL, $cat);
    }

    // ejecuta la acción de modificar producto    
    public function modify() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::MODIFY_FIELDS);

        if (empty($_SESSION['error'])) {
            $product = $this->model->searchById($productValid->getId());

            if (!is_null($product)) {
                $result = $this->model->modify($productValid);

                if ($result == TRUE) {
                    $_SESSION['info'] = ProductMessage::INF_FORM['update'];
                }
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['not_exists_id'];
            }
        }

        $cat = $this->model->listCategories();
        $this->view->display("view/form/ProductFormModify.php", $productValid, $cat);
    }

    // ejecuta la acción de eliminar producto    
    public function delete() {
        $productValid = ProductFormValidation::checkData(ProductFormValidation::DELETE_FIELDS);

        if (empty($_SESSION['error'])) {
            $product = $this->model->searchById($productValid->getId());

            if (!is_null($product)) {
                $result = $this->model->delete($productValid->getId());

                if ($result == TRUE) {
                    $_SESSION['info'] = ProductMessage::INF_FORM['delete'];
                    $productValid = NULL;
                }
            } else {
                $_SESSION['error'] = ProductMessage::ERR_FORM['not_exists_id'];
            }
        }
        $cat = $this->model->listCategories();
        $this->view->display("view/form/ProductFormModify.php", $productValid, $cat);
    }

}
