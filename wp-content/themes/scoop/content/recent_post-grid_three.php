<?php
/**
 * Recent Post: Grid Three
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $_current_widget_instance;

$categories       = '';
$categories_terms = get_the_category();
if ( ! empty( $categories_terms ) && ! is_wp_error( $categories_terms ) ) :
	$categories = wp_list_pluck( $categories_terms, 'name' );
	$categories = $categories[0];
endif;

$format_icon_class = 'format-icon-hide';
if ( 'show' === $_current_widget_instance['metadata_format_icon'] ) :
	$format_icon_class = 'format-icon-show';
endif;
?>
<div <?php post_class( 'recent-post grid-item grid-three col-sm-4 col-xs-12 ' . $format_icon_class ); ?>>
	<div class="item-inner">
		<?php if ( 'show' === $_current_widget_instance['thumbnail'] && $image_url = Pojo_Thumbnails::get_post_thumbnail_url( array( 'width' => '460', 'height' => '295', 'crop' => true, 'placeholder' => true ) ) ) : ?>
			<div class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" class="image-link">
					<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="media-object" />
					<?php if ( ! empty( $categories ) && 'show' === $_current_widget_instance['metadata_category'] ) : ?>
						<div class="category-label"><div><span><?php echo $categories; ?></span></div></div>
					<?php endif; ?>
				</a>
				<div class="entry-meta">
					<?php if ( 'show' === $_current_widget_instance['metadata_date'] ) : ?>
						<span class="entry-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>
					<?php if ( 'show' === $_current_widget_instance['metadata_time'] ) : ?>
						<span class="entry-time"><?php echo get_the_time(); ?></span>
					<?php endif; ?>
					<?php if ( 'show' === $_current_widget_instance['metadata_comments'] ) : ?>
						<span class="entry-comment"><?php comments_popup_link( __( 'No Comments', 'pojo' ), __( 'One Comment', 'pojo' ), __( '% Comments', 'pojo' ), 'comments' ); ?></span>
					<?php endif; ?>
					<?php if ( 'show' === $_current_widget_instance['metadata_author'] ) : ?>
					<span class="entry-user"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></span>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="caption">
			<?php if ( 'show' === $_current_widget_instance['show_title'] ) : ?>
				<h4 class="grid-heading">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h4>
			<?php endif; ?>
			<?php if ( 'show' === $_current_widget_instance['except'] ) : ?>
				<div class="entry-excerpt">
					<p><?php echo pojo_get_words_limit( get_the_excerpt(), $_current_widget_instance['except_length_words'] ); ?></p>
				</div>
			<?php endif; ?>
			<?php if ( 'show' === $_current_widget_instance['metadata_readmore'] ) : ?>
				<a href="<?php the_permalink(); ?>" class="read-more"><?php echo  ! empty( $_current_widget_instance['text_readmore_mode'] ) ? $_current_widget_instance['text_readmore_mode'] : __( 'Read More &raquo;', 'pojo' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>