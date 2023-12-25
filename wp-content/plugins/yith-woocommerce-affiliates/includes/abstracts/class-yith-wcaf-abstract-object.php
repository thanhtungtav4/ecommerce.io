<?php
/**
 * Generic object class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Abstracts
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Object' ) ) {

	/**
	 * Affiliate generic object
	 *
	 * @since 1.0.0
	 */
	abstract class YITH_WCAF_Abstract_Object extends WC_Data implements ArrayAccess {
		/**
		 * Relation existing between object properties and array offsets
		 *
		 * @var array
		 */
		protected $offset_to_prop_map = array();

		/**
		 * Array of available admin actions
		 *
		 * @var  array
		 * @since 2.0.2
		 */
		protected $admin_actions = array();

		/* === GETTERS === */

		/**
		 * Returns a single action fro the list of actions that admin can perform over this object.
		 *
		 * @param string $action Action slug.
		 * @return array|bool Action array, or false on failure.
		 */
		public function get_admin_action( $action ) {
			$actions = $this->get_admin_actions();

			if ( empty( $actions ) || ! isset( $actions[ $action ] ) ) {
				return false;
			}

			return $actions[ $action ];
		}

		/**
		 * Returns a list of actions that admin can perform over this object, including url to perform them.
		 *
		 * @return array Array of valid actions.
		 */
		public function get_admin_actions() {
			if ( ! is_admin() ) {
				return array();
			}

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				return array();
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_object_admin_actions
			 *
			 * Filters the list of the actions to perform over the current object.
			 *
			 * @param array                     $admin_actions Actions to perform over the object.
			 * @param int                       $object_id     Object id.
			 * @param YITH_WCAF_Abstract_Object $object        Current object to perform actions.
			 */
			return apply_filters( 'yith_wcaf_object_admin_actions', $this->admin_actions, $this->get_id(), $this );
		}

		/**
		 * Returns an array representation of this object
		 * It is an alias of ->get_data,
		 *
		 * @return array Formatted array representing current item.
		 */
		public function to_array() {
			/**
			 * APPLY_FILTERS: yith_wcaf_object_to_array
			 *
			 * Filters the generated array with the data from the object.
			 *
			 * @param array                     $data      Object data.
			 * @param int                       $object_id Object id.
			 * @param YITH_WCAF_Abstract_Object $object    Current object to perform actions.
			 */
			return apply_filters( 'yith_wcaf_object_to_array', array_merge( array( 'id' => $this->get_id() ), $this->data ), $this->get_id(), $this );
		}

		/* === CAPABILITIES CHECK === */

		/**
		 * Returns true if a user is found to be owner of current object
		 *
		 * @param int $user_id User id to test.
		 * @return bool Whether user is owner of this object.
		 */
		public function is_user_owner( $user_id ) {
			$object_type = strtolower( self::class );

			if ( method_exists( $this, 'get_user_id' ) ) {
				$owner_id = $this->get_user_id();
			} elseif ( method_exists( $this, 'get_affiliate' ) ) {
				$affiliate = $this->get_affiliate();
				$owner_id  = $affiliate ? $affiliate->get_user_id() : false;
			} else {
				$owner_id = false;
			}

			/**
			 * APPLY_FILTERS: $object_type_is_user_owner
			 *
			 * Filters whether the user is the owner of the current object.
			 * <code>$object_type</code> will be replaced with the object type the operation will be performed to.
			 *
			 * @param bool                      $is_owner  Whether the user is the owner of the current object or not.
			 * @param int                       $user_id   User id.
			 * @param int                       $owner_id  Owner id.
			 * @param int                       $object_id Object id.
			 * @param YITH_WCAF_Abstract_Object $object    Current object to perform actions.
			 */
			return apply_filters( "{$object_type}_is_user_owner", (int) $owner_id === (int) $user_id, $user_id, $owner_id, $this->get_id(), $this );
		}

		/**
		 * Checks whether current user can perform operations over current object
		 *
		 * @param string $capability Capability to check; child objects may implement their logic for vaiours capabilities, if needed.
		 *
		 * @return bool Whether current use can perform action or not.
		 */
		public function current_user_can( $capability ) {
			if ( ! is_user_logged_in() ) {
				return false;
			}

			$current_user_id = get_current_user_id();

			return $this->user_can( $current_user_id, $capability );
		}

		/**
		 * Checks whether specified user can perform operations over current object
		 *
		 * @param int    $user_id    User to check.
		 * @param string $capability Capability to check; child objects may implement their logic for vaiours capabilities, if needed.
		 *
		 * @return bool Whether current use can perform action or not.
		 */
		public function user_can( $user_id, $capability ) {
			$object_type   = strtolower( self::class );
			$is_user_owner = $this->is_user_owner( $user_id );

			if ( 'read' === $capability && $is_user_owner ) {
				$can = true;
			} else {
				$can = user_can( $user_id, YITH_WCAF_Admin()->get_panel_capability() );
			}

			/**
			 * APPLY_FILTERS: $object_type_user_can
			 *
			 * Filters whether the user can perform operations over current payment.
			 * <code>$object_type</code> will be replaced with the object type the operation will be performed to.
			 *
			 * @param bool   $can        Whether the user can perform operations or not.
			 * @param int    $user_id    User id.
			 * @param string $capability Capability to check.
			 * @param int    $id         Object id to check.
			 * @param object $object     Object to check.
			 */
			return apply_filters( "{$object_type}_user_can", $can, $user_id, $capability, $this->get_id(), $this );
		}

		/* === ARRAY ACCESS === */

		#[\ReturnTypeWillChange]
		/**
		 * Checks whether or not an offset exists.
		 *
		 * @param string $offset Offset to check.
		 * @return bool Whether or not the offset exists.
		 */
		public function offsetExists( $offset ) {
			if ( isset( $this->offset_to_prop_map[ $offset ] ) ) {
				$offset = $this->offset_to_prop_map[ $offset ];
			}

			if ( ! method_exists( $this, "get_{$offset}" ) ) {
				return false;
			}

			return true;
		}

		#[\ReturnTypeWillChange]
		/**
		 * Retrieves value for a specific offset
		 *
		 * @param string $offset Offset to retrieve.
		 * @return mixed Retrieved value.
		 */
		public function offsetGet( $offset ) {
			if ( isset( $this->offset_to_prop_map[ $offset ] ) ) {
				$offset = $this->offset_to_prop_map[ $offset ];
			}

			if ( ! method_exists( $this, "get_{$offset}" ) ) {
				return null;
			}

			return $this->{"get_{$offset}"}( 'view' );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Sets value for a specific offset
		 *
		 * @param string $offset Offset to check.
		 * @param mixed  $value  Value to set for the offset.
		 */
		public function offsetSet( $offset, $value ) {
			if ( isset( $this->offset_to_prop_map[ $offset ] ) ) {
				$offset = $this->offset_to_prop_map[ $offset ];
			}

			if ( ! method_exists( $this, "set_{$offset}" ) ) {
				return;
			}

			$this->{"set_{$offset}"}( $value );
		}

		#[\ReturnTypeWillChange]
		/**
		 * Does nothing. Just required by interface.
		 *
		 * @param string $offset Offset to check.
		 */
		public function offsetUnset( $offset ) {
			// just do nothing; should never be called.
		}
	}
}
