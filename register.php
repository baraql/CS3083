<?php
include "connect.php";
$valid_username = 'user';
$valid_password = 'pass';
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$username = $_POST['uname'];
$password = md5($_POST['pwd']);
if (isset($_POST['admin'])) {
    $admin = $_POST['admin'];
} else {
    $admin = -1;
}
if (isset($_POST['isAdmin'])) {
    $isAdmin = $_POST['isAdmin'];
} else {
    $isAdmin = 0;
}


$sql = "INSERT into users(firstname, lastname, username, password, isAdmin) values('$firstname','$lastname','$username','$password', '$isAdmin')";
$result = mysqli_query($con, $sql);
if($result){
	echo $firstname. " is registered succesfully!";
}

if ($admin === 1) {
    $access = "Grant admin to $username WITH admin options";
    mysqli_query($con, $access);
}
else if ($admin === 0) {
    echo "username: $username";
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