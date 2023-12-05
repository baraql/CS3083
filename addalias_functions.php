<?php
include 'connect.php';

/* 
criminal_ID 
crime_ID
officer_ID 
*/ 


function add_alias() {
    global $con;

    $sql = "INSERT INTO `alias`(`alias_id`, `criminal_ID`, `alias`) VALUES (NULL, ?, ?)";
    $criminal_ID = $_POST['criminal_ID'];
    $alias = $_POST['new_alias'];

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "is",
            $criminal_ID,
            $alias,
        );

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }

}

function delete_alias() {

    global $con;
    // $officer_ID = array_key_exists('officer_ID', $_POST) ? $_POST['officer_ID'] : die("Officer ID required!");
    $criminal_ID = $_POST['criminal_ID'];

    $sql = "DELETE FROM alias WHERE alias_id = ?";

    $con->begin_transaction();
    try {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $crime_ID);
        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }

}

if (isset($_POST['m'])) {
    $method = $_POST['m'];
} else {
    return;
}
    if ($method == 'a') {
    add_alias();
} else {
        delete_alias();
    }
?>