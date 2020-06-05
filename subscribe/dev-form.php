<?php
require_once '../login.php' ;
if (isset($_POST['firstname'])) $firstname = mysql_entities_fix_string($conn,$_POST['firstname'])  ;
else $firstname='' ;
if (isset($_POST['lastname'])) $lastname = mysql_entities_fix_string($conn,$_POST['lastname']) ;
else $lastname='' ;
if (isset($_POST['submit'])) $gender = mysql_entities_fix_string($conn,$_POST['gender']) ;
else $gender='' ;
if (isset($_POST['username'])) $username = mysql_entities_fix_string($conn,$_POST['username']) ;
else $username='' ;
if (isset($_POST['password'])) $password = mysql_entities_fix_string($conn,$_POST['password']) ;
else $password='' ;
$salt1='ab12!@';
$salt2='cd34#$';
$password=hash('ripemd128',"$salt1$password$salt2");
$query = "create database if not exists usersinfo" ;
$query = "create table if not exists users(
    firstname VARCHAR(32) NOT NULL,
    lastname VARCHAR(32) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE ,
    password VARCHAR(32) NOT NULL
)" ;
$result=$conn->query($query) ;
if (!$result)  die ($conn->error) ;
add_user($conn,$firstname,$lastname,$gender,$username,$password);


$conn->close();

function add_user ($conn,$fn,$ln,$g,$un,$pw)
{
$query="insert into users values(
    '$fn','$ln','$g','$un','$pw')";
$result=$conn->query($query) ;
if(!$result) die ($conn->error) ;
}

function mysql_entities_fix_string($conn, $string)
{
return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return $conn->real_escape_string($string);
}
header("Location: ../HomePage.php");
exit;
?>
