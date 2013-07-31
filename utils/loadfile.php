<?php
$target_path = "../projects/".$_POST['path'];
if(!file_exists($target_path)){
  echo "ERROR";
  return;
}
$file = fopen($target_path,"r+");
$lines=0;
$file_content="";
while(!feof($file)){
  $line = fgets($file);
  //$file_content = $file_content.$line."</br>";
  $file_content = $file_content.$line;
  $lines++;
}
fclose($file);
echo "<div class='code'><div id='line'>";
    for($i=1;$i<=$lines;$i++){
        echo "<span class='number' id='line_",$i,"'>",$i,"</span>";
    }
echo "</div><textarea id='code' style='resize: none;' rows='",$lines,"'></textarea></div>
	  <div id='util_buttons' style='margin: auto;width:80%;'>
	  <input type='button' class='linkButton' id='compile' value='Compile' style='font-size: 1.5em;margin: 0.5em;'><input type='button' class='linkButton' id='run' value='Run' style='font-size: 1.5em;margin: 0.5em;'>
	  <input type='button' class='generalButton' id='save' value='Save' style='float:right;font-size: 1.5em;margin: 0.5em;'>
    <input type='button' class='linkButton' id='edit' value='Edit More' style='float:right;font-size: 1.5em;margin: 0.5em;'></div>
	  <div id='compiler_title'>Compiler Output: </div><div id='compiler_output'><div id='run_res'></div></div>";
echo "&","$file_content";
?>
