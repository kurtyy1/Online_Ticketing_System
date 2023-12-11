<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			$user = $qry->fetch_assoc();
			if ($user['type'] == 1) {
				foreach ($user as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				return 1; // Super admin
			} elseif ($user['type'] == 2) {
				foreach ($user as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				return 2; // Admin with limited access
			} else {
				return 3; // Non-admin user
			}
		} else {
			return 3; // Non-admin user
		}
	}
	
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			$user = $qry->fetch_assoc();
			if ($user['type'] == 1) {
				foreach ($user as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				return 1; // Super admin
			} elseif ($user['type'] == 2) {
				foreach ($user as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				return 2; // Admin with limited access
			} else {
				return 3; // Non-admin user
			}
		} else {
			return 3; // Non-admin user
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
		header("location.reload");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
		header("location.reload");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
	
		// Check if the user is a super admin
		if (isset($type) && $type == 'super_admin') {
			$data .= ", type = 1 ";
		} elseif (isset($type) && $type == 'admin') {
			// Set the type to 2 for admin
			$data .= ", type = 2 ";
		}
	
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		} else {
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
	
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
			return 1;
				}
	}

	
	function save_airlines(){
		extract($_POST);
		$data = " airlines = '$airlines' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$fname = strtotime(date("Y-m-d H:i"))."_".$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/'.$fname);
			if($move){
				$data .=", logo_path = '$fname' ";
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO airlines_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE airlines_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_airlines(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM airlines_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_airports(){
		extract($_POST);
		$data = " airport = '$airport' ";
		$data .= ", location = '$location' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO airport_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE airport_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_airports(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM airport_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_flight(){
		extract($_POST);
  
		// Validate and sanitize user inputs
		$plane_no = $this->db->real_escape_string($plane_no);
		$departure_airport_id = (int)$departure_airport_id;
		$arrival_airport_id = (int)$arrival_airport_id;
		$departure_datetime = $this->db->real_escape_string($departure_datetime);
		$arrival_datetime = $this->db->real_escape_string($arrival_datetime);
		$return_datetime = $this->db->real_escape_string($return_datetime);
		$seats = (int)$seats;
		$price = (float)$price;
  
		// Initialize $data for both insert and update cases
		$data = "";
		if (isset($airline)) {
			  $data .= "airline_id = $airline, ";
		}
		$data .= "plane_no = '$plane_no', ";
		$data .= "departure_airport_id = $departure_airport_id, ";
		$data .= "arrival_airport_id = $arrival_airport_id, ";
		$data .= "departure_datetime = '$departure_datetime', ";
		$data .= "arrival_datetime = '$arrival_datetime', ";
		$data .= "return_datetime = '$return_datetime', ";
		$data .= "seats = $seats, ";
		$data .= "price = $price";
  
		try {
			 if (empty($id)){
				  $save = $this->db->query("INSERT INTO flight_list SET $data");
			 } else {
				  $save = $this->db->query("UPDATE flight_list SET $data WHERE id = $id");
			 }
		} catch (Exception $e) {
			 // Handle the exception (e.g., log it) and continue the script
			 return "Error: " . $e->getMessage();
		}
  
		return 1;
  }

  function delete_flight(){
	extract($_POST);
	$delete = $this->db->query("DELETE FROM flight_list where id = ".$id);
	if($delete)
		return 1;
}

	function book_flight(){
		extract($_POST);
		foreach ($name as $k => $value) {
			$data = " flight_id = $flight_id ";
			$data .= " , name = '$name[$k]' ";
			$data .= " , address = '$address[$k]' ";
			$data .= " , contact = '$contact[$k]' ";

			$save = $this->db->query("INSERT INTO booked_flight set ".$data);

		}
		if(isset($save)) {
			return $flight_id;
			// $result = $this->db->query("SELECT* FROM booked_flight ORDER BY id DESC LIMIT 1");
			// if ($row = $result->fetch_assoc()) {
			// 	return $row['id'];
			// }
			
		}
	}
	function update_booked(){
		extract($_POST);
			$data = "  name = '$name' ";
			$data .= " , address = '$address' ";
			$data .= " , contact = '$contact' ";
			$data .= " , status  = '$status'  ";

			$save= $this->db->query("UPDATE booked_flight set ".$data." where id =".$id);
		if($save)
			return 1;
	}
}