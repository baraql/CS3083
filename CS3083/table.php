<?php
include 'connect.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Style HTML Tables with CSS</title>
    <link rel="stylesheet" href="styleTable.css">
</head>
<body>
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
                $city  = $row['criminal_city'];
                $state  = $row['criminal_state'];
                $zip  = $row['criminal_zip'];
                $phone  = $row['criminal_phone'];

                echo '<tr>
                    <th scope="row">'.$id.'</th>
                    <td>'.$fname.'</td>
                    <td>'.$lname.'</td>
                    <td>'.$street.'</td>
                    <td>'.$city.'</td>
                    <td>'.$state.'</td>
                    <td>'.$zip.'</td>
                    <td>'.$phone.'</td>
                </tr>';
            }
        }
    ?>





        </tbody>
      </table>
</body>
</html>

