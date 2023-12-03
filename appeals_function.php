<?PHP
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




function get_appeal_info_form_db() {
    global $con;

    $crime_id = array_key_exists('crime_ID', $_GET) ? $_GET['crime_ID'] : die("Crime id required!");
    // $criminal_id = array_key_exists('criminal_id', $_REQUEST) ? $_REQUEST['criminal_id'] : die("Criminal id required!");

    $sql = "select * from appeals where crime_id = $crime_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return appeals::fromArrayOrResult($row);
}

function add_appeals() {
    global $con;
    $criminal_id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal id required!");

    $sql = "INSERT INTO `appeals`(`appeal_ID`, 
    `crime_ID`, 
    `filing_date`, 
    `hearing_date`, 
    `appeal_status`,) VALUES (?,?,?,?,?,?,?)";



    $appeal = Appeal::fromArrayOrResult($_POST);
    
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisssss", 
                        $appeal->appeal_ID, 
                        $appeal->crime_ID, 
                        $appeal->filing_date, 
                        $appeal->hearing_date, 
                        $appeal->appeal_status);


                    
        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}


function update_appeal() {
    global $con;
    $criminal_id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal id required!");

    $sql = "UPDATE `appeals` SET `appeal_ID`= ?,
                                `crime_ID`= ?,
                                `filing_date`= ?,
                                `hearing_date`= ?,
                                `appeal_status`= ?,
                            WHERE crime_ID = ?";

    $crime = Appeal::fromArrayOrResult($_POST);


 try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisssss", 
                        $appeal->appeal_ID, 
                        $appeal->crime_ID, 
                        $appeal->filing_date, 
                        $appeal->hearing_date, 
                        $appeal->appeal_status);


                    
        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}

function delete_crime() {
    global $con;
    $appeal_ID = array_key_exists('appeal_ID', $_POST) ? $_POST['appeal_ID'] : die("Appeal id required!");
    $criminal_id = array_key_exists('criminal_ID', $_GET) ? $_GET['criminal_ID'] : die("Criminal id required!");
    $sql = "DELETE from appeals where crime_ID=$appeal_ID";
    
    $con->begin_transaction();
    try {
        $con->query($sql);
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}
?>