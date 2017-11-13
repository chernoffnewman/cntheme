<?php namespace App\Model;

class Logger
{

    /**
     * @return bool
     */
    private static function hasDebugBarLogger()
    {
        return (class_exists('Debug_Bar_Custom_Info', false));
    }

    public static function info($msg)
    {
        if (true === WP_DEBUG) {
            if (self::hasDebugBarLogger() === true) {
                do_action('add_debug_info', $msg, 'info');
            }

            if (is_array($msg) || is_object($msg)) {
                error_log(
                    'INFO: ' . print_r($msg, true) . "\n", 3, WP_CONTENT_DIR . '/debug.log'
                );
            } else {
                error_log(
                    'INFO: ' . $msg . "\n", 3, WP_CONTENT_DIR . '/debug.log'
                );
            }
        }
    }

    public static function error($msg)
    {
        if (true === WP_DEBUG) {
            if (self::hasDebugBarLogger() === true) {
                do_action('add_debug_info', $msg, 'error');
            }

            if (is_array($msg) || is_object($msg)) {
                error_log(
                    'ERROR: ' . print_r($msg, true) . "\n", 3, WP_CONTENT_DIR . '/debug.log'
                );
            } else {
                error_log(
                    'ERROR: ' . $msg . "\n", 3, WP_CONTENT_DIR . '/debug.log'
                );
            }
        }
    }

    public static function warning($msg)
    {
        if (true === WP_DEBUG) {
            if (self::hasDebugBarLogger() === true) {
                do_action('add_debug_info', $msg, 'warning');
            }

            if (is_array($msg) || is_object($msg)) {
                error_log(
                    'WARNING: ' . print_r($msg, true) . "\n", 3, WP_CONTENT_DIR . '/debug.log'
                );
            } else {
                error_log(
                    'WARNING: ' . $msg . "\n", 3, WP_CONTENT_DIR . '/debug.log'
                );
            }
        }
    }
}