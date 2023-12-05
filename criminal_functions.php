<?PHP
/**
 * criminal related functions;
 */
include 'connect.php';
include 'user.php';

class Criminal {
    public $id;
    public $fname;
    public $lname;
    public $street;
    public $city;
    public $state;
    public $zip;
    public $phone;
    public $violent_status;
    public $probation_status;

    public static function fromResultSet($resultSet) {
        $result = [];
        if ($resultSet) {
            foreach ($resultSet as $row) {
               $criminal = Criminal::fromResultRow($row);

                array_push($result, $criminal);
            }
        }

        return $result;
    }

    public static function fromResultRow($row) {
        $criminal = new Criminal();
        $criminal->id = $row['criminal_ID'];
        $criminal->fname = $row['criminal_name_first'];
        $criminal->lname = $row['criminal_name_last'];
        $criminal->street = $row['criminal_street'];
        $criminal->city = $row['criminal_city'];
        $criminal->state = $row['criminal_state'];
        $criminal->zip = $row['criminal_zip'];
        $criminal->phone = $row['criminal_phone'];
        $criminal->violent_status = $row['criminal_violent_status'];
        $criminal->probation_status = $row['criminal_probation_status'];

        return $criminal;
    }
}

function list_criminal() {
    global $con;

    $sql = "SELECT * FROM `criminals`";
    $result = mysqli_query($con, $sql);

    return Criminal::fromResultSet($result);
}

// search 
function search_cirminal() {
    global $con;

    $sql = "select * from criminals where ";
    $field = $_POST["field"];
    $text = $_POST["search_text"];

    $equal_fields = ["criminal_ID", "criminal_state", "criminal_zip", "criminal_phone"];
    if (in_array($field, $equal_fields)) {
        $sql = $sql . " $field='$text'";
    } else {
        $sql = $sql . "$field like '%$text%'";
    }

    $result = mysqli_query($con, $sql);

    return Criminal::fromResultSet($result);
}

//delete 
function delete_criminal() {
    User::checkPerm();
    global $con;
    $id = $_POST['id'];
    $sql = "DELETE from criminals where criminal_ID=$id";
    
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

//get criminal by id 
function get_criminal_info_from_db() {
    global $con;

    $id = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : null;
    if ($id == null) {
        return new Criminal;
    }

    $sql = 'select * from criminals where criminal_ID = ' . $id;
    try {
        $result = $con->query($sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return Criminal::fromResultRow($row);
        } else {
            die("Criminal with id $id does not exist.");
        }
    } catch (mysqli_sql_exception $exception) {
        die($exception);
        // throw $exception;
    }
}

// insert new 
function add_criminal_info() {
    User::checkPerm();
    global $con;

    $sql = "insert into criminals values (?,?,?,?,?,?,?,?,?,?)";
    $criminal = Criminal::fromResultRow($_POST);
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isssssssss", 
                            $criminal->id, 
                            $criminal->fname,
                            $criminal->lname,
                            $criminal->street,
                            $criminal->city,
                            $criminal->state,
                            $criminal->zip,
                            $criminal->phone,
                            $criminal->violent_status,
                            $criminal->probation_status);
        $stmt->execute();
        $con->commit();
        header("location:criminal.php");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}

//update criminal
function update_criminal_info() {
    User::checkPerm();
    global $con;

    $sql = "UPDATE `criminals` SET `criminal_ID`=?,
                                    `criminal_name_first`= ?,
                                    `criminal_name_last`= ?,
                                    `criminal_street`= ?,
                                    `criminal_city`= ?,
                                    `criminal_state`= ?,
                                    `criminal_zip`= ?,
                                    `criminal_phone`= ?,
                                    `criminal_violent_status`= ?,
                                    `criminal_probation_status`= ? 
                                     WHERE criminal_ID = ?";
    // die($sql);                                    
    $criminal = Criminal::fromResultRow($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);

        $stmt->bind_param("isssssssssi", 
                            $criminal->id, 
                            $criminal->fname,
                            $criminal->lname,
                            $criminal->street,
                            $criminal->city,
                            $criminal->state,
                            $criminal->zip,
                            $criminal->phone,
                            $criminal->violent_status,
                            $criminal->probation_status,
                            $criminal->id);
        $stmt->execute();
        $con->commit();
        header("location:criminal_add_and_edit.php?m=e&success=t&criminal_ID=$criminal->id");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}
?>
