<?php

/**
 * Log file to know more about users website environment. Helps in debugging and providing support.
 *
 * @package WP Headers and Footers
 */

/**
 * Returns the plugin & system information.
 * @param boolean $not_downloadable Check if the request is for downloading.
 * @package WP Headers and Footers
 *
 * @since 2.1.0
 * @return string
 */
if ( ! class_exists( 'WPHeadersAndFooters_Diagnostics_Log' ) ) {

	/**
	 * The WPHeaderAndFooter Settings class
	 */
	class WPHeadersAndFooters_Diagnostics_Log {

		function wp_headers_and_footers_get_sysinfo( $not_downloadable = true ) {

			global $wpdb;
			$html = '';
			// Get the variable from call to check if it is for AJAX.
			if ( $not_downloadable ) {
				$html .= '<div class="wpheaderandfooter-diagnostic-wrapper">';
			}

			$break = $not_downloadable === false ? "\n" : '<br>';

			$html .= '### Begin System Info ###' . $break . $break;

			// Basic site info
			$html .= '-- WordPress Configuration --' . $break . $break;
			$html .= 'Site URL:                 ' . site_url() . $break;
			$html .= 'Home URL:                 ' . home_url() . $break;
			$html .= 'Multisite:                ' . ( is_multisite() ? 'Yes' : 'No' ) . $break;
			$html .= 'Version:                  ' . get_bloginfo( 'version' ) . $break;
			$html .= 'Language:                 ' . get_locale() . $break;
			$html .= 'Table Prefix:             ' . 'Length: ' . strlen( $wpdb->prefix ) . $break;
			$html .= 'WP_DEBUG:                 ' . ( defined( 'WP_DEBUG' ) ? ( WP_DEBUG ? 'Enabled' : 'Disabled' ) : 'Not set' ) . $break;
			$html .= 'Memory Limit:             ' . WP_MEMORY_LIMIT . $break;

			// Plugin Configuration
			$html .= $break . '-- WP Headers and Footers Configuration --' . $break . $break;
			$html .= 'Plugin Version:           ' . WPHEADERANDFOOTER_VERSION . $break;

			// Server Configuration
			$html .= $break . '-- Server Configuration --' . $break . $break;
			$html .= 'Operating System:         ' . php_uname( 's' ) . $break;
			$html .= 'PHP Version:              ' . PHP_VERSION . $break;
			$html .= 'MySQL Version:            ' . $wpdb->db_version() . $break;

			$html .= 'Server Software:          ' . $_SERVER['SERVER_SOFTWARE'] . $break;

			// PHP configs... now we're getting to the important stuff
			$html .= $break . '-- PHP Configuration --' . $break . $break;
			// $html .= 'Safe Mode:                ' . ( ini_get( 'safe_mode' ) ? 'Enabled' : 'Disabled' . $break );
			$html .= 'Memory Limit:             ' . ini_get( 'memory_limit' ) . $break;
			$html .= 'Post Max Size:            ' . ini_get( 'post_max_size' ) . $break;
			$html .= 'Upload Max Filesize:      ' . ini_get( 'upload_max_filesize' ) . $break;
			$html .= 'Time Limit:               ' . ini_get( 'max_execution_time' ) . $break;
			$html .= 'Max Input Vars:           ' . ini_get( 'max_input_vars' ) . $break;
			$html .= 'Display Errors:           ' . ini_get( 'display_errors' ) === 1 ? ini_get( 'display_errors' ) : 'Display Errors: N/A' . $break;

			// WordPress active themes
			$html .= $break . '-- WordPress Active Theme --' . $break . $break;
			$my_theme = wp_get_theme();
			$html .= 'Name:                     ' . $my_theme->get( 'Name' ) . $break;
			$html .= 'URI:                      ' . $my_theme->get( 'ThemeURI' ) . $break;
			$html .= 'Author:                   ' . $my_theme->get( 'Author' ) . $break;
			$html .= 'Version:                  ' . $my_theme->get( 'Version' ) . $break;

			// WordPress active plugins
			$html .= $break . '-- WordPress Active Plugins --' . $break . $break;
			$plugins = get_plugins();
			$active_plugins = get_option( 'active_plugins', array() );
			foreach ( $plugins as $plugin_path => $plugin ) {
				if ( ! in_array( $plugin_path, $active_plugins ) )
					continue;
				$html .= $plugin['Name'] . ': v(' . $plugin['Version'] . ")<br>";
			}

			// WordPress inactive plugins
			$html .= $break . '-- WordPress Inactive Plugins --' . $break . $break;
			foreach ( $plugins as $plugin_path => $plugin ) {
				if ( in_array( $plugin_path, $active_plugins ) ) {
					continue;
				}
				$html .= $plugin['Name'] . ': v(' . $plugin['Version'] . ")<br>";
			}

			if( is_multisite() ) {
				// WordPress Multisite active plugins
				$html .= $break . '-- Network Active Plugins --' . $break . $break;
				$plugins = wp_get_active_network_plugins();
				$active_plugins = get_site_option( 'active_sitewide_plugins', array() );
				foreach ( $plugins as $plugin_path ) {
					$plugin_base = plugin_basename( $plugin_path );
					if ( ! array_key_exists( $plugin_base, $active_plugins ) ) {
						continue;
					}
					$plugin  = get_plugin_data( $plugin_path );
					$html .= $plugin['Name'] . ': v(' . $plugin['Version'] . ")<br>";
				}
			}

			$html .= $break . '### End System Info ###';
			$html .= '</div>';
			if ( $not_downloadable ) {
				$html .= '<div class="wpheaderandfooter-log-download-wrap">';

				$html .= '<input type="button" class="button wpheaderandfooter-log-file" value="' . __( 'Download Log File', 'wp-headers-and-footers' ) . '"/>';
				$html .= '<div class="wpheaderandfooter-log-message">';
				$html .= '<span class="log-file-spinner"><img src="'. admin_url( 'images/wpspin_light.gif' ) .'" /></span>';
				$html .= '<span class="log-file-text">' . __( 'WP Headers and Footers Log File Downloaded Successfully!', 'wp-headers-and-footers' ) . '</span>';
				$html .= '</div>';
				$html .= '</div>';
			}
			return $html;
		}
	}
}
