<?php
class ModelWellness extends CI_Model {
		
	function getWellness($atletID,$month,$year){
		$sql = " SELECT * FROM v_master_kondisi WHERE username = '$atletID'"
			 . " AND MONTH(created_dttm) = '$month'"
			 . " AND YEAR(created_dttm) = '$year'"
			 . " order by created_dttm desc";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{			
			$result = $query->result();
			return $result;
		}
		else
		{
			return false;
		}
	}
		
	function saveWellness($data,$total){
		$now	= date("Y-m-d");
		$insert = $this->db->insert('master_kondisi', $data);
		$sql = "UPDATE users SET value_wellness = '$total',wellness_date = '$now' WHERE username = '$data[username]'";
		$query = $this->db->query($sql);
		
		if($insert){
			return true;
		}else{
			return false;
		}
	}
		
	function getNilai(){
		$sql = "Select * From master_kondisi_value";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			
			$result = $query->result();
			
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	function getWellnessID(){
		$tr = "KOND_";
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$sql = "SELECT left(a.master_kondisi_id,5) as tr, mid(a.master_kondisi_id,6,4) as fyear," 
			 . " mid(a.master_kondisi_id,10,2) as fmonth, mid(a.master_kondisi_id,12,2) as fday,"
			 . " right(a.master_kondisi_id,4) as fno FROM master_kondisi AS a"
			 . " where left(a.master_kondisi_id,5) = '$tr' and mid(a.master_kondisi_id,6,4) = '$year'"
			 . " and mid(a.master_kondisi_id,10,2) = '$month' and mid(a.master_kondisi_id,12,2)= '$day'"
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