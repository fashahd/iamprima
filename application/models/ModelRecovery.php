<?php
class ModelRecovery extends CI_Model {	
		
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
}
?>