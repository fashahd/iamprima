$(document).on('change', '#image_upload_file', function () {
	var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

	$('#image_upload_form').ajaxForm({
		beforeSend: function() {
			progressBar.fadeIn();
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		success: function(html, statusText, xhr, $form) {	
			obj = $.parseJSON(html);
			if(obj.status){
				var percentVal = '100%';
				bar.width(percentVal)
				percent.html(percentVal);
				$("#imgArea>img").prop('src',obj.image_medium);
				window.location.reload();
			}else{
				alert(obj.error);
			}
		},
		complete: function(xhr) {
			progressBar.fadeOut();
		}	
	}).submit();
});

$('#formNewPassword').submit(function(event) {
	event.preventDefault();
	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var oldPassword 	= $('#oldPassword').val();
	var newPassword		= $('#newPassword').val();
	var reNewPassword 	= $('#reNewPassword').val();
	
	if(reNewPassword != newPassword){
		swal("Peringatan", "Password Tidak Sama", "warning");
		return;
	}

	$.ajax({
		type : 'POST',
		url  : toUrl+"/changePassword",
		data : {oldPassword:oldPassword,newPassword:newPassword,reNewPassword:reNewPassword},
		// dataType: "json",
		success: function(data){
			// alert(data);
			if(data == "successPassword"){
				swal("Berhasil", "Password Baru Berhasil Dibuat", "success");
				return;
			}else if(data == "wrongPassword"){
				swal("Peringatan", "Pastikan Password Lama Anda Benar", "warning");
				return;
			}else{
				swal("Error", "Hubungi Team IAM PRIMA", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});