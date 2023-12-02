<?php
// new.php

if (isset($_POST['crimeID'])) {
    $crimeID = $_POST['crimeID'];
    // Perform additional queries using $crimeID

    // Display the crimeID (you can replace this with your actual logic)
    echo "Crime ID: $crimeID";
} else {
    echo "No crime ID received";
}
?>
