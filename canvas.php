<?php
  	session_start();
		$_SESSION['user']="activatedgeek";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<title><?php echo $_SESSION['user'],"'s " ?>Canvas</title> <!--Change title to the the username's canvas -->

  	<link rel="shortcut icon" href="http://localhost/collaborate/icons/collaborate.ico">
	<script src="js/jquery.js"></script>
  	<link rel="stylesheet" type="text/css" href="stylesheets/navs.css">
    <?php
    	echo "<link rel='stylesheet' type='text/css' href='stylesheets/",basename(__FILE__,'.php'),".css'>";
    	echo "<script type='text/javascript' src='js/",basename(__FILE__,'.php'),".js'></script>";
	?>
</head>

<body>
	<?php 
			$con = mysqli_connect("localhost","root","123","collaborate");
			if(!$con){
			    echo "Could not connect to DB server";
			    mysqli_close($con);
			    return;
			}
			$user = $_SESSION['user'];
			$query = "SELECT user_id AS id,date(joined) AS joining,first_name,last_name,email,avatar FROM user WHERE username='".$user."'";
			$result = mysqli_query($con, $query);
			if(!$result){
				echo "Query Failed";
			    mysqli_close($con);
			    return;
			}
			$row = mysqli_fetch_array($result);
  	?>
  	<?php include 'utils/navbar.html';?>
  	<div class="usercontent">
  		<div id="profile">
  			<?php
  				if($row['avatar']==NULL){
    				echo "<img id='profile_blob' src='media/default.jpg' width='222' height='222'>";
				}
				else{
					echo "<img id='profile_blob'src='data:image/jpeg;base64,",base64_encode($row['avatar']),"' width='222' height='222'>";
				}
				echo "<table id='userinfo'>";
				echo "<tr><td>",$_SESSION['user'],"</td></tr>";
				echo "<tr><td>",$row['first_name']," ",$row['last_name'],"</td></tr>";
				if($row['email']!=NULL)
					echo "<tr><td><a href='mailto:",$row['email'],"'>",$row['email'],"</a></td></tr>";
				$join = date_create_from_format('Y-m-d',$row['joining']);
				echo "<tr><td>Joined on ",date_format($join, 'F j, Y'),"</td></tr>";
				echo "</table>";
  			?>
  		</div>
  		<div id="userdata">
  			<div id="databar">
	  			<table id="datalinks">
	  				<tr><td id="activity" class="datalinks">Activity</td>
	  					<td id="projects" class="datalinks">Projects(
	  					<?php
	  						$query = "SELECT COUNT(user_id) AS nums FROM project WHERE user_id='".$row['id']."'";
	  						$result = mysqli_query($con,$query);
	  						if(!$result){
								echo "Query Failed";
							    mysqli_close($con);
							    return;
							}
							$count = mysqli_fetch_array($result);
							echo $count['nums'];
	  					?>
	  					)
	  					</td>
	  					<td id="commits" class="datalinks">Commits</td>
	  					<td id="issues" class="datalinks">Issues</td></tr>
	  			</table>
  			</div>
  			<div id="datalinks_related">
  				
  			</div>
  		</div>
  	</div>
</body>
<?php if(isset($con)){mysqli_close($con);} //close db connection ?>
</html>
