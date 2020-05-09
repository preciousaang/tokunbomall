<?php

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function timeago($date) {
   $timestamp = strtotime($date);	
   
   $strTime = array("second", "minute", 
          "hour", "day", 
          "week", "month", "year");
   $length = array("60","60","24", "7", "30","12","10");

   $currentTime = time();
   if($currentTime >= $timestamp) {
    $diff     = time()- $timestamp;
    for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
    $diff = $diff / $length[$i];
    }

    $diff = round($diff);
    return ($diff>1) ? $diff . " " . $strTime[$i] . "s ago " : $diff . " " . $strTime[$i] . " ago ";
   }
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function link_page($url){
    echo url_root.$url;
}

function die404(){
    header('HTTP/1.1 404 Not Found');
	die("Page Not Found: <a href=\"".url_root."\">Go Home</a>");
}

function reArray(&$file_post){
    $file_array = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for($i=0; $i<$file_count; $i++){
        foreach($file_keys as $key){
            $file_array[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_array;
}

function output_message($message="") {
  if (!empty($message) || !isset($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name){
	$class_name = strtolower($class_name);
	$path = INCLUDES."{$class_name}.php";
	if(file_exists($path)){
		require_once($path);
	}else{
		die("The file {$class_name}.php could not be found");
	}
}

function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>";
			$output .= htmlentities($error);
			$output .= "</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}

function include_layout_template($template=""){
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function log_action($action, $message=""){
	$logfile = doc_root.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? true : false;
	if($new || !$new){
		if($handle = fopen($logfile, 'a')){
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
			$content = "{$timestamp} | {$action}: {$message}\n";
			fwrite($handle, $content);
			fclose($handle);
		}
	}
	chmod($logfile, 755);
}

?>