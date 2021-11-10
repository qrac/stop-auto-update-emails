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

defined('ABSPATH') || exit;

class StopAutoUpdateEmails {
  private $plugin_name;
  private $option_name;
  private $options;

  public function __construct() {
    $this->plugin_name = 'stop-auto-update-emails';
    $this->option_name = 'stop-auto-update-emails';
    $this->options = get_option($this->option_name);

    if (!get_option($this->option_name)) {
      $default = array(
        'stop_email_core' => '0',
        'stop_email_theme' => '1',
        'stop_email_plugin' => '1',
      );
      $this->options = $default;
    }

    $this->languages();
    $this->run();

    add_action('admin_menu', array($this, 'admin_menu'));
    add_action('admin_init', array($this, 'admin_init'));
  }

  public function languages() {
    load_plugin_textdomain($this->plugin_name, false, basename(dirname(__FILE__)) . '/languages');
  }

  public function run() {
    if (isset($this->options['stop_email_core'])) {
      $stop_email_core = $this->options['stop_email_core'];
      $stop_email_core === '1' && add_filter('auto_core_update_send_email' , '__return_false');
    }
    if (isset($this->options['stop_email_theme'])) {
      $stop_email_theme = $this->options['stop_email_theme'];
      $stop_email_theme === '1' && add_filter('auto_theme_update_send_email' , '__return_false');
    }
    if (isset($this->options['stop_email_plugin'])) {
      $stop_email_plugin = $this->options['stop_email_plugin'];
      $stop_email_plugin === '1' && add_filter('auto_plugin_update_send_email' , '__return_false');
    }
  }

  function admin_menu() {
    add_options_page(
      __('Auto update notification', 'stop-auto-update-emails'),
      __('Auto update notification', 'stop-auto-update-emails'),
      'manage_options',
      $this->plugin_name . '-settings',
      [$this, 'setting_page']
    );
  }

  function admin_init() {
    register_setting(
      $this->plugin_name,
      $this->option_name
    );
    add_settings_section(
      'email_settings',
      __('Email Settings', 'stop-auto-update-emails'),
      null,
      $this->plugin_name
    );
    add_settings_field(
      'stop_email_core',
      __('WordPress Core', 'stop-auto-update-emails'),
      [$this, 'stop_email_core_callback'],
      $this->plugin_name,
      'email_settings'
    );
    add_settings_field(
      'stop_email_theme',
      __('WordPress Theme', 'stop-auto-update-emails'),
      [$this, 'stop_email_theme_callback'],
      $this->plugin_name,
      'email_settings'
    );
    add_settings_field(
      'stop_email_plugin',
      __('WordPress Plugin', 'stop-auto-update-emails'),
      [$this, 'stop_email_plugin_callback'],
      $this->plugin_name,
      'email_settings'
    );
  }

  function stop_email_core_callback() {
    $stop_email_core = isset($this->options['stop_email_core']) ? $this->options['stop_email_core'] : '0';
    ?>
    <label>
      <input
        name="<?php echo $this->option_name; ?>[stop_email_core]"
        type="hidden"
        value="0"
      />
      <input
        name="<?php echo $this->option_name; ?>[stop_email_core]"
        type="checkbox"
        id="stop_email_core"
        value="1"
        <?php checked('1', $stop_email_core); ?>
      /> <?php echo __('Stop core auto-updating emails', 'stop-auto-update-emails'); ?>
    </label>
    <?php
  }

  function stop_email_theme_callback() {
    $stop_email_theme = isset($this->options['stop_email_theme']) ? $this->options['stop_email_theme'] : '0';
    ?>
    <label>
      <input
        name="<?php echo $this->option_name; ?>[stop_email_theme]"
        type="hidden"
        value="0"
      />
      <input
        name="<?php echo $this->option_name; ?>[stop_email_theme]"
        type="checkbox"
        id="stop_email_theme"
        value="1"
        <?php checked('1', $stop_email_theme); ?>
      /> <?php echo __('Stop theme auto-updating emails', 'stop-auto-update-emails'); ?>
    </label>
    <?php
  }

  function stop_email_plugin_callback() {
    $stop_email_plugin = isset($this->options['stop_email_plugin']) ? $this->options['stop_email_plugin'] : '0';
    ?>
    <label>
      <input
        name="<?php echo $this->option_name; ?>[stop_email_plugin]"
        type="hidden"
        value="0"
      />
      <input
        name="<?php echo $this->option_name; ?>[stop_email_plugin]"
        type="checkbox"
        id="stop_email_plugin"
        value="1"
        <?php checked('1', $stop_email_plugin); ?>
      /> <?php echo __('Stop plugin auto-updating emails', 'stop-auto-update-emails'); ?>
    </label>
    <?php
  }

  function setting_page() {
    ?>
    <form action='options.php' method='post'>
      <h1><?php _e('Auto update notification', 'stop-auto-update-emails'); ?></h1>
      <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        submit_button();
      ?>
    </form>
    <?php
  }
}

$stopAutoUpdateEmails = new StopAutoUpdateEmails;