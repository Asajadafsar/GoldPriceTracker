<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to display gold prices
function gold_price_shortcode() {
    // API key
    $api_key = '290cdf5f927b479f1ba427d5e687f7f5';

    // Retrieve saved settings
    $selected_currencies = get_option('gold_price_settings', ['EUR', 'XAU', 'XAG']);

    // Construct API URL based on selected currencies
    $currencies = implode(',', $selected_currencies);
    $api_url = "https://api.metalpriceapi.com/v1/latest?api_key=$api_key&base=USD&currencies=$currencies";

    // Send request to the API
    $response = wp_remote_get($api_url, ['timeout' => 15]);
    if (is_wp_error($response)) {
        return '<div>Error retrieving data.</div>';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Validate API data
    if (empty($data) || !isset($data['rates'])) {
        return '<div>No data available for display.</div>';
    }

    // Build output
    $output = '<div class="gold-price-widget"><h3>Gold Prices</h3><ul>';
    foreach ($data['rates'] as $currency => $rate) {
        $output .= "<li><strong>$currency:</strong> " . number_format($rate, 2) . " USD</li>";
    }
    $output .= '</ul></div>';

    return $output;
}
add_shortcode('gold_price', 'gold_price_shortcode');
