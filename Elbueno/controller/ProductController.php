<?php
require_once "controller/ControllerInterface.php";
require_once "view/ProductView.class.php";
require_once "model/ProductModel.php";
require_once "model/Product.php";
require_once "util/ProductMessage.php";
require_once "util/ProductFormValidation.php";

class ProductController implements ControllerInterface {

    private $view;
    private $model;

    public function __construct() {
        // carga la vista
        $this->view=new ProductView();

        // carga el modelo de datos
        $this->model=new ProductModel();
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
            case "form_add":
                $this->formAdd();
                break;
            case "add":
                $this->add();
                break;
            case "mod_del":
                $this->formModify();
                break;
            case "list_all":
                $this->listAll();
                break;
            case "search":
                $this->searchById();
                break;
            case "delete":
                $this->delete();
                break;
            case "modify":
                $this->modify();
                break;
            default:
                $this->view->display();
        }
    }

    // carga el formulario de insertar categoría
    public function formAdd() {
        $categories = $this->model->listCategories();
        //se pasa null pq al principio se cargan en vacio
        $this->view->display("view/form/ProductFormAdd.php",NULL,$categories);
        
        
    }

    // ejecuta la acción de insertar categoría
    public function add() {
        $productValid=ProductFormValidation::checkData(ProductFormValidation::ADD_FIELDS);        
        
        if (empty($_SESSION['error'])) {
            $product=$this->model->searchById($productValid->getId());

            if (is_null($product)) {
                $result=$this->model->add($productValid);

                if ($result == TRUE) {
                    $_SESSION['info']=ProductMessage::INF_FORM['insert'];
                    $productValid=NULL;
                }
            }
            else {
                $_SESSION['error']=ProductMessage::ERR_FORM['exists_id'];          
            }
        }

        $categories= $this->model->ListCategories();
        $this->view->display("view/form/ProductFormAdd.php", $productValid,$categories);
    }

    // carga el formulario de modificar categoria
    public function formModify() {
        $categories=$this->model->listCategories();
        $this->view->display("view/form/ProductFormModify.php", NULL, $categories);    
    }    

    // ejecuta la acción de modificar categoría    
    public function modify() {
        //es static
        $productValid=ProductFormValidation::checkData(ProductFormValidation::MODIFY_FIELDS);        
        
        if (empty($_SESSION['error'])) {
            $product=$this->model->searchById($productValid->getId());

            if (!is_null($product)) {            
                $result=$this->model->modify($productValid);

                if ($result == TRUE) {
                    $_SESSION['info']=ProductMessage::INF_FORM['update'];
                }
            }
            else {
                $_SESSION['error']=ProductMessage::ERR_FORM['not_exists_id'];
            }
        }
        $categories= $this->model->ListCategories();
        $this->view->display("view/form/ProductFormModify.php", $productValid, $categories);        
    }

    // ejecuta la acción de eliminar categoría    
    public function delete() {
        $productValid=ProductFormValidation::checkData(ProductFormValidation::DELETE_FIELDS);
        
        if (empty($_SESSION['error'])) {
            $product=$this->model->searchById($productValid->getId());

            if (!is_null($product)) {            
                $result=$this->model->delete($productValid->getId());

                if ($result == TRUE) {
                    $_SESSION['info']=ProductMessage::INF_FORM['delete'];
                    $productValid=NULL;
                }
            }
            else {
                $_SESSION['error']=ProductMessage::ERR_FORM['not_exists_id'];
            }
        }
        $categories= $this->model->ListCategories();
        $this->view->display("view/form/ProductFormModify.php", $productValid,$categories);
    }

    // ejecuta la acción de mostrar todas las categorías
    public function listAll() {
        //va al model per fer una accio de recollir totes les dades
        //Devuelve un array de categorias
        $products=$this->model->listAll();
        
        if (!empty($products)) { // array void or array of Product objects?
            //::accedo a la constante de metodo static en ProductMessage.
            //En session se guarda toda la frase. found = key en ProductMessage
            $_SESSION['info']=ProductMessage::INF_FORM['found'];
        }
        else {
            $_SESSION['error']=ProductMessage::ERR_FORM['not_found'];
        }
        //vamos a la vista para visualizar, display(mostrar pantalla)
        //le paso la plantilla,le paso los datos
        $this->view->display("view/form/ProductList.php", $products);
    }

    // ejecuta la acción de buscar categoría por id de categoría
    public function searchById() {
        //es static
        $productValid=ProductFormValidation::checkData(ProductFormValidation::SEARCH_FIELDS);
        
        if (empty($_SESSION['error'])) {
            $product=$this->model->searchById($productValid->getId());

            if (!is_null($product)) { // is NULL or Product object?
                $_SESSION['info']=ProductMessage::INF_FORM['found'];
                $productValid=$product;
            }
            else {
                $_SESSION['error']=ProductMessage::ERR_FORM['not_found'];
            }
        }
        $categories=$this->model->listCategories();
        $this->view->display("view/form/ProductFormModify.php", $productValid,$categories);
    }    

    // carga el formulario de buscar productos por nombre de categoría
    public function formListProducts() {
        $this->view->display("view/form/ProductFormSearchProduct.php");
    }    
    
    // ejecuta la acción de buscar productos por nombre de categoría
    public function listProducts() {
        $name=trim(filter_input(INPUT_POST, 'name'));

        $result=NULL;
        if (!empty($name)) { // Category Name is void?
            $result=$this->model->listProducts($name);            

            if (!empty($result)) { // array void or array of Product objects?
                $_SESSION['info']="Data found"; 
            }
            else {
                $_SESSION['error']=ProductMessage::ERR_FORM['not_found'];
            }
            
            $this->view->display("view/form/ProductListProduct.php", $result);
        }
        else {
            $_SESSION['error']=ProductMessage::ERR_FORM['invalid_name'];
            
            $this->view->display("view/form/ProductFormSearchProduct.php", $result);
        }
    }
    
}
