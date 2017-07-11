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

$('#registerForm').submit(function(event) {
	event.preventDefault();
	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var username 	= $("#username").val();
	var name 		= $("#full_name").val();
	var licence 	= $("#licence").val();
	var password 	= $("#password").val();
	var provinsi	= $("#provinsi").val();
	var gender		= $('input[name=gender]:checked').val();
	var birth		= $("#birth").val();
	var email 		= $("#email").val();

	$.ajax({
		type : 'POST',
		url  : toUrl+'/login/createUser',
		data : {username:username,name:name,licence:licence,password:password,provinsi:provinsi,gender:gender,birth:birth,email:email},
		// dataType: "json",
		success: function(data){
			if(data == "user_exist"){
				swal({
                    title: 'User Existed',
                    text: 'Username Sudah Terpakai',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
				return;
			}
			if(data == "licence_exist"){
				swal({
                    title: 'Licence Code Expired',
                    text: 'Licence Sudah Terpakai',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
				return;
			}
			if(data == "licence_suspen"){
				swal({
                    title: 'Licence Code Suspended',
                    text: 'Licence Tidak Aktif',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
				return;
			}
			if(data == "licence_not"){
				swal({
                    title: 'Licence Code Unregisted',
                    text: 'Licence Tidak Terdaftar',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
				return;
			}
			if(data == "regist_failed"){
				swal({
                    title: 'Ooopss',
                    text: 'Pendaftaran Gagal, Coba Lagi',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                });
				return;
			}
			if(data == "regist_success"){
				window.location.href = toUrl+"/login/form";
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});	
});