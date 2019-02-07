<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined("NEATEK_CLICKLOGIN")) { header( 'Location: /' ); die(); }
if(!function_exists('is_admin')) { header( 'Location: /' ); die(); }
	$token=neatek_clicklogin_token();
	if(isset($_REQUEST) && isset($_REQUEST['gettoken']) && $_REQUEST['gettoken']) neatek_clicklogin_set_token();
	if(isset($_REQUEST) && isset($_REQUEST['deltoken']) && $_REQUEST['deltoken']) neatek_clicklogin_del_token();
	if(isset($_REQUEST) && isset($_REQUEST['click_login_update_form']) && $_REQUEST['click_login_update_form']) neatek_clicklogin_update_form();
	if(isset($_REQUEST) && isset($_REQUEST['click_login_update_networks']) && $_REQUEST['click_login_update_networks']) neatek_clicklogin_update_networks();
	if(isset($_REQUEST) && isset($_REQUEST['click_login_recommend']) && $_REQUEST['click_login_recommend']) neatek_clicklogin_set_default();
	if(isset($_REQUEST) && isset($_REQUEST['click_login_recommend_networks']) && $_REQUEST['click_login_recommend_networks']) neatek_clicklogin_set_networks_default();
?>
<div class="wrap">
	<div id="message" class="updated notice notice-success is-dismissible">
		<p>
			<b><?php echo __( 'Donate', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?> : <a target="_blank" href="https://www.paypal.me/neatek"><?php echo __( 'PayPal', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></a></b> - <?php echo __( 'If you like this lightweight plugin and you want more updates for that or new very powerfull plugins.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>
		</p>
		<p>
			<?php echo __( 'Author', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>: <a target="_blank" href="https://neatek.ru/">Neatek (<?php echo __( 'Vladimir Zhelnov', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>)</a> | <a target="_blank" href="https://clicklogin.ru/"><?php echo __( 'ClickLogin', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?> <?php echo __( 'Service', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></a>
			| <a href="mailto:neatek@icloud.com"><?php echo __( 'Do private order (sys. admining, new web-sites, new plugins etc)', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></a>
		</p>
		<button type="button" class="notice-dismiss"><span class="screen-reader-text">Close.</span></button>
	</div>

	<?php if($_POST): ?>
	<div id="message" class="updated notice notice-success is-dismissible">
		<p>
			<?php echo __( 'Data is saved.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>
		</p>
		<button type="button" class="notice-dismiss"><span class="screen-reader-text">Close.</span></button>
	</div>
	<?php endif; ?>

	<h1 class="wp-heading-inline"><?php echo __( 'Click Login - Plugin doing best authorization', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></h1>
	<div class="media-toolbar wp-filter">
		<p><?php echo __( 'Here is token for using clicklogin API', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
		<p><?php echo __( 'Token', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>: <input type="text" size="80" value="<?=$token?>" disabled></p>
		<p><?php echo __( 'Changed domain?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?> <a href="/wp-admin/options-general.php?page=ru.neatek.clicklogin&gettoken=yes"><?php echo __( 'Update', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></a> <?php echo __( 'service token', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>. 
			<?php echo __( 'Or', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?> <a href="/wp-admin/options-general.php?page=ru.neatek.clicklogin&deltoken=yes"><?php echo __( 'delete', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></a> <?php echo __( 'token', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>.</p>
	</div>
	<div class="media-toolbar wp-filter">
		<h2><?php echo __( 'Settings', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></h2>
		<form action="" method="post">
			<p><?php echo __( 'Here you can disable or enable most of features, what you want', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			<?php 
				$options = neatek_clicklogin_options();
				foreach ($options as $keyoption => $valueoption) {
					echo '<p><input type="checkbox" name="'.$keyoption.'" value="" '.neatek_clicklogin_checkbox_enabled($keyoption).'> '.$valueoption.'</p>';
				}
			?>
			<p><?php echo __( 'Most of options are linked, don\'t worry if you disable some option - sometimes other options will be enabled or disabled, it\'s auto-fix.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			<p>
				<input type="submit" name="click_login_recommend" style="background: #299a00;border-color:#299a00;box-shadow: none;text-shadow: none;" class="button button-primary button-large" value="<?php echo __( 'Set default', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>">
				<input type="submit" name="click_login_update_form" style="background: #299a00;border-color:#299a00;box-shadow: none;text-shadow: none;" class="button button-primary button-large" value="<?php echo __( 'Save', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>">
			</p>
		</form>
	</div>
	<div class="media-toolbar wp-filter">
		<h2><?php echo __( 'Select available social networks to auth', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></h2>
		<form action="" method="post">
		<?php
			$options = neatek_clicklogin_networks();
			foreach ($options as $keyoption => $valueoption) {
				echo '<p><input type="checkbox" name="'.$keyoption.'" value="" '.neatek_clicklogin_network_checkbox_enabled($keyoption).'> '.$valueoption.'</p>';
			}
		?>
		<p>
			<input type="submit" name="click_login_recommend_networks" style="background: #299a00;border-color:#299a00;box-shadow: none;text-shadow: none;" class="button button-primary button-large" value="<?php echo __( 'Set default', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>">
			<input type="submit" name="click_login_update_networks" style="background: #299a00;border-color:#299a00;box-shadow: none;text-shadow: none;" class="button button-primary button-large" value="<?php echo __( 'Save', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>">
		</p>
		</form>
	</div>
	<div class="media-toolbar wp-filter">
		<h2><?php echo __( 'FAQ - Frequently Asked Question', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></h2>
		<ol>
			<li>
				<b><?php echo __( 'What to do if you have not Email in your social page and you can\'t login back into admin area?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'Open folder - /wp-content/plugins/ and rename folder \'ru.neatek.clicklogin\' into \'.ru.neatek.clicklogin\' to disable that plugin, and you can sign in through login&pass again.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
			<li>
				<b><?php echo __( 'How it works?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'It working via Clicklogin.ru service. It will <u>authorizate you in Wordpress via Email</u> that using in your social page.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
			<li>
				<b><?php echo __( 'What does option "Display social auth on admin page"?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'It will display ClickLogin authorization on wp login page. I think <a href="/wp-login.php">here</a>.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
			<li>
				<b><?php echo __( 'What does option "Enable shortcodes [fb-auth-link], [vk-auth-link], [google-auth-link], [ok-auth-link]"?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p>
					<?php echo __( 'You can place any of these shortcodes to add link to authorization via clicklogin. Link as [fb-auth-link] or any other.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?><br>
					<pre><?php echo __( 'Example', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>: <a href="[fb-auth-link]"><?php echo __( 'Login via Facebook', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></a></pre>
					<?php echo __( 'Also you can use them into `themes` in php.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?>
					<?php echo __( 'Like here', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?> : <pre>do_shortcode( "[fb-auth-link]" )</pre>
				</p>
			</li>
			<li>
				<b><?php echo __( 'What does option "Disable auth in wp-admin via password (anti-bot feature)"?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'It\'s a great feature. It will disable any tries to authorizate on web-site through login&pass or email&pass. Only Clicklogin authorization will working.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
			<li>
				<b><?php echo __( 'What does option "Enable only (Email & Password) sign in"?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'It will disable login&pass authorization. I suggest disable all authorizations via passwords.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
			<li>
				<b><?php echo __( 'What does option "Allow to users register on web-site via social pages (as Subscribers)"?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'That plugin will register new users through social pages as subscribers.', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
			<li>
				<b><?php echo __( 'What to do if authorization is not working?', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></b>
				<p><?php echo __( 'Try to add links like a - /wp-content/plugins/ru.neatek.clicklogin/ru.neatek.clicklogin.auth.php?service=fb_auth to whitelist in .htaccess. It\'s a public script for doing authorization through this plugin. Also check token, if it isn\'t empty. if token is empty, try to get it <a target="_blank" href="http://clicklogin.ru/gettoken.html">here</a> (write your domain name like a example.com to input field, and press submit). After all of this your can check php_errors.log file on your hosting, or write to me : neatek@icloud.com', NEATEK_CLICKLOGIN_BUNDLE_NAME ); ?></p>
			</li>
		</ol>
	</div>
</div>