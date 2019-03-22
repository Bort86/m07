<?php
class ConnectDb {
    
    private static $hostaname='localhost';
    private static $username='provenusr';
    private static $password='Provenpass1.';
    private static $dbname='proven';
    
    public function __construct() {  
                      
    }
    
    public static function getConnection() {
        $conn=null;
        
        try {
            $conn=new mysqli(self::$hostaname, self::$username, self::$password, self::$dbname);            
        }
        catch (mysqli_sql_exception $e) {
            printf("<p>Error code:</p><p>%s</p>", $e->getCode());
            printf("<p>Error message:</p><p>%s</p>", $e->getMessage());
            printf("<p>Stack trace:</p><p>%s</p>", nl2br($e->getTraceAsString()));
        }
        
        return $conn;
    }
    
}