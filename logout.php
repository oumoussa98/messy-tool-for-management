<?php
require_once 'startsessio.php';
if (isset($_SESSION['uname']))
{
  destroySession();
  die(header('Location: index.php'));
}
else echo "<div class='main'><br>" .
          "You cannot log out because you are not logged in";
          function destroySession()
          {
            $_SESSION=array();
        
            if (session_id() != "" || isset($_COOKIE[session_name()]))
              setcookie(session_name(), '', time()-2592000, '/');
        
            session_destroy();
          }
?>
