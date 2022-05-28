<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Licenses_Settings {

	protected $_capability = 'update_themes';
	
	protected $_page_id = 'pojo-licenses';
	
	const ACTION_NAME = 'pojo-licenses-action';
	const NONCE_NAME  = 'pojo-licenses';

	protected function _hide_license_key( $input_string ) {
		$start  = 5;
		$length = mb_strlen( $input_string ) - $start - 5;

		$mask_string  = preg_replace( '/\S/', 'X', $input_string );
		$mask_string  = mb_substr( $mask_string, $start, $length );
		$input_string = substr_replace( $input_string, $mask_string, $start, $length );

		return $input_string;
	}

	protected function _redirect_back( $message_id = '' ) {
		wp_redirect(
			add_query_arg(
				array(
					'message' => $message_id,
				),
				$this->get_setting_page_link()
			)
		);
		die();
	}

	public function get_setting_page_link() {
		return add_query_arg(
			array(
				'page' => $this->_page_id,
			),
			admin_url( 'admin.php' )
		);
	}
	
	public function get_option_key() {
		return 'pojo_license_' . get_template();
	}
	
	public function get_license_data_option_key() {
		return $this->get_option_key() . '_data';
	}

	public function get_license_key() {
		return trim( get_option( $this->get_option_key() ) );
	}

	public function manager_actions() {
		if ( empty( $_POST[ self::ACTION_NAME ] ) )
			return;

		switch ( $_POST[ self::ACTION_NAME ] ) {
			case 'update-key' :
				check_admin_referer( self::NONCE_NAME );

				if ( empty( $_POST[ $this->get_option_key() ] ) )
					$this->_redirect_back( 'pojo_update_key_empty' );
				
				$license_key = trim( $_POST[ $this->get_option_key() ] );

				if ( ! Pojo_Core::instance()->licenses->api->activate_license( $license_key ) )
					$this->_redirect_back( 'pojo_update_key_error' );
					
				update_option( $this->get_option_key(), $license_key );
				
				$this->_redirect_back( 'pojo_update_key' );
				break;
			
			case 'remove-key' :
				check_admin_referer( self::NONCE_NAME );
				Pojo_Core::instance()->licenses->api->deactivate_license( $this->get_license_key() );
				
				delete_option( $this->get_option_key() );
				
				$this->_redirect_back( 'pojo_remove_key' );
				break;
		}
	}

	public function register_menu() {
		add_submenu_page(
			'pojo-home',
			__( 'Licenses', 'pojo' ),
			__( 'Licenses', 'pojo' ),
			$this->_capability,
			$this->_page_id,
			array( &$this, 'display_page' )
		);
	}

	public function display_page() {
		$license_key = $this->get_license_key();
		?>
		<div class="wrap">
			
			<h2><?php _e( 'Licenses Setting', 'pojo' ); ?></h2>
			
			<form method="post">
				<?php wp_nonce_field( self::NONCE_NAME ); ?>
				
				<p><?php _e( 'Using this settings page you can set the license key that you purchased, then you can get automatic updates for your theme.', 'pojo' ); ?></p>
				
				<h3><?php _e( 'Your Licenses', 'pojo' ); ?></h3>

				<p><?php printf( __( 'A valid license key qualifies you for support and enables automatic updates. A license key may only be used for a several installations on WordPress sites at a time (by your order). you can deactivate it or <a href="%s" target="_blank">buy new license key</a>.', 'pojo' ), 'http://pojo.me/?utm_source=dashboard&utm_medium=link&utm_campaign=buy_license' ); ?></p>
				
				<?php if ( empty( $license_key ) ) : ?>
					<input type="hidden" name="<?php echo self::ACTION_NAME; ?>" value="update-key" />
					
					<label for="<?php echo $this->get_option_key(); ?>"><?php _e( 'Licenses Key:', 'pojo' ); ?></label>

					<input id="<?php echo $this->get_option_key(); ?>" name="<?php echo $this->get_option_key(); ?>" type="text" value="" placeholder="<?php echo sprintf( __( 'Place %s license key here', 'pojo' ), Pojo_Core::instance()->licenses->updater->theme_name ); ?>" class="regular-text" />

					<input type="submit" class="button button-primary" value="<?php _e( 'Activate', 'pojo' ); ?>" />
					
					<p class="description"><?php printf( __( 'Please enter your license key, you can find your key in <a href="%s" target="_blank">your purchases</a>. License key looks similar to this: fb351f05958872E193feb37a505a84be', 'pojo' ), 'http://pojo.me/go/my-purchases/' ); ?></p>

				<?php else : ?>
					<input type="hidden" name="<?php echo self::ACTION_NAME; ?>" value="remove-key" />
					
					<label for="<?php echo $this->get_option_key(); ?>"><?php _e( 'Licenses Key:', 'pojo' ); ?></label>

					<input id="<?php echo $this->get_option_key(); ?>" name="<?php echo $this->get_option_key(); ?>" type="text" value="<?php echo esc_attr( $this->_hide_license_key( $license_key ) ); ?>" class="regular-text" disabled />

					<input type="submit" class="button button-primary" value="<?php _e( 'Deactivate', 'pojo' ); ?>" />
					
					<?php
					$license_data = Pojo_Core::instance()->licenses->api->check_license( $license_key );
					$expires_time = strtotime( $license_data->expires );
					?>
					<?php if ( apply_filters( 'pojo_is_show_license_details', false ) ) : ?>
						<p class="description"><strong><?php _e( 'Site Count', 'pojo' ); ?>:</strong> <?php echo $license_data->site_count; ?></p>

						<p class="description"><strong><?php _e( 'Activations Left', 'pojo' ); ?>:</strong> <?php echo $license_data->activations_left; ?></p>

						<p class="description"><strong><?php _e( 'Expiration', 'pojo' ); ?>:</strong> <abbr title="<?php echo human_time_diff( $expires_time ); ?>"><?php echo date_i18n( 'F j, Y', strtotime( $license_data->expires ) ); ?></abbr></p>
					<?php endif; ?>
				<?php endif; ?>
			</form>

		</div>
	<?php
	}

	public function admin_notices() {
		switch ( filter_input( INPUT_GET, 'message' ) ) {
			case 'pojo_update_key' :
				printf( '<div class="updated"><p>%s</p></div>', __( 'Key updated. Now you can get theme updates automatically.', 'pojo' ) );
				break;
			
			case 'pojo_remove_key' :
				printf( '<div class="updated"><p>%s</p></div>', __( 'Your license have been successfully deleted.', 'pojo' ) );
				break;
			
			case 'pojo_update_key_empty' :
				printf( '<div class="error"><p>%s</p></div>', __( 'Please enter your license key.', 'pojo' ) );
				break;
			
			case 'pojo_update_key_error' :
				$license_data = get_transient( $this->get_license_data_option_key() );
				$msg = __( 'Your license key not good. Please check your key again.', 'pojo' );
				
				if ( ! empty( $license_data->error ) ) {
					switch ( $license_data->error ) {
						case 'no_activations_left' :
							$msg = __( 'No have activations left. Please upgrade your licence for auto updates.', 'pojo' );
							break;
						
						case 'expired' :
							$msg = __( 'Your license has expired. Please upgrade your licence for auto updates.', 'pojo' );
							break;
						
						case 'missing' :
							$msg = __( 'Your license has missing. Please check your key again.', 'pojo' );
							break;
						
						case 'revoked' :
							$msg = __( ' Your license has revoked.', 'pojo' );
							break;
						
						case 'item_name_mismatch' :
							$msg = sprintf( __( 'Your license has no match name. Please go to <a href="%s" target="_blank">your purchases</a> and take the right key.', 'pojo' ), 'http://pojo.me/go/my-purchases/' );
							break;
					}
				}
				printf( '<div class="error"><p>%s</p></div>', $msg );
				break;
		}
	}

	public function __construct() {
		if ( ! current_user_can( $this->_capability ) )
			return;
		
		add_action( 'admin_init', array( &$this, 'manager_actions' ), 500 );
		add_action( 'admin_menu', array( &$this, 'register_menu' ), 600 );
		
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
	}
}