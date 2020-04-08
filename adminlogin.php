<?php
$con = mysqli_connect('localhost', 'root', '');

if (!$con) {
    echo 'Server not connected!';
}

if (!mysqli_select_db($con, 'ksk')) {
    echo 'Database not selected.';
}

if (isset($_POST['submit'])){
$Username = $_POST['username'];
$Password = $_POST['password'];

// to check in database
$sql = "SELECT * FROM admin
WHERE Username = '$Username'
AND Password = '$Password'";

if (!mysqli_query($con, $sql)) {
    echo 'Not inserted';
    header('refresh: 2; url = index.php');
} else 
    header("refresh: 2; url = admin.php");
}
?>