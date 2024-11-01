<?php

  function wpdroid_plugin_customizer_settings_screen()
  {
      if (!current_user_can('manage_options')) {
          wp_die(__('You do not have sufficient permissions to access this page.'));
      }

      if(!get_option('wp_license_valid_droid', 0)) {
         include WP_DROID_PLUGIN_DIR . '/includes/helpers/invalid-license-layout.php';
         return;
      }

      ?>

  <!-- SETTINGS STARTED -->

  <script>
    function wpDroidSmoothScroll(target) {
      jQuery('html, body').animate({
        scrollTop: jQuery("." + target).offset().top
      }, 300);
    }

    function wpDroidHandleCheckedStatus(wpDroidcheckbox, wpDroidContents) {

      if (jQuery(wpDroidcheckbox).is(':checked')) {
        jQuery(wpDroidContents).show();
      } else {
        jQuery(wpDroidContents).hide();
      }
    }

    function wpDroidCheckboxChangeListener(wpDroidcheckbox, wpDroidContents) {

      jQuery(wpDroidcheckbox).change(function() {
        if (this.checked) {
          jQuery(wpDroidContents).show();
        } else {
          jQuery(wpDroidContents).hide();
        }
      });

    }

    jQuery(document).ready(function() {

      wpDroidHandleCheckedStatus('#wpdroid_invite_friends', '.wpdroid_invite_friends_text_toggle');
      wpDroidCheckboxChangeListener('#wpdroid_invite_friends', '.wpdroid_invite_friends_text_toggle');

      var isRelatedPostsAllowed = <?php echo get_option('wp_license_droid_related_posts', 0); ?>;
      if (isRelatedPostsAllowed) {
        wpDroidHandleCheckedStatus('#wpdroid_show_related_posts', '.wpdroid_related_posts_toggle');
        wpDroidCheckboxChangeListener('#wpdroid_show_related_posts', '.wpdroid_related_posts_toggle');
      }

      var isCommentsAllowed = <?php echo get_option('wp_license_droid_comments', 0); ?>;
      if (isCommentsAllowed) {
        wpDroidHandleCheckedStatus('#wpdroid_allow_comments', '.wpdroid_comments_toggle');
        wpDroidCheckboxChangeListener('#wpdroid_allow_comments', '.wpdroid_comments_toggle');
      }

      jQuery('.wpdroid_disable').click(function() {
        toastr.error('', 'Not available in your package. Please upgrade to unlock more features', {
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

  <div class="columnsContainer">

    <div class="leftColumn">

      <form method="post" action="">

        <?php require_once(WP_DROID_PLUGIN_DIR . '/includes/options/customizer-options.php');


        $isBookmarksAllowed = get_option('wp_license_droid_bookmarks', 0);
    		$isAboutAllowed = get_option('wp_license_droid_about', 0);
        $isAdmobAllowed = get_option('wp_license_droid_admob', 0);
        $isNotificationsAllowed = get_option('wp_license_droid_pushnotifications', 0);
        $isCommentsAllowed = get_option('wp_license_droid_comments', 0);
        $isCategoriesAllowed = get_option('wp_license_droid_categories', 0);
        $isRelatedPostsAllowed = get_option('wp_license_droid_related_posts', 0);


        $wpDroidDisableState = "wpdroid_disable";

        ?>

        <div style="text-align: center; margin-top: 50px;">
          <h2 class="itemTitle">Customize your app screens</h2>
        </div>


        <ul class="common-settings">
          <li class="itemDetail" style="display: list-item;">
            <h2 class="itemTitle">Common Settings</h2>
            <table class="form-table">
              <tbody>

                <tr valign="top" style="display: table-row;" class="<?php echo $isNotificationsAllowed ? 'wpdroid_notification' : $wpDroidDisableState ?>">
                  <th>New Post Notification</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_send_notification_automatically', 0) == 1 ? 'checked' : '' ?> type="checkbox" name="wpdroid_send_notification_automatically" id="wpdroid_send_notification_automatically" class="wpdroid_checkbox" <?php echo $isNotificationsAllowed ? '' : 'disabled' ?> >Send notification to app users automatically when new post is published
                          </label>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Posts To Load At Once</th>
                  <td>
                    <input class="wp_droid_input" value="<?php echo get_option('wpdroid_posts_load_count', 5) ?>" id="wpdroid_posts_load_count" type="number" name="wpdroid_posts_load_count" maxlength="10" min="5" max="30" />
                    <p>Recommended is between <code>5</code> and <code>10</code>. Loading more posts at once will slow down the app<br/>For larger screens like tablets, 10 posts are loaded if entered value is less than 10</p>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Exclude Posts</th>
                  <td>

                    <input class="wp_droid_input" value="<?php echo get_option('wpdroid_exclude_posts', " ") ?>" id="wpdroid_exclude_posts" type="text" name="wpdroid_exclude_posts" size="50" placeholder="Example: 173, 437, 374">
                    <p><label class="wpdroid_label">
                      Enter <code>Post ID's</code> seperated by <code>" , "</code>
                      </label></p>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Exclude Categories</th>
                  <td>

                    <input class="wp_droid_input" value="<?php echo get_option('wpdroid_exclude_categories', " ") ?>" id="wpdroid_exclude_categories" type="text" name="wpdroid_exclude_categories" size="50" placeholder="Example: 1, 23, 42, 12">
                    <p><label class="wpdroid_label">
                      Enter <code>Category ID's</code> seperated by <code>" , "</code>
                      </label></p>
                  </td>
                </tr>

                <tr valign="top" style="display: table-row;" class="<?php echo $isAdmobAllowed ? 'wpdroid_admob' : $wpDroidDisableState ?>">
                  <th scope="row">Show AdMob Bottom Banner Ad on</th>

                  <td class="wpdroid_multiple_checkbox">

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_admob_bottom_ad_home', 0) == 1 ? 'checked' : '' ?> id="wpdroid_admob_bottom_ad_home" type="checkbox" name="wpdroid_admob_bottom_ad_home" clas="wpdroid_admob_checkbox" <?php echo $isAdmobAllowed ? '' : 'disabled' ?>>Home Screen (Latest Posts, Categories, Bookmarks and Search results)</label>


                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_admob_bottom_ad_article', 0) == 1 ? 'checked' : '' ?> id="wpdroid_admob_bottom_ad_article" type="checkbox" name="wpdroid_admob_bottom_ad_article" <?php echo $isAdmobAllowed ? '' : 'disabled' ?>>Detailed Article Screen</label>

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_admob_bottom_ad_comments', 0) == 1 ? 'checked' : '' ?> id="wpdroid_admob_bottom_ad_comments" type="checkbox" name="wpdroid_admob_bottom_ad_comments" <?php echo $isAdmobAllowed ? '' : 'disabled' ?>>Comments Screen</label>



                  </td>
                </tr>

                <tr valign="top" style="display: table-row;" class="<?php echo $isBookmarksAllowed ? 'wpdroid_bookmark' : $wpDroidDisableState ?>">
                  <th>Bookmarks</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_allow_bookmarks', 0) == 1 ? 'checked' : '' ?> type="checkbox" name="wpdroid_allow_bookmarks" id="wpdroid_allow_bookmarks" class="wpdroid_checkbox" <?php echo $isBookmarksAllowed ? '' : 'disabled' ?> >Allow users to bookmark articles to read them later</label>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Invite Friends</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_invite_friends', 1) == 1 ? 'checked' : '' ?> id="wpdroid_invite_friends" type="checkbox" name="wpdroid_invite_friends">
                                  This will show invite friends option in Home screen navigation menu
                          </label>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;" class="wpdroid_invite_friends_text_toggle">
                  <th>Invite Friends Text</th>
                  <td>
                    <label class="wpdroid_label">
                          <textarea class="wp_droid_input" id="wpdroid_invite_friends_text" name="wpdroid_invite_friends_text" rows="4" cols="60" placeholder="Let your app users know about your website" maxlenth="200"  ><?php echo get_option('wpdroid_invite_friends_text', wpdroid_DEFAULT_INVITE_FRIENDS_TEXT); ?></textarea>
                        </label>
                  </td>
                </tr>


                <tr>
                  <th>
                  </th>
                  <td>
                    <button type="submit" class="wp_droid_button" name="wp--droid-update">Update Common Settings</button>
                  </td>
                </tr>


              </tbody>
            </table>
          </li>
        </ul>



        <!--  Posts FEED Screen START -->

        <ul class="posts-feed">
          <li class="itemDetail" style="display: list-item;">
            <h2 class="itemTitle">Posts Feed Settings</h2>
            <table class="form-table">
              <tbody>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Show Featured Images On</th>

                  <td class="wpdroid_multiple_checkbox">

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_latest_posts_img_url', 1) == 1 ? 'checked' : '' ?> id="wpdroid_latest_posts_img_url" type="checkbox" name="wpdroid_latest_posts_img_url">Latest Posts</label>

                    <label class="wpdroid_label <?php echo $isCategoriesAllowed ? 'wpdroid_f_i_c_a' : $wpDroidDisableState ?>"><input <?php echo get_option('wpdroid_category_posts_img_url', 1) == 1 ? 'checked' : '' ?> id="wpdroid_category_posts_img_url" type="checkbox" name="wpdroid_category_posts_img_url"
                    <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> >Category Archives</label>

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_search_posts_img_url', 1) == 1 ? 'checked' : '' ?> id="wpdroid_search_posts_img_url" type="checkbox" name="wpdroid_search_posts_img_url">Search Results</label>

                    <label class="wpdroid_label <?php echo $isBookmarksAllowed ? 'wpdroid_f_i_b' : $wpDroidDisableState ?>"><input <?php echo get_option('wpdroid_bookmarked_posts_img_url', 1) == 1 ? 'checked' : '' ?> id="wpdroid_bookmarked_posts_img_url" type="checkbox" name="wpdroid_bookmarked_posts_img_url"
                      <?php echo $isBookmarksAllowed ? '' : 'disabled' ?>>Bookmarked Posts</label>

                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Show Published Date On</th>
                  <td class="wpdroid_multiple_checkbox">

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_latest_posts_published_date', 1) == 1 ? 'checked' : '' ?> id="wpdroid_latest_posts_published_date"  type="checkbox" name="wpdroid_latest_posts_published_date">Latest Posts</label>

                    <label class="wpdroid_label <?php echo $isCategoriesAllowed ? 'wpdroid_s_r_c_a' : $wpDroidDisableState ?>"><input <?php echo get_option('wpdroid_category_posts_published_date', 1) == 1 ? 'checked' : '' ?> id="wpdroid_category_posts_published_date"  type="checkbox" name="wpdroid_category_posts_published_date"
                      <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> >Category Archives</label>

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_search_posts_published_date', 1) == 1 ? 'checked' : '' ?> id="wpdroid_search_posts_published_date"  type="checkbox" name="wpdroid_search_posts_published_date">Search Results</label>

                    <label class="wpdroid_label <?php echo $isBookmarksAllowed ? 'wpdroid_s_r_b' : $wpDroidDisableState ?>"><input <?php echo get_option('wpdroid_bookmarked_posts_published_date', 1) == 1 ? 'checked' : '' ?> id="wpdroid_bookmarked_posts_published_date"  type="checkbox" name="wpdroid_bookmarked_posts_published_date"
                      <?php echo $isBookmarksAllowed ? '' : 'disabled' ?> >Bookmarked Posts</label>


                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Show Author Name On</th>
                  <td class="wpdroid_multiple_checkbox">

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_latest_posts_author_name', 1) == 1 ? 'checked' : '' ?> id="wpdroid_latest_posts_author_name"  type="checkbox" name="wpdroid_latest_posts_author_name">Latest Posts</label>

                    <label class="wpdroid_label <?php echo $isCategoriesAllowed ? 'wpdroid_a_n_c_a' : $wpDroidDisableState ?>"><input <?php echo get_option('wpdroid_category_posts_author_name', 1) == 1 ? 'checked' : '' ?> id="wpdroid_category_posts_author_name"  type="checkbox" name="wpdroid_category_posts_author_name" <?php echo $isCategoriesAllowed ? '' : 'disabled' ?>>Category Archives</label>

                    <label class="wpdroid_label"><input <?php echo get_option('wpdroid_search_posts_author_name', 1) == 1 ? 'checked' : '' ?> id="wpdroid_search_posts_author_name"  type="checkbox" name="wpdroid_search_posts_author_name">Search Results</label>

                    <label class="wpdroid_label <?php echo $isBookmarksAllowed ? 'wpdroid_s_r_b' : $wpDroidDisableState ?>"> <input <?php echo get_option('wpdroid_bookmarked_posts_author_name', 1) == 1 ? 'checked' : '' ?> id="wpdroid_bookmarked_posts_author_name"  type="checkbox" <?php echo $isBookmarksAllowed ? '' : 'disabled' ?> name="wpdroid_bookmarked_posts_author_name">Bookmarked Posts</label>

                  </td>
                </tr>


                <tr>
                  <th scope="row">Date Format In Posts Feed</th>

                  <td>
                    <fieldset id="wpdroid_posts_feed_date_time_format">

                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_posts_feed_date_time_format', "F j, Y") == "F j, Y" ? 'checked' : '' ?> type="radio" value="F j, Y" name="wpdroid_posts_feed_date_time_format" ><?php echo current_time('F j, Y'); ?>
                          </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_posts_feed_date_time_format', "F j, Y") == "F j, Y g:i A" ? 'checked' : '' ?> type="radio" value="F j, Y g:i A" name="wpdroid_posts_feed_date_time_format"><?php echo current_time('F j, Y g:i A'); ?>
                        </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_posts_feed_date_time_format', "F j, Y") == "m/d/Y" ? 'checked' : '' ?> type="radio" value="m/d/Y" name="wpdroid_posts_feed_date_time_format"><?php echo current_time('m/d/Y'); ?>
                        </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_posts_feed_date_time_format', "F j, Y") == "d/m/Y" ? 'checked' : '' ?> type="radio" value="d/m/Y" name="wpdroid_posts_feed_date_time_format"><?php echo current_time('d/m/Y'); ?>
                        </label>

                    </fieldset>
                  </td>
                </tr>



                <tr valign="top" style="display: table-row;">
                  <th scope="row">Latest Posts Layout</th>

                  <td>
                    <fieldset id="wpdroid_latest_posts_template">
                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_latest_posts_template', "top_image") == "top_image" ? 'checked' : '' ?> type="radio" value="top_image" name="wpdroid_latest_posts_template" >Card Layout 1
                          </label>

                      <br>
                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_latest_posts_template', "top_image") == "left_image" ? 'checked' : '' ?> type="radio" value="left_image" name="wpdroid_latest_posts_template">Card Layout 2
                        </label>

                      <br>
                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_latest_posts_template', "top_image") == "flat_top_image" ? 'checked' : '' ?> type="radio" value="flat_top_image" name="wpdroid_latest_posts_template">Flat Layout 1
                          </label>

                      <br>
                      <label class="wpdroid_label">
                              <input <?php echo get_option('wpdroid_latest_posts_template', "top_image") == "flat_right_image" ? 'checked' : '' ?> type="radio" value="flat_right_image" name="wpdroid_latest_posts_template">Flat Layout 2
                            </label>

                    </fieldset>

                  </td>
                </tr>


                <tr valign="top" style="display: table-row;" class="<?php echo $isCategoriesAllowed ? 'wpdroid_c_p_l' : $wpDroidDisableState ?>">
                  <th scope="row">Category Posts Layout</th>

                  <td>
                    <fieldset id="wpdroid_categories_posts_template">
                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_categories_posts_template', "left_image") == "top_image" ? 'checked' : '' ?> type="radio" value="top_image" name="wpdroid_categories_posts_template" <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> >Card Layout 1
                          </label>
                      <br>
                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_categories_posts_template', "left_image") == "left_image" ? 'checked' : '' ?> type="radio" value="left_image" name="wpdroid_categories_posts_template" <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> >Card Layout 2
                        </label>

                      <br>
                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_categories_posts_template', "left_image") == "flat_top_image" ? 'checked' : '' ?> type="radio" value="flat_top_image" name="wpdroid_categories_posts_template" <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> >Flat Layout 1
                          </label>

                      <br>
                      <label class="wpdroid_label">
                              <input <?php echo get_option('wpdroid_categories_posts_template', "left_image") == "flat_right_image" ? 'checked' : '' ?> type="radio" value="flat_right_image" name="wpdroid_categories_posts_template" <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> >Flat Layout 2
                            </label>
                    </fieldset>

                  </td>
                </tr>

                <tr valign="top" style="display: table-row;">
                  <th scope="row">Search Results Layout</th>

                  <td>
                    <fieldset id="wpdroid_search_posts_template">
                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_search_posts_template', "left_image") == "top_image" ? 'checked' : '' ?> type="radio" value="top_image" name="wpdroid_search_posts_template" >Card Layout 1
                          </label>
                      <br>
                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_search_posts_template', "left_image") == "left_image" ? 'checked' : '' ?> type="radio" value="left_image" name="wpdroid_search_posts_template">Card Layout 2
                        </label>

                      <br>

                      <label class="wpdroid_label">
                        <input <?php echo get_option('wpdroid_search_posts_template', "left_image") == "flat_top_image" ? 'checked' : '' ?> type="radio" value="flat_top_image" name="wpdroid_search_posts_template">Flat Layout 1
                      </label>

                      <br>
                      <label class="wpdroid_label">
                        <input <?php echo get_option('wpdroid_search_posts_template', "left_image") == "flat_right_image" ? 'checked' : '' ?> type="radio" value="flat_right_image" name="wpdroid_search_posts_template">Flat Layout 2
                      </label>



                    </fieldset>

                  </td>
                </tr>


                <tr valign="top" style="display: table-row;" class="<?php echo $isBookmarksAllowed ? 'wpdroid_c_p_l' : $wpDroidDisableState ?>">
                  <th scope="row">Bookmarks Layout</th>

                  <td>
                    <fieldset id="wpdroid_bookmarked_posts_template">
                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_bookmarked_posts_template', "left_image") == "top_image" ? 'checked' : '' ?> type="radio" value="top_image" name="wpdroid_bookmarked_posts_template" <?php echo $isBookmarksAllowed ? '' : 'disabled' ?>>Card Layout 1
                          </label>
                      <br>
                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_bookmarked_posts_template', "left_image") == "left_image" ? 'checked' : '' ?> type="radio" value="left_image" name="wpdroid_bookmarked_posts_template" <?php echo $isBookmarksAllowed ? '' : 'disabled' ?>>Card Layout 2
                        </label>



                      <br>
                      <label class="wpdroid_label">
                              <input <?php echo get_option('wpdroid_bookmarked_posts_template', "left_image") == "flat_top_image" ? 'checked' : '' ?> type="radio" value="flat_top_image" name="wpdroid_bookmarked_posts_template" <?php echo $isBookmarksAllowed ? '' : 'disabled' ?>>Flat Layout 1
                            </label>

                      <br>
                      <label class="wpdroid_label">
                                <input <?php echo get_option('wpdroid_bookmarked_posts_template', "left_image") == "flat_right_image" ? 'checked' : '' ?> type="radio" value="flat_right_image" name="wpdroid_bookmarked_posts_template" <?php echo $isBookmarksAllowed ? '' : 'disabled' ?>>Flat Layout 2
                              </label>
                    </fieldset>

                  </td>
                </tr>

                <tr>
                  <th>
                  </th>
                  <td>
                    <button type="submit" class="wp_droid_button" name="wp--droid-update">Update Posts Feed</button>
                  </td>
                </tr>


              </tbody>
            </table>
          </li>
        </ul>


        <!--  Posts FEED Screen END -->


        <!--  Detailed Article Screen START -->

        <ul class="article-screen">

          <li class="itemDetail" style="display: list-item;">
            <h2 class="itemTitle">Detailed Article Screen</h2>
            <table class="form-table">
              <tbody>


                <tr>
                  <th scope="row">Open Article in</th>

                  <td>
                    <fieldset id="wpdroid_article_open_screen">

                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_article_open_screen', "wpdroid") == "wpdroid" ? 'checked' : '' ?> type="radio" value="wpdroid" name="wpdroid_article_open_screen" >Within the app
                          </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_article_open_screen', "wpdroid") == "browser" ? 'checked' : '' ?> type="radio" value="browser" name="wpdroid_article_open_screen">InApp Web Browser<span style="color:red;font-size:0.9em;font-style:italic"> (Use this you are using pagebuilders to align your articles)</span>
                        </label>


                    </fieldset>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Featured Image</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_article_featured_image', 1) == 1 ? 'checked' : '' ?> id="wpdroid_article_featured_image" type="checkbox" name="wpdroid_article_featured_image">
                                  This will show the featured image below the article title
                          </label>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Author Name</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_article_author_name', 1) == 1 ? 'checked' : '' ?> id="wpdroid_article_author_name" type="checkbox" name="wpdroid_article_author_name">
                          This will show the name of article author below the post title.
                          </label>
                  </td>
                </tr>

                <tr valign="top" style="display: table-row;" class="<?php echo $isCategoriesAllowed ? 'wpdroid_c_p_l' : $wpDroidDisableState ?>">
                  <th scope="row">Category Name</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_article_show_category', 0) == 1 ? 'checked' : '' ?> <?php echo $isCategoriesAllowed ? '' : 'disabled' ?> id="wpdroid_article_show_category" type="checkbox" name="wpdroid_article_show_category">
                          This will show main category name at the end of article. User can click it to see all posts from category
                          </label>
                  </td>
                </tr>

                <tr valign="top" style="display: table-row;">
                  <th scope="row">Internal Links</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_url-to-id', 1) == 1 ? 'checked' : '' ?> id="wpdroid_url-to-id"  type="checkbox" name="wpdroid_url-to-id">
                          This will open internal article links as new detailed article screen instead of web browser
                          </label>
                  </td>
                </tr>

                <tr>
                  <th scope="row">Date and Time format</th>

                  <td>
                    <fieldset id="wpdroid_article_date_time_format">

                      <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_article_date_time_format', "F j, Y") == "F j, Y" ? 'checked' : '' ?> type="radio" value="F j, Y" name="wpdroid_article_date_time_format" ><?php echo current_time('F j, Y'); ?>
                          </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_article_date_time_format', "F j, Y") == "F j, Y g:i A" ? 'checked' : '' ?> type="radio" value="F j, Y g:i A" name="wpdroid_article_date_time_format"><?php echo current_time('F j, Y g:i A'); ?>
                        </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_article_date_time_format', "F j, Y") == "m/d/Y" ? 'checked' : '' ?> type="radio" value="m/d/Y" name="wpdroid_article_date_time_format"><?php echo current_time('m/d/Y'); ?>
                        </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_article_date_time_format', "F j, Y") == "d/m/Y" ? 'checked' : '' ?> type="radio" value="d/m/Y" name="wpdroid_article_date_time_format"><?php echo current_time('d/m/Y'); ?>
                        </label>

                      <br>

                      <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_article_date_time_format', "F j, Y") == "hide_date_time" ? 'checked' : '' ?> type="radio" value="hide_date_time" name="wpdroid_article_date_time_format">Hide date and time
                        </label>

                    </fieldset>
                  </td>
                </tr>


                <tr valign="top" style="display: table-row;">
                  <th scope="row">Report Error</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_report_error', 1) == 1 ? 'checked' : '' ?> id="wpdroid_report_error"  type="checkbox" name="wpdroid_report_error">
                          This will show an option to report errors in the article. Report will be sent to <?php echo get_option('admin_email'); ?>
                          </label>
                  </td>
                </tr>

                <tr valign="top" style="display: table-row;">
                  <th scope="row">Copy Post Link</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_copy_post_link', 1) == 1 ? 'checked' : '' ?> id="wpdroid_copy_post_link"  type="checkbox" name="wpdroid_copy_post_link">
                          This will show an option to copy the post URL to clipboard
                          </label>
                  </td>
                </tr>

                <tr valign="top" style="display: table-row;">
                  <th scope="row">Open In Browser</th>
                  <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_open_in_browser', 1) == 1 ? 'checked' : '' ?> id="wpdroid_open_in_browser"  type="checkbox" name="wpdroid_open_in_browser">
                          This will show an option to open the article in external web browser
                          </label>
                  </td>
                </tr>

                <tr>
                  <th></th>
                  <td>
                    <button type="submit" class="wp_droid_button" name="wp--droid-update">Update Article Screen</button>
                  </td>
                </tr>

                <td class="related-posts">
                  <h3>Related Posts</h3></td>
                <td>
                </td>
                </tr>

              </tbody>
            </table>

            <div class="<?php echo $isRelatedPostsAllowed ? 'wpdroid_r_p' : $wpDroidDisableState ?> before-content">

              <table class="form-table">
                <tbody>

                  <tr valign="top" style="display: table-row;">
                    <th>Show Related Posts</th>
                    <td>
                      <label class="wpdroid_label"><input <?php echo get_option('wpdroid_show_related_posts', 1) == 1 ? 'checked' : '' ?> type="checkbox" name="<?php echo $isRelatedPostsAllowed ? 'wpdroid_show_related_posts' : 'wpdroid_show_related_posts_not_allowed' ?>" id="<?php echo $isRelatedPostsAllowed ? 'wpdroid_show_related_posts' : 'wpdroid_show_related_posts_not_allowed' ?>"
                        <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>This will show related posts at the end of article
                         </label>
                    </td>
                  </tr>

                  <tr class="wpdroid_related_posts_toggle" valign="top" style="display: table-row;">
                    <th scope="row">Show Related Posts Based On</th>

                    <td>
                      <fieldset id="wpdroid_related_posts_based_on">
                        <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_related_posts_based_on', "categories") == "categories" ? 'checked' : '' ?> type="radio" value="categories" name="wpdroid_related_posts_based_on" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Categories
                          </label>
                        <br>
                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_posts_based_on', "categories") == "tags" ? 'checked' : '' ?> type="radio" value="tags" name="wpdroid_related_posts_based_on" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Tags
                        </label>
                      </fieldset>

                    </td>
                  </tr>


                  <tr class="wpdroid_related_posts_toggle" valign="top" style="display: table-row;">
                    <th scope="row">Related Posts Count</th>
                    <td>
                      <input class="wp_droid_input" value="<?php echo get_option('wpdroid_related_posts_count', 3) ?>" id="wpdroid_related_posts_count" type="number" name="wpdroid_related_posts_count" maxlength="10" min="3" max="10" <?php echo $isRelatedPostsAllowed ? '' :
                        'disabled' ?>/>
                      <p>Recommended is between <code>3</code> and <code>5</code>. Showing more related posts will slow down the app</p>
                    </td>
                  </tr>

                  <tr class="wpdroid_related_posts_toggle" valign="top" style="display: table-row;">
                    <th scope="row">Related Posts Style</th>

                    <td>
                      <fieldset id="wpdroid_related_posts_style">
                        <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_related_posts_style', "top_image") == "top_image" ? 'checked' : '' ?> type="radio" value="top_image" name="wpdroid_related_posts_style" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Card Layout 1
                          </label>
                        <br>
                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_posts_style', "top_image") == "left_image" ? 'checked' : '' ?> type="radio" value="left_image" name="wpdroid_related_posts_style" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Card Layout 2
                        </label>

                        <br>
                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_posts_style', "top_image") == "flat_top_image" ? 'checked' : '' ?> type="radio" value="flat_top_image" name="wpdroid_related_posts_style" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Flat Layout 1
                        </label>

                        <br>
                        <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_related_posts_style', "top_image") == "flat_right_image" ? 'checked' : '' ?> type="radio" value="flat_right_image" name="wpdroid_related_posts_style" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Flat Layout 2
                          </label>
                      </fieldset>

                    </td>
                  </tr>


                  <tr class="wpdroid_related_posts_toggle" valign="top" style="display: table-row;">
                    <th scope="row">Scroll Direction</th>

                    <td>
                      <fieldset id="wpdroid_related_posts_scroll_position">
                        <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_related_posts_scroll_position', "horizontal") == "horizontal" ? 'checked' : '' ?> type="radio" value="horizontal" name="wpdroid_related_posts_scroll_position" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Horizontal Scrolling
                          </label>
                        <br>
                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_posts_scroll_position', "horizontal") == "vertical" ? 'checked' : '' ?> type="radio" value="vertical" name="wpdroid_related_posts_scroll_position" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Vertical Scrolling
                        </label>
                      </fieldset>

                    </td>
                  </tr>

                  <tr class="wpdroid_related_posts_toggle" valign="top" style="display: table-row;">
                    <th scope="row">Featured Image</th>
                    <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_related_posts_featured_image', 1) == 1 ? 'checked' : '' ?> id="wpdroid_related_posts_featured_image" type="checkbox" name="wpdroid_related_posts_featured_image" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>This will show the featured image in related posts
                          </label>
                    </td>
                  </tr>



                  <tr class="wpdroid_related_posts_toggle" valign="top" style="display: table-row;">
                    <th scope="row">Author Name</th>
                    <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_related_post_author_name', 1) == 1 ? 'checked' : '' ?> id="wpdroid_related_post_author_name" type="checkbox" name="wpdroid_related_post_author_name" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>This will show the author name in related posts
                          </label>
                    </td>
                  </tr>


                  <tr class="wpdroid_related_posts_toggle">
                    <th scope="row">Date Format</th>

                    <td>
                      <fieldset id="wpdroid_related_post_date_time_format">

                        <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_related_post_date_time_format', "F j, Y") == "F j, Y" ? 'checked' : '' ?> type="radio" value="F j, Y" name="wpdroid_related_post_date_time_format" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?> ><?php echo current_time('F j, Y'); ?>
                          </label>

                        <br>

                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_post_date_time_format', "F j, Y") == "F j, Y g:i A" ? 'checked' : '' ?> type="radio" value="F j, Y g:i A" name="wpdroid_related_post_date_time_format" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>><?php echo current_time('F j, Y g:i A'); ?>
                        </label>

                        <br>

                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_post_date_time_format', "F j, Y") == "m/d/Y" ? 'checked' : '' ?> type="radio" value="m/d/Y" name="wpdroid_related_post_date_time_format" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>><?php echo current_time('m/d/Y'); ?>
                        </label>

                        <br>

                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_post_date_time_format', "F j, Y") == "d/m/Y" ? 'checked' : '' ?> type="radio" value="d/m/Y" name="wpdroid_related_post_date_time_format" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>><?php echo current_time('d/m/Y'); ?>
                        </label>

                        <br>

                        <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_related_post_date_time_format', "F j, Y") == "hide_date_time" ? 'checked' : '' ?> type="radio" value="hide_date_time" name="wpdroid_related_post_date_time_format" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Hide date and time in related posts
                        </label>

                      </fieldset>

            </div>
            </td>
            </tr>

            <tr>
              <th></th>
              <td>
                <button type="submit" class="wp_droid_button" name="wp--droid-update" <?php echo $isRelatedPostsAllowed ? '' : 'disabled' ?>>Update Related Posts</button>
              </td>
            </tr>

            </tbody>
            </table>
    </div>




    </li>
    </ul>


    <!--  Detailed Article Screen END -->


    <!--  Comments Screen START -->

    <ul class="comments-screen">
      <li class="itemDetail" style="display: list-item;">
        <h2 class="itemTitle">Comments Screen</h2>
        <table class="form-table <?php echo $isCommentsAllowed ? 'wpdroid_comments' : $wpDroidDisableState ?> before-content">
          <tbody>


            <tr valign="top" style="display: table-row;">
              <th scope="row">Enable Comments</th>
              <td><label class="wpdroid_label"><input <?php echo get_option('wpdroid_allow_comments', 1) == 1 ? 'checked' : '' ?> id="wpdroid_allow_comments" type="checkbox" name="wpdroid_allow_comments" <?php echo $isCommentsAllowed ? '' : 'disabled' ?>
              >
                          Users can comment from the app. Comment approvals depends on discussion settings of your website. <code>Currently WP Droid supports only WordPress default commenting system</code>
                          </label>
              </td>
            </tr>


            <tr class="wpdroid_comments_toggle">
              <th scope="row">Date Format</th>

              <td>
                <fieldset id="wpdroid_comments_date_time_format">

                  <label class="wpdroid_label">
                            <input <?php echo get_option('wpdroid_comments_date_time_format', "F j, Y") == "F j, Y" ? 'checked' : '' ?> type="radio" value="F j, Y" name="wpdroid_comments_date_time_format"
                            <?php echo $isCommentsAllowed ? '' : 'disabled' ?> > <?php echo current_time('F j, Y'); ?>
                          </label>

                  <br>

                  <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_comments_date_time_format', "F j, Y") == "F j, Y g:i A" ? 'checked' : '' ?> type="radio" value="F j, Y g:i A" name="wpdroid_comments_date_time_format" <?php echo $isCommentsAllowed ? '' : 'disabled' ?> ><?php echo current_time('F j, Y g:i A'); ?>
                        </label>

                  <br>

                  <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_comments_date_time_format', "F j, Y") == "m/d/Y" ? 'checked' : '' ?> type="radio" value="m/d/Y" name="wpdroid_comments_date_time_format" <?php echo $isCommentsAllowed ? '' : 'disabled' ?> ><?php echo current_time('m/d/Y'); ?>
                        </label>

                  <br>

                  <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_comments_date_time_format', "F j, Y") == "d/m/Y" ? 'checked' : '' ?> type="radio" value="d/m/Y" name="wpdroid_comments_date_time_format" <?php echo $isCommentsAllowed ? '' : 'disabled' ?> ><?php echo current_time('d/m/Y'); ?>
                        </label>

                  <br>

                  <label class="wpdroid_label">
                          <input <?php echo get_option('wpdroid_comments_date_time_format', "F j, Y") == "hide_date_time" ? 'checked' : '' ?> type="radio" value="hide_date_time" name="wpdroid_comments_date_time_format" <?php echo $isCommentsAllowed ? '' : 'disabled' ?> >Hide date and time
                        </label>

                </fieldset>
              </td>
            </tr>



            <tr>
              <th></th>
              <td>
                <button type="submit" <?php echo $isCommentsAllowed ? '' : 'disabled' ?> class="wp_droid_button" name="wp--droid-update">Update Comments Screen</button>
              </td>
            </tr>


          </tbody>
        </table>
      </li>
    </ul>



    <!-- ABOUT SCREEN START -->


    <ul class="about-screen">
      <li class="itemDetail" style="display: list-item;">
        <h2 class="itemTitle">About Screen</h2>
        <table class="form-table <?php echo $isAboutAllowed ? 'wpdroid_about' : $wpDroidDisableState ?> before-content">
          <tbody>

            <tr valign="top" style="display: table-row;">
              <th>About Your Website</th>
              <td>
                <textarea class="wp_droid_input" id="wp_droid_about_website" name="wp_droid_about_website" rows="6" cols="60" placeholder="Let your app users know about your website" maxlenth="1000" <?php echo $isAboutAllowed ? '' : 'disabled' ?>><?php echo get_option('wp_droid_about_website', get_bloginfo('description')); ?></textarea>
              </td>
            </tr>

            <tr valign="top" style="display: table-row;">
              <th>Read More Link</th>
              <td>
                <input type="text" size="60" name="wp_droid_about_read_more" class="wp_droid_input" id="wp_droid_about_read_more" placeholder="Link to your about page" value="<?php echo get_option('wp_droid_about_read_more', ''); ?>" <?php echo $isAboutAllowed ? '' :
                  'disabled' ?> />
                <p>Read more button will be shown and clicking it will redirect to your About page. Leave it blank to remove the button</p>
              </td>
            </tr>

            <td>
              <h3>Contact Details</h3></td>
            <td>
            </td>
            </tr>

            <th>Email Address</th>
            <td>
              <input type="text" size="60" name="wp_droid_about_email" class="wp_droid_input" id="wp_droid_about_email" placeholder="Official email address" value="<?php echo get_option('wp_droid_about_email', get_bloginfo('admin_email')); ?>" <?php echo $isAboutAllowed
                ? '' : 'disabled' ?>>

            </td>
            </tr>

            <th>Phone Number</th>
            <td>
              <input type="text" size="60" name="wp_droid_about_phone" class="wp_droid_input" id="wp_droid_about_phone" placeholder="Phone number (Optional)" value="<?php echo get_option('wp_droid_about_phone', ''); ?>" <?php echo $isAboutAllowed ? '' : 'disabled'
                ?>>

            </td>
            </tr>

            <td>
              <h3>Social Media Links</h3></td>
            <td>
            </td>
            </tr>

            <th>Facebook</th>
            <td>
              <input type="text" size="60" name="wp_droid_social_facebook" class="wp_droid_input wp_droid_about_placeholders" id="wp_droid_social_facebook" value="<?php echo get_option('wp_droid_social_facebook', ''); ?>" placeholder="https://www.facebook.com/your_username"
                <?php echo $isAboutAllowed ? '' : 'disabled' ?>/>


            </td>
            </tr>

            <th>Twitter</th>
            <td>
              <input type="text" size="60" name="wp_droid_social_twitter" class="wp_droid_input wp_droid_about_placeholders" id="wp_droid_social_twitter" value="<?php echo get_option('wp_droid_social_twitter', ''); ?>" placeholder="https://twitter.com/your_username"
                <?php echo $isAboutAllowed ? '' : 'disabled' ?>/>

            </td>
            </tr>


            <th>Google Plus</th>
            <td>
              <input type="text" size="60" name="wp_droid_social_google_plus" class="wp_droid_input wp_droid_about_placeholders" id="wp_droid_social_google_plus" value="<?php echo get_option('wp_droid_social_google_plus', ''); ?>" placeholder="https://plus.google.com/+your_username"
                <?php echo $isAboutAllowed ? '' : 'disabled' ?>/>

            </td>
            </tr>


            <th>YouTube</th>
            <td>
              <input type="text" size="60" name="wp_droid_social_youtube" class="wp_droid_input wp_droid_about_placeholders" id="wp_droid_social_youtube" value="<?php echo get_option('wp_droid_social_youtube', ''); ?>" placeholder="http://youtube.com/your_username"
                <?php echo $isAboutAllowed ? '' : 'disabled' ?>/>

            </td>
            </tr>


            <th>Instagram</th>
            <td>
              <input type="text" size="60" name="wp_droid_social_instagram" class="wp_droid_input wp_droid_about_placeholders" id="wp_droid_social_instagram" value="<?php echo get_option('wp_droid_social_instagram', ''); ?>" placeholder="https://www.instagram.com/your_username"
                <?php echo $isAboutAllowed ? '' : 'disabled' ?>/>

            </td>
            </tr>


            <th>LinkedIn</th>
            <td>
              <input type="text" size="60" name="wp_droid_social_linkedin" class="wp_droid_input wp_droid_about_placeholders" id="wp_droid_social_linkedin" value="<?php echo get_option('wp_droid_social_linkedin', ''); ?>" placeholder="https://www.linkedin.com/in/your_username"
                <?php echo $isAboutAllowed ? '' : 'disabled' ?>/>
            </td>
            </tr>

            <tr>
              <th>
              </th>
              <td>
                <button type="submit" class="wp_droid_button" name="wp--droid-update" <?php echo $isAboutAllowed ? '' : 'disabled' ?> >Update About Screen</button>
              </td>
            </tr>


          </tbody>
        </table>
      </li>
    </ul>


    <!-- ABOUT SCREEN END -->



    </form>

  </div>

  <div class="rightColumn">
    <div class="rightColumn promotions">

        <div style="margin-top: 2em;"></div>

          <div class="wpdroid_customizer_menu">
            <div onclick="wpDroidSmoothScroll('common-settings')">Common</div>
            <div onclick="wpDroidSmoothScroll('posts-feed')">Posts Feed</div>
            <div onclick="wpDroidSmoothScroll('article-screen')">Article Screen</div>
            <div onclick="wpDroidSmoothScroll('related-posts')">Related Posts</div>
            <div onclick="wpDroidSmoothScroll('comments-screen')">Comments</div>
            <div onclick="wpDroidSmoothScroll('about-screen')">About</div>
          </div>


        <?php include(WP_DROID_PLUGIN_DIR . '/includes/helpers/sidebar-common.php'); ?>


    </div>

  </div>

  </div>


  <script type="text/javascript">
    jQuery(document).ready(function($) {


      var isBookmarksAllowed = <?php echo get_option('wp_license_droid_bookmarks', 0); ?>;
      var isAboutAllowed = <?php echo get_option('wp_license_droid_about', 0); ?>;
      var isAdmobAllowed = <?php echo get_option('wp_license_droid_admob', 0); ?>;
      var isAnalyticsAllowed = <?php echo get_option('wp_license_droid_analytics', 0); ?>;
      var isNotificationsAllowed = <?php echo get_option('wp_license_droid_pushnotifications', 0); ?>;
      var isCommentsAllowed = <?php echo get_option('wp_license_droid_comments', 0); ?>;
      var isCategoriesAllowed = <?php echo get_option('wp_license_droid_categories', 0); ?>;
      var isCategoriesAllowed = <?php echo get_option('wp_license_droid_categories', 0); ?>;


    });
  </script>


  <!-- SETTINGS ENDED -->

  <?php
  }
