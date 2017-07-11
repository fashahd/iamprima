<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monotony extends MX_controller {

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
								<a href='#' onClick='goToData(\"$monotonyID\")'>$start - $end</a>
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
	
	function filterMonotony(){
		$atletID	= $this->session->userdata("sessAtlet");
		$month		= $_POST["month"];
		$year		= $_POST["year"];
		
		$this->session->set_userdata("month",$month);
		$this->session->set_userdata("year",$year);
		
		$ret	= $this->monotonyTable($atletID,$month,$year);
		echo $ret;
	}
	
	function stepOne(){
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
		$selection 	= new Selection();
		
		if(!$this->session->userdata("pickGroupID")){			
			$selection 	= new Selection();
			$this->selection->selectGroup($username);
			return;
		}else{
			$checkBoxAtlet	= $selection->checkBoxAtlet($this->session->userdata("pickGroupID"));
			$selectWeek		= $selection->selectWeek();
			
			$data["selectWeek"]		= $selectWeek;
			$data["checkBoxAtlet"]	= $checkBoxAtlet;
			$data["pages"]			= "stepOne";
			$this->load->view("layout/sidebar",$data);
			
			$this->session->unset_userdata("msg");
		}
	}
	
	function stepTwo(){
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
		$weekID			= $this->session->userdata("sessWeek");
		$listWeekByID 	= $this->ModelSelect->listWeekByID($weekID);
		
		list($week,$start_date,$end_date,$year)	= $listWeekByID;
		
		$jmlHari	= $this->ModelSelect->hitungHari($start_date,$end_date);
		$year		= date("Y", strtotime($start_date));
		$month		= date("m", strtotime($start_date));
		$day		= date("d", strtotime($start_date));
		$ret 		= "";
		for($i=0;$i<=$jmlHari;$i++){
			$date 	 = mktime(0,0,0,$month,$day+$i,$year);
			$dayDate = date("d M Y", $date);
			$date 	 = date("Y-m-d", $date);
			
			$ret .=' <div class="form-group label-floating">
							<label class="control-label">'.$dayDate.' / Sesi</label>
							<input onKeypress="cekValue(event)" type="number" class="form-control" name="day'.$i.'" value="2" required>
						</div>';
		}
		
		$data["ret"]	= $ret;
		$data["pages"]	= "stepTwo";
		$this->load->view("layout/sidebar",$data);
	}
	
	function stepThree(){
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
		
		$weekID			= $this->session->userdata("sessWeek");
		$listWeekByID 	= $this->ModelSelect->listWeekByID($weekID);
		
		list($week,$start,$end,$year)	= $listWeekByID;
		
		$data['form'] = array(
			"start"				=> "start",
			"day" 				=> "day[]",
			"session" 			=> "session[%idx%][]",
			"scale" 			=> "scale[%idx%][]",
			"volume" 			=> "volume[%idx%][]",
			"phase" 			=> "phase",
			"goal" 				=> "goal",
			"description"		=> "description",
			"lastweek" 			=> "lastweek",
			"save" 				=> "save"
		);
		
		$daySet = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum`at","Sabtu");
		$data['data'] = array(
			"start" 	=> $start,
		);
		
		$data['data']['rowcount'] 	= 0;
		$data['data']['date'] 		= array();
		$counter = 0;
		$key 	 = "day";
		while(isset($_POST['day'.$counter])) {

			$w 	= date('w', strtotime($start. ' +'.($counter).' day'));
			
			$data['data']['date'][$counter]['COUNT'] 	= $_POST['day'.$counter];
			$data['data']['date'][$counter]['DAY'] 	= $daySet[$w];
			$data['data']['date'][$counter]['DATE'] 	= date('Y-m-d', strtotime($start. ' +'.($counter).' day'));
			$data['data']['rowcount']  				   += $_POST['day'.$counter];
			$counter++;

		}//END WHILE
		
		$data["pages"]	= "stepThree";
		$this->load->view("layout/sidebar",$data);
	}
	
	function setAtletMonotony(){
		$arrAtlet	= $_POST["atletID"];
		$sessWeek	= $_POST["week"];
		
		$this->session->set_userdata("sessArrAtlet",$arrAtlet);
		$this->session->set_userdata("sessWeek",$sessWeek);
		return true;
	}
	
	function deleteMonotony(){
		$monotonyID	= $_POST["monotonyID"];
		
		$query	= $this->db->query("UPDATE master_monotony SET monotonyActive = '1' WHERE monotonyID = '$monotonyID'");
		
		if($query){
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}
	
	function setMonotonyID(){
		$monotonyID	= $_POST["monotonyID"];
		$this->session->set_userdata("monotonyID",$monotonyID);
		return true;
	}
	
	function monotonyDataTable(){
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
		if(!$this->session->userdata("pickGroupID")){				
			$this->selection->selectGroup($username);
			return;
		}
		if(!$this->session->userdata("sessAtlet")){				
			$this->selection->selectAtlet($this->session->userdata("pickGroupID"));
			return;
		}
		
		$atletID	= $this->session->userdata("sessAtlet");
		
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
		$data['monotonyID'] = $monotonyID;
		$data['atletWellnessValue'] = $atletWellnessValue;
		$data['atletWellnessDate']  = $atletWellnessDate;
		$monotonyData	= $this->ModelMonotony->getMonotonyByID($monotonyID);
		$trmnt			= $this->ModelMonotony->getMonotonyTarget($monotonyID);
		if($trmnt){
			list($target,$last)= $trmnt;
		}else{
			$target = '';
			$last 	= '';
		}
			$desc	= '';
		
		$cell = array(
				"value" 		=> array(),
				"wtl" 			=> 0
		);
		if($monotonyData){
			$sample 				= array();
			$TotalScaleVolume 		= 0;
			foreach($monotonyData as $num => $row){
				$mdldate[$num] 		= $row->monotonyDetailDate;
				$sessType[$num] 	= $row->monotonyDetailSession;
				$detIntensity[$num]	= $row->monotonyIntensity;
				$detVolume[$num]	= $row->monotonyVolume;
				$detTrainingLoad[$num] = $detIntensity[$num] * $detVolume[$num];
				if(!isset($cell['value'][$row->monotonyDetailDate])) {
					$cell['value'][$row->monotonyDetailDate]['count'] = 1;
					$cell['value'][$row->monotonyDetailDate]['trainingday']  	= 0 + $detTrainingLoad[$num];
					$sample[$row->monotonyDetailDate] 							= 0 + $detTrainingLoad[$num];
				}else {
					$cell['value'][$row->monotonyDetailDate]['count'] 			+= 1;
					$cell['value'][$row->monotonyDetailDate]['trainingday'] 	+= $detTrainingLoad[$num];
					$sample[$row->monotonyDetailDate] 							+= $detTrainingLoad[$num];
				}
			}
			$STDEV 		= round($this->ModelMonotony->STDEV($sample));
			$TOTAL 		= ceil($this->ModelMonotony->SUM($sample));
			$AVERAGE 	= ceil($this->ModelMonotony->AVERAGE($sample));
			if($AVERAGE==0 OR $STDEV==0) {
				$DIV 	= 0;
			}else {
				$DIV 	= $AVERAGE / $STDEV;
			}//END ELSE IF
			$VARIATION 	= round( $DIV, 1 );
			$LOAD 		= ceil($TOTAL * $VARIATION);

		}
		$data['variation']	= $VARIATION;
		$data['target']		= $target;
		$data['desc']		= $desc;
		$data['load']		= $LOAD;
		$data['total']		= $TOTAL;
		$data['last']		= $last;
		$data['average']	= $AVERAGE;
		$data['stdev']		= $STDEV;
		$data['cell']		= $cell;
		$data['table']		= $monotonyData;
		$data['monotony_id'] = $monotonyID;
		
		$data["pages"]		= "dataTable";
		$this->load->view("layout/sidebar",$data);
	}
	
	function saveMonotony(){
		$username	= $this->session->userdata("sessUsername");
		$target 	= $_POST["goal"];
		$phase		= $_POST["phase"];
		$arrAtlet	= $this->session->userdata("sessArrAtlet");
		$weekID		= $this->session->userdata("sessWeek");
		$listWeekByID 	= $this->ModelSelect->listWeekByID($weekID);
		
		list($week,$start,$end,$year)	= $listWeekByID;
		
		$PostSession = $_POST["session"];
		$PostScale 	 = $_POST["scale"];
		$PostVolume  = $_POST["volume"];
		
		$args = array($target,$start,$end,$week,$phase,$PostSession,$PostScale,$PostVolume);
		
		$save = $this->ModelMonotony->saveMonotony($args,$username,$arrAtlet);
		
		if($save){
			echo "sukses";
			return;
		}else{
			echo "gagal";
			return;
		}
	}
	
	function chartSessionMonotony(){
		$montonyID = $_POST['monotonyID'];
		$table 	= $this->ModelMonotony->getMonotonyByID($montonyID);
		if($table){
			foreach($table as $row){
				$volume = $row->monotonyVolume;
				$date	= $row->monotonyDetailDate;
				$rpe	= $row->monotonyIntensity;
				$actual	= $row->rpeActual;
				
				$load	= $rpe*$volume;
				
				$arrLoad[] 		= (int)$load;
				$arrdate[]		= date("d M Y", strtotime($date));
				$arrRpe[]		= (int)$rpe;
				$arrActual[]	= (int)$actual;
			}
			$arrayData = array('categories'=>$arrdate, 'load'=>$arrLoad, 'rpe'=>$arrRpe, 'actual'=>$arrActual);
			$json = json_encode($arrayData);
			
			echo $json;
			return;
		}
	}
	
	function chartDayMonotony(){
		$montonyID = $_POST['monotonyID'];
		$table 	= $this->ModelMonotony->getGrafikDay($montonyID);
		if($table){
			foreach($table as $row){
				$rpe		= $row->detail_intensity;
				$actual		= $row->detail_actual;
				$date		= $row->detail_date;				
				$load		= $row->trainingLoad;
				
				$arrLoad[] 		= (int)$load;
				$arrdate[]		= date("d M Y", strtotime($date));
				$arrRpe[]		= (int)$rpe;
				$arrActual[]	= (int)$actual;
			}
			$arrayData = array('categories'=>$arrdate, 'load'=>$arrLoad, 'rpe'=>$arrRpe, 'actual'=>$arrActual);
			$json = json_encode($arrayData);
			
			echo $json;
			return;
		}
	}
	
	function monotonyChart(){
		$year	= $_POST["year"];
		$month	= $_POST["month"];
		$atlet	= $this->session->userdata("sessAtlet");
		$monotony = $this->ModelMonotony->getMonotony($atlet,$month,$year);
		
		if($monotony){
			foreach ($monotony as $key) {
				$date 			= $key->created_dttm;
				$monotony_id 	= $key->monotonyID;
				$startMonotony	= $key->monotonyStartDttm;
				$endMonotony	= $key->monotonyEndDttm;
				$vdt = date("Y-m-d",strtotime($date));
				$start			= date("d M Y",strtotime($startMonotony));
				$end			= date("d M Y",strtotime($endMonotony));
				
				$query	= $this->db->query(" SELECT SUM(monotonyVolume*monotonyIntensity) as monotonyPerDay FROM `master_monotony_detail`"
									 . " WHERE monotonyID = '$monotony_id' group by monotonyID");
				if($query->num_rows()>0){
					$row	= $query->row();
					$monotonyPerDay = $row->monotonyPerDay;
				}else{
					$monotonyPerDay	= 0;
				}
				
				$arrDate[]		= $start."-".$end;
				$arrVolume[]	= (int)$monotonyPerDay;
			}
			
			$arrayData = array('categories'=>$arrDate, 'volume'=>$arrVolume);
			$json = json_encode($arrayData);
			
			echo $json;
			return;
		}else{
			return false;
		}
	}
}
