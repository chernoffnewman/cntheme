<?php namespace App\Model;

class Config
{

    public static $_productionDomains;

    public static $_stagingDomains;

    private static $_textDomain = 'app_';
    private static $_keyPrefix = 'app_';
    private static $_requireAuth = false;
    private static $_requiredPlugins = array();
    private static $_typekit_src;
    private static $_login_logo_src;
    private static $_social_options;
    private static $_add_this_src;

    public static function init()
    {
        $config_options = array();
        require(get_template_directory() . '/src/App/config_options.php');

        date_default_timezone_set($config_options['default_timezone']);

        if ($config_options['iframe_buster'] === true) {
            if (headers_sent() === false) {
                header('X-Frame-Options: SAMEORIGIN');
            }
        }

        if ($config_options['always_hide_admin_bar'] === true) {
            add_filter('show_admin_bar', '__return_false');
        }

        self::$_productionDomains = $config_options['production_domains'];
        self::$_stagingDomains = $config_options['staging_domains'];
        self::$_requireAuth = $config_options['require_auth'];
        self::$_requiredPlugins = $config_options['required_plugins'];
        self::$_typekit_src = $config_options['typekit_src'];
        self::$_login_logo_src = $config_options['login_logo_src'];
        self::$_social_options = $config_options['social'];
        self::$_add_this_src = $config_options['add_this_src'];
    }

    public static function getSocialOptions()
    {
        return self::$_social_options;
    }

    public static function generateTransientKey($key)
    {
        return $key . self::getAppVersion();
    }

    public static function getLoginLogoSrc()
    {
        return self::$_login_logo_src;
    }

    public static function getTypekitSrc()
    {
        return self::$_typekit_src;
    }

    public static function getAddThisSrc()
    {
        return self::$_add_this_src;
    }

    /**
     * @return array
     */
    public static function getRequiredPlugins()
    {
        return self::$_requiredPlugins;
    }

    /**
     * @return bool
     */
    public static function isAuthRequired()
    {
        return self::$_requireAuth;
    }


    /**
     * @return string
     */
    public static function getTextDomain()
    {
        return self::$_textDomain;
    }

    /**
     * @return string
     */
    public static function getKeyPrefix()
    {
        return self::$_keyPrefix;
    }

    /**
     * This file is auto generated via Beanstalk
     *
     * @return int|string
     */
    public static function getAppVersion()
    {
        if (file_exists(ABSPATH . '/.revision')) {
            $version = file_get_contents(ABSPATH . '/.revision');

            return trim($version);
        }

        return time();
    }

}
