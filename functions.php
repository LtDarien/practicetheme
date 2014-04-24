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

function practicetheme_post_types() {
	$types = array(
		'pt_staff' => array(
			'menu_title' => 'Staff',
			'plural' => 'People',
			'singular' => 'Person',
			'supports' => array('title','editor','excerpt','thumbnail','author','page-attributes'),
			'slug' => 'staff'
			), 
		'pt_menu' => array(
			'menu_title' => 'Menu',
			'plural' => 'Items',
			'singular' => 'Item',
			'supports' => array('title','editor','excerpt','thumbnail','author','page-attributes'),
			'slug' => 'menu'
			)
		);
	$counter = 0;
	foreach($types as $type => $arg) {
		$labels = array(
			'name' => $arg['menu_title'],
			'singular_name' => $arg['singular'],
			'add_new' => 'Add new',
			'add__new_item' => 'Add new '.strtolower($arg['singular']),
			'edit_item' => 'Edit '.strtolower($arg['singular']),
			'new_item' => 'New '.strtolower($arg['singular']),
			'all_items' => 'All '.strtolower($arg['plural']),
			'view_items' => 'View '.strtolower($arg['plural']),
			'search_itmes' => 'Search '.strtolower($arg['plural']),
			'not_found' => 'No '.strtolower($arg['plural']).' found',
			'not_found_in_trash' => 'No'.strtolower($arg['plural']).' found in Trash',
			'parent_item_colon' => '',
			'menu_name' => $arg['menu_title']
			 );

	register_post_type($type, array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'capability_type' => 'post',
		'supports' => $arg['supports'],
		'rewrite' => array('slug' => $arg['slug']),
		'menu_positon' => (20 + Counter),
		));
	$counter++;
	}
}
add_action('init', 'practicetheme_post_types');