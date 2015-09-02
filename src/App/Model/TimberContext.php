<?php namespace App\Model;

class TimberContext
{
    public static function init()
    {
        add_filter('timber_context', array(get_class(), 'registerMenu'));
        add_filter('timber_context', array(get_class(), 'addToTimberContext'));
    }

    public static function registerMenu($data)
    {
        $data['menu'] = new \TimberMenu();

        return $data;
    }

    public static function addToTimberContext($data)
    {
        $data['typekit_src'] = Config::getTypekitSrc();
        $data['wp_footer'] = \TimberHelper::function_wrapper('wp_footer');
        $data['wp_head'] = \TimberHelper::function_wrapper('wp_head');
        $data['use_ga'] = Analytics::shouldIncludeGoogleAnalytics();
        $data['ga_code'] = Analytics::getGoogleAnalyticsCode();
        $data['use_crazyegg'] = Analytics::shouldIncludeCrazyEgg();

        return $data;
    }

}