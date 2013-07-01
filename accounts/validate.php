<?php
$con = mysqli_connect("localhost","root","123","collaborate");
$resp = "DENY";
if (!$con){
    echo $resp;
    return;
}
$user = $_POST['user'];
$pass = $_POST['pass'];
$query = "SELECT password FROM user WHERE username=\'".$user."\'";
$pass = hash("sha512", $pass, false);
$result = mysqli_query($con, $query);
if (!$result)
{
    echo $resp;
    die('');
}

mysqli_close($con);
echo $resp;
?>
