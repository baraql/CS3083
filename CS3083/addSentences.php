<?PHP

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
    header("Location: index.html");
    exit();
}

$criminal_id = array_key_exists("criminal_ID", $_GET) ? $_GET['criminal_ID'] : null;
if ($criminal_id == null) {
    header("Localtion: criminal.php");
}

include 'connect.php';
include_once "sentence_function.php";

$method = array_key_exists("m", $_REQUEST) ? $_REQUEST['m'] : null;

$sentence = new Sentence;

if ($method == 'a') {
    add_sentence();
} elseif ($method == 'e') {
    $sentence = get_sentence_info_from_db();
} elseif ($method == 'u') {
    update_sentence();
} elseif ($method == 'd'){
    delete_sentence();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sentence</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styleNav.css">
    <link rel="stylesheet" href="styleTable.css">
    <script>
        function check(form) {
            var sentence_ID = form['sentence_ID'];
            var sentence_type = form['sentence_type'];
            var prob_ID= form['prob_ID'];
            var start_date = form['start_date'];
            var end_date = form['end_date'];
            var violations = form['violations'];

            $result = false;

            if (isNaN(sentence_ID.value) || sentence_ID.value.trim().length < 6) {
                alert('The Sentence ID must be a 6 length numeric value.');
                sentence_ID.focus();
            } else if (sentence_type.value.trim() == '') {
                alert('The Sentence Type cannot be null.');
                sentence_type.focus();
            } else if(prob_ID.value.trim() == '') {
                alert('The Probation ID cannot be null.');
                prob_ID.focus();
            }  else if(start_date.trim() == '') {
                alert('The Start Date cannot be null.');
                start_date.focus();
            } else if(end_date.value.trim() == '') {
                alert('The End Date cannot be null.');
                end_date.focus();
            } else if(violations.value.trim() == '') {
                alert('The Violation cannot be null.');
                violations.focus();
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
                <li class="active"><a href="#">Add sentence information</a></li>
            </ul>
        </nav>
    </header>

    <form action="addSentences.php?m=<?php echo is_null($method) ? 'a' : 'u'?>" onsubmit="return check(this);" method="post">
    <input type="hidden" name="criminal_ID" value="<?php echo $criminal_id; ?>">
    <table class="content-table">
        <tbody>
            <tr>
                <th>Sentence ID</th> 
                <td><input type="text" class="input" name="sentence_ID" maxlength="6" value="<?PHP echo $sentence->sentence_ID;?>"></td>
            </tr>
            <tr>
                <th>Sentence Type</th>
                <td><input type="text" class="input" name="sentence_type" maxlength="1" value="<?PHP echo $sentence->sentence_type;?>"></td>
            </tr>
            <tr>
                <th>Probation ID</th>
                <td><input type="text" class="input" name="prob_ID" maxlength="5" value="<?PHP echo $sentence->prob_ID;?>"></td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td><input type="date" class="input" name="start_date" value="<?PHP echo $sentence->start_date;?>"></td>
            </tr>
            <tr>
                <th>End Date</th>
                <td><input type="date" class="input" name="end_date" value="<?PHP echo $sentence->end_date;?>"></td>
            </tr>
            <tr>
                <th>Violations</th>
                <td><input type="text" class="input" name="violations" maxlength="3" value="<?PHP echo $sentence->violations;?>"></td>
            </tr>
            <tr>
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
