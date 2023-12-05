<?php

include 'connect.php';
include_once "addco_functions.php";

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}
/* 
criminal_ID 
crime_ID
officer_ID 
*/ 

$criminal_ID = array_key_exists("criminal_ID", $_GET) ? $_GET['criminal_ID'] : null;
if ($criminal_ID == null) {
    header("Location: criminal.php");
    exit();
}

//im assuming this is for either edit or appeal 
if (isset($_GET['officer_ID'])) {
    //only delete and update send a 'm' val 
    //delete: $method = d 
    //update: $method = u 
    $method = $_GET['m']; 

} else {
    //add: $method = a 
    $method = 'a';
} 

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Crime Officers</title>
    <!-- the whole "check" function, I don't think we need-->
    <script>
    function check(form) {
        return true;
    }
    </script>



</head>

<body>
    <form method="post" action="addco_functions.php" onsubmit="return check(this);">
        <input type="hidden" name="m" value="<?php echo $method; ?>" />
        <input type="hidden" name="criminal_ID" value="<?php echo $criminal_ID; ?>" />
        <input type="hidden" name="crime_ID" value="<?php echo $crime_ID; ?>" />


        <label for="crime_officers">Crime Officer:</label>
        <select id="officer_ID" name="officer_ID" required
            style="width: 100%; padding: 8px; margin-bottom: 16px; box-sizing: border-box;">
            <?php
                    $OfficersQuery = "SELECT * FROM officers";
                    $OfficersQuery = mysqli_query($con, $OfficersQuery);
                    while ($Officer = mysqli_fetch_assoc($OfficersQuery)) {
                        echo '<option value="' . $Officer['officer_ID'] . '">';
                        echo $Officer['officer_ID'] . ' (' . $Officer['officer_name_first'] . ' ' . $Officer['officer_name_last'] . ')';
                        echo '</option>';
                    } 
                ?>
        </select><br>

        <button type="submit">Submit</button>
        <a href="popup.php?criminal_ID=<?php echo $criminal_ID; ?>" style="text-decoration: none; color: inherit;">
            <button type="button">Go Back</button>
        </a>


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