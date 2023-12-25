<?php
/**
 * Scripts utility class
 * Offers helper method to register assets and enqueue correct dependencies/translations.
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Scripts' ) ) {
	/**
	 * Scripts utility
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Scripts {

		/**
		 * Enqueue a script, given its handle
		 *
		 * @param string $handle       Script handle.
		 * @param string $section      Section; will be used by default as part of the lookup part for the script.
		 * @param array  $dependencies Array of additional dependencies for the script. They will be added to what can be found in .asset.php file.
		 * @param bool   $translate    Whether we need to set script translations or not.
		 */
		public static function enqueue( $handle, $section = '', $dependencies = array(), $translate = false ) {
			self::register( $handle, $section, $dependencies, $translate );

			wp_enqueue_script( $handle );
		}

		/**
		 * Register a script, given its handle
		 *
		 * @param string $handle       Script handle.
		 * @param string $section      Section; will be used by default as part of the lookup part for the script.
		 * @param array  $dependencies Array of additional dependencies for the script. They will be added to what can be found in .asset.php file.
		 * @param bool   $translate    Whether we need to set script translations or not.
		 */
		public static function register( $handle, $section = '', $dependencies = array(), $translate = false ) {
			$metadata = self::get_metadata( $handle, $section, $dependencies );

			wp_register_script( $handle, self::get_url( $handle, $section ), $metadata['dependencies'], $metadata['version'], true );

			$translate && self::translate( $handle );
		}

		/**
		 * Set script translation for the handle passed.
		 * Both text-domain and translations paths are fixed to plugin's ones.
		 *
		 * @param string $handle Script handle.
		 */
		protected static function translate( $handle ) {
			wp_set_script_translations( $handle, 'yith-woocommerce-affiliates', YITH_WCAF_LANG );
		}

		/**
		 * Returns path to a script, given its handle and section
		 * Path is relative to plugin installation folder.
		 *
		 * @param string $handle  Script handle.
		 * @param string $section Section; will be used by default as part of the lookup part for the script.
		 *
		 * @return string Relative path to the script.
		 */
		public static function get_relative_path( $handle, $section = '' ) {
			$subpath   = $section ? "{$section}/" : '';
			$suffix    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			$filename  = $section ? str_replace( "-{$section}", '', $handle ) : $handle;
			$extension = ".bundle{$suffix}.js";

			return apply_filters( 'yith_wcaf_assets_path', "assets/js/{$subpath}{$filename}{$extension}", $handle, $section );
		}

		/**
		 * Returns full url to a script, given its handle and section
		 *
		 * @param string $handle  Script handle.
		 * @param string $section Section; will be used by default as part of the lookup part for the script.
		 *
		 * @return string Script url.
		 */
		public static function get_url( $handle, $section = '' ) {
			$path = self::get_relative_path( $handle, $section );

			return apply_filters( 'yith_wcaf_assets_url', YITH_WCAF_URL . $path, $handle, $section );
		}

		/**
		 * Returns metadata for a specific script, given its handle and section.
		 * Metadata are read from .asset.php file for current script; if none is found, default metadata are returned.
		 * If additional deps are passed, they will be merged with ones read in metadata file
		 *
		 * @param string $handle          Script handle.
		 * @param string $section         Section; will be used by default as part of the lookup part for the script.
		 * @param array  $additional_deps List of dependencies to add to default ones.
		 *
		 * @return array Array of script metadata, formatted as follows:
		 * [
		 *     'dependencies' => array() // list of dependencies handles,
		 *     'version'      => ''      // script version, as an hash (fallbacks to plugin version when metadata file cant be found)
		 * ]
		 */
		public static function get_metadata( $handle, $section = '', $additional_deps = array() ) {
			$path  = self::get_relative_path( $handle, $section );
			$path  = str_replace( array( '.min.js', '.js' ), '.asset.php', $path );
			$path  = YITH_WCAF_DIR . $path;
			$asset = file_exists( $path ) ? (array) require $path : array();
			$asset = array_merge_recursive(
				$asset,
				array(
					'dependencies' => $additional_deps,
					'version'      => YITH_WCAF::VERSION,
				)
			);

			return $asset;
		}
	}
}
