<?php namespace App\Model;

class Twitter
{

    public $user;
    public $message;
    public $created_time;
    public $post_type = 'twitter';
    public $link;

    private static $_access_token;
    private static $_access_token_secret;
    private static $_consumer_key;
    private static $_consumer_secret;

    public static function getRecentTweets($num_items = 1)
    {
        $social_options = get_option('app_social_options');

        $settings = array(
            'oauth_access_token' => '15379442-9z3XzkxjxyTaHBMfxswpSRwQyCUOMLFHO8mPZqUHC',
            'oauth_access_token_secret' => 'DKDjX1dMcqsFikBX0omJihDLsNP98gqvDYwheF8n9VaKJ',
            'consumer_key' => 'zqLLgzq14spLMJSN7kFhJ94XT',
            'consumer_secret' => 'MCZ301GagOxeIDpbINrZR6BEg6mWy8UY5POwX9pcEMoKBGwi3M'
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name=Certified_SC&count=' . $num_items . '&exclude_replies=true';
        $requestMethod = 'GET';

        try {
            $twitter = new \TwitterAPIExchange($settings);
            $twitter_response_as_json = $twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest();
        } catch (\Exception $ex) {
            // likely, settings aren't set
            return array();
        }


        $twitter_response = json_decode($twitter_response_as_json);

        $recent_tweets = array();
        if (is_array($twitter_response)) {
            foreach ($twitter_response as $row) {
                $tweet = new Twitter();
                $tweet->user = $row->user->screen_name;
                $tweet->message = $row->text;
                $tweet->created_time = $row->created_at;
                $tweet->link = 'https://twitter.com/' . $row->user->screen_name . '/status' . $row->id;

                $recent_tweets[] = $tweet;
            }
        }

        return $recent_tweets;
    }
}
