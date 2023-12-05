<?php
include 'connect.php';
include 'user.php';

/* 
criminal_ID 
crime_ID
officer_ID 
*/ 

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

function add_alias() {
    User::checkPerm();
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
    User::checkPerm();
    global $con;
    // $officer_ID = array_key_exists('officer_ID', $_POST) ? $_POST['officer_ID'] : die("Officer ID required!");
    $criminal_ID = $_POST['criminal_ID'];

    $sql = "DELETE FROM alias WHERE alias_id = ?";
    $alias_ID = $_POST['alias_ID'];
    
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $alias_ID);
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