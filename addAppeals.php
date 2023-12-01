<?php
// Assuming you have a valid database connection stored in $con
// Ensure that the connection is established before this code

include 'connect.php';
// Check if the criminal ID is provided in the query parameter

// Check if the crime ID is provided in the URL
if(isset($_GET['crimeID'])) {
    $crimeID = $_GET['crimeID'];
    /* echo "Crime ID: " . $crimeID;*/ 
} else {
    echo "Crime ID not provided";
}
?>
