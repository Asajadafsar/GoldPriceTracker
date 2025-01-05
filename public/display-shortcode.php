<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to display prices
function gold_price_shortcode() {
    // API key
    $api_key = '30899aff9f4e6886270730b63e66b0e7';

    // Get saved settings
    $selected_currencies = get_option('gold_price_settings', ['EUR', 'XAU', 'XAG']);

    // Construct API URL
    $currencies = implode(',', $selected_currencies);
    $api_url = "https://api.metalpriceapi.com/v1/latest?api_key=30899aff9f4e6886270730b63e66b0e7&base=USD&currencies=EUR,XAU,XAG";

    // Send request to API
    $response = wp_remote_get($api_url, ['timeout' => 15]);
    if (is_wp_error($response)) {
        return '<div>Error retrieving data.</div>';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Check data validity
    if (empty($data) || !isset($data['rates'])) {
        return '<div>No data available for display.</div>';
    }

    // Enqueue styles and scripts
    wp_enqueue_style(
        'gold-price-widget-style',
        plugins_url('public/style.css', dirname(__FILE__)) // Set correct path to style.css
    );
    wp_enqueue_script(
        'gold-price-widget-script',
        plugins_url('public/script.js', dirname(__FILE__)), // Set correct path to script.js
        [],
        false,
        true
    );

    // Build HTML output
    $output = '<div class="gold-price-widget"><h3>Gold Prices</h3><ul>';
    foreach ($data['rates'] as $currency => $rate) {
        $output .= "<li><strong>$currency:</strong> " . number_format($rate, 2) . " USD</li>";
    }
    $output .= '</ul></div>';

    return $output;
}
add_shortcode('gold_price', 'gold_price_shortcode');

// Register and enqueue CSS and JS files
function gold_price_enqueue_assets() {
    wp_register_style(
        'gold-price-widget-style',
        plugins_url('public/style.css', dirname(__FILE__)) // Set correct path to style.css
    );
    wp_register_script(
        'gold-price-widget-script',
        plugins_url('public/script.js', dirname(__FILE__)), // Set correct path to script.js
        [],
        false,
        true
    );
}
add_action('wp_enqueue_scripts', 'gold_price_enqueue_assets');
