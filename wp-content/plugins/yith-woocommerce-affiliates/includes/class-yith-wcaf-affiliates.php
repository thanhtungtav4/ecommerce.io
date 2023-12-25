<?php
/**
 * Affiliate Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates' ) ) {
	/**
	 * General affiliates handling
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliates extends YITH_WCAF_Affiliates_Legacy {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Available affiliate statuses
		 *
		 * @var array
		 */
		protected static $available_statuses;

		/**
		 * Role name for affiliates
		 *
		 * @var string
		 */
		protected static $role_name = 'yith_affiliate';

		/* === AFFILIATE STATUES === */

		/**
		 * Returns available statuses for affiliates
		 *
		 * @return array
		 */
		public static function get_available_statuses() {
			if ( empty( self::$available_statuses ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_affiliates_statuses
				 *
				 * Filters the available statuses for the affiliates.
				 *
				 * @param array $available_statuses Available statuses.
				 */
				self::$available_statuses = apply_filters(
					'yith_wcaf_affiliates_statuses',
					array(
						- 1 => array(
							'slug' => 'disabled',
							'name' => _x( 'Rejected', '[ADMIN] Affiliate status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Rejected', 'Rejected', '[ADMIN] Affiliate status', 'yith-woocommerce-affiliates' ),
						),
						0   => array(
							'slug' => 'new',
							'name' => _x( 'New request', '[ADMIN] Affiliate status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'New', 'New', '[ADMIN] Affiliate status', 'yith-woocommerce-affiliates' ),
						),
						1   => array(
							'slug' => 'enabled',
							'name' => _x( 'Accepted and enabled', '[ADMIN] Affiliate status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Accepted', 'Accepted', '[ADMIN] Affiliate status', 'yith-woocommerce-affiliates' ),
						),
					)
				);
			}

			return self::$available_statuses;
		}

		/**
		 * Return a human friendly version of a affiliate status
		 *
		 * @param int|string $status Status to convert to human friendly form.
		 * @param int        $count  Count of items (used to conditionally show plural form).
		 *
		 * @return string Human friendly status
		 * @since 1.3.0
		 */
		public static function get_readable_status( $status, $count = false ) {
			$statuses = self::get_available_statuses();

			// if status is not among supported IDs, assume a slug was passed.
			if ( ! isset( $statuses[ $status ] ) ) {
				$statuses = array_combine( wp_list_pluck( $statuses, 'slug' ), $statuses );
			}

			// retrieve correct label, singular or plural, depending on number of items.
			if ( false !== $count ) {
				$label = translate_nooped_plural( $statuses[ $status ]['noop'], $count, 'yith-woocommerce-affiliates' );
			} else {
				$label = isset( $statuses[ $status ] ) ? $statuses[ $status ]['name'] : '';
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_status_name
			 *
			 * Filters the name of the affiliate's status.
			 *
			 * @param string $label  Status name.
			 * @param string $status Status.
			 */
			return apply_filters( 'yith_wcaf_affiliate_status_name', $label, $status );
		}

		/* === HELPER METHODS === */

		/**
		 * Returns role name
		 *
		 * @return string Role name
		 * @since 1.2.0
		 */
		public static function get_role() {
			return self::$role_name;
		}

		/**
		 * Return number of affiliates matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Affiliate_Data_Store::query).
		 *
		 * @return int Number of counted affiliates
		 * @use \YITH_WCAF_Affiliate_Data_Store::::count
		 */
		public function count_affiliates( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'affiliate' );

				$count = $data_store->count( $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/**
		 * Wrapper for YITH_WCAF_Affiliate_Factory::get_affiliates
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Affiliate_Data_Store::query).
		 *
		 * @return YITH_WCAF_Affiliates_Collection|string[]|bool Matching affiliates.
		 * @since 1.0.0
		 */
		public function get_affiliates( $args = array() ) {
			return YITH_WCAF_Affiliate_Factory::get_affiliates( $args );
		}

		/**
		 * Returns count of affiliate, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic; if left empty, returns array of counts per status.
		 * @param array  $args   Array of arguments to filter status query (@see \YITH_WCAF_Affiliate_Data_Store::per_status_count).
		 *
		 * @return int|array Count per state, or array indexed by status, with status count
		 * @use \YITH_WCAF_Affiliate_Data_Store::::per_status_count
		 */
		public function per_status_count( $status = false, $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'affiliate' );

				$count = $data_store->per_status_count( $status, $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/**
		 * Return affiliate matching passed token
		 *
		 * @param string      $token          Affiliate token to find.
		 * @param string|bool $enabled        Whether to find all affiliate whatever the state (all), or only enabled (true) or disabled (false) ones.
		 * @param bool        $exclude_banned Whether to exclude from current selection banned affiliates (default to false).
		 *
		 * @return YITH_WCAF_Affiliate|bool Affiliate found or false.
		 * @since 1.0.0
		 */
		public function get_affiliate_by_token( $token, $enabled = 'all', $exclude_banned = false ) {
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_token( $token );

			if ( ! $affiliate ) {
				return false;
			}

			if ( 'all' !== $enabled && ! $affiliate->has_status( $enabled ? 'enabled' : 'disabled' ) ) {
				return false;
			}

			if ( $exclude_banned && $affiliate->is_banned() ) {
				return false;
			}

			return $affiliate;
		}

		/**
		 * Return affiliate matching passed id
		 *
		 * @param int         $affiliate_id   Affiliate id.
		 * @param string|bool $enabled        Whether to find all affiliate whatever the state (all), or only enabled (true) or disabled (false) ones.
		 * @param bool        $exclude_banned Whether to exclude from current selection banned affiliates (default to false).
		 *
		 * @return YITH_WCAF_Affiliate|bool Affiliate found or false.
		 * @since 1.0.0
		 */
		public function get_affiliate_by_id( $affiliate_id, $enabled = 'all', $exclude_banned = false ) {
			return $this->get_affiliate_by_token( (int) $affiliate_id, $enabled, $exclude_banned );
		}

		/**
		 * Return affiliate matching passed user id
		 *
		 * @param int         $user_id        User id.
		 * @param string|bool $enabled        Whether to find all affiliate whatever the state (all), or only enabled (true) or disabled (false) ones.
		 * @param bool        $exclude_banned Whether to exclude from current selection banned affiliates (default to false).
		 *
		 * @return YITH_WCAF_Affiliate|bool Affiliate found or false.
		 * @since 1.0.0
		 */
		public function get_affiliate_by_user_id( $user_id, $enabled = 'all', $exclude_banned = false ) {
			try {
				$token = WC_Data_Store::load( 'affiliate' )->get_token_by_user_id( $user_id );
			} catch ( Exception $e ) {
				return false;
			}

			if ( ! $token ) {
				return false;
			}

			return $this->get_affiliate_by_token( $token, $enabled, $exclude_banned );
		}

		/**
		 * Return user object for the given token
		 *
		 * @param string $token Token to use to retrieve user.
		 *
		 * @return \WP_User|bool User object, or false if token doesn't match any user
		 * @since 1.0.0
		 */
		public function get_user_by_token( $token ) {
			if ( empty( $token ) ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_token( $token, true );

			if ( ! $affiliate ) {
				return false;
			}

			return $affiliate->get_user();
		}

		/**
		 * Check if given string is a valid affiliate token
		 *
		 * @param string $token Token to check.
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public function is_valid_token( $token ) {
			$user = $this->get_user_by_token( $token );

			if ( ! $user ) {
				return false;
			}

			if ( ! $this->is_user_valid_affiliate( $user->ID ) ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_is_valid_token
			 *
			 * Filters whether the token is valid.
			 *
			 * @param bool   $is_valid_token Whether the token is valid or not.
			 * @param string $token          Token.
			 */
			return apply_filters( 'yith_wcaf_is_valid_token', true, $token );
		}

		/**
		 * Returns true if user is an affiliate
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return bool Whether user is an affiliate or not
		 * @since 1.0.0
		 */
		public function is_user_affiliate( $user_id = false ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			/**
			 * APPLY_FILTERS: yith_wcaf_is_user_affiliate
			 *
			 * Filters whether the user is an affiliate.
			 *
			 * @param bool $is_affiliate Whether the user is an affiliate or not.
			 * @param int  $user_id      User id.
			 */
			return apply_filters( 'yith_wcaf_is_user_affiliate', ! ! $affiliate, $user_id );
		}

		/**
		 * Returns true if user is an enabled affiliate (enabled = 1)
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return bool Whether user is an enabled affiliate or not
		 * @since 1.0.0
		 */
		public function is_user_enabled_affiliate( $user_id = false ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			/**
			 * APPLY_FILTERS: yith_wcaf_is_user_enabled_affiliate
			 *
			 * Filters whether the user is an enabled affiliate.
			 *
			 * @param bool $is_enabled_affiliate Whether the user is an enabled affiliate or not.
			 * @param int  $user_id              User id.
			 */
			return apply_filters( 'yith_wcaf_is_user_enabled_affiliate', ! ! $affiliate && $affiliate->has_status( 'enabled' ), $user_id );
		}

		/**
		 * Returns true if user is a pending affiliate (enabled = 0)
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return bool Whether user is an enabled affiliate or not
		 * @since 1.0.0
		 */
		public function is_user_pending_affiliate( $user_id = false ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			/**
			 * APPLY_FILTERS: yith_wcaf_is_user_pending_affiliate
			 *
			 * Filters whether the user is a pending affiliate.
			 *
			 * @param bool $is_pending_affiliate Whether the user is a pending affiliate or not.
			 * @param int  $user_id              User id.
			 */
			return apply_filters( 'yith_wcaf_is_user_pending_affiliate', ! ! $affiliate && $affiliate->has_status( 'new' ), $user_id );
		}

		/**
		 * Returns true if user is a rejected affiliate (enabled = -1)
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return bool Whether user is an enabled affiliate or not
		 * @since 1.0.0
		 */
		public function is_user_rejected_affiliate( $user_id = false ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			/**
			 * APPLY_FILTERS: yith_wcaf_is_user_rejected_affiliate
			 *
			 * Filters whether the user is a rejected affiliate.
			 *
			 * @param bool $is_rejected_affiliate Whether the user is a rejected affiliate or not.
			 * @param int  $user_id               User id.
			 */
			return apply_filters( 'yith_wcaf_is_user_rejected_affiliate', ! ! $affiliate && $affiliate->has_status( 'disabled' ), $user_id );
		}

		/**
		 * Checks whether current affiliate is valid (enabled and not banned)
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return bool Whether user is a valid affiliate or not
		 * @since 1.2.5
		 */
		public function is_user_valid_affiliate( $user_id = false ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			/**
			 * APPLY_FILTERS: yith_wcaf_is_user_valid_affiliate
			 *
			 * Filters whether the user is a valid affiliate (enabled and not banned).
			 *
			 * @param bool $is_valid_affiliate Whether the user is a valid affiliate or not.
			 * @param int  $user_id            User id.
			 */
			return apply_filters( 'yith_wcaf_is_user_valid_affiliate', ! ! $affiliate && $affiliate->is_valid(), $user_id );
		}

		/**
		 * Checks whether current affiliate is banned
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return bool Whether user is a banned affiliate or not
		 * @since 1.2.5
		 */
		public function is_user_banned_affiliate( $user_id = false ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return false;
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			/**
			 * APPLY_FILTERS: yith_wcaf_is_user_banned_affiliate
			 *
			 * Filters whether the user is a banned affiliate.
			 *
			 * @param bool $is_banned_affiliate Whether the user is a banned affiliate or not.
			 * @param int  $user_id             User id.
			 */
			return apply_filters( 'yith_wcaf_is_user_banned_affiliate', ! ! $affiliate && $affiliate->is_banned(), $user_id );
		}

		/**
		 * Returns user reject message, if user is a rejected affiliate
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return string Affiliate reject message
		 */
		public function get_user_reject_message( $user_id = false ) {

			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return '';
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			if ( ! $affiliate || ! $affiliate->has_status( 'disabled' ) ) {
				return '';
			}

			return $affiliate->get_message( 'reject' );
		}

		/**
		 * Returns user ban message, if user is a banned affiliate
		 *
		 * @param int|bool $user_id Id of the user to check; false if currently logged in user should be considered.
		 *
		 * @return string Affiliate ban message
		 */
		public function get_user_ban_message( $user_id = false ) {

			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! $user_id ) {
				return '';
			}

			$affiliate = $this->get_affiliate_by_user_id( $user_id );

			if ( ! $affiliate || ! $affiliate->is_banned() ) {
				return '';
			}

			return $affiliate->get_message( 'ban' );
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Affiliate_Handler class
 *
 * @return \YITH_WCAF_Affiliates
 * @since 1.0.0
 */
function YITH_WCAF_Affiliates() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Affiliates::get_instance();
}
