<?php
if($session->is_logged_in()){
	$session->logout();
	redirect_to(url_root);
}
?>