<?php
/**
 * Affiliate Dashboard class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Dashboard' ) ) {
	/**
	 * Offer methods related to affiliate dashboard page
	 *
	 * @since 2.0.0
	 */
	abstract class YITH_WCAF_Abstract_Dashboard {

		/**
		 * Temporary store section of the dashboard being shown
		 *
		 * @var string
		 */
		protected static $current_section = '';

		/**
		 * Single instance of the class for each token
		 *
		 * @var \YITH_WCAF_Abstract_Dashboard
		 * @since 2.0.0
		 */
		protected static $instance = null;

		/**
		 * Constructor method
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// dashboard template.
			add_action( 'yith_wcaf_before_dashboard', array( self::class, 'set_current_section' ), 0, 1 );
			add_action( 'yith_wcaf_before_dashboard', array( self::class, 'output_navigation' ), 5, 2 );
			add_action( 'yith_wcaf_before_dashboard', array( self::class, 'output_ban_message' ), 10, 2 );
			add_action( 'yith_wcaf_dashboard_content', array( self::class, 'output_content' ), 10, 2 );
			add_action( 'yith_wcaf_before_dashboard_section', array( self::class, 'output_section_title' ), 5, 2 );
			add_action( 'yith_wcaf_before_dashboard_section', array( self::class, 'output_notices' ), 10, 2 );

			// summary.
			add_action( 'yith_wcaf_dashboard_summary', array( self::class, 'output_affiliate_stats' ), 5, 1 );
			add_action( 'yith_wcaf_dashboard_summary', array( self::class, 'output_affiliate_commissions' ), 10, 1 );
			add_action( 'yith_wcaf_dashboard_summary', array( self::class, 'output_affiliate_clicks' ), 15, 1 );

			// dashboard sections.
			add_action( 'yith_wcaf_social_share_template', array( self::class, 'output_section_share' ), 10, 1 );
			add_action( 'yith_wcaf_after_dashboard_payments_table_options', array( self::class, 'output_withdraw_modal_opener' ) );
			add_action( 'yith_wcaf_before_dashboard_section', array( self::class, 'output_payment_notice' ), 10, 2 );
			add_action( 'yith_wcaf_after_dashboard_section', array( self::class, 'output_withdraw_modal' ), 10, 2 );

			// dashboard overrides.
			add_filter( 'yith_wcaf_payment_email_required', array( self::class, 'maybe_show_payment_email_field' ) );
		}

		/* === ENDPOINTS METHODS === */

		/**
		 * Set current section
		 *
		 * @param string $section Current section.
		 */
		public static function set_current_section( $section ) {
			self::$current_section = $section;
		}

		/**
		 * Returns available endpoints
		 *
		 * @return array Array of available endpoints
		 * @since 1.3.0
		 */
		public static function get_dashboard_endpoints() {
			return YITH_WCAF_Endpoints::get_dashboard_endpoints();
		}

		/**
		 * Return current dashboard endpoint
		 *
		 * @return string|bool Current request endpoint, or false if none set
		 * @since 1.0.0
		 */
		public static function get_current_dashboard_endpoint() {
			if ( self::$current_section ) {
				return self::$current_section;
			}

			return YITH_WCAF_Endpoints::get_current_endpoint();
		}

		/**
		 * Check if current request if for a dashboard endpoint
		 *
		 * @param string $endpoint Endpoint to check.
		 *
		 * @return bool Whether current request if for a dashboard page or not
		 * @since 1.0.0
		 */
		public static function is_dashboard_endpoint( $endpoint = '' ) {
			if ( $endpoint ) {
				return in_array( $endpoint, array_keys( YITH_WCAF_Endpoints::get_dashboard_endpoints() ), true );
			} else {
				return ! ! self::get_current_dashboard_endpoint();
			}
		}

		/**
		 * Checks if endpoint is available for guests
		 *
		 * @param string $endpoint Endpoint to test.
		 * @return bool Whether endpoint is available for guest.
		 */
		public static function is_dashboard_guest_endpoint( $endpoint = '' ) {
			$endpoint = $endpoint ? $endpoint : self::get_current_dashboard_endpoint();

			$guest_endpoints = array(
				'link-generator',
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_is_dashboard_guest_endpoint
			 *
			 * Filters whether the endpont is availabe for guest users.
			 *
			 * @param bool   $is_available Whether endpoint is available for guest users or not.
			 * @param string $endpoint     Endpoint to test.
			 */
			return apply_filters( 'yith_wcaf_is_dashboard_guest_endpoint', in_array( $endpoint, $guest_endpoints, true ), $endpoint );
		}

		/**
		 * Returns rewrite for any given endpoint
		 * Under My Account page, Dashboard endpoints have different rewrite, in order to be subitems of {@see \YITH_WCAF_Dashboard_My_Account::$default_endpoint}
		 *
		 * @param string $endpoint Endpoint key.
		 * @return string Endpoint rewrite
		 */
		public static function get_endpoint_rewrite( $endpoint ) {
			return YITH_WCAF_Endpoints::get_endpoint_rewrite( $endpoint );
		}

		/* === TEMPLATE METHODS === */

		/**
		 * Renders notices currently registered
		 *
		 * @param string $section Section where we're printing navigation (not in use).
		 * @param array  $atts    Array of attributes for current dashboard page (not in use).
		 */
		public static function output_notices( $section = '', $atts = array() ) {
			if ( function_exists( 'wc_print_notices' ) ) {
				wc_print_notices();
			}
		}

		/**
		 * Renders ban message for the affiliate on top of dashboard page
		 *
		 * @param string $section Section where we're printing navigation (not in use).
		 * @param array  $atts    Array of attributes for current dashboard page (not in use).
		 */
		public static function output_ban_message( $section = '', $atts = array() ) {
			$ban_message = YITH_WCAF_Affiliates()->get_user_ban_message();

			if ( $ban_message ) {
				wc_print_notice( nl2br( $ban_message ), 'error' );
			}
		}

		/**
		 * Renders navigation menu for the dashboard
		 *
		 * @param string $section Section where we're printing navigation (not in use).
		 * @param array  $atts    Array of attributes for current dashboard page.
		 */
		public static function output_navigation( $section = '', $atts = array() ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_show_dashboard_links
			 *
			 * Filters whether to show the dashboard links in the Affiliate Dashboard.
			 *
			 * @param bool   $show_dashboard_links Whether to show the dashboard links or not.
			 * @param string $section              Affiliate dashboard section.
			 */
			if ( ! apply_filters( 'yith_wcaf_show_dashboard_links', true, $section ) ) {
				return;
			}

			yith_wcaf_get_template( 'dashboard-navigation.php', $atts, 'shortcodes' );
		}

		/**
		 * Renders title for current Affiliate dashboard section
		 *
		 * @param string $section Section where we're printing navigation (not in use).
		 * @param array  $atts    Array of attributes for current dashboard page.
		 */
		public static function output_section_title( $section, $atts = array() ) {
			$endpoints = YITH_WCAF_Endpoints::get_dashboard_endpoints();

			if ( ! isset( $endpoints[ $section ] ) ) {
				return;
			}

			$atts['title']   = $endpoints[ $section ];
			$atts['section'] = $section;

			yith_wcaf_get_template( 'dashboard-title.php', $atts, 'shortcodes' );
		}

		/**
		 * Renders content of the dashboard
		 *
		 * @param string $section Section where we're printing navigation (not in use).
		 * @param array  $atts    Array of attributes for current dashboard page.
		 */
		public static function output_content( $section = '', $atts = array() ) {
			global $wp;

			$endpoints = self::get_dashboard_endpoints();

			if ( 'generate-link' === $section ) {
				$section_shortcode = YITH_WCAF_Shortcodes::get_instance( 'yith_wcaf_link_generator' );
				$return            = $section_shortcode ? $section_shortcode->render( $atts ) : '';
			} elseif ( $section && array_key_exists( $section, $endpoints ) ) {
				$section_shortcode = YITH_WCAF_Shortcodes::get_instance( "yith_wcaf_show_{$section}" );
				$return            = $section_shortcode ? $section_shortcode->render_section( $atts ) : '';
			} else {
				/**
				 * APPLY_FILTERS: yith_wcaf_custom_dashboard_sections
				 *
				 * Filters the custom sections in the Affiliate Dashboard.
				 *
				 * @param string $custom_sections Custom sections.
				 * @param array  $query_vars      Query vars.
				 * @param array  $atts            Array of attributes.
				 */
				$return = apply_filters( 'yith_wcaf_custom_dashboard_sections', '', $wp->query_vars, $atts );

				if ( ! $return ) {
					$section_shortcode = YITH_WCAF_Shortcodes::get_instance( 'yith_wcaf_affiliate_dashboard' );
					$return            = $section_shortcode ? $section_shortcode->render_section( $atts ) : '';
				}
			}

			echo $return; // phpcs:ignore
		}

		/**
		 * Render withdraw modal
		 *
		 * @param string $section Section where we're printing navigation.
		 * @param array  $atts    Array of attributes for current section.
		 */
		public static function output_withdraw_modal( $section = '', $atts = array() ) {
			// exit if on wrong section.
			if ( 'payments' !== $section ) {
				return;
			}

			// exit if on withdraws are disabled.
			if ( ! class_exists( 'YITH_WCAF_Withdraws' ) || ! YITH_WCAF_Withdraws()->should_show_withdraw_popup() ) {
				return;
			}

			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			$atts = array_merge(
				$atts,
				array(
					'affiliate'         => $affiliate,
					'formatted_profile' => $affiliate->get_formatted_invoice_profile(),
					'max_withdraw'      => round( $affiliate->get_balance(), 2 ),
					'min_withdraw'      => round( YITH_WCAF_Withdraws()->get_minimum_withdraw(), 2 ),
					'require_invoice'   => YITH_WCAF_Invoices()->are_invoices_required(),
					/**
					 * APPLY_FILTERS: yith_wcaf_withdraw_info_panel_additional_notes
					 *
					 * Filters the additional notes in the modal to request a withdraw.
					 *
					 * @param string $notes Additional notes.
					 */
					'modal_notes'       => apply_filters( 'yith_wcaf_withdraw_info_panel_additional_notes', '' ),
				),
				YITH_WCAF_Invoices()->get_options()
			);

			yith_wcaf_get_template( 'withdraw-modal.php', $atts, 'shortcodes/dashboard-payments' );
		}

		/**
		 * Print notice message above payments view, to beter specify payments method/requirements
		 *
		 * @param string $section Section where we're printing navigation.
		 * @param array  $atts    Array of attributes for current section.
		 */
		public static function output_payment_notice( $section = '', $atts = array() ) {
			if ( 'payments' !== $section ) {
				return;
			}

			// retrieve general options.
			$payment_type             = get_option( 'yith_wcaf_payment_type', 'manually' );
			$payment_date             = (int) get_option( 'yith_wcaf_payment_date', 15 );
			$payment_threshold        = (float) get_option( 'yith_wcaf_payment_threshold', 50 );
			$payment_commission_age   = (int) get_option( 'yith_wcaf_payment_commission_age', 15 );
			$pay_only_old_commissions = yith_plugin_fw_is_true( get_option( 'yith_wcaf_payment_pay_only_old_commissions', 'no' ) );

			// retrieve affiliate.
			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			if ( ! $affiliate ) {
				return;
			}

			$message_parts = array();

			// format base message.
			if ( 'let_user_request' === $payment_type ) {
				if ( ! class_exists( 'YITH_WCAF_Withdraws' ) || YITH_WCAF_Withdraws()->should_show_withdraw_popup() ) {
					return;
				}

				if ( ! $affiliate->is_valid() ) {
					$message_parts[] = _x( '<b>Note:</b> you\'ll be able to request your first payment after your application request has been reviewed and approved.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' );
				} elseif ( ! $affiliate->has_unpaid_commissions() ) {
					$message_parts[] = _x( '<b>Note:</b> you\'ll be able to request a payment after your first commission is generated and confirmed.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' );
				} elseif ( $affiliate->has_active_payments() ) {
					$message_parts[] = _x( '<b>Note:</b> you\'ll be able to request a payment after your current pending payment is processed and completed.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' );
				} elseif ( $payment_threshold && $affiliate->get_balance() <= $payment_threshold - 0.01 ) {
					// translators: 1. Minimum balance for withdraw.
					$message_parts[] = sprintf( _x( '<b>Note:</b> you\'ll be able to request a payment as soon as you collect a minimum of <b>%s</b>.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' ), wc_price( $payment_threshold ) );
				}
			} else {
				switch ( $payment_type ) {
					case 'automatically_on_threshold':
						$message_parts[] = sprintf(
						// translators: 1. Minimum balance for payment.
							_x( '<b>Note:</b> commissions will be paid automatically by our system as soon as you collect a minimum of <b>%s</b>.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' ),
							wc_price( $payment_threshold )
						);
						break;
					case 'automatically_on_date':
						$message_parts[] = sprintf(
						// translators: 1.Day of the month for the payment.
							_x( '<b>Note:</b> commissions will be paid automatically by our system every month on day <b>%s</b>.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' ),
							str_pad( (string) $payment_date, 2, '0', STR_PAD_LEFT )
						);
						break;
					case 'automatically_on_both':
						$message_parts[] = sprintf(
						// translators: 1.Day of the month for the payment. 2. Minimum balance for payment.
							_x( '<b>Note:</b> commissions will be paid automatically by our system every month on day <b>%1$s</b> if you have collected a minimum of <b>%2$s</b>.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' ),
							str_pad( (string) $payment_date, 2, '0', STR_PAD_LEFT ),
							wc_price( $payment_threshold )
						);
						break;
					case 'automatically_every_day':
						$message_parts[] = _x( '<b>Note:</b> commissions will be paid automatically by our system <b>every day</b>.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' );
						break;
					case 'manually':
					default:
						$message_parts[] = _x( '<b>Note:</b> commissions will be paid by a manager according to our internal schedule.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' );
						break;
				}

				if ( ! empty( $message_parts ) ) {
					if ( 'manually' !== $payment_type && $pay_only_old_commissions ) {
						$message_parts[] = sprintf(
							// translators: 1. Minimum age required for a commission to be paid (in number of days).
							_nx(
								'Note that our system will only take into account commissions that are older than <b>%d day</b>.',
								'Note that our system will only take into account commissions that are older than <b>%d days</b>.',
								$payment_commission_age,
								'[FRONTEND] Message above payment tab',
								'yith-woocommerce-affiliates'
							),
							$payment_commission_age
						);
					}

					if ( class_exists( 'YITH_WCAF_New_Affiliate_Payment_Email' ) ) {
						$message_parts[] = _x( 'In order to be informed of any new payment issued to your account, make sure you enable the email notification option in <b>Affiliate Dashboard &gt; Settings</b>.', '[FRONTEND] Message above payment tab', 'yith-woocommerce-affiliates' );
					}
				}
			}

			if ( empty( $message_parts ) ) {
				return;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_dashboard_payment_notice
			 *
			 * Filters the payment notice in the Affiliate Dashboard page.
			 *
			 * @param string $payment_notice Payment notice.
			 */
			$message = apply_filters( 'yith_wcaf_affiliate_dashboard_payment_notice', implode( '<br/>', $message_parts ) );

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_dashboard_payment_notice_classes
			 *
			 * Filters the CSS classes for the payment notice in the Affiliate Dashboard page.
			 *
			 * @param array  $classes       CSS classes.
			 * @param array  $message_parts Array with the parts of the message.
			 * @param string $message       Message.
			 */
			$classes = apply_filters( 'yith_wcaf_affiliate_dashboard_payment_notice_classes', array(), $message_parts, $message );

			$atts = array_merge(
				$atts,
				compact( 'message', 'classes' )
			);

			yith_wcaf_get_template( 'notice.php', $atts, 'global' );
		}

		/**
		 * Renders Affiliate stats panel inside Affiliate dashboard summary
		 *
		 * @param array $atts Array of attributes for current dashboard page.
		 */
		public static function output_affiliate_stats( $atts = array() ) {
			yith_wcaf_get_template( 'affiliate-stats.php', $atts, 'shortcodes/dashboard-summary' );
		}

		/**
		 * Renders Affiliate commissions inside Affiliate dashboard summary
		 *
		 * @param array $atts Array of attributes for current dashboard page.
		 */
		public static function output_affiliate_commissions( $atts = array() ) {
			yith_wcaf_get_template( 'affiliate-commissions.php', $atts, 'shortcodes/dashboard-summary' );
		}

		/**
		 * Renders Affiliate clicks inside Affiliate dashboard summary
		 *
		 * @param array $atts Array of attributes for current dashboard page.
		 */
		public static function output_affiliate_clicks( $atts = array() ) {
			yith_wcaf_get_template( 'affiliate-clicks.php', $atts, 'shortcodes/dashboard-summary' );
		}

		/**
		 * Render share section for Link generator page
		 *
		 * @param array $atts Array of attributes for current section.
		 */
		public static function output_section_share( $atts = array() ) {
			if ( empty( $atts['share_enabled'] ) ) {
				return;
			}

			$share_atts = isset( $atts['share_atts'] ) ? $atts['share_atts'] : array();

			yith_wcaf_get_template( 'share.php', $share_atts, 'shortcodes/link-generator' );
		}

		/**
		 * Render withdraw modal opener
		 */
		public static function output_withdraw_modal_opener() {
			if ( ! class_exists( 'YITH_WCAF_Withdraws' ) || ! YITH_WCAF_Withdraws()->should_show_withdraw_popup() ) {
				return;
			}

			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			$atts = array(
				'affiliate' => $affiliate,
			);

			yith_wcaf_get_template( 'withdraw-modal-opener.php', $atts, 'shortcodes/dashboard-payments' );
		}

		/**
		 * Hide payment email from settings fields, when at least one gateway is enabled
		 */
		public static function maybe_show_payment_email_field() {
			$hide = class_exists( 'YITH_WCAF_Gateways' ) && YITH_WCAF_Gateways::is_valid_gateway( 'paypal' );

			return ! $hide;
		}

		/* === PAGE METHODS === */

		/**
		 * Returns dashboard url, optionally for a specific endpoint
		 * Needs to be extended in subclasses.
		 *
		 * @return string!bool Dashboard url
		 */
		abstract public function get_dashboard_base_url();

		/**
		 * Returns id of the Dashboard page
		 * Needs to be extended in subclasses.
		 *
		 * @return int!bool Dashboard page ID
		 */
		abstract public function get_dashboard_page_id();

		/**
		 * Returns true if current page is Affiliate Dashboard page
		 *
		 * @return bool Whether current page is Affiliate Dashboard page
		 * @since 1.2.2
		 */
		abstract public function is_dashboard_page();

		/**
		 * Return affiliate dashboard url
		 *
		 * @param string $endpoint Optional endpoint of the page.
		 * @param string $value    Optional value to pass to the endpoint.
		 *
		 * @return string Dashboard url, or home url if no dashboard page is set
		 * @since 1.0.0
		 */
		public function get_dashboard_url( $endpoint = '', $value = '' ) {
			$permalink = $this->get_dashboard_base_url();
			$rewrite   = $this->get_endpoint_rewrite( $endpoint );

			/**
			 * APPLY_FILTERS: yith_wcaf_use_dashboard_pretty_permalinks
			 *
			 * Filters whether to use pretty urls in the affiliate dashboard pages.
			 *
			 * @param string $permalink_structure Permalink structure.
			 */
			if ( apply_filters( 'yith_wcaf_use_dashboard_pretty_permalinks', get_option( 'permalink_structure' ) ) ) {
				$url = wc_get_endpoint_url( $rewrite, $value, $permalink );
			} else {
				$url = add_query_arg( $endpoint, $value, $permalink );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_get_endpoint_url
			 *
			 * Filters the endpoint url in the affiliate dashboard.
			 *
			 * @param string $url       Endpoint url.
			 * @param string $endpoint  Endpoint key.
			 * @param string $value     Affiliate dashboard url.
			 * @param string $permalink Dashboard base url.
			 */
			return apply_filters( 'yith_wcaf_get_endpoint_url', $url, $endpoint, $value, $permalink );
		}

		/**
		 * Check if user can see a specific section of the Affiliate Dashboard
		 *
		 * @param int|bool $user_id  User id; false to use current user id.
		 * @param string   $endpoint Endpoint.
		 *
		 * @return bool Whether user can see section or not
		 *
		 * @since 1.2.5
		 */
		public function can_user_see_section( $user_id = false, $endpoint = 'summary' ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( ! YITH_WCAF_Affiliates()->is_user_enabled_affiliate( $user_id ) ) {
				$return = self::is_dashboard_guest_endpoint( $endpoint );
			} else {
				$return = true;

				if ( YITH_WCAF_Affiliates()->is_user_banned_affiliate( $user_id ) ) {
					$hide_sections   = yith_plugin_fw_is_true( get_option( 'yith_wcaf_enable_ban_hidden_sections', 'no' ) );
					$hidden_sections = get_option( 'yith_wcaf_ban_hidden_sections' );

					$return = ! $hide_sections || ! in_array( $endpoint, $hidden_sections, true );
				}
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_can_user_see_section
			 *
			 * Filters whether the user can see a specific section in the Affiliate Dashboard.
			 *
			 * @param bool   $can_see  Whether the user can see a specific section or not.
			 * @param int    $user_id  User id.
			 * @param string $endpoint Endpoint.
			 */
			return apply_filters( 'yith_wcaf_can_user_see_section', $return, $user_id, $endpoint );
		}

		/* === DASHBOARD NAVIGATION METHODS === */

		/**
		 * Returns an array with links for all the sections of affiliate dashboard
		 *
		 * @return array
		 */
		public function get_dashboard_links() {
			$endpoints       = self::get_dashboard_endpoints();
			$dashboard_links = array();

			if ( ! empty( $endpoints ) ) {
				foreach ( $endpoints as $endpoint => $label ) {
					$dashboard_links[ $endpoint ] = $this->get_dashboard_url( $endpoint );
				}
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_links
			 *
			 * Filters the links for the sections in the Affiliate Dashboard.
			 *
			 * @param array $dashboard_links Dashboard links.
			 */
			return apply_filters( 'yith_wcaf_dashboard_links', $dashboard_links );
		}

		/**
		 * Return elements to be added to navigation menu
		 *
		 * @return array Array of navigation menu items
		 */
		public function get_dashboard_navigation_menu() {
			$endpoints        = $this->get_dashboard_endpoints();
			$current_endpoint = $this->get_current_dashboard_endpoint();
			$navigation_menu  = array();

			/**
			 * APPLY_FILTERS: yith_wcaf_show_dashboard_link_for_navigation_menu
			 *
			 * Filters whether to show the link to the dashboard section in the Affiliate Dashboard.
			 *
			 * @param bool $show_dashboard_link Whether to show the link to the dashboard section or not.
			 */
			if ( apply_filters( 'yith_wcaf_show_dashboard_link_for_navigation_menu', true ) ) {
				$navigation_menu['summary'] = array(
					'label'  => __( 'Dashboard', 'yith-woocommerce-affiliates' ),
					'url'    => $this->get_dashboard_url(),
					'active' => empty( $current_endpoint ),
				);
			}

			if ( ! empty( $endpoints ) ) {
				foreach ( $endpoints as $endpoint => $label ) {
					if ( ! $this->can_user_see_section( false, $endpoint ) ) {
						continue;
					}

					$navigation_menu[ $endpoint ] = array(
						'label'  => $label,
						'url'    => $this->get_dashboard_url( $endpoint ),
						'active' => $endpoint === $current_endpoint,
					);
				}
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_navigation_menu
			 *
			 * Filters the elements of the navigation menu in the Affiliate Dashboard.
			 *
			 * @param array $navigation_menu Array with elements in the navigation menu.
			 */
			return apply_filters( 'yith_wcaf_dashboard_navigation_menu', $navigation_menu );
		}

		/**
		 * Returns instance of the class to use to handle current Dashboard location
		 *
		 * @return YITH_WCAF_Dashboard|bool
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				$dashboard_location = get_option( 'yith_wcaf_dashboard_location', 'page' );
				$dashboard_class    = 'YITH_WCAF_Dashboard_' . str_replace( '-', '_', $dashboard_location );

				if ( ! class_exists( $dashboard_class ) ) {
					return false;
				}

				self::$instance = new $dashboard_class();
			}

			return self::$instance;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Dashboard class
 *
 * @return \YITH_WCAF_Abstract_Dashboard|bool
 * @since 1.0.0
 */
function YITH_WCAF_Dashboard() { // phpcs:ignore WordPress.NamingConventions
	return YITH_WCAF_Dashboard::get_instance();
}
