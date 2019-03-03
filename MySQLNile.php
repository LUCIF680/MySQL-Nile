<?php
require_once 'DataBase.php';
/*
How to use : -
First update your server information in DataBase.php file.

Created by Pratik Mazumdar(LUCIF680) haki version.
MySQL Nile is a PDO class extended, you can edit, use this API as you like. You can use this API commercial and non-commercial use.
*/
class MySQLNile implements DataBase{
/* inserting data without sql injection
$input variable will input any data you want to input should be in string
$table_coloum is the coloum name
$table_name is the name of the table you want to insert data into
  */
  public function insertData($input,$table_coloum,$table_name){
    //can input your server information with the help of DataBase.php
     $servername = MySQLNile::servername;
     $dbname = MySQLNile::dbname;
     $password_database = MySQLNile::password_database;
     $username_database = MySQLNile::username_database;
     $input = explode(",",$input);
     //converting "ram,shyam,raghu" to ":ram,:shyam,:raghu"
     $parameter_value = explode(",",$table_coloum);
     $table_coloum_value = "";
     $position=1;
     $i = 0;
       while($position){
           $table_coloum_value .= ":".$parameter_value[$i].",";
           $i++;
           $position++;
           $position= stripos($table_coloum,",",$position);
           if ($position==false)
               break;
       }
     // for removing that last ',' from string
     $table_coloum_value =  substr($table_coloum_value, 0, strlen($table_coloum_value) - 1);
     $parameter =  explode(",",$table_coloum_value);
     //Uploading DATA TO DATABASE
         try {
             $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_database, $password_database);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $sql = "INSERT INTO `".$table_name."` ($table_coloum)
                             VALUES ($table_coloum_value)"; //will be written in  ":ram,:shyam,:raghu"
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
     $servername = MySQLNile::servername;
     $dbname = MySQLNile::dbname;
     $password_database = MySQLNile::password_database;
     $username_database = MySQLNile::username_database;
     try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username_database  , $password_database);
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
In $table_coloums input your coloums name and their values
 */

 public function createTable($table_coloums,$table_name){
     $servername = MySQLNile::servername;
     $dbname = MySQLNile::dbname;
     $password_database = MySQLNile::password_database;
     $username_database = MySQLNile::username_database;
     try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username_database, $password_database);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = "CREATE TABLE IF NOT EXISTS`".$table_name."` ( ".$table_coloums." )";
         $conn->exec($sql);
     }catch(PDOException $e){
        echo $e->getMessage();
     }
     $conn = null;
 }
/*parameter will be the query you want to input*/
 public function fetch($string){
     $servername = MySQLNile::servername;
     $dbname = MySQLNile::dbname;
     $password_database = MySQLNile::password_database;
     $username_database = MySQLNile::username_database;
     try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username_database  , $password_database);
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
}
