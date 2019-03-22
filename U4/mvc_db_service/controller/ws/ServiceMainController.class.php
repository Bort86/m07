<?php
require_once "controller/ws/ServiceCategoryController.class.php";
//require_once "controller/ServiceProductController.class.php";

class ServiceMainController {

    // carga la vista según la opción
    public function processRequest() {

        $requestObject= $_REQUEST["object"];
            //using $_REQUEST to include all http methods
        switch ($requestObject) {
            // categorías
            case "category":
                $controlServiceCategory=new ServiceCategoryController();
                $controlServiceCategory->processRequest();
                break;
            // productes
            case "product": //TODO
                //$controlServiceProduct=new ServiceProductController();
                //$controlServiceProduct->processRequest();
                break;            
            default: 
                $controlServiceCategory=new ServiceCategoryController();
                $controlServiceCategory->processRequest();
                break;
        }

    }
    
}
