<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Gateway_PPEC_With_PayPal extends WC_Gateway_PPEC {
	public function __construct() {
		$this->id   = 'ppec_paypal';
		$this->icon = 'https://www.paypalobjects.com/webstatic/en_US/i/buttons/pp-acceptance-small.png';

		parent::__construct();

		if ( $this->is_available() ) {
			$ipn_handler = new WC_Gateway_PPEC_IPN_Handler( $this );
			$ipn_handler->handle();
		}
	}
}
