<?php
class News {
    
    private $id;
    private $title;
    private $pubDate;
    private $content;
    private $category;
    
    public function __construct($id, $title, $pubDate, $content, $category) {
        $this->id=$id;
        $this->title=$title;
        $this->pubDate=$pubDate;
        $this->content=$content;
        $this->category=$category;
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
        $this->id=$id;
    }

    public function setTitle($title) {
        $this->title=$title;
    }

    public function setPubDate($pubDate) {
        $this->pubDate=$pubDate;
    }

    public function setContent($content) {
        $this->content=$content;
    }

    public function setCategory($category) {
        $this->category=$category;
    }

    public function __toString() {
        return printf("News {id=%d; title=%s; pubDate=%s; content=%s; category=%s}", 
            $this->id, $this->title, $this->pubDate, $this->content, $this->category);
    }
    
}