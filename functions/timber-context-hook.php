<?php

add_theme_support('menus');

add_filter('timber_context', 'add_to_context');


function register_menu() {
	register_nav_menus(array(
		'primary' => 'Primary Navigation'
	));
}

add_action( 'init', 'register_menu' );


function add_to_context($data) {

	/** Nav **/
	$data['menu'] = new TimberMenu('primary');
	
	/** Body classes **/
	global $post;
	$template = substr(basename( get_page_template() ),0,-4);
	$slug = get_post( $post )->post_name;
	$data['page_class'] = "{$template} {$slug}";

	$data['page_title'] = $post->post_title;

	/** Check if admin bar is visible, and add class to body if it is **/
	if ( is_admin_bar_showing() ) { 
		$data['page_class'] .= " logged-in";
	}
	
	/** Header / Footer hooks **/
	$data['wp_head'] = WPHelper::function_wrapper( 'wp_head()' );
	$data['wp_footer'] = WPHelper::function_wrapper( 'wp_footer()' );
    
	return $data;
}