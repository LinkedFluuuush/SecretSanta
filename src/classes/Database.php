<?php

class Database{
    private static $instance;
    private $pdo;
    
    private function __construct(){
        $dbConf = Controller::$deps->conf->getConfig("Database");
        
        $pdo = new PDO("mysql:host=" . $dbConf->host . ";dbname=" . $dbConf->dbname,
            $dbConf->user, $dbConf->pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        $this->pdo = $pdo;
    }
    
    public static function getInstance(){
        if(Database::$instance == null){
            Database::$instance = new Database();
        }
        
        return Database::$instance;
    }
    
    public function __call($name, $arguments){
        if(is_string($arguments[0])){
            $sql = array_shift($arguments);
            
            $statement = $this->pdo->prepare($sql);

            if(isset($arguments[0])){
                
                $bindValues = array_shift($arguments);
                
                if(is_array($bindValues)){
                    foreach($bindValues as $key => $value){
                        $statement->bindValue($key, $value);
                    }
                }
            }
            
            $execReturn = $statement->execute();
            
            if ($execReturn === FALSE){
                handleDbError($name, $sql, $bindValues);
            } else {
                if(strpos($name, "get") === 0){
                    $property = lcfirst(substr($name, 3));
                    
                    if(method_exists($this, '__fetch'.$property)){
                        $fetchReturn = call_user_func_array(array($this, '__fetch'.$property), array($statement));
                        if($fetchReturn === FALSE){
                            handleDbError($name, $sql, $bindValues);
                        } else {
                            return $fetchReturn;
                        }
                    }
                } else {
                    if($name == "execute"){
                        return $execReturn;
                    }
                }
            }
        }
    }
    
    public function handleDbError($name, $sql, $bindValues){
        /** @var \Monolog\Logger $logger */
        $logger = Controller::$deps->logger;
        
        $logger->addError("Error in SQL execution", array(
            "Function" => $name,
            "Request" => $sql,
            "Params" => $bindValues,
            "SQL Error" => $this->pdo->errorInfo()
        ));
    }
    
    private function __fetchOne(PDOStatement $statement){
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    private function __fetchAssoc(PDOStatement $statement){
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    private function __fetchArray(PDOStatement $statement){
        return $statement->fetch(PDO::FETCH_NUM);
    }
    
    private function __fetchObject(PDOStatement $statement){
        return $statement->fetch(PDO::FETCH_OBJ);
    }
    
    private function __fetchAll(PDOStatement $statement){
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function prepare($sql, $bindValues = null){
        $statement = $this->pdo->prepare($sql);
        
        foreach($bindValues as $key => $value){
            $statement->bindValue($key, $value);
        }
    }
}