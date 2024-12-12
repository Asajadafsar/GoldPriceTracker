<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add settings menu to the admin dashboard
function gold_price_add_admin_menu() {
    add_options_page(
        'Gold Price Settings',
        'Gold Price',
        'manage_options',
        'gold_price_settings',
        'gold_price_settings_page'
    );
}
add_action('admin_menu', 'gold_price_add_admin_menu');

// Display the settings page
function gold_price_settings_page() {
    // Retrieve saved settings
    $selected_currencies = get_option('gold_price_settings', ['EUR', 'XAU', 'XAG']);
    ?>
    <div class="wrap">
        <h1>Gold Price Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('gold_price_settings_group');
            do_settings_sections('gold_price_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Display Prices:</th>
                    <td>
                        <label><input type="checkbox" name="gold_price_settings[]" value="EUR" <?php echo in_array('EUR', $selected_currencies) ? 'checked' : ''; ?>> Euro (EUR)</label><br>
                        <label><input type="checkbox" name="gold_price_settings[]" value="XAU" <?php echo in_array('XAU', $selected_currencies) ? 'checked' : ''; ?>> Gold (XAU)</label><br>
                        <label><input type="checkbox" name="gold_price_settings[]" value="XAG" <?php echo in_array('XAG', $selected_currencies) ? 'checked' : ''; ?>> Silver (XAG)</label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
function gold_price_register_settings() {
    register_setting('gold_price_settings_group', 'gold_price_settings');
}
add_action('admin_init', 'gold_price_register_settings');
