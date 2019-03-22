<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>pdo_select</title>
    </head>
    <body>
        <?php
            include_once 'News.class.php';
            
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
                    // los nombres de los campos han de ser igual a los nombres de las propiedades de la clase
                    $sql=<<<SQL
                        SELECT id,title,DATE_FORMAT(pubdate,'%d/%m/%Y') pubDate,content,category,price FROM news ORDER BY pubdate DESC;
SQL;

                    $result=$conn->query($sql); // devuelve los datos
                    
                    printf("<p><ul>");

                    //while($row=$result->fetch(PDO::FETCH_NUM)) {
                        //printf("<li>%s > %s > %s > %s</li>", $row[2], $row[0], $row[1], $row[4]);
                    //while($row=$result->fetch(PDO::FETCH_ASSOC)) {
                        //printf("<li>%s > %s > %s > %s</li>", $row['pubdate'], $row['id'], $row['title'], $row['category']);
                    //while($row=$result->fetch(PDO::FETCH_BOTH)) {
                        //printf("<li>%s > %s > %s > %s</li>", $row['pubdate'], $row[0], $row['title'], $row[4]);
                    //while($row=$result->fetch(PDO::FETCH_OBJ)) {
                        //printf("<li>%s > %s > %s > %s</li>", $row->pubdate, $row->id, $row->title, $row->category);

                    // http://php.net/manual/es/pdo.constants.php
                    $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'News');
                    
                    //$result->fetchAll() para devolver todos los datos a la vez
                    while ($row=$result->fetch()) {
                        printf("<li>%s > %s > %s > %s > %s</li>",
                            $row->getPubDate(), 
                            $row->getId(),
                            $row->getTitle(),
                            $row->getCategory(),
                            $row->getPrice());
                    }

                    printf("</ul></p>");                    
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