<?php

  wp_nonce_field('wp--droid-customizer-settings', 'wp--droid', FALSE, TRUE);

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['wp--droid-update'])) {

                check_admin_referer('wp--droid-customizer-settings', 'wp--droid');

                if (!current_user_can('manage_options'))  {
                   wp_die( __('You do not have sufficient permissions to access this page.') );
                }

                // TRUE - 1
                // FALSE - 0

                if(isset($_POST['wpdroid_latest_posts_img_url'])) {
                  wpdroid_save_option('wpdroid_latest_posts_img_url', 1);
                } else {
                  wpdroid_save_option('wpdroid_latest_posts_img_url', 0);
                }

                if(isset($_POST['wpdroid_category_posts_img_url'])) {
                  wpdroid_save_option('wpdroid_category_posts_img_url', 1);
                } else {
                  wpdroid_save_option('wpdroid_category_posts_img_url', 0);
                }

                if(isset($_POST['wpdroid_search_posts_img_url'])) {
                  wpdroid_save_option('wpdroid_search_posts_img_url', 1);
                } else {
                  wpdroid_save_option('wpdroid_search_posts_img_url', 0);
                }

                if(isset($_POST['wpdroid_bookmarked_posts_img_url'])) {
                  wpdroid_save_option('wpdroid_bookmarked_posts_img_url', 1);
                } else {
                  wpdroid_save_option('wpdroid_bookmarked_posts_img_url', 0);
                }


                if(isset($_POST['wpdroid_url-to-id'])) {
                  wpdroid_save_option('wpdroid_url-to-id', 1);
                } else {
                  wpdroid_save_option('wpdroid_url-to-id', 0);
                }


                if(isset($_POST['wpdroid_exclude_categories'])) {
                  wpdroid_save_option('wpdroid_exclude_categories', preg_replace('/\s+/', '', esc_html( sanitize_text_field($_POST['wpdroid_exclude_categories']))));
                }


                if(isset($_POST['wpdroid_exclude_posts'])) {
                  wpdroid_save_option('wpdroid_exclude_posts', preg_replace('/\s+/', '',esc_html( sanitize_text_field($_POST['wpdroid_exclude_posts']))));
                }


                if(isset($_POST['wpdroid_send_notification_automatically'])) {
                    wpdroid_save_option('wpdroid_send_notification_automatically', 1);
                } else {
                    wpdroid_save_option('wpdroid_send_notification_automatically', 0);
                }

                if(isset($_POST['wpdroid_allow_bookmarks'])) {
                    wpdroid_save_option('wpdroid_allow_bookmarks', 1);
                } else {
                    wpdroid_save_option('wpdroid_allow_bookmarks', 0);
                }

                if(isset($_POST['wpdroid_latest_posts_published_date'])) {
                  wpdroid_save_option('wpdroid_latest_posts_published_date', 1);
                } else {
                  wpdroid_save_option('wpdroid_latest_posts_published_date', 0);
                }

                if(isset($_POST['wpdroid_category_posts_published_date'])) {
                  wpdroid_save_option('wpdroid_category_posts_published_date', 1);
                } else {
                  wpdroid_save_option('wpdroid_category_posts_published_date', 0);
                }

                if(isset($_POST['wpdroid_search_posts_published_date'])) {
                  wpdroid_save_option('wpdroid_search_posts_published_date', 1);
                } else {
                  wpdroid_save_option('wpdroid_search_posts_published_date', 0);
                }


                if(isset($_POST['wpdroid_bookmarked_posts_published_date'])) {
                  wpdroid_save_option('wpdroid_bookmarked_posts_published_date', 1);
                } else {
                  wpdroid_save_option('wpdroid_bookmarked_posts_published_date', 0);
                }


                if(isset($_POST['wpdroid_latest_posts_author_name'])) {
                  wpdroid_save_option('wpdroid_latest_posts_author_name', 1);
                } else {
                  wpdroid_save_option('wpdroid_latest_posts_author_name', 0);
                }

                if(isset($_POST['wpdroid_category_posts_author_name'])) {
                  wpdroid_save_option('wpdroid_category_posts_author_name', 1);
                } else {
                  wpdroid_save_option('wpdroid_category_posts_author_name', 0);
                }

                if(isset($_POST['wpdroid_search_posts_author_name'])) {
                  wpdroid_save_option('wpdroid_search_posts_author_name', 1);
                } else {
                  wpdroid_save_option('wpdroid_search_posts_author_name', 0);
                }

                if(isset($_POST['wpdroid_bookmarked_posts_author_name'])) {
                  wpdroid_save_option('wpdroid_bookmarked_posts_author_name', 1);
                } else {
                  wpdroid_save_option('wpdroid_bookmarked_posts_author_name', 0);
                }


                if(isset($_POST['wpdroid_posts_load_count'])) {
                  wpdroid_save_option('wpdroid_posts_load_count', sanitize_option('posts_per_page', $_POST['wpdroid_posts_load_count']));
                }

                if(isset($_POST['wpdroid_latest_posts_template'])) {
                  wpdroid_save_option('wpdroid_latest_posts_template', sanitize_key($_POST['wpdroid_latest_posts_template']));
                }

                if(isset($_POST['wpdroid_categories_posts_template'])) {
                  wpdroid_save_option('wpdroid_categories_posts_template', sanitize_key($_POST['wpdroid_categories_posts_template']));
                }

                if(isset($_POST['wpdroid_search_posts_template'])) {
                  wpdroid_save_option('wpdroid_search_posts_template', sanitize_key($_POST['wpdroid_search_posts_template']));
                }

                if(isset($_POST['wpdroid_bookmarked_posts_template'])) {
                  wpdroid_save_option('wpdroid_bookmarked_posts_template', sanitize_key($_POST['wpdroid_bookmarked_posts_template']));
                }

                if(isset($_POST['wpdroid_admob_bottom_ad_home'])) {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_home', 1);
                } else {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_home', 0);
                }

                if(isset($_POST['wpdroid_admob_bottom_ad_category_archives'])) {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_category_archives', 1);
                } else {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_category_archives', 0);
                }

                if(isset($_POST['wpdroid_admob_bottom_ad_article'])) {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_article', 1);
                } else {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_article', 0);
                }

                if(isset($_POST['wpdroid_admob_bottom_ad_comments'])) {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_comments', 1);
                } else {
                  wpdroid_save_option('wpdroid_admob_bottom_ad_comments', 0);
                }

                if(isset($_POST['wpdroid_invite_friends'])) {
                  wpdroid_save_option('wpdroid_invite_friends', 1);
                } else {
                  wpdroid_save_option('wpdroid_invite_friends', 0);
                }


                if(isset($_POST['wpdroid_invite_friends_text'])) {
                  wpdroid_save_option('wpdroid_invite_friends_text', sanitize_textarea_field(stripslashes($_POST['wpdroid_invite_friends_text'])));
                }




/** ######################################## W P   D R O I D ###################################* */


                // DETAILED ARTICLE SCREEN OPTIONS START


                if(isset($_POST['wpdroid_show_related_posts'])) {
                  wpdroid_save_option('wpdroid_show_related_posts', 1);
                } else {
                  wpdroid_save_option('wpdroid_show_related_posts', 0);
                }

                if(isset($_POST['wpdroid_related_posts_count'])) {
                  wpdroid_save_option('wpdroid_related_posts_count', sanitize_option('posts_per_page',$_POST['wpdroid_related_posts_count']));
                }

                if(isset($_POST['wpdroid_related_posts_style'])) {
                  wpdroid_save_option('wpdroid_related_posts_style', sanitize_key($_POST['wpdroid_related_posts_style']));
                }


                if(isset($_POST['wpdroid_report_error'])) {
                  wpdroid_save_option('wpdroid_report_error', 1);
                } else {
                   wpdroid_save_option('wpdroid_report_error', 0);
                }

                if(isset($_POST['wpdroid_copy_post_link'])) {
                  wpdroid_save_option('wpdroid_copy_post_link', 1);
                } else {
                  wpdroid_save_option('wpdroid_copy_post_link', 0);
                }

                if(isset($_POST['wpdroid_related_posts_based_on'])) {
                  wpdroid_save_option('wpdroid_related_posts_based_on', $_POST['wpdroid_related_posts_based_on']);
                }


                if(isset($_POST['wpdroid_open_in_browser'])) {
                  wpdroid_save_option('wpdroid_open_in_browser', 1);
                } else {
                  wpdroid_save_option('wpdroid_open_in_browser', 0);
                }

                if(isset($_POST['wpdroid_article_featured_image'])) {
                  wpdroid_save_option('wpdroid_article_featured_image', 1);
                } else {
                  wpdroid_save_option('wpdroid_article_featured_image', 0);
                }

                if(isset($_POST['wpdroid_article_author_name'])) {
                  wpdroid_save_option('wpdroid_article_author_name', 1);
                } else {
                  wpdroid_save_option('wpdroid_article_author_name', 0);
                }

                if(isset($_POST['wpdroid_article_date_time_format'])) {
                  wpdroid_save_option('wpdroid_article_date_time_format', sanitize_option('date_format', $_POST['wpdroid_article_date_time_format']));
                }

                if(isset($_POST['wpdroid_related_posts_scroll_position'])) {
                  wpdroid_save_option('wpdroid_related_posts_scroll_position', sanitize_key($_POST['wpdroid_related_posts_scroll_position']));
                }


                if(isset($_POST['wpdroid_related_post_date_time_format'])) {
                  wpdroid_save_option('wpdroid_related_post_date_time_format', sanitize_option('date_format',$_POST['wpdroid_related_post_date_time_format']));
                }

                if(isset($_POST['wpdroid_posts_feed_date_time_format'])) {
                  wpdroid_save_option('wpdroid_posts_feed_date_time_format', sanitize_option('date_format',$_POST['wpdroid_posts_feed_date_time_format']));
                }

                if(isset($_POST['wpdroid_related_post_author_name'])) {
                  wpdroid_save_option('wpdroid_related_post_author_name', 1);
                } else {
                  wpdroid_save_option('wpdroid_related_post_author_name', 0);
                }

                if(isset($_POST['wpdroid_related_posts_featured_image'])) {
                  wpdroid_save_option('wpdroid_related_posts_featured_image', 1);
                } else {
                  wpdroid_save_option('wpdroid_related_posts_featured_image', 0);
                }

                if(isset($_POST['wpdroid_article_show_category'])) {
                  wpdroid_save_option('wpdroid_article_show_category', 1);
                } else {
                  wpdroid_save_option('wpdroid_article_show_category', 0);
                }

                if(isset($_POST['wpdroid_article_open_screen'])) {
                  wpdroid_save_option('wpdroid_article_open_screen', esc_html( sanitize_text_field($_POST['wpdroid_article_open_screen'])));
                }



                // DETAILED ARTICLE SCREEN OPTIONS END



/** ######################################## W P   D R O I D ###################################* */

                // COMMENTS


                if(isset($_POST['wpdroid_allow_comments'])) {
                  wpdroid_save_option('wpdroid_allow_comments', 1);
                } else {
                  wpdroid_save_option('wpdroid_allow_comments', 0);
                }

                if(isset($_POST['wpdroid_comments_date_time_format'])) {
                  wpdroid_save_option('wpdroid_comments_date_time_format', sanitize_option('date_format',$_POST['wpdroid_comments_date_time_format']));
                }




/** ######################################## W P   D R O I D ###################################* */



                // ABOUT SCREEN OPTIONS START

                if(isset($_POST['wp_droid_about_website'])) {
                  wpdroid_save_option('wp_droid_about_website', sanitize_textarea_field($_POST['wp_droid_about_website']));
                }

                if(isset($_POST['wp_droid_about_read_more'])) {
                  wpdroid_save_option('wp_droid_about_read_more', esc_url($_POST['wp_droid_about_read_more']));
                }

                if(isset($_POST['wp_droid_about_email'])) {
                  wpdroid_save_option('wp_droid_about_email', sanitize_email($_POST['wp_droid_about_email']));
                }

                if(isset($_POST['wp_droid_about_phone'])) {
                  wpdroid_save_option('wp_droid_about_phone', esc_html( sanitize_text_field($_POST['wp_droid_about_phone'])));
                }

                if(isset($_POST['wp_droid_social_linkedin'])) {
                  wpdroid_save_option('wp_droid_social_linkedin', esc_url($_POST['wp_droid_social_linkedin']));
                }

                if(isset($_POST['wp_droid_social_instagram'])) {
                  wpdroid_save_option('wp_droid_social_instagram', esc_url($_POST['wp_droid_social_instagram']));
                }

                if(isset($_POST['wp_droid_social_youtube'])) {
                  wpdroid_save_option('wp_droid_social_youtube', esc_url($_POST['wp_droid_social_youtube']));
                }

                if(isset($_POST['wp_droid_social_google_plus'])) {
                  wpdroid_save_option('wp_droid_social_google_plus', esc_url($_POST['wp_droid_social_google_plus']));
                }

                if(isset($_POST['wp_droid_social_twitter'])) {
                  wpdroid_save_option('wp_droid_social_twitter', esc_url($_POST['wp_droid_social_twitter']));
                }

                if(isset($_POST['wp_droid_social_facebook'])) {
                  wpdroid_save_option('wp_droid_social_facebook', esc_url($_POST['wp_droid_social_facebook']));
                }

                // ABOUT SCREEN OPTIONS END


/** ######################################## W P   D R O I D ###################################* */



  }

?>
