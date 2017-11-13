<?php namespace App\Model;

class Routes
{
    public static function init()
    {
        if (class_exists('Timber')) {
            if (Helper::isProduction() == false &&
                Helper::isStaging() == false
            ) {
                self::_initPrivateRoutes();
            }
            self::_initPublicRoutes();
        }

    }

    private static function _initPrivateRoutes()
    {
        require(get_template_directory() . '/src/App/private_routes.php');
    }

    private static function _initPublicRoutes()
    {
        require(get_template_directory() . '/src/App/public_routes.php');
    }

}