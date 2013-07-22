<?php
$code = $_POST['code'];
$lines=0;
if(isset($code)){
  echo substr_count($code, "<br>");
}
else
	echo "1";
?>
