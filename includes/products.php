<?php
require_once(INCLUDES."database.php");

class Products extends DatabaseObject{
    public $id;
    public $title;
	public $price;
	public $slug;
    public $summary;
    public $user_id;
    public $category_id;
    public $views;
    public $upload_time;
    public $approved;
    public $product_image;
	public $region;
    public $image_arr = array();
    private $temp_path = array();
	public $thumb_dir = "thumbnails";
    public $upload_dir = "uploads";
    protected static $db_fields = array("id", "title", "price", "slug", "summary", "user_id", "category_id", "views", "upload_time", "approved", "product_image", "region");
    public $valid_type = array("image/jpeg", "image/jpg", "image/gif", "image/png", "image/tiff", "image/tif", "image/bmp");
    protected static $table_name = "products";
    public $errors = array();
    protected $upload_errors = array(
    UPLOAD_ERR_OK			=>	"No errors.",
    UPLOAD_ERR_INI_SIZE		=>	"Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE	=>	"Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL		=>	"Partial Upload.",
    UPLOAD_ERR_NO_FILE		=>	"No file.",
    UPLOAD_ERR_NO_TMP_DIR	=>	"No temporary directory.",
    UPLOAD_ERR_CANT_WRITE	=>	"Can't write to disk.",
    UPLOAD_ERR_EXTENSION	=>	"File upload stopped by extension."
    );
     
    function __construct(){
    	global $session;
        $this->upload_time = strftime("%Y-%m-%d %H:%M:%S", time());
		if(isset($session->user_id)){
			$this->user_id = $session->user_id;
			$user = User::find_by_id($session->user_id);
			if($user->is_admin == TRUE){
				$this->approved = TRUE;
			}
		}
    }
	
	public static function find_search_products_by_pagination($keyword, $per_page, $offset){
    	return self::find_by_sql("select * from products where title like '%{$keyword}%' order by upload_time desc limit {$per_page} offset {$offset}");
	}
	
	public static function count_search_products($keyword){
		global $database;
		$sql = "select count(*) from products where title like '%{$keyword}%' and approved=1";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
    
	public function attach_file($file){
        global $database;
        $file_arr = reArray($file);
        $i = 1;
        foreach($file_arr as $f){    
            if(!$f || empty($f) || !is_array($f)){
                $this->errors[] = "No file was uploaded.";
                //$session->message(join("<br>", $this->errors));
                return false;
            }elseif($f['error'] != 0 && key($file_arr) <= 2){
                $this->errors[] = $this->upload_errors[$f['error']] ." in file ". $i++;
                //$session->message(join("<br>", $this->errors));
                return false;
            }else{
                $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
                $img_name = "img_".rand().time().rand().".{$ext}";
                $this->image_arr[] = $img_name;
                $this->temp_path[] = $f['tmp_name'];                
            }
			next($file_arr);
        }
    }
	
	public static function find_all_aprroved(){
		return self::find_by_sql("select * from products where approved=1");
	}
	
	public static function find_all_unapproved(){
		return self::find_by_sql("select * from products where approved = 0");
	}
	
	public static function find_all_trends(){
		return self::find_by_sql("select * from products where approved=1 order by views desc limit 8");
	}
	
	public function delete_product(){
		$img_array = json_decode($this->product_image);
		foreach($img_array as $img){
			$img_dir = doc_root."{$this->upload_dir}/{$img}";
			if(file_exists($img_dir)){
				unlink($img_dir);
			}
		}
		$this->delete();
		return true;
	}
    
    public function save(){
    	if(isset($this->id)){
    		$this->update();
			return true;
    	}else{
	        if(!empty($this->errors)){return false;}
	        
	        $fields_with_length = array('title', 'summary');
	        foreach($fields_with_length as $field){
	           if(strlen(trim($this->$field)) == 0){
	                $this->errors[] = "The {$field} field is empty";
	                return false;
	            }  
	        }
	       
	        if(empty($this->category_id)){
	            $this->errors[] = "Select a category";
	            return false;
	        }
			
			if(empty($this->region)){
				$this->errors[] = "Select a region";
				return false;
			}
			
			if(empty($this->price)){
				$this->errors[] = "Enter a price";
				return false;
			}
			
			if(!is_numeric($this->price)){
				$this->errors[] = "Price must be a number";
				return false;
			}
	        
	        $target_path = doc_root.$this->upload_dir."/";
			$thumb_dir = doc_root.$this->thumb_dir."/";
	        $this->product_image = json_encode($this->image_arr);
	        if($this->create()){
	            for($i=0; $i<=count($this->image_arr)-1; $i++){
	            	$img = new image_sizer();
	                move_uploaded_file($this->temp_path[$i], $target_path.$this->image_arr[$i]);
					/*
					$img->setImage($target_path.$this->image_arr[$i]);
					$img->setSize(300, 400);
					$img->saveTo($thumb_dir.$this->image_arr[$i], 90);
					*/
	            }
	            unset($this->temp_path);
	            unset($this->image_arr);
	            return true;
	        }else{
	            $this->errors[] = "There was an error in the form";
	            return false;
	        }     		
    	}
    }

	public function find_product_region(){
		return Lga::find_by_id($this->region)->local_govt;
	}
	
	public function find_product_category(){
		$category = Categories::find_by_id($this->category_id);
		return $category->title;
	}
	
	public function find_product_state(){
		$lga = Lga::find_by_id($this->region);
		$state = Lga::state_by_lga($lga->state_id);
		return $state->state;
	}
	
	public function product_owner(){
		return User::find_by_id($this->user_id);
	}
	
	public static function find_product_by_user_paginate($user_id, $status, $per_page, $offset){
		return self::find_by_sql("select * from products where user_id = {$user_id} and approved = {$status} order by upload_time desc limit {$per_page} offset {$offset}");
	}
	
	
	public static function count_product_by_user($user_id, $status){
		global $database;
		$sql  = "select count(*) from products where user_id = '{$user_id}' and approved={$status}";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public static function find_products_by_category($category_id){
		return self::find_by_sql("select * from products where category_id = {$category_id} order by upload_time desc");
	}
	
	public static function find_trending_products($offset=1){
		return self::find_by_sql("select * from products where approved=1 order by views desc limit 4 offset {$offset}");
	}
	
	public static function find_product_by_status_paginate($status, $limit, $offset){
		return self::find_by_sql("select * from products where approved = $status order by upload_time desc limit $limit offset $offset");
	}
	
	public static function  find_product_by_id_with_slug($id, $slug){
		global $database;
		$id = (int)$id;
		$slug = $database->escape_value($slug);
		$sql = "select * from products where id = {$id} and slug = '{$slug}' limit 1";
		$result_array =  self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_products_by_region($array){
		$attrib_pair = array();
		$sql = "select * from products where approved=1 and ";
		if(is_array($array)){
			foreach($array as $key=>$value){
				if($key=="region"){
					$attrib_pair[] = "{$key} = {$value}  and";
				}
				elseif($key=="category_id"){
					$attrib_pair[] = "{$key}='{$value}'";
				}elseif($key=="upload_time"){
					$attrib_pair[] = " order by {$key} {$value}";
				}else{
					$attrib_pair[] = "{$key} {$value}";
				}
				
			}
			$sql  .= join(" ", $attrib_pair);
		}
		
		return self::find_by_sql($sql);
	}
	
	public static function find_all_products_by_region_in_order($str, $limit=4, $offset=0){	
		$str = http_build_query($str, '', ' and ');
		$sql = "select * from products where approved=1 ";
		if(!empty($str)){
			$sql.="  and {$str} ";
		}
		$sql .= " order by upload_time desc ";
		$sql .= "limit {$limit} ";
		$sql .= " offset {$offset} ";
		 
		return self::find_by_sql($sql);
	}
	
	public static function count_all_products_by_query($state=null){
		global $database;
		$attrib_pair = array();
		$sql = "select count(*) from products " ;
		if(isset($state) && is_array($state)){
			if(isset($state['state'])){
			foreach($state as $key=>$value){
				$attrib_pair[] = "{$key} = '{$value}'";
			}
				$sql .= " where approved=1 and "; 
				$sql .= join(" ", $attrib_pair);
			}
		}
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public static function count_products_by_query($array){
		global $database;
		$attrib_pair = array();
		$sql = "select count(*) from products where ";
		if(is_array($array)){
			foreach($array as $key=>$value){
				if($key=="region"){
					$attrib_pair[] = "{$key} = '{$value}' and ";
				}
				elseif($key=="category_id"){
					$attrib_pair[] = "{$key}='{$value}'";	
				}else{
					$attrib_pair[] = "{$key} = '{$value}'";
				}
			$sql  .= join(" ", $attrib_pair);
		}
		
			$result_set = $database->query($sql);
			$row = $database->fetch_array($result_set);
			return array_shift($row);
		}
	}
	
}

?>