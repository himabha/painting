=== TAB SLIDE ===
Contributors: zoranc
Donate link: https://blockchain.info/address/1HX5e9WPgi3RhsziV6Ja1a5b5AuUXYmSE4
Tags: tab, sliding, panel, popup, pop out, page, form, ad, slide out, widget, login, post, hide away, widget area
Author URI: http://zoranc.co/
Plugin URI: http://zoranc.co/tab-slide-free/
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 2.0.4
License: GPLv2

== Description ==

This wp plugin is ideal for users who would like to present additional content without cluttering up or leaving the page. Tab Slide can contain a widget area, forms, rss feeds, logins, sign-ups, videos, pictures, posts, menu options, comments, popup ads and etc.  The Tab Slide settings page appears in the Dashboard where you can set all your tab slide options such as page source, size, positioning, autohide, opacity and much more. More than 31,950 sites have checked out Tab Slide already.

== Installation ==

For documentation, support questions, feedback and ideas, please use the official [Tab Slide forum](http://zoranc.co/support/support-forum/tab-slide/).

== Frequently Asked Questions ==
For documentation, support questions, feedback and ideas, please use the official [Tab Slide forum](http://zoranc.co/support/support-forum/tab-slide/).

== Changelog ==

= 2.0.4 =
* feature: added scroll trigger
* feature: separate settings for closing and opening speeds
* feature: added `tab_slide_options` filter
* cleanup: assets folder reorganization and empty `index.php` in all folders
* cleanup: `tab_slide.js`

= 2.0.3 =
* bugfix: prevent displaying of the tab if tab slide content was not successfully included
* feature: modify content hook option for better theme integration
* feature: added `tab_slide_settings_advanced_after_credentials_option` filter
* feature: added `tab_slide_settings_advanced_after_devices_option` filter
* feature: added `tab_slide_settings_advanced_after_disable_pages_option` filter
* feature: added `tab_slide_settings_advanced_after_filter_option` filter
* feature: added `tab_slide_settings_advanced_before_display_settings_section` filter
* feature: added `tab_slide_settings_advanced_before_tab_settings_section` filter
* feature: added `tab_slide_settings_general_after_tab_slide_style_settings_section` filter
* feature: added `tab_slide_settings_general_before_slide_content_settings_section` filter
* feature: added `tab_slide_settings_general_before_slide_startup_settings_section` filter
* feature: added `tab_slide_settings_general_before_tab_settings_section` filter
* feature: added `tab_slide_settings_general_before_tab_slide_style_settings_section` filter
* feature: added `tab_slide_settings_form` filter
* feature: added `tab_slide_about_overlay` action
* feature: automatic upgrade to the pro version with a valid API key

= 2.0.2 =
* bugfix: fixed device option not saving issue
* bugfix: fixed open timer option not saving issue

= 2.0.1 =
* bugfix: compatibility with WordPress SEO
* bugfix: tab_slide.js resize not working due to showing not being set to false when image tab is used starting in closed position
* bugfix: tab_slide.js resize check changed to accept string '0'
* bugfix: tab-slide.php add ABS path to template with no trailing slash for custom templated in custom directories
* bugfix: css.php % added in for top properties of slide and tab
* feature: Filter(show/hide) by device (mobile vs desktop)
* feature: autoopen after X seconds if starting in closed position
* feature: added `tab_slide_check_credentials` action
* feature: added `tab_slide_check_credentials` filter (return true/false)
* feature: added `tab_slide_check_device` action
* feature: added `tab_slide_check_device` filter (return true/false)
* feature: added `tab_slide_front_end_scripts` action
* feature: added `tab_slide_css_url` filter
* feature: added `tab_slide_js_url` filter
* cleanup: fixed the `tab_slide_front_end_scripts` action
* cleanup: renamed action `tab_slide_load_html_container_template` to `tab_slide_html_instance`
* cleanup: code refactoring for the init check, credentials
* cleanup: tab_slide.js code refactoring for calc_width
* cleanup: Tab Slide Settings UI tweaks

= 2.0.0 =
**IMPORTANT NOTE:** *BACKUP* all your customized templates, custom css and buttons before upgrading!

* MAJOR Revision
* Completely revised the way the plugin core works
* Major improvments to performance
* CSS is saved to the database now, so no need to worry anymore about tab slide plugin updates overwriting your changes from this version on.
* IE 9+ support
* New filters:
1. `tab_slide_show_instance`
2. `tab_slide_url`
3. `tab_slide_include_container_html`
      
* New actions:
1. `tab_slide_check_instance`
2. `tab_slide_load_html_container_template`
3. `tab_slide_shortcode`
4. `tab_slide_front_end_scripts`
5. `tab_slide_loaded`
6. `save_tab_slide_settings`
    
* **Template dependent actions**
    
1. `tab_slide_iframe_template`
2. `tab_slide_picture_template`
3. `tab_slide_post_template`
4. `tab_slide_subscribe_template`
5. `tab_slide_video_template`
6. `tab_slide_widget_template`
7. `tab_slide_wplogin_template`

= 1.52 =
= 1.51 =
= 1.50 =
= 1.4 =
* Shortcode implementation
* CSS Only Mode
* Credentials (Show only to logged in/out or all users)
* Color picker
* Border settings 
* MAJOR js code cleanup
* and more
IMPORTANT NOTE: BACKUP all your customized templates and buttons before upgrading!
= 1.32 =
* Append content via php(include) vs jQuery(load)
* Disable on template pages (ie lightbox iframe.php)
* Major template clean-up
* Minor code clean-up

= 1.31 =
* IE fixed
* Template fixes
* Fullscreen issues resolved

= 1.3 =
* Position to the left or right 
* Improved the default design 
* Rename the OPEN and CLOSE titles 
* Show on all pages, exclude or include 
* Full screen or regular mode 
* Segregated the settings page into General, Advanced and About(FAQ) sections 
* Resolved the custom permalinks bug
* Subscribe to Blog template added
* Post template fix

= 1.2 =
* Improved template managment 
* Added ready to use templates for a widget area, video, picture 
* Animation speed control 
* Disable Countdown Timer 
* Exclude Posts

= 1.1 =
* Template Fix

== Upgrade Notice ==
=2.0.4=
=2.0.0=
IMPORTANT NOTE: BACKUP all your customized templates, custom css and buttons before upgrading!

== Screenshots ==
1. Front End View of tab slide in "Tab Image Mode" 
2. Admin general settings view
