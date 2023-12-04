<?PHP
/**
 * probation related functions;
 */
include 'connect.php';

class Probation{
    public $id;
    public $fname;
    public $lname;
    public $street;
    public $city;
    public $state;
    public $zip;
    public $phone;
    public $email;
    public $status;

    public static function fromResultSet($resultSet) {
        $result = [];
        if ($resultSet) {
            foreach ($resultSet as $row) {
               $probation = Probation::fromResultRow($row);
                array_push($result, $probation);
            }
        }
        return $result;
    }

    public static function fromResultRow($row) {
        $probation = new Probation();
        $probation->id = $row['prob_ID'];
        $probation->fname = $row['prob_name_first'];
        $probation->lname = $row['prob_name_last'];
        $probation->street = $row['prob_street'];
        $probation->city = $row['prob_city'];
        $probation->state = $row['prob_state'];
        $probation->zip = $row['prob_zip'];
        $probation->phone = $row['prob_phone'];
        $probation->email = $row['prob_email'];
        $probation->status = $row['prob_status'];
        return $probation;
    }
}

function list_probation() {
    global $con;

    $sql = "SELECT * FROM `prob_officer`";
    $result = mysqli_query($con, $sql);

    return Probation::fromResultSet($result);
}

// search 
function search_probation() {
    global $con;

    $sql = "select * from prob_officer where ";
    $field = $_POST["field"];
    $text = $_POST["search_text"];

    $equal_fields = ["prob_ID", "prob_city", "prob_state", "prob_zip", "prob_phone"];
    if (in_array($field, $equal_fields)) {
        $sql = $sql . " $field='$text'";
    } else {
        $sql = $sql . "$field like '%$text%'";
    }

    $result = mysqli_query($con, $sql);

    return Probation::fromResultSet($result);
}

//delete 
function delete_probation() {
    User::checkPerm();
    global $con;
    $id = $_POST['id'];
    $sql = "DELETE from prob_officer where prob_ID=$id";
    
    $con->begin_transaction();
    try {
        $con->query($sql);
        $con->commit();
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }

    // mysqli_query($con, $sql);
}

//get probation by id 
function get_probation_info_from_db() {
    global $con;

    $id = array_key_exists('prob_ID', $_REQUEST) ? $_REQUEST['prob_ID'] : null;
    if ($id == null) {
        return new Probation;
    }

    $sql = 'select * from prob_officer where prob_ID = ' . $id;
    try {
        $result = $con->query($sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return Probation::fromResultRow($row);
        } else {
            die("Probation with id $id does not exist.");
        }
    } catch (mysqli_sql_exception $exception) {
        die($exception);
        // throw $exception;
    }
}

// insert new 
function add_probation_info() {
    User::checkPerm();
    global $con;
    $sql = "insert into prob_officer values (?,?,?,?,?,?,?,?,?,?)";
    $probation = Probation::fromResultRow($_POST);
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isssssssss", 
                            $probation->id, 
                            $probation->fname,
                            $probation->lname,
                            $probation->street,
                            $probation->city,
                            $probation->state,
                            $probation->zip,
                            $probation->phone,
                            $probation->email,
                            $probation->status);
        $stmt->execute();
        $con->commit();
        header("location:probation.php");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}

//update probation
function update_probation_info() {
    User::checkPerm();
    global $con;

    $sql = "UPDATE `prob_officer` SET `prob_ID`=?,
                                    `prob_name_first`= ?,
                                    `prob_name_last`= ?,
                                    `prob_street`= ?,
                                    `prob_city`= ?,
                                    `prob_state`= ?,
                                    `prob_zip`= ?,
                                    `prob_phone`= ?,
                                    `prob_email`= ?,
                                    `prob_status`= ?
                                     WHERE prob_ID = ?";
    // die($sql);                                    
    $probation = Probation::fromResultRow($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);

        $stmt->bind_param("isssssssssi", 
                            $probation->id, 
                            $probation->fname,
                            $probation->lname,
                            $probation->street,
                            $probation->city,
                            $probation->state,
                            $probation->zip,
                            $probation->phone,
                            $probation->email,
                            $probation->status,
                            $probation->id);
        $stmt->execute();
        $con->commit();
        header("location:probation_add_and_edit.php?m=e&success=t&prob_ID=$probation->id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}
?>