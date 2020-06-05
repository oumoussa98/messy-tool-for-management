<?php
function sanitizeString($var)
  {
    global $conn;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $conn->real_escape_string($var);
  }

  function display_content($cname,$pname,$category,$price,$id,$date,$hidden)
 {
 echo <<<_END
 <button class="accordion"> <strong> $cname </strong> </button>
 <div class="panel">
 <span><strong> Client name: $cname </strong> <br> Product name: $pname 
 <br> Category : $category <br> Price :  $price EUR <br> ID : $id 
 <br> Date : $date 
 <form method="POST" class="delete-form">
 <button  name="delete$id" class="delete-butt" $hidden> Delete </button>
 </form>
 </span> 
 </div>
 </div>
 _END ;
 }
 function display_button($name,$id,$btnEXT)
 {
 echo <<<_END
 <div class="ptabs">
 <form  class="packed-form" method="POST" >
 <button  class="readybutton" id="$btnEXT$id" name="$btnEXT$id" > $name </button>
 </form>
 _END;
 }
 function insertTo($conn,$tableName)
 {
     $pname = $category = 'test' ;
     for($i=1;$i<20;$i++){
         $cname = 'test'.' ' . $i ;
         $j = 20 ;
         $price = $i*$i + $j ;
         $id = 55 ;
         $id = $id * 2 + $i ;
         $query3 = "insert into $tableName values('$cname','$pname','$category','$price','$id',NOW());" ; 
        $result3 = $conn->query($query3) ;
        if (!$result3)  die ($conn->error) ; 
        }
    }

 ?>