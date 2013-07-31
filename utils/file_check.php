<?php
if(isset($_POST['path'])){
  $target_dir = $_POST['path'];
	if(file_exists($target_dir)){
		echo "true";
	}
	else
		echo "false";
	return;
}
return;
?>
