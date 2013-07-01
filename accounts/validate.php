<?php
$con = mysqli_connect("localhost","root","123","collaborate");
$resp = "DENY";
if(!$con){
    echo $resp;
    mysqli_close($con);
    return;
}
$user = $_POST['user'];
$pass = $_POST['pass'];
$query = "SELECT password FROM user WHERE username='".$user."'";
$pass = hash("sha512", $pass, false);
$result = mysqli_query($con, $query);
if (!$result)
{
    echo $resp;
    mysqli_close($con);
    return;
}
while($row = mysqli_fetch_array($result)){
    if($row['password'] == $pass){
        $resp = 'OK';
        mysqli_close($con);
        echo $resp;
        return;
    }
    else{
        mysqli_close($con);
        echo $resp;
        return;
    }
}

echo $resp;
?>
