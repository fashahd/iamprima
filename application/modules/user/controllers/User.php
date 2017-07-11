<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelActivityUser');
		$this->load->model('ModelUsers');
		$this->load->model('ModelLogin');
		if(!$this->session->userdata("sessUsername")){
			redirect("login/form");
			return;
		}
	}
	
	public function myAccount()
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$personalData	= $this->ModelUsers->getPersonalData($username);
		// $this->ModelActivityUser->setActivityUser($username,6,4);
		
		$data["personalData"]	= $personalData;
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Account";
		$data["pages"]		= "account";
		$this->load->view("layout/sidebar",$data);
	}

	
	public function myProfile()
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$personalData	= $this->ModelUsers->getPersonalData($username);
		
		if($this->session->userdata("sessType")){
			$type = $this->session->userdata("sessType");
		}else{
			$type = "personal";
		}
		
		// $this->ModelActivityUser->setActivityUser($username,6,4);
		
		$data["formProfile"] = $this->formProfile($type);
		$data["personalData"]	= $personalData;
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Profile";
		$data["pages"]		= "profile";
		$this->load->view("layout/sidebar",$data);
	}

	function formProfile($type){
		if($type == "personal"){
			$form 	= $this->ModelUsers->formEditPersonal();
		}else if($type == "apparel"){
			$form 	= $this->ModelUsers->formEditApparel();
		}else if($type == "health"){
			$form 	= $this->ModelUsers->formEditHealth();
		}else if($type == "pb"){
			$form 	= $this->ModelUsers->formEditPB();
		}

		return $form;
	}

	function formProfileAjax(){
		$type 	= $_POST["type"];
		$this->session->set_userdata("sessType",$type);
		return true;
	}

	function updatepersonal(){
		$username		= $this->session->userdata("sessUsername");
		$fullName		= $_POST["fullName"];
		$nomorEvent		= $_POST["nomorEvent"];
		$handphone		= $_POST["handphone"];
		$email			= $_POST["email"];
		$alamat			= $_POST["alamat"];
		$tempatLahir	= $_POST["tempatLahir"];
		$tglLahir		= $_POST["tglLahir"];
		$agama			= $_POST["agama"];
		$pendidikan		= $_POST["pendidikan"];
		$tinggiBadan	= "";
		$jenis_kelamin	= $_POST["jenis_kelamin"];
		$status			= $_POST["status"];
		$npwp 			= $_POST["npwp"];
		$nomor_ktp 		= $_POST["nomor_ktp"];
		
		$arrPersonal	= array($username,$fullName,$nomorEvent,$handphone,$email,$alamat,$tempatLahir,$tglLahir,$agama,$pendidikan,$tinggiBadan,$jenis_kelamin,$status,$npwp,$nomor_ktp);
		
		$this->ModelActivityUser->setActivityUser($username,4,2);
		
		$updateData		= $this->ModelUsers->updatePersonalProfile($arrPersonal);
		
		if($updateData){
			$this->session->set_userdata("sessName",$fullName);
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}

	function updatePB(){
		$username		= $this->session->userdata("sessUsername");
		$pb				= $_POST["pb"];
		$alamat_club	= $_POST["alamat_club"];
		$email_club		= $_POST["email_club"];
		
		
		$arrPersonal = array(
			'username' 		=> $username,
			'club' 			=> $pb,
			'alamat_club' 	=> $alamat_club,
			'email_club' 	=> $email_club,
			'prestasi' 		=> '',
			'pengalaman' 	=> ''
		);
		
		$this->ModelActivityUser->setActivityUser($username,4,2);
		
		$updateData		= $this->ModelUsers->updatePBProfile($arrPersonal);
		
		if($updateData){
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}
	
	function updateHealth(){
		$username		= $this->session->userdata("sessUsername");
		$cedera = $this->input->post('cidera');
		$alergi = $this->input->post('alergi');
		$lemak 	= $this->input->post('lemak');
		
		$arrHealth = array(
			'username' => $username,
			'cedera' => $cedera,
			'alergi' => $alergi,
			'lemak' => $lemak
		);
		
		$this->ModelActivityUser->setActivityUser($username,4,2);
		
		$updateData		= $this->ModelUsers->updateHealth($arrHealth);
		
		if($updateData){
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}

	function updateApparel(){
		$username		= $this->session->userdata("sessUsername");
		$kaos			= $_POST["kaos"];
		$jaket			= $_POST["jaket"];
		$celana			= $_POST["celana"];
		$sepatu			= $_POST["sepatu"];

		$arrApparel = array(
			'username' => $username,
			'kaos' => $kaos,
			'jaket' => $jaket,
			'celana' => $celana,
			'sepatu' => $sepatu
		);
		
		$this->ModelActivityUser->setActivityUser($username,4,2);
		
		$updateData		= $this->ModelUsers->updateApparel($arrApparel);
		
		if($updateData){
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}
	
	function changePassword(){
		$username		= $this->session->userdata("sessUsername");
		$oldPassword	= $_POST["oldPassword"];
		$newPassword	= $_POST["newPassword"];
		$reNewPassword	= $_POST["reNewPassword"];
		
		$updatePassword	= $this->ModelUsers->changePassword($username,$oldPassword,$newPassword);
		
		if($updatePassword == "sukses"){
			$this->ModelActivityUser->setActivityUser($username,4,18);
			echo "successPassword";
			return;
		}else if($updatePassword == "wrong_password"){
			$this->ModelActivityUser->setActivityUser($username,12,18);
			echo "wrongPassword";
			return;
		}else{
			$this->ModelActivityUser->setActivityUser($username,12,18);
			echo "error";
			return;
		}
	}

	function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
		/* read the source image */
		$source_image = FALSE;

		if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
			$source_image = imagecreatefromjpeg($path1);
		}
		else if (preg_match("/png|PNG/", $file_type)) {
			if (!$source_image = @imagecreatefrompng($path1)) {
				$source_image = imagecreatefromjpeg($path1);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$source_image = imagecreatefromgif($path1);
		}  
		if ($source_image == FALSE) {
			$source_image = imagecreatefromjpeg($path1);
		}

		$orig_w = imageSX($source_image);
		$orig_h = imageSY($source_image);

		if ($orig_w < $new_w && $orig_h < $new_h) {
			$desired_width = $orig_w;
			$desired_height = $orig_h;
		} else {
			$scale = min($new_w / $orig_w, $new_h / $orig_h);
			$desired_width = ceil($scale * $orig_w);
			$desired_height = ceil($scale * $orig_h);
		}

		if ($squareSize != '') {
			$desired_width = $desired_height = $squareSize;
		}

		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		// for PNG background white----------->
		$kek = imagecolorallocate($virtual_image, 255, 255, 255);
		imagefill($virtual_image, 0, 0, $kek);

		if ($squareSize == '') {
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
		} else {
			$wm = $orig_w / $squareSize;
			$hm = $orig_h / $squareSize;
			$h_height = $squareSize / 2;
			$w_height = $squareSize / 2;

			if ($orig_w > $orig_h) {
				$adjusted_width = $orig_w / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
			}

			elseif (($orig_w <= $orig_h)) {
				$adjusted_height = $orig_h / $wm;
				$half_height = $adjusted_height / 2;
				imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
			} else {
				imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
			}
		}

		if (@imagejpeg($virtual_image, $path2, 90)) {
			imagedestroy($virtual_image);
			imagedestroy($source_image);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function uploadProfile(){
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		if (isset($_FILES['image_upload_file'])) {
			$output['status'] = FALSE;
			set_time_limit(0);
			$allowedImageType = array(
				"image/gif",
				"image/jpeg",
				"image/pjpeg",
				"image/png",
				"image/x-png"
			);
			
			if ($_FILES['image_upload_file']["error"] > 0) {
				$output['error'] = "Error in File";
			} elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
				$output['error'] = "You can only upload JPG, PNG and GIF file";
			} elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
				$output['error'] = "You can upload file size up to 4 MB";
			} else {
				/*create directory with 777 permission if not exist - start*/
				// createDir(IMAGE_SMALL_DIR);
				// createDir(IMAGE_MEDIUM_DIR);
				/*create directory with 777 permission if not exist - end*/
				$path[0]     = $_FILES['image_upload_file']['tmp_name'];
				$file        = pathinfo($_FILES['image_upload_file']['name']);
				$fileType    = $file["extension"];
				$desiredExt  = 'jpg';
				$fileNameNew = rand(333, 999) . time() . ".$desiredExt";
				$path[1]     = 'assets/pictures/'.$fileNameNew;
				$path[2]     = 'assets/pictures/'.$fileNameNew;
				
				$url = base_url().'assets/pictures/'.$fileNameNew;
				$sql = "UPDATE users SET gambar = '$url' WHERE username = '$username'";
				$this->db->query($sql);
				
				$this->session->set_userdata("sessGambar",$url);
				
				if ($this->createThumb($path[0], $path[1], $fileType, 250, 250, 250)) {
					
					if ($this->createThumb($path[1], $path[2], "$desiredExt", 250, 250, 250)) {
						$output['status']       = TRUE;
						$output['image_medium'] = $path[1];
						$output['image_small']  = $path[2];
					}
				}
			}
			$this->ModelActivityUser->setActivityUser($username,4,19);
			echo json_encode($output);
		}
	}
}
