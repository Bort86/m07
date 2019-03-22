<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>pdo_insert</title>
    </head>
    <body>
        <?php
            ini_set('display_errors', 'On');
            error_reporting(E_ALL | E_STRICT);
        
            $servername="localhost";
            $username="provenusr";
            $password="Provenpass1.";
            $dbname="proven";

            try {
                $conn=new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                printf("<p>Connected successfully</p>");
                
                try {
                    $sql=<<<SQL
                        DELETE FROM news WHERE id=:id;
SQL;

                    $id="3";
                    
                    $stmt=$conn->prepare($sql);
                    $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                    

                    $stmt->execute();

                    printf("<p>New records created successfully: %s</p>", $stmt->rowCount());
                }
                catch (PDOException $e) {
                    printf("<p>There was an error running the query: %s</p><p>%s</p>", $e->getCode(), $e->getMessage());                   
                }

                $conn=null;
                printf("<p>Disconnected successfully</p>");
            }
            catch (PDOException $e) {
                printf("<p>Unable to connect to database: %s</p><p>%s</p>", $e->getCode(), $e->getMessage());
            }
        ?>
    </body>
</html>