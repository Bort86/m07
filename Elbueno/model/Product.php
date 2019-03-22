<?php

class Product{
    
    private $id;
    private $name;
    private $price;
    private $description;
    private $category;
    
    function __construct($id, $name, $price, $description, $category) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->category = $category;
    }

    //getters and setters 
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPrice() {
        return $this->price;
    }

    function getDescription() {
        return $this->description;
    }

    function getCategory() {
        return $this->category;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    public function __toString() {
        return sprintf("%s;%s;%s;%s;%s\n", $this->id, $this->name, $this->price, $this->description, $this->category);
    }

}
