<?php
/**
 * Click Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Clicks' ) ) {
	/**
	 * Click Handler
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Clicks extends YITH_WCAF_Clicks_Legacy {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Available click statuses
		 *
		 * @var array
		 */
		protected static $available_statuses;

		/**
		 * Minimum number of seconds to pass before count two different click
		 *
		 * @var int
		 * @since 1.0.0
		 */
		protected $hit_resolution = 60;

		/**
		 * Whether or not to enable click registering
		 *
		 * @var bool
		 * @since 1.5.2
		 */
		protected $enabled = true;

		/**
		 * Constructor method
		 */
		public function __construct() {
			// retrieve options for internal usage.
			$this->retrieve_options();

			// register new clicks.
			if ( $this->are_hits_registered() ) {
				add_action( 'wp', array( $this, 'register_hit' ), 20 );
			}
		}

		/* === CLICKS STATUES === */

		/**
		 * Returns available statuses for affiliates
		 *
		 * @return array
		 */
		public static function get_available_statuses() {
			if ( empty( self::$available_statuses ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_clicks_statuses
				 *
				 * Filters the available statuses for the clicks.
				 *
				 * @param array $available_statuses Available statuses.
				 */
				self::$available_statuses = apply_filters(
					'yith_wcaf_clicks_statuses',
					array(
						'not-converted' => array(
							'slug' => 'not-converted',
							'name' => _x( 'Not converted', '[ADMIN] Click status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Not converted', 'Not converted', '[ADMIN] Click status', 'yith-woocommerce-affiliates' ),
						),
						'converted'     => array(
							'slug' => 'converted',
							'name' => _x( 'Converted', '[ADMIN] Click status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Converted', 'Converted', '[ADMIN] Click status', 'yith-woocommerce-affiliates' ),
						),
					)
				);
			}

			return self::$available_statuses;
		}

		/**
		 * Return a human friendly version of a click status
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
			 * APPLY_FILTERS: yith_wcaf_click_status_name
			 *
			 * Filters the name of the click status.
			 *
			 * @param string $label  Status name.
			 * @param string $status Status.
			 */
			return apply_filters( 'yith_wcaf_click_status_name', $label, $status );
		}

		/* === CLICK/CONVERSION HANDLER === */

		/**
		 * Registers an hit in clicks table
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_hit() {
			/**
			 * APPLY_FILTERS: yith_wcaf_should_register_hit
			 *
			 * Filters whether clicks should be registered.
			 *
			 * @param bool $register_hits Whether to register clicks or not.
			 */
			if ( ! apply_filters( 'yith_wcaf_should_register_hit', $this->are_hits_registered() ) ) {
				return;
			}

			$affiliate = YITH_WCAF_Session()->get_affiliate();

			if ( ! $affiliate || ! YITH_WCAF_Session()->get_query_var() ) {
				return;
			}

			$requester_link   = $this->get_requester_url();
			$requester_ip     = $this->get_requester_ip();
			$requester_origin = $this->get_requester_origin();

			$already_inserted = $this->count_hits(
				array(
					'affiliate_id' => $affiliate->get_id(),
					'ip'           => $requester_ip,
					'interval'     => array(
						'start_date' => wp_date( 'Y-m-d H:i:s', time() - $this->hit_resolution ),
					),
				)
			);

			if ( $already_inserted ) {
				return;
			}

			$click = new YITH_WCAF_Click();

			$click->set_props(
				array(
					'affiliate_id' => $affiliate->get_id(),
					'link'         => $requester_link,
					'ip'           => $requester_ip,
					'origin'       => $requester_origin,
				)
			);
			$click->save();
		}

		/**
		 * Register/unregister conversion depending on order status
		 *
		 * @param int $order_id Order id.
		 *
		 * @return bool Status of the operation.
		 */
		public function maybe_register_conversion( $order_id ) {
			if ( ! $this->are_hits_registered() ) {
				return false;
			}

			$order = wc_get_order( $order_id );

			if ( ! $order ) {
				return false;
			}

			$converted = $order->has_status( wc_get_is_paid_statuses() );

			return $converted ? $this->register_conversion( $order_id ) : $this->unregister_conversion( $order_id );
		}

		/**
		 * Register conversion when an order changes to complete or processing status
		 *
		 * @param int $order_id Order id.
		 *
		 * @return bool Status of the operation
		 * @since 1.0.0
		 */
		public function register_conversion( $order_id ) {
			if ( ! $this->are_hits_registered() ) {
				return false;
			}

			$order = wc_get_order( $order_id );

			if ( ! $order ) {
				return false;
			}

			// retrieve click registered within current order.
			$click_id   = $order->get_meta( '_yith_wcaf_click_id' );
			$registered = $order->get_meta( '_yith_wcaf_conversion_registered' );

			if ( ! $click_id || $registered ) {
				return false;
			}

			// retrieve click object.
			$click = YITH_WCAF_Click_Factory::get_click( $click_id );

			if ( ! $click ) {
				return false;
			}

			// update click object.
			$click->set_order_id( $order_id );
			$click->set_conversion_date( time() );

			$res = $click->save();

			// update order meta.
			if ( $res ) {
				$order->update_meta_data( '_yith_wcaf_conversion_registered', true );
				$order->save();
			}

			return $res;
		}

		/**
		 * Deregister conversion when order switch to on-hold/cancelled/refunded
		 *
		 * @param int $order_id Order id.
		 *
		 * @return boolean Operation status
		 * @since 1.0.0
		 */
		public function unregister_conversion( $order_id ) {
			if ( ! $this->are_hits_registered() ) {
				return false;
			}

			$order = wc_get_order( $order_id );

			if ( ! $order ) {
				return false;
			}

			// retrieve click registered within current order.
			$click_id   = $order->get_meta( '_yith_wcaf_click_id' );
			$registered = $order->get_meta( '_yith_wcaf_conversion_registered' );

			if ( ! $click_id || ! $registered ) {
				return false;
			}

			// retrieve click object.
			$click = YITH_WCAF_Click_Factory::get_click( $click_id );

			if ( ! $click ) {
				return false;
			}

			// update click object.
			$click->set_order_id( 0 );
			$click->set_conversion_date( '' );

			$res = $click->save();

			// update order meta.
			if ( $res ) {
				$order->update_meta_data( '_yith_wcaf_conversion_registered', false );
				$order->save();
			}

			return $res;
		}

		/* === HELPER METHODS === */

		/**
		 * Checks whether click system is enabled or not
		 *
		 * @return bool Whether click system is enabled
		 */
		public function are_hits_registered() {
			return $this->enabled;
		}

		/**
		 * Return number of clicks matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Click_Data_Store::query).
		 *
		 * @return int Number of counted clicks
		 * @since 1.0.0
		 */
		public function count_hits( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'click' );

				$count = $data_store->count( $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/**
		 * Return clicks matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Click_Data_Store::query).
		 *
		 * @return YITH_WCAF_Clicks_Collection Matching clicks
		 * @since 1.0.0
		 */
		public function get_hits( $args = array() ) {
			return YITH_WCAF_Click_Factory::get_clicks( $args );
		}

		/**
		 * Return specific hit by ID
		 *
		 * @param int $hit_id Hit ID.
		 *
		 * @return YITH_WCAF_Click Click object, or false on failure.
		 * @since 1.0.0
		 */
		public function get_hit( $hit_id ) {
			return YITH_WCAF_Click_Factory::get_click( $hit_id );
		}

		/**
		 * Return last hit with current requester IP and affiliate token
		 *
		 * @return mixed Database row, or false on failure
		 * @since 1.0.0
		 */
		public function get_last_hit() {
			$affiliate    = YITH_WCAF_Session()->get_affiliate();
			$affiliate_id = $affiliate ? $affiliate->get_id() : false;
			$requester_ip = $this->get_requester_ip();

			if ( ! $affiliate_id || ! $requester_ip ) {
				return false;
			}

			$collection = YITH_WCAF_Click_Factory::get_clicks(
				array(
					'affiliate_id' => $affiliate_id,
					'IP'           => $requester_ip,
					'limit'        => 1,
					'orderby'      => 'click_date',
					'order'        => 'DESC',
				)
			);

			if ( ! $collection || $collection->is_empty() ) {
				return false;
			}

			$rows = $collection->get_objects();
			$row  = array_shift( $rows );

			return $row->get_id();
		}

		/**
		 * Returns count of clicks, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic; if left empty, returns array of counts per status.
		 * @param array  $args   Array of arguments to filter status query (@see \YITH_WCAF_Click_Data_Store::per_status_count).
		 *
		 * @return int|array Count per state, or array indexed by status, with status count
		 * @use \YITH_WCAF_Click_Data_Store::::per_status_count
		 */
		public function per_status_count( $status = 'all', $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'click' );

				$count = $data_store->per_status_count( $status, $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/* === UTILITIES === */

		/**
		 * Returns IP for current user.
		 *
		 * @return string|bool IP for current user, or false on failure.
		 */
		public function get_requester_ip() {
			$requester_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : false;

			/**
			 * APPLY_FILTERS: yith_wcaf_requester_ip
			 *
			 * Filters the user IP address for the click.
			 *
			 * @param string $requester_ip Requester IP address.
			 */
			return apply_filters( 'yith_wcaf_requester_ip', $requester_ip );
		}

		/**
		 * Returns url visited by current requester
		 *
		 * @return string Visited url.
		 */
		public function get_requester_url() {
			global $wp;

			$requester_url = add_query_arg( $_GET, home_url( $wp->request ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			/**
			 * APPLY_FILTERS: yith_wcaf_requester_link
			 *
			 * Filters the URL visited by the current requester.
			 *
			 * @param string $requester_url Visited URL.
			 */
			return apply_filters( 'yith_wcaf_requester_link', $requester_url );
		}

		/**
		 * Returns origin url for current requester.
		 *
		 * @return string|bool Origin url, or false on failure.
		 */
		public function get_requester_origin() {
			$origin = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url( sanitize_text_field( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) ) : false;

			/**
			 * APPLY_FILTERS: yith_wcaf_requester_origin
			 *
			 * Filters the origin URL for the current requester.
			 *
			 * @param string $origin Origin URL.
			 */
			return apply_filters( 'yith_wcaf_requester_origin', $origin );
		}

		/**
		 * Returns origin url for current requester.
		 *
		 * @return string|bool Origin url, or false on failure.
		 */
		public function get_requester_origin_base() {
			$origin = $this->get_requester_origin();

			if ( ! $origin ) {
				return false;
			}

			return wp_parse_url( $origin, PHP_URL_HOST );
		}

		/**
		 * Init class attributes for admin options
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function retrieve_options() {
			$this->enabled        = 'yes' === get_option( 'yith_wcaf_click_enabled', 'yes' );
			$this->hit_resolution = (int) yith_wcaf_duration_to_secs( get_option( 'yith_wcaf_click_resolution', 60 ) );
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Click class
 *
 * @return \YITH_WCAF_Clicks
 * @since 1.0.0
 */
function YITH_WCAF_Clicks() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Clicks::get_instance();
}
