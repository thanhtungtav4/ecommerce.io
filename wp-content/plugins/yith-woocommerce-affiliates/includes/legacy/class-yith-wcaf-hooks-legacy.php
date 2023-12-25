<?php
/**
 * Affiliate class - LEGACY
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Hooks_Legacy' ) ) {
	/**
	 * Legacy Hooks
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Hooks_Legacy extends WC_Deprecated_Hooks {

		/**
		 * Array of deprecated hooks we need to handle. Format of 'new' => 'old'.
		 *
		 * @var array
		 */
		protected $deprecated_hooks = array(
			'yith_wcaf_updated_persistent_token'          => 'yith_wcaf_updated_persisten_token',
			'yith_wcaf_deleted_persistent_token'          => 'yith_wcaf_deleted_persisten_token',
			'yith_wcaf_affiliate_status_changed'          => 'yith_wcaf_affiliate_status_updated',
			'yith_wcaf_affiliate_payment_email_changed'   => 'yith_wcaf_affiliate_payment_email_updated',
			'yith_wcaf_affiliate_registration_shortcode_atts' => 'yith_wcaf_affiliate_registration_form_atts',
			'yith_wcaf_admin_table_affiliate_column'      => 'yith_wcaf_user_details_affiliates_table',
			'yith_wcaf_rate_symbol'                       => 'yith_wcaf_display_symbol',
			'yith_wcaf_rate_format'                       => 'yith_wcaf_display_format',
			'yith_wcaf_payments_table_column_default'     => 'yith_wcaf_payment_table_column_default',
			'yith_wcaf_referral_totals_table'             => 'yith_wcaf_refeal_totals_table',
			'yith_wcaf_available_admin_tabs'              => 'yith_wcaf_admin_tabs_control',
			'yith_wcaf_check_affiliate_validation_errors' => 'yith_wcaf_check_affiliate_validation_error',
			'yith_wcaf_commission_table_columns'          => 'yith_wcaf_comission_table_columns',
		);

		/**
		 * Array of versions on each hook has been deprecated.
		 *
		 * @var array
		 */
		protected $deprecated_version = array(
			'yith_wcaf_updated_persisten_token'          => '2.0.0',
			'yith_wcaf_deleted_persisten_token'          => '2.0.0',
			'yith_wcaf_affiliate_status_updated'         => '2.0.0',
			'yith_wcaf_affiliate_payment_email_updated'  => '2.0.0',
			'yith_wcaf_affiliate_registration_form_atts' => '2.0.0',
			'yith_wcaf_user_details_affiliates_table'    => '2.0.0',
		);

		/**
		 * Hook into the new hook so we can handle deprecated hooks once fired.
		 *
		 * @param string $hook_name Hook name.
		 */
		public function hook_in( $hook_name ) {
			add_filter( $hook_name, array( $this, 'maybe_handle_deprecated_hook' ), -1000, 8 );
		}

		/**
		 * If the old hook is in-use, trigger it.
		 *
		 * @param  string $new_hook          New hook name.
		 * @param  string $old_hook          Old hook name.
		 * @param  array  $new_callback_args New callback args.
		 * @param  mixed  $return_value      Returned value.
		 * @return mixed
		 */
		public function handle_deprecated_hook( $new_hook, $old_hook, $new_callback_args, $return_value ) {
			if ( has_filter( $old_hook ) ) {
				$this->display_notice( $old_hook, $new_hook );
				$return_value = $this->trigger_hook( $old_hook, $new_callback_args );
			}
			return $return_value;
		}

		/**
		 * Fire off a legacy hook with it's args.
		 *
		 * @param  string $old_hook          Old hook name.
		 * @param  array  $new_callback_args New callback args.
		 * @return mixed
		 */
		protected function trigger_hook( $old_hook, $new_callback_args ) {
			return apply_filters_ref_array( $old_hook, $new_callback_args );
		}
	}
}
