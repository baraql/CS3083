<?PHP
session_start();
include_once 'probation_functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
    header("Location: index.html");
    exit();
}

$method = array_key_exists('m', $_GET) ? $_GET['m']: null;

if($method == 'a'){
    add_probation_info();
}elseif($method == 'e'){
    $probation_info = get_probation_info_from_db();
}elseif($method == 'u'){
    update_probation_info();
}else{
    $probation_info = new Probation();
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
            var id = form['prob_ID'];
            var fname = form['prob_name_first'];
            var lname = form['prob_name_last'];
            var street = form['prob_street'];
            var city = form['prob_city'];
            var state = form['prob_state'];
            var zip = form['prob_zip'];
            var phone = form['prob_phone'];
            var email = form['prob_email'];
            var status = form['prob_status'];
            
            $result = false;
            console.log(Number.isNaN(id.value));
            if (isNaN(id.value) || id.value.trim().length < 5) {
                alert('The Probation ID must be a 5 length numeric value.');
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
            } else if(state.value.trim() == '') {
                alert('The State mustbe 1-2 characters.');
                state.focus();
            } else if(zip.value.trim() == '') {
                alert('The Zip mustbe 1-5 characters.');
                zip.focus();
            } else if(phone.value.trim() == '') {
                alert('The Phone mustbe 10 characters.');
                phone.focus();
            } else if(email.value.trim() == '') {
                alert('The Email mustbe 1-30 characters.');
                email.focus();
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
                <li class="active"><a href="#">Add probation information</a></li>
            </ul>
        </nav>
    </header>

    <form action="probation_add_and_edit.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <table class="content-table">
        <tbody>
            <tr>
                <th>ID</th> 
                <td><input type="text" class="input" name="prob_ID" maxlength="5" value="<?PHP echo $probation_info->id;?>"></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><input type="text" class="input" name="prob_name_first" maxlength="15" value="<?PHP echo $probation_info->fname;?>"></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" class="input" name="prob_name_last" maxlength="10" value="<?PHP echo $probation_info->lname;?>"></td>
            </tr>
            <tr>
                <th>Street</th>
                <td><input type="text" class="input" name="prob_street" maxlength="30" value="<?PHP echo $probation_info->street;?>"></td>
            </tr>
            <tr>
                <th>City</th>
                <td><input type="text" class="input" name="prob_city" maxlength="20" value="<?PHP echo $probation_info->city;?>"></td>
            </tr>
            <tr>
                <th>State</th>
                <td><input type="text" class="input" name="prob_state" maxlength="2" value="<?PHP echo $probation_info->state;?>"></td>
            </tr>
            <tr>
                <th>Zip</th>
                <td><input type="text" class="input" name="prob_zip" maxlength="5" value="<?PHP echo $probation_info->zip;?>"></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><input type="text" class="input" name="prob_phone" maxlength="10" value="<?PHP echo $probation_info->phone;?>"></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type="text" class="input" name="prob_email" maxlength="30" value="<?PHP echo $probation_info->email;?>"></td>
            </tr>
            </tr>
            <tr>
                <th>Probation Status</th>
                <td>
                    <select class="input" name="prob_status" value="<?PHP echo $probation_info->status;?>">
                        <option value="A">A</option>    
                        <option value="I">I</option>
                    </select>
                </td>
            </tr>
            </tr>
            <tr>
                <th>Operation:</th>
                <td>
                    <input type="submit" value="Submit" class="submit">
                    <input type="button" class="submit" value="Back" onclick="location.href='probation.php'">
                </td>
            </tr>
        </tbody>
    </table>

    </form>

</body>

</html>