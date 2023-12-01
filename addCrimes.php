<?php
// Assuming you have a valid database connection stored in $con
// Ensure that the connection is established before this code

include 'connect.php';
// Check if the criminal ID is provided in the query parameter
if(isset($_GET['id'])) {
    $criminalID = $_GET['id'];
} else {
    // If the criminal ID is not provided, display an error message or redirect the user
    echo '<p>Error: Criminal ID not provided</p>';
    // You might want to add additional error handling here, such as redirecting the user to an error page.
    exit();
}
?>














<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Crime</title>
</head>
<body>

<!-- Your form to collect information about the new crime -->
<form method="post" action="">

<label for="crimeID">Crime ID:</label>
    <input type="text" name="crimeID" required><br>

    <label for="crimeClass">Crime Classification:</label>
    <input type="text" name="crimeClass" required><br>



    <label for="crimeStatus">Crime Status:</label>
    <select name="crimeStatus" required style="width: 100%; padding: 8px; margin-bottom: 16px; box-sizing: border-box;">
        <option>P</option>
        <option>C</option>
    </select><br>

    <label for="startDate">Date Charged:</label>
    <input type="date" name="startDate" required><br>

    <label for="endDate">Hearing Date:</label>
    <input type="date" name="endDate" required><br>

    <label for="endDate">Appeal Cut Date:</label>
    <input type="date" name="endDate" required><br>


    <button type="submit">Submit</button>
    <button type="goback">    
        <a href="popup.php" style="text-decoration: none; color: inherit;">Go Back</a>
    </button>


</form>

</body>
</html>













<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #4caf50;
        }

        .error-message {
            color: #f44336;
        }
     
    </style>