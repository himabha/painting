<?php

/**

 * The main template file.

 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



$view = 'archive';

if ( is_singular() )

	$view = 'single';

elseif ( is_search() )

	$view = 'search';

elseif ( is_404() )

	$view = '404';



if ( Pojo_Compatibility::is_bbpress_installed() && is_bbpress() )

	$view = 'page';



do_action( 'pojo_setup_body_classes', $view, get_post_type(), '' );


if(is_front_page()) {
	get_header('home');
} else {
	get_header();
}



do_action( 'pojo_get_start_layout', $view, get_post_type(), '' );



do_action( 'pojo_get_the_content_layout', $view, get_post_type(), '' );



do_action( 'pojo_get_end_layout', $view, get_post_type(), '' );

if(is_front_page()) {
	get_footer('home');
} else {
	get_footer();
}
