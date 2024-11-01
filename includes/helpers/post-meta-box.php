<?php
/**
 * Calls the class on the post edit screen.
 */
function wpDroid_meta_box()
{
    new WPDroid_Meta_BOX();
}

if (is_admin() && get_option('wp_license_valid_droid', 0)) {
    add_action('load-post.php', 'wpDroid_meta_box');
    add_action('load-post-new.php', 'wpDroid_meta_box');
}

/**
 * The WPDroid_Meta_BOX Class.
 */
class WPDroid_Meta_BOX
{

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array( $this, 'add_meta_box' ));
        add_action('save_post', array( $this, 'save_wpdroid_meta_values'));
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type)
    {
        // Limit meta box to certain post types.
        $post_types = array( 'post');

        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'wpdroid_post_meta_box',
                'WP Droid Settings Overrite',
                array( $this, 'wpdroid_render_metabox_content' ),
                $post_type,
                'side',
                'low'
            );

            $isNotificationsAllowed = get_option('wp_license_droid_pushnotifications', 0);
            $isValidLicense = get_option('wp_license_valid_droid', 0);

            if ($isValidLicense && $isNotificationsAllowed) {
                add_meta_box(
                'wpdroid_post_meta_box_notification',
                'WP Droid Notification',
                array( $this, 'wpdroid_post_meta_box_notification_content' ),
                $post_type,
                'side',
                'high'
            );
            }
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save_wpdroid_meta_values($post_id)
    {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (! isset($_POST['wpdroid_post_metabox_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['wpdroid_post_metabox_nonce'];

        // Verify that the nonce is valid.
        if (! wp_verify_nonce($nonce, 'wpdroid_post_metabox')) {
            return $post_id;
        }

        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (! current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (! current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        /* OK, it's safe for us to save the data now. */

        // Sanitize the user input.


        // Override WP Droid Settings
        if (isset($_POST['wpdroid_meta_override_settings'])) {
            update_post_meta($post_id, 'wpdroid_meta_override_settings', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_override_settings', "unchecked");
        }

        // Exclude Posts
        if (isset($_POST['wpdroid_meta_exclude_post'])) {
            update_post_meta($post_id, 'wpdroid_meta_exclude_post', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_exclude_post', "unchecked");
        }

        // Featured Image Feed
        if (isset($_POST['wpdroid_meta_featured_image_feed'])) {
            update_post_meta($post_id, 'wpdroid_meta_featured_image_feed', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_featured_image_feed', "unchecked");
        }

        // Featured Image Article Screen
        if (isset($_POST['wpdroid_meta_featured_image_article'])) {
            update_post_meta($post_id, 'wpdroid_meta_featured_image_article', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_featured_image_article', "unchecked");
        }

        // Author Name on Article Screen
        if (isset($_POST['wpdroid_meta_author_name_article'])) {
            update_post_meta($post_id, 'wpdroid_meta_author_name_article', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_author_name_article', "unchecked");
        }

        // Author Name on Feed
        if (isset($_POST['wpdroid_meta_author_name_feed'])) {
            update_post_meta($post_id, 'wpdroid_meta_author_name_feed', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_author_name_feed', "unchecked");
        }

        //Date and time of Feed
        if (isset($_POST['wpdroid_meta_date_time_feed'])) {
            update_post_meta($post_id, 'wpdroid_meta_date_time_feed', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_date_time_feed', "unchecked");
        }

        //Date and time of Article
        if (isset($_POST['wpdroid_meta_date_time_article'])) {
            update_post_meta($post_id, 'wpdroid_meta_date_time_article', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_date_time_article', "unchecked");
        }

        //Admob Bottom Ad
        if (isset($_POST['wpdroid_meta_ad_mob_bottom_ad'])) {
            update_post_meta($post_id, 'wpdroid_meta_ad_mob_bottom_ad', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_ad_mob_bottom_ad', "unchecked");
        }

        //Comments
        if (isset($_POST['wpdroid_meta_comments'])) {
            update_post_meta($post_id, 'wpdroid_meta_comments', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_comments', "unchecked");
        }

        //Related Posts
        if (isset($_POST['wpdroid_meta_related_posts'])) {
            update_post_meta($post_id, 'wpdroid_meta_related_posts', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_related_posts', "unchecked");
        }

        //Web Browser
        if (isset($_POST['wpdroid_meta_web_browser'])) {
            update_post_meta($post_id, 'wpdroid_meta_web_browser', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_web_browser', "unchecked");
        }

        //Layout Style
        if (isset($_POST['wpdroid_meta_layout_style'])) {
            update_post_meta($post_id, 'wpdroid_meta_layout_style', $_POST['wpdroid_meta_layout_style']);
        }


        if (isset($_POST['wpdroid_meta_send_notification'])) {
            update_post_meta($post_id, 'wpdroid_meta_send_notification', "checked");
        } else {
            update_post_meta($post_id, 'wpdroid_meta_send_notification', "unchecked");
        }
    }


    public function get_excerpt_by_id($post_id)
    {
        $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 35; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

        if (count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
        endif;

        return $the_excerpt;
    }


    /**
     * Render Notification Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function wpdroid_post_meta_box_notification_content($post)
    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field('wpdroid_post_metabox', 'wpdroid_post_metabox_nonce');


        // Notifications - START

        $post_id = $post->ID;
        $post_type = $post->post_type;

        $isPostPublish = $post->post_status == 'publish' ? true : false;
        $isPost = $post->post_type == 'post' ? true : false;
        $isChecked = wpdroid_get_post_meta_value($post_id, 'wpdroid_meta_send_notification', "unchecked") == 'checked' ? true : false;


        if (get_option('wp_license_valid_droid', 0) && get_option('wp_license_droid_pushnotifications', 0)) {
            if ($isPost && $isPostPublish && $isChecked) {
                require_once(WP_DROID_PLUGIN_DIR . '/includes/api/notifications-api.php');

                $oneSignalPush = new WPDroidPush();

                $oneSignalPush->setTitle(get_the_title($post_id));
                $oneSignalPush->setDescription($this->get_excerpt_by_id($post_id));

                $medium = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'medium');
                $medium_image = $medium['0'] == null ? "" : $medium['0'];

                $oneSignalPush->setImage($medium_image);

                $oneSignalPush->setPostId($post_id);

                $oneSignalPush->setNotificationType('new_post');

                $oneSignalPush->sendNotification();

                update_post_meta($post_id, 'wpdroid_meta_send_notification', "unchecked");
            }
        }


        $checkboxStatus = "";
        $isBoxChecked = get_option('wpdroid_send_notification_automatically', 0) == 1;

        if (!$isPostPublish) {
            if ($isBoxChecked) {
                $checkboxStatus = "checked";
            }
        } ?>

  <label for="wpdroid_meta_send_notification">
          <input type="checkbox" id="wpdroid_meta_send_notification" name="wpdroid_meta_send_notification"
          <?php echo $checkboxStatus; ?> />
          <?php if ($isPostPublish) {
            echo "<strong>Send notification on " . $post_type . " update</strong>";
        } else {
            echo "<strong>Send notification on " . $post_type . " publish</strong>";
        } ?>
        </label>
  <?php
    }


    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function wpdroid_render_metabox_content($post)
    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field('wpdroid_post_metabox', 'wpdroid_post_metabox_nonce');

        $isAdmobAllowed = get_option('wp_license_droid_admob', 0) && get_option('wp_license_valid_droid', 0);
        $isCommentsAllowed = get_option('wp_license_droid_comments', 0) && get_option('wp_license_valid_droid', 0);
        $isRelatedPostsAllowed = get_option('wp_license_droid_related_posts', 0) && get_option('wp_license_valid_droid', 0); ?>


    <ul>
      <!--  OVERRIDE SETTINGS -->
      <li><label for="wpdroid_meta_override_settings">
          <input type="checkbox" id="wpdroid_meta_override_settings" name="wpdroid_meta_override_settings" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_override_settings', "unchecked"); ?>/>
          Override WP Droid Global Settings
        </label>
      </li>

    </ul>

    <ul class="wpdroid_meta_override_settings_options_toggle">

      <li>
        <p style="color:red">When you enable this option, global plugin settings will be ignored for this post</p>
      </li>
      <li>
        <p><strong>Article Screen</strong></p>
      </li>


      <!-- Open article in web browser -->
      <li>
        <label for="wpdroid_meta_web_browser">
          <input type="checkbox" id="wpdroid_meta_web_browser" name="wpdroid_meta_web_browser" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_web_browser', "unchecked") ?>/>
          Open Article in Web Browser
        </label>
      </li>

      <!-- AdMob Bottom Ad -->

      <li class="toggle_is_web_browser">
        <label for="wpdroid_meta_ad_mob_bottom_ad" class="<?php echo $isAdmobAllowed ? 'wpdroid-post-meta-allowed' : 'wpdroid-post-meta-not-allowed'?>">
          <input type="checkbox" id="wpdroid_meta_ad_mob_bottom_ad" name="wpdroid_meta_ad_mob_bottom_ad" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_ad_mob_bottom_ad', "checked") ?> <?php echo $isAdmobAllowed ? '' : 'disabled' ?> />
          AdMob Bottom Ad
        </label>
      </li>

      <!-- Related Posts -->
      <li class="toggle_is_web_browser">
        <label for="wpdroid_meta_related_posts" class="<?php echo $isRelatedPostsAllowed ? 'wpdroid-post-meta-allowed' : 'wpdroid-post-meta-not-allowed'?>">
          <input type="checkbox" id="wpdroid_meta_related_posts" name="wpdroid_meta_related_posts" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_related_posts', "checked") ?> <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?> />
          Related Post
        </label>
      </li>


      <!-- Comments -->
      <li class="toggle_is_web_browser">
        <label for="wpdroid_meta_comments" class="<?php echo $isCommentsAllowed ? 'wpdroid-post-meta-allowed' : 'wpdroid-post-meta-not-allowed'?>">
          <input type="checkbox" id="wpdroid_meta_comments" name="wpdroid_meta_comments" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_comments', "checked") ?> <?php echo $isCommentsAllowed ? '' : 'disabled' ?> />
          Show Comments
        </label>
      </li>


      <!-- Featured Image Article -->
      <li class="toggle_is_web_browser">
        <label for="wpdroid_meta_featured_image_article">
          <input type="checkbox" id="wpdroid_meta_featured_image_article" name="wpdroid_meta_featured_image_article" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_featured_image_article', "checked") ?>/>
          Featured Image
        </label>
      </li>


      <!-- Author Name Article -->
      <li class="toggle_is_web_browser">
        <label for="wpdroid_meta_author_name_article">
          <input type="checkbox" id="wpdroid_meta_author_name_article" name="wpdroid_meta_author_name_article" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_author_name_article', "checked") ?>/>
          Author Name
        </label>
      </li>

      <!-- Date Time option Article Screen -->
      <li class="toggle_is_web_browser">
        <label for="wpdroid_meta_date_time_article">
          <input type="checkbox" id="wpdroid_meta_date_time_article" name="wpdroid_meta_date_time_article" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_date_time_article', "checked") ?>/>
          Date and Time
        </label>
      </li>


      <li>
        <p><strong>Posts Feed</strong></p>
      </li>

      <!-- EXCLUDE POST -->
      <li>
        <label for="wpdroid_meta_exclude_post">
          <input type="checkbox" id="wpdroid_meta_exclude_post" name="wpdroid_meta_exclude_post" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_exclude_post', "unchecked") ?>/>
          Exclude Post
        </label>
      </li>


      <!-- Featured Image Feed-->
      <li>
        <label for="wpdroid_meta_featured_image_feed">
          <input type="checkbox" id="wpdroid_meta_featured_image_feed" name="wpdroid_meta_featured_image_feed" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_featured_image_feed', "checked"); ?>/>
          Featured Image

        </label>
      </li>

      <!-- Author Name Feed -->
      <li>
        <label for="wpdroid_meta_author_name_feed">
          <input type="checkbox" id="wpdroid_meta_author_name_feed" name="wpdroid_meta_author_name_feed" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_author_name_feed', "checked") ?>/>
          Author Name
        </label>
      </li>

      <!-- Date Time option Feed -->
      <li>
        <label for="wpdroid_meta_date_time_feed">
          <input type="checkbox" id="wpdroid_meta_date_time_feed" name="wpdroid_meta_date_time_feed" <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_date_time_feed', "checked"); ?>/>
          Date and Time
        </label>
      </li>

      <li>

        <p><strong>Layout Style</strong></p>

        <fieldset id="wpdroid_meta_layout_style">
          <label>
                <input <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_layout_style', 'top_image') == "top_image" ? 'checked' : '' ?> type="radio" value="top_image" name="wpdroid_meta_layout_style" >Card Layout 1
              </label>
          <br>
          <label style=margin-top:10px;>
              <input <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_layout_style', 'top_image') == "left_image" ? 'checked' : '' ?> type="radio" value="left_image" name="wpdroid_meta_layout_style">Card Layout 2
            </label>

            <br>
            <label style=margin-top:10px;>
                <input <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_layout_style', 'top_image') == "flat_top_image" ? 'checked' : '' ?> type="radio" value="flat_top_image" name="wpdroid_meta_layout_style">Flat Layout 1
              </label>

              <br>
              <label style=margin-top:10px;>
                  <input <?php echo wpdroid_get_post_meta_value($post->ID, 'wpdroid_meta_layout_style', 'top_image') == "flat_right_image" ? 'checked' : '' ?> type="radio" value="flat_right_image" name="wpdroid_meta_layout_style">Flat Layout 2
                </label>
        </fieldset>


      </li>

    </ul>


    <!--  JS -->

    <script>
      //Status true - isChecked
      //Status false - Not checked
      function wpDroidMetaHandleCheckedStatus(wpDroidcheckbox, wpDroidContents, flag) {

        if (jQuery(wpDroidcheckbox).is(':checked')) {
            if (flag) {
              jQuery(wpDroidContents).show();
            } else {
              jQuery(wpDroidContents).hide();
            }
          } else {
            if (flag) {
              jQuery(wpDroidContents).hide();
            } else {
              jQuery(wpDroidContents).show();

            }
          }

        }

        //Status true - isChecked
        //Status false - Not checked
        function wpDroidMetaCheckboxChangeListener(wpDroidcheckbox, wpDroidContents, flag) {

          jQuery(wpDroidcheckbox).change(function() {
            if (this.checked) {
              if (flag) {
                jQuery(wpDroidContents).show();
              } else {
                jQuery(wpDroidContents).hide();
              }
            } else {
              if (flag) {
                jQuery(wpDroidContents).hide();
              } else {
                jQuery(wpDroidContents).show();
              }
            }

          });

        }

        jQuery(document).ready(function() {

          wpDroidMetaHandleCheckedStatus('#wpdroid_meta_override_settings', '.wpdroid_meta_override_settings_options_toggle', true);

          wpDroidMetaCheckboxChangeListener('#wpdroid_meta_override_settings', '.wpdroid_meta_override_settings_options_toggle', true);

          wpDroidMetaHandleCheckedStatus('#wpdroid_meta_web_browser', '.toggle_is_web_browser', false);
          wpDroidMetaCheckboxChangeListener('#wpdroid_meta_web_browser', '.toggle_is_web_browser', false);

        });
    </script>



    <?php
    }
}

?>
