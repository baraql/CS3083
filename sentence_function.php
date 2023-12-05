<?PHP
include 'connect.php';
include 'user.php';

class Sentence{
    public $sentence_ID;
    public $criminal_ID;
    public $sentence_type;
    public $prob_ID;
    public $start_date;
    public $end_date;
    public $violations;

    public static function formArrayOrResult($arrOrRes){
        $sentence = new Sentence;

        $sentence->sentence_ID = $arrOrRes['sentence_ID'];
        $sentence->criminal_ID = $arrOrRes['criminal_ID'];
        $sentence->sentence_type = $arrOrRes['sentence_type'];
        $sentence->prob_ID = $arrOrRes['prob_ID'];
        $sentence->start_date = $arrOrRes['start_date'];
        $sentence->end_date = $arrOrRes['end_date'];
        $sentence->violations = $arrOrRes['violations'];
        return $sentence;
    }
}

function get_sentence_info_from_db(){
    global $con;
    
    $sentence_id = array_key_exists('sentence_ID', $_GET) ? $_GET['sentence_ID']:die("Sentence id required!");

    $sql = "select * from sentences where sentence_ID = $sentence_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return Sentence::formArrayOrResult($row);
}

function add_sentence(){
    User::checkPerm();
    global $con;
    $criminal_id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal id required!");

    $sql = "INSERT INTO `sentences`(`sentence_ID`, 
                                 `criminal_ID`, 
                                 `sentence_type`, 
                                 `prob_ID`, 
                                 `start_date`, 
                                 `end_date`, 
                                 `violations`) VALUES (?,?,?,?,?,?,?)";

    $sentence = Sentence::formArrayOrResult($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisssss", 
                        $sentence->sentence_ID,
                        $sentence->criminal_ID,
                        $sentence->sentence_type,
                        $sentence->prob_ID,
                        $sentence->start_date,
                        $sentence->end_date,
                        $sentence->violations);

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}

function update_sentence(){
    User::checkPerm();
    global $con;
    $criminal_id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal id required!");

    $sql = "UPDATE `sentences` SET `sentence_ID`= ?,
                                `criminal_ID`= ?,
                                `sentence_type`= ?,
                                `prob_ID`= ?,
                                `start_date`= ?,
                                `end_date`= ?,
                                `violations`= ? 
                            WHERE sentence_ID = ?";

    $sentence = Sentence::formArrayOrResult($_POST);
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisssssi", 
                        $sentence->sentence_ID,
                        $sentence->criminal_ID,
                        $sentence->sentence_type,
                        $sentence->prob_ID,
                        $sentence->start_date,
                        $sentence->end_date,
                        $sentence->violations,
                        $sentence->sentence_ID);

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }

}

function delete_sentence() {
    User::checkPerm();
    global $con;
    $sentence_id = array_key_exists('sentence_ID', $_POST) ? $_POST['sentence_ID'] : die("Sentence id required!");
    $criminal_id = array_key_exists('criminal_ID', $_GET) ? $_GET['criminal_ID'] : die("Criminal id required!");
    $sql = "DELETE from sentences where sentence_ID=$sentence_id";
    
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

