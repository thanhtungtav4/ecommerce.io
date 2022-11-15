<?php
/**
 * Main class
 *
 * @author  YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF' ) ) {
	/**
	 * WooCommerce Affiliates
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF {

		/**
		 * Plugin version
		 *
		 * @const string
		 * @since 2.0.0
		 */
		const VERSION = '2.8.0';

		/**
		 * Plugin version
		 *
		 * @deprecated
		 * @const string
		 * @since 1.0.0
		 */
		const YITH_WCAF_VERSION = self::VERSION;

		/**
		 * Plugin DB version
		 *
		 * @const string
		 * @since 1.0.0
		 */
		const DB_VERSION = '2.2.0';

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCAF
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Constructor.
		 *
		 * @return \YITH_WCAF
		 * @since 1.0.0
		 */
		public function __construct() {
			/**
			 * DO_ACTION: yith_wcaf_startup
			 *
			 * Allows to trigger some action when initializing the plugin.
			 */
			do_action( 'yith_wcaf_startup' );

			// start by requiring and initializing dependencies.
			$this->install();

			// load plugin-fw.
			add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );
			add_action( 'plugins_loaded', array( $this, 'privacy_loader' ), 20 );

			// enqueue frontend scripts.
			add_action( 'init', array( $this, 'register_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Register frontend scripts
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function register_scripts() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// register fontello fonts (social share icons).
			wp_register_style( 'yith-wcaf-fontello', YITH_WCAF_URL . 'assets/css/fontello/fontello.css', array(), self::VERSION );

			// register plugin style.
			wp_register_style( 'yith-wcaf', YITH_WCAF_URL . "assets/css/yith-wcaf{$suffix}.css", array( 'select2' ), self::VERSION );

			// register selectWoo if missing.
			if ( ! wp_script_is( 'selectWoo', 'registered' ) ) {
				wp_register_script( 'selectWoo', plugins_url( "assets/js/selectWoo/selectWoo.full{$suffix}.js", WC_PLUGIN_FILE ), array( 'jquery' ), WC_VERSION, true );
			}

			// register country select, if missing.
			if ( ! wp_script_is( 'wc-country-select', 'registered' ) ) {
				wp_register_script( 'wc-country-select', plugins_url( "assets/js/frontend/country-select{$suffix}.js", WC_PLUGIN_FILE ), array( 'jquery' ), WC_VERSION, true );
			}

			// register plugin script.
			wp_register_script( 'yith-wcaf-shortcodes', YITH_WCAF_URL . "assets/js/yith-wcaf-shortcodes.bundle{$suffix}.js", array( 'jquery', 'jquery-blockui', 'jquery-ui-datepicker', 'selectWoo', 'wc-country-select' ), self::VERSION, true );

			/**
			 * DO_ACTION: yith_wcaf_scripts_registered
			 *
			 * Allows to trigger some action when the plugin scripts are registered.
			 */
			do_action( 'yith_wcaf_scripts_registered' );
		}

		/**
		 * Enqueue frontend scripts
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {
			global $wp, $post;

			/**
			 * DO_ACTION: yith_wcaf_before_style_enqueue
			 *
			 * Allows to trigger some actions before enqueueing the plugin styles.
			 */
			do_action( 'yith_wcaf_before_style_enqueue' );
			wp_enqueue_style( 'yith-wcaf' );

			/**
			 * Only enqueues Fontello stylesheet when on generate-link endpoint, or when page contains link_generator shortcode
			 *
			 * @since 1.6.5
			 */
			/**
			 * APPLY_FILTERS: yith_wcaf_enqueue_fontello_stylesheet
			 *
			 * Allow to filter posts where fontello stylesheet should be loaded; by default file will be loaded only on pages containing [yith_wcaf_link_generator] shortcode.
			 *
			 * @param bool    $should_include Whether stylesheet should be enqueued.
			 * @param WP_Post $post           Global post.
			 * @param WP      $wp             Global wp.
			 */
			if ( isset( $wp->query_vars['generate-link'] ) || apply_filters( 'yith_wcaf_enqueue_fontello_stylesheet', ( $post instanceof WP_Post && strpos( $post->post_content, '[yith_wcaf_link_generator' ) !== false ), $post, $wp ) ) {
				wp_enqueue_style( 'yith-wcaf-fontello' );
			}

			/**
			 * DO_ACTION: yith_wcaf_before_script_enqueue
			 *
			 * Allows to trigger some actions before enqueueing the plugin scripts.
			 */
			do_action( 'yith_wcaf_before_script_enqueue' );

			wp_enqueue_script( 'yith-wcaf-shortcodes' );
			wp_localize_script( 'yith-wcaf-shortcodes', 'yith_wcaf', $this->get_localize() );
		}

		/**
		 * Returns localize array for main plugin script
		 *
		 * @return array Object to localize.
		 * @since 2.0.0
		 */
		public function get_localize() {
			/**
			 * APPLY_FILTERS: yith_wcaf_global_localize
			 *
			 * Filters the array with the data needed for the main plugin script.
			 *
			 * @param array $localize_data Array with data for main script.
			 */
			return apply_filters(
				'yith_wcaf_global_localize',
				array(
					'labels'              => array(
						'link_copied_message'  => _x( 'URL copied', '[GLOBAL] After copy message', 'yith-woocommerce-affiliates' ),
						'toggle_on'            => _x( 'ON', '[FRONTEND] Toggle fields text', 'yith-woocommerce-affiliates' ),
						'toggle_off'           => _x( 'OFF', '[FRONTEND] Toggle fields text', 'yith-woocommerce-affiliates' ),
						'withdraw_modal_title' => _x( 'Request withdrawal', '[FRONTEND] Withdraw modal', 'yith-woocommerce-affiliates' ),
						'errors'               => array(
							'accept_check'  => _x( 'Please, accept this condition', '[GLOBAL] Form validation error', 'yith-woocommerce-affiliates' ),
							'compile_field' => _x( 'Please, complete this field', '[GLOBAL] Form validation error', 'yith-woocommerce-affiliates' ),
						),
					),
					'nonces'              => array(
						'get_referral_url' => wp_create_nonce( 'get_referral_url' ),
						'set_referrer'     => wp_create_nonce( 'set_referrer' ),
					),
					'ajax_url'            => admin_url( 'admin-ajax.php' ),
					'set_cookie_via_ajax' => 'yes' === get_option( 'yith_wcaf_referral_cookie_ajax_set', 'no' ),
					'referral_var'        => YITH_WCAF_Session()->get_ref_name(),
				)
			);
		}

		/* === PLUGIN FW LOADER === */

		/**
		 * Loads plugin fw, if not yet created
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				global $plugin_fw_data;
				if ( ! empty( $plugin_fw_data ) ) {
					$plugin_fw_file = array_shift( $plugin_fw_data );
					require_once $plugin_fw_file;
				}
			}
		}

		/* === PRIVACY LOADER === */

		/**
		 * Loads privacy class
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function privacy_loader() {
			if ( class_exists( 'YITH_Privacy_Plugin_Abstract' ) ) {
				new YITH_WCAF_Privacy();
			}
		}

		/* === INSTALL METHODS === */

		/**
		 * Execute plugin installation
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function install() {
			$this->require();

			add_action( 'init', array( $this, 'init' ), 5 );
		}

		/**
		 * Require file used by the plugin
		 *
		 * @return void.
		 */
		public function require() {
			require_once YITH_WCAF_INC . 'class-yith-wcaf-autoloader.php';
			require_once YITH_WCAF_INC . 'functions-yith-wcaf.php';
		}

		/**
		 * Startup plugin
		 *
		 * @return void
		 */
		public function init() {
			// do startup operations.
			YITH_WCAF_Install::init();
			YITH_WCAF_Instance::init();
			YITH_WCAF_Endpoints::init();
			YITH_WCAF_Gateways::init();
			YITH_WCAF_Shortcodes::init();
			YITH_WCAF_Form_Handler::init();
			YITH_WCAF_Ajax_Handler::init();
			YITH_WCAF_Crons_Handler::init();
			YITH_WCAF_Affiliates_Profile::init();
			YITH_WCAF_Rate_Handler::get_default();

			// init required objects.
			$this->init_instances();

			// init legacy classes.
			$this->init_legacy();

			do_action( 'yith_wcaf_standby' );
		}

		/**
		 * Startup plugin's objects
		 *
		 * @return void
		 */
		public function init_instances() {
			// init objects' instances.
			YITH_WCAF_Affiliates::get_instance();
			YITH_WCAF_Clicks::get_instance();
			YITH_WCAF_Commissions::get_instance();
			YITH_WCAF_Payments::get_instance();
			YITH_WCAF_Session::get_instance();
			YITH_WCAF_Orders::get_instance();
			YITH_WCAF_Checkout::get_instance();
			YITH_WCAF_Dashboard::get_instance();

			if ( is_admin() ) {
				YITH_WCAF_Admin::get_instance();
			}
		}

		/**
		 * Init legacy classes to make them available to any code that may still make use of them
		 *
		 * @return void
		 */
		public function init_legacy() {
			// init legacy actions and hooks.
			new YITH_WCAF_Hooks_Legacy();

			// makes legacy classes and functions available for any code that may refer them.
			spl_autoload_call( 'YITH_WCAF_Affiliate_Legacy' );
			spl_autoload_call( 'YITH_WCAF_Affiliates_Legacy' );
			spl_autoload_call( 'YITH_WCAF_Clicks_Legacy' );
			spl_autoload_call( 'YITH_WCAF_Commissions_Legacy' );
			spl_autoload_call( 'YITH_WCAF_Coupons_Legacy' );
			spl_autoload_call( 'YITH_WCAF_Payments_Legacy' );
			spl_autoload_call( 'YITH_WCAF_Rate_Handler_Legacy' );
		}

		/* === HELPER METHODS === */

		/**
		 * Check if current request if for a dashboard page
		 *
		 * @param string $endpoint Endpoint to check.
		 *
		 * @return bool Whether current request if for a dashboard page or not
		 * @since 1.0.0
		 * @deprecated 2.0.0
		 */
		public function is_dashboard_url( $endpoint = '' ) {
			_deprecated_function( '\YITH_WCAF::is_dashboard_url', '2.0.0', 'YITH_WCAF_Dashboard()->is_dashboard_url' );

			return YITH_WCAF_Dashboard::is_dashboard_endpoint( $endpoint );
		}

		/**
		 * Return affiliate dashboard url
		 *
		 * @param string $endpoint Optional endpoint of the page.
		 * @param string $value    Optional value to pass to the endpoint.
		 *
		 * @return string Dashboard url, or home url if no dashboard page is set
		 * @since 1.0.0
		 * @deprecated 2.0.0
		 */
		public function get_affiliate_dashboard_url( $endpoint = '', $value = '' ) {
			_deprecated_function( '\YITH_WCAF::get_affiliate_dashboard_url', '2.0.0', 'YITH_WCAF_Dashboard()->get_dashboard_url' );

			return YITH_WCAF_Dashboard()->get_dashboard_url( $endpoint, $value );
		}

		/**
		 * Get referral url
		 *
		 * @param string|bool $token Token to use for url, or false, if current user token should be used.
		 * @param string|bool $base_url Base url to use, or false, if home url should be used.
		 *
		 * @return string|bool Generated affiliate url, or false on failure
		 * @since 1.0.0
		 */
		public function get_referral_url( $token = false, $base_url = false ) {
			$ref_name = YITH_WCAF_Session()->get_ref_name();

			if ( ! $token && is_user_logged_in() ) {
				$affiliate = YITH_WCAF_Affiliates()->get_affiliate_by_user_id( get_current_user_id() );
				$token     = $affiliate['token'];
			}

			if ( ! $base_url ) {
				$base_url = home_url();
			}

			if ( ! $token || ! $base_url ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_get_referral_url
			 *
			 * Filters affiliate referral url.
			 *
			 * @param string $referral_url Affiliate referral url.
			 * @param string $ref_name     Name of the parameter used for referral token in url.
			 * @param string $token        Affiliate token.
			 * @param string $base_url     Url used as a base for referral url generation.
			 */
			return apply_filters( 'yith_wcaf_get_referral_url', esc_url( add_query_arg( $ref_name, $token, $base_url ) ), $ref_name, $token, $base_url );
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF
		 * @since 1.0.2
		 */
		public static function get_instance() {
			$class   = static::class;
			$premium = "{$class}_Premium";

			if ( class_exists( $premium ) ) {
				return $premium::get_instance();
			}

			if ( is_null( self::$instance ) ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

	}
}

/**
 * Unique access to instance of YITH_WCAF class
 *
 * @return \YITH_WCAF
 * @since 1.0.0
 */
function YITH_WCAF() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF::get_instance();
}
