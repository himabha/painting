<?php
/**
 * Content: Gallery Masonry
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $_pojo_parent_id;

$categories       = '';
$categories_terms = get_the_terms( null, 'pojo_gallery_cat' );
if ( ! empty( $categories_terms ) && ! is_wp_error( $categories_terms ) )
	$categories = wp_list_pluck( $categories_terms, 'name' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'pojo_post_classes', array( 'grid-item gallery-item masonry-item col-lg-2 col-md-3 col-sm-6 col-xs-12' ), get_post_type() ) ); ?>>
	<div class="inbox">
		<?php if ( $image_url = Pojo_Thumbnails::get_post_thumbnail_url( array( 'width' => '600' ) ) ) : ?>
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
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
					<?php the_title(); ?>
					<?php if ( ! empty( $categories ) ) : ?>
						<small><?php echo implode( ', ', $categories ); ?></small>
					<?php endif; ?>
				</a>
			</h4>
		</div>
	</div>
</div>