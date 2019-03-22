<?php
require_once "controller/ControllerInterface.php";
require_once "view/UserView.class.php";
require_once "model/UserModel.class.php";
require_once "model/User.class.php";
require_once "util/UserMessage.class.php";

class UserController implements ControllerInterface{

    private $view;
    private $model;

    public function __construct() {
        $this->view=new UserView();            
        
        $this->model=new UserModel();
    }

    public function processRequest() {
        
        $request=NULL;
        $_SESSION['info']=array();
        $_SESSION['error']=array();
        
        if (filter_has_var(INPUT_POST, 'action')) {
            $request=filter_has_var(INPUT_POST, 'action')?filter_input(INPUT_POST, 'action'):NULL;
        }
        else {
            $request=filter_has_var(INPUT_GET, 'option')?filter_input(INPUT_GET, 'option'):NULL;
        }        
        
        if (isset($_SESSION['username'])) {
            switch ($request) {
                case "logout":
                    $this->logout();
                    break;

                default:
                    $this->view->display();
            }
        }
        else {
            switch ($request) {
                case "login":
                    $this->login();
                    break;
                default:
                    $this->view->display("view/form/LoginForm.php");
            }            
        }
        
    }

    public function login() {
        $userValid=new User(trim(filter_input(INPUT_POST, 'username')), 
                       trim(filter_input(INPUT_POST, 'password')));

        $user=$this->model->searchByUsername($userValid->getUsername());
        
        if (!is_null($user) && ($userValid->getPassword() == $user->getPassword())) {
            session_start();
            $_SESSION['username']=$user->getUsername();
        }
        header("Location: index.php");
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }  
    
    
    public function add() {
        /*TODO */
    }

    public function delete() {
        /*TODO */
    }

    public function listAll() {
        /*TODO */
    }

    public function modify() {
        /*TODO */
    }

    public function searchById() {
        /*TODO */
    }

}
