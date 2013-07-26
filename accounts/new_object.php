<?php
//Setting up new entries in DB for project/file/commits/issues
session_start();
if(!isset($_POST['object'])){
  header('Location: http:locahost/collaborate/canvas.php?id='.$_SESSION['user']);
	return;
}
$con = mysqli_connect("localhost","root","123","collaborate");
if(!$con){
    echo "Could not connect to DB server";
    mysqli_close($con);
    return;
}
if($_POST['object']=='project'){
$query = "SELECT username FROM user WHERE user_id=".$_SESSION['user'];
$result = mysqli_query($con,$query);
if(!$result){
	mysqli_close($con);
    return;
}
$username = mysqli_fetch_array($result);
if($_POST['due']==''){
	$due = "ADDDATE(DATE(NOW()),INTERVAL 15 DAY)";
	$values = "'".$_SESSION['user']."','".$_POST['type']."','".$_POST['title']."','".$_POST['desc']."',NOW(),".$due.",NOW(),'".$username['username']."'";
}
else{
	$due = $_POST['due'];
	$values = "'".$_SESSION['user']."','".$_POST['type']."','".$_POST['title']."','".$_POST['desc']."',NOW(),'".$due."',NOW(),'".$username['username']."'";
}
$query = "INSERT INTO project(`user_id`,`type`,`title`,`description`,`created`,`due_date`,`last_pmodified`,`last_pmodified_by`) VALUES (".$values.")";

$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
echo "QUERY SUCCESSFUL";
}

if(isset($con))
	mysqli_close($con);
?>
