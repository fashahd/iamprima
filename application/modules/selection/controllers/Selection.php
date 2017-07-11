<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selection extends MY_controller {

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
		$this->load->model('ModelSelect');
	}
	
	function day2Ind($hari){
		switch($hari){      
			case 0 : {
						$hari='Minggu';
					}break;
			case 1 : {
						$hari='Senin';
					}break;
			case 2 : {
						$hari='Selasa';
					}break;
			case 3 : {
						$hari='Rabu';
					}break;
			case 4 : {
						$hari='Kamis';
					}break;
			case 5 : {
						$hari="Jum'at";
					}break;
			case 6 : {
						$hari='Sabtu';
					}break;
			default: {
						$hari='UnKnown';
					}break;
		}
		return $hari;
	}
	
	function month2Ind($bln){
		switch($bln){       
			case 1 : {
						$bln='Januari';
					}break;
			case 2 : {
						$bln='Februari';
					}break;
			case 3 : {
						$bln='Maret';
					}break;
			case 4 : {
						$bln='April';
					}break;
			case 5 : {
						$bln='Mei';
					}break;
			case 6 : {
						$bln="Juni";
					}break;
			case 7 : {
						$bln='Juli';
					}break;
			case 8 : {
						$bln='Agustus';
					}break;
			case 9 : {
						$bln='September';
					}break;
			case 10 : {
						$bln='Oktober';
					}break;     
			case 11 : {
						$bln='November';
					}break;
			case 12 : {
						$bln='Desember';
					}break;
			default: {
						$bln='UnKnown';
					}break;
		}
		
		return $bln;
	}

	function getCideraCount(){
		$username	= $this->session->userdata("sessUsername");
		$total_cidera = $this->ModelSelect->getCideraCount($username);
		echo $total_cidera;
		return;
	}
	
	function setAtlet(){
		$atletID	= $_POST["atletID"];
		
		$this->session->set_userdata("sessAtlet",$atletID);
		
		return true;
	}
	
	function setGroup(){
		$groupID	= $_POST["groupID"];
		
		$this->session->set_userdata("pickGroupID",$groupID);
		
		return true;
	}
	
	function unsetGroup(){		
		$this->session->unset_userdata("pickGroupID");
		$this->session->unset_userdata("sessAtlet");
		
		return true;
	}
	
	public function getOptGroup($username)
	{
		$sessGroup 	= $this->session->userdata("pickGroupID");
		$role_type = $this->session->userdata("sessRoleType");
		if($role_type == "PRIMA" OR $role_type == "RCV" OR $role_type == "SCH"){
			$all = "<option value='ALL'>Semua Cabang Olahraga</option>";
		}else{
			$all = "";
		}
		$getGroup	= $this->ModelSelect->getGroup($username);
		$optGroup = "<select onchange='onChangeGroup()' id='optGroup' class='browser-default js--animations'>$all";
		if($getGroup){
			foreach($getGroup as $row){
				$group_id 	= $row->groupcode;
				$group_nm	= $row->master_group_name;
				$group_ico	= $row->master_group_logo;
				if($sessGroup == $group_id){
					$slct = "selected";
				}else{
					$slct = "";
				}
				$optGroup .= "<option $slct value='$group_id'>$group_nm</option>";
			}
		}
		$optGroup .="</select";
		
		return $optGroup;
	}
	
	public function selectGroup($username)
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Pililh Group";
		$getGroup	= $this->ModelSelect->getGroup($username);
		if($getGroup){
			$list = "";
			foreach($getGroup as $row){
				$group_id 	= $row->groupcode;
				$group_nm	= $row->master_group_name;
				$group_ico	= $row->master_group_logo;
				$sql = " SELECT COUNT(username) as jml_atl FROM v_member_atlet WHERE master_licence_group = '$group_id'";
				$query = $this->db->query($sql);
				if($query->num_rows()>0){
					$row = $query->row();
					$jmlAtlet = $row->jml_atl;
				}
				$sql1 = " SELECT COUNT(b.name) as jml_chc FROM master_role as a"
					 . " LEFT JOIN users as b on b.role_id = a.role_id"
					 . " WHERE a.group_id = '$group_id' AND a.role_type = 'CHC'";
				$query1 = $this->db->query($sql1);
				if($query1->num_rows()>0){
					$row = $query1->row();
					$jml_chc = $row->jml_chc;
				}
				$list .= '
						<li class="collection-item avatar email-unread" style="cursor:pointer" onClick="setGroup(\''.$group_id.'\')">
                            <img src="'.$group_ico.'" alt="" class="circle">
                            <span class="email-title">'.$group_nm.'</span>
                            <p class="truncate grey-text ultra-small">Atlet : '.$jmlAtlet.'</p>
                        </li>
				';
			}
		}else{
			$list = "";
		}
		// $data["page"] = "ajaxView/selection/setGroup";
		$data["listGroup"]	= $list;
		$data["pages"]		= "setGroup";
		$this->load->view("layout/sidebar",$data);
	}
	
	public function selectAtlet($groupID)
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Pilih Atlet";
		$getAtlet	= $this->ModelSelect->getAtlet($groupID);
		$list = "";
		if($getAtlet){
			foreach($getAtlet as $row){
				$name 		= $row->name;
				$gambar		= $row->gambar;
				$group		= $row->master_group_name;
				$event		= $row->master_atlet_nomor_event;
				$atlet		= $row->username;
				$wellness	= $row->value_wellness;
				$wellness_date	= $row->wellness_date;
				$dttm		= date("Y-m-d");
				
				$query = $this->db->query(" SELECT cidera FROM master_kondisi WHERE username='$atlet'"
										. " AND created_dttm >= '$dttm 00:00:00' AND created_dttm <= '$dttm 23:59:59'");
				if($query->num_rows()>0){
					$row 	= $query->row();
					$cidera = $row->cidera;
					if($cidera == ""){
						$cidera = "-";
					}
				}else{
					$cidera	= "-";
				}
				
				if($wellness_date == $dttm){			
					if($wellness <= 59){
						$btn = "#FF0000";
					}elseif($wellness >= 60 && $wellness <= 69) {
						$btn = "#FF9D00";
					}elseif($wellness >= 70 && $wellness <= 79){
						$btn = "#E1FF00";
					}elseif($wellness >= 80 && $wellness <= 89){
						$btn = "#9BFF77";
					}else{
						$btn = "#00CE25";
					}				
				}else{
					$btn = "#607D8B";
				}
				
				$list .= '
					<li class="collection-item avatar email-unread" style="cursor:pointer" onClick="setAtlet(\''.$atlet.'\')">
						<img src="'.$gambar.'" alt="" class="circle">
						<span class="email-title">'.$name.'</span>
						<p class="truncate grey-text ultra-small">cabang Olahraga : '.$group.'</p>
						<p class="truncate grey-text ultra-small">Nomor Event : '.$event.'</p>
						<a href="#!" class="secondary-content email-time">
							<i class="mdi-action-favorite" style="color:'.$btn.';font-size:30px"></i>
						</a>
					</li>
				';
			}
		}
		// $data["page"] = "ajaxView/selection/setGroup";
		$data["listAtlet"]	= $list;
		$data["pages"]		= "setAtlet";
		$this->load->view("layout/sidebar",$data);
	}
	
	public function checkBoxAtlet($groupID)
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Wellness";
		$getAtlet	= $this->ModelSelect->getAtlet($groupID);
		$list = "";
		if($getAtlet){
			foreach($getAtlet as $row){
				$name 		= $row->name;
				$gambar		= $row->gambar;
				$group		= $row->master_group_name;
				$event		= $row->master_atlet_nomor_event;
				$atlet		= $row->username;
				$wellness	= $row->value_wellness;
				$wellness_date	= $row->wellness_date;
				$dttm		= date("Y-m-d");
				
				$list .= '
						<tr>
							<td>
								<p>
									<input type="checkbox" id="test'.$atlet.'" name="atletID[]" value="'.$atlet.'"/>
									<label for="test'.$atlet.'">'.$name.'</label>
								</p>
							</td>
						</tr>
				';
			}
		}
		return $list;
	}
	
	function selectWeek(){
		$getWeek	= $this->ModelSelect->getWeek();
		$now		= date("Y-m-d");
		$tmpNow		= explode('-', $now);
		$bln		= $tmpNow[1]; //mengambil array $tgl[1] yang isinya 03
		$thn		= $tmpNow[0]; //mengambil array $tgl[0] yang isinya 2015
		$ref_date	= strtotime( "$now" ); //strtotime ini mengubah varchar menjadi format time
		$nowWeek	= date( 'W', $ref_date );
		
		$list = '<select id="selectWeek" class="browser-default js--animations"';
		if($getWeek){
			foreach($getWeek as $row){
				$weekID		= $row->uid;
				$week 		= $row->weekly;
				$start_date	= $row->start_date;
				$end_date	= $row->end_date;
				$year		= $row->year;
				$start		= date("d M Y", strtotime($start_date));
				$end		= date("d M Y", strtotime($end_date));
				
				if($nowWeek == $week){$slc="selected";}else{$slc="";}
				
				$list .= '<option '.$slc.' value="'.$weekID.'">'.$start.' S/d '.$end.'</option>';
			}
		}
		$list .= "</select>";
		return $list;
	}
}
