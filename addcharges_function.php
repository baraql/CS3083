<?php
include 'connect.php';
class Charge
{
    public $charge_ID;
    public $crime_ID;
    public $crime_code;
    public $charge_status;
    public $fine_amount;
    public $court_fee;
    public $amount_paid;
    public $pay_due_date;



    public static function fromArrayOrResult($arrOrRes)
    {
        $charge = new Charge;
        $charge->charge_ID = $arrOrRes['charge_ID'];
        $charge->crime_ID = $arrOrRes['crime_ID'];
        $charge->crime_code = $arrOrRes['crime_ID'];
        $charge->charge_status = $arrOrRes['charge_status'];
        $charge->fine_amount = $arrOrRes['fine_amount'];
        $charge->court_fee = $arrOrRes['court_fee'];
        $charge->amount_paid = $arrOrRes['amount_paid'];
        $charge->pay_due_date = $arrOrRes['pay_due_date'];


        return $charge;
    }
}



function get_charge_info_from_db()
{
    global $con;

    $sql = "SELECT * FROM crime_charges WHERE crime_ID = ?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $crime_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return Charge::fromArrayOrResult($row);
}

function add_charge()
{
    var_dump($_POST);


    global $con;
    $criminal_ID = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal ID required!");
    echo "criminal_ID: $criminal_ID";
    $charge_ID = $_POST['charge_ID'];
    $crime_ID = $_POST['crime_ID'];
    $crime_code = $_POST['crime_code'];
    $charge_status = $_POST['charge_status'];
    $fine_amount = $_POST['fine_amount'];
    $court_fee = $_POST['court_fee'];
    $amount_paid = $_POST['amount_paid'];
    $pay_due_date = $_POST['pay_due_date'];

    $sql = "INSERT INTO `crime_charges`(`charge_ID`, `crime_ID`, `crime_code`, `charge_status`, `fine_amount`, `court_fee`, `amount_paid`, `pay_due_date`) VALUES (?,?,?,?,?,?,?,?)";

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "iiisiiis",
            $charge_ID,
            $crime_ID,
            $crime_code,
            $charge_status,
            $fine_amount,
            $court_fee,
            $amount_paid,
            $pay_due_date
        );

        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }
}

function update_appeal()
{


    global $con;
    $criminal_ID = array_key_exists('criminal_ID', $_REQUEST) ? $_REQUEST['criminal_ID'] : die("Criminal ID required!");

    $sql = "UPDATE `crime_charges` SET `charge_ID`= ?, `crime_ID`= ?, `crime_code`= ?, `charge_status`= ?, `fine_amount`= ?, `court_fee`= ?, `amount_paid`= ? WHERE pay_due_date = ?";
    $charge = Charge::fromArrayOrResult($_POST);

    try {
        $con->begin_transaction();
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "iisssi",
            $charge->charge_ID,
            $charge->crime_ID,
            $charge->crime_code,
            $charge->charge_status,
            $charge->fine_amount,
            $charge->court_fee,
            $charge->amount_paid,
            $charge->pay_due_date
        );


        $stmt->execute();
        $con->commit();
        header("location:popup.php?criminal_ID=$criminal_ID");
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        die($exception);
    }
}

function delete_charge()
{
    global $con;
    $charge_ID = array_key_exists('charge_ID', $_POST) ? $_POST['charge_ID'] : die("Charge ID required!");
    $criminal_ID = $_POST['criminal_ID'];

    $sql = "DELETE FROM crime_charges WHERE charge_ID = ?";

    $con->begin_transaction();
    try {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $charge_ID);
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
    add_charge();
} elseif ($method == 'e') {
    $appeal = get_charge_info_from_db();
} elseif ($method == 'u') {
    update_charge();
} elseif ($method == 'd') {
    delete_charge();
}
?>