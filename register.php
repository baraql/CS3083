<?php
include "connect.php";
// Set your valid username and password here
$valid_username = 'user';
$valid_password = 'pass';

// Get the values from the form
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$username = $_POST['uname'];
$password = md5($_POST['pwd']);



// database connection
$sql = "INSERT into users(firstname, lastname, username, password) values('$firstname','$lastname','$username','$password')";
$result = mysqli_query($con, $sql);
if($result){
	echo $firstname. " is registered succesfully!";
}

	$con->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Status</title>
</head>
<body>
    <button onclick="window.location.href = 'index.html';">Go Back to Login</button>
</body>
</html>