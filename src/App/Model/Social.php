<?php namespace App\Model;

class Social
{
    public static function init()
    {
        add_action('piklist_admin_pages', array(__CLASS__, '_registerSettingsPage'), 10, 1);
    }

    public static function _registerSettingsPage($pages)
    {
        $pages[] = array(
            'page_title' => __('Social', Config::getTextDomain()),
            'menu_title' => __('Social', Config::getTextDomain()),
            'capability' => 'manage_content',
            'menu_slug' => 'social-options',
            'setting' => 'app_social_options',
            'save_text' => 'Save settings'
        );

        return $pages;

    }
}