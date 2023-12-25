<?php
/**
 * Object that wraps old gateways object, to provide current interface of methods
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Legacy_Gateway_Wrapper' ) ) {
	/**
	 * Legacy gateway wrapper
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Legacy_Gateway_Wrapper extends YITH_WCAF_Abstract_Gateway {
		/**
		 * Legacy gateway object
		 * We can expect this to have a ->pay() method, but the rest is not granted
		 * This class wraps previous object to provide all new required methods for the plugin
		 * to work with all gateways
		 *
		 * @var mixed
		 */
		protected $legacy_gateway;

		/**
		 * Constructor method
		 *
		 * @param string $gateway_id Id of the legacy gateway being loaded.
		 * @param array  $properties Optional properties for the legacy gateway.
		 *
		 * @throws Exception When gateways do not match minimum requirements.
		 */
		public function __construct( $gateway_id, $properties = array() ) {
			// set gateway id.
			$this->id = $gateway_id;

			// set gateway name.
			// translators: 1. Gateway id.
			$this->name = isset( $properties['label'] ) ? $properties['label'] : sprintf( _x( 'Legacy gateway (%s)', '[ADMIN] Generic legacy gateway name', 'yith-woocommerce-affiliates' ), $this->id );

			// load custom supports.
			if ( ! empty( $properties['mass_pay'] ) ) {
				$this->supports = array(
					'masspay' => true,
				);
			}

			// load gateway object.
			$this->load_legacy_gateway( $properties );

			parent::__construct();
		}

		/**
		 * Loads legacy gateway
		 *
		 * @param array $properties Optional properties for the legacy gateway.
		 * @throws Exception When gateways do not match minimum requirements.
		 */
		protected function load_legacy_gateway( $properties ) {
			if ( empty( $properties['path'] ) || ! file_exists( $properties['path'] ) || empty( $properties['class'] ) ) {
				throw new Exception( 'Couldn\'t load legacy gateway class' );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_gateway_inclusion_path
			 *
			 * Filters the path to load the gateway classes.
			 *
			 * @param string $path Gateway class path.
			 */
			require_once apply_filters( 'yith_wcaf_gateway_inclusion_path', $properties['path'] );

			if ( ! function_exists( $properties['class'] ) ) {
				throw new Exception( 'Legacy gateway doesn\'t match minimum required standard' );
			}

			$legacy_gateway = $properties['class']();

			if ( ! $legacy_gateway || ! method_exists( $legacy_gateway, 'pay' ) ) {
				throw new Exception( 'Legacy gateway doesn\'t match minimum required standard' );
			}

			$this->legacy_gateway = $legacy_gateway;
		}

		/**
		 * Process a payment through the gateway
		 *
		 * @param int|int[] $payment_ids Array of (or single) payment ids to process. If gateways doesn't support masspay, only first ID will be processed.
		 *
		 * @return Array that describes status of the operation
		 * [
		 *     'status'   => bool describing operation status
		 *     'messages' => string containing operation messages
		 * ]
		 */
		public function process_payment( $payment_ids ) {
			return $this->legacy_gateway->pay( $payment_ids );
		}
	}
}
