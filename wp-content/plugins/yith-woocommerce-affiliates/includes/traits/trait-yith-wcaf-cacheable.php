<?php
/**
 * Trait that offers cache methods for any object that implements it
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Traits
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! trait_exists( 'YITH_WCAF_Trait_Cacheable' ) ) {
	/**
	 * This class implements methods that can be used to store/retrieve data from cache
	 * Current implementation is based on wp_cache, but can be changed with alternative object cache using yith_wcaf_cache_object filter
	 *
	 * @since 2.0.0
	 */
	trait YITH_WCAF_Trait_Cacheable {

		/**
		 * Cache group
		 *
		 * @var string
		 */
		protected $cache_group;

		/**
		 * Set a value into the cache
		 *
		 * @param string $key  Key to use in the cache.
		 * @param mixed  $data Value to save into the cache.
		 */
		protected function cache_set( $key, $data ) {
			$object_cache = $this->get_object_cache();

			$object_cache->set( $this->get_cache_key( $key ), $data, $this->cache_group );
		}

		/**
		 * Retrieve a value from the cache
		 *
		 * @param string $key Key to retrieve from the cache.
		 * @return mixed Data retrieved from the cache.
		 */
		protected function cache_get( $key ) {
			$object_cache = $this->get_object_cache();

			return $object_cache->get( $this->get_cache_key( $key ), $this->cache_group );
		}

		/**
		 * Removes a key from the cache
		 *
		 * @param string $key Key to delete in cache.
		 */
		protected function cache_delete( $key ) {
			$object_cache = $this->get_object_cache();

			$object_cache->delete( $this->get_cache_key( $key ), $this->cache_group );
		}

		/**
		 * Retrieves key for a set of parameters
		 *
		 * @param mixed $params Array to use to generate key.
		 * @return string Key to use in the cache.
		 */
		protected function get_cache_key( $params ) {
			if ( is_scalar( $params ) ) {
				return $params;
			}

			return md5( http_build_query( (array) $params ) );
		}

		/**
		 * Retrieves keys for a set of parameters, including cache version
		 *
		 * @param string $prefix String that will prefix versioned key.
		 * @param mixed  $params Array to use to generate key.
		 *
		 * @return string Key to use in the cache.
		 */
		protected function get_versioned_cache_key( $prefix, $params = array() ) {
			$params = (array) $params;

			$params['version'] = WC_Cache_Helper::get_transient_version( "yith_wcaf_{$this->cache_group}_cache_version" );

			$hashed_key = $this->get_cache_key( $params );

			return "{$prefix}_{$hashed_key}";
		}

		/**
		 * Invalidate cached version
		 */
		protected function invalidate_versioned_cache() {
			WC_Cache_Helper::get_transient_version( "yith_wcaf_{$this->cache_group}_cache_version", true );
		}

		/**
		 * Returns handler of the object cache to use in the plugin
		 *
		 * @return WP_Object_Cache Returns WP cache by default; filter yith_wcaf_cache_object can be user to pass any other object with the same interface.
		 */
		protected function get_object_cache() {
			global $wp_object_cache;

			/**
			 * APPLY_FILTERS: yith_wcaf_cache_object
			 *
			 * Filters the object cache.
			 *
			 * @param WP_Object_Cache $wp_object_cache Object cache.
			 */
			$object_cache = apply_filters( 'yith_wcaf_cache_object', $wp_object_cache );

			// make sure filtered object has minimum requirements.
			if (
				! method_exists( $object_cache, 'get' ) ||
				! method_exists( $object_cache, 'set' ) ||
				! method_exists( $object_cache, 'delete' )
			) {
				return $wp_object_cache;
			}

			return $object_cache;
		}
	}
}
