<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//nama class harus sama dengan nama file dan diawali dengan huruf besar
class Login extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("ModelLogin");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function form(){		
		if($this->session->userdata("sessUsername")){
			redirect("home");
		}
		$this->load->view("form");
	}
	
	function validation(){
		$username	= $_POST["username"];
		$password	= $_POST["password"];
		$arrResult	= $this->ModelLogin->doLogin($username,$password);
		
		list($message,$result) = $arrResult;
		
		if($message == "success"){
			foreach($result as $row){
				$name 		= $row->name;
				$username 	= $row->username;
				$gambar 	= $row->gambar;
				$role_name	= $row->role_name;
				$role_id 	= $row->role_id;
				$role_type 	= $row->role_type;
				$group_id 	= $row->group_id;
				
				$this->ModelActivityUser->setActivityUser($username,1,18);
				
				$this->session->set_userdata('sessUsername',$username);
				$this->session->set_userdata('sessName',$name);
				$this->session->set_userdata('sessGambar',$gambar);
				$this->session->set_userdata('sessRoleID',$role_id);
				$this->session->set_userdata('sessRoleName',$role_name);
				$this->session->set_userdata('sessRoleType',$role_type);
				$this->session->set_userdata('sessGroupID',$group_id);
			}
			
			echo "success";
			return;
		}else if($message == "not_registered"){
			echo "not_registered";
			return;
		}else if($message == "wrong_password"){
			echo "wrong_password";
			return;
		}else{
			echo "error";
			return;
		}
	}
	
	function signout(){
		$username = $this->session->userdata("sessUsername");
		$this->ModelActivityUser->setActivityUser($username,2,7);
        $this->session->unset_userdata('sessUsername');
        $this->session->unset_userdata('sessName');
        $this->session->unset_userdata('sessGambar');
        $this->session->unset_userdata('sessRoleID');
        $this->session->unset_userdata('sessRoleName');
        $this->session->unset_userdata('sessRoleType');
        $this->session->unset_userdata('sessGroupID');
        redirect('login/form','refresh');
	}
}