<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>mysqli_update</title>
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

            /*
            if ($conn->connect_error) {
                die("<p>Unable to connect to database:</p><p>" . $conn->connect_error . "</p>");
            }
            */
            
            if ($conn->connect_errno > 0) {
                printf("<p>Unable to connect to database:</p><p>%s</p>", $conn->connect_error);
            }
            else {
                printf("<p>Connected successfully</p>");
                
                /*
                SELECT id,title,DATE_FORMAT(pubdate,'%d/%m/%Y') pubdate,content,category 
                        FROM news WHERE id=?;
                                  */
                $sql_update=<<<SQL
                    UPDATE news SET title=? WHERE id=?;
SQL;
                $id="1";
                $title="Bort1";
               
                

                $stmt_update=$conn->prepare($sql_update);

                if (!$stmt_update) {
                    printf("<p>Error:</p><p>%s</p>", $conn->error);
                }
                else {
                    $stmt_update->bind_param("si", $title, $id);
                    $success=$stmt_update->execute(); // devuelve true o false

                    if (!$success) {
                        printf("<p>There was an error running the query:</p><p>%s</p>", $conn->error);                
                    }
                    else {
                        
                        print("<p>Todo ok</p>");
                     /*   printf("<p><ul>");
                        
                        
                        $result=$stmt->get_result(); // devuelve los datos
                        $row=$result->fetch_assoc();
                        
                        printf("<li>%s > %s > %s > %s</li>", 
                            $row['pubdate'], 
                            $row['id'], 
                            utf8_encode($row['title']), 
                            utf8_encode($row['category']));
                        
                        printf("</ul></p>");*/
                    }
                }

                $conn->close();
                printf("<p>Disconnected successfully</p>"); 
            }
        ?>
    </body>
</html>