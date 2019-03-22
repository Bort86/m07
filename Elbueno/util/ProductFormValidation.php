<?php

class ProductFormValidation {

    //constantes que le pasamos lo que queremos que busque,tenga en cuenta
    const ADD_FIELDS = array('id', 'name', 'price', 'description', 'category');
    const MODIFY_FIELDS = array('id', 'name', 'price', 'descriptions', 'category');
    const DELETE_FIELDS = array('id');
    const SEARCH_FIELDS = array('id');
    const NUMERIC = "/[^0-9]/";
    const ALPHABETIC = "/[^a-z A-Z]/";
    const DECIMALS = "/^\d{0,2}(\.\d{1,2})?$/";
    const ALPHANUMERIC = "/[^A-Z a-z 0-9]/";

    public static function checkData($fields) {
        $id = NULL;
        $name = NULL;
        $price = NULL;
        $description = NULL;
        $category = NULL;

        foreach ($fields as $field) {
            switch ($field) {
                case 'id':
                    // filter_var retorna los datos filtrados o FALSE si el filtro falla
                    $id = trim(filter_input(INPUT_POST, 'id'));
                    $idValid = !preg_match(self::NUMERIC, $id);
                    if (empty($id)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_id']);
                    } else if ($idValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_id']);
                    }
                    break;
                case 'name':
                    $name = trim(filter_input(INPUT_POST, 'name'));
                    $nameValid = !preg_match(self::ALPHABETIC, $name);
                    if (empty($name)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_name']);
                    } else if ($nameValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_name']);
                    }
                    break;
                case 'price':
                    // filter_var retorna los datos filtrados o FALSE si el filtro falla
                    $price = trim(filter_input(INPUT_POST, 'price'));
                    $priceValid = !preg_match(self::DECIMALS, $price);
                    if (empty($price)) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['empty_price']);
                    } else if ($priceValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_price']);
                    }
                    break;
                case 'description':
                    $description = trim(filter_input(INPUT_POST, 'description'));
                    $descriptionValid = !preg_match(self::ALPHANUMERIC, $description);
                    if ($descriptionValid == FALSE) {
                        array_push($_SESSION['error'], ProductMessage::ERR_FORM['invalid_description']);
                    }
                    break;
                case 'category':
                    $category = trim(filter_input(INPUT_POST, 'category'));

                    break;
            }
        }

        $product = new Product($id, $name, $price, $description, $category);

        return $product;
    }

}
