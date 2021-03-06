<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Many thanks to @Rarst for that class.

final class Pojo_Update_Blocker {

	/** @var object $blocked */
	public $blocked;

	/** @var object|boolean $api */
	public $api;

	/**
	 * @param array $blocked
	 */
	public function __construct( $blocked = array() ) {
		register_activation_hook( __FILE__, array( $this, 'delete_update_transients' ) );
		register_deactivation_hook( __FILE__, array( $this, 'delete_update_transients' ) );

		$defaults      = array( 'all' => false ) + array_fill_keys( array( 'files', 'plugins', 'themes' ), array() );
		$this->blocked = array_merge( $defaults, $blocked );

		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		$this->blocked = (object) apply_filters( 'update_blocker_blocked', $this->blocked );

		if ( $this->blocked->all ) {
			add_filter( 'pre_http_request', array( $this, 'pre_http_request' ), 10, 3 );
		} else {
			add_filter( 'http_request_args', array( $this, 'http_request_args' ), 10, 2 );
		}
	}

	public function delete_update_transients() {
		delete_site_transient( 'update_plugins' );
		delete_site_transient( 'update_themes' );
	}

	/**
	 * @param boolean $false
	 * @param array   $request_args
	 * @param string  $url
	 *
	 * @return boolean|null
	 */
	public function pre_http_request( $false, $request_args, $url ) {
		$api = $this->get_api( $url );

		return empty( $api ) ? $false : null;
	}

	/**
	 * @param array  $request_args
	 * @param string $url
	 *
	 * @return array
	 */
	public function http_request_args( $request_args, $url ) {
		$this->api = $this->get_api( $url );

		if ( empty( $this->api ) ) {
			return $request_args;
		}

		$data = $this->decode( $request_args['body'][$this->api->type] );

		if ( $this->api->is_plugin ) {
			$data = $this->filter_plugins( $data );
		} elseif ( $this->api->is_theme ) {
			$data = $this->filter_themes( $data );
		}

		$data = apply_filters( 'update_blocker_' . $this->api->type, $data );

		$request_args['body'][$this->api->type] = $this->encode( $data );

		return $request_args;
	}

	/**
	 * @param string $url
	 *
	 * @return object|boolean
	 */
	public function get_api( $url ) {
		/* @see https://github.com/cftp/external-update-api/blob/master/external-update-api/euapi.php#L45 */
		static $regex = '#://api\.wordpress\.org/(?P<type>plugins|themes)/update-check/(?P<version>[0-9.]+)/#';
		$match = preg_match( $regex, $url, $api );

		if ( $match ) {
			$api['is_serial'] = ( 1.0 == (float) $api['version'] );
			$api['is_plugin'] = ( 'plugins' === $api['type'] );
			$api['is_theme']  = ( 'themes' === $api['type'] );

			return (object) $api;
		}

		return false;
	}

	/**
	 * @param string $data
	 *
	 * @return array
	 */
	public function decode( $data ) {
		return $this->api->is_serial ? (array) unserialize( $data ) : json_decode( $data, true );
	}

	/**
	 * @param array $data
	 *
	 * @return string
	 */
	public function encode( $data ) {
		if ( $this->api->is_serial ) {
			return serialize( $this->api->is_plugin ? (object) $data : $data );
		}

		return json_encode( $data );
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function filter_plugins( $data ) {
		foreach ( $data['plugins'] as $file => $plugin ) {
			$path = trailingslashit( WP_PLUGIN_DIR . '/' . dirname( $file ) ); // TODO files without dir?

			if ( in_array( $file, $this->blocked->plugins ) || $this->has_blocked_file( $path ) ) {
				unset( $data['plugins'][$file] );
				unset( $data['active'][array_search( $file, $data['active'] )] );
			}
		}

		return $data;
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function filter_themes( $data ) {
		
		foreach ( $data['themes'] as $slug => $theme ) {

			$path = trailingslashit( wp_get_theme( $slug )->get_stylesheet_directory() );

			if ( in_array( $slug, $this->blocked->themes ) || $this->has_blocked_file( $path ) ) {
				unset( $data['themes'][$slug] );
			}
		}

		return $data;
	}

	/**
	 * @param string $path
	 *
	 * @return bool
	 */
	public function has_blocked_file( $path ) {

		foreach ( $this->blocked->files as $file ) {
			if ( file_exists( $path . $file ) ) {
				return true;
			}
		}

		return false;
	}
	
}