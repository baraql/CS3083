<?php
session_start();
include_once 'cc_functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

$result = [];
$method = array_key_exists('m', $_GET) ? $_GET['m'] : 'l';
if ($method == 's') {
    $result = search_crime_code();
} elseif ($method == 'd') {
    delete_crime_code();
    header("location:cc.php");
}
else {
    $result = list_crime_code();
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
            <li><a href="probation.php">PROBATION OFFICERS</a></li>
            <li class="active"><a href="cc.php">CRIME CODES </a></li>
        </ul>
        </nav>
        <nav class="header-main-nav">
            <ul>
            <li>
                <form id="search_form" method="post" action="cc.php?m=s">
                    <input type="search" name="search_text">
                    <select id="field" name="field">
                        <option value="crime_code">Crime Code</option>
                        <option value="code_description">Code Description</option>
                    </select>
                    <input type="submit" value="Search"> 
                </form>
            </li>
            <li>
                    <input type="button" value="Add new" onclick="location.href='cc_add_and_edit.php'"/>
            </li>
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
            <th>Code Description</th>
            <th>Operations</th>
          </tr>
        </thead>
        <tbody>

        <?php
        // $sql = "SELECT * FROM `crime_codes`";
        // $result = mysqli_query($con, $sql);

        // if ($result) {
        //     while ($row = mysqli_fetch_assoc($result)) {
        //         $crimeCode = $row['crime_code'];
        //         $codeDescription = $row['code_description'];

        //         echo '<tr>
        //             <th scope="row">'.$crimeCode.'</th>
        //             <td>'.$codeDescription.'</td>
                    
        //         </tr>';
        //     }
        foreach($result as $row){
            $cc = $row->cc;
            $cd = $row->cd;

            echo '<tr>
            <th scope="row">' . $cc . '</th>
            <td>' . $cd . '</td>

            <script>
                function deleteWithId(id, name){
                    if (window.confirm("Sure to delete crime_code infromation from \'" + name + "\'?")) {
                        var form1 = document.createElement("form");
                        form1.method = "POST";
                        form1.action = "cc.php?m=d";
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "id";
                        input.value = id;

                        form1.appendChild(input);
                        document.body.appendChild(form1);
                        form1.submit();
                    }
                }
            </script>

            <td>
            <a href="#" class="more" onclick="deleteWithId(\'' . $cc . '\')">
                <button type="button">Delete</button>
            </a>

            <a href="cc_add_and_edit.php?m=e&crime_code='. $cc .'" class="more")">
                <button type="button">Edit</button>
            </a>
            </td>
        
        </tr>';
        }
     ?>

        </tbody>
      </table>


    

</body>
</html>