<?php namespace App\Model;

class Cron
{
    public static function init()
    {
        define('DISABLE_WP_CRON', true);
        add_filter('cron_schedules', array(__CLASS__, 'wi_add_weekly_schedule'));
    }

    public static function wi_add_weekly_schedule($schedules)
    {
        $schedules['weekly'] = array(
            'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds
            'display' => __('Once Weekly', Config::getTextDomain())
        );

        return $schedules;
    }
}