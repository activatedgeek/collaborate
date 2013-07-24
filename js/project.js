var title;
var desc;
var due;
var type;
$(document).ready(function(){
  $("#create").click(function(){
		if(valid()){
			window.open("http://localhost/collaborate/utils/new.php?type=project","_parent");
		}
	});
});

function valid(){
	title = $("#title").val();
	desc = $("textarea").val();
	due = $("#due").val();
	type = $("input[name=type]:checked").val();
	if(title==''){
		$("#title").css("border","solid red 2px");
		return false;
	}
	var c = checkdate();
	if(c==1){
		$("#due").css("border","solid red 2px");
		$("#default_due").hide().css("color","red").fadeIn(1000).text("This is not a valid date format!");
		return false;
	}else if(c==2){
		$("#due").css("border","solid red 2px");
		$("#default_due").hide().css("color","red").fadeIn(1000).text("These are non-parseable date parameters");
		return false;
	}else if(c==3){
		$("#due").css("border","solid red 2px");
		$("#default_due").hide().css("color","red").fadeIn(1000).text("This date has already passed!");
		return false;
	}else if(c==4){
		$("#due").css("border","solid red 2px");
		$("#default_due").hide().css("color","red").fadeIn(1000).text("You cannot increase the days in this month!");
		return false;
	}else if(c==5){
		$("#due").css("border","none");
		$("#default_due").hide().css("color","green").fadeIn(1000).text("Way to go!");
		return true;
	}
	return true;
}

/*Error codes for checkdate()
1: Invalid/Null separators
2: Invalid/Non-parseable year/month/day
3: Passed away date
4: Invalid date parameter for the given month
5: Validated
*/
function checkdate(){
	var date = due.split("-");
	var curdate = new Date();
	if(date.length!==3){
		return 1;
	}
	var year = parseInt(date[0],10);
	var month = parseInt(date[1],10);
	var day = parseInt(date[2],10);
	if(isNaN(year) || isNaN(month) || isNaN(day) || month<1 || month>12 || day<1 || day>31){
		return 2;
	}
	else if(date[0]<curdate.getFullYear() || (date[0]==curdate.getFullYear() && date[1]<curdate.getMonth()+1)){
		return 3;
	}
	else if(new Date(year,month-1,day).getMonth() != month-1){
		return 4;
	}
	return 5;
}
