<?php
$cssList = array(
    'bootstrap-select.css',
    'bootstrap.min.css',
    'style.css',
    'easy-responsive-tabs.css',
    'flexslider.css',
    'font-awesome.min.css',
    'jquery-ui1.css',
    'jquery.uls.css',
    'jquery.uls.grid.css',
    'jquery.uls.lcd.css'
);

function page_header($pageTitle=''){
    global $cssList;
    header("Content-Type: text/html; charset=utf-8");
    echo '<!DOCTYPE html>
        <html>
        <head>
        <link rel="icon" href="assets/images/Logo.jpeg" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="The Biggest online Market for selling used things">
        <meta name="author" content="TokunboMall">
        <meta name="keywords" content="Tokunbo Mall">
        <!-- //for-mobile-apps -->
        <!--fonts-->
        <link href="//fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet" type="text/css">
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
        <!--//fonts-->
        
        <title>'.(empty($pageTitle) ? '' : $pageTitle .' - '). 'Tokunbo Mall</title>';
    foreach($cssList as $css){
        echo '<link rel="stylesheet" type="text/css" href="'.url_root.'assets/css/'.$css.'">';
    }
    echo '</head><body>';
    
}

function include_script($script=""){
    echo '<script src='.url_root.'assets/js/'.$script.'></script>';
}

function add_image($img=""){
    echo '<img src="'.url_root.'assets/images/'.$img.'">';
}

?>