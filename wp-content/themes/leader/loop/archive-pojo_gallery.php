<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$display_type = pojo_get_option( 'gallery_display_type' );
if ( empty( $display_type ) )
	$display_type = 'gallery_grid_three';
?>
<header class="entry-header">
	<?php if ( po_breadcrumbs_need_to_show() ) : ?>
		<?php pojo_breadcrumbs(); ?>
	<?php endif; ?>
	<?php if ( pojo_is_show_page_title() ) : ?>
		<div class="page-title">
			<h1 class="entry-title"><?php _e( 'Archive Galleries', 'pojo' ); ?></h1>
		</div>
	<?php endif; ?>
</header>
<?php if ( have_posts() ) : ?>
	<?php do_action( 'pojo_before_content_loop', $display_type ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php pojo_get_content_template_part( 'content', $display_type ); ?>
	<?php endwhile; ?>
	<?php do_action( 'pojo_after_content_loop', $display_type ); ?>
	<?php pojo_paginate(); ?>
<?php else : ?>
	<?php pojo_get_content_template_part( 'content', 'none' ); ?>
<?php endif; ?>
