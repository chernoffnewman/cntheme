<?php namespace App\Model;

class Auth
{
    const INTERNAL_OFFICE_IP = '97.66.221.98';

    public static function checkAuthorization()
    {
        $ip_address = Helper::getIPAddress();
        // check if using internal office IP, if so, let 'em through
        if ($ip_address !== Auth::INTERNAL_OFFICE_IP) {
            if (isset($_SESSION['auth']) === false) {
                wp_redirect(get_site_url() . '/login');
                exit();
            }
        }
    }
}