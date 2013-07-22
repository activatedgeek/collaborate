<?php
$con = mysqli_connect("localhost","root","123","collaborate");
if(!$con){
    mysqli_close($con);
    echo "CONNECTION FAIL";
    return;
}
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = hash("sha512", $password, false);
$values = "'".$username."',NOW(),'".$firstName."','".$lastName."','".$password."','".$email."'";
$query = "INSERT INTO user(`username`,`joined`,`first_name`,`last_name`,`password`,`email`) VALUES (".$values.")";
if(!mysqli_query($con, $query)){
    echo mysqli_error($con);
    return;
}
echo "OK";
?>
