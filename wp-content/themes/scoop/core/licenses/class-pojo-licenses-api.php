<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Pojo_Licenses_API {

	const STORE_URL = 'http://pojo.me';

	// Licenses Status
	const STATUS_VALID       = 'valid';
	const STATUS_EXPIRED     = 'expired';
	const STATUS_DEACTIVATED = 'deactivated';

	protected $_curl_args;

	public function __construct() {
		$this->_curl_args = array(
			'timeout' => 15,
			'sslverify' => false,
		);
	}

	public function activate_license( $license_key ) {
		$response = wp_remote_get(
			add_query_arg(
				array(
					'edd_action' => 'activate_license',
					'item_name' => urlencode( Pojo_Core::instance()->licenses->updater->theme_name ),
					'license' => $license_key,
				),
				self::STORE_URL
			),
			$this->_curl_args
		);

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		set_transient( Pojo_Core::instance()->licenses->settings->get_license_data_option_key(), $license_data, 12 * HOUR_IN_SECONDS );
		
		return self::STATUS_VALID === $license_data->license;
	}

	public function deactivate_license( $license_key ) {
		$response = wp_remote_get(
			add_query_arg(
				array(
					'edd_action' => 'deactivate_license',
					'item_name' => urlencode( Pojo_Core::instance()->licenses->updater->theme_name ),
					'license' => $license_key,
				),
				self::STORE_URL
			),
			$this->_curl_args
		);

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		return self::STATUS_DEACTIVATED === $license_data->license;
	}

	public function check_license( $license_key, $force_request = false ) {
		$option_key   = Pojo_Core::instance()->licenses->settings->get_option_key() . '_data';
		$license_data = get_transient( $option_key );
		
		if ( false === $license_data || $force_request ) {
			$response = wp_remote_get(
				add_query_arg(
					array(
						'license' => $license_key,
						'item_name' => urlencode( Pojo_Core::instance()->licenses->updater->theme_name ),
						'edd_action' => 'check_license',
					),
					self::STORE_URL
				),
				$this->_curl_args
			);

			if ( is_wp_error( $response ) ) {
				$license_data = new stdClass;
				
				$license_data->license          = 'http_error';
				$license_data->payment_id       = '0';
				$license_data->license_limit    = '0';
				$license_data->site_count       = '0';
				$license_data->activations_left = '0';

				set_transient( $option_key, $license_data, 30 * MINUTE_IN_SECONDS );
				return $license_data;
			}
			
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			set_transient( $option_key, $license_data, 12 * HOUR_IN_SECONDS );
		}
		
		return $license_data;
	}

	public function get_version( $license_key = '' ) {
		$body_args = array(
			'edd_action' => 'get_version_inactive',
			'name' => urlencode( Pojo_Core::instance()->licenses->updater->theme_name ),
			'slug' => Pojo_Core::instance()->licenses->updater->theme_slug,
			'version' => Pojo_Core::instance()->licenses->updater->theme_version,
			'site_url' => '',
		);
		
		if ( ! empty( $license_key ) ) {
			$body_args['edd_action'] = 'get_version';
			$body_args['license'] = $license_key;
		}
		
		$response = wp_remote_post(
			self::STORE_URL,
			wp_parse_args(
				array(
					'body' => $body_args,
				),
				$this->_curl_args
			)
		);

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		return $license_data;
	}

}