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
		'menu_positon' => (20 + $counter),
		));
	$counter++;
	}
}
add_action('init', 'practicetheme_post_types');

function practicetheme_updated_messages($messages) {
	global $post, $post_ID;

	$types = array(
		'pt_staff' => 'Person',
		'pt_menu' => 'Item',
		);

	foreach($types as $type => $title) {
		$messages[$type] = array(
			0 => 1,
			1 => sprintf(__('%s updated. <a href="%s">View %s</a>'),$title, esc_url(get_permalink( $post_ID)), $title),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __(strtolower($title).' updated.'),
			5 => isset($_GET['revision']) ? sprintf(__('%s restored to previous version from %s'), $title, 
				wp_post_revision_title( (int) $_GET['revision'], false)):false,
			6 => sprintf(__('%s published. <a href="%s">View %s</a>'), $title, esc_url( get_permalink($post_ID )), strtolower($title)),
			7 => __($title.' saved'),
			8 => sprintf(__('%s submitted. <a target="_blank" href="%s">Preview %s</a>'),$title, 
				esc_url(add_query_arg('preview','true',get_permalink($post_ID))), strtolower($title)),
			9 => sprintf(__('%s scheduled for: <strong>%2$s</strong>. <a target="_blank" href="%3$s">Preview %1$s</a>'), $title,
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post -> post_date)), esc_url(get_permalink($post_ID))),
			10 => sprintf(__('%s draft updated. <a target="_blank" href="%s">Preview %s</a>'), $title, 
				esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))), strtolower($title)),
			);
	}
	return $messages;
}
add_filter('post_updated_messages', 'practicetheme_updated_messages');

function practicetheme_custom_columns($cols) {
	$cols = array(
		'cb' => '<input type="checkbox"/>',
		'title' => __('Title', 'practicetheme'),
		'photo' => __('Thumbnail', 'practicetheme'),
		'date' => __('Date', 'practicetheme'),
	 );
}
add_filter("manage_pt_staff_posts_columns", "practicetheme_custom_columns");
add_filter("manage_pt_meun_posts_columns", "practicetheme_custom_columns");

function practicetheme_custome_column_contenet( $column, $post_id) {
	switch ($column) {
		case 'photo':
			if(has_post_thumbnail($post_id)) {
				echo get_the_post_thumbnail($post_id, array(50,50));
			}
			break;
	}
}
add_action( "manage_pt_staff_posts_custom_column", "practicetheme_custome_column_contenet", 10, 2 );
add_action( "manage_pt_menu_posts_custom_column", "practicetheme_custom_column_content", 10, 2 );

function my_rewrite_flush() {
	flush_rewrite_rules( );
}
add_action( 'after_switch_theme_download', 'practice_theme_flush_rewrite_rules' );