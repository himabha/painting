<?php
/*
 * Plugin Name: Pojo Sharing
 * Plugin URI: http://pojo.me/
 * Description: Share content with Facebook, Twitter, and many more.
 * Author: Pojo Team
 * Version: 2.5.9
 * Author URI: http://pojo.me/
 * Text Domain: pojo-sharing
 * Domain Path: /languages/
 * License: GPL2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'POJO_SHARING__FILE__', __FILE__ );

if ( ! function_exists( 'sharing_init' ) )
	include dirname( __FILE__ ).'/sharedaddy/sharedaddy.php';

function sharing_load_textdomain() {
	load_plugin_textdomain( 'pojo-sharing', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'sharing_load_textdomain' );
