<!DOCTYPE html>

<html>
<head>
    <script src="//use.edgefonts.net/poiret-one.js"></script>
    <script src="//use.edgefonts.net/miama:n4.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="js/login.js"></script>
    <script>
    /**A php snippet to check if user logged in or not,to be added later**/
    var s=true;
    $(document).ready(function(){
        if(s){
            $("#logcred").css("visibility","hidden");
        }
        $("#login_nav").click(function(){
            document.getElementById("errorMsg").innerHTML='';
            $("#id").val('');
            $("#logcred").css("visibility","visible");
            $("#logcred").css("position","fixed").fadeToggle(500);  
        });
        $("#button").click(function(){
            $(this).removeAttr("contenteditable");
            alert($("#code").val());
        });
    });
    </script>
    <style>
        @font-face {
            font-family: 'notcouriersansbold';
            src: url('stylesheets/code_text/NotCourierSans-Bold-webfont.eot');
            src: url('stylesheets/code_text/NotCourierSans-Bold-webfont.eot?#iefix') format('embedded-opentype'),
                 url('stylesheets/code_text/NotCourierSans-Bold-webfont.woff') format('woff'),
                 url('stylesheets/code_text/NotCourierSans-Bold-webfont.ttf') format('truetype'),
                 url('stylesheets/code_text/NotCourierSans-Bold-webfont.svg#notcouriersansbold') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        body{
            margin: 0;
            background: #eaeaea;
        }
        #navbar{
            padding-top: 5px;
            position: fixed;
            margin: auto 0.5%;
            margin-top: -0.5em;
            z-index: 1000;
            width: 99%;
            height: 50px;
            border-radius: 20px;
            border-top-right-radius: 7px;
            border-top-left-radius: 7px;
            -moz-box-shadow:    0 0 10px 3px #5c5d63;
            -webkit-box-shadow: 0 0 10px 3px #5c5d63;
            box-shadow:         0 0 10px 3px #5c5d63;
            background: linear-gradient(rgba(10,10,10,0.85) 0,rgba(142,143,143,0.85) 60%,rgba(213,208,208,0.85) 100%, rgba(182,173,173,0.85) 90%);
            overflow: hidden;
          }
        #navbar .navlinks{
            text-align: center;
            font-family: poiret-one, sans-serif;
            font-weight: bold;
            display: inline;
            font-size: 29px;
            transition: background 0.5s, text-shadow 0.5s;
            -ms-transition: background 0.5s, text-shadow 0.5s;
            -webkit-transition: background 0.5s, text-shadow 0.5s;
        }
        #navbar .nav{
            display: inline-block;
            height: 0.5em;
            width: 4em;
            min-height: 6em;
            margin-top: -1.1em;
            padding-top: 1em;
            transition: background 0.5s;
            -ms-transition: background 0.5s;
            -webkit-transition: background 0.5s; 
        }
        #navbar .nav:hover{
            background: #9894a9;
        }
        #navbar .logo{
            font-family: miama, cursive;
            font-weight: bold;
            font-size: 1.5em;
            margin-left: 0.9em;
            margin-right: 1em;
        }
        #navbar .navlinks a:link,a:visited,a:active{ 
            color: #f1f0f0;
            text-shadow: 0 3px 3px #303030;
            text-decoration: none;
        }
        #navbar .logo a{
            transition: text-shadow 0.5s, color 0.5s;
            -ms-transition: text-shadow 0.5s, color 0.5s;
            -webkit-transition: text-shadow 0.5s, color 0.5s;
        }
        #navbar .logo a:hover{
            text-shadow: 0 1px 3px #333;
            color: #333131;
        }
        #navbar .dot{
            color: rgb(255,255,255);
            font-weight: bold;
            font-size: 25px;
            margin: 0 1em 0 1em;
        }
        #logcred{
            position: absolute;
            text-align: center;
            z-index: 100;
            width: 17em;
            height: 10em;
            margin-left: 53%;
            margin-top: 3.3em;
            padding: 0.5em;
            background: #eaeaea;
            font-family: poiret-one, sans-serif;
            -moz-box-shadow:    0 0 10px 3px #5c5d63;
            -webkit-box-shadow: 0 0 10px 3px #5c5d63;
            box-shadow:         0 0 10px 3px #5c5d63;
            border-bottom-right-radius: 1em;
            border-bottom-left-radius: 1em;
        }
        #logcred #id,#pass{
            display: block;
            text-align: center;
            width: 98.5%;
            height: 1.9em;
            padding: 1px;
            font-size: 1.25em;
            font-family: poiret-one, sans-serif;
            margin-bottom: 0.7em;
            border-radius: 1em;
            border: none;
            -moz-box-shadow:    inset 0 3px 3px #5c5d63;
            -webkit-box-shadow: inset 0 3px 3px #5c5d63;
            box-shadow:         inset 0 3px 3px #5c5d63;
        }
        #logcred #submit{
            width: 30%;
            height: 1.7em;
            margin: 0.2em 0 1em 0.5em;
            padding: -0.3em;
            border-style: none;
            border-radius: 0.2em;
            -moz-box-shadow:    0 0 3px 1px #87aada;
            -webkit-box-shadow: 0 0 3px 1px #87aada;
            box-shadow:         0 0 3px 1px #87aada;
            background-color: #0f49a7;
            font-family: poiret-one, sans-serif;
            font-weight: 900;
            font-size: 1.3em;
            color: white;
            background: linear-gradient(rgba(85,122,181,0.85) 0,rgba(15,86,182,0.85) 60%,rgba(13,65,150,0.85) 100%, rgba(85,122,181,0.85) 90%);
            cursor: pointer;
            transition: background 1s;
            -ms-transition: background 1s;
            -webkit-transition: background 1s;
        }
        #logcred #errorMsg{
            display: block;
        }
        .content{
            position: absolute;
            margin-top: 3.3em;
            width: 99%;
            height: 100%;
        }
        .content #code{
            margin: 1em auto;
            overflow: auto;
            width: 70%;
            height: 60em;
            max-height: 60em;
            padding: 1em; 
            font-family: 'notcouriersansbold';
            font-size: 1em;
            font-weight: 100;
            text-shadow: -1px 0 1px #a59f9f;
            background: #d5d8e1;
            -moz-box-shadow:    0 0 5px 2px #87aada;
            -webkit-box-shadow: 0 0 5px 2px #87aada;
            box-shadow:         0 0 5px 2px #87aada;
            letter-spacing: 1px;
            border: none;
        }
    </style>
</head>

<body>
<?php  /**Add a checker to which div element to echo based on login state**/?>
    <div id="logcred">
        <input type="text" id="id">
        <input type="password" id="pass">
        <input type="button" id="submit" value="Login" onclick="sendCreds()">
        <span><a href="#">Forgot Credentials?</a></span>
        <span id="errorMsg"></span>
    </div>
    <div id="navbar">
        <div id="1" class="logo navlinks"><a href="#">Collaborate</a></div><span class="dot">.</span>
        <div id="2" class="navlinks nav"><a href="#">Link</a></div>
        <div id="3" class="navlinks nav"><a href="#">Link</a></div>
        <div id="4" class="navlinks nav"><a href="#">Link</a></div><span class="dot">.</span>
        <div id="5" class="navlinks nav"><a href="#">Link</a></div>
        <div id="login_nav" class="navlinks nav"><a href="#">Login</a></div>
    </div> 
    <div class="content">
        <input type="text" id="test">
        <input type="button" id="button" value="button is here">
        <div id="code" contenteditable>
        </div>
    </div>

</body>
</html>
