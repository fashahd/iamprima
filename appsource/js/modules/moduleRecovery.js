function goToRecoveryData(week){
	$.ajax({
		type	: 'POST',
		url		: toUrl+'/recovery/setWeek',
		data	: {week:week},
		success: function(data){
			window.location.href = "recovery/recoveryTable";
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	})
}

$("#saveRecovery").submit(function(event){
	event.preventDefault();
	var data = $('input:checkbox:checked').map(function() { return this.value; }).get();
	$.ajax({
		type: "POST",
		url: toUrl+"/recovery/saveRecoveryDay",
		data: {point:data},
		success: function(data) {
			if(data == "sukses"){
				swal({
                    title: 'Success',
                    text: 'Berhasil Menyimpan Recovery',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                },function(){
					window.location.reload();
					return;
				});
				return;
			}else{
				swal({
                    title: 'Ooopss',
                    text: 'Gagal Menyimpan Recovery, Silahkan Coba Lagi',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
				return;
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			swal({
				title: 'Failed Connection',
				text: 'Check Internet Connection Or Call IAM PRIMA Team',
				type: 'danger',
				confirmButtonClass: "btn btn-danger",
				buttonsStyling: false
			});
			return;
		}
	});
});

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