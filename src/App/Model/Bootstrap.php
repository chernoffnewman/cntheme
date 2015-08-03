<?php namespace App\Model;

class Bootstrap
{

    public static function init()
    {
        session_start();

        Config::init();
        Routes::init();
        Cron::init();
        Assets::enqueue();
        Twig::init();
        AdminArea::init();
        Social::init();
        Analytics::init();

        add_theme_support('post-thumbnails');
        add_theme_support('menus');

        self::_checkForRequiredPlugins();

        if (class_exists('Timber')) {
            self::_registerCustomPostTypes();

            add_filter('timber_context', array(get_class(), 'registerMenu'));
            add_filter('timber_context', array(get_class(), 'addToTimberContext'));

            \Timber::$dirname = '/src/App/View';
        }

        if (Config::isAuthRequired() === true) {
            $request_uri = $_SERVER['REQUEST_URI'];
            $path = explode('?', $request_uri);

            if (isset($path[0]) === true && $path[0] !== '/login') {
                Auth::checkAuthorization();
            }
        }
    }

    private static function _checkForRequiredPlugins()
    {
        // nag user to install all missing plugins
        $current_plugins = get_option('active_plugins');
        $required_plugins = Config::getRequiredPlugins();

        foreach ($required_plugins as $key => $required_plugin) {
            if (in_array($key, $current_plugins) === false) {
                AdminArea::addUpdateNagNotice(sprintf('Required Plugin Missing: <a href="%s">%s</a>', $required_plugin['url'], $required_plugin['title']));
            }
        }
    }

    public static function addToTimberContext($data)
    {
        return $data;
    }

    public static function registerMenu($data)
    {
        $data['menu'] = new \TimberMenu();

        return $data;
    }

    private static function _registerCustomPostTypes()
    {
        Instagram::bootstrap();
    }

}