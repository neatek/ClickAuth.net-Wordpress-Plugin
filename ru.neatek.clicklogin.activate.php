<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined("NEATEK_CLICKLOGIN")) { header( 'Location: /' ); die(); }
if(!function_exists('is_admin')) { header( 'Location: /' ); die(); }
function neatek_clicklogin_on_activate() {
	neatek_clicklogin_set_networks_default();
	neatek_clicklogin_set_default();
	neatek_clicklogin_set_token();
	// create login gateway, if we have PHP restrict in `plugins` folder
	neatek_clicklogin_copy();
}
function neatek_clicklogin_on_deactivate() {
	delete_option('click_login_token');
	delete_option('click_login_networks_data');
	delete_option('click_login_data');
	// create login gateway, if we have PHP restrict in `plugins` folder
	// so we need to delete our files
	neatek_clicklogin_delete();
}