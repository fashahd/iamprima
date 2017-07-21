<?php
class ModelRecovery extends CI_Model {	
	
	function saveRecovery($point,$atletID){
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);

		$recovery_dttm = date("Y-m-d");
		
		$sql	= "DELETE FROM master_recovery WHERE recovery_dttm = '$recovery_dttm' AND atlet_id = '$atletID'";
		$query 	= $this->db->query($sql);
		for($i = 0; $i < count($point); $i++){
			$recovery_id 	= $this->RecoveryID();
			
			$sql	= " INSERT INTO master_recovery (recovery_id,point_id,atlet_id,recovery_dttm,created_dttm)"
					. " VALUES('$recovery_id','{$point[$i]}','$atletID','$recovery_dttm',now())";
			$query 	= $this->db->query($sql);
		}

		
		$this->db->trans_complete(); # Completing transaction

		/*Optional*/

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			return "error";
		} 
		else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->ModelActivityUser->setActivityUser($atletID,3,11);
			$this->db->trans_commit();
			return "sukses";
		}
	}

	function cekPoint($point_id,$username){
		$now 	= date("Y-m-d");
		$sql 	= " SELECT * FROM master_recovery "
				. " WHERE point_id = '$point_id'"
				. " AND recovery_dttm = '$now'"
				. " AND atlet_id = '$username'";
		$query 	= $this->db->query($sql);
		if($query->num_rows()>0){
			$row 	= $query->row();
			$point_id = $row->point_id;
		}else{
			$point_id = "";
		}
		
		return $point_id;
	}
	
	function getOptRecovery(){
		$sql 	= "SELECT a.*, b.recovery_type, b.recovery_image as image FROM master_recovery_point as a"
			. " LEFT JOIN master_recovery_type as b on b.type_id = a.type_id";
		$query	= $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function getRecoveryDetail($monotonyID){
		$sql = " SELECT a.* FROM `master_monotony_detail` as a "
// 			 . " LEFT JOIN (SELECT * FROM master_pmc WHERE pmcType = 'core' AND pmcCouchType = 'Physic') as b"
// 			 . " on b.monotonyDetailID = a.monotonyDetailID"
			 . " WHERE a.monotonyID = '$monotonyID'";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function getMonotony($atletID,$month,$year){
		$sql 	= " SELECT a.* FROM d_year_weekly as a WHERE a.`year` = '$year'"
				. "AND MONTH(start_date) = '$month'";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function getLoadWeek($weekly,$atletID){
		$sql 	= "SELECT SUM(b.monotonyIntensity*b.monotonyVolume) as monotonyPerWeek FROM `master_monotony` as a
				LEFT JOIN master_monotony_detail as b on b.monotonyID = a.monotonyID
				WHERE a.monotonyWeek = '$weekly' AND a.monotonyAtletID = '$atletID'
				group by b.monotonyID";
		$query 	= $this->db->query($sql);
		if($query->num_rows()>0){
			$row = $query->row();
			$monotonyPerWeek = $row->monotonyPerWeek;
		}else{
			$monotonyPerWeek = "-";
		}
		return $monotonyPerWeek;
	}
	
	function getRecoveryPoint($atletID,$dttm1){
		$sql	= " SELECT SUM(b.recovery_point) as recovery_point FROM `master_recovery` as a"
				. " LEFT JOIN master_recovery_point as b on b.point_id = a.point_id"
				. " WHERE a.atlet_id = '$atletID'"
				. " AND a.recovery_dttm = '$dttm1'";
		$query	= $this->db->query($sql);
		if($query->num_rows()>0){
			$row	= $query->row();
			$recovery_point	= $row->recovery_point;

			if($recovery_point == ""){
				$recovery_point = 0;
			}				
		}else{
			$recovery_point = 0;
		}
		return $recovery_point;
	}
	
	function RecoveryID(){
		$tr = "RECO_";
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$sql = "SELECT left(a.recovery_id,5) as tr, mid(a.recovery_id,6,4) as fyear," 
			 . " mid(a.recovery_id,10,2) as fmonth, mid(a.recovery_id,12,2) as fday,"
			 . " right(a.recovery_id,4) as fno FROM master_recovery AS a"
			 . " where left(a.recovery_id,5) = '$tr' and mid(a.recovery_id,6,4) = '$year'"
			 . " and mid(a.recovery_id,10,2) = '$month' and mid(a.recovery_id,12,2)= '$day'"
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
		
		$RecoveryID = $tr.$fyear.$fmonth.$fday.$strfno;

		return $RecoveryID;
	}
}
?>