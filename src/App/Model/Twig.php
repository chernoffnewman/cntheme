<?php namespace App\Model;

class Twig
{
    public static function init()
    {
        add_filter('get_twig', array(__CLASS__, 'addToTwig'));
    }

    /**
     * @param \Twig_Environment $twig
     * @return mixed
     */
    public static function addToTwig($twig)
    {
        return $twig;
    }

}
