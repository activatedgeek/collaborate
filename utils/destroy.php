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
$query = "DELETE FROM file WHERE project_id= (SELECT project_id FROM project WHERE title='".$_POST['title']."')";
$result = mysqli_query($con,$query);
if(!$result){
		echo mysqli_error($con);
		mysqli_close($con);
	    return;
}
$query = "DELETE FROM project WHERE user_id=".$_SESSION['user']." AND title='".$_POST['title']."'";
$result = mysqli_query($con,$query);
if(!$result){
	echo mysqli_error($con);
	mysqli_close($con);
    return;
}

}

if(isset($con))
	mysqli_close($con);
?>
