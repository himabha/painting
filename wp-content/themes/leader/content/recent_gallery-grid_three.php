<?php
/**
 * Recent Gallery: Grid Three
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $_current_widget_instance;

$categories = '';
if ( 'hide' !== $_current_widget_instance['show_category'] ) :
	$categories_terms = get_the_terms( null, 'pojo_gallery_cat' );
	if ( ! empty( $categories_terms ) && ! is_wp_error( $categories_terms ) )
		$categories = wp_list_pluck( $categories_terms, 'name' );
endif;
?>
<div class="recent-gallery grid-item gallery-item col-md-4 col-sm-6 col-xs-12">
	<div class="inbox">
		<?php if ( $image_url = Pojo_Thumbnails::get_post_thumbnail_url( array( 'width' => '600', 'height' => '555', 'crop' => true, 'placeholder' => true ) ) ) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" class="image-link">
				<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="media-object image-radius-top" />
				<div class="overlay-image"></div>
				<div class="overlay-title">
					<i class="fa fa-bars"></i>
				</div>
			</a>
		<?php endif; ?>
		<div class="caption">
			<h4 class="grid-heading entry-title">
				<?php if ( 'hide' !== $_current_widget_instance['show_title'] ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php endif; ?>				<?php if ( ! empty( $categories ) ) : ?>
					<small><?php echo implode( ', ', $categories ); ?></small>
				<?php endif; ?>
			</h4>
		</div>
	</div>
</div>