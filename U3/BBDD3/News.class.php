<?php

class News {

    private $id;
    private $title;
    private $pubDate;
    private $content;
    private $category;
    private $price;

    //El contructor de la clase hay que inicializarla con parámetros nulls porque el fetch mode la inicia
    //pero no le pasa parámetros:
    //$result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'News');
    public function __construct($id = null, $title = null, $pubDate = null, $content = null, $category = null, $price = null) {
        $this->id = $id;
        $this->title = $title;
        $this->pubDate = $pubDate;
        $this->content = $content;
        $this->category = $category;
        $this->price = $price;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getPubDate() {
        return $this->pubDate;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setPubDate($pubDate) {
        $this->pubDate = $pubDate;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function __toString() {
        return printf("News {id=%d; title=%s; pubDate=%s; content=%s; category=%s; price=%s}", $this->id, $this->title, $this->pubDate, $this->content, $this->category, $this->price);
    }

}
