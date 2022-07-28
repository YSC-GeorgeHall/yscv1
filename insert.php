<?php  
session_start();
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
require_once "config.php";
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$advert_title = mysqli_real_escape_string($link, $_REQUEST['advert_title']);
$id = $_SESSION['id'];
 
// Attempt insert query execution
$sql = "INSERT INTO adverts (id ,advert_title) VALUES ('$id', '$advert_title')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>