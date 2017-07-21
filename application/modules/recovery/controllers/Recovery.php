<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recovery extends MY_controller {

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
		$this->load->model('ModelSelect');
		$this->load->model('ModelRecovery');
		$this->load->model('ModelMonotony');
		$this->load->module('selection');
		if(!$this->session->userdata("sessUsername")){
			redirect("login/form");
			return;
		}
	}
	
	public function recoveryData()
	{
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Recovery Management";
		
		$this->ModelActivityUser->setActivityUser($username,6,8);
		
		if(!$this->session->userdata("month")){
			$month = date("m");
		}else{
			$month = $this->session->userdata("month");
		}
		
		if(!$this->session->userdata("year")){
			$year = date("Y");
		}else{
			$year = $this->session->userdata("year");
		}
		
		if($role_type == "ATL"){
			$this->showRecovery($username,$month,$year);
		}else{
			if(!$this->session->userdata("pickGroupID")){				
				$this->selection->selectGroup($username);
				return;
			}
			if(!$this->session->userdata("sessAtlet")){				
				$this->selection->selectAtlet($this->session->userdata("pickGroupID"));
				return;
			}
			$atletID	= $this->session->userdata("sessAtlet");
			$this->showRecovery($atletID,$month,$year);
		}
		
		$this->session->unset_userdata("msg");
	}

	function showRecovery($atletID,$month,$year){
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$this->session->set_userdata("sessAtlet",$atletID);
		
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Recovery Management";
		$bln=array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");
		$optBulan	= "";
		for($bulan=1; $bulan<=12; $bulan++){
			if($bulan<=9) {
				$tmpBulan = "0$bulan"; 
			}else{
				$tmpBulan = $bulan;
			}
			if($tmpBulan == $month){$slcMonth = "selected";}else{$slcMonth = "";}
			$optBulan .="<option $slcMonth value='$tmpBulan'>$bln[$bulan]</option>"; 
		}
		
		$now	= date("Y");
		$optTahun = "";
		for($i=1960;$i<=$now;$i++){
			if($i == $year){$slcYear = "selected";}else{$slcYear = "";}
			$optTahun	.="<option $slcYear value='$i'>$i</option>";
		}
		
		$atletInfo	= $this->ModelUsers->getAtletInfo($atletID);
		list($atletName,$atletID,$atletGroup,$atletEvent,$atletPic,$atletWellnessValue,$atletWellnessDate) = $atletInfo;
		
		
		if($role_type == "ATL"){
			$labelAtlet	= $atletName;
			$labelGroup = "";
		}else{
			if($role_type == "CHC"){$groupID = $group_id;}else{$groupID = $this->session->userdata("pickGroupID");}
			$labelAtlet	= $this->ModelSelect->optAtlet($groupID,$atletID);
			$labelGroup = "onClick='changeGroup()'";
			$listGroup 	= $this->ModelSelect->getGroup($username);
		}
		
		$data['labelAtlet'] = $labelAtlet;
		$data['labelGroup'] = $labelGroup;
		$data['atletID'] 	= $atletID;
		$data['atletGroup'] = $atletGroup;
		$data['atletEvent'] = $atletEvent;
		$data['atletPic'] 	= $atletPic;
		$data['optBulan']	= $optBulan;
		$data['optTahun']	= $optTahun;
		$data['atletWellnessValue'] = $atletWellnessValue;
		$data['atletWellnessDate']  = $atletWellnessDate;
		$data["recoveryData"]	= $this->monotonyTable($atletID,$month,$year);
		$data["pages"]			= "recoveryData";
		$this->load->view("layout/sidebar",$data);
	}

	function monotonyTable($atletID,$month,$year){
		$role_type	= $this->session->userdata("sessRoleType");
		$monotonyData	= $this->ModelRecovery->getMonotony($atletID,$month,$year);
		
		$selection 	= new Selection();
		$bulan		= $selection->month2Ind($month);
		$ret ="<tbody><tr><td colspan='4' class='center'>Training Load $bulan $year</td></tr>
						<tr>
							<td class='cyan white-text'>Tanggal</th>
							<td class='cyan white-text'></th>
							<td class='cyan white-text'>Total</th>
						</tr></tbody>";
		if($monotonyData){
			foreach ($monotonyData as $key) {
				$startDay		 = $key->start_date;
				$endDay			 = $key->end_date;
				$start 			 = date("d M Y",strtotime($startDay));
				$end 			 = date("d M Y",strtotime($endDay));
				$weekly 		 = $key->weekly;
				$weeklyID 		 = $key->uid;

				$loadWeekly 	 = $this->ModelRecovery->getLoadWeek($weeklyID,$atletID);
				
				$ret .= "
					<tr>
						<tr>
							<td style='font-weight:bold' colspan='2'>
								<span style='cursor:pointer' onClick='goToRecoveryData(\"$weeklyID\")'>$start - $end</span>
							</td>
							<td>$loadWeekly</td>
						</tr>
					</tr>
				";
			}
		}else{
			$ret .= "<tr><td>Data Kosong</td></tr>";
		}
		
		return $ret;
	}
	
	function setMonotonyID(){
		$monotonyID	= $_POST["monotonyID"];
		$this->session->set_userdata("monotonyID",$monotonyID);
		return true;
	}

	function setWeek(){
		$week = $_POST["week"];
		$this->session->set_userdata("sessWeek",$week);
		return true;
	}

	function recoveryTable(){
		$monotonyID = $this->session->userdata("monotonyID");
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$atletID 	= $this->session->userdata("sessAtlet");
		$atletInfo	= $this->ModelUsers->getAtletInfo($atletID);
		list($atletName,$atletID,$atletGroup,$atletEvent,$atletPic,$atletWellnessValue,$atletWellnessDate) = $atletInfo;
		
		
		if($role_type == "ATL"){
			$labelAtlet	= $atletName;
			$labelGroup = "";
		}else{
			if($role_type == "CHC"){$groupID = $group_id;}else{$groupID = $this->session->userdata("pickGroupID");}
			$labelAtlet	= $this->ModelSelect->optAtlet($groupID,$atletID);
			$labelGroup = "onClick='changeGroup()'";
			$listGroup 	= $this->ModelSelect->getGroup($username);
		}
		
		$week = $this->session->userdata("sessWeek");
		$data['labelAtlet'] = $labelAtlet;
		$data['labelGroup'] = $labelGroup;
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data['labelAtlet'] = $atletName;
		$data['atletID'] 	= $atletID;
		$data['atletGroup'] = $atletGroup;
		$data['atletEvent'] = $atletEvent;
		$data['atletPic'] 	= $atletPic;
		$data['atletWellnessValue'] = $atletWellnessValue;
		$data['atletWellnessDate']  = $atletWellnessDate;
		$data["module"] 	= "Recovery Management";
		$data["recoveryTable"] 	= $this->showrecoveryTable($week);
		$data["pages"]			= "recoveryTable";
		$this->load->view("layout/sidebar",$data);
	}

	function showrecoveryTable($week){
		$listWeek = $this->ModelSelect->listWeekByID($week);
		list($week,$start_date,$end_date,$year)=$listWeek;
	}
	
	function recoveryDetail(){
		$monotonyID 	= $this->session->userdata("monotonyID");
		$atletID 	= $this->session->userdata("sessAtlet");
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$atletInfo	= $this->ModelUsers->getAtletInfo($atletID);
		list($atletName,$atletID,$atletGroup,$atletEvent,$atletPic,$atletWellnessValue,$atletWellnessDate,$group_cat) = $atletInfo;
		$detail 	= $this->ModelRecovery->getRecoveryDetail($monotonyID);
		$ret = "";
		$retTotal = "";
		if($detail){
			$ttlMonotony = 0;
			$tmpdttm = 0;
			foreach($detail as $row){
				$detailID 	= $row->monotonyDetailID;
				$detailDate = $row->monotonyDetailDate;
				$intensity 	= $row->monotonyIntensity;
				$volume 		= $row->monotonyVolume;
				$tempTTL 		= $intensity*$volume;
				$ttlMonotony = $ttlMonotony+$tempTTL;
				$sql = " SELECT SUM(monotonyIntensity*monotonyVolume) as monotonyPerDay"
							." FROM master_monotony_detail WHERE monotonyDetailDate = '$detailDate'"
							." AND monotonyID = '$monotonyID'";
				$query = $this->db->query($sql);
				if($query->num_rows()>0){
					$row 	= $query->row();
					$monotonyPerDay = $row->monotonyPerDay;
				}
				$sql = " SELECT SUM(monotonyIntensity*monotonyVolume) as monotonyPerWeek"
							." FROM master_monotony_detail WHERE monotonyID = '$monotonyID'";
				$query = $this->db->query($sql);
				if($query->num_rows()>0){
					$row 	= $query->row();
					$monotonyPerWeek = $row->monotonyPerWeek;
				}			
			
				if($group_cat == "GW400"){		
					if($monotonyPerWeek <= 3500 OR $monotonyPerWeek < 5000){
						$target = 25;
					}else if($monotonyPerWeek <= 5000 OR $monotonyPerWeek < 6500){
						$target = 35;
					}else{
						$target = 40;
					}			
				}else{		
					if($monotonyPerWeek <= 2000 OR $monotonyPerWeek < 3500){
						$target = 25;
					}else if($monotonyPerWeek <= 3500 OR $monotonyPerWeek < 5000){
						$target = 35;
					}else{
						$target = 40;
					}
				}
				$plan =	($target/$monotonyPerWeek)*$monotonyPerDay;
				$recoveryPlan = number_format($plan);
				$tmp_dttm = explode(" ", $detailDate);
				$dtmm1 = $tmp_dttm[0];
				$dttm = date('d M Y',strtotime($dtmm1));
				$day = date('D', strtotime($dtmm1));
				$rid = date('dmY', strtotime($detailDate));
				
				$recoveryPoin =	$this->ModelRecovery->getRecoveryPoint($atletID,$dtmm1);
				$arrRecovery[$dtmm1]	= $recoveryPoin;

				$dayList = array(
					'Sun' => 'Minggu',
					'Mon' => 'Senin',
					'Tue' => 'Selasa',
					'Wed' => 'Rabu',
					'Thu' => 'Kamis',
					'Fri' => 'Jumat',
					'Sat' => 'Sabtu'
				);
				$btnRecovery = '<span id="button_'.$dtmm1.'" class="waves-effect waves-light" onClick="viewPlan(\''.$dtmm1.'\',\''.$atletID.'\')">'
							 . ''.$recoveryPlan.' Pts</span>';
				if($tmpdttm<>$detailDate){
					$ret .= "
						<tr>
							<td style='font-size:10pt;text-align:left;font-weight:bold' width='50%'>
								<a class='btn-flat btn-brand' href='".base_url()."index.php/recovery/recoveryDetail/$detailDate/$monotonyID'>$dayList[$day], $dttm</a>
							</td>
							<td style='font-weight:bold;text-align:center'>$recoveryPoin Pts</td>
							<td style='font-weight:bold;text-align:center'>$btnRecovery</td>
						</tr>
					";
					$tmpdttm = $detailDate;
				}
			}
			if($group_cat == "GW400"){		
				if($ttlMonotony <= 3500 OR $ttlMonotony < 5000){
					$CM = "#388E3C";
					$target = 25;
				}else if($ttlMonotony <= 5000 OR $ttlMonotony < 6500){
					$CM = "#FF9800";
					$target = 35;
				}else{
					$CM = "#D50000";
					$target = 40;
				}			
			}else{		
				if($ttlMonotony <= 2000 OR $ttlMonotony < 3500){
					$CM = "#388E3C";
					$target = 25;
				}else if($ttlMonotony <= 3500 OR $ttlMonotony < 5000){
					$CM = "#FF9800";
					$target = 35;
				}else{
					$CM = "#D50000";
					$target = 40;
				}
			}
			$ttlRecover	= array_sum($arrRecovery);
			$remains = $target - $ttlRecover;
			
			$retTotal .="<tr><td class='btn-flat btn-brand' colspan='2'><b>Total Recovery</b></td><td><b>$ttlRecover Pts</b></td></tr>";
			$retTotal .="<tr><td class='btn-flat btn-brand' colspan='2'><b>Target Recovery</b></td><td><b>$target Pts</b></td></tr>";
			$retTotal .="<tr><td class='btn-flat btn-brand' colspan='2'><b>Remains Recovery</b></td><td><b>$remains Pts</b></td></tr>";
			$retTotal .="<tr><td class='btn-flat btn-brand' colspan='2'><b>Total Weekly Training Load</b></td><td style='background: $CM'><b>$ttlMonotony</b></td></tr>";
		}
		if($role_type == "ATL"){
			$labelAtlet	= $atletName;
		}else{
			if($role_type == "CHC"){$groupID = $group_id;}else{$groupID = $this->session->userdata("pickGroupID");}
			$listAtlet	= $this->ModelSelect->getAtlet($groupID);
			$labelAtlet	= '<select id="pickAtlet" class="selectpicker col-md-4 text-center" data-style="select-with-transition" title="Pilih Atlet" data-size="7">';
			if($listAtlet){
				foreach($listAtlet as $row){
					$name 		= $row->name;
					$group		= $row->master_group_name;
					$event		= $row->master_atlet_nomor_event;
					$atlet		= $row->username;
					$wellness	= $row->value_wellness;
					$wellness_date	= $row->wellness_date;
					
					if($atlet == $atletID){$slc = "selected";}else{$slc = "";}
					
					$labelAtlet	.= '<option '.$slc.' value="'.$atlet.'">'.$name.'</option>';
				}
			}
			$labelAtlet	.= '</select>';
		}
// 		echo $gambar."<br>".$atletPic;
		$data['labelAtlet'] = $labelAtlet;
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data['labelAtlet'] = $atletName;
		$data['atletID'] 	= $atletID;
		$data['atletGroup'] = $atletGroup;
		$data['atletEvent'] = $atletEvent;
		$data['atletPic'] 	= $atletPic;
		$data['atletWellnessValue'] = $atletWellnessValue;
		$data['atletWellnessDate']  = $atletWellnessDate;
		$data["module"] 	= "Recovery Management";
		$data["ret"]  = $ret;
		$data["retTotal"] = $retTotal;
		$data["pages"] = "recoveryDetail";
		$this->load->view("layout/sidebar",$data);
	}
	
	function viewPlan(){
		$dttm 	 = $_POST["dttm"];
		$atletID = $_POST["atletID"];
		
		$cek	= $this->db->query(" SELECT a.*,b.* FROM master_recovery_plan as a"
							     . " LEFT JOIN master_recovery_point as b on a.recoveryPoint = b.point_id"
								 . " WHERE a.atlet_id = '$atletID' AND a.recoveryPlanDttm='$dttm'");
		if($cek->num_rows()>0){
			$plan	= "";
			$no		= 1;
			foreach($cek->result() as $row){
				$recoveryNm		= $row->recovery_name;
				$recoveryPts	= $row->recovery_point;
				$plan .= "<tr><td>$no</td><td>$recoveryNm</td><td>$recoveryPts Point</td></tr>";
				
				$no++;
			}
		}else{
			$plan	= "<tr><td colspan='4'>Belum Ada Recovery Plan</td></tr>";
		}
		
		$modal = '
			<div id="myModal_'.$dttm.''.$atletID.'" class="modalPopup">
				<!-- Modal content -->
					<div class="modal-content" style="width:80%;height:100%;z-index:999;">
					<h3 onclick="closeModal(\''.$dttm.'\',\''.$atletID.'\')">X</h3>
					<div class="table-responsive">
						<table class="table">
							<thead><tr><th colspan="4">Recovery Plan Per Tanggal <b>'.date('d M Y',strtotime($dttm)).'</th></tr></thead>
							<thead><tr><th>No</th><th>Jenis Recovery</th><th>Point</th></tr></thead>
							'.$plan.'
						</table>
					</div>
				</div>
			</div>
		';
		
		echo $modal;
	}

	function createRecovery(){
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Recovery Management";
		$getOptRecovery = $this->ModelRecovery->getOptRecovery();
		$input = "";
		if($getOptRecovery){
			$tmp = 0;
			foreach($getOptRecovery as $key){
				$point_id		= $key->point_id;
				$recovery_nm	= $key->recovery_name;
				$point			= $key->recovery_point;
				$image			= $key->image;
				$type_id		= $key->type_id;
				$type_nm		= $key->recovery_type;
				$cekPoint 	= $this->ModelRecovery->cekPoint($point_id,$username);
			
				if($cekPoint == $point_id){
					$checked = "checked";
				}else{
					$checked = "";
				}
				
				$img = '';
				if($tmp<>$type_id){
					$input .= "<thead><tr><th colspan='3'><img width='100%' src='".base_url()."assets/images/".$image."'/></th></tr><tr><th colspan='3'><p class='text-black'>$type_nm</p></th></tr></thead>";
					// $input .= '
						// <ul id="task-card" class="collection with-header">
							// <li class="collection-item dismissable"><img width="100%" src="'.base_url().'assets/images/'.$image.'"/></li>
							// <li class="collection-item dismissable"><p>'.$type_nm.'</p></li>
						// </ul>
					// ';
					$tmp = $type_id;
				}
				$input.="<tbody><tr><td><input $checked type='checkbox' id='task3_$point_id' name='point[]' value='$point_id'/>"
					. "<label for='task3_$point_id'> $recovery_nm</label> <a class='secondary-content'>"
					. "<span class='ultra-small'>$point Pts</span></a></td></tr></tbody>";
			}		
		}
		$data["ret"] = $input;
		$data["pages"] = "createRecovery";
		$this->load->view("layout/sidebar",$data);
	}

	function saveRecoveryDay(){
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
		
		$point 			= $_POST["point"];

		$save = $this->ModelRecovery->saveRecovery($point,$username);
		echo $save;
		return;
	}
}
