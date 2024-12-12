<?php
/*
Plugin Name: Gold Price Display
Description: WordPress plugin for displaying gold and precious metal prices.
Version: 1.0
Author: Sajad Afsar
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('GOLD_PRICE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('GOLD_PRICE_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include plugin files
require_once GOLD_PRICE_PLUGIN_PATH . 'admin/settings-page.php';
require_once GOLD_PRICE_PLUGIN_PATH . 'public/display-shortcode.php';

// Plugin activation
function gold_price_activate() {
    add_option('gold_price_settings', ['EUR', 'XAU', 'XAG']);
}
register_activation_hook(__FILE__, 'gold_price_activate');

// Plugin deactivation
function gold_price_deactivate() {
    delete_option('gold_price_settings');
}
register_deactivation_hook(__FILE__, 'gold_price_deactivate');
