<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}
include 'connect.php';
?>

<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styleNav.css">
    <link rel="stylesheet" href="styleTable.css">


</head>

<body>
    <header class = "header-main"> 
        <nav class = "header-main-nav" >
        <ul>
            <li><a href="criminal.php">CRIMINALS</a></li>
            <li><a href="police.php">POLICE</a></li>
            <li class="active"><a href="probation.php">PROBATION OFFICERS</a></li>
            <li><a href="cc.php">CRIME CODES </a></li>
         
        </ul>
        </nav>
        <nav class = "header-main-logout">
        <ul>
        <li><a href="logout.php">LOGOUT</a></li>
        
        </ul>
        </nav>

    </header>


    <table class="content-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Street</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>

          </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT * FROM `prob_officer`";
            $result = mysqli_query($con, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['prob_ID'];
                    $fname = $row['prob_name_first'];
                    $lname = $row['prob_name_last'];
                    $street = $row['prob_street'];
                    $city = $row['prob_city'];
                    $state = $row['prob_state'];
                    $zip = $row['prob_zip'];
                    $phone = $row['prob_phone'];
                    $email = $row['prob_email'];
                    $status = $row['prob_status'];

                    echo '<tr>
                        <th scope="row">' . $id . '</th>
                        <td>' . $fname . '</td>
                        <td>' . $lname . '</td>
                        <td>' . $street . '</td>
                        <td>' . $city . '</td>
                        <td>' . $state . '</td>
                        <td>' . $zip . '</td>
                        <td>' . $phone . '</td>
                        <td>' . $email . '</td>
                        <td>' . $status . '</td>
                    </tr>';
                }
            }
            ?>

        </tbody>
      </table>
























</body>


</html>