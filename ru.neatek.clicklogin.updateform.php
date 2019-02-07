<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined("NEATEK_CLICKLOGIN")) { header( 'Location: /' ); die(); }
if(!function_exists('is_admin')) { header( 'Location: /' ); die(); }
if(is_admin()) {
	$data = array();
	$options = neatek_clicklogin_options();
	foreach ($options as $ko => $kv) {
		$data[$ko] = (bool) false;
	}
	foreach ($_POST as $ko => $kv) {
		if(isset($data[$ko])) {
			$data[$ko] = (bool) true;
		}
	}

	if($data['click_login_disable_pwd'] === true) {
		$data['click_login_admin_page'] = true;
	}

	if($data['click_login_only_email_login'] === true) {
		$data['click_login_admin_page'] = false;
		$data['click_login_disable_pwd'] = false;
	}

	update_option('click_login_data',$data,true);
}
