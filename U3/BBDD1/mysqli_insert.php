<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>mysqli_insert</title>
    </head>
    <body>
        <?php
            ini_set('display_errors', 'On');
            error_reporting(E_ALL | E_STRICT);
        
            $servername="localhost";
            $username="provenusr";
            $password="Provenpass1.";
            $dbname="proven";

            @$conn=new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_errno > 0) {
                printf("<p>Unable to connect to database:</p><p>%s</p>", $conn->connect_error);
            }
            else {
                printf("<p>Connected successfully</p>");
                
                $sql=<<<SQL
                    INSERT INTO news (title,pubdate,content,category) 
                        VALUES (?,STR_TO_DATE(?,'%d/%m/%Y'),?,?);
SQL;

                $title="Noticia";
                $pubdate=date("d/m/Y");
                $content="Contenido de la noticia";
                $category=utf8_decode("Política");

                $stmt=$conn->prepare($sql);

                if (!$stmt) {
                    printf("<p>Error:</p><p>%s</p>", $conn->error);
                }
                else {
                    $stmt->bind_param("ssss", $title, $pubdate, $content, $category);
                    $success=$stmt->execute(); // devuelve true o false

                    if (!$success) {
                        printf("<p>Error:</p><p>%s</p>", $conn->error);
                    }
                    else {
                        printf("<p>New records created successfully: %s</p>", $stmt->affected_rows);
                    }
                }

                $conn->close();
                printf("<p>Disconnected successfully</p>"); 
            }
        ?>
    </body>
</html>