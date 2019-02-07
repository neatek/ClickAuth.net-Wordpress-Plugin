<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(neatek_clicklogin_option_enabled('click_login_shortcodes')) {
	function click_login_fb_auth_link( $atts ){
		// facebook
		return neatek_clicklogin_get_fb_link();
	}
	add_shortcode('fb-auth-link', 'click_login_fb_auth_link');
	
	function click_login_vk_auth_link( $atts ){
		// vk	
		return neatek_clicklogin_get_vk_link();
	}
	add_shortcode('vk-auth-link', 'click_login_vk_auth_link');

	function click_login_google_auth_link( $atts ){
		// google
		return neatek_clicklogin_get_gp_link();
	}
	add_shortcode('google-auth-link', 'click_login_google_auth_link');
	
	function click_login_ok_auth_link( $atts ){
		// ok.ru
		return neatek_clicklogin_get_ok_link();
	}
	add_shortcode('ok-auth-link', 'click_login_ok_auth_link');
}