<?php
class ModelUsers extends CI_Model {
	
	function getAtletHighLight($username,$now){
		$sql 	= "SELECT wellness_date, value_wellness FROM users WHERE username = '$username' AND wellness_date = '$now'";
		$query 	= $this->db->query($sql);
		if($query->num_rows()>0){
			$row = $query->row();
			$wellness_date 	= $row->wellness_date;
			$value_wellness = $row->value_wellness;

			return array($wellness_date,$value_wellness); 
		}else{
			return false;
		}
	}

	function getWellnessHighlight($username,$now,$groupID = NULL){
		if(isset($groupID) && $groupID !='ALL'){
			$sql = " select a.*,ifnull(b.total_cidera,0) as total_cidera,NOW() as last_update"
				 . " from v_master_wellness_sum_bygroup a "
				 . " left outer join v_count_cidera_bygroup b on a.groupcode = b.groupcode"
				 . " where a.groupcode = '".$groupID."' order by a.wellness_rate";
		}else{
			$sql = "SELECT * FROM `m_wellness_sum_generate` WHERE username = '$username' AND  date_generate = '$now'";
		}
		
		$query	= $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function getGroup($username){
		$query = $this->db->query("SELECT a.*,b.* FROM v_users as a"
			 . " LEFT JOIN master_role as b on b.role_id = a.role_id"
			 . " WHERE a.username = '$username'");
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$role_id = $row->role_id;
				$role_type = $row->role_type;
			}
		}
		
		$sql = "SELECT *, master_group_id as groupcode FROM v_master_group WHERE username = '$username' ORDER BY master_group_name ASC";
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}			
	}
	
	function getAtletInfo($atletID){
		$sql = " SELECT d.master_group_category,a.value_wellness,a.wellness_date,a.gambar as gambar_atl,a.name,a.username,b.master_atlet_nomor_event,d.master_group_name FROM users as a"
			 . " LEFT JOIN master_information_personal as b on b.master_atlet_username = a.username"
			 . " LEFT JOIN master_role as c on c.role_id = a.role_id"
			 . " LEFT JOIN master_group as d on d.master_group_id = c.group_id"
			 . " WHERE a.username = '$atletID'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$result = $query->result();
			foreach ($result as $key) {
				$atletGroup = $key->master_group_name;
				$atletEvent = $key->master_atlet_nomor_event;
				$atletName	= $key->name;
				$atletID	= $key->username;
				$atletPic	= $key->gambar_atl;
				$atletWellnessValue = $key->value_wellness;
				$atletWellnessDate	= $key->wellness_date;
				$groupCat = $key->master_group_category;
			}
		}else{
			$atletGroup = "";
			$atletEvent	= "";
			$atletName	= "";
			$atletID	= "";
			$atletPic 	= "";
			$atletWellnessValue = "";
			$atletWellnessDate 	= "";
			$groupCat = "";
		}
		
		return array($atletName,$atletID,$atletGroup,$atletEvent,$atletPic,$atletWellnessValue,$atletWellnessDate,$groupCat);
	}
	
	function changePassword($username,$oldPassword,$newPassword){
		$sql = " SELECT a.*,b.* FROM users as a"
			 . " LEFT JOIN master_role as b on b.role_id = a.role_id"
			 . " WHERE a.username = '$username'";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
			$row 	= $query->row();
			$salt	= $row->salt;
			$enc_p	= $row->encrypted_password;
			$code	= $row->license_code;
			$hash 	= $this->checkhashSSHA($salt, $oldPassword);			
			if ($enc_p == $hash) {
				$password_md5 = md5($newPassword);
				$uuid = uniqid('', true);
				$hash = $this->hashSSHA($newPassword);
				$encrypted_password = $hash["encrypted"]; // encrypted password
				$salt = $hash["salt"]; // salt
				$sql1 = " UPDATE users SET unique_id = '$uuid',encrypted_password = '$encrypted_password' ,salt = '$salt'"
						. " WHERE username = '$username'";
				$query1 = $this->db->query($sql1);
				if($query1){
					return "sukses";
				}else{
					return "error";
				}
			}else{
				return "wrong_password";
			}
		}
	}
	
	function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
	
	function checkhashSSHA($salt, $password) {
		$hash = base64_encode(sha1($password . $salt, true) . $salt);

		return $hash;
	}
	
	function getPersonalData($username){
		$sql = " Select a.*, b.*, c.*, d.*, e.* From master_information_personal as a"
			 . " LEFT join master_information_apparel as e on e.username = a.master_atlet_username"
			 . " Left join users as d on d.username = a.master_atlet_username"
			 . " Left join master_role as b on b.role_id = d.role_id"
			 . " Left join master_group as c on c.master_group_id = b.group_id"
			 . " where a.master_atlet_username = '$username' LIMIT 1";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}			
	}
	
	function getHealthData($username){
		$sql = "Select * From master_information_health where username = '$username'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}	
	}
	
	function getClubData($username){
		$sql = "Select * From master_information_club where username = '$username'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
	}
		
	function updateHealth($data){
		$sql_select = "select * from master_information_health where username = '$data[username]'";
		$query_select = $this->db->query($sql_select);
		if($query_select->num_rows() > 0){
			$this->db->where('username', $data['username']);
			$this->db->update('master_information_health', $data);
			return true;
		}else{
			$this->db->insert('master_information_health', $data);
			return true;
		}
	}
	
	function updatePBProfile($data){		
		$sql_select = "select * from master_information_club where username = '$data[username]'";
		$query_select = $this->db->query($sql_select);
		if($query_select->num_rows() > 0){
			$this->db->where('username', $data['username']);
			$this->db->update('master_information_club', $data);
			return true;
		}else{
			$this->db->insert('master_information_club', $data);
			return true;
		}
	}
	
	function updateApparel($data){
		$sql_select = "select * from master_information_apparel where username = '$data[username]'";
		$query_select = $this->db->query($sql_select);
		if($query_select->num_rows() > 0){
			$this->db->where('username', $data['username']);
			$this->db->update('master_information_apparel', $data);
			return true;
		}else{
			$this->db->insert('master_information_apparel', $data);
			return true;
		}
	}
	
	function updatePersonalProfile($arrPersonal){
		list($username,$fullName,$nomorEvent,$handphone,$email,$alamat,$tempatLahir,$tglLahir,$agama,$pendidikan,$tinggiBadan,$jenis_kelamin,$status,$npwp,$nomor_ktp)=$arrPersonal;
		$sql_select = "select * from master_information_personal where master_atlet_username = '$username'";
		$query_select = $this->db->query($sql_select);
		if($query_select->num_rows() > 0){
			$sql = " UPDATE master_information_personal set master_atlet_nama = '$fullName',"
				 . " master_atlet_address = '$alamat',master_atlet_handphone = '$handphone',"
				 . " master_atlet_email = '$email', master_atlet_tempat_lahir = '$tempatLahir',"
				 . " master_atlet_tanggal_lahir = '$tglLahir',master_atlet_agama = '$agama',"
				 . " master_atlet_tinggi_badan = '$tinggiBadan', master_atlet_jenis_kelamin = '$jenis_kelamin',"
				 . " master_atlet_pendidikan = '$pendidikan', master_atlet_status = '$status',"
				 . " npwp = '$npwp', nomor_ktp = '$nomor_ktp',"
				 . " master_atlet_nomor_event = '$nomorEvent' where master_atlet_username = '$username'";
			$query = $this->db->query($sql);
			$sql1 = "update users set name = '$fullName' where username = '$username'";
			$query1 = $this->db->query($sql1);
		}else{
			$sql = " insert into master_information_personal (master_atlet_username,master_atlet_nama,"
				 . " master_atlet_address,master_atlet_handphone,master_atlet_email,"
				 . " master_atlet_tempat_lahir,master_atlet_tanggal_lahir,master_atlet_agama,"
				 . " master_atlet_tinggi_badan, master_atlet_jenis_kelamin,master_atlet_pendidikan,"
				 . " master_atlet_status,master_atlet_nomor_event,npwp,nomor_ktp)"
				 . " values('$username','$fullName','$alamat','$handphone','$email','$tempatLahir',"
				 . " '$tglLahir','$agama','$tinggiBadan','$jenis_kelamin','$pendidikan','$status',"
				 . " '$nomorEvent','$npwp','$nomor_ktp')";			
			$query = $this->db->query($sql);
			$sql1 = "update users set name = '$fullName' where username = '$username'";
			$query1 = $this->db->query($sql1);
		}
		
		if($query){
			return true;
		}else{
			return false;
		}
	}

	function formEditPB(){
		$username	= $this->session->userdata("sessUsername");
		$personalData	= $this->ModelUsers->getClubData($username);
		$nama_club = "";
		$alamat_club = "";
		$email_club  = "";
		$prestasi  = "";
		if($personalData){
			foreach($personalData as $club){ 
				$nama_club		= $club->club;
				$alamat_club 	= $club->alamat_club;
				$email_club 	= $club->email_club;
				$prestasi 		= $club->prestasi;
			}
		}
		$form = '
			<form class="col s12" id="formPB">
				<div class="row">
					<div class="input-field col s6">
						<input id="pb" type="text" value="'.$nama_club.'">
						<label for="pb">Nama PB/Cabor</label>
					</div>
					<div class="input-field col s6">
						<input id="alamat_club" type="text" value="'.$alamat_club.'">
						<label for="alamat_club">Alamat PB/Cabor</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="email_club" type="email" value="'.$email_club.'">
						<label for="email_club">Email PB/Cabor</label>
					</div>
				</div>
				<button class="btn btn-block cyan">Simpan</button>
			</form>
		';

		return $form;
	}

	function formEditHealth(){
		$username	= $this->session->userdata("sessUsername");
		$personalData	= $this->ModelUsers->getHealthData($username);
		$cedera = "";
		$alergi = "";
		$lemak  = "";
		if($personalData){
			foreach($personalData as $health){ 
				$cedera = $health->cedera;
				$alergi = $health->alergi;
				$lemak  = $health->lemak;
			}
		}
		$form = '
			<form class="col s12" id="formHealth">
				<div class="row">
					<div class="input-field col s6">
						<input id="cidera" type="text" value="'.$cedera.'" placeholder="Lutut">
						<label for="cidera">Cidera yang Sering Dialami</label>
					</div>
					<div class="input-field col s6">
						<input id="alergi" type="text" value="'.$alergi.'" placeholder="Udang, Debu, Ikan">
						<label for="alergi">Alergi yang Dialami</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="lemak" type="text" value="'.$lemak.'">
						<label for="lemak">Persentasi Lemak</label>
					</div>
				</div>
				<button class="btn btn-block cyan">Simpan</button>
			</form>
		';

		return $form;
	}

	function formEditApparel(){
		$username	= $this->session->userdata("sessUsername");
		$personalData	= $this->ModelUsers->getPersonalData($username);

		$kaos = "";
		$jaket = "";
		$celana = "";
		$sepatu = "";
		if($personalData){
			foreach($personalData as $personal){
				$kaos = $personal->kaos;
				$jaket = $personal->jaket;
				$celana = $personal->celana;
				$sepatu = $personal->sepatu;
			}
		}

		$form = '
			<form class="col s12" id="formApparel">
				<div class="row">
					<div class="input-field col s6">
						<input id="kaos" type="text" value='.$kaos.' placeholder="S/M/L/XL">
						<label for="kaos">Ukuran Kaos</label>
					</div>
					<div class="input-field col s6">
						<input id="jaket" type="text" value='.$jaket.' placeholder="S/M/L/XL">
						<label for="jaket">Ukuran Jaket</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="celana" type="text" value='.$celana.' placeholder="30/31/32/33">
						<label for="celana">Ukuran Celana</label>
					</div>
					<div class="input-field col s6">
						<input id="sepatu" type="text" value='.$sepatu.' placeholder="43/9.9">
						<label for="sepatu">Ukuran Sepatu</label>
					</div>
				</div>
				<button class="btn btn-block cyan">Simpan</button>
			</form>
		';

		return $form;
	}
	
	function formEditPersonal(){
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$data["name"] 		= $name;
		$personalData	= $this->ModelUsers->getPersonalData($username);
		
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
		$npwp = "";
		$nomor_ktp = "";
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
				$npwp = $personal->npwp;
				$nomor_ktp = $personal->nomor_ktp;
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
				'
				<option value="laki" selected>Laki Laki</option>
				<option value="perempuan">Perempuan</option>
				';
		}else if($jenis_kelamin == "perempuan"){
			$jenis_kelamin = "Perempuan";
			$optkelamin = 
				'
				<option value="laki">Laki Laki</option>
				<option value="perempuan" selected>Perempuan</option>
				';
		}else{
			$optkelamin = 
				'
				<option>-- Pilih --</option>
				<option value="laki">Laki Laki</option>
				<option value="perempuan">Perempuan</option>
				';
		}
			
		if($status == "menikah"){
			$status = "Menikah";
			$optstatus = 
				'
				<option value="menikah" selected >Menikah</option>
				<option value="single">Belum Menikah</option>
				';
		}else if($status == "single"){		
			$status = "Belum Menikah";
			$optstatus = 
				'
				<option value="menikah" >Menikah</option>
				<option value="single" selected >Belum Menikah</option>
				';
		}else{
			$optstatus = 
				'
				<option>-- Pilih --</option>
				<option value="menikah">Menikah</option>
				<option value="single">Belum Menikah</option>
				';
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
					<div class="input-field col s6">
						<input id="tempatLahir" type="text" value='.$tempat_lahir.'>
						<label for="tempatLahir">Tempat Lahir</label>
					</div>
					<div class="input-field col s6">
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
					<div class="input-field col s6">
						<input id="nomor_ktp" type="text" value='.$nomor_ktp.'>
						<label for="nomor_ktp">Nomor KTP</label>
					</div>
					<div class="input-field col s6">
						<input id="npwp" type="text" value='.$npwp.'>
						<label for="npwp">Nomor NPWP</label>
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

		return $form;
	}
}
?>