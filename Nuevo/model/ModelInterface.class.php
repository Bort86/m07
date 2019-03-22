<?php
interface ModelInterface {

    public function add($object):bool;
    public function modify($object):bool;
    public function delete($id):bool;
    public function searchById($id);
    public function listAll():array;

}
