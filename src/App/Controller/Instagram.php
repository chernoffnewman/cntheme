<?php namespace App\Controller;

use App\Model\Config;
use App\Model\Helper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Instagram extends Router
{
    const CRON_GET_NEW_INSTAGRAMS_SCHEDULE_NAME = 'app_get_new_instagrams';
    const CRON_ALERT_USERS_OF_NEW_INSTAGRAMS = 'app_alert_users_of_new_instagrams';

    public static function routeImages()
    {
        if (Helper::isGet()) {
            if (isset($_GET['hub.challenge'])) {
                exit($_GET['hub.challenge']);
            }

            $social_options = Config::getSocialOptions();
            $tag = isset($social_options['instagram']['tag_to_track_for_approval_workflow']) ?
                $social_options['instagram']['tag_to_track_for_approval_workflow'] :
                false;

            if ($tag === false) {
                self::renderJSON(array(
                    'msg' => 'Error: no tag set to track'
                ), 500);
            }

            // initiate a new subscription
            $client = new Client('https://api.instagram.com');
            $request = $client->post('/v1/subscriptions/');
            $request->setBody(array(
                'client_id' => \App\Model\Instagram::getClientId(),
                'client_secret' => \App\Model\Instagram::getClientSecret(),
                'object' => 'tag',
                'aspect' => 'media',
                'object_id' => $tag,
                'verify_token' => 'blahblahblah',
                'callback_url' => get_site_url() . '/api/instagram-images'
            ));
            $request->setHeaders(array(
                'Accept' => 'application/json'
            ));

            try {
                $response = $request->send();
                $body = $response->getBody();
                $echo = json_decode($body);
                self::renderJSON($echo, 200);
            } catch (ClientException $ex) {
                echo '<pre>';
                print_r($ex);
                echo '</pre>';
            }
        } else if (Helper::isPost()) {
            // Instagram is letting us know that a new image has been added to the #zooplaydate tag
            self::_getNewInstagrams();
        } else {
            // nothing
        }
    }

    public static function initCronJobs()
    {
        if (false === wp_get_schedule(self::CRON_GET_NEW_INSTAGRAMS_SCHEDULE_NAME)) {
            wp_schedule_event(current_time('timestamp'), 'hourly', self::CRON_GET_NEW_INSTAGRAMS_SCHEDULE_NAME);
        }
        add_action(self::CRON_GET_NEW_INSTAGRAMS_SCHEDULE_NAME, array(get_class(), 'cronGetNewInstagrams'));

        if (false === wp_get_schedule(self::CRON_ALERT_USERS_OF_NEW_INSTAGRAMS)) {
            $datetime = \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                date('Y-m-d', strtotime('next monday')) . ' 07:00:00',
                new \DateTimeZone('America/New_York')
            );
            $timestamp = $datetime->getTimestamp();

            wp_schedule_event($timestamp, 'weekly', self::CRON_ALERT_USERS_OF_NEW_INSTAGRAMS);
        }
        add_action(self::CRON_ALERT_USERS_OF_NEW_INSTAGRAMS, array(get_class(), 'cronAlertNewInstagrams'));
    }

    public static function cronAlertNewInstagrams()
    {
        $instagrams = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => array(\App\Model\Instagram::getPostType()),
            'post_status' => array('pending')
        ));

        $num_instagrams = count($instagrams);

        if ($num_instagrams > 0) {
            $instagram_settings = get_option('app_instagram_settings');
            $emails = (isset($instagram_settings['emails'])) ? $instagram_settings['emails'] : 'developer@chernoffnewman.com';

            $social_options = Config::getSocialOptions();
            $tag = isset($social_options['instagram']['tag_to_track_for_approval_workflow']) ?
                $social_options['instagram']['tag_to_track_for_approval_workflow'] :
                'instagram';

            wp_mail(
                $emails,
                "#{$tag} has {$num_instagrams} new images for approval",
                \Timber::compile('emails/new-instagrams.twig', array(
                    'posts' => $instagrams,
                    'tag' => $tag
                )),
                array('Content-Type: text/html; charset=UTF-8', 'From: Chernoff Newman <developer@chernoffnewman.com>')
            );
        }

        self::renderJSON(array(
            'ok'
        ));
    }

    public static function cronGetNewInstagrams()
    {
        self::_getNewInstagrams();
    }

    public static function getNewInstagrams()
    {
        self::_getNewInstagrams();
    }

    private static function _getNewInstagrams()
    {
        $social_options = Config::getSocialOptions();
        $tag = isset($social_options['instagram']['tag_to_track_for_approval_workflow']) ?
            $social_options['instagram']['tag_to_track_for_approval_workflow'] :
            false;

        if ($tag === false) {
            self::renderJSON(array(
                'msg' => 'Error: no tag set to track'
            ), 500);
        }

        $recent_feed = \App\Model\Instagram::getRecentByTag($tag);
        $found = count($recent_feed);

        $instagrams = array();

        // search through what was returned and decide if we have the post already.
        // if not, create new post
        foreach ($recent_feed as $feed_obj) {
            if (\App\Model\Instagram::findByInstagramId($feed_obj->id) === false &&
                \App\Model\Instagram::hasPostByDeletedByInstagramMediaId($feed_obj->id) === false
            ) {
                /* @var \App\Model\Instagram $instance */
                $instance = \App\Model\Instagram::create($feed_obj);
                $instagrams[] = $instance;
            }
        }

        $total = count($instagrams);

        self::renderJSON(array(
            'msg' => sprintf('Found %d new posts of %d', $total, $found)
        ), 200);
    }

}
