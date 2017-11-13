<?php namespace App\Model;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class Facebook
{
    use SocialSettings;

    public $user;
    public $message;
    public $created_time;
    public $link;
    public $post_type = 'facebook';

    const SETTINGS_FIELD_APP_ID = 'facebook_app_id';
    const SETTINGS_FIELD_SECRET = 'facebook_secret';
    const SETTINGS_FIELD_ACCESS_TOKEN = 'facebook_access_token';

    public static function getAppId()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_APP_ID);
    }

    public static function getSecret()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_SECRET);
    }

    public static function getAccessToken()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_ACCESS_TOKEN);
    }

    public static function getDefaultUsername()
    {
        $social_options = Config::getSocialOptions();
        return (isset($social_options['facebook']['default_username'])) ? $social_options['facebook']['default_username'] : '';
    }

    public static function getRecentPostsForPage($page_name, $num_posts = 8)
    {
        try {
            $fb = new \Facebook\Facebook(array(
                'app_id' => self::getAppId(),
                'app_secret' => self::getSecret(),
                'default_graph_version' => 'v2.4',
                'default_access_token' => self::getAccessToken()
            ));
        } catch (FacebookSDKException $ex) {
            Logger::warning('Missing Facebook API credentials');
            return array();
        }


        $posts = array();
            try {
                $response = $fb->sendRequest('get', "/{$page_name}/posts", array(
                    'limit' => $num_posts,
                    'fields' => 'id,from,message,created_time'
                ));

                $body = $response->getDecodedBody();

                if ($body && isset($body['data']) &&
                    is_array($body['data']) &&
                    empty($body['data']) === false
                ) {
                    $data = $body['data'];
                    foreach ($data as $item) {
                        $post = new Facebook();

                        if (isset($item['message']) &&
                            isset($item['created_time']) &&
                            isset($item['from']['name']) &&
                            isset($item['id'])
                        ) {
                            $post->social_post_name = $item['from']['name'];
                            $post->social_post_message = $item['message'];
                            $post->social_post_created_time = $item['created_time'];
                            $post->social_post_link = 'http://fb.com/' . $item['id'];
                            $post->social_post_type = 'facebook';

                            $posts[] = $post;
                        }
                    }
                }
            } catch (FacebookResponseException $e) {
                Logger::error('FacebookResponseException: ' . $e->getMessage());
            } catch (FacebookSDKException $e) {
                Logger::error('FacebookSDKException: ' . $e->getMessage());
        }

        return $posts;
    }

}
