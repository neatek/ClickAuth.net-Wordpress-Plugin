<?php
/*
	Plugin Name: Click Login (social auth)
	Plugin URI: http://clicklogin.ru/
	Description: Now, you can sign in via social pages in one click, light and simple plugin for that purpose. Supports: Facebook (fb.com), Google (google.com), VKontakte (vk.com), Odnoklassniki (ok.ru)
	Version: 1.0.0
	Author: Neatek (Vladimir Zhelnov)
	Author URI: https://neatek.ru/
	License: GPLv2 or later
	Text Domain: <?=NEATEK_CLICKLOGIN_BUNDLE_NAME?>
*/
if ( ! defined( 'ABSPATH' ) ) exit;
define("NEATEK_CLICKLOGIN", true);
define("NEATEK_CLICKLOGIN_BUNDLE_NAME", "ru.neatek.clicklogin");
define("NEATEK_CLICKLOGIN_URI", plugin_dir_url( __FILE__ ));
define("NEATEK_CLICKLOGIN_HOME_URI", home_url());
define("NEATEK_CLICKLOGIN_ICONS_URI", plugin_dir_url( __FILE__ ).'/icons/');
add_action('plugins_loaded', 'neatek_clicklogin_load_textdomain');
function neatek_clicklogin_load_textdomain() {
	load_plugin_textdomain( NEATEK_CLICKLOGIN_BUNDLE_NAME, false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}
register_deactivation_hook( __FILE__, 'neatek_clicklogin_on_deactivate' );
register_activation_hook( __FILE__, 'neatek_clicklogin_on_activate' );
$modules = array('adminmenu','functions', 'activate', 'adminlogin', 'shortcodes');
foreach ($modules as $module) include(NEATEK_CLICKLOGIN_BUNDLE_NAME.'.'.$module.'.php');