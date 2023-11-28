<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Hello World @^_^@";

try {
    $conn = new PDO("mysql:host=localhost;dbname=criminalthing", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Display message upon successful connection
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); // Display error message if connection fails
}
?>
