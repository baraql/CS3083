<?php
// Assuming you have a valid database connection stored in $con
// Ensure that the connection is established before this code

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
    header("Location: index.html");
    exit();
}

$criminal_ID = array_key_exists("criminal_ID", $_GET) ? $_GET['criminal_ID'] : null;
if ($criminal_ID == null) {
    header("Location: criminal.php");
}

include 'connect.php';
include_once "crimes_function.php";

$method = array_key_exists("m", $_REQUEST) ? $_REQUEST['m'] : null;

$crime = new Crime;
if ($method == 'a') {
    add_crime();
} elseif ($method == 'e') {
    $crime = get_crime_info_form_db();
} elseif ($method == 'u') {
    update_crime();
} elseif ($method == 'd') {
    delete_crime();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Crime</title>
    <link rel="stylesheet" href="styleNav.css">
    <link rel="stylesheet" href="styleTable.css">
    <script>
        function check(form) {
            var criminal_ID = form['criminal_ID'];
            var crime_ID = form['crime_ID'];
            var crime_classification = form['crime_classification'];
            var date_charged = form['date_charged'];
            var crime_status = form['crime_status'];
            var hearing_date = form['hearing_date'];
            var appeal_cut_date = form['appeal_cut_date'];

            $result = false;

            if (isNaN(crime_ID.value) || crime_ID.value.trim().length < 6) {
                alert('The Crime ID must be a 9 length numeric value.');
                crime_ID.focus();
            } else if (crime_classification.value.trim() == '') {
                alert('The Crime Classification cannot be null.');
                crime_classification.focus();
            } else if(date_charged.value.trim() == '') {
                alert('The Date Charged cannot be null.');
                date_charged.focus();
            }  else if(crime_status.value.trim() == '') {
                alert('The Crime Status cannot be null.');
                crime_status.focus();
            } else if(hearing_date.value.trim() == '') {
                alert('The Hearing Date cannot be null.');
                hearing_date.focus();
            } else if(appeal_cut_date.value.trim() == '') {
                alert('The Appeal Cut Date cannot be null.');
                appeal_cut_date.focus();
            } else {
                $result = true;
            }

            return $result;;
        }
    </script>
</head>

<body>
    <header class="header-main">
        <nav class="header-main-nav">
            <ul>
                <li class="active"><a href="#">Add crime information</a></li>
            </ul>
        </nav>
    </header>

    <?php
    $disabled = '';
    if ($method === 'e') {
        $disabled = 'readonly';
    }
    ?>

    <form action="addCrimes.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <input type="hidden" name="criminal_ID" value="<?php echo $criminal_ID; ?>">
    <table class="content-table">
        <tbody>
        <tr>
    <th>Crime ID</th>
    <td><input type="text" class="input" name="crime_ID" maxlength="9"
            value="<?php echo isset($_GET['crime_ID']) ? htmlspecialchars($_GET['crime_ID']) : $crime->crime_ID; ?>"
            <?php echo $disabled; ?>></td>
</tr>

            <tr>
                <th>Crime Classification</th>
                <td><input type="text" class="input" name="crime_classification" maxlength="1" value="<?PHP echo $crime->crime_classification;?>"></td>
            </tr>
            <tr>
                <th>Date Charged</th>
                <td><input type="date" class="input" name="date_charged" value="<?PHP echo $crime->date_charged;?>"></td>
            </tr>
            <tr>
                <th>Hearing Date</th>
                <td><input type="date" class="input" name="hearing_date" value="<?PHP echo $crime->hearing_date;?>"></td>
            </tr>
            <tr>
                <th>Appeal Cut Date</th>
                <td><input type="date" class="input" name="appeal_cut_date" value="<?PHP echo $crime->appeal_cut_date;?>"></td>
            </tr>
            </tr>
            <tr>
                <th>Crime Status</th>
                <td>
                    <select class="input" name="crime_status" value="<?PHP echo $crime->crime_status;?>">
                        <option value="P">P</option>
                        <option  value="C">C</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Operation:</th>
                <td>
                    <input type="submit" value="Submit" class="submit">
                    <input type="button" class="submit" value="Back" onclick="location.href='popup.php?criminal_ID=<?php echo $criminal_ID; ?>'">
                </td>
            </tr>
        </tbody>
    </table>

    </form>

</body>

</html>