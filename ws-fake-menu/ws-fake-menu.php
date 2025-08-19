<?php
/**
 * Plugin Name: WS Fake Menu
 * Description: Génère un menu WordPress fictif (liens personnalisés) à partir d'une page d'administration.
 * Version: 1.0.0
 * Author: WS
 * Text Domain: ws-fake-menu
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!defined('WSFM_PLUGIN_FILE')) {
	define('WSFM_PLUGIN_FILE', __FILE__);
}
if (!defined('WSFM_PLUGIN_DIR')) {
	define('WSFM_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('WSFM_PLUGIN_URL')) {
	define('WSFM_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('WSFM_TEXT_DOMAIN')) {
	define('WSFM_TEXT_DOMAIN', 'ws-fake-menu');
}

require_once WSFM_PLUGIN_DIR . 'includes/AdminPage.php';
require_once WSFM_PLUGIN_DIR . 'includes/MenuBuilder.php';
require_once WSFM_PLUGIN_DIR . 'includes/TermsProvider.php';

class WSFM_Plugin {
	private $admin_page;

	public function __construct() {
		add_action('plugins_loaded', [$this, 'load_textdomain']);
		$this->admin_page = new WSFM_Admin_Page(new WSFM_Menu_Builder(new WSFM_Terms_Provider()));
	}

	public function load_textdomain() {
		load_plugin_textdomain(WSFM_TEXT_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages');
	}
}

new WSFM_Plugin();