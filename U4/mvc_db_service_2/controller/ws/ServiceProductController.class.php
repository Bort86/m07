<?php

require_once "model/ProductModel.class.php";
require_once "model/Product.class.php";
require_once "view/ProductView.class.php";
require_once "util/ProductMessage.class.php";
require_once "util/ProductFormValidation.php";

class ServiceProductController {

    private $model;
    private $view;

    public function __construct() {

        $this->model = new ProductModel();
        $this->view = new ProductView();
    }

    public function processRequest() {
        $_SESSION['error'] = array();

        $requestObject = $_REQUEST["object"];
        if ($requestObject != "product") {
            $this->view->display_json_message(400, 'URL no requesting product');
            return;
        }

        $http_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        switch ($http_method) {
            case "GET":
                $this->processGETRequest();  //list or searchById
                break;
           /* case "POST":
                $this->processPOSTRequest();  //add
                break;
            case "PUT":
                $this->processPUTRequest();  //modify
                break;
            case "DELETE":
                $this->processDELETERequest();  //delete
                break; */
            default:
        }
    }

    public function processGETRequest() {

        if (filter_has_var(INPUT_GET, 'id')) {
            // http://localhost/~slimbook/DAWBIO2_M7_UF4/mvc_db_service/category/1
            $this->searchById();
        } else {
            // http://localhost/~slimbook/DAWBIO2_M7_UF4/mvc_db_service/category/
            $this->listAll();
        }
    }

    public function listAll() {
        $products = $this->model->listAll();

        if (empty($_SESSION['error'])) {
            if (!empty($products)) { // array void or array of Category objects?
                $this->view->display_json($products);
            } else {
                // set response code - 404 Not Found
                $this->view->display_json_message(404, ProductMessage::ERR_FORM['not_found']);
            }
        } else {
            // set response code - (TODO - otros errores)
            $this->view->display_json_message(503, $_SESSION['error']);
        }
    }

    
    public function searchById() {
        $id = filter_input(INPUT_GET, 'id');
        
        ProductFormValidation::checkId($id);
        if (!empty($_SESSION['error'])) { //empty or invalid values  - 400 - Bad Request
            $this->view->display_json_message(400, $_SESSION['error']);
            return;
        }
        
        $product = $this->model->searchById($id);

        if (empty($_SESSION['error'])) {
            if (!is_null($product)) {
                $this->view->display_json($product);
            } else {
                // set response code - 404 Not Found
                $this->view->display_json_message(404, ProductMessage::ERR_FORM['not_found']);
            }
        } else {
            // set response code - (TODO - otros errores)
            $this->view->display_json_message(503, $_SESSION['error']);
        }
    }
    /*
    public function processPOSTRequest() {

        //valida from POST data
        $categoryValid = CategoryFormValidation::checkData(CategoryFormValidation::ADD_FIELDS);
        if (!empty($_SESSION['error'])) { //empty or invalid values  - 400 - Bad Request
            $this->view->display_json_message(400, $_SESSION['error']);
            return;
        }

        // check if category exists
        $category = $this->model->searchById($categoryValid->getId());
        if (!is_null($category)) {
            $this->view->display_json_message(400, CategoryMessage::ERR_FORM['exists_id']);
            return;
        }

        $added = $this->model->add($categoryValid);
        if ($added) {
            $this->view->display_json_message(201, CategoryMessage::INF_FORM['insert']);
        } else {
            $this->view->display_json_message(503, $_SESSION['error']);
        }
    }

    public function processDELETERequest() {
         //get URL parameters for DELETE   
        $id = filter_var($_REQUEST["id"]);
        
        CategoryFormValidation::checkId($id);
        if (!empty($_SESSION['error'])) { //empty or invalid values  - 400 - Bad Request
            $this->view->display_json_message(400, $_SESSION['error']);
            return;
        }
        
        $category = $this->model->searchById($id);
        if (is_null($category)) {
            $this->view->display_json_message(404, CategoryMessage::ERR_FORM['not_exists_id']);
            return;
        }
        
        $deleted = $this->model->delete($id);
        if ($deleted) {
            $this->view->display_json_message(200, CategoryMessage::INF_FORM['delete']);
        } else {
            $this->view->display_json_message(503, $_SESSION['error']);
        }
    }

    public function processPUTRequest() {
        // get PUT data   // x-www-form-urlencoded
        parse_str(file_get_contents("php://input"), $put_vars);

        //check data
        if (array_key_exists("id", $put_vars)) {
            CategoryFormValidation::checkId($put_vars["id"]);
        }
        if (array_key_exists("name", $put_vars)) {
            CategoryFormValidation::checkName($put_vars["name"]);
        }
        if (!empty($_SESSION['error'])) { //empty or invalid values  - 400 - Bad Request
            $this->view->display_json_message(400, $_SESSION['error']);
            return;
        }

        $categoryValid = new Category($put_vars["id"], $put_vars["name"]);
        // check if category exists
        $category = $this->model->searchById($categoryValid->getId());
        if (is_null($category)) { //error no existeix
            $this->view->display_json_message(404, CategoryMessage::ERR_FORM['not_exists_id']);
            return;
        }

        $modified = $this->model->modify($categoryValid);

        if ($modified) {
            $this->view->display_json_message(200, CategoryMessage::INF_FORM['update']);
        } else {
            $this->view->display_json_message(503, $_SESSION['error']);
        }
    } */

}
