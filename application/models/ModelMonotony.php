<?php
class ModelMonotony extends CI_Model {
	
	function getMonotonyByID($monotonyID){
		$sql = " SELECT a.*,b.* FROM `master_monotony_detail` as a "
			 . " LEFT JOIN (SELECT * FROM master_pmc WHERE pmcType = 'core' AND pmcCouchType = 'Physic') as b"
			 . " on b.monotonyDetailID = a.monotonyDetailID"
			 . " WHERE a.monotonyID = '$monotonyID'"
			 . " ORDER BY monotonyDetailDate ASC";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
		
	function getMonotonyTarget($monotony_id){
		$sql = " SELECT monotonyTarget, monotonyLastWeek FROM master_monotony"
			  ." WHERE monotonyID = '$monotony_id';";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			$row = $query->row();
			$target = $row->monotonyTarget;
			$last	= $row->monotonyLastWeek;
			
			return array($target,$last);
		}else{
			return false;
		}
	}
	
	function getMonotony($atletID,$month,$year){
		$sql = " SELECT * FROM master_monotony "
				. " WHERE monotonyAtletID = '$atletID' AND MONTH(monotonyStartDttm) = '$month'"
				. " AND YEAR(monotonyStartDttm) = '$year' AND monotonyActive = '0'"
				. " ORDER BY monotonyID DESC";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function cekIsExist($week,$atlet){
		$sql = " SELECT monotonyID FROM master_monotony "
			 . " WHERE monotonyAtletID = '$atlet'"
			 . " AND monotonyWeek='$week'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			$row = $query->row();
			$monotony_id = $row->monotonyID;
			$status = "existed";
		}else{
			$monotony_id = "";
			$status = "empty";
		}
		return array($status,$monotony_id);
	}
		
	function saveMonotony($args,$user_id,$atlet){
		$role_type	= $this->session->userdata("sessRoleType");
		for($k=0; $k<count($atlet); $k++) {
			list($target,$StartDay,$EndDay,$week,$phase,$PostSession,$PostScale,$PostVolume)=$args;
			$cekIsExist = $this->cekIsExist($week,$atlet[$k]);
			list($status,$monotonyID)=$cekIsExist;
			
			$query	= $this->db->query("SELECT MAX(monotonyID) as monotonyID FROM master_monotony WHERE monotonyAtletID = '{$atlet[$k]}'");
			
			if($query->num_rows()>0){
				$row	= $query->row();
				$monotonyID[$k] = $row->monotonyID;
				
				$cek = $this->db->query("SELECT SUM(monotonyIntensity*monotonyVolume) as dailyMonotony FROM master_monotony_detail WHERE monotonyID = '{$monotonyID[$k]}'");
				
				if($cek->num_rows()>0){
					$key	= $cek->result();
					$tmpM	= "";
					foreach($key as $row){
						$dailyMonotony = $row->dailyMonotony;
					}
				}
			}else{
				$dailyMonotony = 0;
			}

			if($status == "existed"){
				$monotony_id = $monotonyID;
				$sql = " UPDATE master_monotony SET created_user_chc = '$user_id', created_dttm_chc = now()"
					 . " WHERE monotonyID = '$monotony_id'";
				$query = $this->db->query($sql);
			}else{
				$monotony_id = $this->uniqekey();
				$sql = " INSERT INTO master_monotony (monotonyID,created_user_id,monotonyTarget,monotonyWeek"
					. " ,monotonyLastWeek,created_dttm,monotonyAtletID,monotonyStartDttm,monotonyEndDttm,monotonyActive)"
					. " values ('$monotony_id','$user_id','$target','$week'"
					. " ,'$dailyMonotony',now(),'{$atlet[$k]}','$StartDay','$EndDay','0')";
				$query = $this->db->query($sql);
			}
			
			$dttm = $StartDay." ".date("H:i:s");
			
			for($i=0; $i<count($PostSession); $i++) {
					
				$w 		= date('w', 		strtotime($StartDay. ' +'.($i).' day'));
				$Date 	= date('Y-m-d', 	strtotime($StartDay. ' +'.($i).' day'));
					
				for($j=0; $j<count($PostSession[$i]); $j++) {
					$detail_id = $this->uniqekey();	
					$sqldetail = " INSERT INTO master_monotony_detail (monotonyDetailID,monotonyID,monotonyDay,"
								." monotonyDetailDate,monotonyDetailSession,monotonyIntensity,monotonyVolume,monotonyLoadPerSession,monotonyType) "
								." values ('$detail_id','$monotony_id','$w','$Date','{$PostSession[$i][$j]}',"
								." '{$PostScale[$i][$j]}','{$PostVolume[$i][$j]}','{$PostScale[$i][$j]}*{$PostVolume[$i][$j]}','$role_type')";
					$qDetail = $this->db->query($sqldetail);
				}
			}
		}
		if($qDetail){
			return true;
		}else{
			return false;
		}
	}
		
	function uniqekey() {
		$micro = microtime();
		$date  = date("YmdHis");
		$micro = explode(" ", $micro);
		$ext   = substr($micro[0], 2, 4);
		return $date.$ext;
	}
	
	function STDEV($sample) {
		if(is_array($sample)){
			$mean = array_sum($sample) / count($sample);
			foreach($sample as $key => $num) $devs[$key] = pow($num - $mean, 2);
			$stdev	= sqrt(array_sum($devs) / (count($devs) - 1));
			return $stdev;
		}else{
			return NULL;
		}//END IF
	}

	function AVERAGE($sample) {
		if(is_array($sample)){
			return array_sum($sample) / count($sample);
		}else{
			return NULL;
		}//END IF
	}

	function SUM($sample) {
		if(is_array($sample)){
			return array_sum($sample);
		}else{
			return NULL;
		}//END IF
	}

	function ABS($number) {
		return abs($number);
	}
		
	function getGrafikDay($monotony_id){
		$sql = " SELECT a.monotonyDetailDate as detail_date, SUM(a.monotonyIntensity * a.monotonyVolume) as trainingLoad,"
			 . " SUM(a.monotonyIntensity) as detail_intensity, SUM(b.rpeActual) as detail_actual"
			 . " FROM `master_monotony_detail` as a"
			 . " LEFT JOIN (SELECT * FROM master_pmc WHERE pmcType = 'core' AND pmcCouchType = 'Physic') as b"
			 . " on b.monotonyDetailID = a.monotonyDetailID"
			 . " WHERE a.monotonyID = '$monotony_id'"
			 . " GROUP BY a.monotonyDetailDate";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
}
?>