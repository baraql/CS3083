<?php
include "connect.php";

$valid_username = 'user';
$valid_password = 'pass';


$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$username = $_POST['uname'];
$password = md5($_POST['pwd']);
if (isset($_POST['isAdmin'])) {
    $admin = $_POST['isAdmin'];
} else {
    $admin = 0;
}


$sql = "INSERT into users(firstname, lastname, username, password, isAdmin) values('$firstname','$lastname','$username','$password', '$admin')";
$result = mysqli_query($con, $sql);
if($result){
	echo $firstname. " is registered succesfully!";
}

if ($admin) {
    $access = "Grant admin to $username WITH admin options";
    mysqli_query($con, $access);
}
else {  
    $access = "Grant user to $username"; 
    mysqli_query($con, $access);
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