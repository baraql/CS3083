<?php
include 'connect.php';


function SentencesQuery($id) {
    global $con;

    $sql = "SELECT * FROM sentences WHERE criminal_ID = '" . mysqli_real_escape_string($con, $id) . "'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die('Error in SQL query: ' . mysqli_error($con));
    }

    $queryResult = mysqli_fetch_assoc($result);

    if (!$queryResult) {
        die('No data found for ID: ' . $id);
    }

    return $queryResult;
}



function criminalQuery($id) {
    global $con;

    if (empty($id)) {
        $id = '101010'; 
    }

    $sql = "SELECT * FROM criminals WHERE criminal_ID = '" . mysqli_real_escape_string($con, $id) . "'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die('Error in SQL query: ' . mysqli_error($con));
    }

    return mysqli_fetch_assoc($result);
}
?>





