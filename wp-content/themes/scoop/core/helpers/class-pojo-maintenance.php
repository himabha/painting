<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Maintenance {
	
	protected static $_db_version = '0.8';
	protected static $_current_db_ver;
	
	public static function activate() {
		self::$_current_db_ver = get_option( 'pojo_db_version', '0.4' );
		
		if ( version_compare( self::$_current_db_ver, self::$_db_version, '<' ) )
			self::update_db();
	}
	
	protected static function update_db() {
		global $wpdb;
		
		if ( version_compare( '0.2', self::$_current_db_ver, '>' ) ) {
			// Smart page items..
			$wpdb->query( $wpdb->prepare(
				'DELETE FROM `%1$s`
					WHERE `meta_value` = \'1\'
						AND ( `meta_key` LIKE \'atpo_show_page_title\' OR `meta_key` LIKE \'atpo_show_page_content\' )
				;',
				$wpdb->postmeta
			) );
			
			// Theme Options..
			$theme_option = get_option( 'pojo_theme_options', array() );
			if ( ! empty( $theme_option ) ) {
				unset( $theme_option['page_show_page_title'] );
				update_option( 'pojo_theme_options', $theme_option );
			}

			update_option( 'pojo_db_version', '0.2' );
		}

		if ( version_compare( '0.3', self::$_current_db_ver, '>' ) ) {
			// Change to new Smart page prefix.
			$wpdb->query( $wpdb->prepare(
				'UPDATE %1$s
					SET `meta_key` = REPLACE( `meta_key`, \'atpo_\', \'po_\' );',
				$wpdb->postmeta
			) );
			
			update_option( 'pojo_db_version', '0.3' );
		}

		if ( version_compare( '0.4', self::$_current_db_ver, '>' ) ) {
			// Change to new Page Format prefix.
			$wpdb->query( $wpdb->prepare(
				'UPDATE %1$s
					SET `meta_key` = REPLACE( `meta_key`, \'ppf_\', \'pf_\' );',
				$wpdb->postmeta
			) );
			
			update_option( 'pojo_db_version', '0.4' );
		}

		if ( version_compare( '0.5', self::$_current_db_ver, '>' ) ) {
			// Builder: Save each row to new row in DB.
			$post_ids = $wpdb->get_col(
				$wpdb->prepare(
					'SELECT `post_id` FROM %1$s
						WHERE `meta_key` = \'pb_page_builder_rows\';',
					$wpdb->postmeta
				)
			);

			$post_ids = array_unique( $post_ids );
			foreach ( $post_ids as $post_id ) {
				$widget_rows = get_post_meta( $post_id, 'pb_page_builder_rows', true );

				//delete_post_meta( $post_id, 'pb_page_builder_rows' );
				delete_post_meta( $post_id, 'pb_builder_row' );
				
				if ( ! empty( $widget_rows ) ) {
					foreach ( $widget_rows as $widget_row ) {
						add_post_meta( $post_id, 'pb_builder_row', $widget_row );
					}
				}
			}
			update_option( 'pojo_db_version', '0.5' );
		}

		if ( version_compare( '0.6', self::$_current_db_ver, '>' ) ) {
			// Builder: Restore Builder rows DB
			$post_ids = $wpdb->get_col(
				$wpdb->prepare(
					'SELECT `post_id` FROM %1$s
						WHERE `meta_key` = \'pb_builder_row\';',
					$wpdb->postmeta
				)
			);

			$post_ids = array_unique( $post_ids );
			foreach ( $post_ids as $post_id ) {
				$widget_rows = get_post_meta( $post_id, 'pb_builder_row' );
				update_post_meta( $post_id, 'pb_builder_rows', $widget_rows );
			}
			update_option( 'pojo_db_version', '0.6' );
		}

		if ( version_compare( '0.7', self::$_current_db_ver, '>' ) ) {
			// Clear License caches
			delete_transient( get_template() . '-update-response' );
			delete_transient( 'pojo_license_' . get_template() . '_data' );
			
			update_option( 'pojo_db_version', '0.7' );
		}

		if ( version_compare( '0.8', self::$_current_db_ver, '>' ) ) {
			$post_ids = $wpdb->get_col(
				$wpdb->prepare(
					'SELECT `post_id` FROM %1$s
						WHERE `meta_key` = \'pb_builder_rows\';',
					$wpdb->postmeta
				)
			);
			
			$post_ids = array_unique( $post_ids );
			foreach ( $post_ids as $post_id ) {
				Pojo_Core::instance()->builder->updates->from_1_0_to_1_1( $post_id );
			}
			update_option( 'pojo_db_version', '0.8' );
		}
		
	}
	
}
add_action( 'after_setup_theme', array( 'Pojo_Maintenance', 'activate' ), 5 );