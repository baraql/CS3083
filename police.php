<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}
include 'connect.php';
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
</head>

<body>
    <header class="header-main">
        <nav class="header-main-nav">
            <ul>
                <li><a href="criminal.php">CRIMINALS</a></li>
                <li class="active"><a href="police.php">POLICE</a></li>
                <li><a href="probation.php">PROBATION OFFICERS</a></li>
                <li><a href="cc.php">CRIME CODES </a></li>
            </ul>
        </nav>
        <nav class="header-main-logout">
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
                <th>Precinct</th>
                <th>Badge</th>
                <th>Phone</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>



            <?php
            $sql = "SELECT * FROM `officers`";
            $result = mysqli_query($con, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['officer_ID'];
                    $fname = $row['officer_name_first'];
                    $lname = $row['officer_name_last'];
                    $precinct = $row['officer_precinct'];
                    $badge = $row['officer_badge'];
                    $phone = $row['officer_phone'];
                    $status = $row['officer_status'];

                    echo '<tr>
                            <th scope="row">' . $id . '</th>
                            <td>' . $fname . '</td>
                            <td>' . $lname . '</td>
                            <td>' . $precinct . '</td>
                            <td>' . $badge . '</td>
                            <td>' . $phone . '</td>
                            <td>' . $status . '</td>
                        </tr>';
                }
            }
            ?>





</body>

</html>