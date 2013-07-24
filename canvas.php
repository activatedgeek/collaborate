<?php
session_start();
$_SESSION['user']=$_GET['id'];
$con = mysqli_connect("localhost","root","123","collaborate");
	if(!$con){
	    echo "Could not connect to DB server";
	    mysqli_close($con);
	    //return;
	}
	$query = "SELECT username,date(joined) AS joining,first_name,last_name,email,avatar FROM user WHERE user_id='".$_SESSION['user']."'";
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
  	<title><?php echo $row['username'],"'s " ?>Canvas</title> <!-- Change title to the the username's canvas -->

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
				echo "<tr><td>",$row['username'],"</td></tr>";
				echo "<tr><td>",$row['first_name']," ",$row['last_name'],"</td></tr>";
				if($row['email']!=NULL)
					echo "<tr><td><a href='mailto:",$row['email'],"'>",$row['email'],"</a></td></tr>";
				$join = date_create_from_format('Y-m-d',$row['joining']);
				echo "<tr><td>Joined on ",date_format($join, 'F j, Y'),"</td></tr>";
				echo "</table>";
				mysqli_close($con);
  			?>
  		</div>
  		<div id="userdata">
  			<div id="databar">
	  			<table id="datalinks">
	  				<tr><td id="activity" class="datalinks">Activity</td>
	  					<td id="projects" class="datalinks">Projects(
	  					<?php
		  					$con = mysqli_connect("localhost","root","123","collaborate");
							if(!$con){
							    echo "Could not connect to DB server";
							    mysqli_close($con);
							    //return;
							}
	  						$query = "SELECT COUNT(user_id) AS nums FROM project WHERE user_id='".$_SESSION['user']."'";
	  						$result = mysqli_query($con,$query);
	  						if(!$result){
								echo "Query Failed";
							    mysqli_close($con);
							    //return;
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
  				<input class='linkButton' id='newProj' type='button' value='Start New Project'/>
  				<script type="text/javascript">
	  				window.onload = function(){
	  					act=false;
						proj=true;
						com=false;
						iss=false;
						$("#projects").css({"border-bottom":"solid green 3px","border-top":"solid green 3px","color":"green"});	
	  				};
  				</script>
  				<?php 	if($count['nums']==0){
  							echo "<span class='no_data'>You have no projects added yet!</span>","<input class='linkButton' id='newProject_null' type='button' value='Start New Project'/>";
  						}
  					else{
  						$query = "SELECT title,description AS des,DATE(created) AS created,DATEDIFF(due_date,NOW()) AS due FROM project WHERE user_id =".$_SESSION['user']." ORDER BY due";
  						$result = mysqli_query($con,$query);
  						if(!$result){
  							echo "<span class='no_data'>Connection Failed! Please reload page</span>";
							mysqli_close($con);
							//return;
  						}
  						while($row=mysqli_fetch_array($result)){
  							$create = date_create_from_format('Y-m-d',$row['created']);
  							echo "<table class='p_block'><tr><td class='title'>",$row['title'],"</td></tr>";
  							echo "<tr><td class='desc'>",$row['des'],"</td><td>";
  							if($row['due']<0){
  								echo "<span  class='due_data' style='color:red'>Deadline passed ",-$row['due']," day(s) ago</span>";
  							}
  							else if($row['due']==0){
  								echo "<span  class='due_data' style='color:	#a58c38'>Today is the deadline</span>";
  							}
  							else{
  								echo "<span  class='due_data' style='color:green'>",$row['due']," days to deadline</span>";
  							}
  							echo "</td><td class='created'>Created on ",date_format($create, 'F j, Y'),"</td></tr></table>";
  						}
  					}
  				?>
  			</div>
  		</div>

  	<?php include 'utils/footer.html'; ?>
  	</div>
</body>
<?php if(isset($con)){mysqli_close($con);} //Close connection to database ?>
</html>
