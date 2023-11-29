<?php
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
            <li><a href="probation.php">PROBATION OFFICERS</a></li>
            <li class="active"><a href="cc.php">CRIME CODES </a></li>
         
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
            <th>Crime Codes</th>
            <th>Crime Description</th>
  

          </tr>
        </thead>
        <tbody>

        <?php
        $sql = "SELECT * FROM `crime_codes`";
        $result = mysqli_query($con, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $crimeCode = $row['crime_code'];
                $codeDescription = $row['code_description'];

                echo '<tr>
                    <th scope="row">'.$crimeCode.'</th>
                    <td>'.$codeDescription.'</td>
                    
                </tr>';
            }
        }
     ?>

        </tbody>
      </table>


    

</body>
</html>