<?php
/*
Plugin Name: WP Droid
Plugin URI: https://ikvaesolutions.com/
Description: Customize your Android native mobile app built with WP Droid.
Version: 2.0
Author: Amar Ilindra
Author URI: https://www.geekdashboard.com/
*/

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

define('wpdroid_PLUGIN_NAME', 'WP Droid');
define('wpdroid_PLUGIN_SETTINGS_SLUG', 'wp-droid');
define('WP_DROID_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_DROID_PLUGIN_DIR_ASSETS', plugin_dir_url(__FILE__) . 'assets');

// define('INPUT_CLEAR_URL_CACHE', wpdroid_PLUGIN_SETTINGS_SLUG.'_clear_url_cache');



//Including all plugin files
require_once(WP_DROID_PLUGIN_DIR . '/includes/menus.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/app-css.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/api-settings.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/api/wp-droid-api.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/customizer.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/notifications.php');
require_once(WP_DROID_PLUGIN_DIR . '/assets/css/default-css.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/helpers/post-meta-box.php');
require_once(WP_DROID_PLUGIN_DIR . '/includes/helpers/validation.php');



/*
 * Adding plugins aseests file only in WP-ADMIN pages
 */

add_action('admin_enqueue_scripts', 'wpdroid_custom_assets');

function wpdroid_custom_assets()
{
    wp_enqueue_style('wp-droid-stylesheet', WP_DROID_PLUGIN_DIR_ASSETS . '/css/styles.css');
    wp_enqueue_style('wp-droid-toastr', WP_DROID_PLUGIN_DIR_ASSETS . '/css/toastr.min.css');
    wp_enqueue_script('wp-droid-toastr-script', WP_DROID_PLUGIN_DIR_ASSETS . '/js/toastr.min.js');
}



/*
 * Saving WP Droid settings in options table
 */

function wpdroid_save_option($id, $value, $forceSave = false)
{
    if (get_option('wp_license_valid_droid', 0) || $forceSave) {
        $option_exists = (get_option($id, null) !== null);
        if ($option_exists) {
            update_option($id, $value);
        } else {
            add_option($id, $value);
        }
    }
}



/*
 * WP Droid custom nonce message
 */

function wpdroid_custom_nonce_message($translation)
{
    if ($translation == 'Are you sure you want to do this?') {
        return 'Good try! But this is not allowed';
    } else {
        return $translation;
    }
}



/*
 * Wrapping get_post_meta() menthod to return a default value if meta value is not available
 * WHY U NO PROVIDE 4th default parameter WordPress :(
 */

 function wpdroid_get_post_meta_value($post_id, $key, $default)
 {
     if (get_option('wp_license_valid_droid', 0)) {
         $value = get_post_meta($post_id, $key, true);
         if (empty($value)) {
             return $default;
         } else {
             return $value;
         }
     } else {
         return $default;
     }
 }

/*
 * Checks if post meta box is checked
 * @returns true if checked
 */

 function wpdroid_meta_box_isChecked($postid, $key, $default)
 {
     return wpdroid_get_post_meta_value($postid, $key, $default) == "checked" ? true : false;
 }


add_filter('gettext', 'wpdroid_custom_nonce_message');

$defaultInviteFriends = "Download the official Android app of ". get_bloginfo('name') . " from Google Play Store - [ADD YOUR PLAYSTORE OR OTHER DOWNLOAD LINK]";

define('wpdroid_DEFAULT_INVITE_FRIENDS_TEXT', $defaultInviteFriends);


if (get_option('wpdroid_api_key', " ") != " ") {
    $nextValidateTime = (int) (get_option("wpdroid_last_validate_time", 1) + 86400);
    $currentTime = ((int) time());

    if ($nextValidateTime < $currentTime) {
        $wpDroidLicenseValidation = new WPDroidLicenseValidation();
        $wpDroidLicenseValidation->showToastr(false);
    }
}


function wpDroidDebug($data) {
    $html = "";

    if (is_array($data) || is_object($data)) {
        $html = "<script>console.log('WP DROID: ".json_encode($data)."');</script>";
    } else {
        $html = "<script>console.log('WP DROID: ".$data."');</script>";
    }

    echo($html);
}
