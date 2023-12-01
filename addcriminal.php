<?php
include 'connect.php';

// MYSQLI VERSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $criminal_ID = $_POST['criminal_ID'];
        $criminal_name_first = $_POST['criminal_name_first'];
        $criminal_name_last = $_POST['criminal_name_last'];
        $criminal_street = $_POST['criminal_street'];
        $criminal_city = $_POST['criminal_city'];
        $criminal_state = $_POST['criminal_state'];
        $criminal_zip = $_POST['criminal_zip'];
        $criminal_phone = $_POST['criminal_phone'];
        $criminal_violent_status = $_POST['criminal_violent_status'];
        $criminal_probation_status = $_POST['criminal_probation_status'];

        $sql = "INSERT INTO `criminals` 
                (criminal_ID, criminal_name_first, criminal_name_last, criminal_street, criminal_city, 
                criminal_state, criminal_zip, criminal_phone, criminal_violent_status, criminal_probation_status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);

        // Bind parameters with values and execute the statement
        mysqli_stmt_bind_param($stmt, 'isssssssss', 
            $criminal_ID, $criminal_name_first, $criminal_name_last, 
            $criminal_street, $criminal_city, $criminal_state, 
            $criminal_zip, $criminal_phone, $criminal_violent_status, $criminal_probation_status);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Data inserted successfully
            header('location: criminal.php');
            exit; // Always exit after a header redirection to prevent further execution
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!-- HTML FORM -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <title>Add Criminal ID</title>
</head>

<body>
    <div class="container my-5">
        <form method="post">

            <!-- Criminal ID -->
            <div class="form-group">
                <label for="criminal_ID">Criminal ID</label>
                <input type="text" class="form-control" name="criminal_ID" autocomplete="off">
            </div>

            <!-- Criminal First Name -->
            <div class="form-group">
                <label for="criminal_name_first">Criminal First Name</label>
                <input type="text" class="form-control" name="criminal_name_first">
            </div>

            <!-- Criminal Last Name -->
            <div class="form-group">
                <label for="criminal_name_last">Criminal Last Name</label>
                <input type="text" class="form-control" name="criminal_name_last">
            </div>

            <!-- Criminal Street -->
            <div class="form-group">
                <label for="criminal_street">Criminal Street</label>
                <input type="text" class="form-control" name="criminal_street">
            </div>

            <!-- Criminal City -->
            <div class="form-group">
                <label for="criminal_city">Criminal City</label>
                <input type="text" class="form-control" name="criminal_city">
            </div>

            <!-- Criminal State -->
            <div class="form-group">
                <label for="criminal_state">Criminal State</label>
                <input type="text" class="form-control" name="criminal_state">
            </div>

            <!-- Criminal Zip -->
            <div class="form-group">
                <label for="criminal_zip">Criminal Zip</label>
                <input type="text" class="form-control" name="criminal_zip">
            </div>

            <!-- Criminal Phone -->
            <div class="form-group">
                <label for="criminal_phone">Criminal Phone</label>
                <input type="text" class="form-control" name="criminal_phone">
            </div>

            <!-- Violent Status -->
            <div class="form-group">
                <label for="criminal_violent_status">Violent Status</label>
                <input type="text" class="form-control" name="criminal_violent_status">
            </div>

            <!-- Probation Status -->
            <div class="form-group">
                <label for="criminal_probation_status">Probation Status</label>
                <input type="text" class="form-control" name="criminal_probation_status">
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>


<style>
    .container{
        background: #96B6C5;
        margin: 30px auto ; /* Add top and bottom margin, keep auto for horizontal centering */
 
    }

    .form-group{
        background: #EEE0C9; 
        margin: 30px; 
        padding: auto;

    }

    .form-control {
        background: #F1F0E8; 
    }


    .btn-primary {
        background-color: #EEE0C9; /* Set your desired color */
        color: black ; 
        border-color: black; /* Set your desired color */
    }
</style>