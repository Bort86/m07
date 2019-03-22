<?php
require_once "controller/ControllerInterface.php";
require_once "view/CategoryView.class.php";
require_once "model/CategoryModel.class.php";
require_once "model/Category.class.php";
require_once "util/CategoryMessage.class.php";
require_once "util/CategoryFormValidation.class.php";

class CategoryController implements ControllerInterface {

    private $view;
    private $model;

    public function __construct() {
        // carga la vista
        $this->view=new CategoryView();

        // carga el modelo de datos
        $this->model=new CategoryModel();
    }

    // carga la vista según la opción o ejecuta una acción específica
    public function processRequest() {
        
        $request=NULL;
        $_SESSION['info']=array();
        $_SESSION['error']=array();
        
        // recupera la acción de un formulario
        if (filter_has_var(INPUT_POST, 'action')) {
            $request=filter_has_var(INPUT_POST, 'action')?filter_input(INPUT_POST, 'action'):NULL;
        }
        // recupera la opción de un menú
        else {
            $request=filter_has_var(INPUT_GET, 'option')?filter_input(INPUT_GET, 'option'):NULL;
        }
        
        switch ($request) {
            case "form_add": // el botón de reset en el formulario de insertar categoría entra en este caso
                $this->formAdd();
                break;
            case "add":
                $this->add();
                break;
            case "list_all":
                $this->listAll();
                break;
            default:
                $this->view->display();
        }
    }

    // carga el formulario de insertar categoría
    public function formAdd() {
        $this->view->display("view/form/CategoryFormAdd.php");
    }

    // ejecuta la acción de insertar categoría
    public function add() {
        $categoryValid=CategoryFormValidation::checkData(CategoryFormValidation::ADD_FIELDS);        
        
        if (empty($_SESSION['error'])) {
            $category=$this->model->searchById($categoryValid->getId());

            if (is_null($category)) {
                $result=$this->model->add($categoryValid);

                if ($result == TRUE) {
                    $_SESSION['info']=CategoryMessage::INF_FORM['insert'];
                    $categoryValid=NULL;
                }
            }
            else {
                $_SESSION['error']=CategoryMessage::ERR_FORM['exists_id'];          
            }
        }

        $this->view->display("view/form/CategoryFormAdd.php", $categoryValid);
    }

    // ejecuta la acción de mostrar todas las categorías
    public function listAll() {
        $categories=$this->model->listAll();

        if (empty($_SESSION['error'])) {
            if (!empty($categories)) { // array void or array of Category objects?
                $_SESSION['info']=CategoryMessage::INF_FORM['found'];
            }
            else {
                $_SESSION['error']=CategoryMessage::ERR_FORM['not_found'];
            }
        }
        
        $this->view->display("view/form/CategoryList.php", $categories);
    }
    
    // ejecuta la acción de eliminar categoría 
    public function delete() {
        /*TODO*/
    }

    // ejecuta la acción de modificar categoría 
    public function modify() {
        /*TODO*/
    }

    // ejecuta la acción de buscar categoría por id de categoría
    public function searchById() {
        /*TODO*/
    }


}
