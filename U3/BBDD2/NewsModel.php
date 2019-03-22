<?php
require_once 'NewsDbDAO.class.php';

$db = new NewsDbDAO();

$news = $db->select(1);

//print_r($news);
$news->__toString();

