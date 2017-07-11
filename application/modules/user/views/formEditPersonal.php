<?php 
	$event = "";
	$alamat = "";
	$telp = "";
	$handphone = "";
	$email = "";
	$tempat_lahir = "";
	$tgl_lahir = "";
	$agama = "";
	$tinggi_badan = "";
	$golongan_darah = "";
	$pendidikan = "";
	$pekerjaan = "";
	$status = "";
	$jenis_kelamin = "";
	$optstatus = "";
	$optkelamin = "";
	$kaos = "";
	$jaket = "";
	$celana = "";
	$sepatu = "";
	if($personalData){
		foreach($personalData as $personal){
			$event = $personal->master_atlet_nomor_event;
			$alamat = $personal->master_atlet_address;
			$telp = $personal->master_atlet_telp;
			$handphone = $personal->master_atlet_handphone;
			$email = $personal->master_atlet_email;
			$tempat_lahir = $personal->master_atlet_tempat_lahir;
			$tgl_lahir = $personal->master_atlet_tanggal_lahir;
			$agama = $personal->master_atlet_agama;
			$tinggi_badan = $personal->master_atlet_tinggi_badan;
			$golongan_darah = $personal->master_atlet_golongan_darah;
			$pendidikan = $personal->master_atlet_pendidikan;
			$pekerjaan = $personal->master_atlet_pekerjaan;
			$status = $personal->master_atlet_status;
			$jenis_kelamin = $personal->master_atlet_jenis_kelamin;
			$kaos = $personal->kaos;
			$jaket = $personal->jaket;
			$celana = $personal->celana;
			$sepatu = $personal->sepatu;
		}
	}
	
	$tmpTanggal	= date("d",strtotime($tgl_lahir));
	$tmpBulan	= date("m",strtotime($tgl_lahir));
	$tmpTahun	= date("Y",strtotime($tgl_lahir));
	
	$optTanggal = "";
	for($i=1;$i<=31;$i+=1){
		if($i < 10){
			$i = "0".$i;
		}
		
		if($i == $tmpTanggal){$slct="selected";}else{$slct="";}
		$optTanggal	.="<option $slct value='$i'>$i</option>";
	}
	
	$bln=array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");
	$optBulan	= "";
	for($bulan=1; $bulan<=12; $bulan++){
		if($bulan<=9) {
			$vBulan	= "0$bulan";
		}else{
			$vBulan	= $bulan;
		}
		
		if($vBulan == $tmpBulan){$slct="selected";}else{$slct="";}
		$optBulan .="<option $slct value='$vBulan'>$bln[$bulan]</option>"; 
	}
	
	$now	= date("Y");
	$optTahun = "";
	for($i=1930;$i<=$now;$i++){
		if($i == $tmpTahun){$slct="selected";}else{$slct="";}
		$optTahun	.="<option $slct value='$i'>$i</option>";
	}
		
	if($jenis_kelamin == "laki"){
		$jenis_kelamin = "Laki - Laki";
		$optkelamin = 
			'<select class="form-control" id="jenis_kelamin">
			  <option value="laki" selected>Laki Laki</option>
			  <option value="perempuan">Perempuan</option>
			</select>';
	}else if($jenis_kelamin == "perempuan"){
		$jenis_kelamin = "Perempuan";
		$optkelamin = 
			'<select class="form-control" id="jenis_kelamin">
			  <option value="laki">Laki Laki</option>
			  <option value="perempuan" selected>Perempuan</option>
			</select>';
	}else{
		$optkelamin = 
			'<select class="form-control" id="jenis_kelamin">
			  <option>-- Pilih --</option>
			  <option value="laki">Laki Laki</option>
			  <option value="perempuan">Perempuan</option>
			</select>';
	}
		
	if($status == "menikah"){
		$status = "Menikah";
		$optstatus = 
			'<select class="form-control" id="status">
			  <option value="menikah" selected >Menikah</option>
			  <option value="single">Belum Menikah</option>
			</select>';
	}else if($status == "single"){		
		$status = "Belum Menikah";
		$optstatus = 
			'<select class="form-control" id="status">
			  <option value="menikah" >Menikah</option>
			  <option value="single" selected >Belum Menikah</option>
			</select>';
	}else{
		$optstatus = 
			'<p>Status</p>
			<select class="form-control" id="status">
			  <option>-- Pilih --</option>
			  <option value="menikah">Menikah</option>
			  <option value="single">Belum Menikah</option>
			</select>';
	}
	$form = '
			<form class="col s12" id="formPersonal">
				<div class="row">
					<div class="input-field col s6">
						<input id="fullName" type="text" value='.$name.'>
						<label for="fullName">Nama Lengkap</label>
					</div>
					<div class="input-field col s6">
						<input id="nomorEvent" type="text" value='.$event.'>
						<label for="nomorEvent">Nomor Event</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6 l6">
						<input id="tempatLahir" type="text" value='.$tempat_lahir.'>
						<label for="tempatLahir">Tempat Lahir</label>
					</div>
					<div class="input-field col s6 l6">
						<input id="alamat" type="text" value='.$alamat.'>
						<label for="alamat">Alamat Lengkap</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s4">
						<select id="tanggal">
							'.$optTanggal.'
						</select>
						<label>Tanggal Lahir</label>
					</div>
					<div class="input-field col s4">
						<select id="bulan">
							'.$optBulan.'
						</select>
						<label>Bulan Lahir</label>
					</div>
					<div class="input-field col s4">
						<select id="tahun">
							'.$optTahun.'
						</select>
						<label>Tahun Lahir</label>
					</div>
					
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="handphone" type="text" value='.$handphone.'>
						<label for="handphone">Nomor Handphone</label>
					</div>
					<div class="input-field col s6">
						<input id="email" type="text" value='.$email.'>
						<label for="email">Alamat Email</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="alamat" type="text" value='.$alamat.'>
						<label for="alamat">Alamat Lengkap</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="agama" type="text" value='.$agama.'>
						<label for="agama">Agama</label>
					</div>
					<div class="input-field col s6">
						<input id="pendidikan" type="text" value='.$pendidikan.'>
						<label for="pendidikan">Pendidikan Terakhir</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<select id="jenis_kelamin">
							'.$optkelamin.'
						</select>
						<label for="jenis_kelamin">Jenis Kelamin</label>
					</div>
					<div class="input-field col s6">
						<select id="status">
							'.$optstatus.'
						</select>
						<label for="status">Status</label>
					</div>
				</div>
				<button class="btn btn-block cyan">Simpan</button>
			</form>
		';
	echo $form;
?>