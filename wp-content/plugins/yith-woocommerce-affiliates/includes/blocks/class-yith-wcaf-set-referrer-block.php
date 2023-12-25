<?php
/**
 * Set referrer block
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Blocks
 * @version 2.16.0
 */

use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Set_Referrer_Block' ) ) {
	/**
	 * "Set Referrer" block
	 *
	 * @since 2.16.0
	 */
	class YITH_WCAF_Set_Referrer_Block implements IntegrationInterface {

		/**
		 * Register block
		 */
		public static function register() {
			add_action(
				'woocommerce_blocks_checkout_block_registration',
				function( $registry ) {
					$registry->register( new self() );
				}
			);

			add_filter(
				'__experimental_woocommerce_blocks_add_data_attributes_to_block',
				function( $blocks ) {
					$blocks[] = 'yith/yith-wcaf-set-referrer';
					return $blocks;
				}
			);
		}

		/**
		 * The name of the integration.
		 *
		 * @return string
		 */
		public function get_name() {
			return 'yith/yith-wcaf-set-referrer';
		}

		/**
		 * When called invokes any initialization/setup for the integration.
		 */
		public function initialize() {
			$this->register_frontend_scripts();
			$this->register_editor_scripts();
		}

		/**
		 * Returns an array of script handles to enqueue in the frontend context.
		 *
		 * @return string[]
		 */
		public function get_script_handles() {
			return array( 'yith-wcaf-shortcodes', 'yith-wcaf-blocks-set-referrer-frontend' );
		}

		/**
		 * Returns an array of script handles to enqueue in the editor context.
		 *
		 * @return string[]
		 */
		public function get_editor_script_handles() {
			return array( 'yith-wcaf-blocks-set-referrer' );
		}

		/**
		 * An array of key, value pairs of data made available to the block on the client side.
		 *
		 * @return array
		 */
		public function get_script_data() {
			return array();

		}

		/**
		 * Register scripts to be used within Editor
		 */
		public function register_editor_scripts() {
			YITH_WCAF_Scripts::register( 'yith-wcaf-blocks-set-referrer', 'blocks', array() );
		}

		/**
		 * Register scripts to be used on Frontend
		 */
		public function register_frontend_scripts() {
			YITH_WCAF_Scripts::register( 'yith-wcaf-blocks-set-referrer-frontend', 'blocks', array(), true );
		}
	}
}
