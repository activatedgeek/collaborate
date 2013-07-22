$(document).ready(function(){
	$("#join").click(function(){
		window.open("http://localhost/collaborate/signup.php","_parent",true);
	});
});

function sendCreds(){
var user = $("#id").val();
var pass = $("#pass").val();
if(user=='' || pass==''){
  $("#id").css({"border-color":"red","borderWidth":"3px"});
  $("#pass").css({"border-color":"red","borderWidth":"3px"});
  document.getElementById("errorMsg").innerHTML = "Error! Please Check your Username or(and) Password";
  $("#errorMsg").fadeIn().fadeOut(2000);
  document.getElementById("id").innerHTML = "";
  document.getElementById("pass").innerHTML = "";
}
else{
  document.getElementById("id").style.borderColor = "";
  document.getElementById("pass").style.borderColor = "";
  document.getElementById("errorMsg").innerHTML = "";
  //jQuery AJAX POST
  $.post("accounts/validate.php",{user: user, pass: pass},
	 function(data,status){
	  if(status=='success' && data=='OK')
	    window.open("http://localhost/collaborate/canvas.php","_parent",true);
	  else if(status=='success' && data=='DENY'){
	    $("#id").css({"border-color":"red","borderWidth":"3px"});
		$("#pass").css({"border-color":"red","borderWidth":"3px"});
		document.getElementById("errorMsg").innerHTML = "Error! Please Check your Username or(and) Password";
		$("#errorMsg").fadeIn().fadeOut(2000);
		$("#pass").val("");
	  }
	  else
	    alert(status);
	  });
}

}
