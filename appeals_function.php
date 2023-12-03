<?php
include 'connect.php';

class Appeal {
    public $appeal_ID;
    public $crime_ID;
    public $filing_date;
    public $hearing_date;
    public $appeal_status;

    public static function fromArrayOrResult($arrOrRes) {
        $appeal = new Appeal;

        $appeal->appeal_ID = $arrOrRes['appeal_ID'];
        $appeal->crime_ID = $arrOrRes['crime_ID'];
        $appeal->filing_date = $arrOrRes['filing_date'];
        $appeal->hearing_date = $arrOrRes['hearing_date'];
        $appeal->appeal_status = $arrOrRes['appeal_status'];

        return $appeal;
    }
}

function get_appeal_info_from_db() {
    global $con;

    $crime_ID = array_key_exists('crime_ID', $_GET) ? $_GET['crime_ID'] : die("Crime ID required!");

    $sql = "SELECT * FROM appeals WHERE crime_ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $crime_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return Appeal::fromArrayOrResult($row);
}

function add_appeal() {
    global $con;
    $criminal_ID = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal ID required!");

    // Validate and sanitize input
    $appeal_ID = filter_input(INPUT_POST, 'appeal_ID', FILTER_VALIDATE_INT);
    $crime_ID = $criminal_ID; // You might want to validate this as well
    $filing_date = $_POST['filing_date']; // Add proper validation
    $hearing_date = $_POST['hearing_date']; // Add proper validation
    $appeal_status = $_POST['appeal_status']; // Add proper validation

    $sql = "INSERT INTO `appeals`(`appeal_ID`, `crime_ID`, `filing_date`, `hearing_date`, `appeal_status`) VALUES (?,?,?,?,?)";

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisss", 
                        $appeal->appeal_ID, 
                        $appeal->crime_ID, 
                        $appeal->filing_date, 
                        $appeal->hearing_date, 
                        $appeal->appeal_status, 
                        );
                        
        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }
}

function update_appeal() {
    global $con;
    $criminal_ID = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal ID required!");

    $sql = "UPDATE `appeals` SET `appeal_ID`= ?, `crime_ID`= ?, `filing_date`= ?, `hearing_date`= ?, `appeal_status`= ? WHERE appeal_ID = ?";

    $appeal = Appeal::fromArrayOrResult($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisss", 
                        $appeal->appeal_ID, 
                        $appeal->crime_ID, 
                        $appeal->filing_date, 
                        $appeal->hearing_date, 
                        $appeal->appeal_status, 
                        );

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }
}

function delete_appeal() {
    global $con;
    $appeal_ID = array_key_exists('appeal_ID', $_POST) ? $_POST['appeal_ID'] : die("Appeal ID required!");
    $criminal_ID = array_key_exists('criminal_ID', $_GET) ? $_GET['criminal_ID'] : die("Criminal ID required!");

    $sql = "DELETE FROM appeals WHERE appeal_ID = ?";

    $con->begin_transaction();
    try {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $appeal_ID);
        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }
}
?>
