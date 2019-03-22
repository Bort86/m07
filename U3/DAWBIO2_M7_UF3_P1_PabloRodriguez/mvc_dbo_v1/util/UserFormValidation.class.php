<?php

/**
 * Clase de validación
 * En el caso de age, permite validar como ok si el age es vacío, porque es un
 * valor opcional.
 * Solo validamos que los campos string lo sean y que en caso de usarse el campo
 * age, que sea un string
 */
class UserFormValidation {

    const ADD_FIELDS = array('username', 'password', 'age', 'role', 'department');
    const MODIFY_FIELDS = array('username', 'password', 'age', 'role', 'active', 'department');
    const DELETE_FIELDS = array('username');
    const SEARCH_FIELDS = array('username');
    //const NUMERIC = "/[^0-9]/";
    //const ALPHABETIC = "/[^a-z A-Z]/";

    public static function checkData($fields) {
        $username = NULL;
        $password = NULL;
        $age = NULL;
        $role = NULL;
        $active = 1; //valor per defecte

        foreach ($fields as $field) {
            switch ($field) {
                case 'username':
                    
                    $username = trim(filter_input(INPUT_POST, 'username'));
                    $usernameValid = filter_var($username, FILTER_SANITIZE_STRING);
                    if (empty($username)) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['empty_username']);
                    } else if ($usernameValid == FALSE) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['invalid_username']);
                    }
                    break;
                case 'password':
                    $password = trim(filter_input(INPUT_POST, 'password')); 
                    $passwordValid = filter_var($password, FILTER_SANITIZE_STRING);
                    if (empty($password)) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['empty_password']);
                    } else if ($passwordValid == FALSE) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['invalid_password']);
                    }
                    break;
                case 'age':
                    $age = trim(filter_input(INPUT_POST, 'age'));
                    
                    if ($age !="") {
                        $ageValid = filter_var($age, FILTER_VALIDATE_INT);
                        if (is_numeric($ageValid) == FALSE) {
                            array_push($_SESSION['error'], UserMessage::ERR_FORM['not_a_number']);
                        }
                    }
                    break;
                
                case 'role':
                    $role = trim(filter_input(INPUT_POST, 'role'));
                    $roleValid = filter_var($role, FILTER_SANITIZE_STRING);

                    if ($roleValid == FALSE) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['invalid_role']);
                    }
                    break;
                case 'active':
                    $active = trim(filter_input(INPUT_POST, 'active'));
                    $activeValid = (filter_var($active, FILTER_VALIDATE_INT) || filter_var($active, FILTER_VALIDATE_INT) === 0);
                    if ($activeValid == FALSE) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['invalid_active']);
                    }
                    break;
                case 'xx':
                    $name = trim(filter_input(INPUT_POST, 'name'));
                    $nameValid = filter_var($name, FILTER_SANITIZE_STRING);
                    if ($nameValid == FALSE) {
                        array_push($_SESSION['error'], UserMessage::ERR_FORM['invalid_name']);
                    }
                    break;
            }
        }

        $user = new User($username, $password, $age, $role, $active);

        return $user;
    }

}
