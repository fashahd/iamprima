function goToDataRecovery(monotonyID){
	$.ajax({
		type	: 'POST',
		url		: toUrl+'/recovery/setMonotonyID',
		data	: {monotonyID:monotonyID},
		success: function(data){
			window.location.href = "recoveryTable";
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	})
}

function viewPlan(dttm,atletID){
	$.ajax({
		type	: 'POST',
		url		: toUrl+'/recovery/viewPlan',
		data	: {dttm:dttm,atletID:atletID},
		success: function(data){
			$("#modalMonotony").html(data);
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	})
}

function closeModal(dttm, recoveryData) {
		var modal = document.getElementById('myModal_' + dttm + recoveryData);
		modal.style.display = "none";
	}