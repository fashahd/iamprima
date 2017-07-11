function showProfile(type){
	$("#profile").html('<div class="progress"><div class="indeterminate"></div></div>');	
	
	if(type == "personal"){
		var subUrl	= "formEditPersonal";
	}

	$.ajax({
		type : 'POST',
		url  : toUrl+"/user/formProfileAjax",
		data : {type:type},
		// dataType: "json",
		success: function(data){
			// $("#profileAjax").html(data);
			window.location.reload();
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
}

$('#formHealth').submit(function(event) {
	event.preventDefault();	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var cidera		= $('#cidera').val();
	var alergi		= $('#alergi').val();
	var lemak	 	= $('#lemak').val();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/updateHealth",
		data : {
			cidera	: cidera,
			alergi	: alergi,
			lemak	: lemak
		},
		// dataType: "json",
		success: function(data){
			if(data == "sukses"){
				swal("Berhasil", "Profile Berhasil Disimpan", "success");
			}else{
				swal("Error", "Silahkan Coba Lagi", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#formApparel').submit(function(event) {
	event.preventDefault();	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var kaos		= $('#kaos').val();
	var jaket		= $('#jaket').val();
	var celana	 	= $('#celana').val();
	var sepatu	 	= $('#sepatu').val();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/updateApparel",
		data : {
			kaos	: kaos,
			jaket	: jaket,
			celana	: celana,
			sepatu	: sepatu
		},
		// dataType: "json",
		success: function(data){
			if(data == "sukses"){
				swal("Berhasil", "Profile Berhasil Disimpan", "success");
			}else{
				swal("Error", "Silahkan Coba Lagi", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#formPB').submit(function(event) {
	event.preventDefault();
	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var pb 			= $('#pb').val();
	var alamat_club = $('#alamat_club').val();
	var email_club 	= $('#email_club').val();

	$.ajax({
		type : 'POST',
		url  : toUrl+"/updatePB",
		data : {
			pb	: pb,
			alamat_club	: alamat_club,
			email_club	: email_club
		},
		// dataType: "json",
		success: function(data){
			if(data == "sukses"){
				swal("Berhasil", "Profile Berhasil Disimpan", "success");
			}else{
				swal("Error", "Silahkan Coba Lagi", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});

$('#formPersonal').submit(function(event) {
	event.preventDefault();
	// alert(toUrl);
	// return;
	
	// // get the form data
	// // there are many ways to get this data using jQuery (you can use the class or id also)
	var fullName 	= $('#fullName').val();
	var nomorEvent 	= $('#nomorEvent').val();
	var handphone 	= $('#handphone').val();
	var email 		= $('#email').val();
	var alamat 		= $('#alamat').val();
	var tempatLahir	= $('#tempatLahir').val();
	var tanggal		= $('#tanggal').val();
	var bulan		= $('#bulan').val();
	var tahun		= $('#tahun').val();
	var agama		= $('#agama').val();
	var npwp 		= $('#npwp').val();
	var nomor_ktp 	= $('#nomor_ktp').val();
	var pendidikan	= $('#pendidikan').val();
	var jenis_kelamin	= $('#jenis_kelamin').val();
	var status		= $('#status').val();
	var tglLahir	= tahun+"-"+bulan+"-"+tanggal;

	$.ajax({
		type : 'POST',
		url  : toUrl+"/updatepersonal",
		data : {
			fullName:fullName,
			nomorEvent:nomorEvent,
			handphone:handphone,
			email:email,
			alamat:alamat,
			tempatLahir:tempatLahir,
			tglLahir:tglLahir,
			agama:agama,
			pendidikan:pendidikan,
			jenis_kelamin:jenis_kelamin,
			status:status,
			nomor_ktp:nomor_ktp,
			npwp:npwp
		},
		// dataType: "json",
		success: function(data){
			if(data == "sukses"){
				swal("Berhasil", "Profile Berhasil Disimpan", "success");
			}else{
				swal("Error", "Silahkan Coba Lagi", "error");
			}
		},error: function(xhr, ajaxOptions, thrownError){            
			alert(xhr.responseText);
		}
	});
});