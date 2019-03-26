<?php
require_once 'DataBase.php';
class SQNile{
    use DataBase;
    private $conn;
    function  __construct(){
        try {
            if (func_num_args() > 4)
                throw new Exception('Argument Error');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        switch (func_num_args()) {
            case 4:
                $this->password_database = func_get_arg(3);
            case 3:
                $this->username_database = func_get_arg(2);
            case 2:
                $this->servername = func_get_arg(1);
            case 1:
                $this->dbname = func_get_arg(0);
        }
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username_database, $this->password_database);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    function fetchAll($query,$array){
        try {
            $query = $this->conn->prepare($query);
            $query->execute($array);
            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            $result = $query->fetchAll();
            return $result;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    function fetch($query,$array){
       $result = $this->fetchAll($query,$array);
       if (isset($result[0])){
           return $result[0];
       }else
           return $result;
    }
    function query($query,$array){
        try{
            $query = $this->conn->prepare($query);
            $query->execute($array);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function createTable($tableName,$columnInfo){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS`".$tableName."` ( ".$columnInfo." )";
            $this->conn->exec($sql);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function __destruct(){
        $this->conn = null;
    }
}
