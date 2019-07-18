# SQNile
SQNile is a simple but powerful API for writing queries. Which Uses the PDO and save from SQL Injection.

## Getting Started
Download the files from [here](https://lucif680.github.io/SQNile/sqnile.rar). Paste both files to the Project Folder.
```sh
require_once 'your_location/SQNile.php';
```
## Before Use
The fastest way to set the database information is to change the value of variables in Database.php file.
![database](https://lucif680.github.io/SQNile/database.png)
## Methods
#### Constructor
Should be used if you have set all the values of database into Database.php
```sh
$query = new SQNile;
```
Set values from constructor
```sh
$query = new SQNile('database_name','servername','username_database','password_database');
```
Or you can set values to Database.php and then change values as per your need, in this example we change the database_name.
```sh
$query = new SQNile('database_name');
```
#### setDatabaseInfo()
It changes the database info. This example changes the database name from name_one to name_two
```sh
$query = new SQNlie('name_one');
/*
Your codes goes here
*/

$query->setDatabaseInfo('name_two');
/*
Your other part of code
*/
```

#### getDatabaseInfo()
Get the database info.
```sh
$query->getDatabaseInfo();
```

#### fetchAll()
Fetch all required data from Database.
```sh
$query->fetchAll('SELECT * FROM user WHERE name=ISHA');
```
Result we get
```sh
Array ( 
[0] => Array ([id] => 1 [name] => ISHA [email] => xyz@protonmail.com)
[1] => Array([id] => 7 [name] => ISHA [email] => xyz@gmail.com)
)
```
Or write dynamically
```sh
$query->fetchAll(
'SELECT * FROM user WHERE name= ? AND paiduser = ?',
['ISHA' , 'true']
);
```

#### fetch()
Fetch the first element from Database.
```sh
$query->fetch('SELECT * FROM user WHERE name=ISHA');
```
Result we get
```sh
Array([id] => 1 [name] => ISHA [email] => xyz@protonmail.com)
```
Or write dynamically
```sh
$query->fetch(
'SELECT * FROM user WHERE name= ? AND paiduser = ?',
['ISHA' , 'true']
);
```
#### createTable()
This method requires two parameters.This method can welcome SQLInjection and should be used with caution.
Provide table name and column name manually.
```sh
$query->createTable(
'tableNmae', 
    "column1 datatype,
    column2 datatype,
    column3 datatype,";
```
#### query()
Write any query you want.
```sh
$query->query('INSERT INTO online (name,email,id) VALUES ("Ram","hello@protonmail.com","1")');
$query->query(UPDATE users SET password = "Ram" WHERE email = "hello@protonmail.com"');
```
Or write dynamically
```sh
$query->query(
UPDATE users SET password = ? WHERE email = ?',
[$password, $email]
);
```
## Donate
If you are like using SQNile and want to [donate](https://www.itarimusic.com/mission.php#pricing)...

## Disclaimer
This tool is only intended for personal use and is a simple demonstration. It is in open domain and I am not responsible if you use it and violate any TnC. Or as they say, it's for science.
