=== Neatek - ClickLogin Social Network Authorization ===
Contributors: neatek
Donate link: https://paypal.me/neatek
Tags: wordpress, plugin, network, networks, social, facebook, google, vkontakte, odnoklassniki, vk, authorization, auth, authorizate, light, simple
Requires at least: 1.0.0
Tested up to: 4.9.8
Stable tag: 4.9.8
Version: 1.0.0
License: GPLv2 or later
Requires PHP: 5.6 or high
License URI: https://www.gnu.org/licenses/gpl-3.0.html

This plugin make authorization 

== Installation ==

Just install and press activate, follow to `Settings` page.

== Privacy ==

We are using 3rd party service called "Click Login" - https://clicklogin.ru/ - (auth), anyone can use that for creating Authorization via PHP.

https://clicklogin.ru/privacy.html

== You can close wp/admin via htaccess ==

If you want enable only social auth in /wp-admin/ area, use that rule

<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{QUERY_STRING} (^|.*&)redirect_to=https%3A%2F%2Fneatek.ru%2Fwp-admin%2F(&.*|$) # Here address of your wp-admin area link
RewriteRule ^wp-login\.php$ /ru.neatek.clicklogin.auth.php?service=vk_auth [L,R=301] # Here any specific service
</IfModule>

== Changelog ==

= 1.0.0 =
First release.