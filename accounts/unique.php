<?php
$con = mysqli_connect("localhost","root","123","collaborate");
$resp = 'OK';

if(!$con){
    $resp = 'DENY';
    echo $resp;
    mysqli_close($con);
    return;
}

$username = $_POST['username'];
$query = "SELECT username FROM user WHERE username='".$username."'";
$result = mysqli_query($con, $query);
if (!$result)
{
    $resp = 'DENY';
    mysqli_close($con);
    echo $resp;
    return;
}

$number_of_rows = $result->num_rows;
if ($number_of_rows > 0)
{
    $resp = 'DENY';    
    mysqli_close($con);
    echo $resp;
    return;
}

echo $resp;
?>
