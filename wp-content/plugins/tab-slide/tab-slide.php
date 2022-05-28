<?php
defined( 'ABSPATH' ) OR exit;
/*
Plugin Name: Tab Slide
Plugin URI: http://zoranc.co/tab-slide-free/
Description: Easy to use, yet powerful and a highly customizable sliding shelf for your site! Slide your target content/widget into and out of the visible page. The content can contain forms, widgets, videos, pictures, posts, menu options, comments, logins, sign-ups, popoup ads etc. The settings page appears in the Dashboard settings menu, where you can set all your tab slide options such as page source, size, positioning, autohide, opacity and much more. No coding skills are required to implement this functionality on your WordPress site. 
Version: 2.0.4
Author: Zoran C.
Author URI: http://zoranc.co/
License: GPL2
Text Domain: tab-slide
Domain Path: /languages/
*/

// Define contants
define( 'TAB_SLIDE_VERSION' , '2.0.4' );
define( 'TAB_SLIDE_ROOT' , dirname(__FILE__) );
define( 'TAB_SLIDE_FILE_PATH' , TAB_SLIDE_ROOT . '/' . basename(__FILE__) );
define( 'TAB_SLIDE_URL' , plugins_url(plugin_basename(dirname(__FILE__)).'/') );
define( 'TAB_SLIDE_SETTINGS_PAGE' , 'options-general.php?page=tab-slide' );
define( 'TAB_SLIDE_BASENAME', $plugin = plugin_basename(__FILE__) ); 
// Include necessary files, including the path in which to search to avoid conflicts
include_once( TAB_SLIDE_ROOT . '/includes/upgrade.php' );

register_uninstall_hook( __FILE__, array( 'tab_slide', 'uninstall_plugin' ) );

class Tab_Slide {
  // Unique identifier added as a prefix to all options
  var $options_group = 'tab_slide_';

  var $plugin_options = array();
  var $hook_html = array(
		'filter'=> array(
			'the_content' => '',
			'the_excerpt' => ''
			),
		'action' => array(
			'wp_footer'   => '', 
			'wp_head'     => ''
		)
	);
	
  public function __construct() {
	  // Translation files
	  load_plugin_textdomain( 'tab-slide', null, TAB_SLIDE_ROOT . '/languages/' );
	
	  // Following plugin options are written to the wp database upon plugin activation
	  $this->plugin_options = json_decode(file_get_contents(TAB_SLIDE_ROOT . '/themes/default-light.json'), true);
	
	  // Sort out the tab slide options
	  $this->load_options();
	
	  // Admin Init
	  if(is_admin()) {
      add_filter( 'plugin_action_links',     array( $this, 'tab_slide_settings_link'), 10, 2 );
      add_action( 'admin_init',              array( $this, 'admin_init' ) );
      add_action( 'admin_enqueue_scripts',   array( $this, 'add_admin_scripts'));
      add_action( 'init',                    array( $this, 'admin_menu_init' ) );
      add_action( 'save_tab_slide_settings', array( $this, 'generate_instance_css' ));			
	  } else {
      add_action( 'wp',                      array( $this, 'do_init_check' ), 10 );
	  }
    add_action( 'widgets_init',            array( $this, 'tab_slide_widgets_init' ));
  } // function __construct
  
  /**
   * activate_tab_slide ()
   *
   * Trigger events on plugin activation
   *
   * @return none
   */
  public function activate_tab_slide () {
  }
  
  /**
   * deactivate_tab_slide ()
   *
   * Trigger events on plugin deactivation
   *
   * @return none
   */
  public function deactivate_tab_slide( ) {
  }
  
  /**
   * uninstall plugin ()
   *
   * Trigger events on plugin uninstall
   * Deleted all the related tab slide options and metadata
   *
   * @return none
   */
  public static function uninstall_plugin() {
    global $tab_slide;
    $tab_slide->delete_options($tab_slide->plugin_options);
    delete_metadata( 'user', 0, 'tab_slide_admin_notice', 0, true );
  } //function uninstall_plugin
  
  /*
   * load_options ()
   *
   * Load options for the plugin.
   * If option doesn't exist in database, it is added
   * Note: default values are stored in the $this->plugin_options array
   * Note: a prefix unique to the plugin is appended to all the options. Prefix is stored in $this->options_group
   * 
   * @return none
   */
  public function load_options() {
    $new_options = array();
    foreach($this->plugin_options as $option => $value) {
      $name = $this->get_plugin_option_fullname($option);
      $return = get_option($name);
      if($return === false) {
        add_option($name, $value);
        $new_array[$option] = $value;
        if ( $name == $this->get_plugin_option_fullname('css') )
          $this->generate_instance_css();
      } else {
        $new_array[$option] = $return;
      }
    }

    $this->plugin_options = $new_array;
  } // function load_options
  
  /*
   * get_plugin_option_fullname ()
   *
   * Append the option prefix and returns the full name of the option as it is stored in the wp_options db
   *
   * @return string prefixed option name
   */
  public function get_plugin_option_fullname( $name ) {
    return $this->options_group . $name;
  } //  function get_plugin_option_fullname
  
  /**
   * get_plugin_option ()
   *
   * Return option for the plugin specified by $name, e.g. show_on_load
   * Note: The plugin option prefix does not need to be included in $name
   *
   * @param string name of the option
   * @return option|null if not found
   */
  public function get_plugin_option( $name ) {
	  if (is_array($this->plugin_options) && isset($this->plugin_options[$name]) && $option = $this->plugin_options[$name])
      return $option;
	  else 
      return null;
  } //function get_plugin_option
  
  /**
   * update_plugin_option ()
   *	 
   * Update option for the plugin specified by $name, e.g. show_on_load
   * Note: The plugin option prefix does not need to be included in $name 
   * 
   * @param string name of the option
   * @param string value to be set
   *
   */
  public function update_plugin_option( $name, $new_value ) {
    if( is_array($this->plugin_options) /*&& !empty( $this->plugin_options[$name] )*/ ) {
      $this->plugin_options[$name] = $new_value;
      update_option( $this->get_plugin_option_fullname( $name ), $new_value );
    }
  } // function update_plugin_option
  
  /**
   * delete_options ()
   *
   * Delete all the options provided
   * Note: The plugin option prefix does not need to be included in $name 
   * 
   * @param array options to be deleted
   * @return none
   *
   */
  public function delete_options ($my_options) {
	  if (!is_string($my_options)){
      foreach (array_keys($my_options) as $value) {
        $name = $this->get_plugin_option_fullname($value);
        delete_option($name);	
      }
	  }
  } // function delete_options
  
  /**
   * generate_instance_css ()
   *
   * Generate CSS based on $this->plugin_options provided
   * NOTE: stored in the 'css' index of database instance option array
   *
   * @return bool true
   */
  public function generate_instance_css() {
    $instance = $this->plugin_options;
    if ( $instance['cssonly'] == 0 || $instance['css'] == "" ) {
      ob_start();
      require('includes/css.php');
      $css = ob_get_clean();
      if ($instance['css'] == "")				
        $this->update_plugin_option( 'css', $css );
    } else {
      $css = $instance['css'];
    }
    file_put_contents(TAB_SLIDE_ROOT . '/ts.css', $css, LOCK_EX); // Save it
    return true;
  } // function generate_instance_css
  
  /**
   * tab_slide_settings_link ()
   *
   * Create a 'Settings' link on the main plugin settings page
   *
   * @param array of available links
   * @param string filename to check against to add the link to the correct plugin
   * @return bool true
   */
  public function tab_slide_settings_link($links, $file ) {
    static $this_plugin;
    if (!$this_plugin) {
      $this_plugin = plugin_basename(__FILE__);
    }
    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
      $settings_link = '<a href="options-general.php?page=tab-slide">Settings</a>'; 
      array_unshift($links, $settings_link); 
    }
    return $links; 
  } // function tab_slide_settings_link
  
  /**
   * admin_init ()
   *
   * Register tab slide settings and iterate through the version upgrade mechanism if need be
   *
   * @param none
   * @return none
   */
  public function admin_init() {
    do_action( 'tab_slide_admin_init');
    foreach($this->plugin_options as $option => $value) {
	    register_setting($this->options_group, $this->get_plugin_option_fullname($option));
    }
    
    // Upgrade if need be
    $tab_prev_version = $this->get_plugin_option('version');
    if ( version_compare( $tab_prev_version, TAB_SLIDE_VERSION, '<' ) ) tab_slide_upgrade($tab_prev_version);
  } //  function admin_init
  
  /**
   * add_admin_scripts ()
   *
   * Enqueue the necessary tab slide settings page scripts
   *
   * @param none
   * @return none
   */
  public function add_admin_scripts() {
    if (is_admin()) {
      if (array_key_exists ( 'page' , $_REQUEST ) && $_REQUEST['page'] == 'tab-slide') {
        wp_enqueue_style( 'tab_slide_settings', TAB_SLIDE_URL . '/assets/css/settings.css' );
        wp_enqueue_script('jquery');
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );
        wp_enqueue_script( 'tab_slide_settings', TAB_SLIDE_URL . '/assets/js/settings.js' );
        wp_localize_script('tab_slide_settings', 'j_options', $this->plugin_options);
        wp_localize_script( 'tab_slide_settings', 'PostAjax', array(
          'ajaxurl' => admin_url( 'admin-ajax.php' ),
          'postNonce' => wp_create_nonce( 'tabslide-post-nonce' ))
        );
        do_action( 'tab_slide_add_admin_scripts' );
      }
    }
  } // function add_admin_scripts
  
  /**
   * admin_menu_init ()
   *
   * Initialize the admin menu hook
   *
   * @return none
   */
  function admin_menu_init() {
    if(is_admin()) {
      $api_key = $this->get_plugin_option('pro_api_key');
      if ( $this->check_api_key($api_key) ) {
        include(TAB_SLIDE_ROOT . '/includes/check-api.php');
        $tab_slide_pro_check = new Tab_Slide_Pro_Check();
      }
      //Add the necessary pages for the plugin 
      add_action('admin_menu', array($this, 'add_menu_items'));
    }
  } // function admin_menu_init
  
  /**
   * add_menu_items ()
   *
   * Deal with the settings page class and related options
   *
   * @return none
   */
  public function add_menu_items ( ) {
    // Add Top-level Admin Menu
    include_once( TAB_SLIDE_ROOT . '/includes/settings.php' );
    $this->settings = new Tab_Slide_Settings();
    add_options_page('Tab Slide', 'Tab Slide', 'manage_options', 'tab-slide',  array($this->settings , 'tab_slide_options_page'));
  } // function add_menu_items
  
  /**
   * tab_slide_widgets_init ()
   *
   * Register the tab slide widget area
   *
   * @return none
   */
  public function tab_slide_widgets_init() {
    // Enable the Tab Slide Widget Area if template_pick set to Widget
    if ( 'Widget' == $this->get_plugin_option('template_pick') ) {
      register_sidebar( array(
        'name' => 'Tab Slide',
        'id' => 'tab-slide',
        'description' => 'The tab slide widget area',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
      ) );
    }
  } // function tab_slide_widgets_init
  
  /**
   * do_init_check ()
   *
   * Initialize all the checks to determine whether to load tab slide
   *
   * @param none
   * @return none
   */
  public function do_init_check() {
    $instance_options = $this->plugin_options;
    do_action( 'tab_slide_init_check', $instance_options );
    $show_instance = false;
    $check_credentials = false;
    $check_through_arrays = $this->check_through_arrays($instance_options);
    if ( $check_through_arrays )
      $check_credentials = $this->check_credentials($instance_options);
    if ( $check_credentials )
      $show_instance = $this->check_device($instance_options);
	
    $show_instance = apply_filters( 'tab_slide_show_instance', $show_instance, $this->plugin_options, $GLOBALS['pagenow']);
	
    if ($show_instance && $this->plugin_options['list_pick'] == 'shortcode' ) {
      add_shortcode( 'tabslide', array( $this, 'shortcode_handler' ) );
    } else if ($show_instance) {
      //add_filter( 'the_content', array( $this, 'append_html_from_template'), 1);
      $this->append_html_from_template($this->plugin_options);
      add_action( 'wp_enqueue_scripts', array( $this, 'load_front_end_scripts' ));
      add_action( 'wp_enqueue_scripts', array( $this, 'load_front_end_styles' ));
      add_shortcode( 'tabslide', array( $this, 'clear_shortcode_handler' ) );
    } else {
      add_shortcode( 'tabslide', array( $this, 'clear_shortcode_handler' ) );
    }
  } // function do_init_check
  
  /**
   * check_through_arrays ()
   *
   * Check through the exclude/include and disabled pages arrays
   *
   * @param array instance options that hold the arrays to check through
   * @return bool true/false if the instance should be shown/hidden based on include/exclude/disable options
   */
  public function check_through_arrays($instance_options) {

    $show_instance = false;
	
    $current_page_id = get_the_ID();
    $exclude_array = $instance_options['exclude_list'] == "" ? -1 : array_map('trim',explode(",", $instance_options['exclude_list']));
    $include_array = $instance_options['include_list'] == "" ? -1 : array_map('trim',explode(",", $instance_options['include_list']));
    $disabled_pages_array = $instance_options['disabled_pages'] == "" ? -1 : array_map('trim',explode(",", $instance_options['disabled_pages']));

    if($instance_options['list_pick'] == 'exclude' && !in_array( $GLOBALS['pagenow'], $disabled_pages_array )) {
      $show_instance = !in_array($current_page_id, $exclude_array);
    } else if($instance_options['list_pick'] == 'include' && !in_array( $GLOBALS['pagenow'], $disabled_pages_array )){
      $show_instance =  in_array($current_page_id, $include_array);
    } else if ($instance_options['list_pick'] == 'all'  && !in_array( $GLOBALS['pagenow'], $disabled_pages_array ) ){
      $show_instance = true;
    } else if ($instance_options['list_pick'] == 'shortcode'){
      $show_instance = true;
    }
    return $show_instance;
  } // function check_through_arrays
  
  /**
   * check_credentials ()
   *
   * Check if tab slide should show based on login credentials
   *
   * @param array instance options that hold the arrays to check through
   * @return bool true
   */
  public function check_credentials($instance_options) {
    do_action( 'tab_slide_check_credentials', $instance_options );

    $show_instance = false;

    switch ( $instance_options['credentials'] ) {
      case "all":
	        $show_instance = true;
        break;
      case "auth":
        if ( is_user_logged_in() )
	        $show_instance = true;
        break;
      case "unauth":
        if ( !is_user_logged_in() )
	        $show_instance = true;
        break;
	  }
    return apply_filters( 'tab_slide_check_credentials', $show_instance, $instance_options, $GLOBALS['pagenow']);
  } // function check_credentials
  
  /**
   * check_device()
   *
   * Check if tab slide should show based on device settings
   *
   * @param array instance options that hold the device settings to check through
   * @return bool true if meets the conditions of the device setting 
   */
  public function check_device($instance_options) {
    do_action( 'tab_slide_check_device', $instance_options );

    $show_instance = false;
    if ( isset($instance_options['device']) ) {
      switch ( $instance_options['device'] ) {
        case "all":
          $show_instance = true;
          break;
        case "mobile":
	        if ( wp_is_mobile() )
		        $show_instance = true;
	        break;
        case "desktop":
	        if ( !wp_is_mobile() )
		        $show_instance = true;
	        break;
        default:
		        $show_instance = true;
	        break;
      }
    } else {
      $show_instance = true;
	  }
    return apply_filters( 'tab_slide_check_device', $show_instance, $instance_options);
  } // function check_device
  
  /**
   * append_html_from_template ()
   *
   * Content filter handler: append the html generated from the template
   * Remove the filter handle, after the tab slide html has been included once
   *
   * @param  string html content
   * @return string modified html content
   */
  public function append_html_from_template($instance_options) {
    switch ( $instance_options['hook'] ) {
	      case "the_content":
	        $this->hook_html['filter']['the_content'] .= $this->load_html_from_template($instance_options);
	      break;
	      case "the_excerpt":
	        $this->hook_html['filter']['the_excerpt'] .= $this->load_html_from_template($instance_options);
	      break;
	      case "wp_footer":
	        $this->hook_html['action']['wp_footer'] .= $this->load_html_from_template($instance_options);
	      break;
	      case "wp_head":
	        $this->hook_html['action']['wp_head'] .= $this->load_html_from_template($instance_options);
	      break;
	      case "custom_filter":
	        $hook = $instance_options['hook_custom'];
	        $this->hook_html['filter'][$hook] = $this->load_html_from_template($instance_options);
	      break;
        default:
          $this->hook_html['filter']['the_content'] .= $this->load_html_from_template($instance_options);
        break;
    }
    foreach ($this->hook_html['action'] as $hook => $html) {
	    if ($html != '') {
	      add_action( $hook, array( $this, 'append_html_via_action') );
	    }
    }
    foreach ($this->hook_html['filter'] as $hook => $html) {
	    if ($html != '') {
	      add_filter( $hook, array( $this, 'append_html_via_filter'), 1 );
	    }
    }
  } // function append_html_from_template
  
  public function append_html_via_filter($content) {
    $current_hook = current_filter();
    $content .= $this->hook_html['filter'][$current_hook];
    remove_filter( $current_hook, array($this, 'append_html_via_filter'));
    return $content;
  } // function append_html_via_filter
  
  public function append_html_via_action() {
     $current_hook = current_filter();
     remove_action( $current_hook, array($this, 'append_html_via_action'));
     echo $this->hook_html['action'][$current_hook];
  } // function append_html_via_action
  
  /**
   * load_html_from_template ()
   * 
   * Generate the content html to be included
   *
   * @return string html of the include div
   */
  public function load_html_from_template() {
    $instance_options = $this->plugin_options;
    do_action('tab_slide_html_instance', $instance_options);
    $url = $instance_options['window_url'];
    if (substr($url, 0, 7) == 'http://') {
        //$url = substr($url, strlen(get_site_url()));
    } else if ( substr($url, 0, 1) != '/' ) {
        $url = ABSPATH . '/' . $url;
    } else {
        $url = TAB_SLIDE_ROOT . $url;
    }

    $url = apply_filters('tab_slide_url', $url, $instance_options);

    $instance = $instance_options;
    $html = "<div id='tab_slide_include' style='display: none'>";
    ob_start();
    include ( $url );
    $html .= ob_get_clean();
    $html .= "</div>";

    return apply_filters('tab_slide_include_container_html', $html, $instance_options);
  } // function load_html_from_template
  
  /**
   * shortcode_handler ()
   * 
   * Load the necessary styles and scripts and echo the HTML for the tab slide instance
   *
   * @return none
   */
  public function shortcode_handler() {
    do_action('tab_slide_shortcode', $this->plugin_options);
    add_action( 'wp_footer', array( $this, 'load_front_end_scripts' ));
    add_action( 'wp_footer', array( $this, 'load_front_end_styles' ));
    echo $this->load_html_from_template();
  } // function shortcode_handler
  
  /**
   * clear_shortcode_handler ()
   *
   * This handler is used to display nothing if the settings aren't set to use shortcodes
   *
   * @return none
   */
  public function clear_shortcode_handler(){
    do_action('tab_slide_shortcode_hide', $this->plugin_options);
  }
  
  /**
   * load_front_end_styles ()
   *
   * Register and enqueue front end styles
   *
   * @return none
   */
  public function load_front_end_styles() {
    $tsStyleUrl = apply_filters( 'tab_slide_css_url', TAB_SLIDE_URL . 'ts.css', 'tab_slide_StyleSheet' );
    wp_register_style('tab_slide_StyleSheet', $tsStyleUrl);
    wp_enqueue_style( 'tab_slide_StyleSheet');

    do_action('tab_slide_front_end_styles', $this->plugin_options, 'tab_slide_StyleSheet');
  } // function load_front_end_styles
  
  /**
   * load_front_end_scripts ()
   *
   * Register and enqueue front end scripts
   *
   * @return none
   */
  public function load_front_end_scripts() {

    $j_options = $this->plugin_options;
    $j_options['site_url'] = site_url();
    
    $j_options = apply_filters('tab_slide_options', $j_options);
    
    $json_str = json_encode($j_options);		
    $params = array(
	    'j_options' => $json_str
    );

    wp_enqueue_script('jquery');	
    //JS TAB-SLIDE frontend
    $tsScriptUrl = apply_filters( 'tab_slide_js_url', TAB_SLIDE_URL . 'assets/js/tab_slide.js', $params, 'tab_slide_script' );
    wp_register_script('tab_slide_script', $tsScriptUrl, false); 
    wp_enqueue_script('tab_slide_script');
    wp_localize_script('tab_slide_script', 'j_options', $params);

    do_action('tab_slide_front_end_scripts', $params,'tab_slide_script');
  } // function load_front_end_scripts
  
	public function check_api_key($api_key) {
      return preg_match('/^[a-f0-9]{32}$/', $api_key);
	}
} // END: class tab_slide

// Create new instance of the tab_slide object
global $tab_slide;
$tab_slide = new Tab_Slide();
// Hook to perform action when plugin activated
register_activation_hook( TAB_SLIDE_FILE_PATH, array(&$tab_slide, 'activate_tab_slide'));

/**
 * tab_pro_loaded()
 *
 * Allow dependent plugins and core actions to attach themselves in a safe way
 *
 * @return none
 */
function tab_slide_loaded() {
  do_action( 'tab_slide_loaded' );
}
add_action( 'plugins_loaded', 'tab_slide_loaded', 10 );
