<?php namespace App\Model;

use Carbon\Carbon;

class Instagram extends \TimberPost
{
    private static $_settings = null;
    private static $_postType;
    private static $_label_title;

    const SETTINGS_FIELD = 'app_social_options';
    const SETTINGS_FIELD_INSTAGRAM_TOKEN = 'instagram_token';
    const SETTINGS_FIELD_MAX_TAG_ID = 'instagram_max_tag_id';
    const SETTINGS_FIELD_USER_ID = 'instagram_user_id';
    const SETTINGS_FIELD_CLIENT_ID = 'instagram_client_id';
    const SETTINGS_FIELD_CLIENT_SECRET = 'instagram_client_secret';

    const OPTION_TRASHED_INSTAGRAM_MEDIA_IDS = 'app_social_trashed_instagram_media_ids';

    public static $field_username;
    public static $field_user_id;
    public static $field_user_profile_picture;
    public static $field_id;
    public static $field_created_time;
    public static $field_type;
    public static $field_link;
    public static $field_image_standard_resolution_url;
    public static $field_image_thumbnail_url;
    public static $field_is_featured;
    public static $field_caption;

    public static function bootstrap()
    {
        self::$_postType = $postType = Config::getKeyPrefix() . 'instagram';
        self::$_label_title = 'Instagram';

        self::$field_username = Config::getKeyPrefix() . 'username';
        self::$field_user_id = Config::getKeyPrefix() . 'user_id';
        self::$field_user_profile_picture = Config::getKeyPrefix() . 'user_profile_picture';
        self::$field_id = Config::getKeyPrefix() . 'id';
        self::$field_created_time = Config::getKeyPrefix() . 'created_time';
        self::$field_type = Config::getKeyPrefix() . 'type';
        self::$field_link = Config::getKeyPrefix() . 'link';
        self::$field_image_standard_resolution_url = Config::getKeyPrefix() . 'image_standard_resolution_url';
        self::$field_image_thumbnail_url = Config::getKeyPrefix() . 'image_thumbnail_url';
        self::$field_is_featured = Config::getKeyPrefix() . 'is_featured';
        self::$field_caption = Config::getKeyPrefix() . 'caption';

        add_filter('piklist_post_types', array(get_class(), 'registerCPT'));
        add_filter("manage_{$postType}_posts_columns", array(get_class(), 'cols'));
        add_action("manage_{$postType}_posts_custom_column", array(get_class(), 'col'), 10, 2);
        add_action('admin_enqueue_scripts', function ($hook) {
            if ($hook !== 'edit.php') {
                return;
            }

            wp_enqueue_script('admin-instagram-js', get_template_directory_uri() . '/js/admin/instagram.js', array('jquery'), false, true);
        });
        add_action('before_delete_post', array(get_class(), 'onDeleteMarkToNotCreateAgain'));
        add_filter('piklist_admin_pages', array(get_class(), 'registerContactPage'));

//        // https://wordpress.org/support/topic/admin-column-sorting
//        add_filter("manage_edit-{$postType}_sortable_columns", function ($columns) {
//            $columns['date_created'] = 'date_created';
//            return $columns;
//        });
//        add_filter('request', function ($vars) {
//            if (isset($vars['orderby']) && 'date_created' == $vars['orderby']) {
//                $vars = array_merge($vars, array(
//                    'meta_key' => '',
//                    'orderby' => 'meta_value'
//                ));
//            }
//            return $vars;
//        });
    }

    public static function onDeleteMarkToNotCreateAgain($post_id)
    {
        $post = get_post($post_id);
        if ($post->post_type !== self::$_postType) {
            return;
        }

        $deleted_media_ids = get_option(self::OPTION_TRASHED_INSTAGRAM_MEDIA_IDS);
        if ($deleted_media_ids === false) {
            $deleted_media_ids = array();
        }

        $deleted_media_ids[] = get_post_meta($post_id, self::$field_id, true);

        update_option(self::OPTION_TRASHED_INSTAGRAM_MEDIA_IDS, $deleted_media_ids);
    }

    public static function registerContactPage($pages)
    {
        $pages[] = array(
            'page_title' => 'Settings',
            'menu_title' => 'Settings',
            'sub_menu' => 'edit.php?post_type=app_instagram',
            'capability' => 'manage_options',
            'menu_slug' => 'instagram-settings',
            'setting' => 'app_instagram_settings',
            'save_text' => 'Save Settings'
        );

        return $pages;
    }

    public static function getPostType()
    {
        return self::$_postType;
    }

    public static function cols($columns)
    {
        $new_columns = array(
            'cb' => $columns['cb'],
            'title' => $columns['title'],
            'image' => 'Image',
            'link' => 'Link',
            'date' => 'Date'
        );

        return $new_columns;
    }

    public static function col($column, $post_id)
    {
        switch ($column) {
            case 'image':
                $vals = get_post_meta($post_id, self::$field_image_thumbnail_url, false);
                $src = (is_array($vals)) ? array_shift($vals) : $vals;
                echo sprintf("<img width='150' height='150' src='%s' />", $src);;
                break;
            case 'link':
                $link = get_post_meta($post_id, self::$field_link, true);
                echo sprintf("<a href='%s' target='_blank'>View on Instagram</a>", $link);
                break;
            case 'date_created':
                $post = get_post($post_id);
                echo Carbon::createFromFormat('Y-m-d H:i:s', $post->post_date)->format('M d, Y');
                break;
        }
    }

    public function getImageSrc()
    {
        $field = self::$field_image_standard_resolution_url;
        return $this->$field;
    }

    public function getUserName()
    {
        $field = self::$field_username;
        return $this->$field;
    }

    public function getCaption()
    {
        $field = self::$field_caption;
        return $this->$field;
    }

    public function getLink()
    {
        $field_link = self::$field_link;

        if ($this->$field_link === null || trim($this->$field_link) === '') {
            $field_media_id = self::$field_id;
            $media_id = $this->$field_media_id;
            $access_token = self::getAccessToken();

            $result = Helper::fetchData("https://api.instagram.com/v1/media/{$media_id}?access_token={$access_token}");
            $result = json_decode($result);

            if (isset($result->data->link)) {
                update_post_meta($this->id, $field_link, $result->data->link);
                $this->$field_link = $result->data->link;
            }
        }

        return $this->$field_link;
    }

    public function getMediaId()
    {
        $field_media_id = self::$field_id;
        return $this->$field_media_id;
    }

    public static function registerCPT($post_types)
    {
        $post_types[self::$_postType] = array(
            'labels' => piklist('post_type_labels', self::$_label_title),
            'title' => __('Instagrams'),
            'public' => true,
            'rewrite' => array(
                'slug' => 'i'
            ),
            'supports' => array(
                'revisions'
            ),
            'hide_meta_box' => array(
                'slug',
                'author',
                'revisions',
                'comments',
                'commentstatus'
            ),
            'status' => array(
                'draft' => array(
                    'label' => 'Draft'
                ),
                'pending' => array(
                    'label' => 'Pending Review'
                ),
                'publish' => array(
                    'label' => 'Approved'
                ),
                'featured' => array(
                    'label' => 'Featured'
                )
            )
        );

        return $post_types;
    }

    public static function create($instagram_obj)
    {
        $post_id = wp_insert_post(array(
            'post_title' => sprintf('@%s', $instagram_obj->user->username),
            'post_name' => uniqid(),
            'post_status' => 'pending',
            'post_type' => self::$_postType,
            'post_date' => date('Y-m-d H:i:s', $instagram_obj->created_time)
        ));

        update_post_meta($post_id, self::$field_username, $instagram_obj->user->username);
        update_post_meta($post_id, self::$field_user_id, $instagram_obj->user->id);
        update_post_meta($post_id, self::$field_user_profile_picture, $instagram_obj->user->profile_picture);
        update_post_meta($post_id, self::$field_id, $instagram_obj->id);
        update_post_meta($post_id, self::$field_created_time, $instagram_obj->created_time);
        update_post_meta($post_id, self::$field_type, $instagram_obj->type);
        update_post_meta($post_id, self::$field_image_standard_resolution_url, $instagram_obj->images->standard_resolution->url);
        update_post_meta($post_id, self::$field_image_thumbnail_url, $instagram_obj->images->thumbnail->url);
        update_post_meta($post_id, self::$field_link, $instagram_obj->link);
        if (isset($instagram_obj->caption->text)) {
            update_post_meta($post_id, self::$field_caption, $instagram_obj->caption->text);
        }

        return self::find($post_id);
    }

    public static function hasPostByDeletedByInstagramMediaId($media_id)
    {
        $deleted_media_ids = get_option(self::OPTION_TRASHED_INSTAGRAM_MEDIA_IDS);
        if ($deleted_media_ids === false) {
            return false;
        }

        return (is_array($deleted_media_ids) && in_array($media_id, $deleted_media_ids));
    }

    public static function findByInstagramId($id)
    {
        $posts = \Timber::get_posts(array(
            'post_type' => self::$_postType,
            'post_status' => array(
                'draft',
                'pending',
                'featured',
                'publish',
                'trash'
            ),
            'posts_per_page' => 1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => self::$field_id,
                    'value' => $id,
                    'compare' => '='
                )
            )
        ), '\App\Model\Instagram');

        if (empty($posts)) {
            return false;
        }

        return true;
    }

    public static function find($post_id)
    {
        return \Timber::get_post($post_id, get_class());
    }

    public static function getApproved($limit)
    {
        return \Timber::get_posts(array(
            'post_type' => self::$_postType,
            'posts_per_page' => $limit,
            'post_status' => array('publish', 'featured')
        ), get_class());
    }

    public static function getFeatured($limit)
    {
        $posts = \Timber::get_posts(array(
            'post_type' => self::$_postType,
            'posts_per_page' => $limit,
            'post_status' => array('featured')
        ));

        return $posts;
    }

    private static function _getSocialSettingByKey($key)
    {
        $settings = self::_getSocialSettings();
        return (isset($settings[$key])) ? $settings[$key] : null;
    }

    private static function _getSocialSettings()
    {
        if (self::$_settings === null) {
            self::$_settings = get_option(self::SETTINGS_FIELD);
        }

        return self::$_settings;
    }

    public static function getClientId()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_CLIENT_ID);
    }

    public static function getClientSecret()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_CLIENT_SECRET);
    }

    public static function getAccessToken()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_INSTAGRAM_TOKEN);
    }

    public static function getUserId()
    {
        return self::_getSocialSettingByKey(self::SETTINGS_FIELD_USER_ID);
    }

    public function getMediaById($media_id)
    {
        $result = Helper::fetchData("https://api.instagram.com/v1/media/" . $media_id . "/?access_token=" . self::getAccessToken());
        $result = json_decode($result);

        if ($result->meta->code === 200) {
            return $result->data;
        }

        return false;
    }

    public static function getRecentByTag($tag, $count = 20)
    {
        $fetch_url = "https://api.instagram.com/v1/tags/" . $tag . "/media/recent/?access_token=" . self::getAccessToken();

        $fetch_url .= "&count={$count}";

        $result = Helper::fetchData($fetch_url);
        $result = json_decode($result);

        $data = array();
        while (isset($result->data) && empty($result->data) === false) {
            foreach ($result->data as $post) {
                $data[] = $post;
            }

            $last_instance = $data[count($data) - 1];
            if (Instagram::findByInstagramId($last_instance->id) === false) {
                // the last returned image is not in the db... we need to continue to the next page
                $fetch_url = $result->pagination->next_url;
                $result = Helper::fetchData($fetch_url);
                $result = json_decode($result);
            } else {
                $result = null;
            }
        }

        return $data;
    }

}
