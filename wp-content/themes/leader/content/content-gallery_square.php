<?php
/**
 * Content: Gallery Square
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $_pojo_parent_id;

$categories       = '';
$categories_terms = get_the_terms( null, 'pojo_gallery_cat' );
if ( ! empty( $categories_terms ) && ! is_wp_error( $categories_terms ) )
	$categories = wp_list_pluck( $categories_terms, 'name' );
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'pojo_post_classes', array( 'grid-item gallery-item square-item' ), get_post_type() ) ); ?>>
	<div class="inbox">
		<a class="image-link" href="<?php the_permalink(); ?>">
			<?php if ( $image_url = Pojo_Thumbnails::get_post_thumbnail_url( array( 'width' => '600', 'height' => '490', 'crop' => true, 'placeholder' => true ) ) ) : ?>
				<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="media-object" />
			<?php endif; ?>
			<div class="overlay-caption">
				<div class="caption">
					<div class="caption-inner">
						<h4 class="grid-heading entry-title">
							<?php the_title(); ?>
							<?php if ( ! empty( $categories ) ) : ?>
								<small><?php echo implode( ', ', $categories ); ?></small>
							<?php endif; ?>
						</h4>
					</div>
				</div>
			</div>
		</a>
	</div>
</div>