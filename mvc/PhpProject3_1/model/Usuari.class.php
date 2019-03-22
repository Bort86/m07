<?php
class Usuari {
    
    //atributos
    private $username;
    private $password;
    private $age;
    private $role;
    private $active;
    
    
    //constructor con id, name y price obligatorios:
    public function __construct($username=NULL, $password=NULL, $age, $role=NULL, $active) {
        $this->username = $username;
        $this->password = $password;
        $this->age = $age;
        $this->role = $role;
        $this->active = $active;
    }

    //método to_string
    public function __toString() {
        return sprintf("%s;%s;%s;%s;%s\n", $this->id, $this->name, $this->price, $this->description, $this->category);
    }
    
    //getters n setters
    
    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getAge() {
        return $this->age;
    }

    public function getRole() {
        return $this->role;
    }

    public function getCategory() {
        return $this->active;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setActive($active) {
        $this->active = $active;
    }
 
}