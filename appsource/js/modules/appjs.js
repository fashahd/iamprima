
function dashboard(dttm,username,groupID){
	$("#highlight").html(circle);
	$.ajax({
		type : 'POST',
		url  : toUrl+"/dashboard/showHightlight/"+username+"/"+dttm+"/"+groupID,
		success: function(data){
			$("#highlight").html(data);
		},error: function(xhr, ajaxOptions, thrownError){
			$("#highlight").html("Bad Connection, Please Check Your Connection");          
			// alert(xhr.responseText);
		}
	});
}

function setGroup(groupID){
	// alert(toUrl);
	// return;
	$.ajax({
		type : 'POST',
		url  : toUrl+"/setGroup",
		data : {groupID:groupID},
		// dataType: "json",
		success: function(data){
			window.location.reload();
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

function changeGroup(){
	$.ajax({
		type : 'POST',
		url  : toUrl+"/unsetGroup",
		success: function(data){
			window.location.reload();
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

$("#optGroup").change(function(){
	var groupID	= $("#optGroup").val();
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/selection/setGroup",
		data : {groupID:groupID},
		// dataType: "json",
		success: function(data){
			window.location.reload()
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

function onChangeGroup(){
	var groupID	= $("#optGroup").val();
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/selection/setGroup",
		data : {groupID:groupID},
		// dataType: "json",
		success: function(data){
			window.location.reload()
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
};

function setAtlet(atletID){
	// alert(atletID);
	$.ajax({
		type : 'POST',
		url  : toUrl+"/setAtlet",
		data : {atletID:atletID},
		// dataType: "json",
		success: function(data){
			window.location.reload()
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

$("#pickAtlet").change(function(){
	var atletID	= $("#pickAtlet").val();
	
	$.ajax({
		type : 'POST',
		url  : toUrl+"/setAtlet",
		data : {atletID:atletID},
		// dataType: "json",
		success: function(data){
			window.location.reload()
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});