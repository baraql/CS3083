<<<<<<< HEAD
<?PHP
session_start();
include_once("setting.php");
include_once 'criminal_functions.php';

=======
<?php
// Assuming you have a valid database connection stored in $con
// Ensure that the connection is established before this code

session_start();
>>>>>>> 55d8daed5424417b493eb399a6f1264c730ae7cd

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
    header("Location: index.html");
    exit();
}
<<<<<<< HEAD


$method = array_key_exists('m', $_GET) ? $_GET['m'] : null;

if ($method == 'a') {
    add_criminal_info();
} elseif ($method == 'e') {
    $criminal_info = get_criminal_info_from_db();
} elseif ($method == 'u') {
    update_criminal_info();
}
else {
    $criminal_info = new Criminal();
}
?>

=======
>>>>>>> 55d8daed5424417b493eb399a6f1264c730ae7cd

$criminal_id = array_key_exists("criminal_ID", $_GET) ? $_GET['criminal_ID'] : null;
if ($criminal_id == null) {
    header("Localtion: criminal.php");
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
<<<<<<< HEAD
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styleNav.css">
    <link rel="stylesheet" href="styleTable.css">
    <script>
        <?php
        if ($method == 'e' && array_key_exists("success", $_GET)) {
            echo "window.onload = function() {";
            echo "        setTimeout(\"alert('Update success!')\", 0);";
            echo "}";
        }
        ?>

        function check(form) {
            var id = form['criminal_ID'];
            var fname = form['criminal_name_first'];
            var lname = form['criminal_name_last'];
            var street = form['criminal_street'];
            var city = form['criminal_city'];
            var state = form['criminal_state'];
            var zip = form['criminal_zip'];
            var phone = form['criminal_phone'];

            $result = false;
            console.log(Number.isNaN(id.value));
            if (isNaN(id.value) || id.value.trim().length < 6) {
                alert('The Criminal ID must be a 6 length numeric value.');
                id.focus();
            } else if (fname.value.trim() == '') {
                alert('The First Name must be 1-15 characters.');
                fname.focus();
            } else if(lname.value.trim() == '') {
                alert('The Last Name mustbe 1-10 characters.');
                lname.focus();
            }  else if(street.value.trim() == '') {
                alert('The Street must be 1-30 characters.');
                street.focus();
            } else if(city.value.trim() == '') {
                alert('The City mustbe 1-20 characters.');
                city.focus();
            } else if(state.value.trim().length != 2) {
                alert('The state must be 2 characters.');
                state.focus();
            } else if(zip.value.trim().length != 5) {
                alert('The ZIP must be 5 characters.');
                zip.focus();
            } else if(isNaN(phone.value) || phone.value.trim().length != 10) {
                alert('The Phone must be 10 characters.');
                phone.focus();
=======
    <title>Add Crime</title>
    <script>
        function check(form) {
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
                sappeal_cut_datetate.focus();
>>>>>>> 55d8daed5424417b493eb399a6f1264c730ae7cd
            } else {
                $result = true;
            }

            return $result;;
        }
    </script>
</head>
<body>
<<<<<<< HEAD
    <header class="header-main">
        <nav class="header-main-nav">
            <ul>
                <li class="active"><a href="#">Add Crimes</a></li>
            </ul>
        </nav>
    </header>

    <form action="criminal_add_and_edit.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <table class="content-table">
        <tbody>
            <tr>
                <th>Crime Classification</th> 
                <td><input type="text" class="input" name="criminal_ID" maxlength="6" value="<?PHP echo $criminal_info->id;?>"></td>
            </tr>
            <tr>
                <th>Date Charged</th>
                <td><input type="date" name="endDate" required></td><br>


                <td><input type="text" class="input" name="criminal_name_first" maxlength="15" value="<?PHP echo $criminal_info->fname;?>"></td>
            </tr>
            <tr>
                <th>Crime Status</th>
                <td>
                    <select class="input" name="criminal_violent_status" value="<?PHP echo $criminal_info->violent_status;?>">
                        <option value="Y">P</option>    
                        <option value="N">N</option>
                    </select>
                </td>

            </tr>
            <tr>
                <th>Hearing Date</th>
                <td><input type="date" name="endDate" required></td><br>
            </tr>
  
                <th>Operation:</th>
                <td>
                    <input type="submit" value="Submit" class="submit">
                    <input type="button" class="submit" value="Back" onclick="location.href='popup.php'">
                </td>
            </tr>
        </tbody>
    </table>

    </form>

</body>

</html>
=======

<!-- Your form to collect information about the new crime -->
<form method="post" action="addCrimes.php" onsubmit="return check(this);">

<?PHP if ($method == null) {
    echo '<input type="hidden" name="m" value="a"/>';
} elseif ($method == 'e') {
    echo '<input type="hidden" name="m" value="u"/>';
}
?>
    <input type="hidden" name="criminal_ID" value="<?PHP echo $criminal_id?>"/>

    <label for="crimeID">Crime ID:</label>
    <input type="text" name="crime_ID" value="<?PHP echo $crime->crime_ID?>" maxlength="9" required><br>

    <label for="crimeClass">Crime Classification:</label>
    <input type="text" name="crime_classification" maxlength="1" value="<?PHP echo $crime->crime_classification?>" required><br>


    <label for="crimeStatus">Crime Status:</label>
    <select id="crime_status" name="crime_status" required style="width: 100%; padding: 8px; margin-bottom: 16px; box-sizing: border-box;">
        <option value="P">P</option>
        <option value="C">C</option>
    </select><br>

    <label for="startDate">Date Charged:</label>
    <input type="date" name="date_charged" value="<?PHP echo $crime->date_charged?>" required><br>

    <label for="endDate">Hearing Date:</label>
    <input type="date" name="hearing_date"  value="<?PHP echo $crime->hearing_date?>" required><br>

    <label for="endDate">Appeal Cut Date:</label>
    <input type="date" name="appeal_cut_date" value="<?PHP echo $crime->appeal_cut_date?>" required><br>


    <button type="submit">Submit</button>
    <button type="goback">    
        <a href="popup.php?criminal_ID=<?PHP echo $criminal_id?>" style="text-decoration: none; color: inherit;">Go Back</a>
    </button>


</form>

</body>
<script>
    document.getElementById("crime_status").value = "<?PHP echo $crime->crime_status?>";
</script>
</html>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #4caf50;
        }

        .error-message {
            color: #f44336;
        }
     
    </style>
>>>>>>> 55d8daed5424417b493eb399a6f1264c730ae7cd
