<?php
// Handles all current and future upgrades for tab_slide
function tab_slide_upgrade( $from ) {
	if ( !$from || version_compare( $from, '2.0.0', '<' ) ) tab_slide_upgrade_200();
	if ( !$from || version_compare( $from, '2.0.1', '<' ) ) tab_slide_upgrade_201();
	if ( !$from || version_compare( $from, '2.0.2', '<' ) ) tab_slide_upgrade_202();
	if ( !$from || version_compare( $from, '2.0.3', '<' ) ) tab_slide_upgrade_203();
	if ( !$from || version_compare( $from, '2.0.4', '<' ) ) tab_slide_upgrade_204();
}
// Upgrade to 2.0.4
function tab_slide_upgrade_204() {
	global $tab_slide;
	$tab_slide->update_plugin_option( 'version', '2.0.4' );
	if ( $tab_slide->get_plugin_option( 'animation_closing_speed') === null )
  	$tab_slide->update_plugin_option( 'animation_closing_speed', 1 );
	if ( $tab_slide->get_plugin_option( 'scroll_percentage_start') === null )
  	$tab_slide->update_plugin_option( 'scroll_percentage_start', 90 );
	if ( $tab_slide->get_plugin_option( 'scroll_percentage_end') === null )
  	$tab_slide->update_plugin_option( 'scroll_percentage_end', 100 );
  if ( $tab_slide->get_plugin_option( 'picture_url') === "wp-content/plugins/tab-slide/images/TabSlideLogo.png" )
    $tab_slide->update_plugin_option( 'picture_url', "wp-content/plugins/tab-slide/assets/images/TabSlideLogo.png" );
  $image_path = $tab_slide->get_plugin_option( 'tab_image');
  if (  $image_path === "images/plus-dark.png"  || $image_path === "images/plus-light.png" )
    $tab_slide->update_plugin_option( 'tab_image', "assets/" . $image_path );
}
// Upgrade to 2.0.3
function tab_slide_upgrade_203() {
	global $tab_slide;
	$tab_slide->update_plugin_option( 'version', '2.0.3' );
	if ( $tab_slide->get_plugin_option( 'hook') === null )
		$tab_slide->update_plugin_option( 'hook', 'the_content' );
	if ( $tab_slide->get_plugin_option( 'hook_custom') === null )
		$tab_slide->update_plugin_option( 'hook_custom', 'tab_slide_append_content' );
	// Convert true false tab type to image, text custom and scroll
	if ( $tab_slide->get_plugin_option( 'tab_type') === 1 ) {
		$tab_slide->update_plugin_option( 'tab_type', 'image' );
	} else if (  $tab_slide->get_plugin_option( 'tab_type' ) === 0 ) {
		$tab_slide->update_plugin_option( 'tab_type', 'text' );
	}
	if ( $tab_slide->get_plugin_option( 'tab_element' ) === null )
		$tab_slide->update_plugin_option( 'tab_element', '.make_it_slide' );
	if ( $tab_slide->get_plugin_option( 'pro_api_key' ) === null )
		$tab_slide->update_plugin_option( 'pro_api_key', 'Enter Your Api Key Here' );
}
// Upgrade to 2.0.2
function tab_slide_upgrade_202() {
	global $tab_slide;
	$tab_slide->update_plugin_option( 'version', '2.0.2' );
}
// Upgrade to 2.0.1
function tab_slide_upgrade_201() {
	global $tab_slide;
	$tab_slide->update_plugin_option( 'version', '2.0.1' );
	if ( $tab_slide->get_plugin_option( 'device') == null ) 
		$tab_slide->update_plugin_option( 'device', 'all' );
	if ( $tab_slide->get_plugin_option( 'enable_open_timer') == null ) 
		$tab_slide->update_plugin_option( 'enable_open_timer', false );
	
	// Update the window url to the new "/templates/Template.php" format if needed
	$url = $tab_slide->get_plugin_option('window_url');
	if ( substr($url, 0, 7) !== 'http://' ) {
			$template_extract = explode('wp-content\/plugins\/tab-slide', $url);
			if (isset($template_extract[1])) {
  			$new_url_format = $template_extract[1];
				$tab_slide->update_plugin_option('window_url', $new_url_format);
			}
	}

}
// Upgrade to 2.0.0
function tab_slide_upgrade_200() {
	global $tab_slide;
	$tab_slide->update_plugin_option( 'version', '2.0.0' );
	if ( $tab_slide->get_plugin_option( 'include_method') !== null )
		delete_option( $tab_slide->get_plugin_option_fullname('include_method') );
}
