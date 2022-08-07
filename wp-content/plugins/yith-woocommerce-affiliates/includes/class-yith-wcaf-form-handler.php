<?php
/**
 * Form handler class
 *
 * @author  YITH
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Form_Handler' ) ) {
	/**
	 * This class will handle various all forms submitted by the user
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Form_Handler {

		/**
		 * Register data submitted
		 *
		 * @var array
		 */
		protected static $posted_data = array();

		/**
		 * Handlers registered for the plugin
		 *
		 * @var array
		 */
		protected static $handlers = array();

		/**
		 * Register the name of last executed handler
		 *
		 * @var string
		 */
		protected static $last_handler = null;

		/**
		 * Stores last value returned by an handler
		 *
		 * @var mixed
		 */
		protected static $last_result = null;

		/* === HANDLE REQUESTS === */

		/**
		 * Constructor method
		 *
		 * @since 2.0.0
		 */
		public static function init() {
			// handle form requests.
			add_action( 'wp_loaded', array( static::class, 'handle' ) );
		}

		/**
		 * Returns registered handlers
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return array Array of handlers, in the following format:
		 * [
		 *     handler_id => [
		 *         'nonce_name' => 'name',
		 *         'nonce_action' => 'name',
		 *         'fields' => [
		 *               // supported fields {@see \yith_wcaf_parse_settings for more detais on expected structure}
		 *         ],
		 *     ]
		 * ]
		 */
		public static function get_handlers( $context = 'view' ) {
			if ( empty( self::$handlers ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_form_handlers
				 *
				 * Filters the form handlers.
				 *
				 * @param array $handlers Form handlers.
				 */
				self::$handlers = apply_filters(
					'yith_wcaf_form_handlers',
					array(
						'register_affiliate'      => array(
							'nonce_name'   => 'woocommerce-register-nonce',
							'nonce_action' => 'woocommerce-register',
						),
						'become_an_affiliate'     => array(
							'nonce_action' => 'yith-wcaf-become-an-affiliate',
							'fields'       => YITH_WCAF_Affiliates_Profile::get_become_an_affiliate_fields( 'view' ),
						),
						'generate_referral_url'   => array(
							'nonce_action' => 'yith-wcaf-generate-referral-url',
							'fields'       => array(
								'username'     => array(),
								'original_url' => array(),
								'affiliate_id' => array(),
							),
						),
						'save_affiliate_settings' => array(
							'nonce_action' => 'yith-wcaf-save-affiliate-settings',
							'fields'       => array_merge(
								array(
									'payment_email' => array(),
								),
								YITH_WCAF_Gateways::get_available_gateways_fields()
							),
						),
					)
				);
			}

			if ( 'view' === $context ) {
				return apply_filters( 'yith_wcaf_form_handlers', self::$handlers );
			}

			return self::$handlers;
		}

		/**
		 * Handle request, when matching a registered handler
		 *
		 * @return void
		 */
		public static function handle() {
			$handlers = static::get_handlers();

			if ( empty( $handlers ) ) {
				return;
			}

			foreach ( $handlers as $handler => $handler_option ) {
				$process_nonce = isset( $handler_option['nonce_validation'] ) ? (bool) $handler_option['nonce_validation'] : true;
				$nonce_name    = isset( $handler_option['nonce_name'] ) ? $handler_option['nonce_name'] : $handler;
				$nonce_action  = isset( $handler_option['nonce_action'] ) ? $handler_option['nonce_action'] : str_replace( '_', '-', $handler );
				$action_field  = isset( $handler_option['action_field'] ) ? $handler_option['action_field'] : $nonce_name;
				$fields        = isset( $handler_option['fields'] ) ? $handler_option['fields'] : array();

				// checks if current handler is being processed.
				if ( ! isset( $_REQUEST[ $action_field ] ) ) {
					continue;
				}

				// nonce validation failed.
				if ( $process_nonce && ( ! isset( $_REQUEST[ $nonce_name ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST[ $nonce_name ] ) ), $nonce_action ) ) ) {
					break;
				}

				// try to validate fields and process handler.
				try {
					self::$last_handler = $handler;
					self::$posted_data  = self::validate_fields( $fields );

					/**
					 * DO_ACTION: yith_wcaf_before_$handler
					 *
					 * Allows to trigger some action before executing the form handler.
					 * <code>$handler</code> will be replaced with the form handler.
					 *
					 * @param array $posted_data    Posted data.
					 * @param array $handler_option Handler option.
					 */
					do_action( "yith_wcaf_before_{$handler}", self::$posted_data, $handler_option );

					if ( method_exists( 'YITH_WCAF_Form_Handler_Premium', $handler ) ) {
						self::$last_result = YITH_WCAF_Form_Handler_Premium::$handler( self::$posted_data );
					} elseif ( method_exists( self::class, $handler ) ) {
						self::$last_result = self::$handler( self::$posted_data );
					}

					/**
					 * DO_ACTION: yith_wcaf_after_$handler
					 *
					 * Allows to trigger some action after executing the form handler.
					 * <code>$handler</code> will be replaced with the form handler.
					 *
					 * @param object $last_result    Last result.
					 * @param array  $posted_data    Posted data.
					 * @param array  $handler_option Handler option.
					 */
					do_action( "yith_wcaf_after_{$handler}", self::$last_result, self::$posted_data, $handler_option );
				} catch ( Exception $e ) {
					self::$posted_data = self::sanitize_fields( $fields );

					// translators: 1. Error message.
					wc_add_notice( sprintf( _x( '<b>Error:</b> %s', '[FRONTEND] General form error message', 'yith-woocommerce-affiliates' ), $e->getMessage() ), 'error' );
				}

				break;
			}
		}

		/**
		 * Returns last stored result
		 *
		 * @param string $handler When passed, returns reuslt only if it comes from specified handler.
		 *
		 * @return mixed Any result returned by last executed handler.
		 */
		public static function get_last_result( $handler = '' ) {
			if ( $handler && $handler !== self::$last_handler ) {
				return null;
			}

			return self::$last_result;
		}

		/* === HANDLE POSTED DATA  === */

		/**
		 * Returns sanitized posted data
		 *
		 * @param string $name    Optional name to search in posted data; if found, method will return value for that key, otherwise false. By default all posted data are returned.
		 * @param mixed  $default Default value to return if $name isn't found in posted data.
		 *
		 * @return array|mixed Array of posted data, or single value if $name is provide.
		 */
		public static function get_posted_data( $name = '', $default = null ) {
			if ( $name ) {
				// handle multi-level data.
				$components = array_map(
					function ( $item ) {
						return trim( $item, '[]' );
					},
					explode( '[', $name )
				);

				$component = current( $components );
				$posted    = self::$posted_data;

				do {
					if ( ! isset( $posted[ $component ] ) ) {
						return $default;
					}

					$posted    = $posted[ $component ];
					$component = next( $components );
				} while ( $component );

				return $posted;
			}

			return self::$posted_data;
		}

		/**
		 * Validate fields
		 *
		 * @param array $fields Fields to match against $_REQUEST {@see \yith_wcaf_parse_settings for more detais on expected structure}.
		 * @return array Array of sanitized data
		 * @throws Exception When data cannot be validated.
		 */
		public static function validate_fields( $fields ) {
			if ( ! $fields ) {
				return array();
			}

			// nonce are verified in /includes/class-yith-wcaf-form-handler.php:68.
			// phpcs:ignore WordPress.Security.NonceVerification
			return yith_wcaf_parse_settings( $_REQUEST, $fields );
		}

		/**
		 * Sanitize fields
		 *
		 * @param array $fields Fields to match against $_REQUEST {@see \yith_wcaf_parse_settings for more detais on expected structure}.
		 * @return array Array of sanitized data
		 */
		public static function sanitize_fields( $fields ) {
			if ( ! $fields ) {
				return array();
			}

			try {
				// nonce are verified in /includes/class-yith-wcaf-form-handler.php:68.
				// phpcs:ignore WordPress.Security.NonceVerification
				return yith_wcaf_parse_settings( $_REQUEST, $fields, YITH_WCAF_PARSE_SETTINGS_SANITIZE_ONLY );
			} catch ( Exception $e ) {
				return array();
			}
		}

		/* === AFFILIATE REGISTRATION HANDLERS === */

		/**
		 * Handle affiliate registration
		 *
		 * @return void
		 */
		public static function register_affiliate() {
			if (
				! yith_plugin_fw_is_true( get_option( 'yith_wcaf_referral_registration_use_wc_form' ) ) &&
				! ( isset( $_POST['register_affiliate'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['register_affiliate'] ) ), 'yith-wcaf-register-affiliate' ) )
			) {
				return;
			}

			add_action( 'woocommerce_created_customer', array( self::class, 'register_affiliate_for_customer' ), 10, 1 );
			add_filter( 'woocommerce_process_registration_errors', array( self::class, 'validate_affiliate_registration' ) );
			add_filter( 'woocommerce_registration_redirect', array( self::class, 'redirect_after_affiliate_registration' ) );
		}

		/**
		 * Register affiliate for a specific customer id
		 *
		 * @param int $customer_id Customer id.
		 * @return void
		 */
		public static function register_affiliate_for_customer( $customer_id ) {
			$auto_enable = 'yes' === get_option( 'yith_wcaf_referral_registration_auto_enable' );

			$affiliate = new YITH_WCAF_Affiliate();
			$affiliate->set_user_id( $customer_id );
			$affiliate->update_meta_data( 'application_date', current_time( 'mysql' ) );

			foreach ( self::$posted_data as $key => $value ) {
				$affiliate->update_meta_data( $key, $value );
			}

			if ( $auto_enable ) {
				$affiliate->set_status( 'enabled' );
			}

			if ( ! empty( self::$posted_data['first_name'] ) || ! empty( self::$posted_data['last_name'] ) ) {
				wp_update_user(
					array_merge(
						array(
							'ID' => $customer_id,
						),
						empty( self::$posted_data['first_name'] ) ? array() : array(
							'first_name' => self::$posted_data['first_name'],
						),
						empty( self::$posted_data['last_name'] ) ? array() : array(
							'last_name' => self::$posted_data['last_name'],
						)
					)
				);
			}

			$id = $affiliate->save();

			// trigger new affiliate action.
			/**
			 * DO_ACTION: yith_wcaf_new_affiliate_registration
			 *
			 * Allows to trigger some action when registering a customer as a new affiliate.
			 *
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			do_action( 'yith_wcaf_new_affiliate_registration', $id, $affiliate );
		}

		/**
		 * Validate fields submitted for the affiliate, adds any error to the WP_Error object passed as argument
		 *
		 * @param WP_Error $validation_errors Error object.
		 * @return WP_Error Filtered error object
		 */
		public static function validate_affiliate_registration( $validation_errors ) {
			$fields = YITH_WCAF_Affiliates_Profile::get_enabled_fields( 'view', array( 'reserved' => false ) );

			try {
				self::$posted_data = self::validate_fields( $fields );
			} catch ( Exception $e ) {
				self::$posted_data = self::sanitize_fields( $fields );
				$validation_errors->add( 'invalid_affiliate', $e->getMessage() );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_check_affiliate_validation_errors
			 *
			 * Filters the validation errors when registering a new affiliate.
			 *
			 * @param WP_Error $validation_errors Error object.
			 */
			return apply_filters( 'yith_wcaf_check_affiliate_validation_errors', $validation_errors );
		}

		/**
		 * Redirect to affiliate dashboard after registering an affiliate
		 *
		 * @return string Filtered redirect url
		 */
		public static function redirect_after_affiliate_registration() {
			$redirect = home_url( wp_get_raw_referer() );

			/**
			 * APPLY_FILTERS: yith_wcaf_redirect_to_dashboard_after_registration
			 *
			 * Filters whether to redirect to the Affiliate Dashboard after registration.
			 *
			 * @param bool $redirect_to_dashboard Whether to redirect to dashboard after registration or not.
			 */
			if ( ! $redirect || apply_filters( 'yith_wcaf_redirect_to_dashboard_after_registration', false ) ) {
				$redirect = YITH_WCAF_Dashboard()->get_dashboard_url();
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_after_registration_redirect
			 *
			 * Filters the URL to redirect after registration.
			 *
			 * @param string $redirect URL to redirect.
			 */
			return apply_filters( 'yith_wcaf_after_registration_redirect', $redirect );
		}

		/* === BECOME AN AFFILIATE === */

		/**
		 * Become an affiliate
		 *
		 * @param array $fields Submitted and sanitized fields.
		 * @return void
		 * @throws Exception When unable to retrieve or edit affiliate.
		 */
		public static function become_an_affiliate( $fields = array() ) {
			$auto_enable = 'yes' === get_option( 'yith_wcaf_referral_registration_auto_enable' );

			if ( YITH_WCAF_Affiliates()->is_user_affiliate() ) {
				throw new Exception( _x( 'You have already subscribed to our affiliate program. Thank you!', '[FRONTEND] Become an affiliate error message', 'yith-woocommerce-affiliates' ) );
			}

			$affiliate = new YITH_WCAF_Affiliate();
			$affiliate->set_user_id( get_current_user_id() );
			$affiliate->update_meta_data( 'application_date', current_time( 'mysql' ) );

			if ( $auto_enable ) {
				$affiliate->set_status( 'enabled' );
			}

			// update affiliate fields.
			foreach ( $fields as $key => $value ) {
				$affiliate->update_meta_data( $key, $value );
			}

			$id = $affiliate->save();

			/**
			 * DO_ACTION: yith_wcaf_new_affiliate_application
			 *
			 * Allows to trigger some action when a customer sends the application to become an affiliate.
			 *
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			do_action( 'yith_wcaf_new_affiliate_application', $id, $affiliate );

			// finally, redirect to affiliate dashboard.
			/**
			 * APPLY_FILTERS: yith_wcaf_become_an_affiliate_redirection
			 *
			 * Filters the URL to redirect after sending the application to become an affiliate.
			 *
			 * @param string $redirect URL to redirect.
			 */
			wp_safe_redirect( apply_filters( 'yith_wcaf_become_an_affiliate_redirection', home_url( wp_get_raw_referer() ) ) );
			die;
		}

		/* === GENERATE REFERRAL URL === */

		/**
		 * Generate referral url
		 *
		 * @param array $fields Submitted and sanitized fields.
		 * @throws Exception When there is a problem with url generation.
		 * @return string Referral url.
		 */
		public static function generate_referral_url( $fields ) {
			list( $username, $affiliate_id, $original_url ) = yith_plugin_fw_extract( $fields, 'username', 'affiliate_id', 'original_url' );

			if ( ! $affiliate_id && ! is_user_logged_in() && ! $username ) {
				throw new Exception( _x( 'Couldn\'t find an affiliate to generate the referral URL.', '[FRONTEND] Link generators error message', 'yith-woocommerce-affiliates' ) );
			}

			if ( $affiliate_id ) {
				$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );
			} elseif ( $username ) {
				$user = get_user_by( 'login', $username );

				if ( ! $user ) {
					throw new Exception( _x( 'You must submit a valid affiliate username to generate the referral URL.', '[FRONTEND] Link generators error message', 'yith-woocommerce-affiliates' ) );
				}

				$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user->ID );
			} else {
				$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();
			}

			if ( ! $affiliate ) {
				throw new Exception( _x( 'Couldn\'t find an affiliate to generate the referral URL.', '[FRONTEND] Link generators error message', 'yith-woocommerce-affiliates' ) );
			}

			// check if base is a valid url.
			$base      = filter_var( $original_url, FILTER_VALIDATE_URL );
			$base_host = wp_parse_url( $base, PHP_URL_HOST );
			$site_host = wp_parse_url( home_url(), PHP_URL_HOST );

			if ( ! apply_filters( 'yith_wcaf_is_url_hosted', $base_host === $site_host, $base_host, $site_host ) ) {
				$base = '';
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_link_generator_generated_url
			 *
			 * Filters the generated URL in the link generator.
			 *
			 * @param string $referral_url Referral URL.
			 */
			return apply_filters( 'yith_wcaf_link_generator_generated_url', YITH_WCAF()->get_referral_url( $affiliate->get_token(), $base ) );
		}

		/* === AFFILIATE SETTINGS === */

		/**
		 * Registers affiliate's preferences
		 *
		 * @param array $fields Submitted and sanitized fields.
		 * @throws Exception When an error occurs with data processing.
		 * @retuns void.
		 */
		public static function save_affiliate_settings( $fields ) {
			if ( ! is_user_logged_in() ) {
				throw new Exception( _x( 'Sorry, you\'re not allowed to process this action.', '[FRONTEND] Affiliate settings error message', 'yith-woocommerce-affiliates' ) );
			}

			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			if ( ! $affiliate ) {
				throw new Exception( _x( 'Sorry, you\'re not allowed to process this action.', '[FRONTEND] Affiliate settings error message', 'yith-woocommerce-affiliates' ) );
			}

			// process gateway options.
			if ( YITH_WCAF_Gateways::should_show_fields() ) {
				$gateways = YITH_WCAF_Gateways::get_available_gateways_list();

				foreach ( array_keys( $gateways ) as $gateway_id ) {
					if ( ! isset( $fields[ $gateway_id ] ) ) {
						continue;
					}

					$affiliate->set_gateway_preferences( $gateway_id, $fields[ $gateway_id ] );
				}
			}

			// process payment email.
			$affiliate->set_payment_email( $fields['payment_email'] );
			$affiliate->save();

			/**
			 * DO_ACTION: yith_wcaf_save_affiliate_settings
			 *
			 * Allows to trigger some action when saving affiliate's settings.
			 *
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param array               $fields    Submitted and sanitized fields.
			 */
			do_action( 'yith_wcaf_save_affiliate_settings', $affiliate, $fields );

			// redirect to settings page and show success message.
			wc_add_notice( _x( 'Settings saved successfully!', '[FRONTEND] Affiliate settings success message', 'yith-woocommerce-affiliates' ) );
			wp_safe_redirect( YITH_WCAF_Dashboard()->get_dashboard_url( 'settings' ) );
			die;
		}
	}
}
