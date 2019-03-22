<?php
class SequenceView {
    
    public function __construct() {

    }

    public function display($template=NULL, $content=NULL, $file_data=NULL) {
        include("view/menu/MainMenu.html");
        //include("view/menu/SequenceMenu.html");

        if (!empty($template)) {
            include($template);
        }
        
        include("view/form/MessageForm.php");
    }    

}
