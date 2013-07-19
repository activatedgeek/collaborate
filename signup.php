<?php
header("Expires: Mon, 25 Jul 1994 04:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
?>

<!doctype html>
</html>
<head>
    <meta charset="UTF-8">
    <title>Start Collaborating</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="shortcut icon" href="http://localhost/collaborate/icons/collaborate.ico">
<?php
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheets/".basename(__FILE__,'.php').".css\">";
    echo "<script type=\"text/javascript\" src=\"js/".basename(__FILE__,'.php').".js\"></script>";
?>
  <link rel="stylesheet" type="text/css" href="stylesheets/navs.css">
</head>

<body>
<div><a class="navs" href="login.php" target="_blank">Login</a></div>
<div id="info">
<form>
    <fieldset id="reg">
        <legend id="fieldCaption">Welcome New Programmer</legend>
    <table class="form">
    <tr>
        <td class="details">First Name</td>
        <td class="details">==</td>
        <td class="details"><input type="text" placeholder="First Name" id="firstName" onkeyup="checkDetails()"/></td>
    </tr>
    <tr>
        <td class="details">Last Name</td>
        <td class="details">==</td>
        <td class="details"><input type="text" placeholder="Last Name" id="lastName" onkeyup="checkDetails()"/></td>
    </tr>
    <tr>
        <td class="details">Username</td>
        <td class="details">==</td>
        <td class="details"><input type="text" placeholder="Your screen name (min. 4 characters)" id="username" onkeyup="uniqueUsername()"//></td>
    </tr>
    <tr>
        <td class="details">Email ID</td>
        <td class="details">==</td>
        <td class="details"><input type="email" placeholder="A confirmation will be sent" id="email" onkeyup="checkDetails()"/></td>
    </tr>
    <tr>
        <td class="details">Password</td>
        <td class="details">==</td>
        <td class="details"><input type="password" placeholder="Minimum 8 characters" id="password"/></td>
    </tr>
    <tr>
        <td class="details">Re-enter Password</td>
        <td class="details">==</td>
        <td class="details"><input type="password" placeholder="Re-enter Password" onkeyup="checkDetails()" id="pass_repeat"/></td>
    </tr>
    </table>
    <input class="signup" type="button" value="    Join!    " onclick="signup()"/>
    </fieldset>
</form>
</div>
</body>

</html>
