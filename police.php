<?php
session_start();
include_once 'police_functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

$result = [];
$method = array_key_exists('m', $_GET) ? $_GET['m'] : 'l';
if ($method == 's') {
    $result = search_police();
} elseif ($method == 'd') {
    delete_police();
    header("location:police.php");
}
else {
    $result = list_police();
}

include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <nav class="header-main-nav">
            <ul>
                <li>
                    <form id="search_form" method="post" action="police.php?m=s">
                        <input type="search" name="search_text">
                        <select id="field" name="field">
                            <option value="officer_ID">id</option>
                            <option value="officer_name_first">First Name</option>
                            <option value="officer_name_last">Last Name</option>
                            <option value="officer_precinct">Precinct</option>
                            <option value="officer_badge">Badge</option>
                            <option value="officer_phone">Phone</option>
                            <option value="officer_status">Status</option>
                        </select>
                        <input type="submit" value="Search"
                            style="width: 60px; height: 40px; margin-right: 10px; border-radius: 5px; background-color: #246583; color: #ffffff; cursor: pointer; transition: background-color 0.3s ease; border: none; text-align: center;"
                            onmouseover="this.style.backgroundColor='#205070'"
                            onmouseout="this.style.backgroundColor='#246583'">
                    </form>
                </li>
                <li>
                    <input type="button" value="Add new"
                        style="width: 80px; height: 40px; border-radius: 5px; background-color: #246583; color: #ffffff; cursor: pointer; transition: background-color 0.3s ease; border: none; text-align: center;"
                        onclick="location.href='police_add_and_edit.php'" />
                </li>
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
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>

            <?php

                foreach($result as $row){
                    $id = $row->id;
                    $fname = $row->fname;
                    $lname = $row->lname;
                    $precinct = $row->precinct;
                    $badge = $row->badge;
                    $phone = $row->phone;
                    $status = $row->status;

                    echo '<tr>
                    <th scope="row">' . $id . '</th>
                    <td>' . $fname . '</td>
                    <td>' . $lname . '</td>
                    <td>' . $precinct . '</td>
                    <td>' . $badge . '</td>
                    <td>' . $phone . '</td>
                    <td>' . $status . '</td>

                    <script>
                        function deleteWithId(id, name){
                            if (window.confirm("Sure to delete police infromation from \'" + name + "\'?")) {
                                var form1 = document.createElement("form");
                                form1.method = "POST";
                                form1.action = "police.php?m=d";
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

                    <a href="police_add_and_edit.php?m=e&officer_ID='. $id .'" class="more")">
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
<style>
.more,
.J {
    display: inline-block;
    text-decoration: none;
}

.more button,
.J button {
    width: 50px;
    height: 40px;
    border-radius: 5px;
    background-color: #246583;
    color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border: none;
}

.more button:hover,
.J button:hover {
    background-color: #205070;
}
</style>