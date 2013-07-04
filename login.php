<?php
header("Expires: Mon, 25 Jul 1994 04:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Collaborate</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <link rel="shortcut icon" href="http://localhost/collaborate/icons/collaborate.ico">
<?php
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheets/".basename(__FILE__,'.php').".css\">";
    echo "<script type=\"text/javascript\" src=\"js/".basename(__FILE__,'.php').".js\"></script>";
?>
  <link rel="stylesheet" type="text/css" href="stylesheets/navs.css">
  
</head>

<body>
  <div><a class="navs" href="signup.php" target="_parent">Join</a></div>
  <div id="loginCreds">
    <form>
      <input id="id" type="text" placeholder="$_GET ID"/></br>
      <input id="pass" type="password" placeholder="$_GET PASSWORD"/></br>
      <input type="button" id="send" class="enter" value="  Program!  " onclick="sendCreds()"/>
    </form>
  <div id="errorMsg"></div>
  </div>
</body>

</html>
