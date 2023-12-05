<?php

if (isset($_POST['crimeID'])) {
    $crimeID = $_POST['crimeID'];
    echo "Crime ID: $crimeID";
} else {
    echo "No crime ID received";
}
?>
