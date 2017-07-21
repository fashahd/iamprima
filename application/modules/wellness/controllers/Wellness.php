<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wellness extends MY_controller {

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
		$this->load->model('ModelWellness');
		$this->load->model('ModelSelect');
		$this->load->module('selection');
		if(!$this->session->userdata("sessUsername")){
			redirect("login/form");
			return;
		}
	}
	
	public function dataWellness()
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
		$data["module"] 	= "Wellness";
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
			$this->showWellness($username,$month,$year);
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
			$this->showWellness($atletID,$month,$year);
		}
	}
	
	function createWellness(){		
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
		$data["module"] 	= "Wellness";
		$nilai				= $this->ModelWellness->getNilai();
		$lama_tidur 	= ""; 
		$soreness 		= ""; 
		$energi 		= ""; 
		$kualitas_tidur = ""; 
		$mood 			= ""; 
		$stress			= ""; 
		$mental			= ""; 
		$jml_nutrisi	= ""; 
		$kwt_nutrisi	= ""; 
		$hydration		= ""; 
		if($nilai){
			foreach ($nilai as $id=>$key) {
				$nilai = $key->nilai;
				$img = $key->ket_image;
				
				if($nilai == 1){
					$ketLamaTidur		= "< 4 Jam";
					$ketKwtTidur		= "Buruk";
					$ketStress			= "Sangat Stress";
					$ketFocus			= "Sangat Tidak Fokus";
					$ketSoreness		= "Sangat Soreness";
					$ketNutrisi			= "Selalu Lapar";
					$ketFatigue			= "Kelelahan";
					$ketKwtNutrisi		= "Sangat Buruk";
					$ketMood			= "Sangat Tidak Mood";
					$ketHidrasi			= "Sangat Buruk";
				}
				if($nilai == 2){
					$ketLamaTidur		= "5 Jam";
					$ketKwtTidur		= "Kurang Sekali";
					$ketStress			= "Stress";
					$ketFocus			= "Tidak Fokus";
					$ketSoreness		= "Soreness";
					$ketNutrisi			= "Tidak Puas";
					$ketFatigue			= "Tidak Berenergi";
					$ketKwtNutrisi		= "Tidak Baik";
					$ketMood			= "Tidak Mood";
					$ketHidrasi			= "Tidak Baik";
				}
				if($nilai == 3){
					$ketLamaTidur		= "6 Jam";
					$ketKwtTidur		= "Kurang";
					$ketStress			= "Sedikit Stress";
					$ketFocus			= "Sedikit Fokus";
					$ketSoreness		= "Ada Soreness";
					$ketNutrisi			= "Sedikit Puas";
					$ketFatigue			= "Kurang Berenergi";
					$ketKwtNutrisi		= "Kurang Baik";
					$ketMood			= "Kurang Mood";
					$ketHidrasi			= "Kurang Baik";
				}
				if($nilai == 4){
					$ketLamaTidur		= "7 Jam";
					$ketKwtTidur		= "Cukup Baik";
					$ketStress			= "Tidak Stress";
					$ketFocus			= "Fokus";
					$ketSoreness		= "Tidak Ada Soreness";
					$ketNutrisi			= "Puas";
					$ketFatigue			= "Berenergi";
					$ketKwtNutrisi		= "Baik";
					$ketMood			= "Mood Baik";
					$ketHidrasi			= "Baik";
				}
				if($nilai == 5){
					$ketLamaTidur		= "> 8 Jam";
					$ketKwtTidur		= "Sempurna";
					$ketStress			= "Tidak Stress Sama Sekali";
					$ketFocus			= "Sangat Fokus";
					$ketSoreness		= "Tidak Soreness Sama Sekali";
					$ketNutrisi			= "Sangat Memuaskan";
					$ketFatigue			= "Sangat Berenergi";
					$ketKwtNutrisi		= "Sangat Baik";
					$ketMood			= "Mood Sangat Baik";
					$ketHidrasi			= "Sangat Baik";
				}
				
				$lama_tidur .= "
					<p>
						<input name='lama_tidur' type='radio' id='lama_tidur_$id' value='$nilai' required/>
						<label for='lama_tidur_$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketLamaTidur</label>						
					</p>
				";
				$kualitas_tidur .= "
					<p>
						<input name='kualitas_tidur' type='radio' id='kualitas_tidur$id' value='$nilai' required/>
						<label for='kualitas_tidur$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketKwtTidur</label>						
					</p>
				";				
				$soreness .= "
					<p>
						<input name='soreness' type='radio' id='soreness$id' value='$nilai' required/>
						<label for='soreness$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketSoreness</label>						
					</p>
				";
				$energi .= "
					<p>
						<input name='energi' type='radio' id='energi$id' value='$nilai' required/>
						<label for='energi$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketFatigue</label>						
					</p>
				";
				$mood .= "
					<p>
						<input name='mood' type='radio' id='mood$id' value='$nilai' required/>
						<label for='mood$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketMood</label>						
					</p>
				";
				$stress .= "
					<p>
						<input name='stress' type='radio' id='stress$id' value='$nilai' required/>
						<label for='stress$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketStress</label>						
					</p>
				";
				$mental .= "
					<p>
						<input name='mental' type='radio' id='mental$id' value='$nilai' required/>
						<label for='mental$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketFocus</label>						
					</p>
				";
				$jml_nutrisi .= "
					<p>
						<input name='jml_nutrisi' type='radio' id='jml_nutrisi$id' value='$nilai' required/>
						<label for='jml_nutrisi$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketNutrisi</label>						
					</p>
				";
				$kwt_nutrisi .= "
					<p>
						<input name='kwt_nutrisi' type='radio' id='kwt_nutrisi$id' value='$nilai' required/>
						<label for='kwt_nutrisi$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketKwtNutrisi</label>						
					</p>
				";
				$hydration .= "
					<p>
						<input name='hydration' type='radio' id='hydration$id' value='$nilai' required/>
						<label for='hydration$id'><img style='width:35px' src='".base_url()."appsource/icons/$img' /> &nbsp&nbsp $ketHidrasi</label>						
					</p>
				";
			}
		}
		
		$data["lama_tidur"]		= $lama_tidur;
		$data["kualitas_tidur"]	= $kualitas_tidur;
		$data["soreness"]		= $soreness;
		$data["energi"]			= $energi;
		$data["mood"]			= $mood;
		$data["stress"]			= $stress;
		$data["mental"]			= $mental;
		$data["jml_nutrisi"]	= $jml_nutrisi;
		$data["kwt_nutrisi"]	= $kwt_nutrisi;
		$data["hydration"]		= $hydration;
		$data['pages']	= 'createWellness';
		$this->load->view('layout/sidebar',$data);
	}
	
	function showWellness($atletID,$month,$year){	
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
		$data["module"] 	= "Wellness";
		
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
		
		
		$data["wellnessData"]	= $this->wellnessTable($atletID,$month,$year);
		$data["pages"]		= "wellnessData";
		$this->load->view("layout/sidebar",$data);
		
	}
	
	function filterWellness(){
		$month		= $_POST["month"];
		$year		= $_POST["year"];
		$atletID	= $this->session->userdata("sessAtlet");
		
		$this->session->set_userdata("month",$month);
		$this->session->set_userdata("year",$year);
		
		$ret		= $this->wellnessTable($atletID,$month,$year);
		
		echo $ret;
		return;
	}
	
	function grafikWellness(){
		$month		= $_POST["month"];
		$year		= $_POST["year"];
		$atletID	= $this->session->userdata("sessAtlet");
		
		$wellnessData	= $this->ModelWellness->getWellness($atletID,$month,$year);
		if($wellnessData){
			foreach ($wellnessData as $key) {
				$date = date('d M',strtotime($key->created_dttm));

				$nilai = array(
					$lama_tidur = $key->lama_tidur * 2,
					$kualitas_tidur = $key->kualitas_tidur * 2,
					$soreness =  $key->soreness * 2,
					$energi = $key->energi * 2,
					$mood = $key->mood * 2,
					$stress = $key->stress * 2,
					$mental = $key->mental * 2,
					$jml_nutrisi = $key->jml_nutrisi * 2,
					$kualitas_nutrisi = $key->kualitas_nutrisi * 2,
					$hidrasi = $key->hidrasi * 2
				);
				
				$nadi 		= $key->nadi;
				$berat 		= $key->berat;
				$energi		= $key->energi;
				$soreness 	= $key->soreness;
				$hidrasi	= $key->hidrasi;
				$mood	 	= $key->mood;
				$stress	 	= $key->stress;
				$mental	 	= $key->mental;

				$total = array_sum($nilai);
				$sum = array_sum($nilai);
				if($sum <= 59){
					$btn = "#FF0000";
				}elseif($sum >= 60 && $sum <= 69) {
					$btn = "#FF9D00";
				}elseif($sum >= 70 && $sum <= 79){
					$btn = "#E1FF00";
				}elseif($sum >= 80 && $sum <= 89){
					$btn = "#9BFF77";
				}else{
					$btn = "#00CE25";
				}
				
				$arrBtn[] 		= $btn;
				$arrTanggal[] 	= $date;
				$arrScore[] 	= (int)$total;
				$arrNadi[]		= (int)$nadi;
				$arrBerat[]		= (int)$berat;
				$arrEnergi[]	= (int)$energi;
				$arrSoreness[]	= (int)$soreness;
				$arrHidrasi[]	= (int)$hidrasi;
				$arrMood[]		= (int)$mood;
				$arrStress[]	= (int)$stress;
				$arrMental[]	= (int)$mental;

				// if(count($total)) {
					// $total .= ",";
					// $btn .= "',";
				// }
			}
			$arrayData = array(
				'categories'=>$arrTanggal, 
				'nadi'=>$arrNadi, 
				'berat'=>$arrBerat, 
				'fatigue'=>$arrEnergi, 
				'soreness'=>$arrSoreness, 
				'hidrasi'=>$arrHidrasi,
				'wellness'=>$arrScore,
				'mood'=>$arrMood,
				'stress'=>$arrStress,
				'focus'=>$arrMental
			);
			$json = json_encode($arrayData);
			
			echo $json;
		}
	}

	function getWellnessCalendar(){
		$atletID		= $this->session->userdata("sessAtlet");
		$wellnessData	= $this->ModelWellness->getWellnessCalendar($atletID);
		if($wellnessData){
			$dataTable = "";
			$no = 1;
			$events = array();
			foreach ($wellnessData as $key) {
				$master_kondisi_id = $key->master_kondisi_id;
				$date 		= date('d M Y',strtotime($key->created_dttm));
				$lama_tidur = $key->lama_tidur;
				$kualitas_tidur = $key->kualitas_tidur;
				$soreness	=  $key->soreness;
				$energi 	= $key->energi;
				$mood 		= $key->mood;
				$stress 	= $key->stress;
				$mental 	= $key->mental;
				$jml_nutrisi = $key->jml_nutrisi;
				$kualitas_nutrisi = $key->kualitas_nutrisi;
				$hidrasi 	= $key->hidrasi;
				
				$lama_tidur_clr 	= $this->getColor($lama_tidur);
				$kualitas_tidur_clr = $this->getColor($kualitas_tidur);
				$soreness_clr 		= $this->getColor($soreness);
				$energi_clr 		= $this->getColor($energi);
				$mood_clr 			= $this->getColor($mood);
				$stress_clr 		= $this->getColor($stress);
				$mental_clr 		= $this->getColor($mental);
				$jml_nutrisi_clr 	= $this->getColor($jml_nutrisi);
				$kualitas_nutrisi_clr 	= $this->getColor($kualitas_nutrisi);
				$hidrasi_clr 		= $this->getColor($hidrasi);
				
				$nilai = array(
					$lama_tidur = $key->lama_tidur * 2,
					$kualitas_tidur = $key->kualitas_tidur * 2,
					$soreness =  $key->soreness * 2,
					$energi = $key->energi * 2,
					$mood = $key->mood * 2,
					$stress = $key->stress * 2,
					$mental = $key->mental * 2,
					$jml_nutrisi = $key->jml_nutrisi * 2,
					$kualitas_nutrisi = $key->kualitas_nutrisi * 2,
					$hidrasi = $key->hidrasi * 2
				);
				
				$cidera = $key->cidera;
				if($cidera == ""){
					$cidera = "-";
				}
				
				$total = array_sum($nilai);
				
				if($total <= 59){
					$btn = "#FF0000";
				}elseif($total >= 60 && $total <= 69) {
					$btn = "#FF9D00";
				}elseif($total >= 70 && $total <= 79){
					$btn = "#E1FF00";
				}elseif($total >= 80 && $total <= 89){
					$btn = "#9BFF77";
				}else{
					$btn = "#00CE25";
				}
				$e = array();
				$e['id'] = $master_kondisi_id;
				$e['title'] = $total;
				$e['start'] = date("Y-m-d", strtotime($key->created_dttm));
				$e['color'] = $btn;

				// Merge the event array into the return array
				array_push($events, $e);

			}
		}
		echo json_encode($events);
	}

	function getModalWellness(){
		$id = $_POST["id"];
		$data = $this->ModelWellness->getWelnessByID($id);
	}
	
	function wellnessTable($atletID,$month,$year){
		$wellnessData	= $this->ModelWellness->getWellness($atletID,$month,$year);
		$no = 1;
		if($wellnessData){
			$dataTable = "";
			$no = 1;
			foreach ($wellnessData as $key) {
				$date 		= date('d M Y',strtotime($key->created_dttm));
				$lama_tidur = $key->lama_tidur;
				$kualitas_tidur = $key->kualitas_tidur;
				$soreness	=  $key->soreness;
				$energi 	= $key->energi;
				$mood 		= $key->mood;
				$stress 	= $key->stress;
				$mental 	= $key->mental;
				$jml_nutrisi = $key->jml_nutrisi;
				$kualitas_nutrisi = $key->kualitas_nutrisi;
				$hidrasi 	= $key->hidrasi;
				
				$lama_tidur_clr 	= $this->getColor($lama_tidur);
				$kualitas_tidur_clr = $this->getColor($kualitas_tidur);
				$soreness_clr 		= $this->getColor($soreness);
				$energi_clr 		= $this->getColor($energi);
				$mood_clr 			= $this->getColor($mood);
				$stress_clr 		= $this->getColor($stress);
				$mental_clr 		= $this->getColor($mental);
				$jml_nutrisi_clr 	= $this->getColor($jml_nutrisi);
				$kualitas_nutrisi_clr 	= $this->getColor($kualitas_nutrisi);
				$hidrasi_clr 		= $this->getColor($hidrasi);
				
				$nilai = array(
					$lama_tidur = $key->lama_tidur * 2,
					$kualitas_tidur = $key->kualitas_tidur * 2,
					$soreness =  $key->soreness * 2,
					$energi = $key->energi * 2,
					$mood = $key->mood * 2,
					$stress = $key->stress * 2,
					$mental = $key->mental * 2,
					$jml_nutrisi = $key->jml_nutrisi * 2,
					$kualitas_nutrisi = $key->kualitas_nutrisi * 2,
					$hidrasi = $key->hidrasi * 2
				);
				
				$cidera = $key->cidera;
				if($cidera == ""){
					$cidera = "-";
				}
				
				$total = array_sum($nilai);
				
				if($total <= 59){
					$btn = "#FF0000";
				}elseif($total >= 60 && $total <= 69) {
					$btn = "#FF9D00";
				}elseif($total >= 70 && $total <= 79){
					$btn = "#E1FF00";
				}elseif($total >= 80 && $total <= 89){
					$btn = "#9BFF77";
				}else{
					$btn = "#00CE25";
				}
				
				$dataTable .= "
					<tr>
						<td>$no</td>
						<td>$date</td>
						<td style='background : $lama_tidur_clr; text-align:center'>$key->lama_tidur</td>
						<td style='background : $kualitas_nutrisi_clr; text-align:center'>$key->kualitas_tidur</td>
						<td style='background : $soreness_clr; text-align:center'>$key->soreness</td>
						<td style='background : $energi_clr; text-align:center'>$key->energi</td>
						<td style='background : $mood_clr; text-align:center'>$key->mood</td>
						<td style='background : $stress_clr; text-align:center'>$key->stress</td>
						<td style='background : $mental_clr; text-align:center'>$key->mental</td>
						<td style='background : $jml_nutrisi_clr; text-align:center'>$key->jml_nutrisi</td>
						<td style='background : $kualitas_nutrisi_clr; text-align:center'>$key->kualitas_nutrisi</td>
						<td style='background : $hidrasi_clr; text-align:center'>$key->hidrasi</td>
						<td style='text-align:center'>$key->berat</td>
						<td style='text-align:center'>$key->nadi</td>
						<td style='text-align:center'>$cidera</td>
						<td style='background : $btn; text-align:center'>$total</td>
					</tr>
				";
				$no++;
			}
		}else{
			$dataTable = "<tr><td colspan='17'>Tidak Ada Data</td></tr>";
		}
		
		$ret = '
				<div class="card">
					<div class="card-content">
						 <div class="col s12 m12 16">
                 			<table class="responsive-table striped">
								<thead>
									<tr>
										<td data-field="no" class="blue white-text">No</td>
										<td data-field="tanggal" class="blue white-text">Tanggal</td>
										<td data-field="lengthTidur" class="blue white-text">Lama Tidur</td>
										<td data-field="QTidur" class="blue white-text">Kwt Tidur</td>
										<td data-field="soreness" class="blue white-text">Soreness</td>
										<td data-field="fatigue" class="blue white-text">Fatigue</td>
										<td class="blue white-text">Mood</td>
										<td class="blue white-text">Stress</td>
										<td class="blue white-text">Fokus</td>
										<td class="blue white-text">Jml Nutrisi</td>
										<td class="blue white-text">Kwt Nutrisi</td>
										<td class="blue white-text">Hidrasi</td>
										<td class="blue white-text">BB</td>
										<td class="blue white-text">RHR</td>
										<td class="blue white-text">Cidera</td>
										<td class="blue white-text">Total</td>
									</tr>
								</thead>
								<tbody>
									'.$dataTable.'
								</tbody>
							</table>
						</div>
					</div>
				</div>';
		return $ret;
	}
	
	function getColor($data){
		if($data == 1){
			$btn = "#FF0000";
		}elseif($data == 2) {
			$btn = "#FF9D00";
		}elseif($data == 3){
			$btn = "#E1FF00";
		}elseif($data == 4){
			$btn = "#9BFF77";
		}else{
			$btn = "#00CE25";
		}
		
		return $btn;
	}
	
	function saveWellness(){
		$username		= $this->session->userdata("sessUsername");
		$id 			= $this->ModelWellness->getWellnessID();
		$lama_tidur 	= $this->input->post('lama_tidur');
		$kualitas_tidur = $this->input->post('kualitas_tidur');
		$soreness 		= $this->input->post('soreness');
		$energi 		= $this->input->post('energi');
		$mood 			= $this->input->post('mood');
		$stress 		= $this->input->post('stress');
		$mental 		= $this->input->post('mental');
		$nutrisi 		= $this->input->post('jml_nutrisi');
		$kualitas_nutrisi = $this->input->post('kwt_nutrisi');
		$hidrasi 		= $this->input->post('hydration');
		$berat_badan 	= $_POST["berat_badan"];
		$rhr 			= $_POST["rhr"];
		$cidera			= $_POST["cidera"];
		
		$nilai = array(
			$a = $lama_tidur * 2,
			$b = $kualitas_tidur * 2,
			$c =  $soreness * 2,
			$d = $energi * 2,
			$e = $mood * 2,
			$f = $stress * 2,
			$f = $mental * 2,
			$h = $nutrisi * 2,
			$i = $kualitas_nutrisi * 2,
			$j = $hidrasi * 2
		);
		$total = array_sum($nilai);
		
		$data = array(
			'master_kondisi_id' => $id,
			'username' => $username,
			'lama_tidur' => $lama_tidur,
			'kualitas_tidur' => $kualitas_tidur,
			'soreness' => $soreness,
			'energi' => $energi,
			'mood' => $mood,
			'stress' => $stress,
			'mental' => $mental,
			'jml_nutrisi' => $nutrisi,
			'kualitas_nutrisi' => $kualitas_nutrisi,
			'hidrasi' => $hidrasi,
			'created_dttm' => date("Y-m-d H:i:s"),
			'berat' => $berat_badan,
			'nadi' => $rhr,
			'cidera' => $cidera,
		);
				
		$kondisi = $this->ModelWellness->saveWellness($data,$total);
		
		if($kondisi){
			echo "sukses";
			return;
		}else{
			echo "error";
			return;
		}
	}
}
