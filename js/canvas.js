$(document).ready(function(){
  /*****Datalink Click UI changes********/

	//Checking scroll, fixing the databar after certain threshold
	$(window).bind("scroll",function(){
		if($(this).scrollTop()>260)
		 	$("#databar").css({"position":"absolute","margin-top":"4em"});
		else{
			$("#databar").css({"position":"static","margin-top": "1em"});
		}
	});
	
	var act=false;
	var proj=false;
	var com=false;
	var iss=false;
	//Hover changes
	$("#activity").hover(function(){
		if(!act)
			$(this).css("border-bottom","solid #7fb0ff 3px");
	},function(){
		if(!act)
			$(this).css("border-bottom","solid gray 3px");
	});
	$("#projects").hover(function(){
		if(!proj)
			$(this).css("border-bottom","solid #9fff99 3px");
	},function(){
		if(!proj)
			$(this).css("border-bottom","solid gray 3px");
	});
	$("#commits").hover(function(){
		if(!com)
			$(this).css("border-bottom","solid #cc6c00 3px");
	},function(){
		if(!com)
			$(this).css("border-bottom","solid gray 3px");
	});
	$("#issues").hover(function(){
		if(!iss)
			$(this).css("border-bottom","solid #ff7f7f 3px");
	},function(){
		if(!iss)
			$(this).css("border-bottom","solid gray 3px");
	});
	
	//Click changes
	$("#activity").click(function(){
		act=true;
		proj=false;
		com=false;
		iss=false;
		$(this).css({"border-bottom":"solid blue 3px","border-top":"solid blue 3px","color":"blue"});
		$(this).nextAll().css({"border-bottom":"solid gray 3px","border-top":"solid gray 3px","color":"gray"});
	});
	$("#projects").click(function(){
		act=false;
		proj=true;
		com=false;
		iss=false;
		$(this).css({"border-bottom":"solid green 3px","border-top":"solid green 3px","color":"green"});
		$(this).prevAll().css({"border-bottom":"solid gray 3px","border-top":"solid gray 3px","color":"gray"});
		$(this).nextAll().css({"border-bottom":"solid gray 3px","border-top":"solid gray 3px","color":"gray"});
	});
	$("#commits").click(function(){
		act=false;
		proj=false;
		com=true;
		iss=false;
		$(this).css({"border-bottom":"solid cc6c00 3px","border-top":"solid #cc6c00 3px","color":"#cc6c00"});
		$(this).prevAll().css({"border-bottom":"solid gray 3px","border-top":"solid gray 3px","color":"gray"});
		$(this).nextAll().css({"border-bottom":"solid gray 3px","border-top":"solid gray 3px","color":"gray"});
	});
	$("#issues").click(function(){
		act=false;
		proj=false;
		com=false;
		iss=true;
		$(this).css({"border-bottom":"solid red 3px","border-top":"solid red 3px","color":"red"});
		$(this).prevAll().css({"border-bottom":"solid gray 3px","border-top":"solid gray 3px","color":"gray"});
	});
	/*****Datalink Click UI changes********/
});
