<?php
/**
 * Utility functions
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'yith_wcaf_locate_template' ) ) {
	/**
	 * Locate template for Affiliate plugin
	 *
	 * @param string $filename Template name (with or without extension).
	 * @param string $section  Subdirectory where to search.
	 *
	 * @return string Found template
	 */
	function yith_wcaf_locate_template( $filename, $section = '' ) {
		$ext = preg_match( '/^.*\.[^\.]+$/', $filename ) ? '' : '.php';

		$template_name = $section . '/' . $filename . $ext;
		$template_path = WC()->template_path() . 'yith-wcaf/';
		$default_path  = YITH_WCAF_DIR . 'templates/';

		if ( defined( 'YITH_WCAF_PREMIUM' ) ) {
			$premium_template = str_replace( '.php', '-premium.php', $template_name );
			$located_premium  = wc_locate_template( $premium_template, $template_path, $default_path );
			$template_name    = file_exists( $located_premium ) ? $premium_template : $template_name;
		}

		return wc_locate_template( $template_name, $template_path, $default_path );
	}
}

if ( ! function_exists( 'yith_wcaf_get_template' ) ) {
	/**
	 * Get template for Affiliate plugin
	 *
	 * @param string $filename Template name (with or without extension).
	 * @param mixed  $atts     Array of params to use in the template.
	 * @param string $section  Subdirectory where to search.
	 */
	function yith_wcaf_get_template( $filename, $atts = array(), $section = '' ) {
		$ext = preg_match( '/^.*\.[^\.]+$/', $filename ) ? '' : '.php';

		$template_name = $section . '/' . $filename . $ext;
		$template_path = WC()->template_path() . 'yith-wcaf/';
		$default_path  = YITH_WCAF_DIR . 'templates/';

		if ( defined( 'YITH_WCAF_PREMIUM' ) ) {
			$premium_template = str_replace( '.php', '-premium.php', $template_name );
			$located_premium  = wc_locate_template( $premium_template, $template_path, $default_path );
			$template_name    = file_exists( $located_premium ) ? $premium_template : $template_name;
		}

		// format args, so to be an array that contains reference to itself.
		$atts = (array) $atts;

		if ( ! isset( $atts['atts'] ) ) {
			$atts['atts'] = $atts;
		}

		wc_get_template( $template_name, $atts, $template_path, $default_path );
	}
}

if ( ! function_exists( 'yith_wcaf_set_cookie' ) ) {
	/**
	 * Set value for a specific cookie
	 *
	 * @param string $cookie_name     Cookie name.
	 * @param string $cookie_value    Cookie value.
	 * @param int    $cookie_duration Cookie duration in seconds.
	 *
	 * @return bool Status of the operation.
	 */
	function yith_wcaf_set_cookie( $cookie_name, $cookie_value, $cookie_duration ) {
		if ( ! $cookie_name ) {
			return false;
		}

		if ( 0 > $cookie_duration ) {
			return yith_wcaf_delete_cookie( $cookie_name );
		}

		return setcookie( $cookie_name, $cookie_value, time() + (int) $cookie_duration, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
	}
}

if ( ! function_exists( 'yith_wcaf_delete_cookie' ) ) {
	/**
	 * Deletes an existing cookie, by setting it with an already expired expiration time
	 *
	 * @param string $cookie_name Cookie name.
	 *
	 * @return bool Status sof the operation.
	 */
	function yith_wcaf_delete_cookie( $cookie_name ) {
		return setcookie( $cookie_name, false, time() - DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
	}
}

if ( ! function_exists( 'yith_wcaf_get_current_affiliate_token' ) ) {
	/**
	 * Returns current affiliate token, if any; otherwise false
	 *
	 * @return string|bool Affiliate token or false
	 * @since 1.0.9
	 */
	function yith_wcaf_get_current_affiliate_token() {
		if ( ! did_action( 'init' ) ) {
			_doing_it_wrong( 'yith_wcaf_get_current_affiliate_token', 'yith_wcaf_get_current_affiliate_token() should be called after init', '1.0.9' );

			return false;
		}

		return YITH_WCAF_Session()->get_token();
	}
}

if ( ! function_exists( 'yith_wcaf_get_current_affiliate' ) ) {
	/**
	 * Returns current affiliate token, if any; otherwise false
	 *
	 * @return string|bool Affiliate token or false
	 * @since 1.0.9
	 */
	function yith_wcaf_get_current_affiliate() {
		if ( ! did_action( 'init' ) ) {
			_doing_it_wrong( 'yith_wcaf_get_current_affiliate', 'yith_wcaf_get_current_affiliate() should be called after init', '1.0.9' );

			return false;
		}

		return YITH_WCAF_Session()->get_affiliate();
	}
}

if ( ! function_exists( 'yith_wcaf_get_current_affiliate_user' ) ) {
	/**
	 * Returns current affiliate token, if any; otherwise false
	 *
	 * @return string|bool Affiliate token or false
	 * @since 1.0.9
	 */
	function yith_wcaf_get_current_affiliate_user() {
		if ( ! did_action( 'init' ) ) {
			_doing_it_wrong( 'yith_wcaf_get_current_affiliate_user', 'yith_wcaf_get_current_affiliate_user() should be called after init', '1.0.9' );

			return false;
		}

		$affiliate = YITH_WCAF_Session()->get_affiliate();

		if ( ! $affiliate ) {
			return false;
		}

		return $affiliate->get_user();
	}
}

if ( ! function_exists( 'yith_wcaf_get_affiliate' ) ) {
	/**
	 * Wrapper for YITH_WCAF_Affiliate_Factory::get_affiliate()
	 *
	 * @param int|string $token Numeric id of textual token of the affiliate to retrieve.
	 *
	 * @return YITH_WCAF_Affiliate|bool Affiliate object, or false on failure
	 */
	function yith_wcaf_get_affiliate( $token ) {
		return YITH_WCAF_Affiliate_Factory::get_affiliate_by_token( $token );
	}
}

if ( ! function_exists( 'yith_wcaf_get_commission' ) ) {
	/**
	 * Wrapper for YITH_WCAF_Commission_Factory::get_commission()
	 *
	 * @param int $id Id of the commission to retrieve.
	 *
	 * @return YITH_WCAF_Commission|bool Commission object, or false on failure
	 */
	function yith_wcaf_get_commission( $id ) {
		return YITH_WCAF_Commission_Factory::get_commission( $id );
	}
}

if ( ! function_exists( 'yith_wcaf_get_rate' ) ) {
	/**
	 * Get rate for an affiliate or a product
	 *
	 * @param int|YITH_WCAF_Affiliate $affiliate Affiliate ID or affiliate object.
	 * @param int|WC_Product          $product   Product id or product object.
	 * @param int|WC_Order            $order     Order id or order object.
	 *
	 * @return float Rate (product specific rate, if any; otherwise, affiliate specific rate, if any; otherwise, general rate)
	 */
	function yith_wcaf_get_rate( $affiliate = false, $product = false, $order = false ) {
		$rate_handler = class_exists( 'YITH_WCAF_Rate_Handler_Premium' ) ? 'YITH_WCAF_Rate_Handler_Premium' : 'YITH_WCAF_Rate_Handler';

		return $rate_handler::get_rate( $affiliate, $product, $order );
	}
}

if ( ! function_exists( 'yith_wcaf_get_formatted_rate' ) ) {
	/**
	 * Returns rate formatted for display purposes
	 *
	 * @param int|YITH_WCAF_Affiliate $affiliate Affiliate ID or affiliate object.
	 * @param int!WC_Product          $product   Product id or product object.
	 * @param int|WC_Order            $order     Order id or order object.
	 *
	 * @return string Formatted rate
	 */
	function yith_wcaf_get_formatted_rate( $affiliate = false, $product = false, $order = false ) {
		$rate_handler = class_exists( 'YITH_WCAF_Rate_Handler_Premium' ) ? 'YITH_WCAF_Rate_Handler_Premium' : 'YITH_WCAF_Rate_Handler';

		return $rate_handler::get_formatted_rate( $affiliate, $product, $order );
	}
}

if ( ! function_exists( 'yith_wcaf_is_affiliate_dashboard_page' ) ) {
	/**
	 * Returns true if current page is Affiliate Dashboard page
	 *
	 * @return bool Whether current page is Affiliate Dashboard page
	 * @since 1.2.2
	 */
	function yith_wcaf_is_affiliate_dashboard_page() {
		return YITH_WCAF_Dashboard()->is_dashboard_page();
	}
}

if ( ! function_exists( 'yith_wcaf_is_affiliate_dashboard_shortcode' ) ) {
	/**
	 * Returns true while printing affiliate dashboard shortcode
	 *
	 * @return bool Whether we're currently printing affiliates dashboard shortcode
	 * @since 1.2.2
	 */
	function yith_wcaf_is_affiliate_dashboard_shortcode() {
		return YITH_WCAF_Shortcodes::$is_affiliate_dashboard;
	}
}

if ( ! function_exists( 'yith_wcaf_delete_order_data' ) ) {
	/**
	 * Delete all plugin data from the order
	 *
	 * @param int $order_id    Order id.
	 * @param int $delete_mask Bool mask.
	 *
	 * @deprecated 2.0.0
	 *
	 * @return void
	 * @since 1.1.1
	 */
	function yith_wcaf_delete_order_data( $order_id, $delete_mask = 0b10001111 ) {
		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			return;
		}

		// removes token.
		if ( $delete_mask & 128 ) {
			$order->delete_meta_data( '_yith_wcaf_referral' );
		}

		// removes token history.
		if ( $delete_mask & 64 ) {
			$order->delete_meta_data( '_yith_wcaf_referral_history' );
		}

		// removes click ID.
		if ( $delete_mask & 32 ) {
			$order->delete_meta_data( '_yith_wcaf_click_id' );
		}

		// removes conversion registered meta.
		if ( $delete_mask & 16 ) {
			$order->delete_meta_data( '_yith_wcaf_conversion_registered' );
		}

		// removes refunded commissions meta.
		if ( $delete_mask & 8 ) {
			$order->delete_meta_data( '_refunded_commissions' );
		}

		// removes order item meta.
		$items = $order->get_items();

		if ( ! $items ) {
			return;
		}

		foreach ( $items as $item_id => $item ) {
			// removes commission id.
			if ( $delete_mask & 4 ) {
				$item->delete_meta_data( '_yith_wcaf_commission_id' );
			}

			// removes commission rate.
			if ( $delete_mask & 2 ) {
				$item->delete_meta_data( '_yith_wcaf_commission_rate' );
			}

			// removes commission amount.
			if ( $delete_mask & 1 ) {
				$item->delete_meta_data( '_yith_wcaf_commission_amount' );
			}

			$item->save();
		}

		$order->save();
	}
}

if ( ! function_exists( 'yith_wcaf_get_promote_methods' ) ) {
	/**
	 * Return promotional methods options, available for the site
	 * Set can be filtered to add or remove items
	 *
	 * @return array Promotional methods available
	 * @since 1.2.5
	 */
	function yith_wcaf_get_promote_methods() {
		/**
		 * APPLY_FILTERS: yith_wcaf_how_promote_methods
		 *
		 * Filters the promotional methods options.
		 *
		 * @param array $promotional_methods Array of "How to promote" method options.
		 */
		return apply_filters(
			'yith_wcaf_how_promote_methods',
			array(
				'website'    => _x( 'Website / Blog', '[FRONTEND] Promotional methods', 'yith-woocommerce-affiliates' ),
				'newsletter' => _x( 'Newsletter / Email Marketing', '[FRONTEND] Promotional methods', 'yith-woocommerce-affiliates' ),
				'socials'    => _x( 'Social media', '[FRONTEND] Promotional methods', 'yith-woocommerce-affiliates' ),
				'others'     => _x( 'Others', '[FRONTEND] Promotional methods', 'yith-woocommerce-affiliates' ),
			)
		);
	}
}

if ( ! function_exists( 'yith_wcaf_append_items' ) ) {
	/**
	 * Adds items inside set array, placing them after the item with the index specified
	 *
	 * @param array  $set      Array where we need to add items.
	 * @param string $index    Index we need to search inside $set.
	 * @param mixed  $items    Items that we need to add to $set.
	 * @param string $position Where to place the additional set of items.
	 *
	 * @return array Array with new items
	 * @since 1.2.5
	 */
	function yith_wcaf_append_items( $set, $index, $items, $position = 'after' ) {
		$index_position = array_search( $index, array_keys( $set ), true );

		if ( $index_position < 0 ) {
			return $set;
		}

		if ( 'after' === $position ) {
			$pivot_position = $index_position + 1;
		} else {
			$pivot_position = $index_position;
		}

		$settings_options_chunk_1 = array_slice( $set, 0, $pivot_position );
		$settings_options_chunk_2 = array_slice( $set, $pivot_position, count( $set ) );

		return array_merge(
			$settings_options_chunk_1,
			$items,
			$settings_options_chunk_2
		);
	}
}

if ( ! function_exists( 'yith_wcaf_number_format' ) ) {
	/**
	 * Allow to override default format provide by number_format function
	 *
	 * @param float $value    The number being formatted.
	 * @param int   $decimals Sets the number of decimal points.
	 *
	 * @return string formatted
	 * @since 1.7.9
	 */
	function yith_wcaf_number_format( $value, $decimals = 2 ) {
		/**
		 * APPLY_FILTERS: yith_wcaf_dec_point
		 *
		 * Filters the decimal separator.
		 *
		 * @param string $decimal_separator Decimal separator.
		 */
		$dec_point = apply_filters( 'yith_wcaf_dec_point', '.' );

		/**
		 * APPLY_FILTERS: yith_wcaf_thousands_sep
		 *
		 * Filters the thousands separator.
		 *
		 * @param string $thousands_separator Thousands separator.
		 */
		$thousands_sep = apply_filters( 'yith_wcaf_thousands_sep', ',' );
		$decimals      = floor( $value ) !== (float) $value ? $decimals : 0;

		return number_format( $value, $decimals, $dec_point, $thousands_sep );

	}
}

if ( ! function_exists( 'yith_wcaf_rate_format' ) ) {
	/**
	 * Returns rate formatted for display purposes
	 *
	 * @param float $rate     The number being formatted.
	 * @param int   $decimals Sets the number of decimal points.
	 *
	 * @return string formatted
	 * @since 1.7.9
	 */
	function yith_wcaf_rate_format( $rate, $decimals = 2 ) {
		/**
		 * APPLY_FILTERS: yith_wcaf_rate_symbol
		 *
		 * Filters the rate symbol.
		 *
		 * @param string $rate_symbol Rate symbol.
		 */
		$symbol = apply_filters( 'yith_wcaf_rate_symbol', '%' );
		$number = yith_wcaf_number_format( $rate, $decimals );

		/**
		 * APPLY_FILTERS: yith_wcaf_rate_format
		 *
		 * Filters the rate format.
		 *
		 * @param string $rate_format Rate format.
		 */
		return sprintf( apply_filters( 'yith_wcaf_rate_format', '%1$s%2$s' ), $number, $symbol );

	}
}

if ( ! function_exists( 'yith_wcaf_date_format' ) ) {
	/**
	 * Accepts any date that ca be successfully passed to {@see strtotime} and converts it to current date_format
	 * Returns an array containing formatted date and a format string that describes currently applied format for jQuery extensions
	 *
	 * This function is especially useful when we need to print a datepicker input: it will require a formatted default date,
	 * and a format to pass to jQuery script, in order to format all picked dates the same as the default one.
	 *
	 * @param  string $date Date in a format accepted by {@see strtotime}.
	 *
	 * @return array An array formatted as follows:
	 * [
	 *     'date'   => 'Jan 01, 2022',
	 *     'format' => 'M dd, yy',
	 * ]
	 */
	function yith_wcaf_js_date_format( $date ) {
		$date_format = wc_date_format();
		$format      = yith_wcaf_convert_jquery_date_format( $date_format, YITH_WCAF_CONVERT_DATE_PHP_TO_JQUERY );
		$date        = $date ? date_i18n( $date_format, strtotime( $date ) ) : '';

		return compact( 'date', 'format' );
	}
}

if ( ! function_exists( 'yith_wcaf_jquery_to_php_date_format' ) ) {
	/**
	 * Define flags to use in $flags field of \yith_wcaf_convert_jquery_date_format function.
	 */
	! defined( 'YITH_WCAF_CONVERT_DATE_PHP_TO_JQUERY' ) && define( 'YITH_WCAF_CONVERT_DATE_PHP_TO_JQUERY', 0 );
	! defined( 'YITH_WCAF_CONVERT_DATE_JQUERY_TO_PHP' ) && define( 'YITH_WCAF_CONVERT_DATE_JQUERY_TO_PHP', 1 );

	/**
	 * Converts date format from PHP to jQuery or vice versa
	 *
	 * @param string $format Format to convert.
	 * @param int    $mode   Mode for conversion (falsy => PHP -> jQuery; truthy => jQuery -> PHP).
	 *
	 * @return string Converted date format.
	 */
	function yith_wcaf_convert_jquery_date_format( $format, $mode = YITH_WCAF_CONVERT_DATE_JQUERY_TO_PHP ) {
		$replacements = array(
			'dd' => 'd',
			'd'  => 'j',
			'oo' => 'z',
			'o'  => 'z',
			'DD' => 'l',
			'mm' => 'm',
			'm'  => 'n',
			'MM' => 'F',
			'yy' => 'Y',
			'@'  => 'U',
		);

		$search  = $mode ? array_keys( $replacements ) : array_values( $replacements );
		$replace = $mode ? array_values( $replacements ) : array_keys( $replacements );

		return str_replace( $search, $replace, $format );
	}
}

if ( ! function_exists( 'yith_wcaf_secs_to_duration' ) ) {
	/**
	 * Converts a number of seconds to a duration array [ 'unit' => 'min', 'amount' => 5 ]
	 *
	 * @param mixed $secs Number of seconds to convert.
	 *                    If parameter is already in duration format, function will just return it; otherwise, it will be converted to int and processed.
	 * @return array Array of duration that best approximate number of seconds passed as first parameter.
	 */
	function yith_wcaf_secs_to_duration( $secs ) {
		// if already in duration format, let's return it.
		if ( is_array( $secs ) && isset( $secs['unit'] ) && isset( $secs['amount'] ) ) {
			return $secs;
		}

		// first of all, let's convert value to integer.
		$secs = (int) $secs;

		// then let's try to approximate closest unit.
		$units = array(
			'sec'   => 1,
			'mim'   => MINUTE_IN_SECONDS,
			'hour'  => HOUR_IN_SECONDS,
			'day'   => DAY_IN_SECONDS,
			'week'  => WEEK_IN_SECONDS,
			'month' => MONTH_IN_SECONDS,
		);
		$keys  = array_keys( $units );
		$pivot = array_shift( $keys );

		do {
			$unit  = $pivot;
			$pivot = array_shift( $keys );
		} while ( isset( $units[ $pivot ] ) && $secs > $units[ $pivot ] );

		// once we have the unit, let's calculate the integer amount of units that best fits current value.
		$amount = round( $secs / $units[ $unit ] );

		// finally return duration array.
		return compact( 'unit', 'amount' );
	}
}

if ( ! function_exists( 'yith_wcaf_duration_to_sec' ) ) {
	/**
	 * Converts a duration array [ 'unit' => 'min', 'amount' => 5 ] to equivalent number of seconds
	 *
	 * @param mixed $duration Duration to convert. If value is int, it will be returned; if not in duration format system will try to convert to duration and then process it.
	 * @return int Number of seconds equivalent to passed duration.
	 */
	function yith_wcaf_duration_to_secs( $duration ) {
		// if already in seconds format, let's return it.
		if ( is_int( $duration ) ) {
			return $duration;
		}

		// if not in duration format, try to convert it.
		if ( ! is_array( $duration ) || ! isset( $duration['unit'] ) || ! isset( $duration['amount'] ) ) {
			$duration = yith_wcaf_secs_to_duration( $duration );
		}

		// if still not in duration format, return 0.
		if ( ! is_array( $duration ) || ! isset( $duration['unit'] ) || ! isset( $duration['amount'] ) ) {
			return 0;
		}

		$units = array(
			'sec'   => 1,
			'mim'   => MINUTE_IN_SECONDS,
			'hour'  => HOUR_IN_SECONDS,
			'day'   => DAY_IN_SECONDS,
			'week'  => WEEK_IN_SECONDS,
			'month' => MONTH_IN_SECONDS,
		);
		$unit  = isset( $units[ $duration['unit'] ] ) ? $units[ $duration['unit'] ] : MINUTE_IN_SECONDS;

		return (int) $unit * $duration['amount'];
	}
}

if ( ! function_exists( 'yith_wcaf_parse_settings' ) ) {
	/**
	 * Define flags to use in $flags field of \yith_wcaf_parse_settings function.
	 */
	! defined( 'YITH_WCAF_PARSE_SETTINGS_IGNORE_REQUIRED' ) && define( 'YITH_WCAF_PARSE_SETTINGS_IGNORE_REQUIRED', 1 );
	! defined( 'YITH_WCAF_PARSE_SETTINGS_SANITIZE_ONLY' ) && define( 'YITH_WCAF_PARSE_SETTINGS_SANITIZE_ONLY', 2 );

	/**
	 * Matches a set of posted values, against a data structure describing available options
	 * It returns sanitized values, or throws an error when one setting doesn't match requirements
	 *
	 * @param array $posted   An array of posted, un-sanitized, values.
	 * @param array $settings Data structure describing the setting to match; EG:
	 * [
	 *     'setting_1' => [
	 *         'label' => 'first_name',
	 *         'type'  => 'text',
	 *         'options' => array(
	 *             'option_1' => 'value 1',
	 *             'option_2' => 'value 2'
	 *          ),
	 *          'required' => false,
	 *          'default' => false,
	 *     ],
	 *     ...
	 * ].
	 * @param int   $flags    Bitmask for function options; accepts following values:
	 * * YITH_WCAF_PARSE_SETTINGS_IGNORE_REQUIRED => 0
	 * * YITH_WCAF_PARSE_SETTINGS_SANITIZE_ONLY = 2.
	 *
	 * @return array Array of sanitized options.
	 * @throws Exception When an error occurs with validation.
	 */
	function yith_wcaf_parse_settings( $posted, $settings, $flags = false ) {
		$validated_options = array();

		// process options.
		$ignore_required = false !== $flags && $flags & YITH_WCAF_PARSE_SETTINGS_IGNORE_REQUIRED;
		$sanitize_only   = false !== $flags && $flags & YITH_WCAF_PARSE_SETTINGS_SANITIZE_ONLY;

		foreach ( $settings as $setting_id => $setting ) {
			$value = isset( $posted[ $setting_id ] ) ? $posted[ $setting_id ] : false;

			// if setting has sub-settings, process those recursively.
			$has_sub_settings = ! empty( $setting ) && is_array( current( $setting ) );

			if ( $has_sub_settings ) {
				$validated_options[ $setting_id ] = yith_wcaf_parse_settings( $value, $setting, $flags );
			} else {
				list( $type, $required, $default, $options, $deps ) = yith_plugin_fw_extract( $setting, 'type', 'required', 'default', 'options', 'deps' );

				if ( ! $type ) {
					$type = 'text';
				}

				if ( ! $options ) {
					$options = array();
				}

				$label = isset( $setting['label'] ) ? $setting['label'] : $setting_id;

				if ( in_array( $type, array( 'checkbox', 'onoff' ), true ) ) {
					$value = (int) yith_plugin_fw_is_true( $value );
				} elseif ( in_array( $type, array( 'select', 'radio' ), true ) && ! empty( $options ) && $value && ! array_key_exists( $value, $options ) ) {
					$value = false;

					if ( ! $value && ! $sanitize_only ) {
						// translators: 1. Label of the required field missing.
						throw new Exception( sprintf( _x( 'Please, choose a valid option for %s', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
					}
				} elseif ( 'email' === $type && $value ) {
					$value = filter_var( $value, FILTER_VALIDATE_EMAIL );

					if ( ! $value && ! $sanitize_only ) {
						// translators: 1. Label of the required field missing.
						throw new Exception( sprintf( _x( 'Please, provide a valid email address for %s', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
					}
				} elseif ( 'number' === $type && $value && ! is_numeric( $value ) ) {
					$value = false;

					if ( ! $value && ! $sanitize_only ) {
						// translators: 1. Label of the required field missing.
						throw new Exception( sprintf( _x( 'Please, provide a valid value for %s', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
					}
				} elseif ( 'textarea' === $type && $value ) {
					$value = sanitize_textarea_field( wp_unslash( $value ) );
				} elseif ( $value ) {
					$value = sanitize_text_field( wp_unslash( $value ) );
				} elseif ( ! empty( $default ) ) {
					$value = $default;
				} else {
					$value = false;
				}

				if ( isset( $setting['validation'] ) ) {
					switch ( $setting['validation'] ) {
						case 'email':
							$value = sanitize_email( $value );

							if ( ! is_email( $value ) && ! $sanitize_only ) {
								// translators: 1. Label of the required field missing.
								throw new Exception( sprintf( _x( 'Please, make sure to enter a valid email address for %s', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
							}
							break;
						case 'tel':
							if ( ! WC_Validation::is_phone( $value ) && ! $sanitize_only ) {
								// translators: 1. Label of the required field missing.
								throw new Exception( sprintf( _x( 'Please, make sure to enter a valid phone number for %s', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
							}
							break;
						case 'url':
							$value = filter_var( $value, FILTER_SANITIZE_URL );

							if ( ! $value && ! $sanitize_only ) {
								// translators: 1. Label of the required field missing.
								throw new Exception( sprintf( _x( 'Please, make sure to enter a valid URL address for %s', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
							}
					}
				}

				// if field has some dependency, make sure that is matched before requiring it.
				if ( ! empty( $deps ) ) {
					list( $dep_id, $dep_value ) = yith_plugin_fw_extract( $deps, 'id', 'value' );

					$required = $required && isset( $posted[ $dep_id ] ) && in_array( $posted[ $dep_id ], (array) $dep_value, true );
				}

				if ( ! empty( $required ) && ! $value && ! $ignore_required && ! $sanitize_only ) {
					// translators: 1. Label of the required field missing.
					throw new Exception( sprintf( _x( '%s is a required field', '[GLOBAL] Error message thrown when settings validation fails', 'yith-woocommerce-affiliates' ), $label ) );
				}

				$validated_options[ $setting_id ] = $value;
			}
		}

		return $validated_options;
	}
}

if ( ! function_exists( 'yith_wcaf_log' ) ) {
	/**
	 * Logs a message in global log file
	 *
	 * @param string $message Message to log.
	 * @param string $level   One of the following:
	 *     'emergency': System is unusable.
	 *     'alert': Action must be taken immediately.
	 *     'critical': Critical conditions.
	 *     'error': Error conditions.
	 *     'warning': Warning conditions.
	 *     'notice': Normal but significant condition.
	 *     'info': Informational messages.
	 *     'debug': Debug-level messages.
	 *
	 * @return void
	 * @since 2.0.0
	 */
	function yith_wcaf_log( $message, $level = 'info' ) {
		static $logger;

		if ( ! $logger ) {
			$logger = wc_get_logger();
		}

		if ( ! $logger ) {
			return;
		}

		$logger->log( $level, $message, array( 'source' => 'yith_wcaf' ) );
	}
}
