<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
     = new PDO("mysql:host=localhost;dbname=criminalthing", "root");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Display message upon successful connection
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); // Display error message if connection fails
}

$sql = "SELECT * FROM criminals";
$stmt = $con->prepare($sql);
$stmt->execute();
echo 'Criminals information: <br />';
while ($row = $stmt->fetch()) {
    echo '----------------------------------------<br />';
    foreach ($row as $columnName => $columnValue) {
        echo $columnName . ': ' . $columnValue . '<br />';
    }
}

?>
