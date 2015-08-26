<?php namespace App\Model;

class Analytics
{
    public static $field_ga_code;
    public static $field_use_ga;
    public static $field_use_crazyegg;

    private static $_settings;

    const SETTINGS_FIELD = 'app_analytics_options';
    const YES = 'yes';
    const NO = 'no';

    public static function init()
    {
        self::$field_ga_code = 'ga_code';
        self::$field_use_ga = 'use_ga';
        self::$field_use_crazyegg = 'use_crazyegg';

        add_action('piklist_admin_pages', array(__CLASS__, '_registerSettingsPage'), 10, 1);
    }

    public static function _registerSettingsPage($pages)
    {
        $pages[] = array(
            'page_title' => __('Analytics', Config::getTextDomain()),
            'menu_title' => __('Analytics', Config::getTextDomain()),
            'capability' => 'manage_options',
            'menu_slug' => 'analytics-options',
            'setting' => 'app_analytics_options',
            'save_text' => 'Save settings'
        );

        return $pages;
    }

    public static function getYesOrNoOptionsForPiklistSelect()
    {
        return array(
            self::YES => 'Yes',
            self::NO => 'No'
        );
    }

    private static function _getSettingByKey($key)
    {
        $settings = self::_getSettings();
        return (isset($settings[$key])) ? $settings[$key] : null;
    }

    private static function _getSettings()
    {
        if (self::$_settings === null) {
            self::$_settings = get_option(self::SETTINGS_FIELD);
        }

        return self::$_settings;
    }

    public static function shouldIncludeGoogleAnalytics()
    {
        return (self::_getSettingByKey(self::$field_use_ga) === self::YES);
    }

    public static function getGoogleAnalyticsCode()
    {
        return self::_getSettingByKey(self::$field_ga_code);
    }

    public static function shouldIncludeCrazyEgg()
    {
        return (self::_getSettingByKey(self::$field_use_crazyegg) === self::YES);
    }
}
