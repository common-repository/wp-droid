 <?php

         wp_nonce_field('wp--droid-settings-update', 'wp--droid', FALSE, TRUE);

          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['wp--droid-setting-update'])) {

              check_admin_referer('wp--droid-settings-update', 'wp--droid');

              if (!current_user_can('manage_options'))  {
                 wp_die( __('You do not have sufficient permissions to access this page.') );
              }

              if(isset($_POST['wpdroid_api_key'])) {
                wpdroid_save_option('wpdroid_api_key', esc_html( sanitize_text_field($_POST['wpdroid_api_key'])), true);
              }

              if(isset($_POST['wpdroid_one_signal_app_id'])) {
                wpdroid_save_option('wpdroid_one_signal_app_id', esc_html( sanitize_text_field($_POST['wpdroid_one_signal_app_id'])));
              }

              if(isset($_POST['wpdroid_google_analytics_id'])) {
                wpdroid_save_option('wpdroid_google_analytics_id', esc_html( sanitize_text_field($_POST['wpdroid_google_analytics_id'])));
              }

              if(isset($_POST['wpdroid_package_name'])) {
                wpdroid_save_option('wpdroid_package_name', esc_html( sanitize_text_field($_POST['wpdroid_package_name'])), true);
              }

              if(isset($_POST['wpdroid_one_signal_rest_api_key'])) {
                wpdroid_save_option('wpdroid_one_signal_rest_api_key', esc_html( sanitize_text_field($_POST['wpdroid_one_signal_rest_api_key'])));
              }

              if(isset($_POST['wpdroid_admob_banner_ad_unit_id'])) {
                wpdroid_save_option('wpdroid_admob_banner_ad_unit_id', esc_html( sanitize_text_field($_POST['wpdroid_admob_banner_ad_unit_id'])));
              }

              $startValidation = new WPDroidLicenseValidation();
              $startValidation->showToastr(true);


        }
     ?>
