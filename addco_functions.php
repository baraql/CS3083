<?php
include 'connect.php';
include 'user.php';

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

function add_co() {
    User::checkPerm();
    global $con;
    $officer_ID = array_key_exists('officer_ID', $_REQUEST) ? $_REQUEST['officer_ID'] : die("officer ID required!");

    $crime_ID = $_POST['crime_ID'];
    $officer_ID = $_POST['officer_ID'];
    $sql = "INSERT INTO `crime_officers`(`crime_ID`, `officer_ID`) VALUES (?,?)";
    $criminal_ID = $_POST['criminal_ID'];

    var_dump($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "ii",
            $crime_ID,
            $officer_ID
        );

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }

}

function update_co() {
    User::checkPerm();
    global $con;
    $criminal_ID = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal ID required!");

    $sql = "UPDATE `crime_officers` SET `crime_ID`= ?, `officer_ID`= ?";

    $crime_ID = $_POST['crime_ID'];
    $officer_ID = $_POST['officer_ID'];

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "ii",
            $crime_ID,
            $officer_ID,
        );

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }

}

function delete_co() {
    User::checkPerm();

    global $con;
    $officer_ID = array_key_exists('officer_ID', $_POST) ? $_POST['officer_ID'] : die("Officer ID required!");
    $criminal_ID = $_POST['criminal_ID'];
    $crime_ID = $_POST['crime_ID'];
    $sql = "DELETE FROM crime_officers WHERE crime_ID = ? AND officer_ID = ?";

    $con->begin_transaction();
    try {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $crime_ID, $officer_ID);
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
    add_co();
} elseif ($method == 'u') {
    update_co();
} elseif ($method == 'd') {
    delete_co();
}






?>