<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbname = "criminalthing";
$username = "root";
$password = "";  

// Create a MySQLi connection
$con = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($con->connect_error) {
   die("Connection failed: " . $con->connect_error);
} 
/* 
else {
   echo "Connected successfully!";
}
*/ 

?>


