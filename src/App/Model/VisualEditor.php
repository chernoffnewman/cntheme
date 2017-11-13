<?php namespace App\Model;

class VisualEditor
{
    public static function init()
    {
        add_filter('tiny_mce_before_init', array(get_class(), 'beforeInit'));
        add_filter('mce_buttons_2', array(get_class(), 'mceButtons2'));

        add_editor_style(get_template_directory_uri() . '/css/visual-editor.css');
    }

    public static function mceButtons2($buttons)
    {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    public static function beforeInit($settings)
    {
        // example of adding 2 new style options for a new button "styleselect"
//        $style_formats = array(
//            array(
//                'title' => 'Gamecock Quote',
//                'block' => 'div',
//                'classes' => 'gamecock-quote',
//                'wrapper' => true
//            ),
//            array(
//                'title' => 'Clemson Quote',
//                'block' => 'div',
//                'classes' => 'clemson-quote',
//                'wrapper' => true
//            )
//        );
//
//        $settings['style_formats'] = json_encode($style_formats);

        return $settings;
    }
}
