<?php
interface ControllerInterface {
    
    public function processRequest();
    public function add();
    public function modify();
    public function delete();
    public function searchById();
    public function listAll();
    
}
