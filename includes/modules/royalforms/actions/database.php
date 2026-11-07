<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Database extends Action_Base {

	public function get_name() {
		return 'database';
	}

	public function get_label() {
		return esc_html__( 'Save to Database', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();
		$fields = $record->get_formatted_data();

		// Create submission post
		$submission_data = [
			'post_type'   => 'royal_form_entry',
			'post_status' => 'publish',
			'post_title'  => sprintf(
				'%s - %s',
				$settings['form_name'] ?? 'Form Submission',
				current_time( 'Y-m-d H:i:s' )
			),
		];

		$post_id = wp_insert_post( $submission_data );

		if ( is_wp_error( $post_id ) ) {
			$ajax_handler->add_error_message(
				esc_html__( 'Failed to save submission to database.', 'royal-addons-for-elementor' )
			);
			return;
		}

		// Save form fields as meta
		update_post_meta( $post_id, '_royal_form_fields', $fields );
		update_post_meta( $post_id, '_royal_form_id', $settings['form_id'] ?? '' );
		update_post_meta( $post_id, '_royal_form_name', $settings['form_name'] ?? '' );
		
		// Save metadata
		$meta = [
			'page_url'    => isset( $_POST['page_url'] ) ? esc_url_raw( $_POST['page_url'] ) : '',
			'post_id'     => isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0,
			'user_id'     => get_current_user_id(),
			'user_ip'     => $this->get_user_ip(),
			'user_agent'  => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '',
			'referrer'    => isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( $_SERVER['HTTP_REFERER'] ) : '',
			'submit_time' => current_time( 'mysql' ),
		];

		update_post_meta( $post_id, '_royal_form_meta', $meta );

		// Add response data
		$ajax_handler->add_response_data( 'submission_id', $post_id );
	}

	private function get_user_ip() {
		$ip = '';

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return sanitize_text_field( $ip );
	}

	/**
	 * Register Custom Post Type for form entries
	 */
	public static function register_post_type() {
		register_post_type( 'royal_form_entry', [
			'labels' => [
				'name'               => esc_html__( 'Form Submissions', 'royal-addons-for-elementor' ),
				'singular_name'      => esc_html__( 'Form Submission', 'royal-addons-for-elementor' ),
				'menu_name'          => esc_html__( 'Form Submissions', 'royal-addons-for-elementor' ),
				'all_items'          => esc_html__( 'All Submissions', 'royal-addons-for-elementor' ),
				'view_item'          => esc_html__( 'View Submission', 'royal-addons-for-elementor' ),
				'search_items'       => esc_html__( 'Search Submissions', 'royal-addons-for-elementor' ),
				'not_found'          => esc_html__( 'No submissions found', 'royal-addons-for-elementor' ),
				'not_found_in_trash' => esc_html__( 'No submissions in trash', 'royal-addons-for-elementor' ),
			],
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'royal-addons-settings',
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'rewrite'             => false,
			'query_var'           => false,
			'supports'            => [ 'title' ],
			'has_archive'         => false,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
		] );
	}

	/**
	 * Add custom columns to submissions list
	 */
	public static function add_columns( $columns ) {
		$new_columns = [];
		
		foreach ( $columns as $key => $value ) {
			if ( $key === 'title' ) {
				$new_columns[ $key ] = $value;
				$new_columns['form_name'] = esc_html__( 'Form', 'royal-addons-for-elementor' );
				$new_columns['page_url'] = esc_html__( 'Page', 'royal-addons-for-elementor' );
				$new_columns['user_ip'] = esc_html__( 'IP', 'royal-addons-for-elementor' );
			} elseif ( $key === 'date' ) {
				$new_columns[ $key ] = esc_html__( 'Submitted', 'royal-addons-for-elementor' );
			} else {
				$new_columns[ $key ] = $value;
			}
		}

		return $new_columns;
	}

	/**
	 * Render custom column content
	 */
	public static function render_columns( $column, $post_id ) {
		$meta = get_post_meta( $post_id, '_royal_form_meta', true );

		switch ( $column ) {
			case 'form_name':
				echo esc_html( get_post_meta( $post_id, '_royal_form_name', true ) ?: '-' );
				break;
			case 'page_url':
				$url = isset( $meta['page_url'] ) ? $meta['page_url'] : '';
				if ( $url ) {
					echo '<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( wp_parse_url( $url, PHP_URL_PATH ) ?: '/' ) . '</a>';
				} else {
					echo '-';
				}
				break;
			case 'user_ip':
				echo esc_html( isset( $meta['user_ip'] ) ? $meta['user_ip'] : '-' );
				break;
		}
	}
}

// Register CPT on init
add_action( 'init', [ 'RoyalAddons\Modules\Forms\Actions\Database', 'register_post_type' ] );

// Add custom columns
add_filter( 'manage_royal_form_entry_posts_columns', [ 'RoyalAddons\Modules\Forms\Actions\Database', 'add_columns' ] );
add_action( 'manage_royal_form_entry_posts_custom_column', [ 'RoyalAddons\Modules\Forms\Actions\Database', 'render_columns' ], 10, 2 );
