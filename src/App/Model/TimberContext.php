<?php namespace App\Model;

class TimberContext
{
    public static function init()
    {
        add_filter('timber_context', array(get_class(), 'registerMenu'));
        add_filter('timber_context', array(get_class(), 'addToTimberContext'));
    }

    public static function registerMenu($data)
    {
        $data['menu'] = new \TimberMenu();

        return $data;
    }

    public static function addToTimberContext($data)
    {
        $data['typekit_src'] = Config::getTypekitSrc();
        $data['wp_footer'] = \TimberHelper::function_wrapper('wp_footer');
        $data['wp_head'] = \TimberHelper::function_wrapper('wp_head');
        $data['use_ga'] = Analytics::shouldIncludeGoogleAnalytics();
        $data['ga_code'] = Analytics::getGoogleAnalyticsCode();
        $data['use_crazyegg'] = Analytics::shouldIncludeCrazyEgg();

        // specific to palmetto series
        $data['gamecock_score'] = MatchUp::getTotalGamecockScore();
        $data['clemson_score'] = MatchUp::getTotalClemsonScore();
        $data['next_match_up'] = MatchUp::getNextMatchUp();
        $data['slides'] = self::_getSlideShowImagesFromPost();
        $data['side_social_boxes'] = self::_getSideSocialBoxes();
        $data['side_upcoming_match_ups'] = self::_getSideUpcomingMatchups();
        $data['side_recent_posts'] = self::_getSideRecentPosts();
        $data['categories'] = \Timber::get_terms('category');

        return $data;
    }

    private static function _getSideRecentPosts()
    {
        return \Timber::get_posts(array(
            'posts_per_page' => 4,
            'post_type' => 'post',
            'post_status' => 'publish'
        ), Post::getClass());
    }

    private static function _getSideUpcomingMatchups()
    {
        return MatchUp::getUpcomingMatchUps(4, 'sport');
    }

    private static function _getSideSocialBoxes()
    {
        $recent_social_posts = \TimberHelper::transient(Config::generateTransientKey('side_social_feed'), function () {
            $recent_tweets = Twitter::getRecentTweetsByUser(Twitter::getDefaultUsername(), 1);
            $recent_facebook_posts = Facebook::getRecentPostsForPage(Facebook::getDefaultUsername(), 1);
            $recent_instagram_posts = Instagram::getRecentByUser(Instagram::getDefaultUsername(), 2);

            $recent_social_posts = array();

            $recent_social_posts[] = array_pop($recent_facebook_posts);
            $recent_social_posts[] = array_pop($recent_instagram_posts);
            $recent_social_posts[] = array_pop($recent_instagram_posts);
            $recent_social_posts[] = array_pop($recent_tweets);


            return $recent_social_posts;
        }, 60 * 60);

        return $recent_social_posts;
    }

    private static function _getSlideShowImagesFromPost()
    {
        $post = \Timber::get_post();

        $slide_show_slide_post_meta = array();
        if (isset($post->app_slide_show_slides) === true) {
            $slide_show_slide_post_meta = $post->app_slide_show_slides;
        }

        if (is_array($slide_show_slide_post_meta) === false) {
            $slide_show_slide_post_meta = array($post->app_slide_show_slides);
        }

        $slide_show_slides = SlideShowSlide::getSlideShowSlidesFromPiklistPostMeta($slide_show_slide_post_meta);

        return $slide_show_slides;
    }
}