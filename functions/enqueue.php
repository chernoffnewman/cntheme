<?php

add_action('wp_enqueue_scripts', 'cn_add_stylesheets');
add_action('wp_enqueue_scripts', 'cn_add_scripts');

/**
 * Enqueue plugin style-file
 */
function cn_add_stylesheets()
{
	/*** add additional styles here ***/
}

function cn_add_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('respond', get_template_directory_uri() . '/js/lib/respond.min.js');
	wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js');
}

