<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Theme_Template extends Pojo_Templates {

	protected function _print_start_layout_default() {
		?>
		<section id="main" class="<?php echo MAIN_CLASSES; ?> sidebar-right" role="main">
	<?php
	}

	protected function _print_end_layout_default() {
		?>
		</section><!-- section#main -->
		<?php get_sidebar(); ?>
	<?php
	}

	protected function _print_start_layout_sidebar_left() {
		?>
		<section id="main" class="<?php echo MAIN_CLASSES; ?> sidebar-left" role="main">
	<?php
	}

	protected function _print_end_layout_sidebar_left() {
		?>
		</section><!-- section#main -->
		<?php get_sidebar(); ?>
	<?php
	}

	protected function _print_start_layout_full() {
		?>
		<section id="main" class="<?php echo FULLWIDTH_CLASSES; ?> full-width" role="main">
	<?php
	}

	protected function _print_end_layout_full() {
		?>
		</section><!-- section#main -->
	<?php
	}

	protected function _print_start_layout_section() {
		?>
		<section id="main" role="main">
	<?php
	}

	protected function _print_end_layout_section() {
		?>
		</section><!-- section#main -->
	<?php
	}

	public function pojo_before_content_loop( $display_type ) {
		if ( in_array( $display_type, array( 'grid_two', 'grid_three', 'grid_four', 'gallery_grid_four', 'gallery_grid_three' ) ) ) :
			echo '<div id="grid-items" class="row">';
		elseif ( in_array( $display_type, array( 'gallery_square' ) ) ) :
			echo '<div id="grid-items">';
		elseif ( in_array( $display_type, array( 'masonry', 'gallery_masonry' ) ) ) :
			echo '<div id="masonry-items" class="row">';
		else :
			echo '<div id="list-items">';
		endif;
	}

	public function pojo_after_content_loop( $display_type ) {
		echo '</div>';
	}

	public function po_display_types( $display_types = array(), $cpt ) {
		if ( 'post' === $cpt ) {
			$display_types['blog']          = __( 'Blog', 'pojo' );
			$display_types['grid_two'] = __( 'Grid Two', 'pojo' );
			$display_types['grid_three'] = __( 'Grid Three', 'pojo' );
			$display_types['grid_four']  = __( 'Grid Four', 'pojo' );
			$display_types['masonry']       = __( 'Masonry', 'pojo' );
		}
		
		if ( 'pojo_gallery' === $cpt ) {
			$display_types['gallery_square']     = __( 'Square', 'pojo' );
			$display_types['gallery_grid_three'] = __( 'Grid Three', 'pojo' );
			$display_types['gallery_grid_four']  = __( 'Grid Four', 'pojo' );
			$display_types['gallery_masonry']    = __( 'Masonry', 'pojo' );
		}
		
		return $display_types;
	}
	
	public function pojo_recent_galleries_layouts( $styles = array() ) {
		$styles['grid_three'] = __( 'Grid Three', 'pojo' );
		$styles['grid_four']  = __( 'Grid Four', 'pojo' );
		$styles['square']     = __( 'Square', 'pojo' );

		return $styles;
	}

	public function pojo_recent_posts_layouts( $styles = array() ) {
		$styles['list']       = __( 'List', 'pojo' );
		$styles['grid_two'] = __( 'Grid Two', 'pojo' );
		$styles['grid_three'] = __( 'Grid Three', 'pojo' );
		$styles['grid_four']  = __( 'Grid Four', 'pojo' );

		return $styles;
	}

	public function pojo_recent_post_before_content_loop( $style ) {
		if ( in_array( $style, array( 'grid_two', 'grid_three', 'grid_four' ) ) ) :
			echo '<div class="row recent-post-wrap-grid">';
		else :
			echo '<div class="list-items">';
		endif;
	}

	public function pojo_recent_post_after_content_loop( $style ) {
		if ( in_array( $style, array( 'list', 'grid_two', 'grid_three', 'grid_four' ) ) ) :
			echo '</div>';
		endif;
	}

	public function pojo_recent_gallery_before_content_loop( $style ) {
		if ( in_array( $style, array( 'grid_three', 'grid_four' ) ) ) :
			echo '<div class="row recent-galleries-wrap-grid">';
		elseif ( in_array( $style, array( 'square' ) ) ) :
			echo '<div class="recent-galleries-wrap-grid">';
		endif;
	}

	public function pojo_recent_gallery_after_content_loop( $style ) {
		if ( in_array( $style, array( 'grid_three', 'grid_four', 'square' ) ) ) :
			echo '</div>';
		endif;
	}

	public function hide_breadcrumbs_in_content( $return, $have_sub_header, $view ) {
		return 'content' !== $view;
	}

	public function default_layout( $default ) {
		return Pojo_Layouts::LAYOUT_FULL;
	}

	public function default_layout_post( $default ) {
		return Pojo_Layouts::LAYOUT_SIDEBAR_RIGHT;
	}

	public function __construct() {
		add_filter( 'pojo_default_layout', array( &$this, 'default_layout' ) );
		add_filter( 'pojo_default_layout_post', array( &$this, 'default_layout_post' ) );
		
		parent::__construct();
	}

}