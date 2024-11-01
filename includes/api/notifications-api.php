<?php

class WPDroidPush
{
    private $title;
    private $description;
    private $post_id;
    private $url;
    private $image;
    private $notification_type;

    private $updateType;
    private $latestVersionCode;
    private $lastForceUpdateCode;

    private $urlToClear;

    public function __construct()
    {
        $this->title = "default";
        $this->description = "default";
        $this->post_id = "default";
        $this->url = "default";
        $this->image = "default";
        $this->notification_type = "default";
        $this->updateType = "default";
        $this->latestVersionCode = -1;
        $this->lastForceUpdateCode = -1;
        $this->urlToClear = "default";
    }

    public function setTitle($title)
    {
        $this->title = esc_html(sanitize_text_field($title));
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPostId($postId)
    {
        $this->post_id = esc_html(sanitize_text_field($postId));
    }

    public function setURL($url)
    {
        $this->url = esc_url($url);
    }

    public function setImage($image)
    {
        $this->image = esc_url($image);
    }

    public function setNotificationType($type)
    {
        $this->notification_type = esc_html(sanitize_text_field($type));
    }

    public function setUpdateType($updateType)
    {
        $this->updateType = esc_html(sanitize_text_field($updateType));
    }

    public function setLatestVersionCode($latestVersionCode)
    {
        $this->latestVersionCode = esc_html(sanitize_text_field($latestVersionCode));
    }

    public function setLastForceUpdateCode($lastForceUpdateCode)
    {
        $this->lastForceUpdateCode = esc_html(sanitize_text_field($lastForceUpdateCode));
    }

    public function setUrlToClear($urlToClear)
    {
        $this->urlToClear = esc_url($urlToClear);
    }


    public function sendNotification()
    {
        if (!get_option('wp_license_valid_droid', 0)) {
            wp_die(__('Can not validate your WP Droid license. If you feel this is an error, please contact us along with your WP Droid API Key'));
        } elseif (!get_option('wp_license_droid_pushnotifications', 0)) {
            wp_die(__('Your WP Droid API Key is not allowed to send notification. Please upgrade your license to send notifications. If you feel this is an error, please contact us along with your WP Droid API Key'));
        }

        $appId = get_option('wpdroid_one_signal_app_id', " ");
        $restAPIKey = get_option('wpdroid_one_signal_rest_api_key', " ");


        $fields = array(

            'app_id' => $appId,

            'included_segments' => array(
                'All'
            ),

            'data' => array(
                "foo" => "bar"
            ),

            'contents' => array(
                "en" => $this->description
            ),

            'headings' => array(
                "en" => $this->title
            ),

            'subtitle' => array(
                "en" => $this->description
            ),

            'isAndroid' => true,

            'isAnyWeb' => false,

        );

        $additionalDate = array(

            'notification_type' => $this->notification_type,

        );


        if ($this->notification_type == "new_post") {
            $additionalDate['post_id'] = $this->post_id;

            if ($this->image != 'default') {
                $fields['big_picture'] = $this->image;
            }
        }

        if ($this->notification_type == "announcement") {
            $additionalDate['announcement_url'] = $this->url;

            if ($this->image != 'default') {
                $fields['big_picture'] = $this->image;
            }

            $additionalDate['announcement_image'] = $this->image;
            $additionalDate['announcement_title'] = $this->title;
            $additionalDate['announcement_description'] = $this->description;
        }

        $fields['additionalDate'] = $additionalDate;
        $fields['data'] = $additionalDate;


        $fields = json_encode($fields);

        $args = array(
          'body' => $fields,

            'headers' => array(
              'Content-Type' => 'application/json',
              'Authorization' => 'Basic ' . $restAPIKey . "'",
            ),
            'timeout' => '10',
            'method' => 'POST',
            'blocking' => true,
            'sslverify' => false
        );

        $sendNotificationRequest = wp_remote_get( 'https://onesignal.com/api/v1/notifications', $args );

        $response = wp_remote_retrieve_body($sendNotificationRequest);
        $httpcode = wp_remote_retrieve_response_code($sendNotificationRequest);

        $this->sentNotificationResponse($response, $httpcode);
    }


    public function sentNotificationResponse($response, $httpcode)
    {
        if ($httpcode == 200) {
            $details = json_decode($response, true);
            $sentCount = $details['recipients'];

            if ($sentCount > 0) {
                $message = "Notification successfully sent to " . $sentCount . " users";
            } else {
                $message = "Notification sent but there are 0 users subscribed to notifications";
            } ?>

					<script>

					toastr.success('', '<?php echo $message; ?>', {
							"progressBar": true,
							"positionClass": "toast-top-center",
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
						toastr.error('', '<?php echo $response; ?>', {
								"progressBar": true,
								"positionClass": "toast-top-center",
								"preventDuplicates": true,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "8000",
								"extendedTimeOut": "1000",
							})
						</script>

					<?php
        }



        if($this->notification_type == 'clear_app_cache') {
          $wpDroidLicenseValidation = new WPDroidLicenseValidation();
          $wpDroidLicenseValidation->showToastr(false);
        }
    }
}


?>
