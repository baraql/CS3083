<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbname = "criminalthing";
$username = "root";
$password = "";

$con = new mysqli($host, $username, $password, $dbname);

if ($con->connect_error) {
   die("Connection failed: " . $con->connect_error);
}

?>