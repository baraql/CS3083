<?php

include 'connect.php';
include_once "appeals_function.php";

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

$criminal_ID = array_key_exists("criminal_ID", $_GET) ? $_GET['criminal_ID'] : null;
if ($criminal_ID == null) {
    header("Location: criminal.php");
    exit();
}

if (isset($_GET['appeal_ID'])) {
    $method = $_GET['m'];
} else {
    $method = 'a';
}

$crime_ID = array_key_exists("crime_ID", $_REQUEST) ? $_REQUEST['crime_ID'] : null;

$appealID = array_key_exists("appeal_ID", $_GET) ? $_GET['appeal_ID'] : null;
$appeal = new Appeal;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appeals</title>
    <script>
    function check(form) {
        var appeal_ID = form['appeal_ID'];
        var appeal_status = form['appeal_status'];
        var filing_date = form['filing_date'];
        var hearing_date = form['hearing_date'];
        var result = false;

        if (isNaN(appeal_ID.value) || appeal_ID.value.trim().length < 5) {
            alert('The Appeal ID must be a 5-length numeric value.');
            appeal_ID.focus();
        } else if (appeal_status.value.trim() == '') {
            alert('The Appeal Status cannot be null.');
            appeal_status.focus();
        } else if (filing_date.value.trim() == '') {
            alert('The Filing Date cannot be null.');
            filing_date.focus();
        } else if (hearing_date.value.trim() == '') {
            alert('The Hearing Date cannot be null.');
            hearing_date.focus();
        } else {
            result = true;
        }

        return result;
    }
    </script>
</head>

<body>

    <form method="post" action="appeals_function.php" onsubmit="return check(this);">
        <input type="hidden" name="m" value="<?php echo $method; ?>" />
        <input type="hidden" name="criminal_ID" value="<?php echo $criminal_ID; ?>" />

        <input type="hidden" name="m" value="<?php echo $method; ?>" />
        <input type="hidden" name="crime_ID" value="<?php echo $crime_ID; ?>" />

        <label for="appeal_ID">Appeal ID:</label>
        
        <?php
$disabled = '';
if ($method === 'u') {
    $disabled = 'readonly';
}
?>
        <input type="text" name="appeal_ID" maxlength="9"
            value="<?php echo isset($_GET['appeal_ID']) ? htmlspecialchars($_GET['appeal_ID']) : ''; ?>"
            <?php echo $disabled; ?>><br>



        <label for="appeal_status">Appeal Status:</label>
        <select id="appeal_status" name="appeal_status" required
            style="width: 100%; padding: 8px; margin-bottom: 16px; box-sizing: border-box;">
            <option value="P" <?php if (isset($_GET['appeal_status']) && htmlspecialchars($_GET['appeal_status']) === 'P')
                echo 'selected'; ?>>
                Pending</option>
            <option value="A" <?php if (isset($_GET['appeal_status']) && htmlspecialchars($_GET['appeal_status']) === 'A')
                echo 'selected'; ?>>
                Approved</option>

        </select><br>

        <label for="filing_date">Filing Date:</label>
        <input type="date" name="filing_date" required
            value="<?php echo isset($_GET['filing_date']) ? htmlspecialchars($_GET['filing_date']) : ''; ?>"><br>

        <label for="hearing_date">Hearing Date:</label>
        <input type="date" name="hearing_date" required
            value="<?php echo isset($_GET['hearing_date']) ? htmlspecialchars($_GET['hearing_date']) : ''; ?>"><br>


        <button type="submit">Submit</button>
        <button type="button">
            <a href="popup.php?criminal_ID=<?php echo $criminal_ID; ?>"
                style="text-decoration: none; color: inherit;">Go Back</a>
        </button>
    </form>

    <script>
    document.getElementById("appeal_status").value = "<?php echo $appeal->appeal_status; ?>";
    </script>

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

</body>

</html>