<?PHP
session_start();
include_once("setting.php");

include_once 'police_functions.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
    header("Location: index.html");
    exit();
}

$method = array_key_exists('m', $_GET) ? $_GET['m']: null;

if($method == 'a'){
    add_police_info();
}elseif($method == 'e'){
    $police_info = get_police_info_from_db();
}elseif($method == 'u'){
    update_police_info();
}else{
    $police_info = new Police();
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
            var id = form['officer_ID'];
=            var fname = form['officer_name_first'];
            var lname = form['officer_name_last'];
            var precinct = form['officer_precinct'];
            var badge = form['officer_badge'];
            var phone = form['officer_phone'];

            $result = false;
            console.log(Number.isNaN(id.value));
            if (isNaN(id.value) || id.value.trim().length < 9) {
                alert('The Police ID must be a 9 length numeric value.');
                id.focus();
            } else if (fname.value.trim() == '') {
                alert('The First Name must be 1-15 characters.');
                fname.focus();
            } else if(lname.value.trim() == '') {
                alert('The Last Name mustbe 1-10 characters.');
                lname.focus();
            }  else if(precinct.value.trim() == '') {
                alert('The Precinct must be 1-4 characters.');
                precinct.focus();
            } else if(badge.value.trim() == '') {
                alert('The Badge mustbe 1-14 characters.');
                badge.focus();
            } else if(phone.value.trim().length != 10) {
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
                <li class="active"><a href="#">Add police information</a></li>
            </ul>
        </nav>
    </header>  
      




    <form action="police_add_and_edit.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <input type="hidden" name="officer_ID" value="<?php echo $police_info->id;?>">
    <table class="content-table">
        <tbody>
            <tr>
                <th>ID</th> 
                <td><input type="text" class="input" name="officer_ID" maxlength="9" value="<?PHP echo $police_info->id;?>"></td>

            </tr>
            <tr>
                <th>First Name</th>
                <td><input type="text" class="input" name="officer_name_first" maxlength="15" value="<?PHP echo $police_info->fname;?>"></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" class="input" name="officer_name_last" maxlength="10" value="<?PHP echo $police_info->lname;?>"></td>
            </tr>
            <tr>
                <th>Precinct</th>
                <td><input type="text" class="input" name="officer_precinct" maxlength="4" value="<?PHP echo $police_info->precinct;?>"></td>
            </tr>
            <tr>
                <th>Badge</th>
                <td><input type="text" class="input" name="officer_badge" maxlength="14" value="<?PHP echo $police_info->badge;?>"></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><input type="text" class="input" name="officer_phone" maxlength="10" value="<?PHP echo $police_info->phone;?>"></td>
            </tr>
            </tr>
            <tr>
                <th>Police Status</th>
                <td>
                    <select class="input" name="officer_status" value="<?PHP echo $police_info->status;?>">
                        <option value="A">A</option>    
                        <option value="I">I</option>
                    </select>
                </td>
            </tr>
            </tr>
            <tr>
                <th>Operation:</th>
                <td>
                    <input type="submit" value="Submit" class="submit" >
                    <input type="button" class="submit" value="Back" onclick="location.href='police.php'">
                </td>
            </tr>
        </tbody>
    </table>

    </form>

</body>

</html>