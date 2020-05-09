<?php
require_once(INCLUDES."config.php");

class MySQLDatabase {
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	
  function __construct() {
    $this->open_connection();
  }

	private function open_connection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die("Database connection failed: " . mysqli_error($this->connection));
	}

	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}
	

	public function query($sql) {
		$this->last_query = $sql;
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}
	
	public function escape_value( $value ) {
		return mysqli_real_escape_string($this->connection, $value);
	}
	
	// "database-neutral" methods
  public function fetch_array($result_set) {
    return mysqli_fetch_assoc($result_set);
  }
  
  public function num_rows($result_set) {
   return mysqli_num_rows($result_set);
  }
  
  public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }
  
  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }

	private function confirm_query($result) {
		if (!$result) {
	    $output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
	    $output .= "Last SQL query: " . $this->last_query;
	    die( $output );
		}
	}
	
}

$database = new MySQLDatabase();
$db =& $database;

?>