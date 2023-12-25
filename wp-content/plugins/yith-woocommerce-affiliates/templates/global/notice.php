<?php
/**
 * Notice message to show above Affiliate Dashboard sections
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Templates
 * @version 1.0.5
 */

/**
 * Template variables:
 *
 * @var $message string
 * @var $classes array
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf-notice-message <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php echo wp_kses_post( $message ); ?>
</div>
