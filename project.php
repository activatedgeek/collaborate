<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: http://localhost/collaborate/login.php');
}
$con = mysqli_connect("localhost","root","123","collaborate");
if(!$con){
    echo "Could not connect to DB server";
    mysqli_close($con);
    //return;
}
$query = "SELECT username,avatar FROM user WHERE user_id='".$_SESSION['user']."'";
$result = mysqli_query($con, $query);
if(!$result){
	echo "Query Failed";
    mysqli_close($con);
    //return;
}
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<title><?php 
  		if(isset($_GET['type'])){
  			echo $row['username'],"'s ",$_GET['type']," Project";
  		}
  		else if(isset($_GET['title'])){
  			echo "Project: ",$_GET['title'];
  		}
  	?>
  	</title> <!--Change title to the the username's canvas -->

  	<link rel="shortcut icon" href="http://localhost/collaborate/icons/collaborate.ico">
	<script src="js/jquery.js"></script>
  	<link rel="stylesheet" type="text/css" href="stylesheets/navs.css">
    <?php
    	echo "<link rel='stylesheet' type='text/css' href='stylesheets/",basename(__FILE__,'.php'),".css'>";
    	echo "<script type='text/javascript' src='js/",basename(__FILE__,'.php'),".js'></script>";
	?>
</head>
<body>
	<?php include 'utils/navbar.html';?>
	<div id="details">
		<?php
		if(isset($_GET['type']) && $_GET['type']=='New'){
			echo "<div id='subcall'><span id='field_title'>new project details</span></div>
				<table class='details'> 
				<tr><td class='subdetails'>Title</td><td><input class='genCreds' id='title' type='text' placeholder='Title goes here'></td></tr>
				<tr><td class='subdetails'>Description</td><td><textarea maxlength='500' placeholder='max. 500 characters'></textarea></td></tr>
				<tr><td class='subdetails'>Due Date</td><td><input class='genCreds' id='due' type='text' placeholder='YYYY-MM-DD'></td></tr>
				<tr><td class='subdetails'></td><td><span id='default_due'>Default is 15 days</span></td></tr>
				<tr><td class='subdetails'>Type</td><td><input type='radio' name='type' value='public' checked><span class='radio'>&nbsp&nbspPublic&nbsp&nbsp</span><input type='radio' name='type' value='private'><span class='radio'>&nbsp&nbspPrivate&nbsp&nbsp</span></td></tr>
				</table>
				<input id='create' class='generalButton' type='button' value='Create New Project'/>";
			}
		else if(isset($_GET['title'])){
				$query = "SELECT project_id AS pid,type,description AS des,created ,DATEDIFF(due_date,DATE(NOW())) AS due,TIME_TO_SEC(TIMEDIFF(NOW(),`last_pmodified`)) AS last_mod FROM project WHERE title='".$_GET['title']."'";
				$result = mysqli_query($con,$query);
				if(!$result){
					echo "<span style='color:red;font-size: 1em;'>QUERY FAILED</span>";
					mysqli_close($con);
					return;
				}
				$pid = mysqli_fetch_array($result);
				$query = "SELECT username FROM user WHERE user_id = (SELECT user_id FROM project WHERE project_id=".$pid['pid'].")";
				$result = mysqli_query($con,$query);
				if(!$result){
					echo "<span style='color:red;font-size: 1em;'>QUERY FAILED</span>";
					mysqli_close($con);
					return;
				}
				$username = mysqli_fetch_array($result);
				echo "<div id='p_details'>";
				if($pid['type']=='public'){
					echo "<span class='type' style='color:green;font-weight: bolder'>Public";
				}
				else if($pid['type']=='private'){
					echo "<span class='type' style='color:red;font-weight: bolder'>Private";
				}
				echo "</span><span id='title'>",$_GET['title'],"</span><span class='created'>",date_format(new DateTime($pid['created']), 'F j, Y'),"</span></br>
						<table id='project'>
						<tr><td class='desc'>",$pid['des'],"</td><td class='author'>",$username['username'],"</td></tr>
						<tr>";
				if($pid['due']<0){
					echo "<td class='due' style='color:red;font-weight:bolder'>Deadline passed ",-$pid['due']," day(s) ago</span>";
				}
				else if($pid['due']==0){
					echo "<td class='due' style='color:	#a58c38;font-weight:bolder'>Today is the deadline</span>";
				}
				else{
					echo "<td class='due' style='color:green;font-weight:bolder'>",$pid['due']," days to deadline</span>";
				}
				echo "</td><td class='last_modif'>Last Edit: ";
					if($pid['last_mod']<60){ //seconds
						echo $pid['last_mod']," second(s) ago";
					}
					else if($pid['last_mod']<3600){ //minutes
						echo intval($pid['last_mod']/60)," minute(s) ago";
					}
					else if($pid['last_mod']<21600){ //hours
						echo intval($pid['last_mod']/3600)," hour(s) ago";
					}
					else{ //days
						echo intval($pid['last_mod']/86400)," day(s) ago";	
					}
				echo "</td></tr>
					</table>
					</div>";
				$query = "SELECT COUNT(file_id) AS num_files FROM file WHERE project_id=".$pid['pid'];
				$result = mysqli_query($con,$query);
				if(!$result){
					echo "<span style='color:red;font-size: 1em;'>QUERY FAILED</span>";
					mysqli_close($con);
					return;
				}
				$num_files = mysqli_fetch_array($result);
				echo "<div id='p_directory'><span id='dir'>",$_GET['title'],"/</span><span id='all_file'>",$num_files['num_files']," Files</span></div>
					<div id='p_content'><input type='button' id='new_file' class='generalButton' value='Add New File'></div>";
				if($num_files['num_files']==0){
					echo "<div style='margin-bottom:1em'><span class='null_data'>Empty Directory!</span></div>";
				}
				else{
					$query = "SELECT * FROM file WHERE project_id=".$pid['pid'];
					$result = mysqli_query($con,$query);
					if(!$result){
						echo "<span style='color:red;font-size: 1em;'>QUERY FAILED</span>";
						mysqli_close($con);
						return;
					}
					while($file_det = mysqli_fetch_array($result)){
						
					}
				}
			}
			else{
				echo "<span style='color:red;font-size: 3em;'>Invalid Request or(and) Request Failed</span>";
			}
		?>
	<?php include 'utils/footer.html'; ?>
	</div>
</body>
<?php if(isset($con)){mysqli_close($con);} //Close connection to database ?>
</html>
