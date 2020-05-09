<?php
require_once(INCLUDES."database.php");

class Lga extends DatabaseObject{
	public $id;
	public $state_id;
	public $local_govt;
	protected static $db_fields = array("id", "state_id", "local_govt");
	protected static $table_name = "local_govts";
	
	
	public static function find_lga_by_state($state_id){
		global $database;
		$id = $database->escape_value($state_id);
		$sql = "select * from local_govts where state_id = {$id}";
		return self::find_by_sql($sql);
	}
	
	public static function state_by_lga($state_id){
		return States::find_by_id($state_id);
	}
	
	public static function file_products_by_lga($lga){
		$lga = self::find_by_id($lga);
		$users = User::find_users_by_lga($lga->id);
	}
}

?>