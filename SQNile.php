<?php
require_once 'DataBase.php';
class SQNile{
    use DataBase;
    public $conn;
    function  __construct(){
        try {
            if (func_num_args() > 4)
                throw new Exception('SQNile Exception: Argument Error');
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
            $this->conn = new PDO($this->driver.":host=$this->servername;dbname=$this->dbname", $this->username_database, $this->password_database);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(PDOException $e){echo $e->getMessage();}
        catch (Exception $e) {echo $e->getMessage();}
    }
    function setDatabaseInfo(){
        $this->conn = null;
        try {
            if (func_num_args() > 4)
                throw new Exception('SQNile Exception: Argument Error');
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
        catch(PDOException $e){echo $e->getMessage();}
        catch (Exception $e) {echo $e->getMessage();}
    }
    function getDatabaseInfo(){
        return ["servername"=>$this->servername,"database_name"=>$this->dbname,"username"=>$this->username_database,"password"=>$this->password_database,"driver"=>$this->driver];
    }
    function fetchAll(){
        try {
            if (func_num_args() > 2 || func_num_args() == 0)
                throw new Exception('SQNile Exception: Argument Error');
            $query = $this->conn->prepare(func_get_arg(0));
            switch(func_num_args()){
                case 1:
                    $query->execute();
                    break;
                case 2:
                    $query->execute(func_get_arg(1));
            }
            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            $result = $query->fetchAll();
            return $result;
        }
        catch(PDOException $e) {echo $e->getMessage();}
        catch (Exception $e) {echo $e->getMessage();}
    }
    function fetch(){
        try {
            if (func_num_args() > 2 || func_num_args() == 0)
                throw new Exception('SQNile Exception: Argument Error');
            switch (func_num_args()) {
                case 1:
                    $result = $this->fetchAll(func_get_arg(0));
                    break;
                case 2:
                    $result = $this->fetchAll(func_get_arg(0),func_get_arg(1));
            }
            if (isset($result[0])) {
                return $result[0];
            } else
                return $result;
        }
        catch(PDOException $e) {echo $e->getMessage();}
        catch (Exception $e) {echo $e->getMessage();}
    }
    function query(){
        try {
            if (func_num_args() > 2 || func_num_args() == 0)
                throw new Exception('SQNile Exception: Argument Error');
            $query = $this->conn->prepare(func_get_arg(0));
            switch(func_num_args()){
                case 1:
                $query->execute();
                break;
                case 2:
                $query->execute(func_get_arg(1));
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}
        catch (Exception $e) {echo $e->getMessage();}
    }
    function createTable($tableName,$columnInfo){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS`".$tableName."` ( ".$columnInfo." )";
            $this->conn->exec($sql);
        }catch(PDOException $e){echo $e->getMessage();}
    }
    function __destruct(){
        $this->conn = null;
    }
}