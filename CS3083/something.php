<?php
// Assuming you have a valid database connection stored in $con
// Ensure that the connection is established before this code

include 'connect.php';
// Check if the crime ID is provided in the query parameter
if(isset($_GET['id'])) {
    $crimeID = $_GET['id'];

    // Display the crime ID
    echo '<p>Crime ID: ' . $crimeID . '</p>';

    // Now you can use $crimeID in the rest of your code to refer to the provided crime ID.
    // For example, you can use it in a database query to retrieve information related to this crime.
} else {
    // If the crime ID is not provided, display an error message or redirect the user
    echo '<p>Error: Crime ID not provided</p>';
    // You might want to add additional error handling here, such as redirecting the user to an error page.
    exit();
}
?>
