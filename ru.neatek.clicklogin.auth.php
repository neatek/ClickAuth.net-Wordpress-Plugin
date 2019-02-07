<?php
// Plugin - ru.neatek.clicklogin
// This file is needed for public redirect to social network
// After deactivate this file will be deleted in WP root folder
// let's find wp-load
$wpload = "../../wp-load.php";
if(file_exists($wpload)) { require_once $wpload; }
else {
	// maybe we dont support multi site...
	$wpload = $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
	if(file_exists($wpload)) { require_once $wpload; }
}
// okay, start auth process
$allowedServices = array('','fb_auth','vk_auth','ok_auth','gp_auth');
$service = '';
// filter request param
if(isset($_REQUEST['service'])) {
	$key = array_search(trim($_REQUEST['service']), $allowedServices);
	if(!empty($key)) {
		$service = $allowedServices[$key];
	}
}
if(empty($service)) { header( 'Location: /' ); die(); }
if(neatek_clicklogin_service_network_enabled($service)) {
	neatek_clicklogin_redirect_authlink($service);
}
header( 'Location: /' );
die();