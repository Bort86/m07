<?php
class Category implements JsonSerializable{
    
    private $id;
    private $name;
    private $productList; // array of Product objects

    public function __construct($id=NULL, $name=NULL) {
        $this->id=$id;
        $this->name=$name;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id=$id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name=$name;
    }

    public function getProductList() {
        return $this->productList; // array of Product objects
    }

    public function setProductList($productList) {
        $this->productList=$productList; // array of Product objects
    }

    public function __toString() {
        return sprintf("%s;%s\n", $this->id, $this->name); // array of Product objects is excluded
    }
    /*
    public function toJson(){
        $std = new stdClass();
            
        $std->id = $this->id;
        $std->name = $this->name;
        
        $std->productList=array();
        
        if (!empty($this->productList)) {
            foreach ($this->productList as $product) {
                array_push($std->productList, $product->toArray());  
            }
        }
        
        return json_encode($std, JSON_PRETTY_PRINT);
    }
    */
    
    public function jsonSerialize() {
        return [
            'id' =>$this->id,
            'name' => $this->name
        ];
    }
}
