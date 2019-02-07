<?php
// Plugin - ru.neatek.clicklogin
// This file accept users for authorization
// After deactivate this file will be deleted in WP root folder
// callback for clicklogin
$wpload = "../../wp-load.php";
if(file_exists($wpload)) { require_once $wpload; }
else {
	// maybe we dont support multi site...
	$wpload = $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
	if(file_exists($wpload)) { require_once $wpload; }
}
neatek_clicklogin_check_auth();