<?php
/** Wordpress Practice Theme  
*
*/

if (!function_exists('practicetheme_setup')):
	function praticetheme_sethp() {
		// Add default posts and comments RSS feed
		add_theme_support('automatic-feed-links' );

		//Enable support for post thumbnails 
		add_theme_support('post-thumbnails' );
	}
endif; //practicetheme_setup
add_action('after_setup_theme','practicetheme_setup' );


//Enqueue scripts and styles 
function practicetheme_scripts_and_styles() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', practicetheme,);