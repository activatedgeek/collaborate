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
	var line=1;
    var old_filename = "";
    var fid = 0;
	$(".basename").click(function(){
		var appendPath="";
		if($(this).next().text()!='./'){
			var basename = ($(this).next().text()).split("/");
			basename[basename.length-1]="";
			appendPath = basename.join("/");
			$("#dir").after("<span class='dir' id='subdir'>"+appendPath+"</span>");
		}
		var value= $(this).text();
		old_filename = value;
		fid = $(this).attr("fid").split("_")[1];
		$.post("utils/loadfile.php",{path: $(".title").text()+"/"+appendPath+$(this).text()},function(data,status){
			var fdata = data.split("&");
			if(status=='success' && fdata[0]!='ERROR'){
				$(".files").html(fdata[0]).hide().fadeIn(500);
				$("#p_content").append("<input type='button' class='linkButton' value='Back' style='float:right;margin: 1em;font-size:1.5em;' id='back'>");
				$("#new_file").fadeOut();
				$("#code").val(fdata[1]);
				var string = $("#code").val();
				var count = string.match(/\n/g);
				if(count == null){
					line=1;
					$("#code").attr("rows",line);
				}
				else{
					line = count.length+1;
					$("#code").attr("rows",line);
				}
			}
			else if(status=='success' && data=='ERROR'){
				alert('Error loading file: '+value);
			}
			$("#p_content").append("<span style='display: block;margin: 0.3em;font-size:2em;float: left'>Filename:</span><input type='text' id='fid_"+fid+"' class='genCreds filename' value='"+value+"'>");
		});
	});

	$(document).on('click','#back',function(){ //back button to main files
		window.location.reload();
		$("#p_content span,#filename").fadeOut(500).remove();
	});

	$(document).on('keydown','#code',function(event){
		//constantly updated on keydown (keypress in general terms)!
		if(event.keyCode==13){// ENTER KEY
			line++;
            $("#line").append("<span class='number' id='line_"+line+"'>"+line+"</span>");
            $("#code").attr("rows",line);
		}
		else if(event.keyCode==8 || event.keyCode==46){//backspace or delete key
			var string = $("#code").val();
			var count = string.match(/\n/g);
			if(count==null){
				line=1;
				$("#line_1").nextAll().remove();
				$("#code").attr("rows",line);
				return;
			}
			newcount = count.length;
			if(newcount==line-2){
				$("#line_1").siblings().last().remove();
				line--;
				$("#code").attr("rows",line);
			}
		}
	});
	
	$(document).on('keyup','#code',function(){
		var string = $("#code").val();
		var count = string.match(/\n/g);
		//full delete!
		if(count==null){
			line=1;
			$("#line_1").nextAll().remove();
			$("#code").attr("rows",line);
			return;
		}
		var newl = count.length+1;
		//for code pastes
		if(newl>line){
			var diff = newl-line;
			for(var i=1;i<=diff+1;i++){
				var newline = line+i;
				$("#line").append("<span class='number' id='line_"+newline+"'>"+newline+"</span>");
			}
			line = newl+1;
			$("#code").attr("rows",line);
		}

		//for sub-mass deletes
		else if(newl < line){
			$("#line_"+newl).nextAll().remove();
			line = newl;
			$("#code").attr("rows",line);
		}
	});

    $(document).on('click','#save',function(){
    	$.post("utils/save.php",{title: $(".title").text(),folder: $("#subdir").text(),old_name: old_filename,curr_name: $(".filename").val(),fid: fid,filedata: $("#code").val()},function(data,status){
    		if(status=='success' && data!='OK')
    			alert(data);
    		else if(status=='success' && data=='OK'){
    			$("#code").attr('readonly','readonly').css({'cursor':'none','background':'#eaeaea','color':'gray'});
    			//alert('File Saved');
    		}
    	});
    });
    $(document).on('click','#edit',function(){
    	$("#code").removeAttr('readonly').css({'cursor':'text','background':'#f0f3f6','color':'black'});
    });
    /***Compiler***/
    $(document).on('click',"#compile",function(){
        var file = $(".dir").text()+$(".filename").val();
        var mode = $(this).attr('value');
        $.post("utils/terminal.php",{file: file,mode: mode},function(data,status){
                if(status=='success'){
                    $("#run_res").hide().html(data).fadeIn();
                    //alert(data);
                }
            });
    });
    $(document).on('click',"#run",function(){
    	var file = $(".dir").text();
    	var filename= ($(".filename").val()).split(".");
    	if(filename[1]=='cpp' || filename[1]=='c' || filename[1]=='c++' || filename[1]=='cc' || filename[1]=='cxx'){
    		filename[1] = 'exe';
    		filename = filename.join(".");
    	}
    	else if(filename[1]=='java'){
    		filename[1]='class';
    		filename = filename.join(".");
    	}
    	else if(filename[1]=='py' || filename[1]=='pyw' || filename[1]=='pyc' || filename[1]=='pyo' || filename[1]=='pyd'){
    		filename = filename.join(".");
    	}
    	file += filename;
    	var mode = $(this).attr('value');
    	$.post("utils/terminal.php",{file: file,mode: mode},function(data,status){
                if(status=='success'){
                    $("#run_res").hide().html(data).fadeIn();
                    //alert(data);
                }
            });
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
		alert(c);
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
