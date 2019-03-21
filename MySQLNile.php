<?php
require_once 'DataBase.php';
/*
How to use : -
Created by Pratik Mazumdar(LUCIF680) haki version.
MySQL Nile is a PDO class extended, you can edit, use this API as you like. You can use this API commercial and non-commercial use.
*/
class MySQLNile{
    use DataBase;
    //can input your server information with the help of constructor
    function  __construct($dbname = "", $servername = "",$username_database = "",$password_database = ""){
        try {
            if ($dbname === "" || $servername === "" || $username_database === "") {
                $error = 'Empty DataBase Information Error';
                throw new Exception($error);
            }
            $this->dbname = $dbname;
            $this->servername = $servername;
            $this->username_database = $username_database;
            $this->password_database = $password_database;
        }catch(Exception $e){
            $e->getMessage();
        }
    }
    /* inserting data without sql injection
    $input variable will input any data you want to input should be in string
    $columnName is the coloum name
    $table_name is the name of the table you want to insert data into
      */
    public function insertData($input,$columnName,$table_name){
        $input = explode(",",$input);
        //converting "ram,shyam,raghu" to ":ram,:shyam,:raghu"
        $parameter_value = explode(",",$columnName);
        $columnName_value = "";
        $position=1;
        $i = 0;
        while($position){
            $columnName_value .= ":".$parameter_value[$i].",";
            $i++;
            $position++;
            $position= stripos($columnName,",",$position);
            if ($position==false)
                break;
        }
        // for removing that last ',' from string
        $columnName_value =  substr($columnName_value, 0, strlen($columnName_value) - 1);
        $parameter =  explode(",",$columnName_value);
        //Uploading DATA TO DATABASE
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $username_database, $this->password_database);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `".$table_name."` ($columnName)
                             VALUES ($columnName_value)"; //will be written in  ":ram,:shyam,:raghu"
            $query =$conn->prepare($sql);
            for($i=0;$i<count($parameter_value);$i++)
                $query->bindParam($parameter[$i], $input[$i]);
            $query->execute();
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        $conn = null;
    }
    /* for any querry writing
    $query should be string*/
    public function query($query){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username_database  , $this->password_database);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "".$query;
            $query =$conn->prepare($sql);
            $query->execute();
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        $conn = null;
    }
//creating table
    /* parameters will be name of table
    In $columnNames input your coloums name and their values
     */
    public function createTable($columnNames,$table_name){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$username_database, $this->password_database);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE IF NOT EXISTS`".$table_name."` ( ".$columnNames." )";
            $conn->exec($sql);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $conn = null;
    }
    /*parameter will be the query you want to input*/
    public function fetch($string){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username_database  , $this->password_database);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = $conn->prepare("".$string);
            $query->execute();
            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            $result = $query->fetchAll();
            $conn = null;
            return $result;
        }catch(PDOException $e){
            $conn = null;
            return $e->getMessage();

        }
    }
    public function delete($where,$where_value,$table_name){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username_database  , $this->password_database);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `".$table_name."` WHERE `".$where."` = '".$where_value."'";
            $query =$conn->prepare($sql);
            $query->execute();
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        $conn = null;
    }
}

