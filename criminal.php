<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // echo "not logged in";
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
                <li class="active"><a href="criminal.php">CRIMINALS</a></li>
                <li><a href="police.php">POLICE</a></li>
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
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Phone</th>
                <th>Operations</th>


            </tr>
        </thead>
        <tbody>

            <?php
            $sql = "SELECT * FROM `criminals`";
            $result = mysqli_query($con, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['criminal_ID'];
                    $fname = $row['criminal_name_first'];
                    $lname = $row['criminal_name_last'];
                    $street = $row['criminal_street'];
                    $city = $row['criminal_city'];
                    $state = $row['criminal_state'];
                    $zip = $row['criminal_zip'];
                    $phone = $row['criminal_phone'];

                    echo '<tr>
                    <th scope="row">' . $id . '</th>
                    <td>' . $fname . '</td>
                    <td>' . $lname . '</td>
                    <td>' . $street . '</td>
                    <td>' . $city . '</td>
                    <td>' . $state . '</td>
                    <td>' . $zip . '</td>
                    <td>' . $phone . '</td>
                    
                    <script>
    function submitFormWithId(id) {
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "popup.php";
        
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "id";
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        
        form.submit();
    }
</script>


                    <td>
                    <a href="#" class="more" onclick="submitFormWithId(' . $id . ')">
                        <button type="button">More</button>
                    </a>
                    </td>
                
                </tr>';
                }
            }
            ?>

            <script>
                const from = document.getElementByID('form')
            </script>



        </tbody>
    </table>



</body>

</html>