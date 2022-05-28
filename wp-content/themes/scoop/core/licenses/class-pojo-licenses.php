<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Pojo_Licenses {

	/**
	 * @var Pojo_Licenses_API
	 */
	public $api;

	/**
	 * @var Pojo_Licenses_Settings
	 */
	public $settings;

	/**
	 * @var Pojo_Theme_Updater
	 */
	public $updater;

	/**
	 * @var Pojo_Update_Blocker
	 */
	public $blocker;

	public function include_settings() {
		include( POJO_CORE_DIRECTORY . '/licenses/class-pojo-licenses-settings.php' );

		$this->settings = new Pojo_Licenses_Settings();
	}

	public function __construct() {
		include( POJO_CORE_DIRECTORY . '/licenses/class-pojo-licenses-api.php' );
		include( POJO_CORE_DIRECTORY . '/licenses/class-pojo-theme-updater.php' );
		include( POJO_CORE_DIRECTORY . '/licenses/class-pojo-update-blocker.php' );
		
		$this->api     = new Pojo_Licenses_API();
		$this->updater = new Pojo_Theme_Updater();
		
		$this->blocker = new Pojo_Update_Blocker(
			array(
				'all'     => false,
				'files'   => array( '.git', '.svn', '.hg' ),
				'plugins' => array(),
				'themes'  => array( 'aleph', 'atlanta', 'berlin', 'border', 'everest', 'firma', 'frame', 'quantum', 'river', 'scoop', 'stream', 'superstar', 'titanium' ),
			)
		);
		
		add_action( 'pojo_framework_base_settings_included', array( &$this, 'include_settings' ) );
	}
	
}