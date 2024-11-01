<?php

function wpdroid_plugin_api_settings_screen()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    } ?>


  <div class="columnsContainer">

    <div class="leftColumn">

      <form method="post" action="">

        <?php require_once(WP_DROID_PLUGIN_DIR . '/includes/options/api-settings-options.php'); ?>



        <ul>
          <li class="itemDetail" style="display: list-item;">
            <h2 class="itemTitle">Add API Keys</h2>
            <table class="form-table wp_droid_table">
              <tbody>

                <tr style="display: table-row;">
                  <th scope="row" class="wp_droid_th">WP Droid API Key</th>
                  <td>
                    <input value="<?php echo get_option('wpdroid_api_key', " ") ?>" id="wpdroid_api_key" type="text" class="wp_droid_input" name="wpdroid_api_key" size="50">
                  </td>
                </tr>

                <tr style="display: table-row;">
                  <th class="wp_droid_th" scope="row">Package Name</th>
                  <td>
                    <input value="<?php echo get_option('wpdroid_package_name', " ") ?>" id="wpdroid_package_name" type="text" name="wpdroid_package_name" class="wp_droid_input" size="50">
                  </td>
                </tr>

                <tr style="display: table-row;" class="wpdroid-validate-admob-id">
                  <th class="wp_droid_th" scope="row">AdMob Banner Ad Unit ID</th>
                  <td>
                    <input value="<?php echo get_option('wpdroid_admob_banner_ad_unit_id', " ") ?>" id="wpdroid_admob_banner_ad_unit_id" type="text" class="wp_droid_input" name="wpdroid_admob_banner_ad_unit_id" size="50">
                  </td>
                </tr>

                <tr style="display: table-row;" class="wpdroid-validate-analytics">
                  <th class="wp_droid_th" scope="row">Google Analytics ID</th>
                  <td>
                    <input value="<?php echo get_option('wpdroid_google_analytics_id', " ") ?>" id="wpdroid_google_analytics_id" type="text" class="wp_droid_input" name="wpdroid_google_analytics_id" size="50">
                  </td>
                </tr>

                <tr style="display: table-row;" class="wpdroid-validate-onesignal-app-id">
                  <th class="wp_droid_th" scope="row">OneSignal APP ID</th>
                  <td>
                    <input value="<?php echo get_option('wpdroid_one_signal_app_id', " ") ?>" id="wpdroid_one_signal_app_id" type="text" class="wp_droid_input" name="wpdroid_one_signal_app_id" size="50">
                  </td>
                </tr>


                <tr style="display: table-row;" class="wpdroid-validate-onesignal-api-key">
                  <th class="wp_droid_th" scope="row">OneSignal REST API KEY</th>
                  <td>
                    <input value="<?php echo get_option('wpdroid_one_signal_rest_api_key', " ") ?>" id="wpdroid_one_signal_rest_api_key" type="text" class="wp_droid_input" name="wpdroid_one_signal_rest_api_key" size="50">
                  </td>
                </tr>


                <tr>
                  <td></td>
                  <td style="margin-top:20px">
                    <button type="submit" class="wp_droid_button" name="wp--droid-setting-update">Update API Keys</button>
                  </td>
                </tr>

              </tbody>
            </table>
          </li>
        </ul>

      </form>
    </div>

    <div class="rightColumn">
      <div class="rightColumn promotions-nonsticky">

        <?php include(WP_DROID_PLUGIN_DIR . '/includes/helpers/license-details.php'); ?>
        <?php include(WP_DROID_PLUGIN_DIR . '/includes/helpers/sidebar-common.php'); ?>

      </div>

    </div>

  </div>

  <script type="text/javascript">
    jQuery(document).ready(function($) {

      var isValidLicense = <?php echo get_option('wp_license_valid_droid', 0); ?>;

      if (!isValidLicense) {
        $(".wpdroid-validate-admob-id").addClass("wpdroid_disable");
        $(".wpdroid-validate-onesignal-app-id").addClass("wpdroid_disable");
        $(".wpdroid-validate-onesignal-api-key").addClass("wpdroid_disable");
        $(".wpdroid-validate-analytics").addClass("wpdroid_disable");
      } else {

        var isADMobAllowed = <?php echo get_option('wp_license_droid_admob', 0); ?>;
        var isNotificationsAllowed = <?php echo get_option('wp_license_droid_pushnotifications', 0); ?>;
        var isAnalyticsAllowed = <?php echo get_option('wp_license_droid_analytics', 0); ?>;

        if (!isADMobAllowed) {
          $(".wpdroid-validate-admob-id").addClass("wpdroid_disable");
        }

        if (!isNotificationsAllowed) {
          $(".wpdroid-validate-onesignal-app-id").addClass("wpdroid_disable");
          $(".wpdroid-validate-onesignal-api-key").addClass("wpdroid_disable");
        }

        if (!isAnalyticsAllowed) {
          $(".wpdroid-validate-analytics").addClass("wpdroid_disable");
        }

      }

      jQuery('.wpdroid_disable').click(function() {

        var wpdroidErrorMessage = '';
        if (isValidLicense) {
          wpdroidErrorMessage = 'Not available in your package. Please upgrade to unlock more features';
        } else {
          wpdroidErrorMessage = 'You need to first validate your API key and package name';
        }
        toastr.error('', wpdroidErrorMessage, {
          "progressBar": true,
          "positionClass": "toast-top-center",
          "preventDuplicates": true,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "8000",
          "extendedTimeOut": "1000",
        })
      })

    });
  </script>

  <?php
}
?>
