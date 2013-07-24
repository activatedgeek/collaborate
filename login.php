<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
session_start();
if($_SESSION['user']){
  header('Location: http://localhost/collaborate/canvas.php?id='.$_SESSION['user']);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"></meta>
  <title>Collaborate</title>
  <script src="js/jquery.js"></script>
  <link rel="shortcut icon" href="http://localhost/collaborate/icons/collaborate.ico">
<?php
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheets/".basename(__FILE__,'.php').".css\">";
    echo "<script type=\"text/javascript\" src=\"js/".basename(__FILE__,'.php').".js\"></script>";
?>
  <link rel="stylesheet" type="text/css" href="stylesheets/navs.css">
  
</head>

<body>
  <div><input id="join" type="button" class="navs linkButton" value="Join"/></div>
  <div id="loginCreds">
    <form>
      <input class="genCreds" id="id" type="text" placeholder="Enter a valid username"/></br>
      <input class="genCreds" id="pass" type="password" placeholder="Enter a valid password"/></br>
      <input type="button" class="generalButton enter" id="send" value="  Program!  " onclick="sendCreds()"/>
    </form>
  <div id="errorMsg"></div>
  </div>
</body>

</html>
