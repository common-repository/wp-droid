<?php


class WPDroidLicenseValidation
{
    private $toastr;

    public function __construct()
    {
        $this->toastr = false;
    }

    public function showToastr($status)
    {
        $this->toastr = $status;
        $this->startValidation();
    }

    public function startValidation()
    {
        $x_api_key = get_option('wpdroid_api_key', "");
        $x_package_name = get_option('wpdroid_package_name', "");

        $url_parts = parse_url(get_site_url());
        $x_website = $url_parts['host'] . $url_parts['path'];

        $args = array(

                'headers' => array(
                        'Content-Type' => 'application/json',
                        'cache-control' => 'no-cache',
                        'content-type' => 'application/json',
                        'x-api-key' => $x_api_key,
                        'x-package-name' => $x_package_name,
                        'x-website' => $x_website,
                        'x-api-secret' => 'a4c31a9d-a20d-40cc-8adb-1c36e5f4f3e4',

                ),
                'timeout' => '25',
                'method' => 'GET',
                'blocking' => true,
                'sslverify' => false
            );

        $validationRequest = wp_remote_get('https://ikvaesolutions.com/wp-json/wp-droid-license-validator/validate', $args);

        $licenseDetails = json_decode(wp_remote_retrieve_body($validationRequest), true);
        $licenseStatus = $licenseDetails['code'];


        if (!($licenseStatus == 1 || $licenseStatus == 97 || $licenseStatus == 98 || $licenseStatus == 99 || $licenseStatus == 100)) {
            if ($this->toastr) {
                wp_die(__('Error: Can not establish connection to validate API Key'));
            } else {
                return;
            }
        }

        if ($licenseStatus == "1") {
            $currentStatus = 1;
            wpdroid_save_option('wp_license_valid_droid', 1, true);
            wpdroid_save_option('wp_license_droid_bookmarks', $licenseDetails['bookmarks'], true);
            wpdroid_save_option('wp_license_droid_about', $licenseDetails['about'], true);
            wpdroid_save_option('wp_license_droid_admob', $licenseDetails['admob'], true);
            wpdroid_save_option('wp_license_droid_related_posts', $licenseDetails['related_posts'], true);
            wpdroid_save_option('wp_license_droid_analytics', $licenseDetails['analytics'], true);
            wpdroid_save_option('wp_license_droid_pushnotifications', $licenseDetails['push_notifications'], true);
            wpdroid_save_option('wp_license_droid_comments', $licenseDetails['comments'], true);
            wpdroid_save_option('wp_license_droid_categories', $licenseDetails['categories'], true);
            wpdroid_save_option('wp_license_droid_plan', $licenseDetails['plan'], true);
            wpdroid_save_option('wp_license_droid_purchase_date', $licenseDetails['purchased_on'], true);
            wpdroid_save_option('wp_license_droid_validuntil', $licenseDetails['valid_until'], true);
        } else {
            $currentStatus = 0;
            wpdroid_save_option('wp_license_valid_droid', 0, true);
        }

        wpdroid_save_option('wpdroid_last_validate_time', time(), true);

        if ($this->toastr) {
            if ($currentStatus == 0) {
                ?>

                  <script>
                  toastr.error('', 'Unable to verify detailes. Please check your API Key and Package Name', {
                      "progressBar": true,
                      "positionClass": "toast-bottom-center",
                      "preventDuplicates": true,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "8000",
                      "extendedTimeOut": "1000",
                    })
                  </script>

                <?php
            } else {
                ?>

                <script>
                toastr.success('', 'API keys updated successfully', {
                    "progressBar": true,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  })
                </script>
<?php
            }
        }
    }
}
