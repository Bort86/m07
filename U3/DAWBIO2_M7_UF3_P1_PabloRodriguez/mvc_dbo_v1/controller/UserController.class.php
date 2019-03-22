<?php

//require_once "controller/ControllerInterface.php";
require_once "view/UserView.class.php";
require_once "model/UserModel.class.php";
require_once "model/User.class.php";
require_once "util/UserMessage.class.php";
require_once "util/UserFormValidation.class.php";

class UserController {

    private $view;
    private $model;

    public function __construct() {
        $this->view = new UserView();

        $this->model = new UserModel();
    }
    /**
     * processRequest que controlará la página de acuerdo a las opciones que 
     * pulse el usuario, desde opciones de menú a botones de acciones
     */
    public function processRequest() {

        $request = NULL;
        $_SESSION['info'] = array();
        $_SESSION['error'] = array();

        if (filter_has_var(INPUT_POST, 'action')) {
            $request = filter_has_var(INPUT_POST, 'action') ? filter_input(INPUT_POST, 'action') : NULL;
        } else {
            $request = filter_has_var(INPUT_GET, 'option') ? filter_input(INPUT_GET, 'option') : NULL;
        }

        if (isset($_SESSION['username'])) {
            switch ($request) {
                case "logout":
                    $this->logout();
                    break;
                case "list_all":
                    $this->listAll();
                    break;
                case "form_add":
                    $this->formAdd();
                    break;
                case "add":
                    $this->add();
                    break;
                case "mod_del":
                    $this->formModify();
                    break;
                case "search":
                    $this->searchById();
                    break;
                case "modify":
                    $this->modify();
                    break;
                default:
                    $this->view->display();
            }
        } else {
            switch ($request) {
                case "login":
                    $this->login();
                    break;
                default:
                    $this->view->display("view/form/LoginForm.php");
            }
        }
    }
    
    /**
     * login de usuario
     */
    public function login() {
        $userValid = new User(trim(filter_input(INPUT_POST, 'username')), trim(filter_input(INPUT_POST, 'password')));

        $user = $this->model->searchByUsername($userValid->getUsername());

        if (!is_null($user) && ($userValid->getPassword() == $user->getPassword())) {
            session_start();
            $_SESSION['username'] = $user->getUsername();
        }
        header("Location: index.php");
    }
    
    /**
     * logout
     */
    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
    
    /**
     * método para printar el formulario de añadir usuarios
     */
    public function formAdd() {
        $this->view->display("view/form/UserFormAdd.php");
    }

    /**
     * método para añadir usuarios:
     * usa la clase de validación para confirmar que los datos introducidos en el
     * formulario son válidos, luego consulta si hay errores de sesión, si no los hay,
     * busca el user por el username; si no lo encuentra, intenta añadirlo; si lo 
     * encuentra printa mensaje de error; finalmente devuelve la vista del mismo
     * formulario
     */
    public function add() {
        $userValid = UserFormValidation::checkData(UserFormValidation::ADD_FIELDS);

        if (empty($_SESSION['error'])) {
            $user = $this->model->searchByUsername($userValid->getUsername());

            if (is_null($user)) {
                $result = $this->model->add($userValid);

                if ($result == TRUE) {
                    $_SESSION['info'] = UserMessage::INF_FORM['insert'];
                    $userValid = NULL;
                }
            } else {
                $_SESSION['error'] = UserMessage::ERR_FORM['exists_username'];
            }
        }

        $this->view->display("view/form/UserFormAdd.php", $userValid);
    }
    
    /**
     * método para printar el formulario de modificación y búsqueda de users
     */
    public function formModify() {
        $this->view->display("view/form/UserFormModify.php");
    }
    
    /**
     * método que busca por Id: reciclado de las prácticas anteriores
     * primero valida la info introducida del user a buscar
     * si no ha dado errores esa validación, busca el usuario por username
     */
    public function searchById() {
        $userValid=UserFormValidation::checkData(UserFormValidation::SEARCH_FIELDS);
        
        if (empty($_SESSION['error'])) {
            $user=$this->model->searchByUsername($userValid->getUsername());

            if (!is_null($user)) {
                $_SESSION['info']=UserMessage::INF_FORM['found'];
                $userValid=$user;
            }
            else {
                $_SESSION['error']=UserMessage::ERR_FORM['not_found'];
            }
        }
        
        $this->view->display("view/form/UserFormModify.php", $userValid);
    }

    /**
     * método para mostrar todos los users creados
     */
    public function listAll() {
        $users = $this->model->listAll();

        if (empty($_SESSION['error'])) {
            if (!empty($users)) {
                $_SESSION['info'] = UserMessage::INF_FORM['found'];
            } else {
                $_SESSION['error'] = UserMessage::ERR_FORM['not_found'];
            }
        }

        $this->view->display("view/form/UserList.php", $users);
    }

    /**
     * método para modificar usuario, prácticamente idéntico al añadir
     * 
     */
    public function modify() {
        $userValid=UserFormValidation::checkData(UserFormValidation::MODIFY_FIELDS);        
        
        if (empty($_SESSION['error'])) {
            $user=$this->model->searchByUsername($userValid->getUsername());

            if (!is_null($user)) {            
                $result=$this->model->modify($userValid);

                if ($result == TRUE) {
                    $_SESSION['info']=UserMessage::INF_FORM['update'];
                }
            }
            else {
                $_SESSION['error']=UserMessage::ERR_FORM['not_modify_username'];
            }
        }
        $this->view->display("view/form/UserFormModify.php", $userValid);
    }
}
