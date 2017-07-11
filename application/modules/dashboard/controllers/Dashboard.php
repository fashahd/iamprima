<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
		$this->load->module('selection');
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
		$data["module"] 	= "Dashboard";
		$data["pages"]		= "dashboard";
		$this->load->view("layout/sidebar",$data);
	}
	
	public function front()
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		// $this->ModelActivityUser->setActivityUser($username,6,4);
		
		if(!$this->session->userdata("pickGroupID")){
			$pickGroupID = NULL;
		}else{
			$pickGroupID = $this->session->userdata("pickGroupID");
		}

		// echo $pickGroupID;
		$now = date("Y-m-d");
		// $data["highlight"]	= $this->showHightlight($username,$now,$pickGroupID);
		$data["gambar"]		= $gambar;
		$data["now"] 		= $now;
		$data["pickGroupID"] = $pickGroupID;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Highlights";
		$data["pages"]		= "front";
		$this->load->view("layout/sidebar",$data);
	}
	
	function showHightlight($username,$now,$groupID = NULL){
		$highlight 	= $this->ModelUsers->getWellnessHighlight($username,$now,$groupID);
		$optGroup	= $this->selection->getOptGroup($username);
		
		$rateWellness = "";
		if($highlight){
			foreach($highlight as $row){
				$wellness_rate = $row->wellness_rate;
				$total_atlet_sum 	= $row->total_atlet_sum;
				$total_atlet		= $row->total_atlet;
				$total_percentage	= $row->total_percentage;
				if($wellness_rate == 0){
					$color	= "#9e9e9e";
				}else if($wellness_rate == 1){
					$color	= "#d50000";
				}else if($wellness_rate == 2){
					$color	= "#ff9800";
				}else if($wellness_rate == 3){
					$color	= "#ffff00";
				}else if($wellness_rate == 4){
					$color	= "#76ff03";
				}else if($wellness_rate == 5){
					$color	= "#1b5e20";
				}
				
				$rateWellness .= '					
					<div class="col s6 m6 l6 center-align">
						<div class="flight-state">
							<h2 class="margin"><i class="mdi-action-favorite"  style="color:'.$color.'"></i></h2>
							<p class="ultra-small">'.$total_atlet.' Atlet</p>
							<p class="ultra-small">'.$total_percentage.' %</p>
						</div>
					</div>
				';
			}
		}
		
		$day = date("l", strtotime($now));
		$date = date("d M Y", strtotime($now));
		$ret = '
			<div id="flight-card" class="card">
				<div class="card-header cyan">
					<div class="card-title">
						<h4 class="flight-card-title">Wellness Highlights</h4>
						<p class="flight-card-date">'.$day.', '.$date.'</p>
					</div>
				</div>
				<div class="card-content white">
					<div class="row">
						<div class="input-field col s12">
						'.$optGroup.'
					  </div>
					</div>
					<div class="row flight-state-wrapper">
						'.$rateWellness.'
					</div>
				</div>
			</div>
		';
		
		echo $ret;
	}
}
