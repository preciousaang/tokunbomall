<?php
require_once(INCLUDES."database.php");

class User extends DatabaseObject{
	protected static $table_name = "users";
	public static $db_fields = array('id', 'is_admin', 'username', 'password', 'full_name',  'email', 'phone');
	public $errors = array();
	public $id;
	public $full_name;
	public $is_admin;
	public $username;
	public $password;
	public $confirm_password;
	public $email;
	public $phone;
	
	
	public static function find_by_username($username){
		global $database;
		$username = $database->escape_value($username);
		$sql = "select * from users where username = '{$username}' limit 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_email($email){
		global $database;
		$email = $database->escape_value($email);
		$sql = "select * from users where email = '{$email}' limit 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}	
	
	public static function find_by_phone($phone){
		global $database;
		$phone = $database->escape_value($phone);
		$sql = "select * from users where phone = '{$phone}' limit 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : null;
	}
	
/*	public static function find_by_email($email){
		global $database;
		$email = $database->escape_value($email);
		$sql = "select * from users where email = '{$email}' limit 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}*/
	
	public function validate(){
		
		
		if(!isset($this->id)){
			if($this->find_by_email($this->email)){
				$this->errors[] = "This email has already been registered. Please choose another";
			}		
				
		}
		
		if(isset($this->id)){
			$required_fields = array("full_name",  "email",  "phone");
		}else{
			$required_fields = array("username", "password", "full_name", "email",  "phone");
		}
		
		if(isset($this->id)){
			$fields_with_max_lengths = array("password"=>40);
		}else{
			$fields_with_max_lengths = array("username"=>30, "password"=>40);
		}
		
		foreach($required_fields as $field){
			if(!isset($this->$field) || strlen(trim($this->$field)) == 0){
				$this->errors[] = "The $field field is empty";
				
			}
		}
		
		if(!isset($this->id)){
			if($this->find_by_username($this->username)){
				$this->errors[] = "This username has already been registered. Please choose another";
			}		
			
		}
		
		
		/*
		if(!isset($this->id)){
			if($this->find_by_email($this->email)){
					$this->errors[] = "This Email has already been used. Please choose another";
					return false;
					
			}
		}
		*/
		
		
		foreach($fields_with_max_lengths as $field=>$length){
			if(strlen($this->$field) < 4){
				$this->errors[] = "The $field field is too short";
				
			}
			if(strlen($this->$field) > $length){
				$this->errors[] = "The $field field is too long";
				
			}
		}
		
		if(!is_numeric($this->phone)){
			$this->errors[] = "Please enter a number for the phone number field";
			
		}
		
		if(strlen(trim($this->phone)) != 11){
			$this->errors[] = "Invalid phone number, make sure you enter a valid phone number, i.e Make sure it is 11 digits";
			
		}
		
		if(isset($this->id)){			
			if($this->password != $this->confirm_password){
				$this->errors[] = "Make sure your Confirm Password Field matches your password field.";
							
			}
		}else{
			if($this->password != $this->confirm_password){
				$this->errors[] = "Make sure your Confirm Password Field matches your password field.";
				
			}			
		}

		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->errors[] = "Invalid Email format";
			
		}
		

		

		
		if(!empty($this->errors)){
			return false;
		}else{
			return true;
		}
	}

	public static function authenticate($username, $password){
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		$sql 	 = "select * from users ";
		$sql 	.= "where username = '{$username}' ";
		$sql	.= "and password = sha1('{$password}') ";
		$sql	.= "limit 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public function full_name(){
		if(isset($this->full_name)){
			return $this->full_name;
		}else{
			return "";
		}
	}
	
	public function save(){
		if($this->validate()){
			if(isset($this->id)){
				$this->update();
				return true;
			}else{
				$this->create();
				return true;
			}
		}else{
			return false;
		}
	}
	
	/*
	public function find_user_Lga(){
		return Lga::find_by_id($this->lga);
	}
	
	public function find_user_state(){
		return States::find_by_id($this->state);
	}
	
	public static function find_users_by_lga($lga){
		return self::find_by_sql("select * from users where lga = {$lga}");
	}
	 * 
	 */
	
}


?>