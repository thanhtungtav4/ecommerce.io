<?php
/**
 * Affiliate Dashboard class
 * This is just an alias for {@see YITH_WCAF_Abstract_Dashboard}
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Creates an alias for current class
 * This is required to allow for YITH_WCAF_Dashboard::get_instance() (and other YITH_WCAF_Dashboard static methods) calls to work,
 * while keeping name coherent with abstract nature of the class.
 *
 * Class definition can be located in /includes/abstracts/class-yith-wcaf-abstract-dashboard.php
 *
 * @since 2.0.0
 */
class_alias( 'YITH_WCAF_Abstract_Dashboard', 'YITH_WCAF_Dashboard' );
