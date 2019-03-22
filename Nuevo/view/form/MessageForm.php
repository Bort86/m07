<div id="info">
    <?php
        if (is_array($_SESSION['info']) == TRUE) {
            foreach ($_SESSION['info'] as $info) {
                echo "<p>$info</p>";
            }
        }
        else {
            echo "<p>{$_SESSION['info']}</p>";          
        }
    ?>
</div>
<div id="error">
    <?php
        if (is_array($_SESSION['error']) == TRUE) {
            foreach ($_SESSION['error'] as $error) {
                echo "<p>$error</p>";
            }
        }
        else {
            echo "<p>{$_SESSION['error']}</p>";            
        }
    ?>
</div>
