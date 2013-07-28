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
//Get current username
$query = "SELECT username FROM user WHERE user_id=".$_SESSION['user'];
$result = mysqli_query($con,$query);
if(!$result){
	mysqli_close($con);
    return;
}
$username = mysqli_fetch_array($result);

if($_POST['object']=='project'){
	//Make folder on file system
if(!mkdir("../projects/".$_POST['title'],0777,true)){
	echo "Directory make unsuccessful";
	return;
}

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

else if($_POST['object']=='file'){
$query = "INSERT INTO file(`project_id`,`path`,`created`,`last_fmodified`,`last_fmodified_by`) VALUES (".$_POST['pid'].",'".$_POST['path']."',NOW(),NOW(),'".$username['username']."')";
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
$query = "UPDATE project SET last_pmodified=NOW() WHERE project_id=".$_POST['pid'];
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
//adding the physical copy of file on file system
$target_path = "../projects/".$_POST['title']."/".$_POST['path'];
if(!is_dir(dirname($target_path)))
	mkdir(dirname($target_path),0777,true);
$newfile = fopen($target_path,"w");
fclose($newfile);
}

if(isset($con))
	mysqli_close($con);
?>
