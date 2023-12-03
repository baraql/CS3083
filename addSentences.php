<?php
// Assuming you have a valid database connection stored in $con
// Ensure that the connection is established before this code

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
</head>
<body>

<!-- Your form to collect information about the new crime -->
<form method="post" action="">

<label for="sentenceID">Sentence ID:</label>
    <input type="text" name="sentenceID" required><br>

    <label for="sentenceType">Sentence Type:</label>
    <select name="sentenceType" required style="width: 100%; padding: 8px; margin-bottom: 16px; box-sizing: border-box;">
        <option>P</option>
        <option>N</option>
    </select><br>



    <label for="probID">Probation Officer ID:</label>
<select name="probID" required style="width: 100%; padding: 8px; margin-bottom: 16px; box-sizing: border-box;">
    <?php
    $sql = "SELECT * FROM `prob_officer`";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prob_id = $row['prob_ID'];
            $fname = $row['prob_name_first'];
            $lname = $row['prob_name_last'];

            echo "<option value='$prob_id'>$prob_id $fname $lname</option>";
        }
    }
    ?>
</select><br>







    <label for="startDate">Start Date:</label>
    <input type="date" name="startDate" required><br>

    <label for="endDate">End Date:</label>
    <input type="date" name="endDate" required><br>

    <label for="violations">Violations:</label>
    <input type="text" name="violations" required><br>

    <button type="submit">Submit</button>
    <button type="goback">    
        <a href="popup.php" style="text-decoration: none; color: inherit;">Go Back</a>
    </button>


</form>

</body>
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