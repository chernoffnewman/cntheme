<?php namespace App\Model;

class Facebook
{

    public $user;
    public $message;
    public $created_time;
    public $link;
    public $post_type = 'facebook';

    public static function getRecentPosts($num_posts = 8)
    {
        $facebook = new \Facebook(array(
            'appId' => '775358335831313',
            'secret' => '0209cac9d6c15ab1aec6fc3f4276d039'
        ));
        $accessToken = $facebook->getAccessToken();

        $posts = array();

        if ($accessToken) {
            try {
                $data = $facebook->api('/51701364355/feed', 'get', array('limit(' . $num_posts . ')'));
                if (isset($data['data'])) {
                    $data = $data['data'];
                    foreach ($data as $item) {

                        $post = new Facebook();
                        $post->user = '';
                        $post->message = '';
                        $post->created_time = '';
                        $post->link = '';

                        // get the first feed item that is a message (status update)
                        if (isset($item['message']) &&
                            isset($item['created_time']) &&
                            isset($item['from']['name']) &&
                            isset($item['link'])
                        ) {
                            $post->user = $item['from']['name'];
                            $post->message = $item['message'];
                            $post->created_time = $item['created_time'];
                            $post->link = $item['link'];

                            $posts[] = $post;
                        }
                    }

                }
            } catch (\FacebookApiException $e) {
                // error, keep previous update
            }
        }

        return $posts;
    }

}