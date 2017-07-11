$('#formLogin').submit(function(event) {
	event.preventDefault();
	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var username = $('#username').val();
	var password = $('#password').val();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/validation",
		data : {username:username,password:password},
		// dataType: "json",
		success: function(data){
			if(data == "wrong_password"){
				swal("Gagal Login", "Password Salah", "error");
			}else if(data == "not_registered"){
				swal("Gagal Login", "Username Tidak Terdaftar", "error");
			}else if(data == "success"){
				window.location.href = toUrl;
			}else{
				swal("Gagal Login", "Hubungin Team IAM PRIMA", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});