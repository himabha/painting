<?php 
// Generate the Tab Slide settings page
if ( !class_exists( 'Tab_Slide_Settings' ) ) {	
	class Tab_Slide_Settings {
		public function __construct() {
			global $tab_slide;
			add_action( 'admin_notices', array(&$this, 'tab_slide_admin_notice' ) );
			add_action( 'admin_init',  array(&$this,'tab_slide_admin_notice_ignore' ) );
		}
		public function tab_slide_admin_notice() {
			if (isset( $_GET['page']) && $_GET['page'] == 'tab-slide' ) {			
				global $current_user ;
				$user_id = $current_user->ID;
				if ( ! get_user_meta( $user_id, 'tab_slide_admin_notice' ) ) {
					echo '<div class="updated"><p>';
					printf(__( 'Do you want multiple instances, premium support and more? Check out <a href="http://store.zoranc.co/downloads/tab-slide/" class="button-primary" title="Tab Slide Pro" target="_blank">TAB SLIDE PRO</a> right now!<a href="%1$s" style="float:right;">Dismiss</a>' ), "?page=tab-slide&tab_slide_admin_notice_ignore=1");
					echo "</p></div>";
				}
				if ( ! get_user_meta( $user_id, 'tab_slide_admin_cookie_notice' ) ) {
					echo '<div class="updated"><p>';
					printf(__( 'Identify your users and provide customized Tab Slide experiences.<a href="http://store.zoranc.co/downloads/tab-slide-cookie/" class="button-primary" title="Tab Slide Cookie Addon" target="_blank">TAB SLIDE COOKIE ADDON</a> is here! <a href="%1$s" style="float:right;">Dismiss</a>' ), "?page=tab-slide&tab_slide_admin_notice_cookie_ignore=1");
					echo "</p></div>";
				}
			}
		}
		public function tab_slide_admin_notice_ignore() {
			global $current_user;
			$user_id = $current_user->ID;
			if ( isset( $_GET['tab_slide_admin_notice_ignore']) && '1' === $_GET['tab_slide_admin_notice_ignore'] ) {
			  $time = time();
			  add_user_meta( $user_id, 'tab_slide_admin_notice', $time, true);
			}
			if ( isset( $_GET['tab_slide_admin_notice_cookie_ignore']) && '1' === $_GET['tab_slide_admin_notice_cookie_ignore'] ) {
			  $time = time();
			  add_user_meta( $user_id, 'tab_slide_admin_cookie_notice', $time, true);
			}
		}
		/**
		 * Generate the radio option html
		 *
		 * @params string $option, $class, $value
		 * @return html element
		 */
		function get_radio( $option, $class, $value ) {
			global $tab_slide;
			?><input type="radio" class="<?php echo $class;?>" name="<?php  echo $tab_slide->get_plugin_option_fullname( $option) ?>" value="<?php echo $value ?>" <?php if( $tab_slide->get_plugin_option( $option) == $value) echo 'checked="yes"'; ?> />
		<?php
		}
		/**
		 * Generate the checkbox option html
		 *
		 * @params string $option, $class, $value, $checked
		 * @return html element
		 */
		function get_checkbox( $option, $class, $value ) {
			global $tab_slide;
			?>
			<input type="hidden" name="<?php  echo $tab_slide->get_plugin_option_fullname( $option) ?>" value='0' />
			<input type="checkbox" class="<?php echo $class; ?>" name="<?php  echo $tab_slide->get_plugin_option_fullname( $option) ?>" id="<?php echo $option ?>" value="<?php echo $value ?>" <?php checked( $tab_slide->get_plugin_option( $option) ); ?>/>
		<?php
		}
		/**
		 * Generate the text input option html
		 *
		 * @params string $option, $class, $value, $checked
		 * @return html element
		 */
		function get_input( $option, $class, $max_length, $size, $type = false ) {
			global $tab_slide;
			$value = $tab_slide->get_plugin_option( $option);
			if ( $type) {
				settype( $value, $type);
			}
			?><input class="<?php echo $class;?>" name="<?php echo $tab_slide->get_plugin_option_fullname( $option) ?>" value="<?php echo $value ?>" id="<?php echo $option ?>" maxlength="<?php echo $max_length ?>" size="<?php echo $size ?>" />
		<?php
		}
		function tab_slide_ouput_string( $string) {
		    $string = str_replace( '&', '&amp;', $string);
		    $string = str_replace( '"', '&quot;', $string);
		    $string = str_replace("'", '&#39;', $string);
		    $string = str_replace( '<', '&lt;', $string);
		    $string = str_replace( '>', '&gt;', $string);
		    return $string;
		} // end function tab_slide_output_string
		function directoryToArray( $directory, $recursive) {
		    $array_items = array();
		    if ( $handle = opendir( $directory) ) {
			while (false !== ( $file = readdir( $handle) )) {
			    if ( $file != "." && $file != "..") {
				if (is_dir( $directory. "/" . $file) ) {
				    if( $recursive) {
				        $array_items = array_merge( $array_items, directoryToArray( $directory. "/" . $file, $recursive) );
				    }
				    $file = $directory . "/" . $file;
				    $array_items[] = preg_replace("/\/\//si", "/", $file);
				} else {
				    $file = $directory . "/" . $file;
				    $array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			    }
			}
			closedir( $handle);
		    }
		    return $array_items;
		}
		function tab_slide_options_page() {
			global $tab_slide;
			?>

			<a id="overlay" class="hidden" href="javascript:void(0);" title="Close"></a>
			
			<div id="header-wrapper">
			  <div class="tabslide-icon">
			  </div>
			  <h2>Tab Slide
			  </h2>
			  
			</div>
			<div id="help">
			  <a href="http://store.zoranc.co/downloads/tab-slide/" class="button-primary" target="_blank">GO PRO</a>
			  <a href="#" class="instance_menu_item" >Help</a>
			  <a href="#" class="instance_menu_item about" >About</a>
		  </div>
			<div class="wrap">
				<div id="push"></div>
				<div class="subsubsub">
						<a class="general current" href="javascript:void(0)">General </a>
						<a href="javascript:void(0)" class="advanced">Advanced</a>
				</div>
				<?php $msg = null;
					if( array_key_exists( 'updated', $_GET ) && $_GET['updated']=='true' ) { 
						$msg = __( 'Settings Saved', 'tab_slide' );
						$this->generate_instance_css();
					}
				?>
				<?php do_action( 'save_tab_slide_settings' ); ?>
				<form action="options.php" method="post">
					<?php settings_fields( $tab_slide->options_group ); ?>
					<?php $this->get_form_content(); ?>
					<?php echo apply_filters( 'tab_slide_settings_form', '' ) ?>
					<input type="hidden" id="api_key" name="<?php echo $tab_slide->get_plugin_option_fullname( 'pro_api_key' ); ?>" value="<?php echo ( $tab_slide->get_plugin_option( 'pro_api_key' ) ) ?>" />
					<input type="hidden" name="<?php echo $tab_slide->get_plugin_option_fullname( 'version' ) ?>" value="<?php echo ( $tab_slide->get_plugin_option( 'version' ) ) ?>" />
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'tab-slide' ) ?>" />
				</form>
			</div>
		<?php
		}
		/* 
		 * Adds Settings page for Tab Slide.
		 */
		function get_form_content() {
			global $tab_slide; ?>
			<div id="general">
				<table class="form-table">
				<?php echo apply_filters( 'tab_slide_settings_general_before_slide_startup_settings_section', '' ); ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Startup Settings', 'tab-slide' ) ?></strong>
					</th>
					<td>
						<p>
							<label for="tab_slide_position">
								<?php _e( '', 'tab-slide' ); ?>
								<?php $this->get_radio( 'tab_slide_position', '', 'left' ); ?><?php _e( 'Left', 'tab-slide' ) ?>
								<?php $this->get_radio( 'tab_slide_position', '', 'right' ); ?><?php _e( 'Right', 'tab-slide' ) ?>
							</label>
							<label for="show_on_load" class='newline'>
								<?php $this->get_checkbox( 'show_on_load', 'show_on_load', 1 ); ?>
								<?php _e( 'Start in open tab slide view', 'tab-slide' ) ?>
							</label>
							<span class="description hidden"><?php _e( 'Determines whether the tab slide content is initially shown when the page is loaded.', 'tab-slide' ) ?></span>
						</p>
						<div id='autoopen_timer'>
							<label for="enable_open_timer">
								<?php $this->get_checkbox ( 'enable_open_timer', 'enable_timer', 1); ?>
								<?php _e( 'Enable Auto-Open Timer', 'tab-slide' ) ?>
							</label>
						</div>
						<div id='autohide_timer'>
							<label for="enable_timer">
								<?php $this->get_checkbox ( 'enable_timer', 'enable_timer', 1); ?>
								<?php _e( 'Enable Auto-Hide Timer', 'tab-slide' ) ?>
							</label>
						</div>
						<div id='timer'>
							<label for="timer">
								<?php _e( 'Wait for:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'timer', '', '6', '5', 'float' ); ?><?php _e( 'seconds', 'tab-slide' ) ?>
						</div>
					</td>
				</tr>
         <?php echo apply_filters( 'tab_slide_settings_general_before_slide_content_settings_section', '' ); ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Slide Content Settings', 'tab-slide' ) ?></strong>
					</th>
					<td>
						<p>
							<div class="css_only">
								<label for="borders">
									<?php _e( 'Use Borders:', 'tab-slide' ) ?>
								</label>
								<?php $this->get_radio ( 'borders' , 'no_borders', 0); ?><?php _e( 'No', 'tab-slide' ) ?>
								<?php $this->get_radio ( 'borders' , 'yes_borders', 1); ?><?php _e( 'Yes', 'tab-slide' ) ?>
								<span class="border_size">										
									<label for="border_size">
										<?php _e( '-> Offset closed slide by:', 'tab-slide' ) ?>
									</label>
									<?php $this->get_input ( 'border_size', 'border_size', 4, 4, 'int' ); ?>px
								</span>
							</div><div></div>
							<label for="open_width">
								<?php _e( 'Slide width:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'open_width', '', 5, 2); ?>
								
							<label for="open_height">
								<?php _e( 'Slide height:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'open_height', '', 5, 2); ?>
							
							<label for="window_unit">
								<?php $this->get_radio ( 'window_unit', '', 'px' ); ?>px
								<?php $this->get_radio ( 'window_unit', '', '%' ); ?>%
							</label> 
							<div class="peripheral">
								<label for="open_top">
									<?php _e( 'Vertical position from top:', 'tab-slide' ) ?>
								</label>
								<?php $this->get_input ( 'open_top', '', 5, 1, 'int' ); ?>%
							</div>
							<span class="description hidden"><?php _e( 'The size and vertical positioning settings.<br /> Width and Height values can be dealt with either in percentages or pixels.', 'tab-slide' ) ?></span>
						</p>
						<p>
							<label for="template_pick">
								<?php _e( 'Template:', 'tab-slide' ) ?>
							</label>
							<input type=hidden name="<?php echo $tab_slide->get_plugin_option_fullname( 'template_pick' ) ?>"  value="<?php  echo $tab_slide->get_plugin_option( 'template_pick' ) ?>" id="template_pick" size="90">
								<select name="template_select" value="<?php  echo $tab_slide->get_plugin_option( 'template_pick' ) ?>" id='template_select'>	
									<option id='subscribe' value='Subscribe'><?php _e( 'Subscribe', 'tab-slide' ) ?></option>
									<option id='wplogin' value='WPLogin'><?php _e( 'WPLogin', 'tab-slide' ) ?></option>
									<option id='widget' value='Widget'><?php _e( 'Widget', 'tab-slide' ) ?></option>
									<option id='post' value='Post'><?php _e( 'Post', 'tab-slide' ) ?></option>
									<option id='iframe' value='iFrame'><?php _e( 'iFrame', 'tab-slide' ) ?></option>
									<option id='picture' value='Picture'><?php _e( 'Picture', 'tab-slide' ) ?></option>
									<option id='video' value='Video'><?php _e( 'Video', 'tab-slide' ) ?></option>
									<option id='custom' value='Custom'><?php _e( 'Custom', 'tab-slide' ) ?></option>
								</select>
							</input>

						</p>
						<div id="Widget">
							<span class="description hidden"><?php _e( 'Tab Slide Widget Area Enabled.', 'tab-slide' ) ?></span>
						</div>
						<div id="Post">
							<label for="post">
								<?php _e( 'Post ID: ', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'post_id', '', '', 2); ?>
							<span class="description hidden"><?php _e( 'example: 2', 'tab-slide' ) ?></span>
						</div>
						<div id="iFrame">
							<label for="iframe_url">
								<?php _e( 'iFrame Url: ', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'iframe_url', '', '', '' ); ?>
							<span class="description hidden"><?php _e( 'example: http://www.google.com/', 'tab-slide' ) ?></span>
						</div>
						<div id="Picture">
							<label for="picture_url">
								<?php _e( 'Picture Url: ', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'picture_url', '', '', '' ); ?>
							<span class="description hidden"><?php _e( 'example: http://www.google.com/picture.jpg', 'tab-slide' ) ?></span>
						</div>
						<div id="Video">
							<label for="video_url">
								<?php _e( 'Video Url: ', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'video_url', '', '', '' ); ?>
							<span class="description hidden"><?php _e( 'example: http://www.youtube.com/v/9yl_XPkcTl4 <br/ >Note: Video URL format', 'tab-slide' ) ?></span>
						</div>
						<div id="Custom">
							<label for="window_url">
								<?php _e( 'Window Url Path:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'window_url', '', '', '' ); ?>
							<div class="description"><?php _e( '<b>IMPORTANT NOTE:</b> Place your custom templates in your child theme directry to avoid the custom templates from being overwritten on tab slide plugin updates. Then use `wp-content/themes/yourtheme/youtrtemplate.php` as the url here', 'tab-slide' ) ?></div>
						</div>
					</td>
				</tr>
				<?php 
					$themes=$this->directoryToArray( TAB_SLIDE_ROOT . '/themes', false); 
				?>
				
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e( 'Background Settings', 'tab-slide' ) ?></strong></th>
					<td>
						<p>
							<label for="background">
								<?php _e( 'Background (Path or Color):', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'background', '', '', 58); ?>	
							<span class="description hidden"><?php _e( 'You can use the color picker or simply use the image location eg. http://www.yoursite.com/background.jpg', 'tab-slide' ) ?></span>
							<div id="bgcolorpicker"></div>
						</p>
						<p>
							<label for="opacity">
								<?php _e( 'Opacity:', 'tab-slide' ) ?>
							</label>
								
							<input type="range"  min="0" max="100" name="<?php echo $tab_slide->get_plugin_option_fullname( 'opacity' ) ?>" value="<?php  echo $tab_slide->get_plugin_option( 'opacity' ) ?>" id="opacity" maxlength="<?php if( $tab_slide->get_plugin_option( 'window_unit' ) == '%' ) echo '3'; else echo '5'; ?>" size="2" />
							<span id="range"><?php  echo $tab_slide->get_plugin_option( 'opacity' ) ?></span>
							<span class="description hidden"><?php _e( 'The background opacity.<br />  Any value between 0 (transparent) and 100 (opaque)', 'tab-slide' ) ?></span>
						</p>
					</td>
				</tr>	
				<?php echo apply_filters( 'tab_slide_settings_general_before_tab_settings_section', '' ); ?>
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e( 'TAB Settings', 'tab-slide' ) ?></strong></th>
					<td>
						<p>
							<label for="tab_top">
								<?php _e( 'Position from top:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input( 'tab_top', '', 3, 2, 'int' ); ?>%
							<span class="description hidden"><?php _e( 'Vertical tab position relative to slide content height.<br /> Use any value between 0 (top of slide) and 100 (bottom of slide)', 'tab-slide' ) ?></span>
						</p>
						<p class="peripheral">
							<label for="tab_height">
								<?php _e( 'Vertical TAB Size:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_height', '', '', 3, 'int' ); ?>px
						</p>
						<p class="peripheral">
							<label for="tab_width">
								<?php _e( 'Horizontal TAB Size:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_width', '', '', 3, 'int' ); ?>px	
						</p>
					</td>
				</tr>
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e( 'Font Settings', 'tab-slide' ) ?></strong></th>
					<td>
						<p>
							<label for="font_family">
								<?php _e( 'Font:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'font_family', '', '', 30); ?>
						</p>
						<p>
							<label for="font_size">
								<?php _e( 'Font Size:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'font_size', '', '', 5); ?>
						</p>
						<p>
							<label for="font_color">
								<?php _e( 'Font Color:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'font_color', '', '', 5); ?>
							<div id="fontcolorpicker"></div>
						</p>
					</td>
					</tr>
						
				<?php echo apply_filters( 'tab_slide_settings_general_before_tab_slide_style_settings_section', '' ); ?>

				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Tab Slide Style', 'tab-slide' ) ?></strong></th>
					<td>		
						<p>
							<label for="cssonly">
								<?php _e( 'CSS Only Mode:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_radio ( 'cssonly', 'cssonly', 1); ?><?php _e( 'Yes', 'tab-slide' ) ?>
							<?php $this->get_radio ( 'cssonly', 'integratedcss', 0); ?><?php _e( 'No', 'tab-slide' ) ?>
							<div id="edit_css" class="css_only">
								<textarea name="<?php echo $tab_slide->get_plugin_option_fullname( 'css' ) ?>" rows="10" cols="60" class="" id="edit_css_text"><?php echo $tab_slide->get_plugin_option( 'css' ) ?> </textarea>
							</div>
							<span class="description hidden"><?php _e( 'You can switch to css only mode and use cssonly.css to set up your tab slide.', 'tab-slide' ) ?></span>
							<span class="description hidden"><?php _e( 'Note: If in CSS only mode, make sure you fill out the remaining settings that you will be using in your css as they are necessary for calculations and such', 'tab-slide' ) ?></span>
						</p>
					</td>
				</tr>
				<?php echo apply_filters( 'tab_slide_settings_general_after_tab_slide_style_settings_section', '' ); ?>
				</table>
			</div>
			<div id="advanced">
				<table class="form-table">
				<?php echo apply_filters( 'tab_slide_settings_advanced_before_display_settings_section', '' ); ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Visual Settings', 'tab-slide' ) ?></strong></th>
					<td>
					  <p>
							<label for="devices">
								<?php _e( 'Devices:', 'tab-slide' ) ?>
							</label>
									<select name="<?php echo $tab_slide->get_plugin_option_fullname( 'device' ); ?>"  id='device'>
										<option value="all" <?php if ( $tab_slide->get_plugin_option( 'device' ) == 'all' ) echo ' selected'; ?>><?php _e( 'Show on all devices', 'tab-slide' ); ?></option>
										<option value="mobile" <?php if ( $tab_slide->get_plugin_option( 'device' ) == 'mobile' ) echo '  selected'; ?>><?php _e( 'Show on mobiles only', 'tab-slide' ); ?></option>
										<option value="desktop" <?php if ( $tab_slide->get_plugin_option( 'device' ) == 'desktop' ) echo '  selected'; ?>><?php _e( 'Show on desktops only', 'tab-slide' ) ?></option>
									</select>
						</p>
						<?php echo apply_filters( 'tab_slide_settings_advanced_after_devices_option', '' ); ?>
						<p>
							<label for="credentials">
								<?php _e( 'Authentication:', 'tab-slide' ) ?>
							</label>
									<select name="<?php echo $tab_slide->get_plugin_option_fullname( 'credentials' ); ?>"  id='credentials'>
										<option value="all" <?php if ( $tab_slide->get_plugin_option( 'credentials' ) == 'all' ) echo ' selected'; ?>><?php _e( 'Show to all visitors', 'tab-slide' ); ?></option>
										<option value="auth" <?php if ( $tab_slide->get_plugin_option( 'credentials' ) == 'auth' ) echo ' selected'; ?>><?php _e( 'Show only to logged in visitors', 'tab-slide' ); ?></option>
										<option value="unauth" <?php if ( $tab_slide->get_plugin_option( 'credentials' ) == 'unauth' ) echo ' selected'; ?>><?php _e( 'Show only to logged out visitors', 'tab-slide' ); ?></option>
									</select>
						</p>
						<?php echo apply_filters( 'tab_slide_settings_advanced_after_credentials_option', '' ); ?>
						<p>
							<?php _e( 'Filter:', 'tab-slide' ) ?>
							<select name="<?php echo $tab_slide->get_plugin_option_fullname( 'list_pick' ); ?>"  id='list_pick'>
							  <option value="shortcode" <?php if ( $tab_slide->get_plugin_option( 'list_pick' ) == 'shortcode' ) echo ' selected'; ?>><?php _e( 'Use the <b>[tabslide]</b> shortcode.', 'tab-slide' ); ?></option>
							  <option value="all" <?php if ( $tab_slide->get_plugin_option( 'list_pick' ) == 'all' ) echo ' selected'; ?>><?php _e( 'Include on all pages.', 'tab-slide' ); ?></option>
							  <option value="include" <?php if ( $tab_slide->get_plugin_option( 'list_pick' ) == 'include' ) echo ' selected'; ?>><?php _e( 'Include only on page ID(s)', 'tab-slide' ); ?></option>
							  <option value="exclude" <?php if ( $tab_slide->get_plugin_option( 'list_pick' ) == 'exclude' ) echo ' selected'; ?>><?php _e( 'Exclude from page ID(s)', 'tab-slide' ); ?></option>
              </select>
							
							<div class='padding list-pick-sub' id='list-pick-shortcode'>
								<label for="shortcode">
									<?php _e( 'Use the <b>[tabslide]</b> shortcode.', 'tab-slide' ) ?>
								</label>
							</div>
							<div class='padding list-pick-sub' id='list-pick-include'>
								<label for="include_list">
									<?php _e( 'Include only on page ID(s):', 'tab-slide' ) ?>
								</label>
								<?php $this->get_input ( 'include_list', '', '', '' ); ?>		
							</div>
							<div class='padding list-pick-sub' id='list-pick-exclude'>
								<label for="exclude_list">
									<?php _e( 'Exclude from page ID(s):', 'tab-slide' ) ?>
								</label>
								<?php $this->get_input ( 'exclude_list', '', '', '' ); ?>	
								<span class="description hidden"><?php _e( 'example: 2, 3, 55', 'tab-slide' ) ?></span>
							</div>
							<?php echo apply_filters( 'tab_slide_settings_advanced_after_filter_option', '' ); ?>
						</p>
						<div>
						  <label for="disable_pages">
							  <?php _e( 'Disable pages:', 'tab-slide' ) ?>
						  </label>
						  <?php $this->get_input ( 'disabled_pages', '', '', '' ); ?>	
						  <span class="description hidden"><?php _e( 'example: template.php', 'tab-slide' ) ?></span>
						</div>
						<?php echo apply_filters('tab_slide_settings_advanced_after_disable_pages_option', '' ); ?>
						<p>
							<label for="animation_speed">
								<?php _e('Opening Speed:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'animation_speed', '', 6, 5, 'float' ); ?><?php _e('seconds', 'tab-slide') ?>
							<span class="description hidden"><?php _e('Set how long it takes for the tab to open.', 'tab-slide') ?>
						</p>
						<p>
							<label for="animation_closing_speed">
								<?php _e('Closing Speed:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'animation_closing_speed', '', 6, 5, 'float' ); ?><?php _e('seconds', 'tab-slide') ?>
							<span class="description hidden"><?php _e('Set how long it takes for the tab to close.', 'tab-slide') ?>
						</p>
					</td>
				</tr>	
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Theme Integration Hook', 'tab-slide' ) ?></strong></th>
					<td>
						<p>
							<select name="<?php echo $tab_slide->get_plugin_option_fullname( 'hook' ); ?>" id="hook">
								<option value='the_content' <?php if ( $tab_slide->get_plugin_option( 'hook' ) === 'the_content' ) echo " selected='selected'"; ?>>the_content (Default)</option>
								<option value='the_excerpt' <?php if ( $tab_slide->get_plugin_option( 'hook' ) === 'the_excerpt' ) echo " selected='selected'"; ?>>the_excerpt</option>
								<option value='wp_footer' <?php if ( $tab_slide->get_plugin_option( 'hook' ) === 'wp_footer' ) echo " selected='selected'"; ?>>wp_footer</option>
								<option value='wp_head' <?php if ( $tab_slide->get_plugin_option( 'hook' ) === 'wp_head' ) echo " selected='selected'"; ?>>wp_head (Use as last resort only)</option>
								<option value='custom_filter' <?php if ( $tab_slide->get_plugin_option( 'hook' ) === 'custom_filter' ) echo " selected='selected'"; ?>><?php _e( 'Custom Filter', 'tab-slide' ) ?></strong></option>
							</select>
						</p>
						<span class="description hidden"><?php _e( 'Choose which hook is used to insert the tab slide content in your template. Consult with your theme developer to figure out what hook would be most appropriate to use for the page that you are targeting.', 'tab-slide' ) ?>
						</span>
						<p class="hook_custom">
							<label for="hook_custom" class="hook_custom">
									<?php _e( 'Custom Filter Hook:', 'tab-slide' ) ?>
							</label>
								<?php $this->get_input ( 'hook_custom', '', '', '' ); ?>
						</p>
						<p class="hook_custom">
							<span class="hook_custom description hidden"><?php _e( 'Add the filter hook to your template like so:', 'tab-slide' ) ?>
							</span>
							<span class="hook_custom description hidden">
								<?php echo "echo apply_filters( '{$tab_slide->get_plugin_option( 'hook_custom' )}', '' );" ?>
							</span>
						</p>
					</td>
				</tr>
				<?php echo apply_filters( 'tab_slide_settings_advanced_before_tab_settings_section', '' ); ?>
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'TAB Settings', 'tab-slide' ) ?></strong></th>
					<td>
						<select name="<?php echo $tab_slide->get_plugin_option_fullname( 'tab_type' ); ?>" id="tab-type">
								<option value='text' <?php if ( $tab_slide->get_plugin_option( 'tab_type' ) === 'text' ) echo " selected='selected'"; ?>><?php _e( 'Tab Text', 'tab-slide' ) ?></option>
								<option value='image' <?php if ( $tab_slide->get_plugin_option( 'tab_type' ) === 'image' ) echo " selected='selected'"; ?>><?php _e( 'Tab Image', 'tab-slide' ) ?></option>
								<option value='scroll' <?php if ( $tab_slide->get_plugin_option( 'tab_type' ) === 'scroll' ) echo " selected='selected'"; ?>><?php _e( 'Scroll trigger', 'tab-slide'); ?></option>
								<option value='custom' <?php if ( $tab_slide->get_plugin_option( 'tab_type' ) === 'custom' ) echo " selected='selected'"; ?>><?php _e( sprintf( 'Custom element trigger' ), 'tab-slide' ); ?></option>
						</select>
						<p class="tab_image_settings tab-type-options">
							<label for="tab_image">
								<?php _e( 'Image Path:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_image', '', '', '' ); ?>
						</p>
						<p class="tab_custom_settings tab-type-options">
							<label for="tab_element">
								<?php _e( 'Target ID or Class:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_element', '', '', '' ); ?>
						</p>
						<div class="tab_text_settings tab-type-options" id="tab-text-inputs">
							<label for="tab_title_close">
								<?php _e( 'Closed View:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_title_close', '', '', 5 ); ?>	| 	
							<label for="tab_title_open">
								<?php _e( 'Opened View:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_title_open', '', '', 5 ); ?>
						</div>
						<div class="peripheral tab_text_settings tab-type-options">
							<label for="tab_margin_close">
								<?php _e( 'CLOSE Text Offset:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_margin_close', '', '', 3 ); ?>px | 
							<label for="tab_margin_open">
								<?php _e( 'OPEN Text Offset:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_margin_open', '', '', 3 ); ?>px
						</div>
						<div class="peripheral tab_text_settings tab-type-options">
							<label for="tab_color">
								<?php _e( 'Color:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_color', '', '', 8 ); ?>
							<span class="description hidden"><?php _e( 'Set the color of the tab as well as ALL the borders.', 'tab-slide' ) ?></span>
							<div id="tabcolorpicker"></div>
						</div>
						<div class="peripheral tab_text_settings tab-type-options">
							<label for="font_size">
								<?php _e( 'Tab Font Size:', 'tab-slide' ) ?>
							</label>
							<?php $this->get_input ( 'tab_font_size', '', '', 5 ); ?>
						</div>
						
						<div class="tab_scroll_settings tab-type-options">
							<label for="scroll_percentage_start">
								<?php _e('Keep tab slide open between ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'scroll_percentage_start', '', '', 5 ); ?>%
							<label for="scroll_percentage_end">
								<?php _e(' and ', 'tab-slide-pro') ?>
							</label>
							<?php $this->get_input ( 'scroll_percentage_end', '', '', 5 ); ?>% <?php _e(' scroll height.', 'tab-slide-pro') ?>
						</div>
					</td>
				</tr>
				</table>
			</div>
			<div id="about" class="hidden">
			<div id="logo"></div>
			<a id="close_about" href="javascript:void(0);"></a>
			<div><h3><?php _e( 'Thank you for using Tab Slide!', 'tab-slide' ) ?></h5> </h3>
				<p><em>Please take a moment to <a class="button-secondary" href="http://wordpress.org/support/view/plugin-reviews/tab-slide?rate=5#postform" title="Rate" target="_blank"><?php _e( 'Rate', 'tab-slide' ) ?></a>, <?php _e( 'Blog and spread the word to help support this plugin.', 'tab-slide' ) ?></em></p>				
				<h5><?php _e( 'Donate', 'tab-slide' ) ?></h5>
				<pre><a href="https://blockchain.info/address/1HX5e9WPgi3RhsziV6Ja1a5b5AuUXYmSE4" title="Donate via bitCoin" target="_blank"><?php _e( 'Donate via bitCoin', 'tab-slide' ) ?></a>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZYBTAH986982N" title="Donate via PayPal" target="_blank"><?php _e( 'Donate via PayPal', 'tab-slide' ) ?></a></pre>
				<h5><?php _e( 'Suggestions, Issues?', 'tab-slide' ) ?></h5>
				<p><?php _e( 'Check out the', 'tab-slide' ) ?> <a class="button-secondary" href='http://zoranc.co/support/support-forum/tab-slide/' title="Tab Slide Forum" target="_blank"><?php _e( 'Tab Slide Forum', 'tab-slide' ) ?></a> <?php _e( 'and post your questions there, as this way the rest of the community can benefit.', 'tab-slide' ) ?> </p>
				<h5<?php _e( 'Do you want multiple instances? Premium Support?', 'tab-slide' ) ?>></h5>
				<center><?php _e( 'Get', 'tab-slide' ) ?> <a href="http://store.zoranc.co/downloads/tab-slide/" title="Purchase Tab Slide Pro" target="_blank" class="button-primary"><?php _e( 'TAB SLIDE PRO', 'tab-slide' ) ?></a> <?php _e( 'right now!', 'tab-slide' ) ?>
				<a href="javascript:void(0);" title="<?php _e( 'Enter API Key', 'tab-slide' ) ?>" class="button-secondary" id="pro_api_key"><?php _e( 'Enter Pro API Key', 'tab-slide' ) ?></a>
				<div id="api_key_input" style="display:none;"><input type="text" value="<?php echo $tab_slide->get_plugin_option( 'pro_api_key' ); ?>"  maxlength=34 size=34 /><a href="javascript:void(0);" title="<?php _e( 'Save API Key', 'tab-slide' ) ?>" class="button-secondary" id="save_api_key"><?php _e( 'Save API Key', 'tab-slide' ) ?></a></div>
				</center>
				<?php do_action('tab_slide_about_overlay'); ?>
			</div>
	</div>
<div id="rate">
  <div id="close-rate">&#215</div>
	<?php					
	  if (function_exists( 'get_transient' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		// First, try to access the data, check the cache.
		if (false === ( $api = get_transient( 'tab-slide' ) )) {
		  // The cache data doesn't exist or it's expired.
		  $api = plugins_api( 'plugin_information', array( 'slug' => stripslashes( 'tab-slide' ) ) );
		  if ( !is_wp_error( $api) ) {
			// cache isn't up to date, write this fresh information to it now to avoid the query for xx time.
			$myexpire = 60 * 15; // Cache data for 15 minutes
			set_transient( 'tab-slide', $api, $myexpire);
		  }
		}
		if ( !is_wp_error( $api) ) {
		  $plugins_allowedtags = array( 'a' => array( 'href' => array(), 'title' => array(), 'target' => array() ),
									   'abbr' => array( 'title' => array() ), 'acronym' => array( 'title' => array() ),
									   'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
									   'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
									   'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
									   'img' => array( 'src' => array(), 'class' => array(), 'alt' => array() ));
		  //Sanitize HTML
		  foreach ( (array)$api->sections as $section_name => $content )
			$api->sections[$section_name] = wp_kses( $content, $plugins_allowedtags);
		  foreach ( array( 'version', 'author', 'requires', 'tested', 'homepage', 'last_updated', 'slug' ) as $key )
			$api->$key = wp_kses( $api->$key, $plugins_allowedtags);
		  if ( ! empty( $api->last_updated) ) {
			echo sprintf(__( 'Last updated: %s', 'tab-slide' ),$api->last_updated);
			echo '.';
		  } ?>
	<?php if ( ! empty( $api->rating) ) : ?>
	<div class="star-holder" title="<?php echo $this->tab_slide_ouput_string(sprintf(__( '(Average rating based on %s ratings)', 'tab-slide' ),number_format_i18n( $api->num_ratings) )); ?>">
	  <div class="star star-rating" style="width: <?php echo $this->tab_slide_ouput_string( $api->rating) ?>px"></div>
	  <div class="star star5"></div>
	  <div class="star star4"></div>
	  <div class="star star3"></div>
	  <div class="star star2"></div>
	  <div class="star star1"></div><span></span>
	</div>
	<small><?php echo sprintf(__( '(%s ratings)', 'tab-slide' ),number_format_i18n( $api->num_ratings) ); ?></small>
	<?php endif;
		} // if ( !is_wp_error( $api)
	  }// end if (function_exists( 'get_transient'
	?>
	<input type="button" class="button-secondary" value="Review Plugin" onClick="window.open( 'http://wordpress.org/support/view/plugin-reviews/tab-slide?rate=5#postform' )" />
<div id="share">
					<a href="http://www.addthis.com/bookmark.php"
        class="addthis_button"
       addthis:url="http://wordpress.org/extend/plugins/tab-slide/" addthis:title="Tab Slide WordPress Plugin" addthis:description="An awesome sliding shelf wordpress plugin for your website."></a> 
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-511334722499daaa"></script>
	</div>
</div>
			<?php
		}
	}
}
