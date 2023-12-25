<?php
/**
 * Affiliate Handler class - LEGACY
 *
 * This class is deprecated, and you should use none of it methods
 * Please, check \YITH_WCAF_Affiliate instead.
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates_Legacy' ) ) {
	/**
	 * Legacy Affiliate Handler
	 *
	 * @deprecated
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliates_Legacy {

		/**
		 * Role name for affiliates
		 *
		 * @var string
		 * @since 1.2.0
		 */
		protected static $role_name = 'yith_affiliate';

		/* === AFFILIATE HANDLING METHODS === */

		/**
		 * Add an item to affiliate table
		 *
		 * @param array $affiliate_args Arguments for item creation:<br/>
		 * [<br/>
		 *     'token' => '',        // affiliate token<br/>
		 *     'user_id' => 0,       // affiliate related user id<br/>
		 *     'enabled' => 1,       // affiliate enabled (0/1/-1)<br/>
		 *     'rate' => 'NULL',     // affiliate rate (float; leave empty if there is no specific rate for this affiliate)<br/>
		 *     'earnings' => 0,      // affiliate earnings (float)<br/>
		 *     'refunds' => 0,       // affiliate refunds (float)<br/>
		 *     'paid' => 0,          // affiliate paid (float)<br/>
		 *     'click' => 0,         // affiliate clicks (int)<br/>
		 *     'conversion' => 0,    // affiliate conversions (int)<br/>
		 *     'banned' => 0,        // affiliates banned (bool)<br/>
		 *     'payment_email' => '' // affiliate payment email (string)<br/>
		 * ].
		 *
		 * @deprecated 2.0.0
		 *
		 * @return int Inserted row ID
		 * @since 1.0.0
		 */
		public function add( $affiliate_args ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate_Data_Store::create' );

			try {
				$affiliate = new YITH_WCAF_Affiliate( $affiliate_args );
				$affiliate->save();
			} catch ( Exception $e ) {
				return false;
			}

			return $affiliate->get_id();
		}

		/**
		 * Update an item of affiliate table
		 *
		 * @param int   $affiliate_id Affiliate ID.
		 * @param array $args         Array of affiliates param to update:<br/>
		 * [<br/>
		 *     'token' => '',        // affiliate token<br/>
		 *     'user_id' => 0,       // affiliate related user id<br/>
		 *     'enabled' => 1,       // affiliate enabled (0/1/-1)<br/>
		 *     'rate' => 'NULL',     // affiliate rate (float; leave empty if there is no specific rate for this affiliate)<br/>
		 *     'earnings' => 0,      // affiliate earnings (float)<br/>
		 *     'refunds' => 0,       // affiliate refunds (float)<br/>
		 *     'paid' => 0,          // affiliate paid (float)<br/>
		 *     'click' => 0,         // affiliate clicks (int)<br/>
		 *     'conversion' => 0,    // affiliate conversions (int)<br/>
		 *     'banned' => 0,        // affiliates banned (bool)<br/>
		 *     'payment_email' => '' // affiliate payment email (string)<br/>
		 * ].
		 *
		 * @deprecated 2.0.0
		 *
		 * @return int|bool False on failure; number of updated rows on success (usually 1)
		 * @since 1.0.0
		 */
		public function update( $affiliate_id, $args ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate_Data_Store::update' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			$affiliate->set_props( $args );

			return $affiliate->save();
		}

		/**
		 * Delete an item from affiliates table
		 *
		 * @param int $affiliate_id Affiliate id.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return bool Status of the operation
		 * @since 1.0.0
		 */
		public function delete( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate_Data_Store::delete' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			return $affiliate->delete();
		}

		/**
		 * Add role to enabled affiliates
		 *
		 * @param int $affiliate_id Affiliate ID.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return void
		 * @since 1.2.0
		 */
		public function add_role( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', 'none (role is assigned automatically when creating affiliate)' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );
			$user      = $affiliate->get_user();

			/**
			 * APPLY_FILTERS: yith_wcaf_add_affiliate_role
			 *
			 * Filters whether to add the Affiliate role.
			 *
			 * @param bool                $add_role  Whether to add the role or not.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			if ( ! $user || is_wp_error( $user ) || ! apply_filters( 'yith_wcaf_add_affiliate_role', true, $affiliate ) ) {
				return;
			}

			$user->add_role( self::$role_name );
		}

		/**
		 * Remove role from enabled affiliates
		 *
		 * @param int $affiliate_id Affiliate ID.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return void
		 * @since 1.2.0
		 */
		public function remove_role( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', 'none (role is removed automatically when deleting affiliate)' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );
			$user      = $affiliate->get_user();

			if ( ! $user || is_wp_error( $user ) ) {
				return;
			}

			$user->remove_role( self::$role_name );
		}

		/* === HELPER METHODS === */

		/**
		 * Return current ref variable name
		 *
		 * @deprecated 2.0.0
		 *
		 * @return string Ref variable name
		 * @since 1.0.0
		 */
		public function get_ref_name() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Session::get_ref_name' );

			return YITH_WCAF_Session()->get_ref_name();
		}

		/**
		 * Return affiliate rate for a specific affiliate id
		 *
		 * @param int $affiliate_id Affiliate ID.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return float Affiliate rate
		 * @since 1.0.0
		 */
		public function get_affiliate_rate( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_rate' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			return (float) $affiliate->get_rate();
		}

		/**
		 * Update affiliate rate for a specific affiliate id (set it null if no rate is passed)
		 *
		 * @param int   $affiliate_id Affiliate ID.
		 * @param float $rate         New affiliate rate.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return int Operation result
		 * @since 1.0.0
		 */
		public function update_affiliate_rate( $affiliate_id, $rate = false ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::set_rate' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			$affiliate->set_rate( $rate );

			return $affiliate->save();
		}

		/**
		 * Return affiliate earnings for a specific affiliate id
		 *
		 * @param int $affiliate_id Affiliate ID.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return float Affiliate earnings
		 * @since 1.0.0
		 */
		public function get_affiliate_total( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_earnings' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return 0;
			}

			return (float) $affiliate->get_earnings();
		}

		/**
		 * Update affiliate total for a specific affiliate id (sum amount passed to total)
		 *
		 * @param int   $affiliate_id Affiliate ID.
		 * @param float $amount       Amount to sum to old total.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return int Operation result
		 * @since 1.0.0
		 */
		public function update_affiliate_total( $affiliate_id, $amount ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::update_earnings' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			$affiliate->update_earnings( $amount );

			return $affiliate->save();
		}

		/**
		 * Return affiliate refunds for a specific affiliate id
		 *
		 * @param int $affiliate_id Affiliate ID.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return float Affiliate refunds
		 * @since 1.0.0
		 */
		public function get_affiliate_refunds( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_refunds' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return 0;
			}

			return (float) $affiliate->get_refunds();
		}

		/**
		 * Update affiliate refunds for a specific affiliate id (sum amount passed to total)
		 *
		 * @param int   $affiliate_id Affiliate ID.
		 * @param float $amount       Amount to sum to old total.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return int Operation result
		 * @since 1.0.0
		 */
		public function update_affiliate_refunds( $affiliate_id, $amount ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::update_refunds' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			$affiliate->update_refunds( $amount );

			return $affiliate->save();
		}

		/**
		 * Return affiliate total payments for a specific affiliate id
		 *
		 * @param int $affiliate_id Affiliate ID.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return float Amount paid to affiliate
		 * @since 1.0.0
		 */
		public function get_affiliate_payments( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_paid' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return 0;
			}

			return (float) $affiliate->get_paid();
		}

		/**
		 * Update affiliate total payments for a specific affiliate id (sum amount passed to total)
		 *
		 * @param int   $affiliate_id Affiliate ID.
		 * @param float $amount       Amount to sum to old total.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return int Operation result
		 * @since 1.0.0
		 */
		public function update_affiliate_payments( $affiliate_id, $amount ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::update_paid' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return false;
			}

			$affiliate->update_paid( $amount );

			return $affiliate->save();
		}

		/**
		 * Return affiliate balance for a specific affiliate id
		 *
		 * @param int    $affiliate_id Affiliate ID.
		 * @param string $type         Stored or Actual, depending on how to calculate balance.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return float Affiliate refunds
		 * @since 1.0.0
		 */
		public function get_affiliate_balance( $affiliate_id, $type = 'stored' ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_balance' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return 0;
			}

			return (float) $affiliate->get_balance( 'view', 'actual' === $type );
		}

		/**
		 * Return default token for a specific user id
		 *
		 * @param int $user_id User id.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return string User default token
		 * @since 1.0.0
		 */
		public function get_default_user_token( $user_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate_Data_Store::generate_token' );

			$default_token = $user_id;

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_token
			 *
			 * Filters the default affiliate token.
			 *
			 * @param string $default_token Default token.
			 * @param int    $user_id       Used id.
			 */
			return apply_filters( 'yith_wcaf_affiliate_token', $default_token, $user_id );
		}

		/**
		 * Check if user can see a specific section of the Affiliate Dashboard
		 *
		 * @param int|bool $user_id User id; false to use current user id.
		 * @param string   $section Section id.
		 * @param bool     $nopriv  Whether section should be visible by unauthenticated users or not.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return bool Whether user can see section or not
		 *
		 * @since 1.2.5
		 */
		public function can_user_see_section( $user_id = false, $section = 'summary', $nopriv = false ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Abstract_Dashboard::can_user_see_section' );

			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id && ! $nopriv ) {
				return false;
			}

			return YITH_WCAF_Dashboard()->can_user_see_section( $user_id, $section );
		}

		/**
		 * Returns true if affiliate has some unpaid commissions
		 *
		 * @param int $affiliate_id Affiliate id.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return bool Whether affiliate has unpaid commissions or not
		 * @since 1.0.10
		 */
		public function has_unpaid_commissions( $affiliate_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::has_unpaid_commissions' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			return $affiliate->has_unpaid_commissions();
		}

		/**
		 * Returns role name
		 *
		 * @deprecated 2.0.0
		 *
		 * @return string Role name
		 * @since 1.2.0
		 */
		public function get_role_name() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliates::get_role' );

			return self::$role_name;
		}

		/* === INVOICE PROFILE METHODS === */

		/**
		 * Retrieve invoice profile for the user
		 *
		 * @param int $user_id User id.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return mixed Array of stored information about affiliate invoice profile
		 */
		public function get_affiliate_invoice_profile( $user_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_invoice_profile' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user_id );

			if ( ! $affiliate ) {
				return false;
			}

			return $affiliate->get_invoice_profile();
		}

		/**
		 * Retrieve formatted invoice profile for the user
		 *
		 * @param int $user_id User id.
		 *
		 * @deprecated 2.0.0
		 *
		 * @return mixed Array of stored information about affiliate invoice profile
		 */
		public function get_formatted_affiliate_invoice_profile( $user_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliate::get_formatted_invoice_profile' );

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user_id );

			if ( ! $affiliate ) {
				return false;
			}

			return $affiliate->get_formatted_invoice_profile();
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Affiliates_Legacy
		 * @since 1.0.2
		 */
		public static function get_instance() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Affiliates' );

			return YITH_WCAF_Affiliates::get_instance();
		}
	}
}

/**
 * Create class alias, to allow for interaction with the legacy class, with its previous name.
 *
 * @since 2.0.0
 */
class_alias( 'YITH_WCAF_Affiliates_Legacy', 'YITH_WCAF_Affiliate_Handler' );
class_alias( 'YITH_WCAF_Affiliates_Legacy', 'YITH_WCAF_Affiliate_Handler_Premium' );

/**
 * Unique access to instance of YITH_WCAF_Affiliate_Handler class
 *
 * @deprecated 2.0.0
 *
 * @return \YITH_WCAF_Affiliates_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Affiliate_Handler() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Affiliates' );

	return YITH_WCAF_Affiliates::get_instance();
}

/**
 * Unique access to instance of YITH_WCAF_Affiliate_Handler class
 *
 * @deprecated 2.0.0
 *
 * @return \YITH_WCAF_Affiliates_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Affiliate_Handler_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Affiliate_Handler();
}
