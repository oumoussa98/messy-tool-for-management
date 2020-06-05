<?php
require_once "login.php" ;
require_once "functions.php" ;
echo '<script src="checkID.js"></script>' ;
$conn = new mysqli ($db_hostname,$db_username,$db_password,$db_database,$port) ;
if (isset($_POST['cname'])) $cname = sanitizeString($_POST['cname']) ;
  else echo "<span>the client name field is empty</span>";
if (isset($_POST['pname'])) $pname = sanitizeString($_POST['pname']) ;
  else echo "<span>the product name field is empty</span>";
if (isset($_POST['category'])) $category = sanitizeString($_POST['category']) ;
  else echo "<span>the category field is empty</span>";
if (isset($_POST['price'])) $price = sanitizeString($_POST['price']) ;
  else echo "<span>the price field is empty</span>";

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

if (isset($_POST['id'])) 
{
    $id = sanitizeString($_POST['id']) ;
    $query = "SELECT * FROM products WHERE ID='$id' ;";
    $result = $conn->query($query) ;
    if (!$result)  die ($conn->error) ;
    if ($result->num_rows)
        echo  "<span>&nbsp;&#x2718;"."This ID is taken</span>";
    else echo  "<span>&nbsp;&#x2718;"."This ID is avialab</span>";
} 
else echo "<span>the id field is empty</span>";






add_product($conn,$cname,$pname,$category,$price,$id);
function add_product ($conn,$cn,$pn,$cg,$pr,$id)
{
$query="insert into products values(
    '$cn','$pn','$cg','$pr','$id',NOW());";
$result=$conn->query($query) ;
if(!$result) die ($conn->error) ;
}
$conn->close();
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;

?>