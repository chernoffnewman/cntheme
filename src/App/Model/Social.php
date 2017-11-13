<?php namespace App\Model;

trait SocialSettings
{
    private static $_settings = null;

    public $social_post_name;
    public $social_post_message;
    public $social_post_type;
    public $social_post_image_src;
    public $social_post_created_time;
    public $social_post_link;

    public static function _getSocialSettingByKey($key)
    {
        $settings = self::_getSocialSettings();
        return (isset($settings[$key])) ? $settings[$key] : null;
    }

    public static function _getSocialSettings()
    {
        if (self::$_settings === null) {
            self::$_settings = get_option(Social::SETTINGS_FIELD);
        }

        return self::$_settings;
    }

}

class Social
{
    const SETTINGS_FIELD = 'app_social_options';

    public static function init()
    {
        add_action('piklist_admin_pages', array(__CLASS__, '_registerSettingsPage'), 10, 1);
    }

    public static function _registerSettingsPage($pages)
    {
        $pages[] = array(
            'page_title' => __('Social', Config::getTextDomain()),
            'menu_title' => __('Social', Config::getTextDomain()),
            'capability' => 'manage_options',
            'menu_slug' => 'social-options',
            'setting' => 'app_social_options',
            'save_text' => 'Save settings'
        );

        return $pages;
    }
}
