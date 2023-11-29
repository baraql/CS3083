<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    echo "Received ID: " . $id;
} else {
    echo "No ID received!";
}
?>