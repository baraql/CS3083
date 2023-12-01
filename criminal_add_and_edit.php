<?PHP
session_start();
include_once("setting.php");
include_once 'criminal_functions.php';

if (DEBUG == false) {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // echo "not logged in";
        header("Location: index.html");
        exit();
    }
}

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <li class="active"><a href="#">Add criminal information</a></li>
            </ul>
        </nav>
    </header>

    <form action="criminal_add_and_edit.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <table class="content-table">
        <tbody>
            <tr>
                <th>ID</th> 
                <td><input type="text" class="input" name="criminal_ID" maxlength="6" value="<?PHP echo $criminal_info->id;?>"></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><input type="text" class="input" name="criminal_name_first" maxlength="15" value="<?PHP echo $criminal_info->fname;?>"></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" class="input" name="criminal_name_last" maxlength="10" value="<?PHP echo $criminal_info->lname;?>"></td>
            </tr>
            <tr>
                <th>Street</th>
                <td><input type="text" class="input" name="criminal_street" maxlength="30" value="<?PHP echo $criminal_info->street;?>"></td>
            </tr>
            <tr>
                <th>City</th>
                <td><input type="text" class="input" name="criminal_city" maxlength="20" value="<?PHP echo $criminal_info->city;?>"></td>
            </tr>
            <tr>
                <th>State</th>
                <td><input type="text" class="input" name="criminal_state" maxlength="2" value="<?PHP echo $criminal_info->state;?>"></td>
            </tr>
            <tr>
                <th>Zip</th>
                <td><input type="text" class="input" name="criminal_zip" maxlength="5" value="<?PHP echo $criminal_info->zip;?>"></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><input type="text" class="input" name="criminal_phone" maxlength="10" value="<?PHP echo $criminal_info->phone;?>"></td>
            </tr>
            </tr>
            <tr>
                <th>Violent Status</th>
                <td>
                    <select class="input" name="criminal_violent_status" value="<?PHP echo $criminal_info->violent_status;?>">
                        <option value="Y">Y</option>    
                        <option value="N">N</option>
                    </select>
                </td>
            </tr>
            </tr>
            <tr>
                <th>Probation Status</th>
                <td>
                    <select class="input" name="criminal_probation_status" value="<?PHP echo $criminal_info->probation_status;?>">
                        <option value="Y">Y</option>
                        <option  value="N">N</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Operation:</th>
                <td>
                    <input type="submit" value="Submit" class="submit">
                    <input type="button" class="submit" value="Back" onclick="location.href='criminal.php'">
                </td>
            </tr>
        </tbody>
    </table>

    </form>

</body>

</html>