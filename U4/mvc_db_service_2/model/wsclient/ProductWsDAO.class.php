<?php

require_once "model/ModelInterface.class.php";


class ProductWsDAO implements ModelInterface {
    // http://localhost/DAWBIO2_M7_UF4/mvc_db_service_v1/category/5
    //const URL_WS = "http://192.168.128.103/m07/UF4/Rest/"; Marc
    const URL_WS = "http://192.168.128.103/m07/UF4/Rest/"; 
    
    const HTTP_CODE_OK = 200;
    const HTTP_CODE_OK_INSERT = 201;
    const HTTP_CODE_BAD_REQUEST = 400;
    const HTTP_CODE_NOT_FOUND   = 404;
    const HTTP_CODE_SERVER_ERROR = 503;

    private static $instance = NULL; // instancia de la clase
    private $connect; // conexión actual

    public function __construct() {
        // TODO - add authentication, get token
    }

    // singleton: patrón de diseño que crea una instancia única
    // para proporcionar un punto global de acceso y controlar
    // el acceso único a los recursos físicos
    
    public static function getInstance(): ProductWsDAO {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
        public function listAll(): array {
        $products = array();

        $query_url = self::URL_WS."product/";
             
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  //importante!! para que no muestre resultado
        $result_json = curl_exec($curl);
        $http_code = curl_getinfo($curl , CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($http_code==self::HTTP_CODE_OK) {
            $products_json_array = json_decode($result_json,TRUE);       
            for($i = 0; $i < count($products_json_array); $i++) {
                array_push($products, new Category($products_json_array[$i]["id"],
                        $products_json_array[$i]["name"], $products_json_array[$i]["price"], 
                        $products_json_array[$i]["description"], $products_json_array[$i]["category"]));
            }
      } else { //obtenir missatge d'error
            $missatge_json = json_decode($result_json,TRUE);
            $_SESSION['error']=$missatge_json["message"];
        }

      return $products;
     
      

    }
    
    
    public function add($product): bool {
        //TODO - check valid token (JWT)
        $result=FALSE;
        
        $query_url = self::URL_WS."category/";

        $curl_post_data = array(
        'id' => $category->getId(),
        'name' => $category->getName()
        );
           
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query_url);
        curl_setopt($curl, CURLOPT_POST, TRUE); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  //importante!!

        $result_json = curl_exec($curl);
        $http_code = curl_getinfo($curl , CURLINFO_HTTP_CODE); 
        curl_close($curl);
        
        $missatge_json = json_decode($result_json,TRUE);
        if ($http_code==self::HTTP_CODE_OK_INSERT) { 
            $_SESSION['info'] = $missatge_json['message'];
            $result=TRUE;
        }
         else { //obtenir missatge d'error
            $_SESSION['error']=$missatge_json['message'];
        }
                       
        return $result;    
    }

    public function modify($category):bool {
        //TODO - check valid token (JWT)
        $result=FALSE;
        
        $query_url = self::URL_WS."category/";

        $curl_post_data = array(
        "id" => $category->getId(),
        "name" => $category->getName()
        );
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query_url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_post_data));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");        

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  //importante!!

        $result_json = curl_exec($curl);
        $http_code = curl_getinfo($curl , CURLINFO_HTTP_CODE); 
        curl_close($curl);
        
        $missatge_json = json_decode($result_json,TRUE);
        if ($http_code==self::HTTP_CODE_OK) {      
            $_SESSION['info'] = $missatge_json['message'];
            $result=TRUE;
        }
         else { //obtenir missatge d'error
            $_SESSION['error']=$missatge_json['message'];
        }
                       
        return $result;  
    }

    public function delete($id):bool {
         //TODO - check valid token (JWT)
        $result=FALSE;
        
        $query_url = self::URL_WS."category/".$id;
              
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query_url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  //importante!!

        $result_json = curl_exec($curl);
        $http_code = curl_getinfo($curl , CURLINFO_HTTP_CODE); 
        curl_close($curl);

        $missatge_json = json_decode($result_json,TRUE);
        if ($http_code==self::HTTP_CODE_OK) {       
            $_SESSION['info'] = $missatge_json['message'];
            $result=TRUE;
        }
         else { //obtenir missatge d'error
            $_SESSION['error']=$missatge_json['message'];
        }
                        
        return $result;
    }



    public function searchById($id) {
        $category=NULL;
        $query_url = self::URL_WS."category/".$id;
              
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  //importante!!
        $result_json = curl_exec($curl);
        $http_code = curl_getinfo($curl , CURLINFO_HTTP_CODE); //hace echo del json recibido!!!
        curl_close($curl);
        
        if ($http_code==self::HTTP_CODE_OK) {  //TODO - poner en constantes       
            $category_json = json_decode($result_json,TRUE);
            $category = new Category($category_json["id"],$category_json["name"]);
      } 
      else { //obtenir missatge d'error
            $missatge_json = json_decode($result_json,TRUE);
            $_SESSION['error']=$missatge_json["message"];
        } 
             
        return $category;
    }

}
