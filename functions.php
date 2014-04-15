<?php
/** Wordpress Practice Theme  
*
*/

if (!function_exists('practicetheme_setup')):
	function practicetheme_setup() {
		// Add default posts and comments RSS feed
		add_theme_support('automatic-feed-links' );

		//Enable support for post thumbnails 
		add_theme_support('post-thumbnails' );

		//This theme usis wp_nav_menu( ) in one location
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'ao_starter'),
		));

		//enable support for Post Formats
		add_theme_support('post-formats', array('aside','image','video','quote','link') );
	}
endif; //practicetheme_setup
add_action('after_setup_theme','practicetheme_setup' );

function simple_copyright() {
	echo "&copy;".get_bloginfo( 'name' )." ".date("Y");
}


//Enqueue scripts and styles 
function practicetheme_scripts_and_styles() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	/**
	 * Better jQuery inclusion
	 */
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false);
		wp_enqueue_script('jquery');
	}
}

add_action( 'wp_enqueue_scripts', 'practicetheme_scripts_and_styles');
