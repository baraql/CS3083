<?php
session_start();
include_once 'probation_functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

$result = [];
$method = array_key_exists('m', $_GET) ? $_GET['m'] : 'l';
if ($method == 's') {
    $result = search_probation();
} elseif ($method == 'd') {
    delete_probation();
    header("location:probation.php");
}
else {
    $result = list_probation();
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
        <nav class="header-main-nav">
            <ul>
            <li>
                <form id="search_form" method="post" action="probation.php?m=s">
                    <input type="search" name="search_text">
                    <select id="field" name="field">
                        <option value="prob_ID">id</option>
                        <option value="prob_name_first">First Name</option>
                        <option value="prob_name_last">Last Name</option>
                        <option value="prob_street">Street</option>
                        <option value="prob_city">City</option>
                        <option value="prob_state">State</option>
                        <option value="prob_zip">Zip</option>
                        <option value="prob_phone">Phone</option>
                        <option value="prob_email">Email</option>
                    </select>
                    <input type="submit" value="Search"> 
                </form>
            </li>
            <li>
                    <input type="button" value="Add new" onclick="location.href='probation_add_and_edit.php'"/>
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
            <th>Operations</th>
          </tr>
        </thead>
        <tbody>
        <?php
            // $sql = "SELECT * FROM `prob_officer`";
            // $result = mysqli_query($con, $sql);

            // if ($result) {
            //     while ($row = mysqli_fetch_assoc($result)) {
            //         $id = $row['prob_ID'];
            //         $fname = $row['prob_name_first'];
            //         $lname = $row['prob_name_last'];
            //         $street = $row['prob_street'];
            //         $city = $row['prob_city'];
            //         $state = $row['prob_state'];
            //         $zip = $row['prob_zip'];
            //         $phone = $row['prob_phone'];
            //         $email = $row['prob_email'];
            //         $status = $row['prob_status'];

            //         echo '<tr>
            //             <th scope="row">' . $id . '</th>
            //             <td>' . $fname . '</td>
            //             <td>' . $lname . '</td>
            //             <td>' . $street . '</td>
            //             <td>' . $city . '</td>
            //             <td>' . $state . '</td>
            //             <td>' . $zip . '</td>
            //             <td>' . $phone . '</td>
            //             <td>' . $email . '</td>
            //             <td>' . $status . '</td>
            //         </tr>';
            //     }
            // }
            foreach($result as $row){
                $id = $row->id;
                $fname = $row->fname;
                $lname = $row->lname;
                $street = $row->street;
                $city = $row->city;
                $state = $row->state;
                $zip = $row->zip;
                $phone = $row->phone;
                $email = $row->email;
                $status = $row->status;

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

                <script>
                    function deleteWithId(id, name){
                        if (window.confirm("Sure to delete Probation Officer infromation from \'" + name + "\'?")) {
                            var form1 = document.createElement("form");
                            form1.method = "POST";
                            form1.action = "probation.php?m=d";
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
                <a href="#" class="more" onclick="deleteWithId(' . $id . ', \'' . $fname . ' ' . $lname . '\')">
                    <button type="button">Delete</button>
                </a>

                <a href="probation_add_and_edit.php?m=e&probation_ID='. $id .'" class="more")">
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
