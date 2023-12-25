<?php
/**
 * Gateways related functions and actions.
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

defined( 'YITH_WCAF' ) || exit;

if ( ! class_exists( 'YITH_WCAF_Gateways' ) ) {
	/**
	 * Endpoint class
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Gateways {

		/**
		 * Available gateways
		 *
		 * @var YITH_WCAF_Abstract_Gateway[]
		 */
		protected static $available_gateways = array();

		/**
		 * Hooks actions required to install gateways
		 *
		 * @return void
		 */
		public static function init() {
			// load defined gateways.
			self::load_gateways();

			// then load legacy ones.
			self::load_legacy_gateways();

			// init fields.
			add_action( 'yith_wcaf_settings_form_before_additional_info', array( self::class, 'show_fields' ) );
		}

		/**
		 * Loads defined gateways
		 * Allow third party code to define custom gateways through the use of {@code yith_wcaf_payment_gateways} filter
		 * Note that Gateway class must be included at the moment of filtering the array, as the method will check if class exists
		 * before proceeding further.
		 *
		 * @return void
		 */
		protected static function load_gateways() {
			/**
			 * APPLY_FILTERS: yith_wcaf_payment_gateways
			 *
			 * Filters the payment gateways.
			 *
			 * @param array $payment_gateways Payment gateways.
			 */
			$gateways = apply_filters(
				'yith_wcaf_payment_gateways',
				array(
					'bacs',
					'paypal',
					'funds',
					'payouts',
				)
			);

			if ( empty( $gateways ) ) {
				return;
			}

			// Loads defined gateways.
			foreach ( $gateways as $gateway_slug ) {
				$gateway_class = str_replace( '-', '_', $gateway_slug );
				$gateway_class = "YITH_WCAF_{$gateway_class}_Gateway";

				if ( ! class_exists( $gateway_class ) ) {
					continue;
				}

				$gateway = new $gateway_class();

				if ( ! $gateway instanceof YITH_WCAF_Abstract_Gateway ) {
					continue;
				}

				self::$available_gateways[ $gateway_slug ] = $gateway;
			}
		}

		/**
		 * Loads legacy gateways
		 * Offers backward compatibility for old gateways.
		 *
		 * @return void
		 */
		protected static function load_legacy_gateways() {
			/**
			 * APPLY_FILTERS: yith_wcaf_available_gateways
			 *
			 * Filters the available legacy gateways.
			 *
			 * @param array $legacy_gateways Legacy gateways.
			 */
			$legacy_gateways = apply_filters( 'yith_wcaf_available_gateways', array() );

			if ( empty( $legacy_gateways ) ) {
				return;
			}

			foreach ( $legacy_gateways as $gateway_id => $gateway_properties ) {
				try {
					self::$available_gateways[ $gateway_id ] = new YITH_WCAF_Legacy_Gateway_Wrapper( $gateway_id, $gateway_properties );
				} catch ( Exception $e ) {
					continue;
				}
			}
		}

		/**
		 * Checks whether a gateway with a specific id exists
		 *
		 * @param string $id Gateway slug.
		 * @return bool Whether gateway exists or not.
		 */
		public static function is_valid_gateway( $id ) {
			return array_key_exists( $id, self::$available_gateways );
		}

		/**
		 * Checks whether a gateway with a specific id exists and is available
		 *
		 * @param string $id Gateway slug.
		 * @return bool Whether gateway is available or not.
		 */
		public static function is_available_gateway( $id ) {
			if ( ! self::is_valid_gateway( $id ) ) {
				return false;
			}

			$gateway = self::get_gateway( $id );

			return $gateway && $gateway->is_enabled();
		}

		/**
		 * Retrieves gateway object for a specific slug
		 *
		 * @param string $id Gateway id.
		 *
		 * @return YITH_WCAF_Abstract_Gateway|bool Gateway object, or false on failure
		 */
		public static function get_gateway( $id ) {
			if ( ! isset( self::$available_gateways[ $id ] ) ) {
				return false;
			}

			return self::$available_gateways[ $id ];
		}

		/**
		 * Returns a list of all gateways
		 *
		 * @return YITH_WCAF_Abstract_Gateway[]
		 */
		public static function get_gateways() {
			return self::$available_gateways;
		}

		/**
		 * Returns a list of all available gateways
		 *
		 * @return YITH_WCAF_Abstract_Gateway[]
		 */
		public static function get_available_gateways() {
			$available_gateways = array();

			foreach ( self::$available_gateways as $gateway_id => $gateway ) {
				if ( ! $gateway->is_enabled() ) {
					continue;
				}

				$available_gateways[ $gateway_id ] = $gateway;
			}

			return $available_gateways;
		}

		/**
		 * Returns a list of names for each available gateways
		 *
		 * @return string[]
		 */
		public static function get_available_gateways_list() {
			$available_gateways = self::get_available_gateways();

			if ( empty( $available_gateways ) ) {
				return array();
			}

			return array_map(
				function( $gateway ) {
					return $gateway->get_name();
				},
				$available_gateways
			);
		}

		/**
		 * Returns a formatted list of field for all available gateways
		 *
		 * @return array Array of available gateways fields.
		 */
		public static function get_available_gateways_fields() {
			$gateways = self::get_available_gateways();
			$fields   = array();

			foreach ( $gateways as $gateway_id => $gateway ) {
				if ( ! $gateway->has_fields() ) {
					continue;
				}

				$fields[ $gateway_id ] = $gateway->get_fields();
			}

			return $fields;
		}

		/**
		 * Get array of registered gateway ids
		 *
		 * @since 2.6.0
		 * @return array of strings
		 */
		public static function get_gateway_ids() {
			return wp_list_pluck( self::$available_gateways, 'id' );
		}

		/**
		 * Checks if payments can be processed on current site
		 *
		 * @return bool
		 */
		public static function check_current_instance() {
			return YITH_WCAF_Instance::check();
		}

		/* === PRINT METHODS === */

		/**
		 * Whether to show passed gateway in settings or not
		 *
		 * @param YITH_WCAF_Abstract_Gateway $gateway Gateway object.
		 * @return bool Whether to show gateway or not.
		 */
		public static function should_show_gateway( $gateway ) {
			if ( ! $gateway instanceof YITH_WCAF_Abstract_Gateway ) {
				return false;
			}

			if ( ! $gateway->is_enabled() ) {
				return false;
			}

			$current_action = current_action();

			// only show gateway on settings if it has fields.
			if ( 'yith_wcaf_settings_form_before_additional_info' === $current_action && ! $gateway->has_fields() ) {
				return false;
			}

			return true;
		}

		/**
		 * Show gateways fields when necessary
		 *
		 * @param YITH_WCAF_Abstract_Object $item Affiliate object or anything with ->get_affiliate() method; if not provided, current affiliate will be used instead.
		 *
		 * @return void
		 */
		public static function show_fields( $item = false ) {
			if ( ! self::should_show_fields() ) {
				return;
			}

			if ( ! $item ) {
				$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();
			} elseif ( method_exists( $item, 'get_affiliate' ) ) {
				$affiliate = $item->get_affiliate();
			} elseif ( $item instanceof YITH_WCAF_Affiliate ) {
				$affiliate = $item;
			} else {
				$affiliate = false;
			}

			foreach ( self::get_available_gateways() as $gateway_id => $gateway ) {
				$fields      = self::get_fields_to_show( $gateway );
				$preferences = $affiliate ? $affiliate->get_gateway_preferences( $gateway_id ) : array();
				$selected    = false;

				if ( ! self::should_show_gateway( $gateway ) ) {
					continue;
				}

				if ( $item instanceof YITH_WCAF_Payment && $gateway_id === $item->get_gateway_id() ) {
					$preferences = $item->get_gateway_details();
					$selected    = true;
				}

				self::maybe_open_form_container( $gateway, $selected );

				if ( ! empty( $fields ) ) {
					foreach ( $fields as $field_key => $field ) {
						$field_name    = self::get_field_name( $gateway, $field_key );
						$field_default = isset( $preferences[ $field_key ] ) ? $preferences[ $field_key ] : null;

						/**
						 * APPLY_FILTERS: yith_wcaf_gateway_$gateway_id_$field_key_label
						 *
						 * Filters the label of the payment gateway field.
						 * <code>$gateway_id</code> will be replaced with the id of the payment gateway.
						 * <code>$field_key</code> will be replaced with the key of the field.
						 *
						 * @param string $field_label Field label.
						 * @param array  $field       Field.
						 */
						$field['label'] = apply_filters( "yith_wcaf_gateway_{$gateway_id}_{$field_key}_label", isset( $field['label'] ) ? $field['label'] : '', $field );

						/**
						 * APPLY_FILTERS: yith_wcaf_gateway_$gateway_id_$field_key_required
						 *
						 * Filters whether the gateway field is required.
						 * <code>$gateway_id</code> will be replaced with the id of the payment gateway.
						 * <code>$field_key</code> will be replaced with the key of the field.
						 *
						 * @param bool  is_required Whether the field is required or not.
						 * @param array $field      Field.
						 */
						$field['required'] = apply_filters( "yith_wcaf_gateway_{$gateway_id}_{$field_key}_required", isset( $field['required'] ) ? $field['required'] : false, $field );
						$field['id']       = "gateway_{$gateway_id}_{$field_key}";

						woocommerce_form_field( $field_name, $field, YITH_WCAF_Form_Handler::get_posted_data( $field_name, $field_default ) );
					}
				}

				self::maybe_close_form_container( $gateway, $selected );
			}
		}

		/**
		 * Returns name to use for a specific field
		 *
		 * @param YITH_WCAF_Abstract_Gateway $gateway   Gateway object.
		 * @param string                     $field_key Key of the field.
		 *
		 * @return string Name to use for the field.
		 */
		public static function get_field_name( $gateway, $field_key ) {
			$current_action = current_action();
			$field_name     = $field_key;
			$gateway_id     = $gateway->get_id();

			if ( 'yith_wcaf_settings_form_before_additional_info' === $current_action ) {
				$field_name = "{$gateway_id}[$field_key]";
			} elseif ( 'yith_wcaf_payment_details_panel' === $current_action ) {
				$field_name = "gateway_preferences[{$gateway_id}][$field_key]";
			}

			return $field_name;
		}

		/**
		 * Checks whether we should show gateways fields for the affiliate
		 *
		 * @return bool Whether we should show gateway fields for the affiliate
		 */
		public static function should_show_fields() {
			return ! ! self::get_available_gateways();
		}

		/**
		 * Returns an array of fields to show per gateway
		 *
		 * @param YITH_WCAF_Abstract_Gateway $gateway Gateway object.
		 *
		 * @reutrn array Array of fields to show.
		 */
		public static function get_fields_to_show( $gateway ) {
			return $gateway->get_fields();
		}

		/**
		 * Wrap fields when required
		 *
		 * @param YITH_WCAF_Abstract_Gateway $gateway  Gateway object.
		 * @param bool                       $selected Whether gateway is selected or not.
		 */
		public static function maybe_open_form_container( $gateway, $selected = false ) {
			$current_action = current_action();

			if ( 'yith_wcaf_settings_form_before_additional_info' === $current_action ) :
				?>
				<div class="settings-box">
					<h3><?php echo esc_html( $gateway->get_name() ); ?></h3>
				<?php
			elseif ( 'yith_wcaf_payment_details_panel' === $current_action ) :
				?>
				<div class="settings-box accordion-option">
					<input
						type="radio"
						name="gateway_preferences[gateway]"
						id="gateway_<?php echo esc_attr( $gateway->get_id() ); ?>"
						class="accordion-radio"
						value="<?php echo esc_attr( $gateway->get_id() ); ?>"
						<?php checked( $selected ); ?>
					/>
					<label for="gateway_<?php echo esc_attr( $gateway->get_id() ); ?>">
						<?php echo esc_html( $gateway->get_name() ); ?>
					</label>
					<div id="gateway_<?php echo esc_attr( $gateway->get_id() ); ?>_fields" class="accordion-content">
				<?php
			endif;
		}

		/**
		 * Closes fields wrap when was previously opened
		 *
		 * @param YITH_WCAF_Abstract_Gateway $gateway Gateway object.
		 * @param bool                       $selected Whether gateway is selected or not.
		 */
		public static function maybe_close_form_container( $gateway, $selected ) {
			$current_action = current_action();

			if ( 'yith_wcaf_settings_form_before_additional_info' === $current_action ) :
				?>
				</div>
				<?php
			elseif ( 'yith_wcaf_payment_details_panel' === $current_action ) :
				?>
					</div>
				</div>
				<?php
			endif;
		}

	}
}
