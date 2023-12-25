<?php
/**
 * Click class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Click' ) ) {

	/**
	 * Affiliate hit
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Click extends YITH_WCAF_Abstract_Object {

		/**
		 * Stores meta in cache for future reads.
		 *
		 * A group must be set to to enable caching.
		 *
		 * @var string
		 */
		protected $cache_group = 'hit';

		/**
		 * Stores affiliate for current click
		 *
		 * @var YITH_WCAF_Affiliate
		 */
		protected $affiliate = null;

		/**
		 * Stores order for current click, if any
		 *
		 * @var WC_Order
		 */
		protected $order = null;

		/**
		 * Relation existing between object properties and array offesets
		 *
		 * @var array
		 */
		protected $offset_to_prop_map = array(
			'conv_date'  => 'conversion_date',
			'conv_time'  => 'conversion_time',
			'click_date' => 'date',
		);

		/**
		 * Constructor
		 *
		 * @param int|\YITH_WCAF_Click $click Click identifier.
		 *
		 * @throws Exception When not able to load Data Store class.
		 */
		public function __construct( $click = 0 ) {
			// set default values.
			$this->data = array(
				'affiliate_id'    => 0,
				'link'            => '',
				'origin'          => '',
				'origin_base'     => '',
				'ip'              => '',
				'date'            => '',
				'order_id'        => 0,
				'conversion_date' => '',
				'conversion_time' => '',
			);

			parent::__construct();

			if ( is_numeric( $click ) && $click > 0 ) {
				$this->set_id( $click );
			} elseif ( $click instanceof self ) {
				$this->set_id( $click->get_id() );
			} else {
				$this->set_object_read( true );
			}

			$this->data_store = WC_Data_Store::load( 'click' );

			if ( $this->get_id() > 0 ) {
				$this->data_store->read( $this );
			}
		}

		/* === GETTERS === */

		/**
		 * Return affiliate id for current click
		 *
		 * @param string $context Context of the operation.
		 * @return int Affiliate id.
		 */
		public function get_affiliate_id( $context = 'view' ) {
			return (int) $this->get_prop( 'affiliate_id', $context );
		}

		/**
		 * Return affiliate object for current click
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read affiliate again from db, even if a cached version exists.
		 * @return YITH_WCAF_Affiliate Affiliate object.
		 */
		public function get_affiliate( $context = 'view', $refresh = false ) {
			$affiliate_id = $this->get_affiliate_id( $context );

			if ( ! $affiliate_id ) {
				return null;
			}

			if ( empty( $this->affiliate ) || $affiliate_id !== $this->affiliate->get_id() || $refresh ) {
				$this->affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );
			}

			return $this->affiliate;
		}

		/**
		 * Return link visited by the customer
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Return visited link.
		 */
		public function get_link( $context = 'view' ) {
			return esc_url( $this->get_prop( 'link', $context ) );
		}

		/**
		 * Return origin url (if available)
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Return origin url.
		 */
		public function get_origin( $context = 'view' ) {
			return esc_url( $this->get_prop( 'origin', $context ) );
		}

		/**
		 * Return domain for origin url (if available)
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Return origin domain.
		 */
		public function get_origin_base( $context = 'view' ) {
			return $this->get_prop( 'origin_base', $context );
		}

		/**
		 * Return customer IP
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Return customer IP.
		 */
		public function get_ip( $context = 'view' ) {
			return $this->get_prop( 'ip', $context );
		}

		/**
		 * Return object representing date click was registered.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Creation date.
		 */
		public function get_date( $context = 'view' ) {
			$date = $this->get_prop( 'date', $context );

			if ( $date && 'view' === $context ) {
				return $date->date_i18n( 'Y-m-d H:i:s' );
			}

			return $date;
		}

		/**
		 * Return object representing date click was registered.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Creation date.
		 */
		public function get_click_date( $context = 'view' ) {
			return $this->get_date( $context );
		}

		/**
		 * Return order id for current click
		 *
		 * @param string $context Context of the operation.
		 * @return int Order id.
		 */
		public function get_order_id( $context = 'view' ) {
			return (int) $this->get_prop( 'order_id', $context );
		}

		/**
		 * Return order object for current click
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read order again from db, even if a cached version exists.
		 * @return WC_Order Order object.
		 */
		public function get_order( $context = 'view', $refresh = false ) {
			$order_id = $this->get_order_id( $context );

			if ( ! $order_id ) {
				return null;
			}

			if ( empty( $this->order ) || $order_id !== $this->order->get_id() || $refresh ) {
				$this->order = wc_get_order( $order_id );
			}

			return $this->order;
		}

		/**
		 * Returns if click is converted
		 *
		 * @param string $context Context of the operation.
		 * @return bool Whether click is converted or not
		 */
		public function is_converted( $context = 'view' ) {
			return ! ! $this->get_order_id( $context );
		}

		/**
		 * Return current status of the click, as a slug
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Click status.
		 */
		public function get_status( $context = 'view' ) {
			return $this->is_converted( $context ) ? 'converted' : 'not-converted';
		}

		/**
		 * Return current status of the click, as a localized string
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Click shortened status.
		 */
		public function get_formatted_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Clicks::get_available_statuses();
			$current_status     = $this->is_converted( $context ) ? 'converted' : 'not-converted';

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses['pending']['name'];
			}

			return $available_statuses[ $current_status ]['name'];
		}

		/**
		 * Return object representing date click was converted.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Conversion date.
		 */
		public function get_conversion_date( $context = 'view' ) {
			$date = $this->get_prop( 'conversion_date', $context );

			if ( $date && 'view' === $context ) {
				return $date->date_i18n( 'Y-m-d H:i:s' );
			}

			return $date;
		}

		/**
		 * Return number of seconds that passed between click registration and conversion
		 *
		 * @param string $context Context of the operation.
		 * @return int Conversion seconds.
		 */
		public function get_conversion_time( $context = 'view' ) {
			return (int) $this->get_prop( 'conversion_time', $context );
		}

		/* === SETTERS === */

		/**
		 * Set affiliate id for the click
		 *
		 * @param int $affiliate_id Affiliate id for current click.
		 */
		public function set_affiliate_id( $affiliate_id ) {
			$affiliate_id = (int) $affiliate_id;

			// checks that we're referring an existing user.
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );

			if ( ! $affiliate ) {
				return;
			}

			$this->set_prop( 'affiliate_id', $affiliate_id );
			$this->affiliate = $affiliate;
		}

		/**
		 * Set visited url.
		 *
		 * @param string $link Visited url.
		 */
		public function set_link( $link ) {
			$link = $link ? esc_url( $link ) : '';

			$this->set_prop( 'link', $link );
		}

		/**
		 * Set origin url.
		 *
		 * @param string $origin Origin url.
		 */
		public function set_origin( $origin ) {
			$origin = $origin ? esc_url( $origin ) : '';

			if ( $this->object_read ) {
				$new_base = wp_parse_url( $origin, PHP_URL_HOST );
				$this->set_origin_base( $new_base );
			}

			$this->set_prop( 'origin', $origin );
		}

		/**
		 * Set origin domain.
		 *
		 * @param string $origin_base Origin domain.
		 */
		public function set_origin_base( $origin_base ) {
			$this->set_prop( 'origin_base', $origin_base );
		}

		/**
		 * Set customer IP.
		 *
		 * @param string $ip Customer ip.
		 */
		public function set_ip( $ip ) {
			$this->set_prop( 'ip', $ip );
		}

		/**
		 * Set date click was registered
		 *
		 * @param int|string $created_at Date of creation (timestamp or date).
		 */
		public function set_date( $created_at ) {
			$this->set_date_prop( 'date', $created_at );
		}

		/**
		 * Set order id for the commission
		 *
		 * @param int $order_id Order id.
		 */
		public function set_order_id( $order_id ) {
			$order_id = (int) $order_id;

			$this->set_prop( 'order_id', $order_id );
		}

		/**
		 * Set date click was converted
		 *
		 * @param int|string $converted_at Date of conversion (timestamp or date).
		 */
		public function set_conversion_date( $converted_at ) {
			$this->set_date_prop( 'conversion_date', $converted_at );

			if ( $this->object_read ) {
				if ( ! $converted_at ) {
					$this->set_conversion_time( '' );
				} else {
					$creation_date   = $this->get_date( 'edit' );
					$creation_ts     = $creation_date ? $creation_date->getTimestamp() : false;
					$conversion_date = $this->get_conversion_date( 'edit' );
					$conversion_ts   = $conversion_date ? $conversion_date->getTimestamp() : false;

					if ( $creation_ts && $conversion_ts ) {
						$this->set_conversion_time( max( 0, $conversion_ts - $creation_ts ) );
					}
				}
			}
		}

		/**
		 * Set order id for the commission
		 *
		 * @param int $conversion_time Number of seconds passed between hit registration and hit conversion.
		 */
		public function set_conversion_time( $conversion_time ) {
			$conversion_time = (int) $conversion_time;

			$this->set_prop( 'conversion_time', $conversion_time );
		}

		/* === OVERRIDES === */

		/**
		 * Save should create or update based on object existence.
		 *
		 * @return int
		 */
		public function save() {
			$changes  = $this->get_changes();
			$old_data = $this->get_data();

			$new_id = parent::save();

			// executes required adjustments to affiliate object after changes.
			if ( array_intersect( array_keys( $changes ), array( 'affiliate_id', 'order_id' ) ) ) {
				$this->sync_affiliate( $old_data, $changes );
			}

			return $new_id;
		}

		/* === EXTERNAL OBJECTS HANDLING === */

		/**
		 * Sync changes to affiliate object when saving data for the click
		 *
		 * @param array $old_data Array of old click data.
		 * @param array $new_data Array of new click data.
		 */
		protected function sync_affiliate( $old_data, $new_data ) {
			// retrieve new and old affiliate (they might be the same).
			$new_affiliate = $this->get_affiliate();

			if ( isset( $new_data['affiliate_id'] ) && $new_data['affiliate_id'] !== $old_data['affiliate_id'] ) {
				$old_affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_id( $old_data['affiliate_id'] );
			} else {
				$old_affiliate = $new_affiliate;
			}

			// retrieve old commission status.
			$was_converted = $old_data['order_id'];
			$is_converted  = $this->is_converted();

			// updated counters for the previous affiliate.
			if ( $old_affiliate ) {
				$old_affiliate->decrease_clicks();

				if ( $was_converted ) {
					$old_affiliate->decrease_conversions();
				}
			}

			// updated counters for the current affiliate.
			if ( $new_affiliate ) {
				$new_affiliate->increase_clicks();

				if ( $is_converted ) {
					$new_affiliate->increase_conversions();
				}
			}

			// save affiliates.
			$new_affiliate && $new_affiliate->save();

			if ( $old_affiliate && $old_affiliate->get_id() !== $this->get_affiliate_id() ) {
				$old_affiliate->save();
			}
		}
	}
}
