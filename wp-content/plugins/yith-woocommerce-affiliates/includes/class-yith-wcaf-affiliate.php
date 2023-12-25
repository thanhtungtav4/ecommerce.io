<?php
/**
 * Affiliate class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliate' ) ) {

	/**
	 * Affiliate object
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliate extends YITH_WCAF_Affiliate_Legacy {

		/**
		 * Token for this affiliate.
		 *
		 * @since 2.0.0
		 * @var string
		 */
		protected $token = '';

		/**
		 * Stores meta in cache for future reads.
		 *
		 * A group must be set to to enable caching.
		 *
		 * @var string
		 */
		protected $cache_group = 'affiliates';

		/**
		 * Stores user object for current user
		 *
		 * @var WP_User
		 */
		protected $user = null;

		/**
		 * Relation existing between object properties and array offesets
		 *
		 * @var array
		 */
		protected $offset_to_prop_map = array(
			'click'      => 'clicks',
			'conversion' => 'conversions',
			'enabled'    => 'status',
		);

		/**
		 * Constructor
		 *
		 * @param int|string|\YITH_WCAF_Affiliate $affiliate Affiliate identifier.
		 *
		 * @throws Exception When not able to load Data Store class.
		 */
		public function __construct( $affiliate = 0 ) {
			// set default values.
			$this->data = array(
				'user_id'       => 0,
				'rate'          => 0,
				'earnings'      => 0,
				'refunds'       => 0,
				'paid'          => 0,
				'clicks_count'  => 0,
				'conversions'   => 0,
				'status'        => 0,
				'banned'        => false,
				'payment_email' => '',
			);

			parent::__construct();

			if ( is_int( $affiliate ) && $affiliate > 0 ) {
				$this->set_id( $affiliate );
			} elseif ( $affiliate instanceof self ) {
				$this->set_id( $affiliate->get_id() );
			} elseif ( is_string( $affiliate ) ) {
				$this->set_token( $affiliate );
			} else {
				$this->set_object_read( true );
			}

			$this->data_store = WC_Data_Store::load( 'affiliate' );

			if ( $this->get_id() > 0 || ! empty( $this->get_token() ) ) {
				$this->data_store->read( $this );
			}
		}

		/* === GETTERS === */

		/**
		 * Get token for the affiliate
		 *
		 * @return string Token.
		 */
		public function get_token() {
			return $this->token;
		}

		/**
		 * Return user id for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @return int User id.
		 */
		public function get_user_id( $context = 'view' ) {
			return (int) $this->get_prop( 'user_id', $context );
		}

		/**
		 * Return user object for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read user again from db, even if a cached version exists.
		 * @return WP_User User object.
		 */
		public function get_user( $context = 'view', $refresh = false ) {
			$user_id = $this->get_user_id( $context );

			if ( ! $user_id ) {
				return null;
			}

			if ( empty( $this->user ) || $user_id !== $this->user->ID || $refresh ) {
				$this->user = get_userdata( $user_id );
			}

			return $this->user;
		}

		/**
		 * Return rate for current affiliate
		 *
		 * @param string $context             Context of the operation.
		 * @param bool   $fallback_to_default Whether to return default rate, if specific one is empty.
		 *
		 * @return float Affiliate specific rate.
		 */
		public function get_rate( $context = 'view', $fallback_to_default = false ) {
			$rate = (float) $this->get_prop( 'rate', $context );

			if ( ! $rate && $fallback_to_default ) {
				$rate = YITH_WCAF_Rate_Handler::get_default();
			}

			return $rate;
		}

		/**
		 * Return formatted rate for current affiliate
		 *
		 * @param string $context             Context of the operation.
		 * @param bool   $fallback_to_default Whether to return default rate, if specific one is empty.
		 *
		 * @return string Affiliate specific rate.
		 */
		public function get_formatted_rate( $context = 'view', $fallback_to_default = false ) {
			return yith_wcaf_rate_format( $this->get_rate( $context, $fallback_to_default ) );
		}

		/**
		 * Return earnings for current affiliate
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Return total earnings.
		 */
		public function get_earnings( $context = 'view' ) {
			return (float) $this->get_prop( 'earnings', $context );
		}

		/**
		 * Return formatted earnings for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted affiliate earnings.
		 */
		public function get_formatted_earnings( $context = 'view', $args = array() ) {
			$amount = (float) $this->get_earnings( $context );

			return wc_price( $amount, $args );
		}

		/**
		 * Return amount of refunds for current affiliate
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Return total refunds.
		 */
		public function get_refunds( $context = 'view' ) {
			return (float) $this->get_prop( 'refunds', $context );
		}

		/**
		 * Return formatted refunds for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted affiliate refunds.
		 */
		public function get_formatted_refunds( $context = 'view', $args = array() ) {
			$amount = (float) $this->get_refunds( $context );

			return wc_price( $amount, $args );
		}

		/**
		 * Returns totals, calculated as earnings + refunds
		 *
		 * @return float Return total earnings.
		 */
		public function get_total() {
			return $this->get_earnings() + $this->get_refunds();
		}

		/**
		 * Return formatted total for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted affiliate total.
		 */
		public function get_formatted_total( $context = 'view', $args = array() ) {
			$amount = (float) $this->get_total( $context );

			return wc_price( $amount, $args );
		}

		/**
		 * Returns balance, calculated as earnings - paid
		 *
		 * @param string $context     Context of the operation.
		 * @param bool   $recalculate Whether system should recalculate balance from currently pending commissions.
		 *
		 * @return float Return total earnings.
		 */
		public function get_balance( $context = 'view', $recalculate = false ) {
			if ( ! $recalculate ) {
				return max( 0, $this->get_earnings( $context ) - $this->get_paid( $context ) );
			} else {
				$commissions = YITH_WCAF_Commissions()->get_commissions(
					array(
						'status' => 'pending',
					)
				);

				if ( empty( $commissions ) ) {
					return 0;
				}

				return $commissions->get_total_amount();
			}
		}

		/**
		 * Return formatted balance for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted affiliate balance.
		 */
		public function get_formatted_balance( $context = 'view', $args = array() ) {
			$amount = (float) $this->get_balance( $context );

			return wc_price( $amount, $args );
		}

		/**
		 * Return amount paid to current affiliate
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Return total paid.
		 */
		public function get_paid( $context = 'view' ) {
			return (float) $this->get_prop( 'paid', $context );
		}

		/**
		 * Return formatted amount paid for current affiliate
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted amount paid to affiliate.
		 */
		public function get_formatted_paid( $context = 'view', $args = array() ) {
			$amount = (float) $this->get_paid( $context );

			return wc_price( $amount, $args );
		}

		/**
		 * Return number of clicks registered for current affiliate
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return int Return number of clicks.
		 */
		public function get_clicks_count( $context = 'view' ) {
			return (int) $this->get_prop( 'clicks_count', $context );
		}

		/**
		 * Same as get_clicks
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return int Return number of clicks.
		 */
		public function get_click( $context = 'view' ) {
			return $this->get_clicks_count( $context );
		}

		/**
		 * Return number of conversions registered for current affiliate
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return int Return number of conversions.
		 */
		public function get_conversions( $context = 'view' ) {
			return (int) $this->get_prop( 'conversions', $context );
		}

		/**
		 * Same as get_conversions
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return int Return number of conversions.
		 */
		public function get_conversion( $context = 'view' ) {
			return $this->get_conversions( $context );
		}

		/**
		 * Get conversion rate, calculated as conversions/clicks
		 *
		 * @return float Conversion rate.
		 */
		public function get_conversion_rate() {
			$clicks = $this->get_clicks_count();

			if ( ! $clicks ) {
				return 0;
			}

			return $this->get_conversions() / $clicks * 100;
		}

		/**
		 * Return current status of the affiliate, as stored in database
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return int Affiliate status.
		 */
		public function get_raw_status( $context = 'view' ) {
			return (int) $this->get_prop( 'status', $context );
		}

		/**
		 * Same as get_raw_status
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return int Affiliate status.
		 */
		public function get_enabled( $context = 'view' ) {
			return $this->get_raw_status( $context );
		}

		/**
		 * Return current status of the affiliate, as stored in database
		 *
		 * @param string|array $statuses Array of statues to check.
		 *
		 * @return int Affiliate status.
		 */
		public function has_status( $statuses ) {
			if ( ! is_array( $statuses ) ) {
				$statuses = (array) $statuses;
			}

			return in_array( $this->get_status(), $statuses, true );
		}

		/**
		 * Return current status of the affiliate, as a slug
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Affiliate status.
		 */
		public function get_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Affiliates::get_available_statuses();
			$current_status     = $this->get_raw_status( $context );

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses[0]['slug'];
			}

			return $available_statuses[ $current_status ]['slug'];
		}

		/**
		 * Return current status of the affiliate, as a localized string
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Affiliate formatted status.
		 */
		public function get_formatted_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Affiliates::get_available_statuses();
			$current_status     = $this->get_raw_status( $context );

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses[0]['name'];
			}

			return $available_statuses[ $current_status ]['name'];
		}

		/**
		 * Return value of banned property
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return bool Affiliate banned status.
		 */
		public function get_banned( $context = 'view' ) {
			return ! ! $this->get_prop( 'banned', $context );
		}

		/**
		 * Same as get_banned
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return bool Whether current affiliate is banned.
		 */
		public function is_banned( $context = 'view' ) {
			return $this->get_banned( $context );
		}

		/**
		 * Returns true when affiliate can receive commissions
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return bool Whether current affiliate is valid.
		 */
		public function is_valid( $context = 'view' ) {
			$is_valid = $this->has_status( 'enabled' ) && ! $this->is_banned( $context );

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_is_valid
			 *
			 * Filters whether affiliates is valid (can receive commissions) or not.
			 *
			 * @param bool                $is_valid  Whether affiliate is valid or not.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_affiliate_is_valid', $is_valid, $this->get_id(), $this );
		}

		/**
		 * Return payment email as registered in affiliate record
		 * Note that this is an outdated field, and it is preserved just for backward compatibility
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Affiliate payment email.
		 */
		public function get_payment_email( $context = 'view' ) {
			return $this->get_prop( 'payment_email', $context );
		}

		/**
		 * Get referral url
		 *
		 * @param string|bool $base_url Base url to use, or false, if home url should be used.
		 *
		 * @return string|bool Generated affiliate url, or false on failure
		 * @since 1.0.0
		 */
		public function get_referral_url( $base_url = false ) {
			$ref_name = YITH_WCAF_Session()->get_ref_name();
			$token    = $this->get_token();

			if ( ! $token ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_get_referral_url
			 *
			 * Filters affiliate referral url.
			 *
			 * @param string $referral_url Affiliate referral url.
			 * @param string $ref_name     Name of the parameter used for referral token in url.
			 * @param string $token        Affiliate token.
			 * @param string $base_url     Url used as a base for referral url generation.
			 */
			return apply_filters( 'yith_wcaf_get_referral_url', YITH_WCAF()->get_referral_url( $token, $base_url ), $ref_name, $token, $base_url );
		}

		/**
		 * Returns first name of the affiliate, if set
		 *
		 * @return string First name.
		 */
		public function get_first_name() {
			$value = $this->get_meta( 'first_name' );

			if ( ! $value ) {
				$user  = $this->get_user();
				$value = $user ? $user->first_name : $value;
			}

			return $value;
		}

		/**
		 * Returns last name of the affiliate, if set
		 *
		 * @return string First name.
		 */
		public function get_last_name() {
			$value = $this->get_meta( 'last_name' );

			if ( ! $value ) {
				$user  = $this->get_user();
				$value = $user ? $user->last_name : $value;
			}

			return $value;
		}

		/**
		 * Returns formatted name for the affiliate
		 *
		 * @param string $context Context of the operation (when in edit context, additional user info will be added).
		 *
		 * @return string Formatted affiliate name; empty string if no user is selected
		 */
		public function get_formatted_name( $context = 'view' ) {
			$user = $this->get_user( $context );

			if ( ! $user ) {
				return '';
			}

			$name = '';

			$first_name = $this->get_first_name();
			$last_name  = $this->get_last_name();

			if ( $first_name || $last_name ) {
				$name .= esc_html( ucfirst( $first_name ) . ' ' . ucfirst( $last_name ) );
			} else {
				$name .= esc_html( ucfirst( $user->display_name ) );
			}

			if ( 'edit' === $context ) {
				$name = $name . ' (#' . $user->ID . ' - ' . sanitize_email( $user->user_email ) . ')';
			}

			return $name;
		}

		/**
		 * Returns a list of users that have current affiliate as Associated Affiliate
		 *
		 * @return WP_User[]|bool List of users.
		 */
		public function get_associated_users() {
			// ignoring performance notice as there is no way around this query.
			// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key, WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			$users = get_users(
				array(
					'meta_key'   => '_yith_wcaf_persistent_token',
					'meta_value' => $this->get_token(),
				)
			);
			// phpcs:enable WordPress.DB.SlowDBQuery.slow_db_query_meta_key, WordPress.DB.SlowDBQuery.slow_db_query_meta_value

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_associated_users
			 *
			 * Filters list of users associated with an affiliate.
			 *
			 * @param WP_User[]|bool      $users     List of users objects, or false on failure.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_affiliate_associated_users', $users, $this->get_id(), $this );
		}

		/**
		 * Returns affiliate's preferences for a specific gateway
		 *
		 * @param string $gateway_id Gateway id.
		 * @return array|bool Array of saved preferences; false on failure or if no preference is saved.
		 */
		public function get_gateway_preferences( $gateway_id ) {
			if ( ! YITH_WCAF_Gateways::is_valid_gateway( $gateway_id ) ) {
				return false;
			}

			$meta_name = "{$gateway_id}_gateway_preferences";

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_$GATEWAY_ID_gateway_preferences
			 *
			 * Filters preferences affiliate configured for a specific gateway.
			 * <code>$GATEWAY_ID</code> will be replaced by the actual id of the gateway.
			 *
			 * @param array               $preferences Preferences configured for current gateway.
			 * @param int                 $id          Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate   Affiliate object.
			 */
			return apply_filters( "yith_wcaf_affiliate_{$gateway_id}_gateway_preferences", $this->get_meta( $meta_name ), $this->get_id(), $this );
		}

		/**
		 * Returns affiliate's preferences for a specific gateway and option_id
		 *
		 * @param string $gateway_id Gateway id.
		 * @param string $option_id  Id of the option to retrieve.
		 *
		 * @return mixed|bool Value of the retrieved option or false.
		 */
		public function get_gateway_preference( $gateway_id, $option_id ) {
			$preferences = $this->get_gateway_preferences( $gateway_id );

			if ( ! $preferences || ! is_array( $preferences ) || ! isset( $preferences[ $option_id ] ) ) {
				return false;
			}

			return $preferences[ $option_id ];
		}

		/**
		 * Returns affiliate invoice profile as saved in affiliate's meta
		 *
		 * @return array Array containing Affiliate's billing information.
		 */
		public function get_invoice_profile() {
			$invoice_fields = YITH_WCAF_Affiliates_Invoice_Profile::get_available_billing_fields();
			$profile        = array();

			foreach ( array_keys( $invoice_fields ) as $field_id ) {
				$meta = "invoice_$field_id";

				$profile[ $field_id ] = $this->get_meta( $meta );
			}

			return $profile;
		}

		/**
		 * Retrieve formatted invoice profile for the user
		 *
		 * @return mixed Array of stored information about affiliate invoice profile
		 */
		public function get_formatted_invoice_profile() {
			$available_fields = YITH_WCAF_Affiliates_Invoice_Profile::get_available_billing_fields();
			$invoice_profile  = array_filter( $this->get_invoice_profile() );

			// if empty invoice profile, return.
			if ( empty( $invoice_profile ) ) {
				return '';
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_formatted_affiliate_invoice_profile_format
			 *
			 * Filters template used to format affiliate's invoice profile
			 * Any placeholder is included between a double pair of curly braces; following a list of available fields
			 * <ul>
			 * <li>first_name</li>
			 * <li>last_name</li>
			 * <li>company</li>
			 * <li>billing_address_1</li>
			 * <li>billing_address_2</li>
			 * <li>billing_city</li>
			 * <li>billing_postcode</li>
			 * <li>billing_state</li>
			 * <li>billing_country</li>
			 * <li>cif</li>
			 * <li>vat</li>
			 * </ul>.
			 *
			 * @param string $format invoice profile format template.
			 */
			$textual_profile = apply_filters(
				'yith_wcaf_formatted_affiliate_invoice_profile_format',
				'{{first_name}} {{last_name}}
				 {{company}}
				 {{billing_address_1}}, {{billing_city}} {{billing_postcode}}
				 {{billing_state}} {{billing_country}}
				 {{cif}}
				 {{vat}}'
			);

			if ( empty( $available_fields ) ) {
				return '';
			}

			foreach ( $available_fields as $field => $label ) {
				$value = isset( $invoice_profile[ $field ] ) ? $invoice_profile[ $field ] : '';

				if ( 'billing_state' === $field && ! empty( $invoice_profile['billing_country'] ) ) {
					$country = $invoice_profile['billing_country'];

					// Handle full state name.
					$states = WC()->countries->get_states( $country );
					$value  = ( $country && isset( $states[ $value ] ) ) ? $states[ $value ] : $value;
				}

				$textual_profile = str_replace( "{{{$field}}}", $value, $textual_profile );
			}

			// clean resulting address, by removing empty lines and remaining placeholders.
			$profile_components = explode( "\n", $textual_profile );
			$profile_components = array_map(
				function( $component ) {
					$component = preg_replace( '/\{\{[^}]+\}\}/', '', $component );

					return trim( $component, ", \n\r\t\v\x00" );
				},
				$profile_components
			);
			$formatted_profile  = implode( "\n", array_filter( $profile_components ) );

			/**
			 * APPLY_FILTERS: yith_wcaf_formatted_affiliate_invoice_profile
			 *
			 * Filters affiliates formatted invoice profile HTML.
			 *
			 * @param string              $profile          Affiliate formatted invoice profile.
			 * @param int                 $user_id          User id.
			 * @param array               $available_fields Fields available for invoice profile, as configured by admin.
			 * @param array               $invoice_profile  Affiliate invoice profile info.
			 * @param YITH_WCAF_Affiliate $affiliate        Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_formatted_affiliate_invoice_profile', nl2br( $formatted_profile ), $this->get_user_id(), $available_fields, $invoice_profile, $this );
		}

		/**
		 * Returns message set for the affiliate
		 *
		 * @param string $message_type Message to retrieve.
		 * @return string Message retrieved.
		 */
		public function get_message( $message_type ) {
			$message = $this->get_meta( "{$message_type}_message" );

			if ( ! $message && yith_plugin_fw_is_true( get_option( "yith_wcaf_enable_global_{$message_type}_message", 'no' ) ) ) {
				$message = get_option( "yith_wcaf_global_{$message_type}_message" );
			}

			return $message;
		}

		/**
		 * Returns a list of actions that admin can perform over these object, including url to perform them.
		 *
		 * @return array Array of valid actions.
		 */
		public function get_admin_actions() {
			if ( empty( $this->admin_actions ) ) {
				$item_id   = $this->get_id();
				$is_banned = $this->is_banned();

				$this->admin_actions = array_merge(
					! $is_banned && ! $this->has_status( 'enabled' ) ? array(
						'enable' => array(
							'label' => _x( 'Enable affiliate', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'tip'   => _x( 'Change status to accepted', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'url'   => YITH_WCAF_Admin_Actions::get_action_url(
								'change_status',
								array(
									'affiliate_id' => $item_id,
									'status'       => 'enabled',
								)
							),
						),
					) : array(),
					! $is_banned && ! $this->has_status( 'disabled' ) ? array(
						'disable' => array(
							'label' => _x( 'Reject affiliate', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'tip'   => _x( 'Change status to rejected', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'url'   => YITH_WCAF_Admin_Actions::get_action_url(
								'change_status',
								array(
									'affiliate_id' => $item_id,
									'status'       => 'disabled',
								)
							),
						),
					) : array(),
					! $is_banned ? array(
						'ban' => array(
							'label' => _x( 'Ban affiliate', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'tip'   => _x( 'Ban affiliate', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'url'   => YITH_WCAF_Admin_Actions::get_action_url(
								'change_status',
								array(
									'affiliate_id' => $item_id,
									'status'       => 'banned',
								)
							),
						),
					) : array(),
					$is_banned ? array(
						'unban' => array(
							'label' => _x( 'Unban affiliate', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'tip'   => _x( 'Unban affiliate', '[ADMIN] Single affiliate actions', 'yith-woocommerce-affiliates' ),
							'url'   => YITH_WCAF_Admin_Actions::get_action_url(
								'change_status',
								array(
									'affiliate_id' => $item_id,
									'status'       => 'unbanned',
								)
							),
						),
					) : array()
				);
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_admin_actions
			 *
			 * Filters the available actions for each affiliate in the affiliates table.
			 *
			 * @param array               $actions     Actions.
			 * @param int                 $id          Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate   Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_affiliate_admin_actions', parent::get_admin_actions(), $this->get_id(), $this );
		}

		/**
		 * Get admin edit url for current object
		 *
		 * @return string|bool Admin edit url; false on failure
		 */
		public function get_admin_edit_url() {
			if ( ! is_admin() ) {
				return false;
			}

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				return false;
			}

			return YITH_WCAF_Admin()->get_tab_url( 'affiliates', '', array( 'affiliate_id' => $this->get_id() ) );
		}

		/**
		 * Checks if we should notify customer about  specific event
		 *
		 * @param string $notification Event to maybe notify.
		 * @return bool Whether affiliate should be notified or not.
		 */
		public function should_notify( $notification ) {
			$meta  = "notify_$notification";
			$value = $this->get_meta( $meta );

			/**
			 * APPLY_FILTERS: yith_wcaf_default_notify_user_$NOTIFICATION
			 *
			 * Filters default value for notification preference
			 * <code>$NOTIFICATION</code> will be replaced with specific notification name.
			 *
			 * @param string $default  Yes or no, depending on default value we want to assign to current notification.
			 * @param int    $user_id  User id.
			 */
			$value = $value ? $value : apply_filters( "yith_wcaf_default_notify_user_$notification", 'no', $this->get_user_id() );

			/**
			 * APPLY_FILTERS: yith_wcaf_notify_user_$NOTIFICATION
			 *
			 * Notification preference for current affiliate
			 * <code>$NOTIFICATION</code> will be replaced with specific notification name.
			 *
			 * @param string              $notification Yes or no, depending on actual notification value for current affiliate notification.
			 * @param int                 $id           Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate    Affiliate object.
			 */
			return apply_filters( "yith_wcaf_notify_user_$notification", yith_plugin_fw_is_true( $value ), $this->get_id(), $this );
		}

		/**
		 * Returns an array representation of this object
		 * It is a slightly extended form of $this->get_data()
		 *
		 * @return array Formatted array representing current affiliate.
		 */
		public function to_array() {
			$data = $this->data;
			$user = $this->get_user();

			$return = array_merge(
				array(
					'ID'    => $this->get_id(),
					'token' => $this->get_token(),
				),
				$data,
				array(
					'total'             => $this->get_total(),
					'balance'           => $this->get_balance(),
					'conversion_rate'   => $this->get_conversion_rate(),
					'user_login'        => $user->user_login,
					'user_email'        => $user->user_email,
					'user_display_name' => $user->display_name,
					'user_nicename'     => $user->user_nicename,
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_to_array
			 *
			 * Filters data returned when converting an affiliate object to an array.
			 *
			 * @param array               $array     Affiliate in array format.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_affiliate_to_array', $return, $this->get_id(), $this );
		}

		/* === COMMISSIONS === */

		/**
		 * Returns a list of affiliate's commissions, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return YITH_WCAF_Commissions_Collection|bool List of commission, if any; false on failure.
		 */
		public function get_commissions( $args = array() ) {
			$commissions = YITH_WCAF_Commissions()->get_commissions(
				array_merge(
					$args,
					array(
						'affiliate_id' => $this->get_id(),
					)
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_commissions
			 *
			 * Filters commissions found for current affiliate, for filters passed.
			 *
			 * @param YITH_WCAF_Commissions_Collection $commissions  Commissions collection (may be empty).
			 * @param int                              $id           Affiliate id.
			 * @param YITH_WCAF_Affiliate              $affiliate    Affiliate object.
			 * @param array                            $args         Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_affiliate_commissions', $commissions, $this->get_id(), $this, $args );
		}

		/**
		 * Counts affiliate's commissions, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return int|bool Count of commission, if any; false on failure.
		 */
		public function count_commissions( $args = array() ) {
			$count = YITH_WCAF_Commissions()->count_commissions(
				array_merge(
					$args,
					array(
						'affiliate_id' => $this->get_id(),
					)
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_commissions_count
			 *
			 * Filters count of commissions found for current affiliate, for current filters.
			 *
			 * @param int                 $count     Count of commissions found.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param array               $args      Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_affiliate_commissions_count', $count, $this->get_id(), $this, $args );
		}

		/**
		 * Checks whether affiliate has unpaid commissions
		 *
		 * @return bool Whether affiliate has unpaid commissions.
		 */
		public function has_unpaid_commissions() {
			$unpaid_commissions = $this->get_commissions(
				array(
					'status' => 'pending',
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_has_unpaid_commissions
			 *
			 * Filters whether affiliates has unpaid commissions (and then can request payment).
			 *
			 * @param bool                             $has_unpaid Whether affiliate has unpaid commissions.
			 * @param int                              $id         Affiliate id.
			 * @param YITH_WCAF_Affiliate              $affiliate  Affiliate object.
			 * @param YITH_WCAF_Commissions_Collection $unpaid     Collection of unpaid commissions found.
			 */
			return apply_filters( 'yith_wcaf_affiliate_has_unpaid_commissions', $unpaid_commissions && ! $unpaid_commissions->is_empty(), $this->get_id(), $this, $unpaid_commissions );
		}

		/* === PAYMENTS === */

		/**
		 * Returns a list of affiliate's payment, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return YITH_WCAF_Payments_Collection|bool List of payments, if any; false on failure.
		 */
		public function get_payments( $args = array() ) {
			$payments = YITH_WCAF_Payments()->get_payments(
				array_merge(
					array(
						'affiliate_id' => $this->get_id(),
					),
					$args
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_payments
			 *
			 * Filters commissions found for current affiliate, for filters passed.
			 *
			 * @param YITH_WCAF_Payments_Collection $payments  Payments collection (may be empty).
			 * @param int                           $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate           $affiliate Affiliate object.
			 * @param array                         $args      Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_affiliate_payments', $payments, $this->get_id(), $this, $args );
		}

		/**
		 * Counts affiliate's payment, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return int|bool Count of payments, if any; false on failure.
		 */
		public function count_payments( $args = array() ) {
			$count = YITH_WCAF_Payments()->count_payments(
				array_merge(
					array(
						'affiliate_id' => $this->get_id(),
					),
					$args
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_payments_count
			 *
			 * Filters count of payments found for current affiliate, for current filters.
			 *
			 * @param int                 $count     Count of payments found.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param array               $args      Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_affiliate_payments_count', $count, $this->get_id(), $this, $args );
		}

		/**
		 * Checkes whether current affiliate has active payments
		 *
		 * @return bool Whether current affiliate has active payments.
		 */
		public function has_active_payments() {
			$active_payments = $this->get_payments(
				array(
					'status' => array(
						'on-hold',
						'pending',
					),
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_has_active_payments
			 *
			 * Filters whether affiliates has active payments (and then cannot request further payment).
			 *
			 * @param bool                          $has_active Whether affiliate has active payments.
			 * @param int                           $id         Affiliate id.
			 * @param YITH_WCAF_Affiliate           $affiliate  Affiliate object.
			 * @param YITH_WCAF_Payments_Collection $active     Collection of active payments found.
			 */
			return apply_filters( 'yith_wcaf_affiliate_has_active_payments', $active_payments && ! $active_payments->is_empty(), $this->get_id(), $this, $active_payments );
		}

		/**
		 * Checks if user can withdraw from his/her earnings
		 *
		 * @return bool Whether affiliate can withdraw or not.
		 */
		public function can_withdraw() {
			/**
			 * APPLY_FILTERS: yith_wcaf_can_affiliate_withdraw
			 *
			 * Filters whether affiliates can withdraw (has unpaid commissions and no active payment).
			 *
			 * @param bool                             $can_withdraw Whether affiliate can withdraw.
			 * @param int                              $id          Affiliate id.
			 * @param YITH_WCAF_Affiliate              $affiliate   Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_can_affiliate_withdraw', $this->is_valid() && ! $this->has_active_payments() && $this->has_unpaid_commissions(), $this->get_id(), $this );
		}

		/* === CLICKS === */

		/**
		 * Returns a list of affiliate's hits, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return YITH_WCAF_Clicks_Collection|bool List of hits, if any; false on failure.
		 */
		public function get_clicks( $args = array() ) {
			$clicks = YITH_WCAF_clicks()->get_hits(
				array_merge(
					array(
						'affiliate_id' => $this->get_id(),
					),
					$args
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_clicks
			 *
			 * Filters clicks found for current affiliate, for filters passed.
			 *
			 * @param YITH_WCAF_Clicks_Collection $clicks    Clicks collection (may be empty).
			 * @param int                         $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate         $affiliate Affiliate object.
			 * @param array                       $args      Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_affiliate_clicks', $clicks, $this->get_id(), $this, $args );
		}

		/**
		 * Counts affiliate's hits, eventually matching filtering criteria
		 *
		 * @param array $args        Optional array of filtering criteria.
		 * @param bool  $recalculate Whether system should re-count items instead of using registered value.
		 *
		 * @return int|bool Count of hits, if any; false on failure.
		 */
		public function count_clicks( $args = array(), $recalculate = false ) {
			if ( ! $args && ! $recalculate ) {
				return $this->get_clicks_count();
			}

			$count = YITH_WCAF_clicks()->count_hits(
				array_merge(
					array(
						'affiliate_id' => $this->get_id(),
					),
					$args
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_clicks_count
			 *
			 * Filters count of clicks found for current affiliate, for current filters.
			 *
			 * @param int                 $count     Count of clicks found.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param array               $args      Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_affiliate_clicks_count', $count, $this->get_id(), $this, $args );
		}

		/* === COUPONS === */

		/**
		 * Returns a list of affiliate's coupons, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return YITH_WCAF_Coupons_Collection|bool List of hits, if any; false on failure.
		 */
		public function get_coupons( $args = array() ) {
			$coupon_ids = YITH_WCAF_Coupons()->get_affiliate_coupons( $this->get_id(), $args );

			return new YITH_WCAF_Coupons_Collection( $coupon_ids );
		}

		/**
		 * Counts affiliate's coupons
		 *
		 * @return int|bool Count of hits, if any; false on failure.
		 */
		public function count_coupons() {
			$count = YITH_WCAF_Coupons()->count_affiliate_coupons( $this->get_id() );

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_coupons_count
			 *
			 * Filters count of coupons found for current affiliate.
			 *
			 * @param int                 $count     Count of coupons found.
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			return apply_filters( 'yith_wcaf_affiliate_coupons_count', $count, $this->get_id(), $this );
		}

		/* === SETTERS === */

		/**
		 * Set token for the affiliate
		 *
		 * @param string $token Token to set.
		 */
		public function set_token( $token ) {
			$new_token = sanitize_text_field( $token );
			$old_token = $this->get_token();

			$this->token = $new_token;

			// manually set token inside changes array (not a prop, but still needs to be updated on DB).
			if ( $this->object_read && $new_token !== $old_token ) {
				$this->changes['token'] = $this->token;
			}
		}

		/**
		 * Set user id for the affiliate
		 *
		 * @param int $user_id User id for current affiliate.
		 */
		public function set_user_id( $user_id ) {
			$user_id = (int) $user_id;

			// checks that we're referring an existing user.
			$user = get_userdata( $user_id );

			if ( ! $user ) {
				return;
			}

			$this->set_prop( 'user_id', $user_id );
			$this->user = $user;
		}

		/**
		 * Set rate for the affiliate
		 *
		 * @param float $rate Affiliate rate.
		 */
		public function set_rate( $rate ) {
			$rate = (float) $rate;

			/**
			 * APPLY_FILTERS: yith_wcaf_max_rate_value
			 *
			 * Filters the maximum rate value.
			 *
			 * @param int $max_rate_value Maximum rate value.
			 */
			if ( $rate < 0 || $rate > apply_filters( 'yith_wcaf_max_rate_value', 100 ) ) {
				return;
			}

			$this->set_prop( 'rate', $rate );
		}

		/**
		 * Set earnings for the affiliate
		 *
		 * @param float $earnings Affiliate earnings.
		 */
		public function set_earnings( $earnings ) {
			$earnings = (float) $earnings;

			if ( $earnings < 0 ) {
				$earnings = 0;
			}

			$this->set_prop( 'earnings', $earnings );
		}

		/**
		 * Update earnings for the affiliate
		 *
		 * @param float $difference Amount to add (or subtract, depending on the sign) to affiliate earnings.
		 */
		public function update_earnings( $difference ) {
			$difference = (float) $difference;

			$this->set_prop( 'earnings', $this->get_earnings( 'edit' ) + $difference );
		}

		/**
		 * Wrapper for \YITH_WCAF_Affiliate::update_earnings
		 *
		 * @param float $amount Amount to add (or subtract, depending on the sign) to affiliate earnings.
		 */
		public function update_total( $amount ) {
			$this->update_earnings( $amount );
		}

		/**
		 * Set refunds for the affiliate
		 *
		 * @param float $refunds Affiliate refunds.
		 */
		public function set_refunds( $refunds ) {
			$refunds = (float) $refunds;

			if ( $refunds < 0 ) {
				$refunds = 0;
			}

			// check if total refunds exceed for some reason earning amount.
			$earnings = $this->get_earnings();
			$refunds  = min( $earnings, $refunds );

			$this->set_prop( 'refunds', $refunds );
		}

		/**
		 * Update refunds for the affiliate
		 *
		 * @param float $difference Amount to add (or subtract, depending on the sign) to affiliate refunds.
		 */
		public function update_refunds( $difference ) {
			$difference = (float) $difference;
			$refunds    = $this->get_refunds( 'edit' ) + $difference;

			if ( $refunds < 0 ) {
				$refunds = 0;
			}

			// check if total refunds exceed for some reason earning amount.
			$earnings = $this->get_earnings();
			$refunds  = min( $earnings, $refunds );

			$this->set_prop( 'refunds', $refunds );
		}

		/**
		 * Set paid amount for the affiliate
		 *
		 * @param float $paid Affiliate paid.
		 */
		public function set_paid( $paid ) {
			$paid = (float) $paid;

			if ( $paid < 0 ) {
				$paid = 0;
			}

			// check if total paid exceed for some reason earning amount.
			$earnings = $this->get_earnings();
			$paid     = min( $earnings, $paid );

			$this->set_prop( 'paid', $paid );
		}

		/**
		 * Update paid amount for the affiliate
		 *
		 * @param float $difference Amount to add (or subtract, depending on the sign) to affiliate paid amount.
		 */
		public function update_paid( $difference ) {
			$difference = (float) $difference;
			$paid       = $this->get_paid( 'edit' ) + $difference;

			if ( $paid < 0 ) {
				$paid = 0;
			}

			// check if total paid exceed for some reason earning amount.
			$earnings = $this->get_earnings();
			$paid     = min( $earnings, $paid );

			$this->set_prop( 'paid', $paid );
		}

		/**
		 * Set clicks for the affiliate
		 *
		 * @param int $clicks Affiliate clicks.
		 */
		public function set_clicks_count( $clicks ) {
			$clicks = (int) $clicks;

			if ( $clicks < 0 ) {
				return;
			}

			$this->set_prop( 'clicks_count', $clicks );
		}

		/**
		 * Same as set_click
		 *
		 * @param int $clicks Affiliate clicks.
		 */
		public function set_click( $clicks ) {
			$this->set_clicks_count( $clicks );
		}

		/**
		 * Increase registered clicks by 1
		 */
		public function increase_clicks() {
			$clicks = $this->get_clicks_count();

			$this->set_prop( 'clicks_count', ++ $clicks );
		}

		/**
		 * Decrease registered clicks by 1
		 */
		public function decrease_clicks() {
			$clicks = $this->get_clicks_count();
			$clicks = max( 0, -- $clicks );

			$this->set_prop( 'clicks_count', $clicks );
		}

		/**
		 * Set conversions for the affiliate
		 *
		 * @param int $conversions Affiliate conversions.
		 */
		public function set_conversions( $conversions ) {
			$conversions = (int) $conversions;

			if ( $conversions < 0 ) {
				return;
			}

			$this->set_prop( 'conversions', $conversions );
		}

		/**
		 * Same as set_conversion
		 *
		 * @param int $conversions Affiliate conversions.
		 */
		public function set_conversion( $conversions ) {
			$this->set_conversions( $conversions );
		}

		/**
		 * Increase registered conversions by 1
		 */
		public function increase_conversions() {
			$conversions = $this->get_conversions();

			$this->set_prop( 'conversions', ++ $conversions );
		}

		/**
		 * Decrease registered conversions by 1
		 */
		public function decrease_conversions() {
			$conversions = $this->get_conversions();
			$conversions = max( 0, -- $conversions );

			$this->set_prop( 'conversions', $conversions );
		}

		/**
		 * Set affiliate status
		 *
		 * @param string|int $status Status for the affiliate, in numeric or textual form.
		 */
		public function set_status( $status ) {
			$old_status         = $this->get_raw_status();
			$new_status         = false;
			$available_statuses = YITH_WCAF_Affiliates::get_available_statuses();
			$statuses           = wp_list_pluck( $available_statuses, 'slug' );

			if ( is_numeric( $status ) && ! array_key_exists( $status, $statuses ) || ! is_numeric( $status ) && ! in_array( $status, $statuses, true ) ) {
				return;
			}

			if ( is_numeric( $status ) ) {
				$new_status = (int) $status;
			} elseif ( is_string( $status ) ) {
				$new_status = array_flip( $statuses )[ $status ];
			}

			if ( false === $new_status ) {
				return;
			}

			// triggers action when we're changing status for an already read object.
			if ( $this->object_read && $new_status !== $old_status ) {
				$status = 0 < $new_status ? 'enabled' : 'disabled';

				/**
				 * DO_ACTION: yith_wcaf_affiliate_$status
				 *
				 * Allows to trigger some action when the affiliate's status changes.
				 * <code>$status</code> will be replaced with the affiliate's status.
				 *
				 * @param int                 $id        Affiliate id.
				 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
				 */
				do_action( "yith_wcaf_affiliate_{$status}", $this->get_id(), $this );
			}

			$this->set_prop( 'status', $new_status );
		}

		/**
		 * Same as set_status with numeric values
		 *
		 * @param int $status Status for the affiliate.
		 */
		public function set_enabled( $status ) {
			$this->set_status( (int) $status );
		}

		/**
		 * Set affiliate banned status
		 *
		 * @param bool $banned Whether affiliate is banned or not.
		 */
		public function set_banned( $banned ) {
			$banned = ! ! $banned;

			$this->set_prop( 'banned', $banned );
		}

		/**
		 * Set affiliate as banned
		 */
		public function ban() {
			$this->set_banned( true );
		}

		/**
		 * Set affiliate as unbanned
		 */
		public function unban() {
			$this->set_banned( false );
		}

		/**
		 * Set payment email for the affiliate
		 * Note that this is an outdated field, and it is preserved just for backward compatibility
		 *
		 * @param string $payment_email Email to set.
		 */
		public function set_payment_email( $payment_email ) {
			if ( ! is_email( $payment_email ) ) {
				return;
			}

			$this->set_prop( 'payment_email', $payment_email );
		}

		/**
		 * Updates preferences for a specific gateway
		 * Returns if gateway is not available or a validation error occurs.
		 *
		 * @param string $gateway_id Gateway id.
		 * @param array  $options    Values to save.
		 */
		public function set_gateway_preferences( $gateway_id, $options ) {
			$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );

			if ( ! $gateway ) {
				return;
			}

			try {
				$validated_options = $gateway->validate_fields( $options );
			} catch ( Exception $e ) {
				return;
			}

			$meta_name = "{$gateway_id}_gateway_preferences";

			$this->update_meta_data( $meta_name, $validated_options );

			// register this change in $this->changes, even if not  prop.
			if ( ! isset( $this->changes['gateway_preferences'] ) ) {
				$this->changes['gateway_preferences'] = array();
			}

			$this->changes['gateway_preferences'][ $gateway_id ] = $options;
		}

		/**
		 * Returns affiliate invoice profile as saved in affiliate's meta
		 *
		 * @param array $options Invoice profile to validate and save.
		 */
		public function set_invoice_profile( $options ) {
			try {
				$validated_options = YITH_WCAF_Affiliates_Invoice_Profile::validate_billing_fields( $options, 'billing_profile' );
			} catch ( Exception $e ) {
				return;
			}

			foreach ( $validated_options as $field_id => $value ) {
				$meta = "invoice_$field_id";

				$this->update_meta_data( $meta, $value );
			}
		}

		/**
		 * Sets notification preferences for the affiliate.
		 *
		 * @param string $notification Event to maybe notify.
		 * @param bool   $notify       Whether to notify the event or not.
		 */
		public function set_notify( $notification, $notify = true ) {
			$meta = "notify_$notification";

			$this->update_meta_data( $meta, yith_plugin_fw_is_true( $notify ) );
		}

		/* === OVERRIDES === */

		/**
		 * Save should create or update based on object existence.
		 *
		 * @return int
		 */
		public function save() {
			$changes      = $this->get_changes();
			$old_data     = $this->get_data();
			$affiliate_id = $this->get_id();

			$new_id = parent::save();

			// execute status change actions.
			if ( isset( $changes['status'] ) ) {
				// retrieve new status slug.
				$new_status = $this->get_status();

				// retrieve old status slug.
				$available_statuses = YITH_WCAF_Affiliates::get_available_statuses();

				$old_status = $old_data['status'];
				$old_status = isset( $available_statuses[ $old_status ] ) ? $available_statuses[ $old_status ]['slug'] : '';

				/**
				 * DO_ACTION: yith_wcaf_affiliate_status_$new_status
				 *
				 * Allows to trigger some action when the affiliate status changes into a new status.
				 * <code>$new_status</code> will be replaced with the new status for the affiliate.
				 *
				 * @param int $affiliate_id Affiliate id.
				 */
				do_action( "yith_wcaf_affiliate_status_{$new_status}", $affiliate_id );

				/**
				 * DO_ACTION: yith_wcaf_affiliate_status_$old_status_to_$new_status
				 *
				 * Allows to trigger some action when the affiliate status changes from the old status into the new status.
				 * <code>$old_status</code> will be replaced with the old affiliate status.
				 * <code>$new_status</code> will be replaced with the new affiliate status.
				 *
				 * @param int $affiliate_id Affiliate id.
				 */
				do_action( "yith_wcaf_affiliate_status_{$old_status}_to_{$new_status}", $affiliate_id );

				/**
				 * DO_ACTION: yith_wcaf_affiliate_status_changed
				 *
				 * Allows to trigger some action when the affiliate status has changed.
				 *
				 * @param int    $affiliate_id Affiliate id.
				 * @param string $new_status   New status.
				 * @param string $old_status   Old status.
				 */
				do_action( 'yith_wcaf_affiliate_status_changed', $affiliate_id, $new_status, $old_status );
			}

			// execute payment email change action (legacy).
			if ( isset( $changes['payment_email'] ) ) {
				/**
				 * DO_ACTION: yith_wcaf_affiliate_payment_email_changed
				 *
				 * Allows to trigger some action when the affiliate's payment email has changed.
				 *
				 * @param int    $affiliate_id      Affiliate id.
				 * @param string $payment_email     Affiliate's payment email.
				 * @param string $old_payment_email Affiliate's old payment email.
				 */
				do_action( 'yith_wcaf_affiliate_payment_email_changed', $affiliate_id, $this->get_payment_email(), $old_data['payment_email'] );
			}

			// execute ban/unban actions.
			if ( isset( $changes['banned'] ) ) {
				$ban_status = $changes['banned'] ? 'banned' : 'unbanned';

				/**
				 * DO_ACTION: yith_wcaf_affiliate_$ban_status
				 *
				 * Allows to trigger some action when performing the actions to ban/unban the affiliate.
				 * <code>$ban_status</code> will be replaced with the ban status for the affiliate.
				 *
				 * @param int                 $id        Affiliate id.
				 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
				 */
				do_action( "yith_wcaf_affiliate_{$ban_status}", $this->get_id(), $this );
			}

			// executes required adjustments to commissions object after changes.
			if ( array_intersect( array_keys( $changes ), array( 'payment_email', 'gateway_preferences' ) ) ) {
				$this->sync_payments( $old_data, $changes );
			}

			return $new_id;
		}

		/* === EXTERNAL OBJECTS HANDLING === */

		/**
		 * Sync payment object when an affiliate is changed (register new payment details)
		 *
		 * @param array $old_data Old data for the affiliate.
		 * @param array $new_data New data for the affiliate.
		 */
		public function sync_payments( $old_data, $new_data ) {
			$payments = $this->get_payments(
				array(
					'status' => 'on-hold',
				)
			);

			if ( empty( $payments ) ) {
				return;
			}

			foreach ( $payments as $payment ) {
				$payment->set_email( $this->get_payment_email() );

				if ( isset( $new_data['gateway_preferences'] ) && array_key_exists( $payment->get_gateway_id(), $new_data['gateway_preferences'] ) ) {
					$payment->set_gateway_details( $new_data['gateway_preferences'][ $payment->get_gateway_id() ] );
				}

				$payment->save();
			}
		}
	}
}
