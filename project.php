<?php
session_start();
$type = $_GET['type'];

$con = mysqli_connect("localhost","root","123","collaborate");
if(!$con){
    echo "Could not connect to DB server";
    mysqli_close($con);
    //return;
}
$query = "SELECT user_id AS id,avatar FROM user WHERE username='".$_SESSION['user']."'";
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
  	<title><?php echo $_SESSION['user'],"'s New ",$type ?></title> <!--Change title to the the username's canvas -->

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
		<div id="subcall"><span id="field_title">new project details</span></div>
		<table class="details">
			<tr><td class="subdetails">Title</td><td><input class="genCreds" id="title" type="text" placeholder="Title goes here"></td></tr>
			<tr><td class="subdetails">Description</td><td><textarea maxlength="500" placeholder="max. 500 characters"></textarea></td></tr>
			<tr><td class="subdetails">Due Date</td><td><input class="genCreds" id="due" type="text" placeholder="YYYY-MM-DD"></td></tr>
			<tr><td class="subdetails"></td><td><span id="default_due">Default is 15 days</span></td></tr>
			<tr><td class="subdetails">Type</td><td><input type="radio" name="type" value="public" checked><span class="radio">&nbsp&nbspPublic&nbsp&nbsp</span><input type="radio" name="type" value="private"><span class="radio">&nbsp&nbspPrivate&nbsp&nbsp</span></td></tr>
		</table>
		<input id="create" class="generalButton" type="button" value="Create New Project"/>
	<?php include 'utils/footer.html'; ?>
	</div>
</body>
<?php if(isset($con)){mysqli_close($con);} //Close connection to database ?>
</html>
