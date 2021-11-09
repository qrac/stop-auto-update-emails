<?php
/*
Plugin Name: Stop Auto Update Emails
Plugin URI: https://wordpress.org/plugins/stop-auto-update-emails/
Description: Add the function to stop automatic update emails to WordPress.
Version: 0.0.1
Author: Qrac
Author URI: https://qrac.jp
Text Domain: stop-auto-update-emails
Domain Path: /languages
License: GPLv2 or later
*/

add_filter('auto_plugin_update_send_email', '__return_false');
add_filter('auto_theme_update_send_email', '__return_false');