<?php
class Category {
    
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

}
