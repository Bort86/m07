<?php
require_once 'ConnectDb.class.php';
require_once 'News.class.php';

class NewsDbDAO {
    
    private $connect; // conexión actual    
    
    public function __construct() {
        // http://php.net/manual/fa/function.mysqli-report.php
        mysqli_report(MYSQLI_REPORT_ALL);
        
        try {
            $dataSource=new ConnectDb();
            $this->connect=$dataSource->getConnection();
        }
        catch (mysqli_sql_exception $e) {
            printf("<p>Error code:</p><p>%s</p>", $e->getCode());
            printf("<p>Error message:</p><p>%s</p>", $e->getMessage());
            printf("<p>Stack trace:</p><p>%s</p>", nl2br($e->getTraceAsString()));
        }
    }

    public function select($id) {
        $news=null;
        
        $sql="SELECT * FROM news WHERE id=?;";   

        $query=$this->connect->prepare($sql);        
        $query->bind_param("i", $id);
        $stmt=$query->execute();
        
        if ($stmt) {
            $result=$query->get_result();
            $row=$result->fetch_assoc();
            $news=new News($row['id'], $row['title'], $row['pubdate'], $row['content'], $row['category']);            
        }
        
        return $news;
    }

    // TODO
    public function insert($news) {
        
    }

    // TODO
    public function update($news) {
        
    }    

    // TODO
    public function delete($id) {
        
    }
        
}