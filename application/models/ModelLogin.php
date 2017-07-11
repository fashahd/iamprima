<?php
	class ModelLogin extends CI_Model {
		function createUser($data){
			$this->db->trans_start();
			$this->db->trans_strict(FALSE);

			list($name,$username,$licence_code,$device_id,$device_name,$password,$provinsi,$birth,$gender,$email) = $data;
			
			$sql 	= "SELECT username from users WHERE username = '$username'";
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				return "user_exist";
			}
			
			$sql = "SELECT license_code from users WHERE license_code = '$licence_code'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return "licence_exist";
			}
			
			$sql = "SELECT master_licence_code from master_licence WHERE master_licence_code = '$licence_code' and master_licence_is_activate = '2'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return "licence_suspen";
			}
			
			$result = "SELECT master_licence_code from master_licence WHERE master_licence_code = '$licence_code'";
			$no_of_rows = $this->db->query($result);
			if ($no_of_rows->num_rows() == 0) {
				return "licence_not";
			}
			
			$password_md5 = md5($password);
			$uuid = uniqid('', true);
			$hash = $this->hashSSHA($password);
			$encrypted_password = $hash["encrypted"]; // encrypted password
			$salt = $hash["salt"]; // salt
			$birthDttm = date("Y-m-d", strtotime($birth));
			
			$sql = "SELECT master_licence_type, master_licence_user_groupcode, master_licence_group FROM master_licence WHERE master_licence_code = '$licence_code'";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				$key	= $query->row();
				$master_licence_type = $key->master_licence_type;
				$master_licence_user_groupcode = $key->master_licence_user_groupcode;
				$groupcode = $key->master_licence_group;
				
			}				
				
			if($master_licence_user_groupcode == 'ALL'){
				$sql_alias = "INSERT INTO user_access_alias(username,role_id,role_type) VALUES ('$username','RL_ALL_ACCESS','ALL')";
				$this->db->query($sql_alias);
			}
				
			if($master_licence_user_groupcode == 'HPD'){
				$sql_alias = "INSERT INTO user_access_alias(username,role_id,role_type) VALUES ('$username','$master_licence_type','HPD')";
				$sql_group_sc = "INSERT INTO master_group_sc(username,groupcode) VALUES ('$username','$groupcode')";
				$this->db->query($sql_alias);
				$this->db->query($sql_group_sc);
			}
			
			$sql_update = "UPDATE master_licence SET master_licence_is_activate = '1' WHERE master_licence_code = '$licence_code'";
			
			$insert_user_data = "INSERT INTO users(unique_id, name, username, encrypted_password, salt, created_at,updated_at,license_code,"
				 . " registered_device_id,registered_device_name,gambar,login_device_id,login_device_name, role_id, role_type) VALUES "
				 . " ('$uuid', '$name', '$username', '$encrypted_password', '$salt', NOW(),NOW(),'$licence_code','$device_id',"
				 . " '$device_id','http://portal.iamprima.com/assets/pictures/9731481551200.jpg',"
				 . "'$device_id','$device_id','$master_licence_type','$master_licence_user_groupcode')";
			
			$insert_personal_data = "INSERT INTO master_information_personal (master_atlet_username,master_atlet_email, master_atlet_tanggal_lahir, master_atlet_jenis_kelamin, provinsi_id) 
							VALUES ('$username', '$email', '$birthDttm', '$gender', '$provinsi')";

			$this->db->query($sql_update);
			$this->db->query($insert_user_data);
			$this->db->query($insert_personal_data);

			$this->db->trans_complete(); # Completing transaction

			/*Optional*/

			if ($this->db->trans_status() === FALSE) {
				# Something went wrong.
				$this->db->trans_rollback();
				return "regist_failed";
			} 
			else {
				# Everything is Perfect. 
				# Committing data to the database.
				$this->db->trans_commit();
				return "regist_success";
			}
			
		}

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
		
		function hashSSHA($password) {
			$salt = sha1(rand());
			$salt = substr($salt, 0, 10);
			$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
			$hash = array("salt" => $salt, "encrypted" => $encrypted);
			return $hash;
		}
	}
?>