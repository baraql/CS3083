<?PHP
include 'connect.php';
include 'user.php';

class Crime {
    public $crime_ID;
	public $criminal_ID;
	public $crime_classification;
	public $date_charged;
	public $crime_status;
	public $hearing_date;
	public $appeal_cut_date;

    public static function fromArrayOrResult($arrOrRes) {
        $crime = new Crime;

        $crime->crime_ID = $arrOrRes['crime_ID'];
        $crime->criminal_ID = $arrOrRes['criminal_ID'];
        $crime->crime_classification = $arrOrRes['crime_classification'];
        $crime->date_charged = $arrOrRes['date_charged'];
        $crime->crime_status = $arrOrRes['crime_status'];
        $crime->hearing_date = $arrOrRes['hearing_date'];
        $crime->appeal_cut_date = $arrOrRes['appeal_cut_date'];

        return $crime;
    }
}

function get_crime_info_form_db() {
    global $con;

    $crime_id = array_key_exists('crime_ID', $_GET) ? $_GET['crime_ID'] : die("Crime id required!");
    // $criminal_id = array_key_exists('criminal_id', $_REQUEST) ? $_REQUEST['criminal_id'] : die("Criminal id required!");

    $sql = "select * from crimes where crime_id = $crime_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return Crime::fromArrayOrResult($row);
}

function add_crime() {
    User::checkPerm();
    global $con;

    $criminal_id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal id required!");

    $sql = "INSERT INTO `crimes`(`crime_ID`, 
                                 `criminal_ID`, 
                                 `crime_classification`, 
                                 `date_charged`, 
                                 `crime_status`, 
                                 `hearing_date`, 
                                 `appeal_cut_date`) VALUES (?,?,?,?,?,?,?)";

    $crime = Crime::fromArrayOrResult($_POST);
    
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisssss", 
                        $crime->crime_ID,
                        $crime->criminal_ID,
                        $crime->crime_classification,
                        $crime->date_charged,
                        $crime->crime_status,
                        $crime->hearing_date,
                        $crime->appeal_cut_date);

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}


function update_crime() {
    User::checkPerm();
    global $con;
    $criminal_id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal id required!");

    $sql = "UPDATE `crimes` SET `crime_ID`= ?,
                                `criminal_ID`= ?,
                                `crime_classification`= ?,
                                `date_charged`= ?,
                                `crime_status`= ?,
                                `hearing_date`= ?,
                                `appeal_cut_date`= ? 
                            WHERE crime_ID = ?";

    $crime = Crime::fromArrayOrResult($_POST);
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisssss", 
                        $crime->crime_ID,
                        $crime->criminal_ID,
                        $crime->crime_classification,
                        $crime->date_charged,
                        $crime->crime_status,
                        $crime->hearing_date,
                        $crime->appeal_cut_date,
                        );

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
    User::checkPerm();
    global $con;
    $crime_id = array_key_exists('crime_ID', $_POST) ? $_POST['crime_ID'] : die("Crime id required!");
    $criminal_id = array_key_exists('criminal_ID', $_GET) ? $_GET['criminal_ID'] : die("Criminal id required!");
    $sql = "DELETE from crimes where crime_ID=$crime_id";
    
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