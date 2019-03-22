<?php
//plantilla on carga els resultats i formularis. És el que volem mostrar
    session_start();

    //rutes de directoris
    $host = $_SERVER['HTTP_HOST']; // localhost
    $path = rtrim(dirname($_SERVER['PHP_SELF']), "/"); 
    $base = "http://" . $host . $path . "/";//directori del projecte
    //constants
    define("PATH_CSS", $base . "view/css/");
    define("PATH_IMG", $base . "view/img/");
    define("PATH_JS", $base . "view/js/");
    
    require_once "controller/MainController.class.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Institut Provençana</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="<?=PATH_CSS?>header.css">
        <link rel="stylesheet" href="<?=PATH_CSS?>body.css">
        <script src="<?=PATH_JS?>general-fn.js"></script>
    </head>
    <body>
        <div id="page">
            <header>
                <a href="http://www.ies-provensana.com"><img src="<?=PATH_IMG?>proven.jpg" alt="proven.jpg"></a>
                <h1>Institut Provençana</h1>
            </header>
            <?php
            //enviem tot el que volem aqui
            
                
                (new MainController())->processRequest();
                //es el mateix
                //$controlMain=new MainController();
                //$controlMain->processRequest();
            ?>
        </div>
    </body>
</html>