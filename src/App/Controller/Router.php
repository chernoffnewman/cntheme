<?php namespace App\Controller;

abstract class Router
{
    public static function renderJSON(array $message, $status = 200)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        http_response_code($status);
        echo json_encode($message);
        exit();
    }

    protected static function verifyNonce($action = '')
    {
        $headers = getallheaders();
        return (false === isset($headers['X-Wp-Nonce']) || false !== wp_verify_nonce($headers['X-Wp-Nonce'], $action));
    }
}
