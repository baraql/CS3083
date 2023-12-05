<?PHP
/**
 * police related functions;
 */
include 'connect.php';
include 'user.php';

class Police{
    public $id;
    public $fname;
    public $lname;
    public $precinct;
    public $badge;
    public $phone;
    public $status;

    public static function fromResultSet($resultSet) {
        $result = [];
        if ($resultSet) {
            foreach ($resultSet as $row) {
               $police = Police::fromResultRow($row);

                array_push($result, $police);
            }
        }

        return $result;
    }

    public static function fromResultRow($row) {
        $police = new Police();
        $police->id = $row['officer_ID'];
        $police->fname = $row['officer_name_first'];
        $police->lname = $row['officer_name_last'];
        $police->precinct = $row['officer_precinct'];
        $police->badge = $row['officer_badge'];
        $police->phone = $row['officer_phone'];
        $police->status = $row['officer_status'];

        return $police;
    }
}

function list_police() {
    global $con;

    $sql = "SELECT * FROM `officers`";
    $result = mysqli_query($con, $sql);

    return Police::fromResultSet($result);
}

// search 
function search_police() {
    global $con;

    $sql = "select * from officers where ";
    $field = $_POST["field"];
    $text = $_POST["search_text"];

    $equal_fields = ["officer_ID", "officer_badge", "officer_phone", "officer_precinct"];
    if (in_array($field, $equal_fields)) {
        $sql = $sql . " $field='$text'";
    } else {
        $sql = $sql . "$field like '%$text%'";
    }

    $result = mysqli_query($con, $sql);

    return Police::fromResultSet($result);
}

//delete 
function delete_police() {
    global $con;
    $id = $_POST['id'];
    $sql = "DELETE from officers where officer_ID=$id";
    
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

//get police by id 
function get_police_info_from_db() {
    global $con;

    $id = array_key_exists('officer_ID', $_REQUEST) ? $_REQUEST['officer_ID'] : null;
    if ($id == null) {
        echo 'fuckkk'; 
        return new Police;
    }

    $sql = 'SELECT * FROM officers WHERE officer_ID = ' . $id;
    try {
        $result = $con->query($sql);
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return Police::fromResultRow($row);
        } else {
            die("Police with ID $id does not exist.");
        }
    } catch (mysqli_sql_exception $exception) {
        die($exception);
    }
}


// insert new 
function add_police_info() {
    global $con;

    $sql = "insert into officers values (?,?,?,?,?,?,?)";
    $police = Police::fromResultRow($_POST);
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issssss", 
                            $police->id, 
                            $police->fname,
                            $police->lname,
                            $police->precinct,
                            $police->badge,
                            $police->phone,
                            $police->status);
        $stmt->execute();
        $con->commit();
        header("location:police.php");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}

//update police
function update_police_info() {
    global $con;

    $sql = "UPDATE `officers` SET `officer_ID`=?,
                                    `officer_name_first`= ?,
                                    `officer_name_last`= ?,
                                    `officer_precinct`= ?,
                                    `officer_badge`= ?,
                                    `officer_phone`= ?,
                                    `officer_status`= ?
                                     WHERE officer_ID = ?";
    // die($sql);                                    
    $police = Police::fromResultRow($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);

        $stmt->bind_param("issssssi", 
                            $police->id, 
                            $police->fname,
                            $police->lname,
                            $police->precinct,
                            $police->badge,
                            $police->phone,
                            $police->status,
                            $police->id);
        $stmt->execute();
        $con->commit();
        header("location:police.php");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}
?>