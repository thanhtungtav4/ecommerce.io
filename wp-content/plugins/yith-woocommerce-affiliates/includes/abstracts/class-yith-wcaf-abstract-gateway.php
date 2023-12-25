<?php
/**
 * Generic gateway object
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Abstracts
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Gateway' ) ) {

	/**
	 * Affiliate generic object
	 *
	 * @since 2.0.0
	 */
	abstract class YITH_WCAF_Abstract_Gateway {

		/**
		 * Gateway id
		 *
		 * @var string
		 */
		protected $id = false;

		/**
		 * Gateway name
		 *
		 * @var string
		 */
		protected $name = '';

		/**
		 * Array of fields to show on settings page for this gateway
		 *
		 * @var array
		 */
		protected $fields = array();

		/**
		 * Array of settings to show on backend for this gateway
		 *
		 * @var array
		 */
		protected $settings = array();

		/**
		 * Array of admin preferences entered for gateway settings.
		 * It includes at least enabled flag.
		 *
		 * @var array
		 */
		protected $options = array();

		/**
		 * Includes supported features for the gateway
		 *
		 * @var array
		 */
		protected $supports = array();

		/**
		 * Logger instance
		 *
		 * @var WC_Logger
		 */
		protected $logger = null;

		/**
		 * Constructor method
		 */
		public function __construct() {
			$this->init_settings();
			$this->init_fields();
		}

		/**
		 * Init settings for the gateway
		 *
		 * @return void
		 */
		protected function init_settings() {
			$this->settings = array();
		}

		/**
		 * Init fields for the gateway
		 *
		 * @return void
		 */
		protected function init_fields() {
			$this->fields = array();
		}

		/* === GETTERS === */

		/**
		 * Returns gateway slug
		 *
		 * @return string Gateway slug.
		 */
		public function get_id() {
			return $this->id;
		}

		/**
		 * Returns gateway name
		 *
		 * @return string Gateway name.
		 */
		public function get_name() {
			/**
			 * APPLY_FILTERS: yith_wcaf_$id_payment_gateway_name
			 *
			 * Filters the name of the payment gateway.
			 * <code>$id</code> will be replaced with the id of the payment gateway.
			 *
			 * @param string $name Name of the payment gateway.
			 */
			return apply_filters( "yith_wcaf_{$this->get_id()}_payment_gateway_name", $this->name );
		}

		/**
		 * Returns true if gateway is available
		 *
		 * @return bool Whether current gateway is enabled.
		 */
		public function is_available() {
			return true;
		}

		/**
		 * Returns true if gateway is enabled
		 *
		 * @return bool Whether current gateway is enabled.
		 */
		public function is_enabled() {
			return $this->is_available() && yith_plugin_fw_is_true( $this->get_option( 'enabled', 'no' ) );
		}

		/**
		 * Returns true if gateway shows fields on Settings page
		 *
		 * @return bool Whether current gateway has fields.
		 */
		public function has_fields() {
			return ! ! $this->fields;
		}

		/**
		 * Returns true if gateway has backend settings
		 *
		 * @return bool Whether current gateway has settings.
		 */
		public function has_settings() {
			return ! ! $this->settings;
		}

		/**
		 * Returns true if gateway supports a specific capability
		 *
		 * @param string $capability Capability to test.
		 *
		 * @return bool Whether current gateway supports capability.
		 */
		public function supports( $capability ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_$id_gateway_supports_$capability
			 *
			 * Filters whether the gateway supports a specific capability.
			 * <code>$id</code> will be replaced with the id of the payment gateway.
			 * <code>$capability</code> will be replaced with the capability to test.
			 *
			 * @param bool                       $suports    Whether the gateway supports a specific capability or not.
			 * @param YITH_WCAF_Abstract_Gateway $gateway    Gateway object.
			 * @param string                     $gateway_id Gateway id.
			 */
			return apply_filters( "yith_wcaf_{$this->id}_gateway_supports_{$capability}", ! empty( $this->supports[ $capability ] ), $this, $this->id );
		}

		/**
		 * Returns true if gateway supports masspay
		 *
		 * @return bool Whether current gateway supports masspay.
		 */
		public function supports_masspay() {
			return $this->supports( 'masspay' );
		}

		/**
		 * Returns a message describing why gateway is not available at the moment.
		 *
		 * @return string|bool Message for the admin, or false if gateway is available.
		 */
		public function why_not_available() {
			if ( $this->is_available() ) {
				return false;
			}

			return _x( 'Gateway is not available at the moment', '[ADMIN] Gateways table, not generally visible', 'yith-woocommerce-affiliates' );
		}

		/* === SETTERS === */

		/**
		 * Enable the gateway
		 *
		 * @return bool Status of the operation.
		 */
		public function enable() {
			return $this->set_option( 'enabled', true );
		}

		/**
		 * Disable the gateway
		 *
		 * @return bool Status of the operation.
		 */
		public function disable() {
			return $this->set_option( 'enabled', false );
		}

		/* === LOG METHODS === */

		/**
		 * Log messages for the gateway
		 *
		 * @param string $message Message to log.
		 * @param string $level   One of the following:
		 *     'emergency': System is unusable.
		 *     'alert': Action must be taken immediately.
		 *     'critical': Critical conditions.
		 *     'error': Error conditions.
		 *     'warning': Warning conditions.
		 *     'notice': Normal but significant condition.
		 *     'info': Informational messages.
		 *     'debug': Debug-level messages.
		 */
		public function log( $message, $level = 'info' ) {
			if ( ! $this->logger ) {
				$this->logger = wc_get_logger();
			}

			if ( ! $this->logger ) {
				return;
			}

			$this->logger->log(
				$level,
				$message,
				array(
					'source' => "yith-wcaf-{$this->id}-gateway",
				)
			);
		}

		/**
		 * Logs a message and an accompanying set of data
		 *
		 * @param string $message Message to log.
		 * @param mixed  $data    Data to log.
		 * @param string $level   Message level (@see \YITH_WCAF_Abstract_Gateway::log).
		 */
		public function log_data( $message, $data, $level = 'info' ) {
			$separator = "\n";

			for ( $i = 0; $i < 80; $i ++ ) {
				$separator .= '-';
			}

			$separator .= "\n";

			if ( empty( $data ) ) {
				$data_message = _x( 'Empty', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' );
			} else {
				ob_start();
				print_r( $data ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
				$data_message = ob_get_clean();
			}

			$message = "$message $separator $data_message";

			$this->log( $message, $level );
		}

		/* === PAY METHODS === */

		/**
		 * Test if gateway can be used to pay an affiliate
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
		 * @return bool Whether affiliate can be paid with this gateway or not.
		 */
		public function can_pay_affiliate( $affiliate ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_$id_gateway_can_pay_affiliate
			 *
			 * Filters whether the gateway can be used to pay an affiliate.
			 * <code>$id</code> will be replaced with the id of the payment gateway.
			 *
			 * @param bool                       $can_be_used Whether the gateway can be used to pay an affiliate or not.
			 * @param YITH_WCAF_Affiliate        $affiliate   Affiliate object.
			 * @param YITH_WCAF_Abstract_Gateway $gateway     Gateway object.
			 * @param string                     $gateway_id  Gateway id.
			 */
			return apply_filters( "yith_wcaf_{$this->id}_gateway_can_pay_affiliate", true, $affiliate, $this, $this->id );
		}

		/**
		 * Wrapper for \YITH_WCAF_Abstract_Gateway::process_payment method
		 * Performs some pre-flight checks, such as verifying that instance didn't change.
		 *
		 * @param int|int[] $payment_ids Array of (or single) payment ids to process. If gateways doesn't support masspay, only first ID will be processed.
		 *
		 * @return Array that describes status of the operation
		 * [
		 *     'status'   => bool describing operation status
		 *     'messages' => string containing operation messages
		 * ]
		 */
		public function pay( $payment_ids ) {
			if ( ! YITH_WCAF_Gateways::check_current_instance() ) {
				return array(
					'status'   => false,
					'messages' => _x( 'The payments could not be processed because the system detected a URL change', '[ADMIN] Gateway messages.', 'yith-woocommerce-affiliates' ),
				);
			}

			// saves gateway and gateway preferences for each payment.
			if ( ! empty( $payment_ids ) ) {
				$payments = new YITH_WCAF_Payments_Collection( (array) $payment_ids );

				foreach ( $payments as $payment ) {
					/**
					 * Each of the payments.
					 *
					 * @var $payment YITH_WCAF_Payment
					 */
					$payment->set_gateway_id( $this->id );

					$affiliate = $payment->get_affiliate();
					$affiliate && $payment->set_gateway_details( $affiliate->get_gateway_preferences( $this->id ) );

					$payment->save();
				}
			}

			return $this->process_payment( $payment_ids );
		}

		/**
		 * Performs the actual payment with the gateway
		 *
		 * @param int|int[] $payment_ids Array of (or single) payment ids to process. If gateways doesn't support masspay, only first ID will be processed.
		 *
		 * @return Array that describes status of the operation
		 * [
		 *     'status'   => bool describing operation status
		 *     'messages' => string containing operation messages
		 * ]
		 */
		abstract public function process_payment( $payment_ids );

		/* === SETTINGS HANDLING === */

		/**
		 * Prints settings fields for current gateway
		 *
		 * @return void
		 */
		public function print_settings() {
			if ( ! $this->has_settings() ) {
				return;
			}

			foreach ( $this->settings as $setting_id => $setting ) :
				$field_id   = "yith_wcaf_{$this->id}_gateway_settings_{$setting_id}";
				$field_name = "yith_wcaf_{$this->id}_gateway_settings[{$setting_id}]";
				$field      = $setting;

				$field['id']    = $field_id;
				$field['name']  = $field_name;
				$field['value'] = $this->get_option( $setting_id )
				?>
				<div class="form-row form-row-inline">
					<label for="<?php echo esc_attr( $field_id ); ?>">
						<?php echo esc_html( $field['label'] ); ?>
					</label>
					<div class="field-wrapper">
						<?php yith_plugin_fw_get_field( $field, true ); ?>
						<?php if ( ! empty( $field['desc'] ) ) : ?>
							<span class="description">
								<?php echo esc_html( $field['desc'] ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
				<?php
			endforeach;
			?>
			<input type="hidden" name="yith_wcaf_<?php echo esc_attr( $this->id ); ?>_gateway_settings[enabled]" value="<?php echo $this->is_enabled() ? 'yes' : 'no'; ?>"/>
			<?php
		}

		/* === FIELDS HANDLING === */

		/**
		 * Returns fields defined for current gateway, or false if no field is defined
		 *
		 * @return array|bool Array of fields or false.
		 */
		public function get_fields() {
			if ( ! $this->has_fields() ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_$id_gateway_fields
			 *
			 * Filters the fields defined for the payment gateway.
			 * <code>$id</code> will be replaced with the id of the payment gateway.
			 *
			 * @param array                      $fields     Gateway fields.
			 * @param YITH_WCAF_Abstract_Gateway $gateway    Gateway object.
			 * @param string                     $gateway_id Gateway id.
			 */
			return apply_filters( "yith_wcaf_{$this->id}_gateway_fields", $this->fields, $this, $this->id );
		}

		/**
		 * Validate submitted options, matching them against defined settings
		 * Returns validated options or throws error
		 *
		 * @param array $fields Values to validate.
		 * @return array Status of the operation
		 * @throws Exception When there is a validation error.
		 */
		public function validate_fields( $fields ) {
			if ( ! $this->has_fields() ) {
				return array();
			}

			return yith_wcaf_parse_settings( $fields, $this->get_fields() );
		}

		/* === OPTIONS HANDLING === */

		/**
		 * Returns an array of options defined for the gateway
		 *
		 * @return array Array of options.
		 */
		public function get_options() {
			return $this->maybe_read_options();
		}

		/**
		 * Returns value of a specific option
		 *
		 * @param string $option  Option name.
		 * @param mixed  $default Fallback value, to return if option is empty.
		 *
		 * @return mixed Value of the option, if any, or $default.
		 */
		public function get_option( $option, $default = false ) {
			$options = $this->maybe_read_options();

			if ( ! isset( $options[ $option ] ) && isset( $this->settings[ $option ]['default'] ) ) {
				return $this->settings[ $option ]['default'];
			} elseif ( empty( $options[ $option ] ) ) {
				return $default;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_$id_option
			 *
			 * Filters the value of a specific option for the gateway.
			 * <code>$id</code> will be replaced with the id of the payment gateway.
			 *
			 * @param string                     $value      Option value.
			 * @param array                      $option     Option.
			 * @param YITH_WCAF_Abstract_Gateway $gateway    Gateway object.
			 * @param string                     $gateway_id Gateway id.
			 */
			return apply_filters( "yith_wcaf_{$this->id}_option", $options[ $option ], $option, $this, $this->id );
		}

		/**
		 * Set a single option of the settings
		 *
		 * @param string $option Option to set.
		 * @param mixed  $value  Value to set for the option.
		 *
		 * @return bool Status of the operation
		 */
		public function set_option( $option, $value ) {
			$options = $this->maybe_read_options();

			if ( 'enabled' !== $option && ! isset( $this->settings[ $option ] ) ) {
				return false;
			}

			$options[ $option ] = $value;

			try {
				return $this->update_options( $options );
			} catch ( Exception $e ) {
				return false;
			}
		}

		/**
		 * Reads options first time it is invoked; return array of options
		 *
		 * @return array Array of options from DB.
		 */
		protected function maybe_read_options() {
			if ( ! empty( $this->options ) ) {
				return $this->options;
			}

			$option_name = "yith_wcaf_{$this->id}_gateway_settings";
			$options     = get_option( $option_name, array() );
			$defaults    = array(
				'enabled' => false,
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_$id_gateway_settings
			 *
			 * Filters the gateway settings.
			 * <code>$id</code> will be replaced with the id of the payment gateway.
			 *
			 * @param array                      $options    Array of options.
			 * @param YITH_WCAF_Abstract_Gateway $gateway    Gateway object.
			 * @param string                     $gateway_id Gateway id.
			 */
			$this->options = apply_filters( $option_name, wp_parse_args( $options, $defaults ), $this, $this->id );

			return $this->options;
		}

		/**
		 * Validate submitted options, matching them against defined settings
		 * Returns validated options or throws error
		 *
		 * @param array $options Values to validate.
		 * @return array Status of the operation
		 * @throws Exception When there is a validation error.
		 */
		public function validate_options( $options ) {
			// manually add 'enabled' to the settings.
			$settings = array_merge(
				array(
					'enabled' => array(
						'type'    => 'onoff',
						'id'      => 'enabled',
						'default' => 'no',
					),
				),
				$this->settings
			);

			return yith_wcaf_parse_settings( $options, $settings );
		}

		/**
		 * Updates option on database
		 *
		 * @param array $options Values to save.
		 *
		 * @return bool Status of the operation
		 * @throws Exception When there is a validation error.
		 */
		public function update_options( $options ) {
			$validated_options = $this->validate_options( $options );

			if ( ! $validated_options ) {
				return false;
			}

			$option_name = "yith_wcaf_{$this->id}_gateway_settings";

			return update_option( $option_name, $validated_options );
		}
	}
}
