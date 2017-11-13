<?php namespace App\Controller;

class Auth extends Router
{
    public static function routeLoginPage($params)
    {
        $context = \Timber::get_context();
        wp_enqueue_script('log-in-js', get_template_directory_uri() . '/js/log-in.js', array('jquery'), null, true);
        \Timber::render('login.twig', $context);
        exit();
    }

    public static function routeLoginAuth($params)
    {
        $code = (isset($_POST['code'])) ? sanitize_title($_POST['code']) : null;
        $status = '401';

        if (is_numeric($code) && $code === '1411') {
            // you're in!
            $status = '200';
            $_SESSION['auth'] = uniqid();
        }

        self::renderJSON(array(
            'status' => $status
        ));
    }
}