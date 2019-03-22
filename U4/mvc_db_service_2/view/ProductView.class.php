<?php

class ProductView {

    public function __construct() {
        
    }

    public function display($template = NULL, $content = NULL, $categories = NULL) {
        include("view/menu/MainMenu.html");


        if (!empty($template)) {
            include($template);
        }

        include("view/form/MessageForm.php");
    }

    private function in_accept_header($mime) {
        //check Accept HTTP Header
        $headerStringValue = filter_input(INPUT_SERVER, 'HTTP_ACCEPT');
        //exemple firefox: 
        //text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8Array
        $acceptMIME = explode(",", $headerStringValue);
        foreach ($acceptMIME as $mimeandquality) {
            $mimeandquality_array = explode(";", $mimeandquality);
            if (in_array($mime, $mimeandquality_array)) {
                return TRUE;
            };
        }
        return FALSE;
    }

    public function display_json($content = NULL) {
        //check Accept HTTP headers
        if (!$this->in_accept_header("application/json") &&
                $this->in_accept_header("application/xml")) {
            $this->display_xml($content);
            return;
        }
        // required headers
        //header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // set response code - 200 OK
        http_response_code(200);
        // show categories data in json format
        echo json_encode($content);
    }

    public function display_json_message($responseCode = NULL, $message = NULL) {
        //check Accept HTTP headers 
        if (!$this->in_accept_header("application/json") &&
                $this->in_accept_header("application/xml")) {
            $this->display_xml_message($responseCode, $message);
            return;
        }
        // required headers
        //header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // set HTTP response code
        http_response_code($responseCode);

        echo json_encode(
                array("message" => $message)
        );
    }
    
    public function display_xml($content = NULL) {
        // required headers
        //header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/xml; charset=UTF-8");

        // set response code - 200 OK
        http_response_code(200);
        
        // show categories data in XML format
        if (is_array($content)) {
            $xml = new SimpleXMLElement('<products/>');
            foreach ($content as $product) {
                $xml_categ_element = $xml->addChild("product");
                $xml_categ_element->addChild("id", $product->getId());
                $xml_categ_element->addChild("name", $product->getName());
                $xml_categ_element->addChild("price", $product->getPrice());
                $xml_categ_element->addChild("description", $product->getDescription());
                $xml_categ_element->addChild("category", $product->getCategory());
            }
        } else {
            $xml = new SimpleXMLElement('<product/>');
            if ($content instanceof Product) {
                $xml->addChild("id", $content->getId());
                $xml->addChild("name", $content->getName());
                $xml->addChild("price", $content->getPrice());
                $xml->addChild("description", $content->getDescription());
                $xml->addChild("category", $content->getCategory());
            }
        }
        echo $xml->asXML();
    }

    public function display_xml_message($responseCode = NULL, $message = NULL) {
        // required headers
        //header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/xml; charset=UTF-8");

        // set response code - 200 OK
        http_response_code($responseCode);
        if (!is_array($message)) {
            echo "<message>$message</message>";
        }
        else {
            $xml = new SimpleXMLElement('<messages/>');
            foreach ($message as $error_message) {
                $xml_element = $xml->addChild("error",$error_message);
            } 
            echo $xml->asXML();
        }
    }

}
