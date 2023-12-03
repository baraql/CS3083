<?PHP
session_start();
include_once 'cc_functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
    header("Location: index.html");
    exit();
}

$method = array_key_exists('m', $_GET) ? $_GET['m']: null;

if($method == 'a'){
    add_crim_code_info();
}elseif($method == 'e'){
    $crime_code_info = get_crime_code_info_from_db();
}elseif($method == 'u'){
    update_crime_code_info();
}else{
    $crime_code_info = new Crime_code();
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
            var cc = form['crime_code'];
            var cd = form['crime_description'];

            $result = false;
            console.log(Number.isNaN(cc.value));
            if (isNaN(cc.value) || cc.value.trim().length < 3) {
                alert('The Crime code must be a 3 length numeric value.');
                cc.focus();
            } else if (cd.value.trim() == '') {
                alert('The Crime description must be 1-30 characters.');
                cd.focus();
            }else {
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
                <li class="active"><a href="#">Add crime_code information</a></li>
            </ul>
        </nav>
    </header>

    <form action="cc_add_and_edit.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <table class="content-table">
        <tbody>
            <tr>
                <th>Crime Codes</th> 
                <td><input type="text" class="input" name="crime_code" maxlength="3" value="<?PHP echo $crime_code_info->cc;?>"></td>
            </tr>
            <tr>
                <th>Code Description</th>
                <td><input type="text" class="input" name="code_description" maxlength="30" value="<?PHP echo $crime_code_info->cd;?>"></td>
            </tr>
            <tr>
                <th>Operation:</th>
                <td>
                    <input type="submit" value="Submit" class="submit">
                    <input type="button" class="submit" value="Back" onclick="location.href='cc.php'">
                </td>
            </tr>
        </tbody>
    </table>

    </form>

</body>

</html>