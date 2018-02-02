<?php

function all_scripts() {

    wp_enqueue_style('style-css', get_template_directory_uri() . '/assets/css/style.css','','');
    wp_enqueue_script('head', get_template_directory_uri() . '/assets/js/head.js','','');
    wp_enqueue_script('foot', get_template_directory_uri() . '/assets/js/foot.js','','',true);

}

add_action( 'wp_enqueue_scripts', 'all_scripts' );
