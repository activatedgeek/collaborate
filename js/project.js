var title;
var desc;
var due;
var type;
$(document).ready(function(){
	$("#create").click(function(){
		if(valid()){
			$.post("accounts/new_object.php",{object: "project",title: title,desc: desc,due: due,type: type},function(data,status){
				if(status=='success'){
					window.open("http://localhost/collaborate/canvas.php","_parent");
				}
			});
		}
	});
	$("#logout").click(function(){
		$.post("utils/destroy.php",{type: "session"},function(data,status){
			if(status=='success'){
				window.open("http://localhost/collaborate/login.php","_parent");
			}
		})
	});
	$(".title").click(function(){
		window.location.reload();
	});
	/**Functionality of adding a new file***/
	$("#new_file").click(function(){
		$(this).hide().parent().append("<input type='text' style='display:inline-block;margin-left: 7%;margin-top: 1.5%;' class='genCreds' placeholder='FORMAT = folder/file.ext'>\
			<input style='display:inline-block;font-size: 1.5em' class='linkButton' type='button' id='confirm_file' value='Confirm!'>\
			<input style='display:inline-block;font-size: 1.5em' class='generalButton' type='button' id='cancel_file' value='Cancel'>").hide().fadeIn(500);
	});
	
	$(document).on('click',"#cancel_file",function(){ //cancel adding file
		$("#new_file").siblings().remove();
		$("#new_file").fadeIn(500);
	});
	$(document).on('click','#confirm_file',function(){
		if($(this).prev().val()!=''){
			var pid = $(".title").attr("id").split("_");
			var path = "../projects/"+$(".title").text()+"/"+$(this).prev().val();
			$.post("utils/file_check.php",{path: path},function(data,status){
				if(status='success' && data=='false'){
					$.post("accounts/new_object.php",{object: "file",title: $(".title").text(),pid: pid[1],path: $("#confirm_file").prev().val()},function(data,status){
						if(status=='success'){
							//alert(data);
							window.location.reload();
						}
					});
				}
				else{
					$("#cancel_file").trigger('click');
				}
			});
		}
	});
	/**Functionality of adding a new file***/
	
	/**************Handling text editor**********************/
	var line;
	var res_back=0;
    var ctrlkey=false;
	$(".basename").click(function(){
		var appendPath="";
		if($(this).next().text()!='./'){
			var basename = ($(this).next().text()).split("/");
			basename[basename.length-1]="";
			appendPath = basename.join("/");
			$("#dir").after("<span class='dir' id='subdir'>"+appendPath+"</span>");
		}
		$.post("utils/loadfile.php",{path: $(".title").text()+"/"+appendPath+$(this).text()},function(data,status){
			if(status=='success'){
				$(".files").html(data).hide().fadeIn(500);
				$("#p_content").append("<input type='button' class='linkButton' value='Back' style='float:right;margin: 1em;font-size:1.5em;' id='back'>");
			}
			line = $("#line span").last().attr("id");
			line = (line.split("_"))[1];
		});
	});
	$(document).on('click','#back',function(){ //back button to main files
		window.location.reload();
	});
	$(document).on('keypress',"#code",function(event){
            if(event.keyCode==13){ //enter key
                line++;
                $("#line").append("<span class='number' id='line_"+line+"'>"+line+"</span>");
            }
            //While the backspace or delete key is pressed, keep updating lines
            else if(event.keyCode==8 || event.keyCode==46){ //backspace or delete key
                    $.post("utils/line_check.php",{code: $(this).html()},function(data,status){
                        if(status=='success'){
                            res_back = data.split(" ");
                        }
                        if(line!=1 && res_back[0]==(line-1)){
                            $("#line_"+line).remove();
                            line--;
                        }
                    });
            }
        });
		$(document).on('keyup',"#code",function(event){
            //To handle mass delete of code
            if((event.keyCode==8)  || (event.keyCode>=46 && event.keyCode<=90) || (event.keyCode>=96 && event.keyCode<=111) || (event.keyCode>=186 && event.keyCode<=192) || (event.keyCode>=219 && event.keyCode<=222) ){
                if($(this).html()=='<br>'){
                    $("#line_1").siblings().remove();
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
                            $(id).nextAll().remove();
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
                            //diff+=5; //just some extra lines //still need better handle perhaps js would do
                            for(var i=0;i<diff;i++){
                                line++;
                                $("#line").append("<span class='number' id='line_"+line+"'>"+line+"</span>");
                            }
                        }
                        ctrlkey=false;
                    });
            }
            if(event.ctrlKey){
                ctrlkey=false;
            }
        });
		
        $(document).on('keydown',"#code",function(event){
            if(event.ctrlKey)
                ctrlkey=true;
        });
    /**************Handling text editor**********************/

	$(".delete").click(function(){
		var fid = ($(this).attr("id")).split("_");
		$.post("utils/destroy.php",{type: "file",id: fid[1],title: $(".title").text()},function(data,status){
			if(status=='success'){
				//alert(data);
				window.location.reload();
			}
		});
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
	if(due!=''){
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
