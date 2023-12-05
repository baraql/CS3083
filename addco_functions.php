<?php
include 'connect.php';

/* 
criminal_ID 
crime_ID
officer_ID 
*/ 


class crimeOfficer
{
    public $crime_ID;
    public $officer_ID;
    
    public static function fromArrayOrResult($arrOrRes)
    {
        $crimeOfficer = new crimeOfficer;
        $crimeOfficer->crime_ID = $arrOrRes['crime_ID'];
        $crimeOfficer->officer_ID = $arrOrRes['officer_ID'];
        
        return $crimeOfficer;
    }
}

function get_co_info_from_db() {
    global $con;

    $criminal_ID = array_key_exists('crime_ID', $_REQUEST) ? $_REQUEST['crime_ID'] : die("Crime ID required!");

    $sql = "SELECT * FROM crime_officers WHERE crime_ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $crime_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return crimeOfficer::fromArrayOrResult($row);

}

function add_co() {
    global $con;
    $officer_ID = array_key_exists('officer_ID', $_REQUEST) ? $_REQUEST['officer_ID'] : die("officer ID required!");

    // Validate and sanitize input
    $crime_ID = $_POST['crime_ID']; // You might want to validate this as well
    $officer_ID = $_POST['officer_ID']; // Add proper validation
    $sql = "INSERT INTO `crime_officers`(`crime_ID`, `officer_ID`) VALUES (?,?)";
    $criminal_ID = $_POST['criminal_ID']; // You might want to validate this as well



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

function update_co() {
    global $con;
    $criminal_ID = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal ID required!");

    $sql = "UPDATE `crime_officers` SET `crime_ID`= ?, `officer_ID`= ?";
    $crimeOfficer = crimeOfficer::fromArrayOrResult($_POST);

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

    global $con;
    $officer_ID = array_key_exists('officer_ID', $_POST) ? $_POST['officer_ID'] : die("Officer ID required!");
    // $criminal_ID = array_key_exists('criminal_ID', $_GET) ? $_GET['criminal_ID'] : die("Criminal ID required!");
    $criminal_ID = $_POST['criminal_ID'];

    $sql = "DELETE FROM crime_officers WHERE crime_ID = ?";

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
    add_co();
} elseif ($method == 'e') {
    $crimeOfficer = get_co_info_from_db();
} elseif ($method == 'u') {
    update_co();
} elseif ($method == 'd') {
    delete_co();
}










?>