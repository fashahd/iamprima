<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmc extends MX_controller {

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
		$this->load->model('ModelMonotony');
		$this->load->model('ModelPMC');
		$this->load->module('selection');
		if(!$this->session->userdata("sessUsername")){
			redirect("login/form");
			return;
		}
	}
	
	public function dataMonotony()
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
		$data["module"] 	= "Training Load";
		// $selection 	= new Selection();
		
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
			$this->showMonotony($username,$month,$year);
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
			$this->showMonotony($atletID,$month,$year);
		}
		
		$this->session->unset_userdata("msg");
	}
	
	function showMonotony($atletID,$month,$year){
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
		$data["module"] 	= "Training Load";
		
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
		for($i=$now;$i>=2010;$i--){
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
		
		$data["monotonyData"]	= $this->monotonyTable($atletID,$month,$year);
		$data["pages"]			= "monotonyData";
		$this->load->view("layout/sidebar",$data);
	}
	
	function filterMonotony(){
		$atletID	= $this->session->userdata("sessAtlet");
		$month		= $_POST["month"];
		$year		= $_POST["year"];
		
		$this->session->set_userdata("month",$month);
		$this->session->set_userdata("year",$year);
		
		$ret	= $this->monotonyTable($atletID,$month,$year);
		echo $ret;
	}

	function monotonyTable($atletID,$month,$year){
		$role_type	= $this->session->userdata("sessRoleType");
		$monotonyData	= $this->ModelMonotony->getMonotony($atletID,$month,$year);
		
		$selection 	= new Selection();
		$bulan		= $selection->month2Ind($month);
		$ret ="<thead><tr><th colspan='4' class='center red white-text'>Training Load $bulan $year</th><tr></thead>";
		if($monotonyData){
			foreach ($monotonyData as $key) {
				$created_dttm	 = $key->created_dttm;
				$user_id		 = $key->created_user_id;
				$monotonyID 	 = $key->monotonyID;
				$startDay		 = $key->monotonyStartDttm;
				$endDay			 = $key->monotonyEndDttm;
				$date 			 = date("d M Y H:i:s",strtotime($created_dttm));
				$start 			 = date("d M Y",strtotime($startDay));
				$end 			 = date("d M Y",strtotime($endDay));
				
				$sql	= $this->db->query("SELECT name FROM users WHERE username = '$user_id'");
				if($sql->num_rows()>0){
					$row		= $sql->row();
					$created_user_nm	= $row->name;
				}else{
					$created_user_nm = "";
				}
				
				if($role_type == "KSC"){
					$btnDelete	= '<button onClick="deleteMonotony(\''.$monotonyID.'\')"class="btn-floating waves-effect waves-light red">
                                        <i class="mdi-action-delete"></i>
                                    </button>';
				}else{
					$btnDelete = "";
				}
				
				$query	= $this->db->query(" SELECT SUM(monotonyVolume*monotonyIntensity) as monotonyPerDay FROM master_monotony_detail"
										 . " WHERE monotonyID = '$monotonyID' group by monotonyID");
				if($query->num_rows()>0){
					$row	= $query->row();
					$monotonyPerDay = $row->monotonyPerDay;
				}else{
					$monotonyPerDay	= 0;
				}
				
				$ret .= "
					<tr id='data_$monotonyID'>
						<tr>
							<td class='blue white-text'>Tanggal</td>
							<td class='blue white-text'>Total</td>
							<td class='blue white-text'>$btnDelete</td>
						</tr>
						<tr>
							<td style='font-weight:bold'>
								<a href='#' onClick='goToPMC(\"$monotonyID\")'>$start - $end</a>
							</td>
							<td style='font-weight:bold' colspan='2'>
								$monotonyPerDay
							</td>
						</tr>
						<tr>
							<td colspan='4'>Dibuat Pada $date</td>
						</tr>
						<tr>
							<td colspan='4'>Dibuat Oleh $created_user_nm</td>
						</tr>
					</tr>
				";
			}
		}else{
			$ret .= "<tr><td>Data Kosong</td></tr>";
		}
		
		return $ret;
	}
	
	function setAtletMonotony(){
		$arrAtlet	= $_POST["atletID"];
		$sessWeek	= $_POST["week"];
		
		$this->session->set_userdata("sessArrAtlet",$arrAtlet);
		$this->session->set_userdata("sessWeek",$sessWeek);
		return true;
	}
	
	function setMonotonyID(){
		$monotonyID	= $_POST["monotonyID"];
		$this->session->set_userdata("monotonyID",$monotonyID);
		return true;
	}
	
	function pmcData(){
		$monotonyID	= $this->session->userdata("monotonyID");
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
		$data["module"] 	= "Training Load";
		
		$atletID	= $this->session->userdata("sessAtlet");
		
		$atletInfo	= $this->ModelUsers->getAtletInfo($atletID);
		list($atletName,$atletID,$atletGroup,$atletEvent,$atletPic,$atletWellnessValue,$atletWellnessDate) = $atletInfo;
		
		if($role_type == "ATL"){
			$labelAtlet	= $atletName;
			$labelGroup = "";
		}else{
			if($role_type == "CHC"){$groupID = $group_id;}else{$groupID = $this->session->userdata("pickGroupID");}
			$labelAtlet	= $atletName;
			$labelGroup = "onClick='changeGroup()'";
			$listGroup 	= $this->ModelSelect->getGroup($username);
		}
		
		$data['labelAtlet'] = $labelAtlet;
		$data['labelGroup'] = $labelGroup;
		$data['pmcList'] 	= $this->ModelPMC->getPmcList($monotonyID,$role_type);
		$data['atletID'] 	= $atletID;
		$data['atletGroup'] = $atletGroup;
		$data['atletEvent'] = $atletEvent;
		$data['atletPic'] 	= $atletPic;
		$data['monotonyID'] = $monotonyID;
		$data['atletWellnessValue'] = $atletWellnessValue;
		$data['atletWellnessDate']  = $atletWellnessDate;
		$data['table']		= "";
		$data['monotony_id'] = $monotonyID;
		
		$data["pages"]		= "pmcData";
		$this->load->view("layout/sidebar",$data);
	}

	function savePMC(){
		$username		= $this->session->userdata("sessUsername");
		$monotonyID		= $this->session->userdata("monotonyID");
		$atletID		= $this->session->userdata("sessAtlet");
		$detail_id		= $_POST["detail_id"];
		$actualWarmUp 	= $_POST["actualWarmUp"];
		$actualCore 	= $_POST["actualCore"];
		$actualCoolDown = $_POST["actualCoolDown"];
		$typePmc 		= $_POST["typePmc"];
		$detailSession 	= $_POST["detailSession"];
		$volcore 		= $_POST["volcore"];
		$volwarm 		= $_POST["volwarm"];
		$volcool 		= $_POST["volcool"];
		$role_type		= $this->session->userdata("sessRoleType");

		for($i=0; $i<count($detail_id); $i++) {
			$sql 	= " UPDATE master_monotony_detail set pmcActualCore = '{$actualCore[$i]}',"
					. " pmcActualWarmUp='{$actualWarmUp[$i]}', pmcActualCoolDown='{$actualCoolDown[$i]}',"
					. " pmcVolumeCore='{$volcore[$i]}', pmcVolumeWarmUp='{$volwarm[$i]}', pmcVolumeCoolDown='{$volcool[$i]}'"
					. " WHERE monotonyDetailID = '{$detail_id[$i]}'";
			$query 	= $this->db->query($sql);
		}
		if($query){
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}

	function showPMCYear(){
		$atletID		= $this->session->userdata("sessAtlet");
		$year	= $_POST["year"];
		
		$pmc	= $this->ModelPMC->getPmcYear($year,$atletID);
		
		if($pmc){
			$tmpDate = 1;
			foreach($pmc as $row){
				$detail_id			= $row->monotonyDetailID;
				$detail_date		= $row->monotonyDetailDate;
				$detail_intensity	= $row->monotonyIntensity;
				
				//PMC Physic
				$durasiInti			= $row->pmcVolumeCore;
				$durasiWarmUp		= $row->pmcVolumeWarmUp;
				$durasiCooldown		= $row->pmcVolumeCoolDown;
				$rpeInti			= $row->pmcActualCore;
				$rpeWarmUp			= $row->pmcActualWarmUp;
				$rpeCooldown		= $row->pmcActualCoolDown;
				$TssHourInti		= $this->getTssHour($rpeInti);
				$TssHourWarmUp		= $this->getTssHour($rpeWarmUp);
				$TssHourCooldown	= $this->getTssHour($rpeCooldown);
				
				$warmUp				= ($durasiWarmUp/60)*$TssHourWarmUp;
				$training			= ($durasiInti/60)*$TssHourInti;
				$coolDown			= ($durasiCooldown/60)*$TssHourCooldown;
				
				
				$TotalTss[$detail_date][$detail_id]	= $warmUp+$training+$coolDown;
				
				// if($tmpDate<>$detail_date){
					// echo array_sum($TotalTss[$detail_date]);
					// $tmpDate = $detail_date;
				// }
			}
			
			$first = true;
			foreach($TotalTss as $date => $id){
				$dailyTss	= array_sum($id);
				$ATL_exp	= EXP(-1/7);
				$ATL		= 179.61;
				
				$CTL_exp	= EXP(-1/42);
				$CTL		= 62.36;
				
				if ( $first )
				{
					$ATL_Start 	= $ATL;					
					$CTL_Start	= $CTL;
					
					$first 		= false;
				}
				else
				{
					$ATL_Start = $dailyTss*(1-$ATL_exp)+$ATL_Start*$ATL_exp;
					$CTL_Start = $dailyTss*(1-$CTL_exp)+$CTL_Start*$CTL_exp;
					// do something
				}
				
				// $D3*(1-ATL_exp)+ATL_start*ATL_exp
				
				$fatigue	= $dailyTss*(1-$ATL_exp)+$ATL_Start*$ATL_exp;
				$fitness	= $dailyTss*(1-$CTL_exp)+$CTL_Start*$CTL_exp;				
				$tsb		= $fitness-$fatigue;
				
				$arrDate[]		= $date;
				$arrFatigue[]	= (int)$fatigue;
				$arrFitness[]	= (int)$fitness;
				$arrTsb[]		= (int)$tsb;
			}
			
			$data = array('categories'=>$arrDate, 'fatigue'=>$arrFatigue, 'fitness'=>$arrFitness, 'tsb'=>$arrTsb);
			$json = json_encode($data);
			echo $json;
		}
	}
	
	function showPMCMonth(){
		$atletID		= $this->session->userdata("sessAtlet");
		$year	= $_POST["year"];
		$month	= $_POST["month"];
		
		$pmc	= $this->ModelPMC->getPmcMonth($year,$month,$atletID);
		
		if($pmc){
			$tmpDate = 1;
			foreach($pmc as $row){
				$detail_id			= $row->monotonyDetailID;
				$detail_date		= $row->monotonyDetailDate;
				$detail_intensity	= $row->monotonyIntensity;
				
				//PMC Physic
				$durasiInti			= $row->pmcVolumeCore;
				$durasiWarmUp		= $row->pmcVolumeWarmUp;
				$durasiCooldown		= $row->pmcVolumeCoolDown;
				$rpeInti			= $row->pmcActualCore;
				$rpeWarmUp			= $row->pmcActualWarmUp;
				$rpeCooldown		= $row->pmcActualCoolDown;
				$TssHourInti		= $this->getTssHour($rpeInti);
				$TssHourWarmUp		= $this->getTssHour($rpeWarmUp);
				$TssHourCooldown	= $this->getTssHour($rpeCooldown);
				
				$warmUp				= ($durasiWarmUp/60)*$TssHourWarmUp;
				$training			= ($durasiInti/60)*$TssHourInti;
				$coolDown			= ($durasiCooldown/60)*$TssHourCooldown;
				
				
				$TotalTss[$detail_date][$detail_id]	= $warmUp+$training+$coolDown;
				
				// if($tmpDate<>$detail_date){
					// echo array_sum($TotalTss[$detail_date]);
					// $tmpDate = $detail_date;
				// }
			}
			
			$first = true;
			foreach($TotalTss as $date => $id){
				$dailyTss	= array_sum($id);
				$ATL_exp	= EXP(-1/7);
				$ATL		= 179.61;
				
				$CTL_exp	= EXP(-1/42);
				$CTL		= 62.36;
				
				if ( $first )
				{
					$ATL_Start 	= $ATL;					
					$CTL_Start	= $CTL;
					
					$first 		= false;
				}
				else
				{
					$ATL_Start = $dailyTss*(1-$ATL_exp)+$ATL_Start*$ATL_exp;
					$CTL_Start = $dailyTss*(1-$CTL_exp)+$CTL_Start*$CTL_exp;
					// do something
				}
				
				// $D3*(1-ATL_exp)+ATL_start*ATL_exp
				
				$fatigue	= $dailyTss*(1-$ATL_exp)+$ATL_Start*$ATL_exp;
				$fitness	= $dailyTss*(1-$CTL_exp)+$CTL_Start*$CTL_exp;				
				$tsb		= $fitness-$fatigue;
				
				$arrDate[]		= $date;
				$arrFatigue[]	= (int)$fatigue;
				$arrFitness[]	= (int)$fitness;
				$arrTsb[]		= (int)$tsb;
			}
			
			$data = array('categories'=>$arrDate, 'fatigue'=>$arrFatigue, 'fitness'=>$arrFitness, 'tsb'=>$arrTsb);
			$json = json_encode($data);
			echo $json;
			
			// print_r($TotalTss);
		}
	}
	
	function getTssHour($detail_intensity){
		if($detail_intensity == 1){
			$TssHour	= 20;
		}else if($detail_intensity == 2){
			$TssHour	= 30;
		}else if($detail_intensity == 3){
			$TssHour	= 40;
		}else if($detail_intensity == 4){
			$TssHour	= 50;
		}else if($detail_intensity == 5){
			$TssHour	= 60;
		}else if($detail_intensity == 6){
			$TssHour	= 70;
		}else if($detail_intensity == 7){
			$TssHour	= 80;
		}else if($detail_intensity == 8){
			$TssHour	= 100;
		}else if($detail_intensity == 8){
			$TssHour	= 120;
		}else if($detail_intensity == 10){
			$TssHour	= 140;
		}else{
			$TssHour 	= 0;
		}
		
		return $TssHour;
	}
}
