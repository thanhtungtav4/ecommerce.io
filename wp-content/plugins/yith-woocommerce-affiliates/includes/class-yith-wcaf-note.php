<?php
/**
 * Note class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Note class.
 */
class YITH_WCAF_Note implements JsonSerializable {

	/**
	 * Current data for note
	 *
	 * @since 3.2.0
	 * @var array
	 */
	protected $current_data;

	/**
	 * Note data
	 *
	 * @since 3.2.0
	 * @var array
	 */
	protected $data;

	/**
	 * Constructor.
	 *
	 * @param array $note Data to wrap behind this function.
	 */
	public function __construct( $note = array() ) {
		$this->current_data = $note;
		$this->apply_changes();
	}

	/**
	 * When converted to JSON.
	 *
	 * @return object|array
	 */
	public function jsonSerialize() {
		return $this->get_data();
	}

	/**
	 * Merge changes with data and clear.
	 */
	public function apply_changes() {
		$this->data = $this->current_data;
	}

	/**
	 * Creates or updates a property in the metadata object.
	 *
	 * @param string $key Key to set.
	 * @param mixed  $value Value to set.
	 */
	public function __set( $key, $value ) {
		$this->current_data[ $key ] = $value;
	}

	/**
	 * Checks if a given key exists in our data. This is called internally
	 * by `empty` and `isset`.
	 *
	 * @param string $key Key to check if set.
	 *
	 * @return bool
	 */
	public function __isset( $key ) {
		return array_key_exists( $key, $this->current_data );
	}

	/**
	 * Returns the value of any property.
	 *
	 * @param string $key Key to get.
	 * @return mixed Property value or NULL if it does not exists
	 */
	public function __get( $key ) {
		if ( array_key_exists( $key, $this->current_data ) ) {
			return $this->current_data[ $key ];
		}
		return null;
	}

	/**
	 * Return data changes only.
	 *
	 * @return array
	 */
	public function get_changes() {
		$changes = array();
		foreach ( $this->current_data as $id => $value ) {
			if ( ! array_key_exists( $id, $this->data ) || $value !== $this->data[ $id ] ) {
				$changes[ $id ] = $value;
			}
		}
		return $changes;
	}

	/**
	 * Return all data as an array.
	 *
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Returns note content, if any
	 *
	 * @return string
	 */
	public function get_content() {
		return isset( $this->current_data['content'] ) ? $this->current_data['content'] : '';
	}

	/**
	 * Return date of creation of the note, as a WC_DateTime object
	 *
	 * @return WC_DateTime|bool Creation date, or false on failure.
	 */
	public function get_created_at() {
		if ( ! isset( $this->current_data['created_at'] ) ) {
			return false;
		}

		try {
			$ts = strtotime( $this->current_data['created_at'] );
			$dt = new WC_DateTime( "@{$ts}" );

			/**
			 * We don't set any timezone on WC_DateTime constructor, as we're building the object
			 * using a timestamp {@see https://www.php.net/manual/en/datetime.construct.php}
			 *
			 * Anyway, we want date to be localized in current zone, so we set "visualization" zone immediately after creation
			 *
			 * @since 2.0.2
			 */
			$dt->setTimezone( wp_timezone() );

			return $dt;
		} catch ( Exception $e ) {
			return false;
		}
	}
}
