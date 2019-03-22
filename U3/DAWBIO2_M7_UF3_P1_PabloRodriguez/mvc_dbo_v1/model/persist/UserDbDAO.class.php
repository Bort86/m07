<?php
require_once "model/persist/ConnectDb.class.php";

/**
 * Métodos del DBDao: añadir, buscar, modificar y buscar por username
 * todos comparten una estructura: primero se intenta conectar a la database
 * luego construye la sentencia sql pertinente, la prepara, bindea valores en caso
 * de necesitarlo y la lanza; retorna booleanos o valores dependiendo del método
 * En cada método, se devuelven mensajes de error a la sesión en caso de cualquier 
 * incidencia (ya sea conexión a la db o un error en la ejecución de la sentencia
 * sql)
 *
 * @author Pablo Rodriguez
 */
class UserDbDAO  {
    
    private static $instance = NULL; 
    private $connect; 

    public function __construct() {
        $this->connect = (new ConnectDb())->getConnection();
    }


    public static function getInstance(): UserDbDAO {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function add($user): bool {
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return FALSE;
        };

        try {
            $sql = <<<SQL
                INSERT INTO user (username,password,age,role,active)
                    VALUES (:username,:password,:age,:role,:active);
SQL;

            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
            $stmt->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $stmt->bindValue(":age", $user->getAge(), PDO::PARAM_INT);
            $stmt->bindValue(":role", $user->getRole(), PDO::PARAM_STR);
            $stmt->bindValue(":active", $user->getActive(), PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return FALSE;
        }
        
    }

    public function listAll(): array {
        $result = array();

        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return $result;
        };

        try {
            $sql = <<<SQL
                SELECT username,password,age,role,active FROM user;
SQL;

            $stmt = $this->connect->query($sql); 

            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $result;
        }

        return $result;
    }

    public function modify($user): bool {
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return FALSE;
        };

        try {
            $sql = <<<SQL
                UPDATE user SET password=:password, age=:age, role=:role, active=:active
                    WHERE USERNAME=:username;
SQL;

            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $stmt->bindValue(":age", $user->getAge(), PDO::PARAM_INT);
            $stmt->bindValue(":role", $user->getRole(), PDO::PARAM_STR);
            $stmt->bindValue(":active", $user->getActive(), PDO::PARAM_INT);
            $stmt->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);

            $stmt->execute();
            
            if ($stmt->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            
            return FALSE;
        }
    }

    public function searchByUsername($username) {
        if ($this->connect == NULL) {
            $_SESSION['error'] = "Unable to connect to database";
            return NULL;
        };

        try {
            $sql = <<<SQL
                SELECT username,password,age,role,active FROM user WHERE username=:username;
SQL;

            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
                return $stmt->fetch();
            } else {
                return NULL;
            }
        } catch (PDOException $e) {
            return NULL;
        }
    }

}
