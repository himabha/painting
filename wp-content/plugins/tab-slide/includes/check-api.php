<?php
class Tab_Slide_Pro_Check 
{
  public function __construct() {
			add_action( 'admin_init',                 array( $this, 'activate_autoupdate' ) );
    	add_filter( 'upgrader_source_selection', 	array( $this, 'rename_tsp_zip' ), 1, 3 );
    	add_filter( 'http_request_args',          array( $this, 'tsp_deactivate_wp_org_update' ), 5, 2 );
  }
	public function get_version() {
	    if ( ! function_exists( 'get_plugins' ) )
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	    $plugin_data = get_plugin_data( __FILE__ );
	    return $plugin_data['Version'];
	}
	public function activate_autoupdate() {
	    global $tab_slide;
	    require ( TAB_SLIDE_ROOT . '/includes/update.php' ); 
	    $tsp_api_key = $tab_slide->get_plugin_option('pro_api_key');
	    $ts_current_version = self::get_version();
	    $ts_remote_path = 'http://store.zoranc.co/autoupdate/?p=tab-slide-pro&key='.$tsp_api_key;
	    $ts_slug = TAB_SLIDE_BASENAME;//plugin_basename(__FILE__);
	    new Tab_Slide_Pro_Auto_Update ($ts_current_version, $ts_remote_path, $ts_slug, $tsp_api_key);  
	}
	public function rename_tsp_zip( $source, $remote_source, $thiz ) {
		if(  strpos( $source, 'tab-slide' ) === false )
			return $source;

		$path_parts = pathinfo($source);
		$newsource = trailingslashit($path_parts['dirname']). trailingslashit( 'tab-slide-pro' );
		rename($source, $newsource);
		return $newsource;
	}
	public function tsp_deactivate_wp_org_update( $r, $url ) {
	    if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
		return $r;
	  
	    $plugins = unserialize( $r['body']['plugins'] );
	    unset( $plugins->plugins[ TAB_SLIDE_BASENAME ] );
	    unset( $plugins->active[ array_search( TAB_SLIDE_BASENAME, $plugins->active ) ] );
	    $r['body']['plugins'] = serialize( $plugins );
	    return $r;
	}
}
?>
