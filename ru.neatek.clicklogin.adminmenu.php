<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined("NEATEK_CLICKLOGIN")) { header( 'Location: /' ); die(); }
if(!function_exists('is_admin')) { header( 'Location: /' ); die(); }
function ru_neatek_clicklogin_callback(){
	include(NEATEK_CLICKLOGIN_BUNDLE_NAME.'.adminpage.php');
}
add_action('admin_menu', 'ru_neatek_clicklogin_admin_menu');
function ru_neatek_clicklogin_admin_menu() {
	add_options_page(__( 'ClickLogin', NEATEK_CLICKLOGIN_BUNDLE_NAME ), __( 'ClickLogin', NEATEK_CLICKLOGIN_BUNDLE_NAME ).' - '.__( 'Settings', NEATEK_CLICKLOGIN_BUNDLE_NAME ), 'manage_options', 'ru.neatek.clicklogin', 'ru_neatek_clicklogin_callback');
}