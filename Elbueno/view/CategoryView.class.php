<?php
class CategoryView {
    
    public function __construct() {

    }
//el display pinta generalmente. Le puedes pasar lo que quieras
    //plantilla + contenido
    public function display($template=NULL, $content=NULL) {
        include("view/menu/MainMenu.html");
        //include("view/menu/CategoryMenu.html");

        if (!empty($template)) {
            include($template);
        }
        //"hace echo de todo el fichero(para que lo entendamos)"
        include("view/form/MessageForm.php");
    }    

}
