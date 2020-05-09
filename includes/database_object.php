<?php
require_once(INCLUDES."database.php");

class DatabaseObject{
	
	//Common Database Methods
	public static function find_all(){
		return static::find_by_sql("select * from ".static::$table_name);
	}
	
	public static function find_all_by_order($row, $ord){
		return static::find_by_sql("select * from ".static::$table_name." order by {$row} {$ord}");
	}
	
	
	public static function find_by_id($id=0){
		global $database;
		$result_array = static::find_by_sql("select * from ".static::$table_name." where id = ". $database->escape_value($id)." limit 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_slug($slug){
		global $database;
		$slug = $database->escape_value($slug);
		$result_array = static::find_by_sql("select * from ".static::$table_name." where slug = '{$slug}' limit 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql){
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result_set)){
			$object_array[] = static::instantiate($row);
		}
		return $object_array;
	}
	
	public static function find_db_fields(){
		global $database;
		$sql = "show fields from ".static::$table_name;
		$result = $database->query($sql);
		$result_array = array();
		while($row = $database->fetch_array($result)){
			$result_array[] = $row;
		}
		return $result_array;
	}
	
	public static function find_by_pagination($per_page, $offset){
		$sql = "select * from  ".static::$table_name;
		$sql .= " limit {$per_page} ";
		$sql .= " offset {$offset}";
		return static::find_by_sql($sql);
	}
	
	public static function find_by_pagination_in_order($per_page, $offset, $row="upload_time", $ord="desc"){
		$sql = "select * from ".static::$table_name;
		$sql .= " order by {$row} {$ord}";
		$sql .= " limit {$per_page} ";
		$sql .= " offset {$offset} ";
		return static::find_by_sql($sql);
	}
	/*
	public static function find_by_search_pagination($search, $per_page, $offset){
		global $database;
		$search = $database->escape_value($search);
		$sql = "select * from ".static::$table_name;
		$sql .= " where ".static::$table_name." like '{$search}'";
		$sql .= " limit {$per_page} ";
		$sql .= "offset {$offset}";
	}
	 * 
	 */
	
	public static function count_all(){
		global $database;
		$sql = "select count(*) from " . static::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	private static function instantiate($record){
        $class_name = get_called_class();
		$object = new $class_name;
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;	
	}
	
	private function has_attribute($attribute){
		$object_vars = $this->attributes();
		return array_key_exists($attribute, $object_vars);
	}
	
	protected function attributes(){
		$attributes = array();
		foreach(static::$db_fields as $field){
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes(){
		global $database;
		$clean_attributes = array();
		foreach($this->attributes() as $key => $value){
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}
	
	public function save(){
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create(){
		global $database;
		$attributes = $this->sanitized_attributes();
		$sql = "insert into " .static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") values ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}
	
	public function update(){
		global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value){
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "update ".static::$table_name." set ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " where id=".$database->escape_value($this->id);
		if($database->query($sql)){
			return ($database->affected_rows() == 1)?true:false;
		}
	}
	
	public function delete(){
		global $database;
		$sql = "delete from ".static::$table_name;
		$sql .= " where id = ". $database->escape_value($this->id);
		$sql .= " limit 1";
		if($database->query($sql)){
			return ($database->affected_rows() == 1) ? true : false;
		}
	}
}
?>