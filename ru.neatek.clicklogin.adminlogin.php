<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined("NEATEK_CLICKLOGIN")) { header( 'Location: /' ); die(); }
//
if(
	neatek_clicklogin_option_enabled('click_login_admin_page') &&
	!neatek_clicklogin_option_enabled('click_login_only_email_login')
) {
	add_action( 'login_footer', 'neatek_clicklogin_admin_login_box' );
}
function neatek_clicklogin_admin_login_box(){
?>
<style type="text/css">
	.ru-neatek-clicklogin-buttons {
		text-align: center;
		/*opacity: 0.5;*/
		/*transition: 0.5s;*/
		font-size: 16px;
	}
	.ru-neatek-clicklogin-buttons h4 {
		padding: 5px;
		transition: 0.6s;
		opacity: 0.5;
	}
	.ru-neatek-clicklogin-buttons:hover h4 {
		opacity: 1.0;
	}
	.ru-neatek-clicklogin-icons a {
		display: inline-block;
		width: 30px;
		height: 30px;
	}
	.ru-neatek-clicklogin-icons a img {
		opacity: 0.5;
		width: 100%;
		transition: 0.3s;
		height: auto;
		border-radius: 50%;
	}
	.ru-neatek-clicklogin-buttons a img:hover {
		opacity: 1.0;
	}
<?php if(neatek_clicklogin_option_enabled('click_login_disable_pwd')): ?>
	#loginform {
		display: none;
	}
<?php endif; ?>
</style>
<div class="ru-neatek-clicklogin-buttons">
	<h4><?php echo __( 'ClickLogin', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?> - <?php echo __( 'Authorization', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></h4>
	<div class="ru-neatek-clicklogin-icons">
		<?php if(neatek_clicklogin_fb_enabled()): ?>
			<a href="<?php echo neatek_clicklogin_get_fb_link(); ?>"><img src="<?php echo neatek_clicklogin_fb_img(); ?>" alt="Facebook" title="Auth via Facebook"></a> 
		<?php endif; ?>
		<?php if(neatek_clicklogin_google_enabled()): ?>
			<a href="<?php echo neatek_clicklogin_get_gp_link(); ?>"><img src="<?php echo neatek_clicklogin_gp_img(); ?>" alt="Google Plus" title="Auth via Google"></a>
		<?php endif; ?>
		<?php if(neatek_clicklogin_vk_enabled()): ?>
			<a href="<?php echo neatek_clicklogin_get_vk_link(); ?>"><img src="<?php echo neatek_clicklogin_vk_img(); ?>" alt="Vkontakte" title="Auth via Vkontakte"></a>
		<?php endif; ?>
		<?php if(neatek_clicklogin_ok_enabled()): ?>
			<a href="<?php echo neatek_clicklogin_get_ok_link(); ?>"><img src="<?php echo neatek_clicklogin_ok_img(); ?>" alt="Odnoklassniki" title="Auth via Odnoklassniki"></a>
		<?php endif; ?>
	</div>
</div>
<?php
}
// anti-bot, pwd restrict
if(neatek_clicklogin_option_enabled('click_login_disable_pwd')) {
	remove_filter( 'authenticate', 'wp_authenticate_username_password',  20, 3 );
	remove_filter( 'authenticate', 'wp_authenticate_email_password',  20, 3 );

	add_filter( 'wp_login_errors', 'neatek_click_login_change_errors', 10, 2 );
	function neatek_click_login_change_errors( $errors, $redirect_to ){
		if(isset($errors->errors['authentication_failed'])) {
			$errors->errors['authentication_failed'][0] = __( 'You have to authorize via Click Login.<br>Login through the password is restricted.', NEATEK_CLICKLOGIN_BUNDLE_NAME );
		}
		return $errors;
	}
}
if(neatek_clicklogin_option_enabled('click_login_only_email_login')) {
	remove_filter( 'authenticate', 'wp_authenticate_username_password',  20, 3 );
}