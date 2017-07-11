<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance extends MY_controller {

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
		$this->load->model('ModelProfiling');
		$this->load->module('selection');
		if(!$this->session->userdata("sessUsername")){
			redirect("login/form");
			return;
		}
	}
	
	public function profiling()
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
		$data["module"] 	= "Performance Profiling";
		$selection 	= new Selection();
		
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
			$this->showProfiling($username);
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
			$this->showProfiling($atletID);
		}
		
		$this->session->unset_userdata("msg");
	}
	
	function profilingData($atletID){
		$role_type		= $this->session->userdata("sessRoleType");
		$kpf			= $this->ModelProfiling->getProfiling($atletID);
		
		$ret ="";
		if($kpf){
			foreach ($kpf as $key) {
				$id_performance = $key->id_performance;
				$no_event = $key->master_atlet_nomor_event;
				$group = $key->master_group_name;
				$jenis = $key->jenis_performance;
				$messo = $key->messo;
				$date = $key->created_dttm;
				$user_id = $key->created_user_id;
				$tmpdate = explode(" ", $date);
				$dttm = $tmpdate[0];
				$catatan = $key->catatan;
				$nama = $key->name;
				$gambar = $key->gambar;
				if($gambar){
					$img = "<img alt='$nama' src='$gambar'>";
				}else{
					$img = "";										
				}
				if($role_type == "KSC" AND $jenis == "Physical" OR $role_type == "CHC" AND $jenis == "Technical" OR $role_type =="PSY" AND $jenis == "Psichology"){
					$btndelete = "<i class='mdi-action-delete small red-text' onclick='deleteProfiling(\"$id_performance\")'></i>";
				}else{
					$btndelete = "";
				}

				$table 	= $this->showTable($id_performance,$jenis,$user_id,$date,$catatan);				
				$ret .= '
					<div class="col m6 l6 s12">
						<div class="card">
						  <div class="card-content">
							<table class="table">
								<thead>
									<tr>
										<th class="cyan white-text">'.$jenis.'</th>
										<th class="cyan white-text">Messo '.$messo.'</th>
										<th class="cyan white-text">
											<span id="btnGrafik_'.$id_performance.'">
												<i class="small mdi-editor-insert-chart" onclick="showGrafik(\''.$id_performance.'\',\''.$jenis.'\',\''.$user_id.'\',\''.$date.'\',\''.$catatan.'\')"></i>
											</span>&nbsp &nbsp
											'.$btndelete.'
										</th>
									</tr>
									<tr></tr>
								</thead>
							</table>
							<div  id="grafik_'.$id_performance.'">
								'.$table.'
							</div>
						  </div>
						</div>
					</div>           
				';
			}
		}else{
			$ret .= "Data Kosong";
		}
		
		return $ret;
	}

	function showTable($id_performance,$jenis,$user_id,$date,$catatan){	
				
		$query	= $this->db->query("SELECT name as user_nm FROM users WHERE username = '$user_id'");
		if($query->num_rows()>0){
			$row		= $query->row();
			$user_nm 	= $row->user_nm;
		}
		$role_type		= $this->session->userdata("sessRoleType");			
		if($role_type == "KSC" AND $jenis == "Physical" OR $role_type == "CHC" AND $jenis == "Technical" OR $role_type =="PSY" AND $jenis == "Psichology"){
			$btnadd = "<a data-backdrop='static' data-toggle='modal' href='".base_url()."index.php/performance/formPerformanceAdd/$jenis/".$id_performance."'><i class='mdi-content-add-box'></i></a>";
		}else{
			$btnadd = "";
		}			
		$sql_phy = " SELECT id_performance_detail as id, id_performance, komponen as komponen,"
				. " benchmark as benchmark, goal as goal, current as current"
				. " From master_performance_detail where id_performance = '$id_performance'";
		$query_phy = $this->db->query($sql_phy);
		$table = "";
		if($query_phy -> num_rows() > 0){
			$result_phy = $query_phy->result();
			if($result_phy > 0){
				foreach ($result_phy as $item) {
					$d_id = $item->id;
					$komponen = $item->komponen;
					// $messo = $item->benchmark;
					$current = $item->goal;
					$benchmark = $item->current;
					
					if ($benchmark <= 0) $benchmark = 1;
					if ($current <= 0) $current = 1;
					// if($role_type == "KSC" AND date("Y-m-d", strtotime($date)) == date("Y-m-d")){
						// $btnedit = "<span href='' onclick='showModal(\"$d_id\",\"$komponen\",\"$messo\",\"$current\",\"$benchmark\")'>$item->komponen</span>";
					// }else{
						$btnedit = "$item->komponen";
					// }
					// $hasil = ($current/$benchmark)*100;
					// $result = number_format($hasil, 2, '.', ' ');
					$table .= "<tr><td><strong>$btnedit</strong></td><td>$item->current</td><td>$item->goal</td></tr>";
				}
			}
		}

		$ret = '
			<table class="table">
				<tbody>
					<tr>
						<td class="btn-danger">Komponen</td>
						<td class="btn-danger">Benchmark</td>
						<td class="btn-danger">Current</td>
					</tr>
					'.$table.'
					<tr><td colspan="4">'.$btnadd.'</td></tr>
					<tr>
						<td colspan="4">Dibuat Pada : '.date('d M Y H:i:s',strtotime($date)).' <br>Dibuat Oleh &nbsp: '.$user_nm.'</td>
					</tr>
					<tr>
						<td colspan="4"><p>Catatan : '.$catatan.'</p></td>
					</tr>
				</tbody>
			</table>
		';

		return $ret;
	}

	

	function showTableAjax($id_performance,$jenis,$user_id,$date,$catatan){	
		if($catatan == 'NULL'){
			$catatan = '';
		}
				
		$query	= $this->db->query("SELECT name as user_nm FROM users WHERE username = '$user_id'");
		if($query->num_rows()>0){
			$row		= $query->row();
			$user_nm 	= $row->user_nm;
		}
		$role_type		= $this->session->userdata("sessRoleType");			
		if($role_type == "KSC" AND $jenis == "Physical" OR $role_type == "CHC" AND $jenis == "Technical" OR $role_type =="PSY" AND $jenis == "Psichology"){
			$btnadd = "<a data-backdrop='static' data-toggle='modal' href='".base_url()."index.php/performance/formPerformanceAdd/$jenis/".$id_performance."'><i class='mdi-content-add-box'></i></a>";
		}else{
			$btnadd = "";
		}			
		$sql_phy = " SELECT id_performance_detail as id, id_performance, komponen as komponen,"
				. " benchmark as benchmark, goal as goal, current as current"
				. " From master_performance_detail where id_performance = '$id_performance'";
		$query_phy = $this->db->query($sql_phy);
		$table = "";
		if($query_phy -> num_rows() > 0){
			$result_phy = $query_phy->result();
			if($result_phy > 0){
				foreach ($result_phy as $item) {
					$d_id = $item->id;
					$komponen = $item->komponen;
					// $messo = $item->benchmark;
					$current = $item->goal;
					$benchmark = $item->current;
					
					if ($benchmark <= 0) $benchmark = 1;
					if ($current <= 0) $current = 1;
					// if($role_type == "KSC" AND date("Y-m-d", strtotime($date)) == date("Y-m-d")){
						// $btnedit = "<span href='' onclick='showModal(\"$d_id\",\"$komponen\",\"$messo\",\"$current\",\"$benchmark\")'>$item->komponen</span>";
					// }else{
						$btnedit = "$item->komponen";
					// }
					// $hasil = ($current/$benchmark)*100;
					// $result = number_format($hasil, 2, '.', ' ');
					$table .= "<tr><td><strong>$btnedit</strong></td><td>$item->current</td><td>$item->goal</td></tr>";
				}
			}
		}

		$ret = '
			<table class="table">
				<tbody>
					<tr>
						<td class="btn-danger">Komponen</td>
						<td class="btn-danger">Benchmark</td>
						<td class="btn-danger">Current</td>
					</tr>
					'.$table.'
					<tr><td colspan="4">'.$btnadd.'</td></tr>
					<tr>
						<td colspan="4">Dibuat Pada : '.date('d M Y H:i:s',strtotime($date)).' <br>Dibuat Oleh &nbsp: '.$user_nm.'</td>
					</tr>
					<tr>
						<td colspan="4"><p>Catatan : '.$catatan.'</p></td>
					</tr>
				</tbody>
			</table>
		';

		echo $ret;
	}
	
	function showProfiling($atletID){
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
		$data["module"] 	= "Performance Profiling";
		
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
		$data['atletWellnessValue'] = $atletWellnessValue;
		$data['atletWellnessDate']  = $atletWellnessDate;
		
		$data["profilingData"]	= $this->profilingData($atletID);
		$data["pages"]			= "profilingData";
		$this->load->view("layout/sidebar",$data);
	}

	function create(){
		$atletID 	= $this->session->userdata("sessAtlet");
		$username	= $this->session->userdata("sessUsername");
		$name		= $this->session->userdata("sessName");
		$gambar		= $this->session->userdata("sessGambar");
		$role_type	= $this->session->userdata("sessRoleType");
		$role_name	= $this->session->userdata("sessRoleName");
		$group_id	= $this->session->userdata("sessGroupID");
	
		if($role_type == "KSC"){
			$type = "Physical";
		}
		if($role_type == "CHC"){
			$type = "Technical";
		}
		if($role_type == "PSY"){
			$type = "Psycology";
		}
		
		$data["gambar"]		= $gambar;
		$data["name"] 		= $name;
		$data["username"] 	= $username;
		$data["role_type"]	= $role_type;
		$data["role_name"] 	= $role_name;
		$data["module"] 	= "Create ".$type." Profiling";

		if($role_type == "CHC"){$groupID = $group_id;}else{$groupID = $this->session->userdata("pickGroupID");}

		if($groupID == ''){			
			$selection 	= new Selection();
			$this->selection->selectGroup($username);
			return;
		}else{
			$listAtlet	= $this->ModelSelect->getAtlet($groupID);
			$labelAtlet	= '<select name="pickAtlet" class="selectpicker text-center" data-style="select-with-transition" title="Pilih Atlet" data-size="7">';
			if($listAtlet){
				foreach($listAtlet as $row){
					$name 		= $row->name;
					$gambar		= $row->gambar;
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

		$data["type"] 	= $type;
		$data['labelAtlet'] = $labelAtlet;
		$data["pages"]			= "createProfiling";
		$this->load->view("layout/sidebar",$data);
	}

	function getGrafik(){
		$performanceID = $this->input->post("performanceID");
		
		$perf = $this->ModelProfiling->getProfilingByID($performanceID);
		
		if($perf){
			list($first,$second)=$perf;
			$result_benchmark 	= "";
			$result_current		= "";
			foreach ($first as $key) {
				$jenis = $key->jenis_performance;
				$atlet = $key->id_user_atlet;
				$catatan = $key->catatan;

				foreach ($second as $item) {
					$komponen 	= $item->komponen;
					$current 		= $item->goal;
					$benchmark 	= $item->current;
					$option			= $item->value;
					if ($benchmark <= 0) $benchmark = 1;
					if ($current <= 0) $current = 1;
					
					if($option == 'ascending'){
						$hasil_current = ($benchmark/$current)*100;
					}else{
						$hasil_current = ($current/$benchmark)*100;
					}
					
					$hasil_benchmark = ($benchmark/$benchmark)*100;
					$result_benchmark = number_format($hasil_benchmark, 2, '.', ' ');
					$result_current = number_format($hasil_current, 2, '.', ' ');
		
					$arrkomponen[] 	= $komponen;
					$arrbenchmark[] = (int)$result_benchmark;
					$arrcurrent[] 	= (int)$result_current;
				}
				
				$data = array('categories'=>$arrkomponen, 'benchmark'=>$arrbenchmark, 'current'=>$arrcurrent);
				$json = json_encode($data);
				echo $json;
			}
		}
	}

	function deleteProfiling(){
		$username	= $this->session->userdata("sessUsername");
		$performanceID = $_POST["performanceID"];
		// $this->ModelActivityUser->setActivityUser($username,5,9);
		
		$sql 	= " UPDATE master_performance SET active = '1', deletedUserID = '$username', deletedDateTime = now()"
				. " WHERE id_performance = '$performanceID'";
		$query 	= $this->db->query($sql);

		if($query){
			echo "sukses";
			return;
		}else{
			echo "error";
			return;
		}
	}

	function saveProfiling(){
		$username	= $this->session->userdata("sessUsername");
		$role_type	= $this->session->userdata("sessRoleType");
	
		if($role_type == "KSC"){
			$jenis = "Physical";
		}
		if($role_type == "CHC"){
			$jenis = "Technical";
		}
		if($role_type == "PSY"){
			$jenis = "Psycology";
		}

		$atletID 	= $_POST["pickAtlet"];
		$messo 		= $_POST["messo"];
		$komponen 	= $_POST["komponen"];
		$benchmark 	= $_POST["benchmark"];
		$current 	= $_POST["current"];
		$catatan 	= $_POST["catatan"];

		$atletInfo	= $this->ModelUsers->getAtletInfo($atletID);
		list($atletName,$atletID,$atletGroup,$atletEvent,$atletPic,$atletWellnessValue,$atletWellnessDate) = $atletInfo;

		$save 	= $this->ModelProfiling->saveProfiling($username,$atletID,$messo,$komponen,$benchmark,$current,$jenis,$catatan);

		$data = array('status'=>$save, 'atletName'=>$atletName);
		$json = json_encode($data);
		echo $json;
		return;
	}
}
