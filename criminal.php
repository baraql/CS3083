<?php
session_start();
include_once 'criminal_functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}
include 'connect.php';

$result = [];
$method = array_key_exists('m', $_GET) ? $_GET['m'] : 'l';
if ($method == 's') {
    $result = search_cirminal();
} elseif ($method == 'd') {
    delete_criminal();
    header("location:criminal.php");
}
else {
    $result = list_criminal();
}

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
                <li class="active"><a href="criminal.php">CRIMINALS</a></li>
                <li><a href="police.php">POLICE</a></li>
                <li><a href="probation.php">PROBATION OFFICERS</a></li>
                <li><a href="cc.php">CRIME CODES </a></li>
            </ul>
        </nav>
        <nav class="header-main-nav">
            <ul>
            <li>
                <form id="search_form" method="post" action="criminal.php?m=s">
                    <input type="search" name="search_text">
                    <select id="field" name="field">
                        <option value="criminal_ID">id</option>
                        <option value="criminal_name_first">First Name</option>
                        <option value="criminal_name_last">Last Name</option>
                        <option value="criminal_street">Street</option>
                        <option value="criminal_city">City</option>
                        <option value="criminal_state">State</option>
                        <option value="criminal_zip">Zip</option>
                        <option value="criminal_phone">Phone</option>
                    </select>
                    <input type="submit" value="Search"> 
                </form>
            </li>
            <li>
                    <input type="button" value="Add new" onclick="location.href='criminal_add_and_edit.php'"/>
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
            foreach ($result as $row) {
                    $id = $row->id;
                    $fname = $row->fname;
                    $lname = $row->lname;
                    $street = $row->street;
                    $city = $row->city;
                    $state = $row->state;
                    $zip = $row->zip;
                    $phone = $row->phone;

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
                            input.name = "criminal_ID";
                            input.value = id;
                            
                            form.appendChild(input);
                            document.body.appendChild(form);
                            
                            form.submit();
                        };
                        
                        function deleteWithId(id, name) {
                            if (window.confirm("Sure to delete criminal infromation from \'" + name + "\'?")) {
                                var form1 = document.createElement("form");
                                form1.method = "POST";
                                form1.action = "criminal.php?m=d";

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
                    <a href="#" class="more" onclick="submitFormWithId(' . $id . ')">
                        <button type="button">More</button>
                    </a>
                    
                    <a href="#" class="more" onclick="deleteWithId(' . $id . ', \'' . $fname . ' ' . $lname . '\')">
                        <button type="button">Delete</button>
                    </a>

                    <a href="criminal_add_and_edit.php?m=e&criminal_ID='. $id .'" class="more")">
                        <button type="button">Edit</button>
                    </a>
                    </td>
                
                </tr>';
            }
            ?>

        </tbody>
    </table>


    <script>
    function redirectToNewPage() {
        var newPageUrl = 'addcriminal.php';
        
        window.location.href = newPageUrl;
    }
</script>


    



</body>

</html>