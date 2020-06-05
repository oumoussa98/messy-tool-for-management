<?php
require_once "login.php" ;
require_once 'startsessio.php';
require_once "functions.php" ;
if ($loggedin) die(header('Location:  HomePage.php?view='.$user)) ; 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli ($db_hostname,$db_username,$db_password,$db_database,$port) ;
$error = $user = $pass = "";
$salt1='ab12!@';
$salt2='cd34#$';
 if (isset($_POST['uname'])) {
     $uname = sanitizeString($_POST['uname']) ;
     $passw = sanitizeString($_POST['passw']) ;
  if ($uname == "" || $passw == "")
       $error = "Not all fields were entered<br>";
  else {
    $passwh = hash('ripemd128',"$salt1$passw$salt2");
    $query = "SELECT * FROM users WHERE username='$uname' AND password='$passwh' ;";
    $result = $conn->query($query); 
  if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Invalid Username or 
                  Password !!</span><br><br>";
      }
  else {
          $_SESSION['uname'] = $uname;
          $_SESSION['passw'] = $passw;
            die("You are now logged in" . header('Location: HomePage.php?view='.$uname)); 
            }}}
                      
    echo <<<_END
<!DOCTYPE html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style1.css">
</head>
<body>
    <form name ="login" method="POST" action="index.php"  class="login-form">$error
        <h3>Please enter your informations</h3>
        <label for="uname">
        <strong>User name</strong>
        </label>
        <input autofocus  id="uname" type="text" placeholder="User name" name="uname" required >
        <label for="passw">
        <strong>Password</strong>
        </label>
        <input  type="password" id="passw" placeholder="Password" name="passw" required>
        <button type="submit" class="btn" >Login</button><br>
        <a href="subscribe/dev-form.html" >Or Subscribe</a>
</body>
_END ;

?>