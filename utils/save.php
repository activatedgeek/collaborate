<?php
$target_dir = "../projects/";
$title = $_POST['title']."/";
$subdir = $_POST['folder'];

$con = mysqli_connect("localhost","root","123","collaborate");
if(!$con){
    echo "Could not connect to DB server";
    mysqli_close($con);
    return;
}
$temp_path = $target_dir.$title.$subdir;
$rename = false;
if($_POST['old_name']!=$_POST['curr_name'] && !file_exists($temp_path.$_POST['curr_name'])){
  $query = "UPDATE file SET `path`='".($subdir==''?$_POST['curr_name']:$subdir.$_POST['curr_name'])."',last_fmodified=NOW() WHERE file_id=".$_POST['fid'];
	$result = mysqli_query($con,$query);
	if(!$result){
		echo "QUERY ERROR";
	 	mysqli_close($con);
	    return;
	}
	if(rename($temp_path.$_POST['old_name'],$temp_path.$_POST['curr_name']))
		$rename = true;
}

$temp_path = $temp_path.($rename==true?$_POST['curr_name']:$_POST['old_name']);

$filedata = $_POST['filedata'];
if(file_exists($temp_path)){
	$file = fopen($temp_path,"w");
	fwrite($file,$filedata);
	fclose($file);
}
$query = "UPDATE file SET last_fmodified=NOW() WHERE file_id=".$_POST['fid'];
$result = mysqli_query($con,$query);
if(!$result){
	echo "QUERY ERROR";
 	mysqli_close($con);
    return;
}

$query = "SELECT project_id AS pid FROM project WHERE title='".$_POST['title']."'";
$result = mysqli_query($con,$query);
if(!$result){
	echo "QUERY ERROR";
 	mysqli_close($con);
    return;
}
$pid = mysqli_fetch_array($result);
$query = "UPDATE project SET last_pmodified=NOW() WHERE project_id=".$pid['pid'];
$result = mysqli_query($con,$query);
if(!$result){
	echo "QUERY ERROR";
 	mysqli_close($con);
    return;
}
echo "OK";
?>
