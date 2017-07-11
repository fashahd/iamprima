<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mealplan extends MY_Controller {

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
		if(!$this->session->userdata("sessUsername")){
			redirect("login/form");
			return;
		}
	}
	
	public function index()
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		// $this->ModelActivityUser->setActivityUser($username,6,4);
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Meal Plan";
		$data["pages"]		= "meal";
		$this->load->view("layout/sidebar",$data);
	}

	function showImage(){
		$url 	= $_POST["url"];

		$modal 	= '
			<div id="modal" class="modalPopup">
				<!-- Modal content -->
				<div class="modal-content">
				</div>
			</div>
		';

		echo $modal;
	}
}
