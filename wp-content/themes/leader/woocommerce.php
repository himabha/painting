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

do_action( 'pojo_setup_body_classes', $view, get_post_type(), '' );

get_header();

do_action( 'pojo_get_start_layout', $view, get_post_type(), '' );

woocommerce_content();

do_action( 'pojo_get_end_layout', $view, get_post_type(), '' );

get_footer();