<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Pojo_Theme_Updater {

	public $theme_version;
	public $theme_name;
	public $theme_slug;
	
	public $response_key;

	public function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}
		return $value;
	}
	
	public function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	public function load_themes_screen() {
		add_thickbox();
		add_action( 'admin_notices', array( &$this, 'update_nag' ), 10 );
	}

	public function update_nag() {
		$api_response = get_transient( $this->response_key );

		if ( false === $api_response )
			return;

		$license_key = Pojo_Core::instance()->licenses->settings->get_license_key();
		$details_url = add_query_arg( array( 'TB_iframe' => 'true', 'width' => 1024, 'height' => 800 ), $api_response->url );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( __( 'Updating this theme will lose any files you have changes. \'Cancel\' to stop, \'OK\' to update.', 'pojo' ) ) . '\') ) {return true;}return false;"';
		$whats_new_text = sprintf( '<a href="%1$s" class="thickbox" title="%2s">' . __( 'Check out what\'s new', 'pojo' ) . '</a>', $details_url, $this->theme_name );

		if ( version_compare( $this->theme_version, $api_response->new_version, '<' ) ) {
			if ( ! empty( $license_key ) ) {
				$update_url = wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( get_template() ), 'upgrade-theme_' . get_template() );
				$update_now_text = $whats_new_text . sprintf( __( ' or', 'pojo' ) . ' <a href="%1$s"%2$s>' . __( 'update now', 'pojo' ) . '</a>', $update_url, $update_onclick );
			} else {
				$update_now_text = sprintf( __( '<a href="%s">Activate license</a> to enable automatic updates', 'pojo' ), add_query_arg( array( 'page' => 'pojo-licenses' ), admin_url( 'admin.php' ) ) ) . '. ' . $whats_new_text;
			}
			
			echo '<div id="update-nag">';
			printf( '<strong>%1$s %2$s</strong> ' . __( 'is available', 'pojo' ) . '. %3$s',
				$this->theme_name,
				$api_response->new_version,
				$update_now_text
			);
			
			echo '</div>';
		}
	}

	public function license_details() {
		$license_key = Pojo_Core::instance()->licenses->settings->get_license_key();
		if ( empty( $license_key ) ) {
			$msg = sprintf( __( '<strong>Welcome to Pojo Framework!</strong> Please <a href="%s">activate your license key</a> to enable automatic updates.', 'pojo' ), add_query_arg( array( 'page' => 'pojo-licenses' ), admin_url( 'admin.php' ) ) );
			printf( '<div class="error"><p>%s</p></div>', $msg );
			return;
		}

		$license_data = Pojo_Core::instance()->licenses->api->check_license( $license_key );
		
		if ( Pojo_Licenses_API::STATUS_EXPIRED === $license_data->license ) {
			printf( '<div class="error"><p>%s</p></div>', __( 'Your license is expired. Please renew it or purchase a new one in order to update this theme.', 'pojo' ) );
			return;
		}

		if ( Pojo_Licenses_API::STATUS_VALID === $license_data->license ) {
			$expires_time = strtotime( $license_data->expires );
			$notification_expires_time = strtotime( '-30 days', $expires_time );
			
			if ( $notification_expires_time <= current_time( 'timestamp' ) ) {
				$msg = sprintf( __( '<strong>Note:</strong> Your license key will expire in %s.', 'pojo' ), human_time_diff( current_time( 'timestamp' ), $expires_time ) );
				printf( '<div class="update-nag">%s</div>', $msg );
			}
		}
	}

	public function check_for_update() {
		$update_data = get_transient( $this->response_key );
		if ( false === $update_data ) {
			$license_key = Pojo_Core::instance()->licenses->settings->get_license_key();
			
			$failed = false;

			// Make sure the response was successful
			$update_data = Pojo_Core::instance()->licenses->api->get_version( $license_key );
			
			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			// If the response failed, try again in 30 minutes
			if ( $failed ) {
				$data = new stdClass;
				$data->new_version = $this->theme_version;
				set_transient( $this->response_key, $data, 30 * MINUTE_IN_SECONDS );
				
				return false;
			}

			// If the status is 'OK', return the update arguments
			if ( ! $failed ) {
				$update_data->sections = maybe_unserialize( $update_data->sections );
				set_transient( $this->response_key, $update_data, 12 * HOUR_IN_SECONDS );
			}
		}

		if ( version_compare( $this->theme_version, $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}

	public function __construct() {
		if ( wp_get_theme()->parent() ) {
			$this->theme_name    = wp_get_theme()->parent()->get( 'Name' );
			$this->theme_version = wp_get_theme()->parent()->get( 'Version' );
		} else {
			$this->theme_name    = wp_get_theme()->get( 'Name' );
			$this->theme_version = wp_get_theme()->get( 'Version' );
		}
		
		$this->theme_slug = sanitize_key( get_template() );
		
		// Override this from theme config
		if ( defined( 'POJO_THEME_NAME' ) )
			$this->theme_name = POJO_THEME_NAME;
		
		$this->response_key = get_template() . '-update-response';
		
		add_action( 'site_transient_update_themes', array( &$this, 'theme_update_transient' ) );
		add_filter( 'delete_site_transient_update_themes', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-update-core.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'load_themes_screen' ) );

		add_action( 'admin_notices', array( &$this, 'license_details' ), 20 );
	}
	
}