<?php
class CategoryView {
    
    public function __construct() {

    }

    public function display($template=NULL, $content=NULL) {
        include("view/menu/MainMenu.html");
        //include("view/menu/CategoryMenu.html");

        if (!empty($template)) {
            include($template);
        }
        
        include("view/form/MessageForm.php");
    }    

}
