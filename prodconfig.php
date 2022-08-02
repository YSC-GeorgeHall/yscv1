<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'db5006951069.hosting-data.io');
define('DB_USERNAME', 'dbu1073158');
define('DB_PASSWORD', '2zHnhW6nK$zNb@Yo9o7S');
define('DB_NAME', 'dbs5739225');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>