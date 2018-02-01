<?php

function my_scripts() {

    wp_enqueue_style('style-css', get_template_directory_uri() . '/style.css');

    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js', array('jquery', 'popper-js'), null, false);
    wp_enqueue_script('modernizr-js', get_template_directory_uri() . '/bower_components/Modernizr/modernizr.custom.js', array(), null, false);
}

add_action( 'wp_enqueue_scripts', 'my_scripts' );
