<?php
$target_path = "../projects/".$_POST['path'];
if(file_exists($target_path))
  $file = fopen($target_path,"r+");
$lines=0;
$file_content="";
while(!feof($file)){
  $line = fgets($file);
  $file_content = $file_content.$line."</br>";
  $lines++;
}
echo "<div class='code'><div id='line'>";
    for($i=1;$i<=$lines;$i++){
        echo "<span class='number' id='line_",$i,"'>",$i,"</span>";
    }
echo "</div><div id='code' contenteditable>",$file_content,"</div></div>";

fclose($file);
?>
