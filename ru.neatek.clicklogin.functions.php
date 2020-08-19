<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined("NEATEK_CLICKLOGIN")) { header( 'Location: /' ); die(); }
function neatek_clicklogin_get_token() {
	if(!function_exists('curl_init')) {
		die('Install `curl` extension for PHP!');
	}
	$post_data = array (
	    "domain" => site_url( '/', 'https' )
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.clicklogin.ru/api/addtoken');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
function neatek_file_get_contents($url) {
	$data = wp_remote_get($url);
	if(!empty($data)) {
		return $data['body'];
	}
	return "{\"success\":false}";
}
function neatek_show_me_pre($str) {
	echo '<pre>';
	print_r($str);
	echo '</pre>';
}
function neatek_clicklogin_set_token($token = '') {
	if(empty($token)) {
		$apianswer = neatek_clicklogin_get_token();
		if(!empty($apianswer)) {
			$json = json_decode($apianswer,true);
			if(isset($json['error'])) {
				if(isset($json['data']['token'])) {
					$token = $json['data']['token'];
				}
			}
			unset($json);
		}
		unset($apianswer);
	}

	if(!empty($token)) {
		update_option( 'click_login_token', $token, true );
	}
	return (bool) true;
}
function neatek_clicklogin_get_domain() {
	$home = home_url();
	$ex = explode('/', $home);
	return (string) str_replace('/','',$ex[2]);
	// return site_url( '/', 'https' );
}
function neatek_clicklogin_token() {
	$token = get_option( 'click_login_token', '' );
	return (string) $token;
}
function neatek_clicklogin_del_token() {
	update_option( 'click_login_token', '', true );
}
function neatek_clicklogin_update_form() {
	include(NEATEK_CLICKLOGIN_BUNDLE_NAME.'.updateform.php');
}
function neatek_clicklogin_update_networks() {
	if(!function_exists('is_admin')) return;
	$data = array();
	$options = neatek_clicklogin_networks();
	foreach ($options as $ko => $kv) {
		$data[$ko] = (bool) false;
	}
	foreach ($_POST as $ko => $kv) {
		if(isset($data[$ko])) {
			$data[$ko] = (bool) true;
		}
	}
	update_option('click_login_networks_data',$data,true);
}
function neatek_clicklogin_set_default() {
	$settings = array();
	$settings['click_login_admin_page'] = true;
	$settings['click_login_shortcodes'] = true;
	$settings['click_login_disable_pwd'] = false;
	$settings['click_login_only_email_login'] = false;
	$settings['click_login_allow_register'] = false;
	update_option('click_login_data',$settings,true);
}
function neatek_clicklogin_data() {
	return get_option( 'click_login_data', '' );
}
function neatek_clicklogin_networks_data() {
	return get_option( 'click_login_networks_data', '' );
}
function neatek_clicklogin_set_networks_default() {
	$settings = array();
	$settings['click_login_google_network'] = true;
	$settings['click_login_facebook_network'] = true;
	$settings['click_login_vkontakte_network'] = true;
	$settings['click_login_ok_network'] = true;
	update_option('click_login_networks_data',$settings,true);
}
function neatek_clicklogin_networks() {
	return array(
		'click_login_google_network' => '<b>'.__( 'Recommended',NEATEK_CLICKLOGIN_BUNDLE_NAME).'</b> '.__( 'Google.com (World-wide network, no target for years or countries)', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_facebook_network' => '<b>'.__( 'Recommended',NEATEK_CLICKLOGIN_BUNDLE_NAME).'</b> '.__( 'Facebook.com (World-wide network, no target for years or countries)', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_vkontakte_network' => __( 'vk.com (CIS countries, young network for teenagers < 30 years old)', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_ok_network' => __( 'ok.ru (CIS countries, network for old people > 30 years old)', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
	);
}
function neatek_clicklogin_options() {
	return array(
		'click_login_admin_page' => __( 'Display social auth on admin page', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_shortcodes' => __( 'Enable shortcodes [fb-auth-link], [vk-auth-link], [google-auth-link], [ok-auth-link]', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_disable_pwd' => __( 'Disable auth in wp-admin via password (anti-bot feature)', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_only_email_login' => __( 'Enable only (Email & Password) sign in', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
		'click_login_allow_register' => __( 'Allow to users register on web-site via social pages (as Subscribers)', NEATEK_CLICKLOGIN_BUNDLE_NAME ),
	);
}
function neatek_clicklogin_network_enabled($option = '') {
	$data = neatek_clicklogin_networks_data();
	if(!empty($data))
		if(isset($data[$option]) && $data[$option] === true) return (bool) true;
	return (bool) false;
}
function neatek_clicklogin_option_enabled($option = '') {
	$data = neatek_clicklogin_data();
	if(!empty($data))
		if(isset($data[$option]) && $data[$option] === true) return (bool) true;
	return (bool) false;
}
function neatek_clicklogin_checkbox_enabled($option = '') {
	if(neatek_clicklogin_option_enabled($option)) return (string) 'checked';
	return (string) '';
}
function neatek_clicklogin_network_checkbox_enabled($option = '') {
	if(neatek_clicklogin_network_enabled($option)) return (string) 'checked';
	return (string) '';
}
function neatek_clicklogin_service_network_enabled($service = '') {
	switch ($service) {
		case 'fb_auth':
			return neatek_clicklogin_fb_enabled();
			break;
		case 'vk_auth':
			return neatek_clicklogin_vk_enabled();
			break;
		case 'ok_auth':
			return neatek_clicklogin_ok_enabled();
			break;
		case 'gp_auth':
			return neatek_clicklogin_google_enabled();
			break;
		default:
			break;
	}

	return false;
}
function neatek_clicklogin_get_authlink($service = '') {
	$redirect = NEATEK_CLICKLOGIN_HOME_URI.'/ru.neatek.clicklogin.callback.php';
	if(!empty(neatek_clicklogin_token()) && !empty(neatek_clicklogin_get_domain())) {
		return (string) 'https://api.clicklogin.ru/?action='.$service.'&token='.neatek_clicklogin_token().'&domain='.neatek_clicklogin_get_domain().'&redirect='.$redirect;
	}
	return (string) '';
}
function neatek_clicklogin_redirect_authlink($service = '') {
	wp_redirect( neatek_clicklogin_get_authlink($service), 302 );
	die();
}
function neatek_clicklogin_check_auth() {
	$params = array(
		'action' => 'service_info',
		'domain' => neatek_clicklogin_get_domain(),
		'token_auth' => $_REQUEST['token_auth']
	);
	$query = "https://api.clicklogin.ru/?" . http_build_query($params, null, '&');
	$json = neatek_file_get_contents($query);
	//@file_get_contents($query);
	if(!empty($json)) {
		$response = (array) json_decode($json,true);
		if(isset($response['success']) && $response['success'] !== false) {
			$user = get_user_by('email',$response['user']['email']);
			if(!empty($user)) {
				wp_set_current_user($user->ID, $user->data->user_login);
				wp_set_auth_cookie($user->ID, true);
				wp_redirect( "/", 302 );
			}
			else {
				if(neatek_clicklogin_option_enabled('click_login_allow_register')) {
					$registered = false;
					$user_login = '';
					$salt = substr(sha1(rand()), -7);
					// try to register vk user ^)
					if(isset($response['user']['screen_name'])) {
						$user_login = 'vk_'.$response['user']['screen_name'];
					}
					if(!empty($user_login) && $registered == false) {
						$user_id = register_new_user( $user_login, $response['user']['email'] );
						if (!is_wp_error($user_id)) { 
							$registered = true; 
							$user_id = wp_update_user( array( 
								'ID' => $user_id,
								'display_name' => $response['user']['first_name'].' '.$response['user']['last_name'], 
								'first_name' => $response['user']['first_name'],
								'last_name' => $response['user']['last_name'],
								'user_nicename' => $response['user']['first_name'].' '.$response['user']['last_name'],
								'user_pass' => md5(rand()),
							));
						}
					}

					// again try to register via email part ^)
					if(isset($response['user']['email'])) {
						$ex = explode('@', $response['user']['email']);
						//neatek[0]@icloud.com[1]
						$ex1 = explode('.', $ex[1]);
						//icloud[0].com[1]
						$user_login = $ex[0].'_'.$ex1[0].'_'.$salt;
					}
					if(!empty($user_login) && $registered == false) {
						$user_id = register_new_user( $user_login, $response['user']['email'] );
						if (!is_wp_error($user_id)) { 
							$registered = true; 
							$user_id = wp_update_user( array( 
								'ID' => $user_id,
								'display_name' => $response['user']['first_name'].' '.$response['user']['last_name'], 
								'first_name' => $response['user']['first_name'],
								'last_name' => $response['user']['last_name'],
								'user_nicename' => $response['user']['first_name'].' '.$response['user']['last_name'],
								'user_pass' => md5(rand()),
							));
						}
					}

					// again try register via user_id login
					$user_login = $response['user']['user_id'].'_'.$salt;
					if(!empty($user_login) && $registered == false) {
						$user_id = register_new_user( $user_login, $response['user']['email'] );
						if (!is_wp_error($user_id)) { 
							$registered = true; 
							$user_id = wp_update_user( array( 
								'ID' => $user_id,
								'display_name' => $response['user']['first_name'].' '.$response['user']['last_name'], 
								'first_name' => $response['user']['first_name'],
								'last_name' => $response['user']['last_name'],
								'user_nicename' => $response['user']['first_name'].' '.$response['user']['last_name'],
								'user_pass' => md5(rand()),
							));
						}
					}
					if($registered == true) { 
						$user = get_user_by('email',$response['user']['email']);
						wp_set_current_user($user->ID, $user->data->user_login);
						wp_set_auth_cookie($user->ID, true);
						wp_redirect( "/", 302 );
					}
				}
			}
		}
	}

	wp_redirect( '/', 302 ); die();
}
function neatek_clicklogin_plugins_to_root($path) {
	return str_replace('/wp-content/plugins/ru.neatek.clicklogin','/',$path);
}
function neatek_clicklogin_delete() {
	// we respect cleanliness
	$path = dirname( __FILE__ ).'/ru.neatek.clicklogin.auth.php';
	if(file_exists(neatek_clicklogin_plugins_to_root($path))) {
		unlink(neatek_clicklogin_plugins_to_root($path));
	}
	$path = dirname( __FILE__ ).'/ru.neatek.clicklogin.callback.php';
	if(file_exists(neatek_clicklogin_plugins_to_root($path))) {
		unlink(neatek_clicklogin_plugins_to_root($path));
	}
}
function neatek_clicklogin_copy() {
	// some users have PHP restriction in plugins folder, try to avoid it
	$path = dirname( __FILE__ ).'/ru.neatek.clicklogin.auth.php';
	copy($path, neatek_clicklogin_plugins_to_root($path));
	$path = dirname( __FILE__ ).'/ru.neatek.clicklogin.callback.php';
	copy($path, neatek_clicklogin_plugins_to_root($path));
}
function neatek_clicklogin_get_fb_link() {
	if(neatek_clicklogin_fb_enabled())
		return NEATEK_CLICKLOGIN_HOME_URI.'/ru.neatek.clicklogin.auth.php?service=fb_auth';
	return "";
}
function neatek_clicklogin_get_gp_link() {
	if(neatek_clicklogin_google_enabled())
		return NEATEK_CLICKLOGIN_HOME_URI.'/ru.neatek.clicklogin.auth.php?service=gp_auth';
	return "";
}
function neatek_clicklogin_get_vk_link() {
	if(neatek_clicklogin_vk_enabled())
		return NEATEK_CLICKLOGIN_HOME_URI.'/ru.neatek.clicklogin.auth.php?service=vk_auth';
	return "";
}
function neatek_clicklogin_get_ok_link() {
	if(neatek_clicklogin_ok_enabled())
		return NEATEK_CLICKLOGIN_HOME_URI.'/ru.neatek.clicklogin.auth.php?service=ok_auth';
	return "";
}
function neatek_clicklogin_fb_enabled() {
	if(neatek_clicklogin_network_enabled('click_login_facebook_network')) return true;
	return false;
}
function neatek_clicklogin_vk_enabled() {
	if(neatek_clicklogin_network_enabled('click_login_vkontakte_network')) return true;
	return false;
}
function neatek_clicklogin_ok_enabled() {
	if(neatek_clicklogin_network_enabled('click_login_ok_network')) return true;
	return false;
}
function neatek_clicklogin_google_enabled() {
	if(neatek_clicklogin_network_enabled('click_login_google_network')) return true;
	return false;
}
function neatek_clicklogin_vk_img() {
	return NEATEK_CLICKLOGIN_ICONS_URI.'vk.jpg';
}
function neatek_clicklogin_fb_img() {
	return NEATEK_CLICKLOGIN_ICONS_URI.'fb.jpg';
}
function neatek_clicklogin_ok_img() {
	return NEATEK_CLICKLOGIN_ICONS_URI.'ok.jpg';
}
function neatek_clicklogin_gp_img() {
	return NEATEK_CLICKLOGIN_ICONS_URI.'gp.jpg';
}
