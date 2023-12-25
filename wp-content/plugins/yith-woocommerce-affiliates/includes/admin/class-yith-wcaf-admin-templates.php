<?php
/**
 * Offers a set of utility to locate/copy/delete templates from theme's directory
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin_Templates' ) ) {
	/**
	 * Class that manages templates.
	 */
	class YITH_WCAF_Admin_Templates {
		/**
		 * Return path for a specific template inside theme folder
		 *
		 * @param string $template Template to locate.
		 *
		 * @return string Path to template
		 * @since 1.3.0
		 */
		public static function get_theme_file( $template ) {
			return get_stylesheet_directory() . '/' . apply_filters( 'woocommerce_template_directory', 'woocommerce', $template ) . '/yith-wcaf/' . $template;
		}

		/**
		 * Save the templates
		 *
		 * @param string $template_code Template code.
		 * @param string $template_path Template path.
		 *
		 * @since 1.3.0
		 */
		public static function save( $template_code, $template_path ) {
			if ( ! current_user_can( 'edit_themes' ) || empty( $template_code ) || empty( $template_path ) ) {
				return;
			}

			$saved = false;
			$file  = self::get_theme_file( $template_path );
			$code  = wp_unslash( $template_code );

			if ( is_writeable( $file ) ) {
				global $wp_filesystem;

				if ( ! $wp_filesystem ) {
					wp_filesystem();
				}

				$saved = $wp_filesystem->put_contents( $file, $code );
			}

			if ( ! $saved ) {
				?>
				<div class="error">
					<p><?php echo esc_html_x( 'Could not write to template file.', '[ADMIN] Error while copying template to theme directory', 'yith-woocommerce-affiliates' ); ?></p>
				</div>
				<?php
			}

		}

		/**
		 * Move template action.
		 *
		 * @param string $template Template to move.
		 *
		 * @return void
		 * @since 1.3.0
		 */
		public static function copy_to_theme( $template ) {
			if ( ! current_user_can( 'edit_themes' ) || empty( $template ) ) {
				return;
			}

			$theme_file = self::get_theme_file( $template );

			if ( wp_mkdir_p( dirname( $theme_file ) ) && ! file_exists( $theme_file ) ) {

				// Locate template file.
				$template_file = yith_wcaf_locate_template( $template );

				// Copy template file.
				copy( $template_file, $theme_file );

				/**
				 * DO_ACTION: yith_wcaf_copy_template
				 *
				 * Allows to trigger some action after copying email template file.
				 *
				 * @param string $template Template to copy.
				 */
				do_action( 'yith_wcaf_copy_template', $template );

				?>
				<div class="updated">
					<p><?php echo esc_html_x( 'Template file copied to the theme.', '[ADMIN] Success message after copying template to theme directory', 'yith-woocommerce-affiliates' ); ?></p>
				</div>
				<?php
			}
		}

		/**
		 * Delete template action.
		 *
		 * @param string $template Template to delete.
		 *
		 * @return void
		 * @since 1.3.0
		 */
		public static function remove_from_theme( $template ) {
			if ( ! current_user_can( 'edit_themes' ) || empty( $template ) ) {
				return;
			}

			$theme_file = self::get_theme_file( $template );

			if ( file_exists( $theme_file ) ) {
				unlink( $theme_file ); // phpcs:ignore WordPress.VIP.FileSystemWritesDisallow.file_ops_unlink

				/**
				 * DO_ACTION: yith_wcaf_delete_template
				 *
				 * Allows to trigger some action after deleting template file.
				 *
				 * @param string $template Template to delete.
				 */
				do_action( 'yith_wcaf_delete_template', $template );
				?>
				<div class="updated">
					<p><?php echo esc_html_x( 'Template file deleted from the theme.', '[ADMIN] Success message after deleting template from theme directory', 'yith-woocommerce-affiliates' ); ?></p>
				</div>
				<?php
			}
		}
	}
}
