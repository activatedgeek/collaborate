<?php
session_start();
if($_POST['type']=='session'){
	session_destroy();
	return;
}
$con = mysqli_connect("localhost","root","123","collaborate");
if(!$con){
    echo "Could not connect to DB server";
    mysqli_close($con);
    return;
}

else if($_POST['type']=='project'){
	//Delete all file relations
$query = "DELETE FROM file WHERE project_id= (SELECT project_id FROM project WHERE title='".$_POST['title']."')";
$result = mysqli_query($con,$query);
if(!$result){
		echo mysqli_error($con);
		mysqli_close($con);
	    return;
}
//Delete project
$query = "DELETE FROM project WHERE user_id=".$_SESSION['user']." AND title='".$_POST['title']."'";
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
//Delete project from directory

}

else if($_POST['type']=='file'){
$query = "SELECT `path` FROM file WHERE file_id=".$_POST['id'];
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
$path = mysqli_fetch_array($result);

$query = "DELETE FROM file WHERE file_id=".$_POST['id'];
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}

//Update last project edit
$query = "SELECT project_id AS pid FROM project WHERE title='".$_POST['title']."'";
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
$pid = mysqli_fetch_array($result);
$query = "UPDATE project SET last_pmodified=NOW() WHERE project_id=".$pid['pid'];
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}
//Delete file from directory
$target = "../projects/".$_POST['title']."/".$path['path'];
unlink($target);
}

if(isset($con))
	mysqli_close($con);
?>
