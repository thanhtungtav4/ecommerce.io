<?php
/**
 * Generic objects collection class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Abstracts
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Objects_Collection' ) ) {

	/**
	 * Implements method that allow you to access this object as an array
	 *
	 * @since 2.0.0
	 */
	abstract class YITH_WCAF_Abstract_Objects_Collection implements ArrayAccess, Iterator, Countable {
		/**
		 * Array of ids for the collection
		 *
		 * @var array
		 */
		protected $ids = array();

		/**
		 * Array of objects for matching ids
		 *
		 * @var array
		 */
		protected $objects = array();

		/**
		 * Array of metadata for current collection
		 *
		 * @var array
		 */
		protected $meta = array();

		/**
		 * Construct collection o object
		 *
		 * @param array $ids  Array of ids for the collection's objects.
		 * @param array $meta Meta data concerning current collection:
		 * [
		 *     'per_page' => 10, // int: number of items per page
		 *     'pages'    => 1,  // int: number of pages
		 *     'items'    => 10, // int: number of total items
		 *     'page'     => 1,  // int: current page
		 *     'offset'   => 0,  // int: query offset
		 * ].
		 */
		public function __construct( $ids = array(), $meta = array() ) {
			$this->ids  = $ids;
			$this->meta = $meta;
		}

		/* === GETTERS === */

		/**
		 * Tests if current collection is empty
		 *
		 * @return bool
		 */
		public function is_empty() {
			return empty( $this->ids );
		}

		/**
		 * Retrieves ids for current collection
		 *
		 * @return array Array of objects.
		 */
		public function get_ids() {
			return array_map(
				function( $item ) {
					return $item instanceof YITH_WCAF_Abstract_Object ? $item->get_id() : $item;
				},
				$this->ids
			);
		}

		/**
		 * Retrieves objects for current collection
		 *
		 * @return array Array of objects.
		 */
		public function get_objects() {
			if ( ! empty( $this->ids ) && empty( $this->objects ) ) {
				$objects = array();

				foreach ( $this->ids as $object_id ) {
					$object = $this->get_object( $object_id );

					if ( ! $object ) {
						$this->ids = array_diff( $this->ids, array( $object_id ) );
					} else {
						$objects[] = $object;
					}
				}

				$this->objects = array_combine( $this->ids, $objects );
			}

			return $this->objects;
		}

		/**
		 * Returns first object in the list
		 *
		 * @return YITH_WCAF_Abstract_Object
		 */
		public function get_head() {
			$objects = $this->get_objects();

			return current( $objects );
		}

		/**
		 * Retrieves a specific object, giver the id
		 *
		 * @param int $object_id Id of the object to retrieve.
		 *
		 * @return WC_Data Object retrieved.
		 */
		abstract public function get_object( $object_id );

		/* === MODIFY ITEMS === */

		/**
		 * Add an item to the collection
		 *
		 * @param int $id Id of the item to add.
		 * @return void
		 */
		public function add( $id ) {
			$this->ids[] = $id;

			$objects        = $this->get_objects();
			$objects[ $id ] = $this->get_object( $id );

			$this->objects = $objects;
		}

		/**
		 * Removes an item from the collection
		 *
		 * @param int $id Id of the item to remove.
		 * @return void
		 */
		public function remove( $id ) {
			$this->offsetUnset( $id );
		}

		/* === META === */

		/**
		 * Returns an existing meta for this collection
		 *
		 * @param string $meta Meta to retrieve.
		 *
		 * @return mixed|bool Meta value, or false if meta doesn't exist.
		 */
		public function get_meta( $meta ) {
			return isset( $this->meta[ $meta ] ) ? $this->meta[ $meta ] : false;
		}

		/* === PAGINATION META === */

		/**
		 * Check if we can assume that current collection represents a subset of a larger set.
		 * This information comes from collection meta; if we have no information about, just assume collection is the entire set.
		 *
		 * @return bool
		 */
		public function is_paged() {
			return isset( $this->meta['per_page'] );
		}

		/**
		 * Assuming collection represents a subset of a larger set, returns current page collection represent in the set.
		 * This information comes from collection meta; if we have no information about, just returns 1.
		 *
		 * @return int
		 */
		public function get_current_page() {
			$page = 1;

			if ( isset( $this->meta['page'] ) ) {
				$page = (int) $this->meta['page'];
			} elseif ( isset( $this->meta['offset'] ) && isset( $this->meta['per_page'] ) ) {
				$page = $this->meta['offset'] % $this->meta['per_page'] + 1;
			}

			return $page;
		}

		/**
		 * Assuming collection represents a subset of a larger set, returns total number of pages in the larger set.
		 * This information comes from collection meta; if we have no information about, just return 1.
		 *
		 * @return int
		 */
		public function get_total_pages() {
			$pages = 1;

			if ( isset( $this->meta['pages'] ) ) {
				$pages = (int) $this->meta['pages'];
			} elseif ( isset( $this->meta['items'] ) && isset( $this->meta['per_page'] ) ) {
				$pages = ceil( $this->meta['items'] / $this->meta['per_page'] );
			}

			return $pages;
		}

		/**
		 * Assuming collection represents a subset of a larger set, checks if there is another page following current one.
		 * This information comes from collection meta; if we have no information about, just assume current is the only page available.
		 *
		 * @return bool
		 */
		public function has_next_page() {
			$page  = $this->get_current_page();
			$pages = $this->get_total_pages();

			return $pages > $page;
		}

		/**
		 * Assuming collection represents a subset of a larger set, returns total number of items in the larger set
		 * This information comes from collection meta; if we have no information about this, just count collection items.
		 *
		 * @return int
		 */
		public function get_total_items() {
			if ( isset( $this->meta['items'] ) ) {
				return (int) $this->meta['items'];
			}

			return count( $this->ids );
		}

		/* === ITERATOR === */

		#[\ReturnTypeWillChange]
		/**
		 * Return the current element
		 *
		 * @link https://php.net/manual/en/iterator.current.php
		 * @return mixed Can return any type.
		 */
		public function current() {
			$this->get_objects();

			return current( $this->objects );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Move forward to next element
		 *
		 * @link https://php.net/manual/en/iterator.next.php
		 * @return void Any returned value is ignored.
		 */
		public function next() {
			$this->get_objects();

			next( $this->objects );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Return the key of the current element
		 *
		 * @link https://php.net/manual/en/iterator.key.php
		 * @return string|float|int|bool|null scalar on success, or null on failure.
		 */
		public function key() {
			$this->get_objects();

			return key( $this->objects );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Checks if current position is valid
		 *
		 * @link https://php.net/manual/en/iterator.valid.php
		 * @return bool The return value will be casted to boolean and then evaluated.
		 * Returns true on success or false on failure.
		 */
		public function valid() {
			$this->get_objects();

			return array_key_exists( $this->key(), $this->objects );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Rewind the Iterator to the first element
		 *
		 * @link https://php.net/manual/en/iterator.rewind.php
		 * @return void Any returned value is ignored.
		 */
		public function rewind() {
			$this->get_objects();

			reset( $this->objects );
		}

		/**
		 * Returns lasst element of the set
		 *
		 * @return mixed Last item.
		 */
		public function end() {
			$this->get_objects();

			return end( $this->objects );
		}

		/* === ARRAY ACCESS === */

		#[\ReturnTypeWillChange]
		/**
		 * Whether a offset exists
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetexists.php
		 *
		 * @param mixed $offset An offset to check for.
		 * @return bool true on success or false on failure.
		 */
		public function offsetExists( $offset ) {
			return in_array( $offset, $this->ids, true );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Offset to retrieve
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetget.php
		 *
		 * @param mixed $offset The offset to retrieve.
		 *
		 * @return mixed Can return all value types.
		 */
		public function offsetGet( $offset ) {
			$objects = $this->get_objects();

			if ( ! isset( $objects[ $offset ] ) ) {
				return false;
			}

			return $objects[ $offset ];
		}

		#[\ReturnTypeWillChange]
		/**
		 * Offset to set
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetset.php
		 *
		 * @param mixed $offset The offset to assign the value to.
		 * @param mixed $value  The value to set.
		 *
		 * @throws Exception When called; you should use ->add() instead.
		 * @return void
		 */
		public function offsetSet( $offset, $value ) {
			throw new Exception( 'You cannot add items to from collection this way; please, use ->add() method' );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Offset to unset
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetunset.php
		 *
		 * @param mixed $offset The offset to unset.
		 *
		 * @return void
		 */
		public function offsetUnset( $offset ) {
			$objects = $this->get_objects();

			if ( ! isset( $objects[ $offset ] ) ) {
				return;
			}

			unset( $objects[ $offset ] );

			$this->objects = $objects;
			$this->ids     = array_diff( $this->ids, array( $offset ) );
		}

		/* === COUNTABLE === */

		#[\ReturnTypeWillChange]
		/**
		 * Count elements of an object
		 *
		 * @link https://php.net/manual/en/countable.count.php
		 * @return int The custom count as an integer.
		 */
		public function count() {
			return count( $this->ids );
		}
	}
}
