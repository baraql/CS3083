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
                        <input type="submit" value="Search"
                            style="width: 60px; height: 40px; margin-right: 10px; border-radius: 5px; background-color: #246583; color: #ffffff; cursor: pointer; transition: background-color 0.3s ease; border: none; text-align: center;"
                            onmouseover="this.style.backgroundColor='#205070'"
                            onmouseout="this.style.backgroundColor='#246583'">
                    </form>
                </li>
                <li>
                    <input type="button" value="Add new"
                        style="width: 80px; height: 40px; border-radius: 5px; background-color: #246583; color: #ffffff; cursor: pointer; transition: background-color 0.3s ease; border: none; text-align: center;"
                        onclick="location.href='cc_add_and_edit.php'" />
                </li>
            </ul>

        </nav>
        <nav class="header-main-logout">
            <ul>
                <li style="font-family: Futura, sans-serif; line-height: 1.5;"><a
                        style="font-family: Futura, sans-serif; line-height: 1.5;" href="logout.php">LOGOUT</a></li>

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
        foreach($result as $row){
            $cc = $row->cc;
            $cd = $row->cd;

            echo '<tr>
            <th scope="row">' . $cc . '</th>
            <td>' . $cd . '</td>

            <script>
                function deleteWithId(id){
                    if (window.confirm("Sure to delete crime_code infromation?")) {
                        var form1 = document.createElement("form");
                        form1.method = "POST";
                        form1.action = "cc.php?m=d";
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "cc";
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