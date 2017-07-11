<?php
class ModelSelect extends CI_Model {
	
	function getCideraCount($username){
		$sql 	= "select b.username,b.name,b.gambar,a.role_name,a.group_id,
		b.master_licence_user_groupcode,b.value_wellness,b.access_all,b.wellness_date,
		b.phone,b.email,b.cover_url,IFNULL(c.total_cidera,0) as total_cidera,
		(select count(*) from temp_master_group where username = '".$username."') as total_group
		from master_role a
join v_role_user b
on a.role_id = b.master_licence_type
left outer join
v_count_cidera c
on b.username = c.username
where b.username =
'".$username."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			$row = $query->row();
			$total_cidera = $row->total_cidera;
		}else{
			$total_cidera = 0;
		}

		return $total_cidera;
	}

	function hitungHari($awal,$akhir){
		$tglAwal = strtotime($awal);
		$tglAkhir = strtotime($akhir);
		$jeda = abs($tglAkhir - $tglAwal);
		return floor($jeda/(60*60*24));
	}
	
	function getWeek(){
		$query	= $this->db->query("SELECT * FROM d_year_weekly");
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return null;
		}
	}
	
	function listWeekByID($weekID){
		$query	= $this->db->query("SELECT * FROM d_year_weekly where uid = '$weekID'");
		if($query->num_rows()>0){
			$row		= $query->row();
			$week 		= $row->weekly;
			$start_date	= $row->start_date;
			$end_date	= $row->end_date;
			$year		= $row->year;
			
			return array($week,$start_date,$end_date,$year);
		}else{
			return null;
		}
	}
	
	function getGroup($username){
		
		$sql = "SELECT *, master_group_id as groupcode FROM v_master_group WHERE username = '$username' ORDER BY master_group_name ASC";
		
		// if($role_type == "SATLAK" OR $role_type == "PRIMA" OR $role_type == "RCV" OR $role_type == "MLP"){
			// $sql = " select *, master_group_id as groupcode from master_group "
				 // . " where master_group_category in ('GW200','GW300','GW400') "
				 // . " ORDER BY master_group_name";
		// }else{
			// $sql = " SELECT a.groupcode, b.master_group_name, b.master_group_logo FROM v_master_group_sc as a"
				 // . " LEFT JOIN master_group as b on b.master_group_id = a.groupcode"
				 // . " WHERE a.username = '$username'";
		// }
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}			
	}
	
	
	function getAtlet($group_id){	
		$sql_atlet = "SELECT *, nomor_event as master_atlet_nomor_event FROM v_member_atlet WHERE master_licence_group = '$group_id' ORDER BY name ASC";
		$query_atlet = $this->db->query($sql_atlet);
		if($query_atlet -> num_rows() > 0){
			$result = $query_atlet->result();
			return $result;
		}else{
			return false;
		}
	}

	function optAtlet($groupID,$atletID){
		$labelAtlet	= '<select id="pickAtlet" class="browser-default js--animations" style="width:220px;text-align:center;text-align-last: center;margin: auto;paddin-bottom: 30px">';
		$listAtlet = $this->getAtlet($groupID);
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

		return $labelAtlet;
	}

	function optGroup($username,$groupID){
		$labelGroup	= '<select id="optGroup" class="browser-default js--animations"';
		$listGroup = $this->getGroup($username);
		if($listGroup){
			foreach($listGroup as $row){
				$groupcode	= $row->groupcode;
				$groupname 	= $row->master_group_name;
				
				if($groupcode == $groupID){$slc = "selected";}else{$slc = "";}
				
				$labelGroup	.= '<option '.$slc.' value="'.$groupcode.'">'.$groupname.'</option>';
			}
		}
		$labelGroup	.= '</select>';

		return $labelGroup;
	}
}
?>