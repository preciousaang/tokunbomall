<?php require_once INCLUDES.'database.php';?>
<?php

class Categories extends DatabaseObject{
	protected static $table_name = "categories";
	protected static $db_fields = array("id", "title", "slug");
	public $id;
	public $title;
	public $slug;
	
	public static function find_category_by_slug($slug){
		return static::find_by_slug($slug);
	}
	
}

?>
