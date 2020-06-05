
<?php // login.php
 $db_hostname = 'localhost';
 $db_database = 'gestiondld';
 $db_username = 'root';
 $db_password = '';
 $port = 3307 ;
 $conn = new mysqli ($db_hostname,$db_username,$db_password,"",$port) ;
 $query = "CREATE DATABASE if not exists $db_database ;";
   $conn->query($query) ;
$conn = new mysqli ($db_hostname,$db_username,$db_password,$db_database,$port) ;

$query = "create table if not exists products(
    clientName VARCHAR(32) NOT NULL,
    productName VARCHAR(32) NOT NULL,
    Category VARCHAR(32) NOT NULL,
    Price INT NOT NULL,
    ID INT NOT NULL UNIQUE,
    date datetime
);" ;
  $result = $conn->query($query) ;
  if (!$result)  die ($conn->error) ;

  $query = "create table if not exists packed(
    clientName VARCHAR(32) NOT NULL,
    productName VARCHAR(32) NOT NULL,
    Category VARCHAR(32) NOT NULL,
    Price INT NOT NULL,
    ID INT NOT NULL UNIQUE,
    date datetime
    );" ;
    $result = $conn->query($query) ;
  if (!$result)  die ($conn->error) ;

  $query = "create table if not exists shiped(
    clientName VARCHAR(32) NOT NULL,
    productName VARCHAR(32) NOT NULL,
    Category VARCHAR(32) NOT NULL,
    Price INT NOT NULL,
    ID INT NOT NULL UNIQUE,
    date datetime
    );" ;
      $result = $conn->query($query) ;
    if (!$result)  die ($conn->error) ;

    $query = "create table if not exists archived(
        clientName TEXT NOT NULL);" ;
        $result = $conn->query($query) ;
        if (!$result)  die ($conn->error) ;
?>
