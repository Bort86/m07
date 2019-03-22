<?php
    session_start();
    require_once "controller/ws/ServiceMainController.class.php";
    
    $controlService = new ServiceMainController();
    $controlService->processRequest();