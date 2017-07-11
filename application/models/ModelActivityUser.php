<?php
	class ModelActivityUser extends CI_Model {
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->load->library('user_agent');
		}
		
		function setActivityUser($username,$activity_id,$type_id){
			$device_type 	= $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
			$ip_address		= $this->input->ip_address();
			
			$sql = " INSERT INTO d_log (username,activity_id,type_id,device_type,device_name,device_version,ip_address,d_log_date)"
				    ." VALUES ('$username','$activity_id','$type_id','$device_type','','','$ip_address',now())";
			$this->db->query($sql);
						   
			return true;
		}
	}
?>