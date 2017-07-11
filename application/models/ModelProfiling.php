<?php
class ModelProfiling extends CI_Model {	
		
	function getProfiling($atlet){
		$sql = " select a.*, b.role_id, c.master_atlet_nomor_event, b.name, b.gambar, e.master_group_name"
			 . " FROM master_performance as a"
			 . " LEFT JOIN users as b on b.username = a.id_user_atlet"
			 . " LEFT JOIN master_information_personal as c on c.master_atlet_username = a.id_user_atlet"
			 . " LEFT JOIN master_role as d on d.role_id = b.role_id"
			 . " LEFT JOIN master_group as e on e.master_group_id = d.group_id"
			 . " where id_user_atlet='$atlet' AND a.active = '0' order by a.id_performance desc";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){

			$result = $query->result();

			return $result;
			
		}else{
			return false;
		}
	}

	function getProfilingByID($id_performance){
		$sql = "select a.* FROM master_performance as a where a.id_performance = '$id_performance'";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			$result = $query->result();
			foreach ($result as $key) {
				$sql_phy = " SELECT id_performance_detail as id, id_performance, komponen as komponen,"
							. " benchmark as benchmark, goal as goal, current as current, value"
							. " From master_performance_detail where id_performance = '$id_performance'";
				$query_phy = $this->db->query($sql_phy);
				if($query_phy -> num_rows() > 0){
					$result_per = $query_phy->result();
				}
			}
			return array($result, $result_per);
		}else{
			return false;
		}
	}

	function saveProfiling($username,$atletID,$messo,$komponen,$benchmark,$current,$jenis,$catatan){
		$performanceID = $this->id_performance();
		$values = array();
		for($i = 0; $i < count($komponen); $i++){
			$values[] = "('$performanceID','{$komponen[$i]}','{$current[$i]}','{$benchmark[$i]}')";
		}
		$values_string = implode(',',$values);

		$sql_add = " insert into master_performance (id_performance,id_user_atlet,jenis_performance,created_user_id,"
				 . " created_dttm,catatan,messo)"
				 . " values ('$performanceID','$atletID','$jenis','$username',now(),'$catatan','$messo')";
		$query_add = $this->db->query($sql_add);
		if($query_add){				
			$sql_phy = "insert into master_performance_detail (id_performance,komponen,goal,current) values $values_string";
			$query_phy = $this->db->query($sql_phy);
			if($query_phy){
				return "sukses";
			}else{
				return "error";
			}
			return "sukses";
		}else{
			return "error";
		}
	}

	function id_performance(){
		$tr = "PERF_";
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$sql = "SELECT left(a.id_performance,5) as tr, mid(a.id_performance,6,4) as fyear," 
				. " mid(a.id_performance,10,2) as fmonth, mid(a.id_performance,12,2) as fday,"
				. " right(a.id_performance,4) as fno FROM master_performance AS a"
				. " where left(a.id_performance,5) = '$tr' and mid(a.id_performance,6,4) = '$year'"
				. " and mid(a.id_performance,10,2) = '$month' and mid(a.id_performance,12,2)= '$day'"
				. " order by fyear desc, CAST(fno AS SIGNED) DESC LIMIT 1";
				
		$result = $this->db->query($sql);	
			
		if($result->num_rows($result) > 0) {
			$row = $result->row();
			$tr = $row->tr;
			$fyear = $row->fyear;
			$fmonth = $row->fmonth;
			$fday = $row->fday;
			$fno = $row->fno;
			$fno++;
		} else {
			$tr = $tr;
			$fyear = $year;
			$fmonth = $month;
			$fday = $day;
			$fno = 0;
			$fno++;
		}
		if (strlen($fno)==1){
			$strfno = "000".$fno;
		} else if (strlen($fno)==2){
			$strfno = "00".$fno;
		} else if (strlen($fno)==3){
			$strfno = "0".$fno;
		} else if (strlen($fno)==4){
			$strfno = $fno;
		}
		
		$id_goal = $tr.$fyear.$fmonth.$fday.$strfno;

		return $id_goal;
	}
}
?>