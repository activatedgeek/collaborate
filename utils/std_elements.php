<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
    <script src="//use.edgefonts.net/poiret-one.js"></script>
    <script src="//use.edgefonts.net/miama:n4.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="js/login.js"></script>
    <script>
    /**A php snippet to check if user logged in or not,to be added later**/
    var s=true;
    $(document).ready(function(){
        if(s){
            $("#logcred").hide();
        }
        $("#login_nav").click(function(){
            document.getElementById("errorMsg").innerHTML='';
            $("#id").val('');
            $("#logcred").css("visibility","visible");
            $("#logcred").css("position","fixed").fadeToggle(500);
        });

        /**************Handling text editor**********************/
        var line=1;
		var res_back=0;
		var ctrlkey=false;
        $("#code").keypress(function(event){
        	if(event.keyCode==13){ //enter key
        		line++;
        		$("#line").append("<span class='number' id='line_"+line+"'>"+line+"</span>");
        		$("#line_"+line).hide().fadeIn(250);
        	}
        	
        	//While the backspace or delete key is pressed, keep updating lines
        	else if(event.keyCode==8 || event.keyCode==46){ //backspace or delete key
        			$.post("utils/line_check.php",{code: $(this).html()},function(data,status){
    					if(status=='success'){
    						res_back = data.split(" ");
    					}
        				if(line!=1 && res_back[0]==(line-1)){
        					$("#line_"+line).fadeOut(250,function(){$(this).remove();});
    						line--;
    					}
        			});
    		}
    		
        });
        $("#code").keyup(function(event){
        	//To handle mass delete of code
        	if((event.keyCode==8)  || (event.keyCode>=46 && event.keyCode<=90) || (event.keyCode>=96 && event.keyCode<=111) || (event.keyCode>=186 && event.keyCode<=192) || (event.keyCode>=219 && event.keyCode<=222) ){
        		if($(this).html()=='<br>'){
        			$("#line_1").siblings().fadeOut(250,function(){$("#line_1").siblings().remove();});
        			line=1;
        			return;
        		}
        		$.post("utils/line_check.php",{code: $(this).html()},function(data,status){
    					if(status=='success'){
    						res_back = data.split(" ");
    					}
    					var diff=line-res_back[0];
    					if(diff>0){
    						var id = $("#line_1").siblings(":last").attr("id");
    						id = id.split("_");
    						id[1] -=diff;
    						id = '#'+id.join("_");
    						$(id).nextAll().fadeOut(250,function(){$(id).nextAll().remove();});
    						line = line-diff;
    					}
        			});
        	}
        	//To handle code pastes
        	if(event.keyCode==86 && ctrlkey){
        		$.post("utils/line_check.php",{code: $(this).html()},function(data,status){
    					if(status=='success'){
    						res_back = data.split(" ");
    					}
    					var diff = res_back[0] - line;
    					if(diff>0){
    						//diff++;
    						for(var i=0;i<diff;i++){
    							line++;
				        		$("#line").append("<span class='number' id='line_"+line+"'>"+line+"</span>");
        						$("#line_"+line).hide().fadeIn(250);
    						}

    					}
    					ctrlkey=false;
        			});
        	}
        	if(event.ctrlKey){
        		ctrlkey=false;
        	}

        });
        $("#code").keydown(function(event){
        	if(event.ctrlKey)
        		ctrlkey=true;
        });
        /**************Handling text editor**********************/
    });
    </script>
    <style>
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
            margin: 3em auto auto 0.5%;
            width: 97.7%;
            height: 500%;
            display: block;
            padding: 0.5em;
            border: solid black 1px;
        }
        .content .contentHeader{
        	position: relative;
        	padding: 0.5em;
		}

        @font-face {
            font-family: 'notcouriersansbold';
            src: url('stylesheets/code_text/NotCourierSans-Bold-webfont.eot');
            src: url('stylesheets/code_text/NotCourierSans-Bold-webfont.eot?#iefix') format('embedded-opentype'),
                 url('stylesheets/code_text/NotCourierSans-Bold-webfont.woff') format('woff'),
                 url('stylesheets/code_text/NotCourierSans-Bold-webfont.ttf') format('truetype'),
                 url('stylesheets/code_text/NotCourierSans-Bold-webfont.svg#notcouriersansbold') format('svg');
            font-weight: 100;
            font-style: normal;
        }
        .content .code{
        	position: relative;
        	padding: 0.5em;
        	margin-bottom: 1em;
            height: 100%;
        	font-family: 'notcouriersansbold';
        }
        
        .content .code #line{
        	float: left;
        	padding: 0 1em 0 0.4em;
        	margin-left: 12.5%;
            overflow: hidden;
        	width: 1.5em;
            height: 73.5em;
            max-height: 73.5em;
        	-moz-box-shadow:    0 0 5px 2px #87aada;
            -webkit-box-shadow: 0 0 5px 2px #87aada;
            box-shadow:         0 0 5px 2px #87aada;
            background: linear-gradient(90deg,rgba(10,10,10,1) 0,rgba(142,143,143,1) 80%,rgba(150,150,150,1) 100%);
            cursor: default;
        }
        #line .number{
        	display: block;
        }
        .content .code .number{
        	font-family: 'notcouriersansbold';
            font-size: 1em;
            font-weight: 100;
        	text-align: left;
        	color: rgb(200,200,200);
        	font-style: italic;
        }
        .content .code #code{
            overflow: auto;
            width: 70%;
            padding-left: 1em;
            height: 73.5em;
            max-height: 73.5em;
            font-family: 'notcouriersansbold';
            font-size: 1em;
            font-weight: 100;
            letter-spacing: 1px;
            text-align: left;
            background: #f0f3f6;
            -moz-box-shadow:    0 0 5px 2px #87aada;
            -webkit-box-shadow: 0 0 5px 2px #87aada;
            box-shadow:         0 0 5px 2px #87aada;
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
    	<div class="contentHeader">
        	<input type="text" id="test">
        	<input type="button" id="button" value="button is here">
        </div>
    	<div class="code">
    		<div id="line">
    	<?php
    		for($i=1;$i<=1;$i++) echo "<span class='number' id='line_$i'>$i</span>";
    	?>	
    		</div>
    		<div id="code" contenteditable><br></div>
    	</div>
    </div>

</body>
</html>
