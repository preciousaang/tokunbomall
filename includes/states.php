<?php
require_once(INCLUDES."database.php");

class States extends DatabaseObject{
	public $id;
	public $state;
	protected static $db_fields = array("id", "state");
	protected static $table_name = "states";
	
	public function find_state_lga(){
		return Lga::find_lga_by_state($this->id);
	}
}

?>