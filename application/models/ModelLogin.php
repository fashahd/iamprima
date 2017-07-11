<?php
	class ModelLogin extends CI_Model {
		
		function doLoginMobile($username)
		{
			$query = $this->db->query("SELECT a.*,b.* FROM v_users as a"
			 	 . " LEFT JOIN master_role as b on b.role_id = a.role_id"
				 . " WHERE a.username = '$username'");
			
			if($query->num_rows() > 0){
				$row 	= $query->row();
				$salt	= $row->salt;
				$enc_p	= $row->encrypted_password;
				$code	= $row->license_code;
				$result = $query->result();
				$arrResult	= array("success",$result);
			}
			else
			{
				$arrResult	= array("not_registered",false);
			}
			
			return $arrResult;
		}

		function doLogin($username,$password)
		{
			$query = $this->db->query("SELECT a.*,b.* FROM v_users as a"
			 	 . " LEFT JOIN master_role as b on b.role_id = a.role_id"
				 . " WHERE a.username = '$username'");
			
			if($query->num_rows() > 0){
				$row 	= $query->row();
				$salt	= $row->salt;
				$enc_p	= $row->encrypted_password;
				$code	= $row->license_code;
				$hash 	= $this->checkhashSSHA($salt, $password);
				
				if ($enc_p == $hash) {
					$result = $query->result();
					$arrResult	= array("success",$result);
				}else{
					$arrResult	= array("wrong_password",false);
				}
			}
			else
			{
				$arrResult	= array("not_registered",false);
			}
			
			return $arrResult;
		}

		function checkhashSSHA($salt, $password) {

			$hash = base64_encode(sha1($password . $salt, true) . $salt);

			return $hash;
		}
	}
?>