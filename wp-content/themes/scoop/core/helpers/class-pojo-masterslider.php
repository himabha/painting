<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_MasterSlider {
	
	protected static $_slides = array();
	protected static $_index  = 1;

	/**
	 * @param $options
	 *
	 * @return bool
	 */
	public static function add_slider( $options ) {
		$options = wp_parse_args( $options, array(
			'params' => array(),
			'id' => '',
			'arrows' => true,
			'lightbox' => false,
			'thumblist' => true,
			'thumblist_params' => array(),
			'bullets' => false,
			'bullets_params' => array(),
		) );

		$options['params'] = wp_parse_args( $options['params'], array(
			'width' => 1920,
			'height' => 1080,
			'loop' => true,
			'autoplay' => true,
			'space' => 0,
			'centerControls' => false,
			'fullwidth' => true,
		) );

		$options['thumblist_params'] = wp_parse_args( $options['thumblist_params'], array(
			'dir' => 'h',
			'autohide' => false,
		) );

		$options['bullets_params'] = wp_parse_args( $options['bullets_params'], array(
			'dir' => 'h',
			'autohide' => true,
		) );
		
		if ( empty( $options['id'] ) )
			return false;
		
		$params = $options['params'];
		
		self::$_slides[] = array(
			'id' => $options['id'],
			'params' => $params,
			'arrows' => $options['arrows'],
			'lightbox' => $options['lightbox'],
			'thumblist' => $options['thumblist'],
			'thumblist_params' => $options['thumblist_params'],
			'bullets' => $options['bullets'],
			'bullets_params' => $options['bullets_params'],
		);
		
		return true;
	}

	/**
	 * return void
	 */
	public static function wp_footer() {
		?><script type="text/javascript">var PojoSliders=<?php echo json_encode( self::$_slides ); ?>;</script><?php
	}

	/**
	 * @return int
	 */
	public static function get_index() {
		return self::$_index++;
	}

}
add_action( 'wp_footer', array( 'Pojo_MasterSlider', 'wp_footer' ) );