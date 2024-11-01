<?php

class WPDroidRelatedPosts
{
    private $postId;

    public function __construct()
    {
        $this->postId = "-1";
    }

    public function setPostId($post_id)
    {
        $this->postId = $post_id;
    }


    public function getRelatedPosts()
    {
        $relatedPosts = array();

        $isCatOrTag = get_option('wpdroid_related_posts_based_on', "categories");

        if ($isCatOrTag == 'categories') {
            $all_related_posts = get_the_category($this->postId);
        } else {
            $all_related_posts = wp_get_post_tags($this->postId);
        }


        if ($all_related_posts) {
            $related_posts_id = array();

            foreach ($all_related_posts as $individual_id) {
                $related_posts_id[] = $individual_id->term_id;
            }

            $args = array(
                        'post__not_in' => array($this->postId),
                        'posts_per_page' => get_option('wpdroid_related_posts_count', 3),
                        'ignore_sticky_posts' => true,
                        'orderby' => 'rand',
                        'order'    => 'ASC'
                    );

            if ($isCatOrTag == 'categories') {
                $args['category__in'] = $related_posts_id;
            } else {
                $args['tag__in'] = $related_posts_id;
            }


            $my_query = new wp_query($args);

            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) {
                    $my_query->the_post();

                    $singlePost = array();

                    $singlePost['title'] = the_title('', '', false);
                    $singlePost['post_id'] = get_the_ID();

                    if (get_option('wpdroid_related_posts_featured_image', 1) == 1) {
                        $medium = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');
                        $medium_image = $medium['0'] == null ? "" : $medium['0'];
                        $singlePost['featured_image'] = $medium_image;
                    }

                    if (get_option('wpdroid_related_post_date_time_format', "F j, Y") != 'hide_date_time') {
                        $singlePost['date_time'] = get_the_date(get_option('wpdroid_related_post_date_time_format', "F j, Y"));
                        ;
                    }

                    if (get_option('wpdroid_related_post_author_name', 1) == 1) {
                        $singlePost['author_name'] = get_the_author_meta('display_name');
                    }

                    //OPEN IN WEB BROWSER START

                    $isInWebBrowser = get_option('wpdroid_article_open_screen', "wpdroid") == "wpdroid" ? false : true;


                    $singlePost['in_browser'] = $isInWebBrowser;

                    if ($isInWebBrowser) {
                        $singlePost['url'] =  get_permalink($object['id']);
                    }


                    $relatedPosts[] = $singlePost;
                }
            }
        }

        wp_reset_query();
        return $relatedPosts;
    }
}
