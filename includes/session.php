<?php
require_once doc_root."includes/initialize.php";
require_once doc_root."includes/database_object.php";
class Session{
	
	private $logged_in = false;
	private $admin = false;
	public $user_id;
	public $message;
	public $prev_page;
	
	function __construct(){
		session_start();
		$this->check_message();
		$this->check_page();
		$this->check_login();
		if($this->logged_in){
			
		}else{
		}
	}
	
	private function check_message(){
		if(isset($_SESSION['message'])){
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}else{
			$this->message = "";
		}
	}
	
	private function check_page(){
		if(isset($_SESSION['prev_page'])){
			$this->prev_page = $_SESSION['prev_page'];
			//unset($_SESSION['prev_page']);
		}else{
			$this->prev_page = 1;
		}
	}
	
	public function p_page($page=""){
		if(!empty($page)){
			$_SESSION['prev_page'] = $page;
		}else{
			return $this->prev_page;
		}
	}
	
	public function message($msg=""){
		if(!empty($msg)){
			$_SESSION['message'] = $msg;
		}else{
			return $this->message;
		}
	}
	
	private function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->user_id = $_SESSION['user_id'];
			$this->logged_in = true;
			if(User::find_by_id($this->user_id)->is_admin==1){
				$this->admin = true;
			}else{$this->admin=false;}
		}else{
			unset($this->user_id);
			$this->logged_in = false;
		}
	}

	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function is_admin(){
		return $this->admin;
	}
	
	public function login($user){
		if($user){
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->logged_in = true;
			if($user->is_admin==true){
				$this->admin = true;
			}else{
				$this->admin = false;
			}
		}
	}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->admin = false;
		$this->logged_in = false;
	}
}

$session = new Session();
$message = $session->message();
$prev_page = $session->p_page();
?>