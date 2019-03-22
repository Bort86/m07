<?php

class Product {

    private $id;
    private $name;
    private $price;
    private $description;
    private $category;

    public function __construct($id=NULL, $name=NULL, $price=NULL, $description=NULL, $category=NULL) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->category = $category;
    }

    //getters and setters 
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    public function __toString() {
        return sprintf("%s;%s;%s;%s;%s\n", $this->id, $this->name, $this->price, $this->description, $this->category);
    }

}
