var avatar = false;
$(document).ready(function(){
    var login = document.getElementById("login");
    login.onclick = function(){
        window.open("http://localhost/collaborate/login.php","_parent",true);
    };

    $("#reset").click(function(){
        $("#avatar_blob").wrap('<form>').parent('form').trigger('reset');
        $("#avatar_blob").unwrap();
        $(this).css("color","gray");
        avatar=false;
    });
    
    $("#avatar_blob").change(function(){
    });
});

var firstName,lastName ,username,email,password,pass_repeat;

function getDetails(){
    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;
    username = document.getElementById("username").value;
    email = document.getElementById("email").value;
    password = document.getElementById("password").value;
    pass_repeat = document.getElementById("pass_repeat").value;
}

function uniqueUsername(){
    username = document.getElementById("username").value;
    if(username!="" && username.length>=4){
        //jQuery AJAX POST
        $.post("accounts/unique.php",{username: username},
            function(data, status){
                if(status=='success' && data=='OK'){
                   document.getElementById("username").style.borderColor = "Green";
                   return true;
                }
                else if(status=='success' && data=='DENY'){
                    document.getElementById("username").style.borderColor = "Red";
                    return false;
                }
                else{
                    alert(status);
                    return false;
                }
            });
    }
    else if(username.length<4 && username!=""){
        document.getElementById("username").style.borderColor = "Red";
        return false;
    }
    else{
        document.getElementById("username").style.borderColor = "";
        return false;
    }
}

function checkValidity(){
    getDetails();
    if(firstName!="" && lastName!="" && username!="" && email!="" && password!="" && uniqueUsername && password==pass_repeat && password.length>8 && avatar){
        return true;
    }
    else{
        alert('Please Correct Errors');
        if(firstName=="" || firstName==NULL){
            document.getElementById("firstName").style.borderColor = "Red";
        }
        if(lastName=="" || lastName==NULL){
            document.getElementById("lastName").style.borderColor = "Red";
        }
        if(username=="" || username==NULL || username.length<4){
            document.getElementById("username").style.borderColor = "Red";
            document.getElementById("username").value = "";
        }
        if(email.indexOf("@")<1 || email.lastIndexOf(".")-email.indexOf("@")==1 || email.lastIndexOf(".")+2>=email.length){
            document.getElementById("email").style.borderColor = "Red";
            document.getElementById("email").value = "";
        }
        if(password=="" || password==NULL || password.length<8){
            document.getElementById("password").style.borderColor = "Red";
            document.getElementById("password").value = "";
        }
        if(password!=pass_repeat){
            document.getElementById("pass_repeat").style.borderColor = "Red";
            document.getElementById("password").style.borderColor = "Red";
            document.getElementById("pass_repeat").value = "";
            document.getElementById("password").value = "";
        }
        return false;
    }
}

function checkDetails(){
    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;
    password = document.getElementById("password").value;
    pass_repeat = document.getElementById("pass_repeat").value;
    email = document.getElementById("email").value;
    if((email.indexOf("@")<1 || email.indexOf(".")<1 || email.lastIndexOf(".")-email.indexOf("@")==1 || email.lastIndexOf(".")+2>=email.length) && email!=""){
            document.getElementById("email").style.borderColor = "Red";
    }
    else if(email==""){
        document.getElementById("email").style.borderColor = "";
    }
    else{
        document.getElementById("email").style.borderColor = "Green";
    }
    if(password!="" && pass_repeat!="")
        if(password == pass_repeat){
            document.getElementById("password").style.borderColor = "Green";
            document.getElementById("pass_repeat").style.borderColor = "Green";
        }
        else{
            document.getElementById("password").style.borderColor = "Red";
            document.getElementById("pass_repeat").style.borderColor = "Red";
        }
    else if(password.length < 8 && password!=""){
        document.getElementById("password").style.borderColor = "Red";
        document.getElementById("pass_repeat").style.borderColor = "";
    }
    else{
        document.getElementById("password").style.borderColor = "";
        document.getElementById("pass_repeat").style.borderColor = "";
    }
    if(firstName!="" && lastName!=""){
        var edit=new XMLHttpRequest();
        edit.onreadystatechange=function(){
        if (edit.readyState==4 && edit.status==200){
            document.getElementById("fieldCaption").innerHTML = "Welcome "+ firstName + " " + lastName;
        }
        }
        edit.open("GET","info.txt",true);
        edit.send();
    }
    else{
        document.getElementById("fieldCaption").innerHTML = "Welcome New Programmer";
    }
}


function signup(){
    /*
        if(checkValidity()){
            $.post("accounts/setup.php",
                {firstName: firstName, lastName: lastName, username: username,email: email,password: password},
                function(data, status){
                    if(status=='success' && data=='OK')
                        window.open("test.php","_parent",true);
                    else
                        alert(data);
                });
        }
    */
}
