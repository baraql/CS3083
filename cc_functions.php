<?PHP
/**
 * crime codes related functions;
 */
include 'connect.php';

class Crime_code{
    public $cc;
    public $cd;

    public static function fromResultSet($resultSet) {
        $result = [];
        if ($resultSet) {
            foreach ($resultSet as $row) {
               $crime_code = Crime_code::fromResultRow($row);

                array_push($result, $crime_code);
            }
        }
        return $result;
    }

    public static function fromResultRow($row) {
        $crime_code = new Crime_code();
        $crime_code->cc = $row['crime_code'];
        $crime_code->cd = $row['code_description'];
        return $crime_code;
    }
}

function list_crime_code() {
    global $con;

    $sql = "SELECT * FROM `crime_codes`";
    $result = mysqli_query($con, $sql);

    return Crime_code::fromResultSet($result);
}

// search 
function search_crime_code(){
    global $con;
    $sql = "select * from crime_codes where ";
    $field = $_POST["field"];
    $text = $_POST["search_text"];

    $equal_fields = ["crime_code", "code_description"];
    if (in_array($field, $equal_fields)) {
        $sql = $sql . " $field='$text'";
    } else {
        $sql = $sql . "$field like '%$text%'";
    }

    $result = mysqli_query($con, $sql);

    return Crime_code::fromResultSet($result);

}

//delete 
function delete_crime_code() {
    User::checkPerm();
    global $con;
    $cc = $_POST['cc'];
    $sql = "DELETE from crime_codes where crime_code=$cc";
    
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

//get crime_code by cc
function get_crime_code_info_from_db() {
    global $con;

    $id = array_key_exists('crime_code', $_REQUEST) ? $_REQUEST['crime_code'] : null;
    if ($id == null) {
        return new Crime_code;
    }

    $sql = 'select * from crime_codes where crime_code = ' . $id;
    try {
        $result = $con->query($sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return Crime_code::fromResultRow($row);
        } else {
            die("Crime_code with crime_code $id does not exist.");
        }
    } catch (mysqli_sql_exception $exception) {
        die($exception);
        // throw $exception;
    }
}

// insert new 
function add_crime_code_info() {
    User::checkPerm();
    global $con;

    $sql = "insert into crime_codes values (?,?)";
    $crime_code = Crime_code::fromResultRow($_POST);
    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("is", 
                            $crime_code->cc, 
                            $crime_code->cd);
        $stmt->execute();
        $con->commit();
        header("location:cc.php");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}

//update crime_code
function update_crime_code_info() {
    User::checkPerm();
    global $con;

    $sql = "UPDATE `crime_codes` SET `crime_code`=?,
                                    `code_description`= ?
                                     WHERE crime_code = ?";
    // die($sql);                                    
    $crime_code = Crime_code::fromResultRow($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);

        $stmt->bind_param("isi", 
                            $crime_code->cc, 
                            $crime_code->cd,
                            $crime_code->cc);
        $stmt->execute();
        $con->commit();
        header("location:cc_add_and_edit.php?m=e&success=t&crime_code=$crime_code->cc");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
        // throw $exception;
    }
}
?>