<?php 
/** Practice Theme header file
*
*/
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes( );?> >
<head>
	<meta charset="<?php bloginfo('charset' );?>" >
	<title><?php wp_title( '|', true, 'right' );?></title>
	<!-- HTML5 SHIV for IE --> <!--if using Modernizr you can remove this script! -->
	<!-- [if lt IE9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>

		<![endif] -->
	<?php wp_head();?>
</head>
<body <?php body_class( );?>>
	<header class="site-header">
		<h1> <a href="<?php echo home_url( );?>">
			Wordpress Practice Theme </a></h1>
	</header>

	