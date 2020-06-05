<?php
require_once 'startsessio.php';
require_once "login.php" ;
require_once "functions.php" ;
echo '<script type="text/javascript" src="jquery-3.5.0.js"></script>';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli ($db_hostname,$db_username,$db_password,$db_database,$port) ;
 if (!$loggedin) die(header('Location: index.php'));
 if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);
    if ($view == $user) $name = "Your";
    else                $name = "$view's";
  }
$query = "SELECT * FROM users WHERE username='$user' ;";
$result = $conn->query($query);  
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc() ) {
          $fullname = $row["firstname"] ." ". $row["lastname"] ;
          $username = $row["username"] ;
     }}
// get the theme style for the user -----------------------
  $query = "create table if not exists themes(
      theme VARCHAR(32) NOT NULL,
      username VARCHAR(32) NOT NULL);" ;
  $result = $conn->query($query);  
  $query = "SELECT * FROM themes WHERE username='$user';";
  $result1 = $conn->query($query);  
  if ($result1->num_rows == 0) {
    $style = 'style1' ; 
    $query = "insert into themes values('$style','$user') ;" ;
    $result = $conn->query($query); 
  }
else {
    while($row = $result1->fetch_assoc() )  $style = $row["theme"] ; 
  }
// form for adding products -----------------------
 echo <<<_END
 <html>
 <head>
 <title>Home Page</title>
 <link rel="stylesheet" href="$style.css">
 <link rel="stylesheet" href="fontawesome/css/all.css" >
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
 <body>   
 <div id=top-div1>
 <button  class="open-button" onclick="openForm()"><i class="fas fa-plus fa-1x"></i></button>
 <div>
 <form  class="theme-form" method="POST" >
 <button  class="theme-button" name="style1" > green theme </button>
 <button  class="theme-button" name="style2" > orange theme </button>
 <button  class="theme-button" name="style3" > blue theme </button>
 </form>
 </div>
 <div class="userinfodiv" >
 <img class="userimg" alt="image here" src="$username.jpg" ><br>
 <h5 class="username"> $fullname </h5> <br>
 <a href='logout.php'>Log out</a>
 </div>
 </div>
 <div class="productInfo-div" id="popupdiv" >
 <div class="form-popup" id="popupForm" >
 <form name = "productInfo" method="POST" action="popupform.php"  class="form-container">
 <h3>Please enter product informations</h3>
 <label for="pname">
 <strong>Client name</strong>
 </label>
 <input autofocus  id="cname" type="text" placeholder="Client name" name="cname" required >
 <label for="pname">
 <strong>Product name</strong>
 </label>
 <input  type="text" id="pname" placeholder="Product name" name="pname"  required>
 <label for="category">
 <strong>Product category</strong>
 </label>
 <input type="text" id="category" placeholder="Category" name="category"  required>
 <label for="price">
 <strong>Product price EUR</strong>
 </label>
 <input type="number" id="price" placeholder="Product price" name="price"  required>
 <label for="id">
 <strong>Product ID</strong>
 </label>
 <input type="number" id="id" placeholder="Product ID" name="id"  onBlur='checkUser(this)' required><span id='info'></span><br>
 <button type="submit" class="btn" >Save</button>
 <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
 </form>
 </div>
 </div>
 <div class="tab">
 <button class="tablinks" onclick="openCity(event, 'In')" id="productedS">In production</button>
 <button class="tablinks" onclick="openCity(event, 'pack')" id="packS">Packed</button>
 <button class="tablinks" onclick="openCity(event, 'ship')" id="shipS">Shiped</button>
 <button class="tablinks" onclick="openCity(event, 'Archived')" id="archiveS">Archived</button>
 </div>
 _END;
//update theme for each user --------------------------------
if(array_key_exists('style2', $_POST)) { 
$query = "UPDATE `themes` SET `theme`='style2' WHERE username='$user' ;";
$result = $conn->query($query);
if (!$result)  die ($conn->error) ;
echo "<meta http-equiv='refresh' content='0'>";
}
if(array_key_exists('style3', $_POST)) { 
  $query = "UPDATE `themes` SET `theme`='style3'  WHERE username='$user' ;";
  $result = $conn->query($query);
  if (!$result)  die ($conn->error) ;
  echo "<meta http-equiv='refresh' content='0'>";
}
if(array_key_exists('style1', $_POST)) { 
  $query = "UPDATE `themes` SET `theme`='style1' WHERE username='$user' ;";
  $result = $conn->query($query);
  if (!$result)  die ($conn->error) ;
  echo "<meta http-equiv='refresh' content='0'>";
}

// *************************** products aria ************************* -->
// *************************** products aria ************************* -->
$btnName = "ready to pack" ;
$btnEXT = "producted" ;
//$tableName = 'products' ;
//insertTo($conn,$tableName) ;
echo '<div id="In" name="In" class="tabcontent">' ;
 // -------------------- move a product to the next step --------------------
 $query = "SELECT * FROM products ;";
 $result = $conn->query($query);
 if (!$result)  die ($conn->error) ;
 if ($result->num_rows == 0 ){
   echo "this block is empty (0 Products)" ;
 } 
 else {
 while($row = $result->fetch_assoc() ) {
 $cname = $row["clientName"] ;
 $pname = $row["productName"] ;
 $category = $row["Category"] ;
 $price = $row["Price"] ;
 $id = $row["ID"] ;
 $date = $row["date"] ;
 $ids = array();
 $i = 0 ;
 $ids[$i] = $row["ID"] ;
 $id2 = $ids[$i] ;
 $i++ ;
 foreach ($ids as $value){
 $id1 = $value ;
 if(array_key_exists($btnEXT.$id1, $_POST)) { 
 $query4 = "create table if not exists packed(
 clientName VARCHAR(32) NOT NULL,
 productName VARCHAR(32) NOT NULL,
 Category VARCHAR(32) NOT NULL,
 Price INT NOT NULL,
 ID INT NOT NULL UNIQUE,
 date datetime
 );" ;
   $result4 = $conn->query($query4) ;
 if (!$result4)  die ($conn->error) ;
 $query3 = "insert into packed values('$cname','$pname','$category','$price','$id','$date') ;" ;
   $result3 = $conn->query($query3) ;
 $query2 = "DELETE FROM products WHERE ID=$id1 ;" ;
   $result2 = $conn->query($query2) ;
 if (!$result3)  die ($conn->error) ; 
 if (!$result2)  die ($conn->error) ;
 echo "<meta http-equiv='refresh' content='0'>";
 }
// ------------------------- delete elements  --------------------
 if(array_key_exists('delete'.$id1, $_POST)){
   $query5 = "DELETE FROM products WHERE ID=$id1 ;" ;
   $result5 = $conn->query($query5) ;
 if (!$result5)  die ($conn->error) ;
 echo "<meta http-equiv='refresh' content='0'>";
 }
// ------------------- display elements ---------------------
   $hidden = "" ;
 display_button($btnName,$id2,$btnEXT) ;
 display_content($cname,$pname,$category,$price,$id,$date,$hidden) ;
 }}}
// *************************** packed area **************************************** -->
// *************************** packed area **************************************** -->
 $btnName = "ready to ship&nbsp" ;
 $btnEXT = "packed" ;
 echo'</div><div id="pack" name="pack" class="tabcontent">' ;
  // ---------------------------- move elements to te next step  -----------------
   $query = "SELECT * FROM packed ;";
   $result = $conn->query($query);
   if ($result->num_rows == 0 ){
    echo "this block is empty (0 Products)" ;
  }
   else {
   while($row = $result->fetch_assoc() ) {
   $cname = $row["clientName"] ;
   $pname = $row["productName"] ;
   $category = $row["Category"] ;
   $price = $row["Price"] ;
   $id = $row["ID"] ;
   $date = $row["date"] ;
   $ids = array();
   $i = 0 ;
   $ids[$i] = $row["ID"] ;
   $id2 = $ids[$i] ;
   $i++ ;
   foreach ($ids as $value){
   $id1 = $value ;
   if(array_key_exists($btnEXT.$id1, $_POST)) { 
   $query4 = "create table if not exists shiped(
   clientName VARCHAR(32) NOT NULL,
   productName VARCHAR(32) NOT NULL,
   Category VARCHAR(32) NOT NULL,
   Price INT NOT NULL,
   ID INT NOT NULL UNIQUE,
   date datetime
   );" ;
     $result4 = $conn->query($query4) ;
   if (!$result4)  die ($conn->error) ;
   $query3 = "insert into shiped values('$cname','$pname','$category','$price','$id','$date');" ;
     $result3 = $conn->query($query3) ;
   $query2 = "DELETE FROM packed WHERE ID=$id1 ;" ;
     $result2 = $conn->query($query2) ;
   if (!$result3)  die ($conn->error) ; 
   if (!$result2)  die ($conn->error) ;
   echo "<meta http-equiv='refresh' content='0'>";
   }
// ------------------------- display elements  ----------------
 $hidden = "hidden" ;
 display_button($btnName,$id2,$btnEXT) ;
 display_content($cname,$pname,$category,$price,$id,$date,$hidden) ;
 }}}
// *************************** shiped area ********************************* -->
// *************************** shiped area ********************************* -->
 echo'</div><div id="ship" class="tabcontent">' ;
 $btnName = "add 2 archive" ;
 $btnEXT = "shiped" ;
   //------------------------------ get elements from database ----------------------------
$query = "SELECT * FROM shiped ;";
   $result = $conn->query($query);
   if ($result->num_rows == 0 ){
    echo "this block is empty (0 Products)" ;
  }
else {
 while($row = $result->fetch_assoc() ) {
 $cname = $row["clientName"] ;
 $pname = $row["productName"] ;
 $category = $row["Category"] ;
 $price = $row["Price"] ;
 $id = $row["ID"] ;
 $date = $row["date"] ;
 $ids = array();
 $i = 0 ;
 $ids[$i] = $row["ID"] ;
 $id2 = $ids[$i] ;
 $i++ ;
 $num = 1 ;
 // create files ---------------------------------------------
 foreach ($ids as $value){
  $id1 = $value ;
 if(array_key_exists($btnEXT.$id1, $_POST)) 
 {
  $myfile ='archived/'.$cname.'.xls' ;
  $filename = $cname . '.xls' ;
  if (file_exists($myfile)) {
 /* $file = fopen($myfile, 'r');
  $lines = file($myfile) ;
  $linesLen = count($lines) ;
  $j = $linesLen - 5 ;
  $num = $lines[$j][1] ;
  if($j == 1) $num = 2 ;
  else        $num = $num+1 ; */
  $file = fopen($myfile, "a") or die("Unable to open file!");
  $text = <<<_END
  $pname \t $category \t $price \t $id1 \n
 _END ;
 fwrite($file, $text);
 fclose($file);
           }
   else {
  $file = fopen($myfile, "w") or die("Unable to open file!");
  $text = <<<_END
  Client Name \t $cname \n
  Product Name \t  Category \t Price \t ID 
  $pname \t $category \t $price \t $id1 \n
  _END ;
  fwrite($file, $text);
  fclose($file);
  }
  // store tag for dowloading files -------------------
  $query = "create table if not exists archived(
    clientName TEXT NOT NULL);" ;
  $result = $conn->query($query) ;
  if (!$result)  die ($conn->error) ;
 $tag = <<<_END
    <a href="$myfile">$filename</a> click item to download <br>
 _END;
$query1  = "insert into archived values('$tag');" ;
// check for a tag if its already exist ---------------
$getit = 0 ;
  $query = "SELECT * FROM archived;";
   $result = $conn->query($query);
   if ($result->num_rows) {
 while($row = $result->fetch_assoc() ) {
   if ($tag == $row["clientName"]) $getit = 1 ; }}
  if(!$getit){
   $result1 = $conn->query($query1) ;
   if (!$result1)  die ($conn->error) ; }  
 echo "<meta http-equiv='refresh' content='0'>";
 // delete product from chiped area -----           
  $query = "DELETE FROM shiped WHERE ID=$id1 ;" ;
  $result = $conn->query($query) ;
   if (!$result)  die ($conn->error) ; 
      }}
// ---------------------------- display elements  ---------------------------
   $hidden = 'hidden' ;
 display_button($btnName,$id2,$btnEXT) ;
 display_content($cname,$pname,$category,$price,$id,$date,$hidden) ;
 }}
echo<<<_END
 </div>
 <div id="Archived" class="tabcontent">
 <div  class="arcivedlinks-div">
 _END;
 $query = "SELECT * FROM archived;";
 $result = $conn->query($query);
 if ($result->num_rows) {
while($row = $result->fetch_assoc() ) {
 $tag = $row["clientName"] ;
  echo $tag ;  }}
 echo <<<_END
 </div>
 </div>
 <script src="scripte_top_bar.js"></script>
 <script src="in_production.js"></script>
 <script src="popup.js"></script>
 <script src="def_scripts.js"></script>
 </body>
 </html>
 _END ;
$conn->close() ;
?>
