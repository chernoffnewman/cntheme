<?php

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150 ); 
}

if ( function_exists( 'add_image_size' ) ) { 
	// add additional image sizes - example:
	// add_image_size( 'image-size-name', 1400, 1400, true ); 
}