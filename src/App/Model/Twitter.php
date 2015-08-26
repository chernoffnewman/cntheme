<?php namespace App\Model;

class Twitter extends Social
{
    use SocialSettings;

    const SETTINGS_FIELD_ACCESS_TOKEN = 'twitter_access_token';
    const SETTINGS_FIELD_ACCESS_TOKEN_SECRET = 'twitter_access_token_secret';
    const SETTINGS_FIELD_CONSUMER_KEY = 'twitter_consumer_key';
    const SETTINGS_FIELD_CONSUMER_SECRET = 'twitter_consumer_secret';

    const API_BASE_URL = 'https://api.twitter.com/1.1/';

    public static function getAccessToken()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_ACCESS_TOKEN);
    }

    public static function getAccessTokenSecret()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_ACCESS_TOKEN_SECRET);
    }

    public static function getConsumerKey()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_CONSUMER_KEY);
    }

    public static function getConsumerSecret()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_CONSUMER_SECRET);
    }

    public static function getDefaultUsername()
    {
        $social_options = Config::getSocialOptions();
        return (isset($social_options['twitter']['default_username'])) ? $social_options['twitter']['default_username'] : '';
    }

    public static function getRecentTweetsByUser($user, $num_items = 10)
    {
        $recent_tweets = array();

        $settings = array(
            'oauth_access_token' => self::getAccessToken(),
            'oauth_access_token_secret' => self::getAccessTokenSecret(),
            'consumer_key' => self::getConsumerKey(),
            'consumer_secret' => self::getConsumerSecret()
        );

        try {
            $twitter = new \TwitterAPIExchange($settings);
            $twitter_response_as_json = $twitter->setGetfield('?' . http_build_query(array(
                    'screen_name' => $user,
                    'count' => $num_items
                )))
                ->buildOauth(self::API_BASE_URL . 'statuses/user_timeline.json', 'GET')
                ->performRequest();
        } catch (\Exception $ex) {
            Logger::error('Failed to pull recent tweets');
            return $recent_tweets;
        }

        $twitter_response = json_decode($twitter_response_as_json);

        if ($twitter_response === null || $twitter_response === false) {
            return $recent_tweets;
        }

        if (is_array($twitter_response)) {
            foreach ($twitter_response as $row) {
                $tweet = new Twitter();
                $tweet->social_post_name = $row->user->screen_name;
                $tweet->social_post_message = $row->text;
                $tweet->social_post_created_time = $row->created_at;
                $tweet->social_post_link = 'https://twitter.com/' . $row->user->screen_name . '/status/' . $row->id;
                $tweet->social_post_type = 'twitter';

                $recent_tweets[] = $tweet;
            }
        }

        return $recent_tweets;
    }
}
