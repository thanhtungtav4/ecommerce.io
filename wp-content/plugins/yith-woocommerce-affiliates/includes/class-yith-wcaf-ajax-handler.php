<?php
/**
 * Static class that will handle all ajax calls for the plugin
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Ajax_Handler' ) ) {
	/**
	 * WooCommerce Affiliates Ajax Handler
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Ajax_Handler {

		/**
		 * AJAX Handlers
		 *
		 * @var array
		 */
		protected static $handlers = array();

		/**
		 * Performs all required add_actions to handle forms
		 *
		 * @return void
		 */
		public static function init() {
			$handlers = static::get_handlers();

			if ( empty( $handlers ) ) {
				return;
			}

			foreach ( $handlers as $handler_key => $handler ) {
				if ( is_string( $handler ) ) {
					$action   = self::get_handler_action( $handler );
					$callback = self::get_handler_callback( $handler );

					if ( ! is_callable( $callback ) ) {
						continue;
					}

					add_action( 'wp_ajax_' . $action, $callback );
				} elseif ( is_array( $handler ) ) {
					$action   = isset( $handler['action'] ) ? $handler['action'] : self::get_handler_action( $handler_key );
					$callback = isset( $handler['callback'] ) ? $handler['callback'] : self::get_handler_callback( $handler_key );

					if ( ! is_callable( $callback ) ) {
						continue;
					}

					add_action( 'wp_ajax_' . $action, $callback );

					if ( ! empty( $handler['nopriv'] ) ) {
						add_action( 'wp_ajax_nopriv_' . $action, $callback );
					}
				} else {
					continue;
				}
			}
		}

		/**
		 * Returns available AJAX call handlers
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return array
		 */
		public static function get_handlers( $context = 'view' ) {
			if ( empty( self::$handlers ) ) {
				self::$handlers = array(
					// AJAX affiliate creation.
					'create_affiliate',

					// JSON search affiliates.
					'get_affiliates_ids'              => array(
						'callback' => array( self::class, 'search_affiliates' ),
					),
					'get_affiliates_tokens'           => array(
						'callback' => array( self::class, 'search_affiliates' ),
					),

					// AJAX profile fields handling.
					'enable_affiliate_profile_field'  => array(
						'callback' => array( self::class, 'change_profile_field_status' ),
					),
					'disable_affiliate_profile_field' => array(
						'callback' => array( self::class, 'change_profile_field_status' ),
					),

					// AJAX gateways handling.
					'get_gateway_edit_form',
					'save_gateway_options',
					'enable_gateway'                  => array(
						'callback' => array( self::class, 'change_gateway_status' ),
					),
					'disable_gateway'                 => array(
						'callback' => array( self::class, 'change_gateway_status' ),
					),

					// AJAX call to calculate referral url.
					'get_referral_url'                => array(
						'nopriv' => true,
					),

					// AJAX call to set up referral cookies.
					'set_cookie'                      => array(
						'callback' => '__return_false',
						'nopriv'   => true,
					),
				);
			}

			if ( 'view' === $context ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_ajax_handlers
				 *
				 * Filters the AJAX handlers.
				 *
				 * @param array $ajax_handlers AJAX handlers.
				 */
				return apply_filters( 'yith_wcaf_ajax_handlers', self::$handlers );
			}

			return self::$handlers;
		}

		/**
		 * Returns action for an handler
		 *
		 * @param string $handler Handler to listen.
		 * @return string Action to use for wp_ajax_ hook.
		 */
		public static function get_handler_action( $handler ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_ajax_handler_action
			 *
			 * Filters the AJAX handler action.
			 *
			 * @param string $action  AJAX handler action.
			 * @param string $handler AJAX handler.
			 */
			return apply_filters( 'yith_wcaf_ajax_handler_action', "yith_wcaf_$handler", $handler );
		}

		/**
		 * Returns default callback for an handler
		 *
		 * @param string $handler Handler to listen.
		 * @return callable Callable that handles AJAX call.
		 */
		public static function get_handler_callback( $handler ) {
			$class = self::class;

			if ( class_exists( "{$class}_Premium" ) ) {
				$class = "{$class}_Premium";
			}

			return array( $class, $handler );
		}

		/* === AFFILIATES SEARCHING === */

		/**
		 * Print json encoded list of affiliate matching filter (param $term in request used to filter)
		 * Array is formatted as identifier => Verbose affiliate description (identifier can be both ID or token,
		 * depending on current action)
		 */
		public static function search_affiliates() {
			ob_start();

			check_ajax_referer( 'search-affiliates', 'security' );

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				die( - 1 );
			}

			$term = isset( $_REQUEST['term'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['term'] ) ) : false;

			if ( empty( $term ) ) {
				die( - 1 );
			}

			$param = 'wp_ajax_yith_wcaf_get_affiliates_ids' === current_action() ? 'id' : 'token';

			wp_send_json( self::get_affiliates_for_ajax( $term, $param ) );
		}

		/**
		 * Prepare an array of affiliates to be returned as json-encoded answer of an ajax call
		 *
		 * @param string $term  Term to search for.
		 * @param string $index Field to use as array index.
		 *
		 * @return array Formatter array of results.
		 */
		protected static function get_affiliates_for_ajax( $term, $index = 'token' ) {
			$found_affiliates = array();

			if ( ! $term ) {
				return $found_affiliates;
			}

			try {
				$data_store = WC_Data_Store::load( 'affiliate' );
			} catch ( Exception $e ) {
				return $found_affiliates;
			}

			$found_affiliates_raw = $data_store->query( array( 's' => $term ) )->get_objects();

			if ( ! empty( $found_affiliates_raw ) ) {
				foreach ( $found_affiliates_raw as $affiliate ) {
					if ( ! method_exists( $affiliate, "get_{$index}" ) ) {
						continue;
					}
					$found_affiliates[ $affiliate->{"get_{$index}"}() ] = $affiliate->get_formatted_name( 'edit' );
				}
			}

			return $found_affiliates;

		}

		/* === GATEWAYS HANDLING === */

		/**
		 * Retrieve Gateway edit form via AJAX
		 */
		public static function get_gateway_edit_form() {
			ob_start();

			check_ajax_referer( 'get_gateway_edit_form', 'security' );

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				die( - 1 );
			}

			$gateway_id = isset( $_GET['gateway_id'] ) ? sanitize_text_field( wp_unslash( $_GET['gateway_id'] ) ) : false;

			if ( ! $gateway_id ) {
				wp_send_json_error();
			}

			$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );

			if ( ! $gateway ) {
				wp_send_json_error();
			}

			$gateway->print_settings();

			wp_send_json_success(
				array(
					'template' => ob_get_clean(),
				)
			);
		}

		/**
		 * Save Gateway options form via AJAX
		 */
		public static function save_gateway_options() {
			ob_start();

			check_ajax_referer( 'save_gateway_options', 'security' );

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				die( - 1 );
			}

			$gateway_id = isset( $_POST['gateway_id'] ) ? sanitize_text_field( wp_unslash( $_POST['gateway_id'] ) ) : false;

			if ( ! $gateway_id ) {
				wp_send_json_error();
			}

			$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );

			if ( ! $gateway ) {
				wp_send_json_error();
			}

			$options_name = "yith_wcaf_{$gateway->get_id()}_gateway_settings";

			// sanitization and validation will be done in next steps, using data structure from the gateway.
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			$options = isset( $_POST[ $options_name ] ) ? $_POST[ $options_name ] : false;

			if ( ! $options ) {
				wp_send_json_error();
			}

			try {
				$gateway->update_options( $options );
			} catch ( Exception $e ) {
				wp_send_json_error(
					array(
						'message' => $e->getMessage(),
					)
				);
			}

			wp_send_json_success();
		}

		/**
		 * Change status of a gateway via AJAX
		 */
		public static function change_gateway_status() {
			ob_start();

			check_ajax_referer( 'change_gateway_status', 'security' );

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				die( - 1 );
			}

			$gateway_id = isset( $_POST['gateway_id'] ) ? sanitize_text_field( wp_unslash( $_POST['gateway_id'] ) ) : false;

			if ( ! $gateway_id ) {
				wp_send_json_error();
			}

			$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );

			if ( ! $gateway ) {
				wp_send_json_error();
			}

			$action = 'wp_ajax_yith_wcaf_enable_gateway' === current_action();

			$gateway->set_option( 'enabled', $action );

			wp_send_json_success();
		}

		/* === REFERRAL URL === */

		/**
		 * Returns referral url for current affiliate,
		 * or for any user that is an affiliate, whose username is passed in request.
		 */
		public static function get_referral_url() {
			ob_start();

			check_ajax_referer( 'get_referral_url', 'security' );

			/**
			 * APPLY_FILTERS: yith_wcaf_current_user_can_get_referral_url
			 *
			 * Filters whether current user can get the referral URL.
			 *
			 * @param bool $can_get_referral_url Whether current user can get referral URL or not.
			 * @param int  $current_user_id      Current user ID.
			 */
			if ( ! apply_filters( 'yith_wcaf_current_user_can_get_referral_url', true, get_current_user_id() ) ) {
				die( - 1 );
			}

			$original_url = isset( $_REQUEST['base'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['base'] ) ) : false;
			$affiliate_id = isset( $_REQUEST['affiliate_id'] ) ? (int) $_REQUEST['affiliate_id'] : false;
			$username     = isset( $_REQUEST['user'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['user'] ) ) : false;

			try {
				$referral_url = YITH_WCAF_Form_Handler::generate_referral_url( compact( 'username', 'affiliate_id', 'original_url' ) );
			} catch ( Exception $e ) {
				wp_send_json_error(
					array(
						'message' => $e->getMessage(),
					)
				);
			}

			wp_send_json_success(
				array(
					'url' => $referral_url,
				)
			);
		}

		/* === AFFILIATE HANDLING === */

		/**
		 * Create affiliate via AJAX (admin only)
		 */
		public static function create_affiliate() {
			ob_start();

			check_ajax_referer( 'create_affiliate', 'security' );

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				die( - 1 );
			}

			$panel = YITH_WCAF_Admin()->get_tab_instance( 'affiliates' );

			if ( ! $panel ) {
				wp_send_json_error(
					array(
						'message' => _x( 'An error occurred while creating the affiliate; please, try again later.', '[ADMIN] General error message', 'yith-woocommerce-affiliates' ),
					)
				);
			}

			$result = $panel->create_affiliate_action();

			if ( isset( $result['error_adding_affiliate'] ) ) {
				wp_send_json_error(
					array(
						'message' => $result['error_adding_affiliate'],
					)
				);
			}

			wp_send_json_success();
		}

		/* === PROFILE FIELDS HANDLING === */

		/**
		 * Change status of a profile field via AJAX
		 */
		public static function change_profile_field_status() {
			ob_start();

			check_ajax_referer( 'change_profile_field_status', 'security' );

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				die( - 1 );
			}

			$field_name = isset( $_POST['field_name'] ) ? sanitize_text_field( wp_unslash( $_POST['field_name'] ) ) : false;

			if ( ! $field_name ) {
				wp_send_json_error();
			}

			$action = 'wp_ajax_yith_wcaf_enable_affiliate_profile_field' === current_action();

			YITH_WCAF_Affiliates_Profile::change_field_status( $field_name, $action );

			if ( class_exists( 'YITH_WCAF_Affiliates_Profile_Fields_Admin_Table_Premium' ) ) {
				$table = new YITH_WCAF_Affiliates_Profile_Fields_Admin_Table_Premium();
			} else {
				$table = new YITH_WCAF_Affiliates_Profile_Fields_Admin_Table();
			}

			$table->prepare_items();
			$table->display();

			wp_send_json_success(
				array(
					'template' => ob_get_clean(),
				)
			);
		}
	}
}
