<?php
require_once 'header.php';


$chop = -strlen(basename($_SERVER['SCRIPT_NAME']));
define('doc_root', substr($_SERVER['SCRIPT_FILENAME'], 0, $chop));
define('url_root', substr($_SERVER['SCRIPT_NAME'], 0, $chop));
require_once(doc_root.'includes/initialize.php');

$url = str_replace(array("\\", "../"), array("/", ""), $_SERVER['REQUEST_URI']);
if($offset = strpos($url, '?')){
    $url = substr($url, 0, $offset);
}elseif($offset = strpos($url, '#')){
    $url = substr($url, 0, $offset);
}

if($url!='/'){
    $url = substr($url, strlen(url_root));
}

$url = trim($url, '/');

if(file_exists(doc_root.'/'.$url) && ($_SERVER['SCRIPT_FILENAME'] != doc_root.$url) && ($url != '') && ($url != 'index.php')){
    die404();
}


$action = (
    ($url == '') || ($url=='index.php') || ($url=='index.html')
) ? array('index') : explode('/', html_entity_decode($url));


$includeFile = 'pages/'.preg_replace('/[^\w]/', '', $action[0]).'.php';

is_file($includeFile) ? include($includeFile) : die404();

die();
?>