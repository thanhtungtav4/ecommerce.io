<?php
/**
 * Admin action class
 *
 * @author  YITH
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin_Actions' ) ) {
	/**
	 * WooCommerce Affiliates Admin
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Admin_Actions {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Array of supported actions
		 *
		 * @var array
		 */
		protected $supported_actions;

		/**
		 * Construct the object, and register available admin actions
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'process_action' ), 15 );
		}

		/**
		 * Register a new action to handle
		 *
		 * @param string   $action   Action to register.
		 * @param callable $callback Callback to run.
		 *
		 * @return void.
		 */
		public function add_action( $action, $callback ) {
			$this->supported_actions[ $action ] = $callback;
		}

		/**
		 * Process admin action
		 *
		 * @return void
		 */
		public function process_action() {
			// exit if no action was submitted.
			if ( ! isset( $_REQUEST['yith_wcaf_action'] ) ) {
				return;
			}

			// retrieve current action.
			$action = sanitize_text_field( wp_unslash( $_REQUEST['yith_wcaf_action'] ) );

			// exit if action isn't supported.
			if ( ! in_array( $action, array_keys( $this->supported_actions ), true ) ) {
				return;
			}

			$nonce_action = is_array( $this->supported_actions[ $action ] ) && isset( $this->supported_actions[ $action ]['nonce_action'] ) ? $this->supported_actions[ $action ]['nonce_action'] : $action;

			// exit if we can't verify nonce.
			if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), $nonce_action ) ) {
				return;
			}

			$callback = is_array( $this->supported_actions[ $action ] ) && isset( $this->supported_actions[ $action ]['callback'] ) ? $this->supported_actions[ $action ]['callback'] : $this->supported_actions[ $action ];

			try {
				$return = $callback();
			} catch ( Exception $e ) {
				return;
			}

			if ( isset( $_REQUEST['redirect_to'] ) ) {
				$redirect = sanitize_text_field( wp_unslash( $_REQUEST['redirect_to'] ) );
			} else {
				$redirect = YITH_WCAF_Admin()->get_tab_url();
			}

			if ( is_array( $return ) ) {
				$redirect = add_query_arg( $return, $redirect );
			}

			wp_safe_redirect( esc_url_raw( $redirect ) );
			die;
		}

		/**
		 * Returns url used to trigger a specific action
		 *
		 * @param string $action Action to trigger.
		 * @param array  $params Optional params.
		 *
		 * @return string Action url.
		 */
		public static function get_action_url( $action, $params = array() ) {
			$params = array_merge(
				$params,
				array(
					'yith_wcaf_action' => $action,
				)
			);

			$base_url = YITH_WCAF_Admin()->get_tab_url();

			if ( ! $base_url ) {
				$base_url = YITH_WCAF_Admin()->get_panel_url();
			}

			return add_query_arg( $params, wp_nonce_url( $base_url, $action ) );
		}
	}
}
