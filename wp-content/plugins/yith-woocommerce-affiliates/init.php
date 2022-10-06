<?php
/**
 * Plugin Name: YITH WooCommerce Affiliates
 * Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-affiliates/
 * Description: <code><strong>YITH WooCommerce Affiliates</strong></code> allows your users to become affiliates on your site earning commissions on every sale generated through their exclusive affiliation links. Create a sales network at no cost and increase your incomes just like big stores. <a href="https://yithemes.com/" target="_blank">Get more plugins for your e-commerce on <strong>YITH</strong></a>
 * Version: 2.7.0
 * Author: YITH
 * Author URI: https://yithemes.com/
 * Text Domain: yith-woocommerce-affiliates
 * Domain Path: /languages/
 * WC requires at least: 6.8
 * WC tested up to: 7.0
 *
 * @author  YITH
 * @package YITH/Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

! defined( 'YITH_WCAF' ) && define( 'YITH_WCAF', true );
! defined( 'YITH_WCAF_FREE' ) && define( 'YITH_WCAF_FREE', true );
! defined( 'YITH_WCAF_URL' ) && define( 'YITH_WCAF_URL', plugin_dir_url( __FILE__ ) );
! defined( 'YITH_WCAF_DIR' ) && define( 'YITH_WCAF_DIR', plugin_dir_path( __FILE__ ) );
! defined( 'YITH_WCAF_ASSETS_URL' ) && define( 'YITH_WCAF_ASSETS_URL', YITH_WCAF_URL . 'assets/' );
! defined( 'YITH_WCAF_INC' ) && define( 'YITH_WCAF_INC', YITH_WCAF_DIR . 'includes/' );
! defined( 'YITH_WCAF_LANG' ) && define( 'YITH_WCAF_LANG', YITH_WCAF_DIR . 'languages/' );
! defined( 'YITH_WCAF_INIT' ) && define( 'YITH_WCAF_INIT', plugin_basename( __FILE__ ) );
! defined( 'YITH_WCAF_FREE_INIT' ) && define( 'YITH_WCAF_FREE_INIT', plugin_basename( __FILE__ ) );
! defined( 'YITH_WCAF_SLUG' ) && define( 'YITH_WCAF_SLUG', 'yith-woocommerce-affiliates' );

if ( ! function_exists( 'yith_affiliates_constructor' ) ) {
	/**
	 * Bootstraps plugin
	 *
	 * @return YITH_WCAF
	 */
	function yith_affiliates_constructor() {
		load_plugin_textdomain( 'yith-woocommerce-affiliates', false, plugin_basename( YITH_WCAF_LANG ) );

		require_once YITH_WCAF_INC . 'class-yith-wcaf.php';

		return YITH_WCAF();
	}
}

if ( ! function_exists( 'yith_affiliates_install' ) ) {
	/**
	 * Performs pre-flight basic tests, and then bootstrap plugin
	 *
	 * @return void
	 */
	function yith_affiliates_install() {

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_wcaf_install_woocommerce_admin_notice' );
		} elseif ( defined( 'YITH_WCAF_PREMIUM_INIT' ) ) {
			add_action( 'admin_notices', 'yith_wcaf_show_premium_admin_notice' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
		} else {
			do_action( 'yith_wcaf_init' );
		}
	}
}

if ( ! function_exists( 'yith_wcaf_install_woocommerce_admin_notice' ) ) {
	/**
	 * Show admin notice when WooCommerce is not installed.
	 *
	 * @return void.
	 */
	function yith_wcaf_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p>
				<?php
				// translators: 1. Plugin name.
				echo esc_html( sprintf( __( '%s is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-affiliates' ), 'YITH WooCommerce Affiliates ' ) );
				?>
			</p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'yith_wcaf_show_free_admin_notice' ) ) {
	/**
	 * Show admin notice when premium version is installed
	 *
	 * @return void.
	 */
	function yith_wcaf_show_free_admin_notice() {
		?>
		<div class="error">
			<p>
				<?php
				// translators: 1. Plugin name.
				echo esc_html( sprintf( __( 'You can\'t activate the free version of %s while you are using the premium one.', 'yith-woocommerce-affiliates' ), 'YITH WooCommerce Affiliates' ) );
				?>
			</p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'yith_wcaf_maybe_load_plugin_fw' ) ) {
	/**
	 * Check plugin framework version.
	 *
	 * @return void.
	 */
	function yith_wcaf_maybe_load_plugin_fw() {
		if ( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YITH_WCAF_DIR . 'plugin-fw/init.php' ) ) {
			require_once YITH_WCAF_DIR . 'plugin-fw/init.php';
		}

		yit_maybe_plugin_fw_loader( YITH_WCAF_DIR );

		// activation hook.
		if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
			require_once 'plugin-fw/yit-plugin-registration-hook.php';
		}
		register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );
	}
}

// load plugin-fw.
yith_wcaf_maybe_load_plugin_fw();

// let's start the game.
add_action( 'plugins_loaded', 'yith_affiliates_install', 11 );
add_action( 'yith_wcaf_init', 'yith_affiliates_constructor' );
