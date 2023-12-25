<?php
/**
 * Affiliate Dashboard shortcode
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliate_Dashboard_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Affiliate_Dashboard_Shortcode extends YITH_WCAF_Abstract_Shortcode {

		/**
		 * Current dashboard section
		 *
		 * It matches the endpoint if any; default section is summary
		 * This base class manages summary only; child classes will handle other sections
		 *
		 * @var string
		 */
		protected $section;

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_affiliate_dashboard';
			$this->title       = _x( 'YITH Affiliates Dashboard', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->section     = 'summary';
			$this->template    = "dashboard-{$this->section}.php";
			$this->description = _x( 'Show affiliate dashboard to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
			$this->supports    = array(
				'gutenberg',
				'elementor',
			);
		}

		/**
		 * Returns attributes accepted for current shortcode
		 *
		 * @return array Array of supported attributes.
		 */
		public function get_atts() {
			if ( empty( $this->attributes ) ) {
				$this->attributes = array_merge(
					array(
						'section'              => array(
							'type'      => 'select',
							'label'     => _x( 'Choose section to show', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
							'options'   => array_merge(
								array(
									'' => _x( 'Dynamic', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
								),
								YITH_WCAF_Dashboard::get_dashboard_endpoints()
							),
							'default'   => '',
							'elementor' => true,
							'gutenberg' => true,
						),
						'show_dashboard_links' => array(
							'type'      => 'select',
							'label'     => _x( 'Show navigation menu', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
							'options'   => array(
								'no'  => _x( 'Hide menu', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
								'yes' => _x( 'Show menu', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
							),
							'default'   => 'yes',
							'elementor' => true,
							'gutenberg' => true,
						),
					),
					$this->get_section_atts()
				);
			}

			return $this->attributes;
		}

		/**
		 * Renders shortcode
		 *
		 * @param array  $atts    Array of shortcode attributes.
		 * @param string $content Shortcode content.
		 *
		 * @return string Shortcode content.
		 */
		public function render( $atts = array(), $content = '' ) {
			$current_endpoint = YITH_WCAF_Dashboard::get_current_dashboard_endpoint();
			$current_section  = ! empty( $atts['section'] ) ? $atts['section'] : $current_endpoint;

			$atts = $this->parse_atts( $atts );

			// if user is not an enabled affiliate, show registration form.
			if ( ! YITH_WCAF_Affiliates()->is_user_enabled_affiliate() ) {
				$return = YITH_WCAF_Shortcodes::render( 'yith_wcaf_registration_form', $atts );
			} else {
				// retrieve template variables.
				$dashboard_atts = array(
					'section' => $current_section,
					'atts'    => $atts,
				);

				// retrieve shortcode template.
				ob_start();
				yith_wcaf_get_template( 'dashboard.php', $dashboard_atts, 'shortcodes' );

				$return = ob_get_clean();
			}

			return $return;
		}

		/* === SECTION HANDLING === */

		/**
		 * Renders and returns content for a specific section of the dashboard
		 *
		 * @param array $atts Attributes for the section.
		 *
		 * @return string Section content.
		 */
		public function render_section( $atts = array() ) {
			if ( ! is_user_logged_in() || ! YITH_WCAF_Dashboard()->can_user_see_section( false, $this->section ) ) {
				return '';
			}

			YITH_WCAF_Shortcodes::$is_affiliate_dashboard = true;

			// enqueue required assets.
			$this->enqueue();

			// retrieve shortcode template.
			ob_start();
			yith_wcaf_get_template( $this->template, $this->get_template_atts( $this->parse_atts( $atts ) ), 'shortcodes' );

			$return = ob_get_clean();

			YITH_WCAF_Shortcodes::$is_affiliate_dashboard = false;

			return $return;
		}

		/**
		 * Returns shortcode attributes accepted for current section
		 *
		 * @return array Array of additional shortcode attributes.
		 */
		public function get_section_atts() {
			return array(
				'show_commissions_summary' => array(
					'default' => 'yes',
				),
				'number_of_commissions'    => array(
					'default' => 5,
				),
				'show_clicks_summary'      => array(
					'default' => 'yes',
				),
				'number_of_clicks'         => array(
					'default' => 5,
				),
				'show_referral_stats'      => array(
					'default' => 'yes',
				),
			);
		}

		/**
		 * Filters variable submitted to template, in order to add section-specific values
		 *
		 * @param array $atts General shortcode attributes, as entered for the shortcode, or as default values.
		 *
		 * @return array Array of filtered template variables.
		 */
		public function get_template_atts( $atts ) {
			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			if ( ! $affiliate || ! $affiliate instanceof YITH_WCAF_Affiliate ) {
				return;
			}

			$commissions              = array();
			$show_commissions_summary = 'yes' === $atts['show_commissions_summary'];

			if ( $show_commissions_summary ) {
				$commissions = $affiliate->get_commissions(
					array(
						'status__not_in' => 'trash',
						'order_by'       => 'created_at',
						'order'          => 'DESC',
						'limit'          => $atts['number_of_commissions'],
					)
				);
			}

			$clicks              = array();
			$show_clicks_summary = 'yes' === $atts['show_clicks_summary'] && YITH_WCAF_Clicks()->are_hits_registered();

			if ( $show_clicks_summary ) {
				$clicks = $affiliate->get_clicks(
					array(
						'order_by' => 'click_date',
						'order'    => 'DESC',
						'limit'    => $atts['number_of_clicks'],
					)
				);
			}

			$show_referral_stats = 'yes' === $atts['show_referral_stats'];

			$greeting_message = sprintf(
				// translators: 1. Affiliate formatted name.
				_x( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', '[FRONTEND] No longer in use', 'yith-woocommerce-affiliates' ) . ' ',
				$affiliate->get_formatted_name(),
				wp_logout_url( wc_get_page_permalink( 'myaccount' ) )
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_affiliate_message
			 *
			 * Filters the message shown in the Affiliate Dashboard.
			 *
			 * @param string $message          Message.
			 * @param string $greeting_message Greeting message.
			 */
			$greeting_message .= apply_filters(
				'yith_wcaf_dashboard_affiliate_message',
				sprintf(
					// translators: 1. Link to affiliate settings page.
					_x( 'From your affiliate dashboard you can view your recent commissions and visits, consult your affiliate stats and <a href="%1$s">manage settings</a> for your profile', '[FRONTEND] No longer in use', 'yith-woocommerce-affiliates' ),
					YITH_WCAF_Dashboard()->get_dashboard_url( 'settings' )
				),
				$greeting_message
			);

			return parent::get_template_atts(
				array_merge(
					$atts,
					compact( 'affiliate', 'show_commissions_summary', 'commissions', 'show_clicks_summary', 'clicks', 'show_referral_stats' ),
					// backward compatibility: these attributes are submitted only to support old versions of the templates.
					array(
						'user_id'              => $affiliate->get_user_id(),
						'user'                 => $affiliate->get_user(),
						'affiliate_id'         => $affiliate->get_id(),
						'greeting_message'     => $greeting_message,
						'referral_stats'       => array(
							'earnings'  => $affiliate->get_earnings(),
							'paid'      => $affiliate->get_paid(),
							'balance'   => $affiliate->get_balance(),
							'refunds'   => $affiliate->get_refunds(),
							'click'     => $affiliate->get_clicks_count(),
							'conv_rate' => $affiliate->get_conversion_rate(),
							'rate'      => yith_wcaf_get_rate( $affiliate ),
						),
						'show_dashboard_links' => 'yes' === $atts['show_dashboard_links'],
						'show_right_column'    => 'yes' === $atts['show_dashboard_links'],
						'show_left_column'     => $show_referral_stats,
						'dashboard_links'      => YITH_WCAF_Dashboard()->get_dashboard_navigation_menu(),
					)
				)
			);
		}

		/**
		 * Returns Icon used for Elementor widget
		 *
		 * @return string Icon.
		 */
		protected function get_elementor_icon() {
			return 'eicon-gallery-justified';
		}

		/* === BUILDERS SUPPORT === */

		/**
		 * Performs required tweaks before builder rendering
		 *
		 * @param string $builder   Specific builder.
		 * @param string $shortcode Specific shortcode.
		 */
		protected function do_pre_builder_render_tweaks( $builder, $shortcode ) {
			add_filter( 'yith_wcaf_is_user_enabled_affiliate', '__return_true' );
			add_filter( 'yith_wcaf_can_user_see_section', '__return_true' );
		}

		/* === UTILS === */

		/**
		 * Returns current page for the paginated sections of the dashboard
		 *
		 * @param array $atts Array of attributes submitted for current section.
		 *
		 * @return int Current page (defaults to 1).
		 */
		public function get_current_page( $atts = array() ) {
			$current_page = get_query_var( $this->section );

			if ( ! $current_page ) {
				$current_page = isset( $atts['current_page'] ) ? (int) $atts['current_page'] : 1;
			}

			return $current_page;
		}

		/**
		 * Returns attributes used to paginate items on all sections of the dashboard that contain a listing
		 *
		 * @param array $atts Array of attributes submitted for current section.
		 *
		 * @return array Array of pagination attributes, formatted as follows:
		 * [
		 *     'limit'  => int items per page
		 *     'offset' => int query offset
		 * ]
		 */
		public function get_pagination_atts( $atts = array() ) {
			$current_page = $this->get_current_page( $atts );

			$limit  = isset( $atts['per_page'] ) ? (int) $atts['per_page'] : 10;
			$offset = ( $current_page - 1 ) * $atts['per_page'];

			return compact( 'limit', 'offset' );
		}

		/**
		 * Returns paginate links for current section
		 *
		 * @param int $current Current page number.
		 * @param int $pages   Total number of pages.
		 *
		 * @deprecated Pagination should be handled on YITH_WCAF_Dashboard_Table.
		 *
		 * @return string HTML template of pagination links.
		 */
		public function get_paginate_links( $current, $pages ) {
			return paginate_links(
				array(
					'base'      => YITH_WCAF_Dashboard()->get_dashboard_url( $this->section, '%#%' ),
					'format'    => '%#%',
					'current'   => $current,
					'total'     => $pages,
					'show_all'  => false,
					'prev_next' => true,
				)
			);
		}
	}
}
