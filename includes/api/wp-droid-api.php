<?php

/**
 * Creating wp_droid JSON Object to append custom keys and values depending on user settings
 */

add_action('rest_api_init', 'wpdroid_register_custom_fields');

function wpdroid_register_custom_fields()
{
    register_rest_field(
        'post',
        'wp_droid',
        array(
            'get_callback'    => 'wpdroid_register_custom_fields_callback',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

/**
 * call back function which performs heavy logic to append 'wp_droid' JSON object in lists posts response
 */

function wpdroid_register_custom_fields_callback($object, $field_name, $request)
{

    // $_data = $data->data;
    $params = $request->get_params();

    if (isset($params['wpdroid'])) {
        if ($params['wpdroid'] == "true") {
            $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            $url_parts = parse_url($current_url);
            $constructed_url = '//' . $url_parts['host'] . $url_parts['path'];

            $isSettingsOverride = wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_override_settings', "unchecked");
            $wpDroidFields['override'] = $isSettingsOverride;

            $isValidLicense = get_option('wp_license_valid_droid', 0);

            if (isset($params['offset'])) {
                $shouldShowExtraDetails = $params['offset'] == 0;
            } else {
                $shouldShowExtraDetails = false;
            }

            //Detailed POST
            if (preg_match('/posts\/[\s\S]*\d$/', $constructed_url)) {

                //COMMENTS START
                if ($isValidLicense && get_option('wp_license_droid_comments', 0)) {
                    if ($isSettingsOverride) {
                        $wpDroidFields['comments'] = wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_comments', 'checked');
                    } else {
                        $wpDroidFields['comments'] = get_option('wpdroid_allow_comments', 0) == 0 ? false : true;
                    }
                } else {
                    $wpDroidFields['comments'] = false;
                }


                //FEATURED IMAGE START
                $isFeaturedImageAllowed = true;
                if ($isSettingsOverride) {
                    if (!wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_featured_image_article', 'checked')) {
                        $isFeaturedImageAllowed = false;
                    }
                } else {
                    $isFeaturedImageAllowed = get_option('wpdroid_article_featured_image', 1);
                }

                if ($isFeaturedImageAllowed) {
                    $medium = wp_get_attachment_image_src(get_post_thumbnail_id($object['id']), 'medium');
                    $medium_url = $medium['0'] == null ? "" : $medium['0'];

                    $wpDroidFields['featured_image'] = $medium_url;
                }

                //FEATURED IMAGE END


                //AUTHOR NAME START
                $isAuthorNameAllowed = true;
                if ($isSettingsOverride) {
                    if (!wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_author_name_article', 'checked')) {
                        $isAuthorNameAllowed = false;
                    }
                } else {
                    $isAuthorNameAllowed = get_option('wpdroid_article_author_name', 1);
                }

                if ($isAuthorNameAllowed) {
                    $wpDroidFields['author_name'] = get_the_author_meta('display_name', get_post_field('post_author', $object['id']));
                }

                // AUTHOR NAME END


                //DATE TIME START
                $isDateTimeAllowed = 'yes';
                if ($isSettingsOverride) {
                    if (!wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_date_time_article', 'checked')) {
                        $isDateTimeAllowed = 'hide_date_time';
                    }
                } else {
                    $isDateTimeAllowed = get_option('wpdroid_article_date_time_format', "F j, Y");
                }

                if ($isDateTimeAllowed != 'hide_date_time') {
                    $wpDroidFields['date_time'] = get_the_date(get_option('wpdroid_article_date_time_format', "F j, Y"), $object['id']);
                }

                //DATE TIME END


                // RELATED POSTS START






                //Related Posts

                $isRelatedPostsAllowed = true;


                if ($isValidLicense && get_option('wp_license_droid_related_posts', 0)) {
                    if ($isSettingsOverride) {
                        if (!wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_related_posts', 'checked')) {
                            $isRelatedPostsAllowed = false;
                        }
                    } else {
                        $isRelatedPostsAllowed = get_option('wpdroid_show_related_posts', 0) == 1;
                    }
                    $wpDroidFields['is_related_posts_allowed'] = true;
                } else {
                    $isRelatedPostsAllowed = false;
                    $wpDroidFields['is_related_posts_allowed'] = false;
                }



                if ($isRelatedPostsAllowed) {
                    require_once(WP_DROID_PLUGIN_DIR . '/includes/helpers/related-posts.php');

                    $WPDroidRelatedPosts = new WPDroidRelatedPosts();
                    $WPDroidRelatedPosts->setPostId(get_the_ID($object['id']));

                    if (get_option('wpdroid_related_posts_based_on', "categories") == 'categories') {
                        $relatedPosts['related_posts_based_on'] = 'categories';
                    } else {
                        $relatedPosts['related_posts_based_on'] = 'tags';
                    }

                    $relatedPosts['related_posts_style'] = get_option('wpdroid_related_posts_style', 'top_image');
                    $relatedPosts['scroll_direction'] = get_option('wpdroid_related_posts_scroll_position', 'horizontal');

                    $relatedPosts['posts'] = $WPDroidRelatedPosts->getRelatedPosts();

                    $wpDroidFields['related_posts'] = $relatedPosts;
                }

                // RELATED POSTS END


                // ADMOB Bottom Ad START

                if ($isValidLicense && get_option('wp_license_droid_admob', 0)) {
                    if ($isSettingsOverride) {
                        if (wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_ad_mob_bottom_ad', 'checked')) {
                            $wpDroidFields['admob_bottom_banner'] = get_option('wpdroid_admob_banner_ad_unit_id', '');
                        }
                    } else {
                        if (get_option('wpdroid_admob_bottom_ad_article', 0)) {
                            $wpDroidFields['admob_bottom_banner'] = get_option('wpdroid_admob_banner_ad_unit_id', '');
                        }
                    }
                }

                // ADMOB Bottom Ad END


                $isReportError = get_option('wpdroid_report_error', 1) == 1 ? true : false;

                if ($isReportError) {
                    $wpDroidFields['report_error_email'] = get_option('admin_email');
                }

                $wpDroidFields['copy_to_clipboard'] = get_option('wpdroid_copy_post_link', 1) == 1 ? true : false;
                $wpDroidFields['open_in_browser'] = get_option('wpdroid_open_in_browser', 1) == 1 ? true : false;


                if ($isValidLicense && get_option('wp_license_droid_categories', 0)) {
                    if (get_option('wpdroid_article_show_category', 0) == 1) {
                        $wpDroidpostCat = get_the_category($object['id'])[0];

                        $wp_droid_category_details['name'] = $wpDroidpostCat->name;
                        $wp_droid_category_details['id'] = $wpDroidpostCat->cat_ID;
                        $wp_droid_category_details['count'] = $wpDroidpostCat->count;

                        $wpDroidFields['category'] = $wp_droid_category_details;
                    }
                }


                $wpDroidFields['internal_links'] = get_option('wpdroid_url-to-id', 1) == 1 ? true : false;

                // APP CSS
                $app_css = preg_replace('/\s+/', '', get_option('wpdroid_app_custom_css', wpdroid_DEFAULT_APP_CSS));
                $wpDroidFields['app_css'] = $app_css;
            }

            // LIST POSTS

            else {
                if (isset($params['search'])) { //Search Start

                    //Featured Image
                    if (get_option('wpdroid_search_posts_img_url', 1) && !$isSettingsOverride) {
                        $medium = wp_get_attachment_image_src(get_post_thumbnail_id($object['id']), 'medium');
                        $medium_url = $medium['0'] == null ? "" : $medium['0'];

                        $wpDroidFields['featured_image'] = $medium_url;
                    }


                    //Date Time
                    if (get_option('wpdroid_search_posts_published_date', 1) && !($isSettingsOverride)) {
                        $wpDroidFields['date_time'] = get_the_date(get_option('wpdroid_posts_feed_date_time_format', "F j, Y"), $object['id']);
                    }


                    //Author Name
                    if (get_option('wpdroid_search_posts_author_name', 1) && !($isSettingsOverride)) {
                        $wpDroidFields['author_name'] = get_the_author_meta('display_name', get_post_field('post_author', $object['id']));
                    }

                    //Layout Style
                    if ($isSettingsOverride) {
                    } else {
                        $wpDroidFields['layout_style'] = get_option('wpdroid_search_posts_template', "left_image");
                    }
                } //SEARCH END



                elseif (isset($params['categories']) && !empty($params['categories'])) { //Category


                    //Featured Image
                    if (get_option('wpdroid_category_posts_img_url', 1) && !($isSettingsOverride)) {
                        $medium = wp_get_attachment_image_src(get_post_thumbnail_id($object['id']), 'medium');
                        $medium_url = $medium['0'] == null ? "" : $medium['0'];

                        $wpDroidFields['featured_image'] = $medium_url;
                    }


                    //Date Time
                    if (get_option('wpdroid_category_posts_published_date', 1) && !($isSettingsOverride)) {
                        $wpDroidFields['date_time'] = get_the_date(get_option('wpdroid_posts_feed_date_time_format', "F j, Y"), $object['id']);
                    }


                    //Author Name
                    if (get_option('wpdroid_category_posts_author_name', 1) && !($isSettingsOverride)) {
                        $wpDroidFields['author_name'] = get_the_author_meta('display_name', get_post_field('post_author', $object['id']));
                    }

                    //Layout Style
                    if (!$isSettingsOverride) {
                        $wpDroidFields['layout_style'] = get_option('wpdroid_categories_posts_template', "left_image");
                    }
                } //Category END


                else { //Default List Posts Start


                    //Featured Image
                    if (get_option('wpdroid_latest_posts_img_url', 1) && !($isSettingsOverride)) {
                        $medium = wp_get_attachment_image_src(get_post_thumbnail_id($object['id']), 'medium');
                        $medium_url = $medium['0'] == null ? "" : $medium['0'];

                        $wpDroidFields['featured_image'] = $medium_url;
                    }


                    //Date Time
                    if (get_option('wpdroid_latest_posts_published_date', 1) && !($isSettingsOverride)) {
                        $wpDroidFields['date_time'] = get_the_date(get_option('wpdroid_posts_feed_date_time_format', "F j, Y"), $object['id']);
                    }


                    //Author Name
                    if (get_option('wpdroid_latest_posts_author_name', 1) && !($isSettingsOverride)) {
                        $wpDroidFields['author_name'] = get_the_author_meta('display_name', get_post_field('post_author', $object['id']));
                    }

                    //Layout Style
                    if ($isSettingsOverride) {
                    } else {
                        $wpDroidFields['layout_style'] = get_option('wpdroid_latest_posts_template', "top_image");
                    }
                } //Default List Posts END


                //OPEN IN WEB BROWSER START
                if ($isSettingsOverride) {
                    $isInWebBrowser = wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_web_browser', 'unchecked');
                } else {
                    $isInWebBrowser = get_option('wpdroid_article_open_screen', "wpdroid") == "wpdroid" ? false : true;
                }

                $wpDroidFields['in_browser'] = $isInWebBrowser;

                if ($isInWebBrowser) {
                    $wpDroidFields['url'] =  get_permalink($object['id']);
                }


                //OPEN IN WEB BROWSER END


                //Settings Overrite common for all

                if ($isSettingsOverride) {

                  //Exclude posts START
                    if (wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_exclude_post', 'unchecked')) {
                        $wpDroidFields['is_post_excluded'] = true;
                    } else {
                        $wpDroidFields['is_post_excluded'] = false;
                    }

                    //Exclude posts END

                    // Featured Image Start
                    if (wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_featured_image_feed', 'checked')) {
                        $medium = wp_get_attachment_image_src(get_post_thumbnail_id($object['id']), 'medium');
                        $medium_url = $medium['0'] == null ? "" : $medium['0'];

                        $wpDroidFields['featured_image'] = $medium_url;
                    }

                    // Featured Image END


                    // Author Name Start
                    if (wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_author_name_feed', 'checked')) {
                        $wpDroidFields['author_name'] = get_the_author_meta('display_name', get_post_field('post_author', $object['id']));
                    }

                    // Author Name End



                    // Date Time Start
                    if (wpdroid_meta_box_isChecked($object['id'], 'wpdroid_meta_date_time_feed', 'checked')) {
                        $wpDroidFields['date_time'] = get_the_date(get_option('wpdroid_posts_feed_date_time_format', "F j, Y"), $object['id']);
                    }

                    // Date Time End

                    // Layout Style Start
                    $wpDroidFields['layout_style'] = wpdroid_get_post_meta_value($object['id'], 'wpdroid_meta_layout_style', 'top_image');

                // Layout Style END
                } else {

                  //Excluded post common for all
                    $excludedPosts = get_option('wpdroid_exclude_posts', '');
                    $excluded_post_id = explode(',', $excludedPosts);
                    $wpDroidFields['is_post_excluded'] = in_array(get_the_ID($object['id']), $excluded_post_id);
                }

                if ($shouldShowExtraDetails) {
                    //Invite friends - common for all (TRY TO MOVE OUT OF ARRAY)
                    if ((get_option('wpdroid_invite_friends', 1) == 1)) {
                        $wpDroidFields['invite_friends'] = get_option('wpdroid_invite_friends_text', wpdroid_DEFAULT_INVITE_FRIENDS_TEXT);
                    }

                    //BOOKMARKS DETAILS ----- START


                    //Featured Image
                    if (get_option('wpdroid_bookmarked_posts_img_url', 1)) {
                        $wpDroidFields['bookmark_featured_image'] = true;
                    }


                    //Date Time
                    if (get_option('wpdroid_bookmarked_posts_published_date', 1)) {
                        $wpDroidFields['bookmark_date_time'] = true;
                    }


                    //Author Name
                    if (get_option('wpdroid_bookmarked_posts_author_name', 1)) {
                        $wpDroidFields['bookmark_author_name'] = true;
                    }

                    //Layout Style
                    $wpDroidFields['bookmark_layout_style'] = get_option('wpdroid_bookmarked_posts_template', "left_image");



                    //BOOKMARKS DETAILS ----- END


                    //Posts LOAD LIMIT
                    $wpDroidFields['posts_limit'] = get_option('wpdroid_posts_load_count', 5);


                    //About
                    if ($isValidLicense && get_option('wp_license_droid_about', 0)) {
                        $wpDroidFields['is_about_allowed'] = true;
                    } else {
                        $wpDroidFields['is_about_allowed'] = false;
                    }

                    //Notifications
                    if ($isValidLicense && get_option('wp_license_droid_pushnotifications', 0)) {
                        $wpDroidFields['is_notifications_allowed'] = true;
                        $wpDroidFields['notification_id'] = get_option('wpdroid_one_signal_app_id', '');
                    } else {
                        $wpDroidFields['is_notifications_allowed'] = false;
                    }

                    //Google Analytics ID
                    if ($isValidLicense && get_option('wp_license_droid_analytics', 0)) {
                        $wpDroidFields['is_google_analytics_allowed'] = true;
                        $wpDroidFields['google_analytics'] = get_option('wpdroid_google_analytics_id', '');
                    } else {
                        $wpDroidFields['is_google_analytics_allowed'] = false;
                    }
                }
            }


            if ($shouldShowExtraDetails) {


              //Categories
              if ($isValidLicense && get_option('wp_license_droid_categories', 0)) {
                  $wpDroidFields['is_categories_allowed'] = true;
              } else {
                  $wpDroidFields['is_categories_allowed'] = false;
              }



                //ADMOB
                if ($isValidLicense && get_option('wp_license_droid_admob', 0)) {
                    if (get_option('wpdroid_admob_bottom_ad_home', 0)) {
                        $wpDroidFields['admob_bottom_banner'] = get_option('wpdroid_admob_banner_ad_unit_id', '');
                    }
                }


                if ($isValidLicense) {
                    $wpDroidFields['license_status'] = 'valid';
                } else {
                    $wpDroidFields['license_status'] = 'invalid';
                }


                //Bookmarks
                if ($isValidLicense && get_option('wp_license_droid_bookmarks', 0)) {
                    $wpDroidFields['is_bookmarks_allowed'] = true;
                } else {
                    $wpDroidFields['is_bookmarks_allowed'] = false;
                }


                $wpDroidFields['is_bookmarks_enabled'] = get_option('wpdroid_allow_bookmarks', 0) == 0 ? false : true;


                //ADMob
                if ($isValidLicense && get_option('wp_license_droid_admob', 0)) {
                    $wpDroidFields['is_ads_allowed'] = true;
                } else {
                    $wpDroidFields['is_ads_allowed'] = false;
                }

                //Comments
                if ($isValidLicense && get_option('wp_license_droid_comments', 0)) {
                    $wpDroidFields['is_comments_allowed'] = true;
                } else {
                    $wpDroidFields['is_comments_allowed'] = false;
                }
            }



            return $wpDroidFields;
        }
    }
}





/** ######################################## W P   D R O I D ###################################* */




/**
 * This filter will allow adding comments from app without authentication. However adminstrator need to approve it from WordPress admin panel or as per website discussion settings
 */

add_filter('rest_allow_anonymous_comments', 'wpdroid_filter_allow_anonymous_comments');

function wpdroid_filter_allow_anonymous_comments()
{
    if (get_option('wpdroid_allow_comments', 1)) {
        return true;
    } else {
        return false;
    }
}



/** ######################################## W P   D R O I D ###################################* */



/**
 *
 * Registering new route 'wp-json/url-to-id'
 * Send the URL in header with key 'HTTP_URL'
 * This route is used in Detailed Article screen to open internal links within the application activity
 *
 * returns JSON object with status 1 when post fount or
 * 0 when no posts found
 *
 */

add_action('rest_api_init', 'wpdroid_register_getpostid_routes');

function wpdroid_register_getpostid_routes()
{
    register_rest_route('wp-droid', 'url-to-id', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'wpdroid_register_getpostid_routes_callback',
    ));
}

function wpdroid_register_getpostid_routes_callback(WP_REST_Request $request)
{
    $id = url_to_postid($_SERVER['HTTP_URL']);
    $urlToIdResponce = array();

    if ($id == 0) {
        $urlToIdResponce = array("status" => '0', 'message' => 'no post found');
    } else {
        $urlToIdResponce['status'] = 1;

        if (wpdroid_meta_box_isChecked($id, 'wpdroid_meta_override_settings', "unchecked")) {
            $isInWebBrowser = wpdroid_meta_box_isChecked($id, 'wpdroid_meta_web_browser', 'unchecked');
        } else {
            $isInWebBrowser = get_option('wpdroid_article_open_screen', "wpdroid") == "wpdroid" ? false : true;
        }

        if ($isInWebBrowser) {
            $urlToIdResponce['url'] =  get_permalink($id);
        } else {
            $urlToIdResponce['id'] = $id;
        }
    }

    if (get_option('wp_license_valid_droid', 0)) {
        $urlToIdResponce['license_status'] = 'valid';
    } else {
        $urlToIdResponce['license_status'] = 'invalid';
    }

    $urlToIdJson = json_encode($urlToIdResponce);
    echo $urlToIdJson;
}




/** ######################################## W P   D R O I D ###################################* */




/**
 * Creating wp_droid JSON Object to append in categories route
 * this will 'exclude_category' key with boolen value true or false.
 * Category will be hidden in app when value is false
 */

add_action('rest_api_init', 'wpdroid_categories_route');

function wpdroid_categories_route()
{
    register_rest_field(
        'category',
        'wp_droid',
        array(
            'get_callback'    => 'wp_droid_categories_route_callback',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

/**
 * call back function that will add 'wp_droid' JSON Object to list categories 'wp-json/v2/categories'
 */

function wp_droid_categories_route_callback($object, $field_name, $request)
{
    $excludedCategory = get_option('wpdroid_exclude_categories', '');
    $excluded_category_ids = explode(',', $excludedCategory);

    $status = in_array($object['id'], $excluded_category_ids);

    $wpDroidCategoryFields['exclude_category'] = $status;

    if (get_option('wp_license_valid_droid', 0) && get_option('wp_license_droid_categories', 0)) {
        $wpDroidCategoryFields['license_status'] = 'valid';
    } else {
        $wpDroidCategoryFields['license_status'] = 'invalid';
    }

    return $wpDroidCategoryFields;
}




/** ######################################## W P   D R O I D ###################################* */


/**
 *
 * Registering new route 'wp-json/about'
 * returns a JSON Object with all details needed for About screen
 */

add_action('rest_api_init', 'wpdroid_register_about_screen_routes');


function wpdroid_register_about_screen_routes()
{
    register_rest_route('wp-droid', 'about', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'wpdroid_register_about_screen_routes_callback',
    ));
}

function wpdroid_register_about_screen_routes_callback(WP_REST_Request $request)
{
    $aboutArray = array();

    $aboutArray['status'] = 100;

    if (get_option('wp_droid_about_website', get_bloginfo('description')) != '') {
        $aboutArray['about'] = get_option('wp_droid_about_website', get_bloginfo('description'));
    }

    if (get_option('wp_droid_about_read_more', '') != '') {
        $aboutArray['read_more'] = get_option('wp_droid_about_read_more', '');
    }

    if (get_option('wp_droid_about_email', get_bloginfo('admin_email')) != '') {
        $aboutArray['email'] = get_option('wp_droid_about_email', get_bloginfo('admin_email'));
    }

    if (get_option('wp_droid_about_phone', '') != '') {
        $aboutArray['phone'] = get_option('wp_droid_about_phone', '');
    }

    if (get_option('wp_droid_social_linkedin', '') != '') {
        $aboutArray['linkedin'] = get_option('wp_droid_social_linkedin', '');
    }

    if (get_option('wp_droid_social_instagram', '') != '') {
        $aboutArray['instagram'] = get_option('wp_droid_social_instagram', '');
    }

    if (get_option('wp_droid_social_youtube', '') != '') {
        $aboutArray['youtube'] = get_option('wp_droid_social_youtube', '');
    }

    if (get_option('wp_droid_social_google_plus', '') != '') {
        $aboutArray['google_plus'] = get_option('wp_droid_social_google_plus', '');
    }

    if (get_option('wp_droid_social_twitter', '') != '') {
        $aboutArray['twitter'] = get_option('wp_droid_social_twitter', '');
    }

    if (get_option('wp_droid_social_facebook', '') != '') {
        $aboutArray['facebook'] = get_option('wp_droid_social_facebook', '');
    }

    if (get_option('wp_license_valid_droid', 0) && get_option('wp_license_droid_about', 0)) {
        $aboutArray['license_status'] = 'valid';
    } else {
        $aboutArray['license_status'] = 'invalid';
    }

    $aboutJson = json_encode($aboutArray);

    echo $aboutJson;
}


/** ######################################## W P   D R O I D ###################################* */


/*
 * Removing unwanted fields from "wp/v2/posts" if request contains wpdroid=ture parameter
 */

add_filter('rest_prepare_post', 'wpdroid_remove_unwanted_fields_post', 10, 3);

function wpdroid_remove_unwanted_fields_post($data, $post, $request)
{
    $_data = $data->data;
    $params = $request->get_params();

    if (isset($params['wpdroid'])) {
        if ($params['wpdroid'] == "true") {
            $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            $url_parts = parse_url($current_url);
            $constructed_url = '//' . $url_parts['host'] . $url_parts['path'];

            //Detailed POST
            if (!preg_match('/posts\/[\s\S]*\d$/', $constructed_url)) {
                unset($_data['content']);
            }


            unset($_data['date_gmt']);
            unset($_data['guid']);
            unset($_data['date']);
            unset($_data['modified']);
            unset($_data['modified_gmt']);
            unset($_data['slug']);
            unset($_data['status']);
            unset($_data['type']);
            // unset($_data['link']);
            unset($_data['excerpt']);
            unset($_data['author']);
            unset($_data['featured_media']);
            // unset( $_data['comment_status'] );
            unset($_data['ping_status']);
            unset($_data['sticky']);
            unset($_data['template']);
            unset($_data['format']);
            unset($_data['meta']);
            unset($_data['categories']);
            unset($_data['tags']);

            $data->remove_link('collection');
            $data->remove_link('self');
            $data->remove_link('about');
            $data->remove_link('author');
            $data->remove_link('replies');
            $data->remove_link('version-history');
            $data->remove_link('https://api.w.org/featuredmedia');
            $data->remove_link('https://api.w.org/attachment');
            $data->remove_link('https://api.w.org/term');
            $data->remove_link('curies');


            $data->data = $_data;
            return $data;
        }
    }

    $data->data = $_data;
    return $data;
}




/** ######################################## W P   D R O I D ###################################* */




/**
 * Adding AdMob Bottom Banner Ad ID to list COMMENTS
 * Banner Ad ID is added inside 'wp_droid' JSON Object
 */

add_action('rest_api_init', 'wpdroid_comments_route');

function wpdroid_comments_route()
{
    register_rest_field(
        'comment',
        'wp_droid',
        array(
            'get_callback'    => 'wp_droid_comments_route_callback',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

/**
 * call back function that will add 'wp_droid' JSON Object to list comments 'wp-json/v2/comments'
 */

function wp_droid_comments_route_callback($object, $field_name, $request)
{



    // $_data = $data->data;
    $params = $request->get_params();

    if (isset($params['wpdroid'])) {
        if ($params['wpdroid'] == "true") {
            if (get_option('wpdroid_comments_date_time_format', "F j, Y") != 'hide_date_time') {
                $wpDroidCommentFields['date_time'] = get_comment_date(get_option('wpdroid_comments_date_time_format', 'F j, Y'), $object['id']);
            }

            if (get_option('wpdroid_admob_bottom_ad_comments', 0)) {
                $wpDroidCommentFields['admob_bottom_banner'] = get_option('wpdroid_admob_banner_ad_unit_id', '');
            }

            $wpDroidCommentFields['commenter_image'] = true;

            if (get_option('wp_license_valid_droid', 0)) {
                $wpDroidCommentFields['license_status'] = 'valid';
            } else {
                $wpDroidCommentFields['license_status'] = 'invalid';
            }

            return $wpDroidCommentFields;
        }
    }
}


/** ######################################## W P   D R O I D ###################################* */


/*
 * Removing unwanted fields from "wp/v2/comments" if request contains wpdroid=ture parameter
 */

add_filter('rest_prepare_comment', 'wpdroid_remove_unwanted_fields_comments', 10, 3);

function wpdroid_remove_unwanted_fields_comments($data, $post, $request)
{
    $_data = $data->data;
    $params = $request->get_params();

    if (isset($params['wpdroid'])) {
        if ($params['wpdroid'] == "true") {

            // unset( $_data['post'] );
            // unset( $_data['parent'] );
            // unset( $_data['author'] );

            // unset( $_data['date'] );
            unset($_data['date_gmt']);
            unset($_data['link']);
            unset($_data['meta']);


            $data->remove_link('collection');
            $data->remove_link('self');
            $data->remove_link('up');

            $data->data = $_data;
            return $data;
        }
    }

    $data->data = $_data;
    return $data;
}


/** ######################################## W P   D R O I D ###################################* */


/*
 * Removing unwanted fields from "wp/v2/categories" if request contains wpdroid=ture parameter
 */

// add_filter( 'rest_prepare_category', 'wpdroid_remove_unwanted_fields_categories', 10, 3 );

function wpdroid_remove_unwanted_fields_categories($data, $post, $request)
{
    // $_data = $data->data;
    $params = $request->get_params();

    if (isset($params['wpdroid'])) {
        if ($params['wpdroid'] == "true") {
            unset($_data['description']);
            unset($_data['link']);
            unset($_data['slug']);
            unset($_data['taxonomy']);
            unset($_data['parent']);
            unset($_data['meta']);


            $data->remove_link('collection');
            $data->remove_link('self');
            $data->remove_link('about');
            $data->remove_link('curies');
            $data->remove_link('https://api.w.org/post_type');

            $data->data = $_data;
            return $data;
        }
    }

    $data->data = $_data;
    return $data;
}
