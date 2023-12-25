<?php
/**
 * Shortcode base class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	abstract class YITH_WCAF_Abstract_Shortcode {

		/**
		 * Shortcode tag
		 *
		 * @var string
		 */
		protected $tag = '';

		/**
		 * Title for current shortcode
		 *
		 * @var string
		 */
		protected $title = '';

		/**
		 * Template for current shortcode
		 *
		 * @var string
		 */
		protected $template = '';

		/**
		 * Description for current shortcode
		 *
		 * @var string
		 */
		protected $description = '';

		/**
		 * Attributes expected for the shortcode
		 *
		 * @var array
		 */
		protected $attributes = array();

		/**
		 * Array of supported functionality for the shortcode
		 *
		 * @var array
		 */
		protected $supports = array();

		/* === INIT === */

		/**
		 * Constructor method
		 */
		public function __construct() {
			// init shortcode.
			$this->init();

			// gutenberg handling.
			$this->init_gutenberg();

			// elementor handling.
			$this->init_elementor();
		}

		/**
		 * Performs any required init operation
		 * By default, does nothing.
		 */
		public function init() {}

		/**
		 * Init gutenberg block for this shortcode, when supported
		 *
		 * @return void.
		 */
		public function init_gutenberg() {
			if ( ! $this->supports( 'gutenberg' ) || ! function_exists( 'yith_plugin_fw_gutenberg_add_blocks' ) ) {
				return;
			}

			$gutenberg_block_index = str_replace( '_', '-', $this->tag );

			yith_plugin_fw_gutenberg_add_blocks(
				array(
					$gutenberg_block_index => $this->get_builder_config( 'gutenberg' ),
				)
			);

			add_action( 'yith_plugin_fw_gutenberg_before_do_shortcode', array( $this, 'builder_render_tweaks' ), 10, 1 );
			add_action( 'yith_plugin_fw_gutenberg_after_do_shortcode', array( $this, 'builder_render_tweaks' ), 10, 1 );
		}

		/**
		 * Init gutenberg block for this shortcode, when supported
		 *
		 * @return void.
		 */
		public function init_elementor() {
			if ( ! $this->supports( 'elementor' ) || ! defined( 'ELEMENTOR_VERSION' ) ) {
				return;
			}

			$elementor_block_index = str_replace( '_', '-', $this->tag );

			yith_plugin_fw_register_elementor_widgets(
				array(
					$elementor_block_index => $this->get_builder_config( 'elementor' ),
				),
				true
			);

			add_action( 'yith_plugin_fw_elementor_editor_before_do_shortcode', array( $this, 'builder_render_tweaks' ), 10, 1 );
			add_action( 'yith_plugin_fw_elementor_editor_after_do_shortcode', array( $this, 'builder_render_tweaks' ), 10, 1 );
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
			if ( empty( $atts ) ) {
				$atts = array();
			}

			/**
			 * APPLY_FILTERS: $tag_shortcode_atts
			 *
			 * Filters the attributes for the shortcode.
			 * <code>$tag</code> will be replaced with the shortcode tag.
			 *
			 * @param array $atts Shortcode attributes.
			 */
			$atts = apply_filters(
				"{$this->tag}_shortcode_atts",
				$this->parse_atts(
					array_merge(
						$atts,
						array(
							'content' => $content,
						)
					)
				)
			);

			// enqueue required assets.
			$this->enqueue();

			// retrieve shortcode template.
			ob_start();
			yith_wcaf_get_template( $this->template, $this->get_template_atts( $atts ), 'shortcodes' );

			return ob_get_clean();
		}

		/**
		 * Enqueue assets required by current shortcode
		 */
		public function enqueue() {
			wp_enqueue_script( 'yith-wcaf-shortcodes' );
		}

		/* === GETTERS === */

		/**
		 * Checks if a text contains current shortcode
		 *
		 * @param string $text Text to check.
		 * @return bool Whether text contains tag or not.
		 */
		public function has_shortcode( $text ) {
			return strpos( $text, "[{$this->tag}" ) !== false;
		}

		/**
		 * Checks if current shortcode supports a specific feature
		 *
		 * @param string $feature Feature to test.
		 * @return bool Whether current shortcode supports tested feature or not.
		 */
		public function supports( $feature ) {
			return in_array( $feature, $this->supports, true );
		}

		/**
		 * Returns attributes accepted for current shortcode
		 *
		 * @return array Array of supported attributes.
		 */
		public function get_atts() {
			return $this->attributes;
		}

		/**
		 * Parses attributes for the shortcode
		 *
		 * @param array $atts Array of attributes to parse.
		 * @return array Array of paresed attributes.
		 */
		protected function parse_atts( $atts ) {
			if ( empty( $atts ) ) {
				$atts = array();
			}

			$defaults = wp_list_pluck( $this->get_atts(), 'default' );

			return apply_filters( "{$this->tag}_shortcode_atts", shortcode_atts( $defaults, $atts ) );
		}

		/**
		 * Returns variables to be used inside template
		 *
		 * @param array $atts Attributes passed to the shortcode.
		 * @return array Array of attributes used for the template.
		 */
		protected function get_template_atts( $atts ) {
			/**
			 * APPLY_FILTERS: $tag_shortcode_template_atts
			 *
			 * Filters the array with the attritubes needed for the shortcode template.
			 * <code>$tag</code> will be replaced with the shortcode tag.
			 *
			 * @param array $shortcode_atts Attributes for the shortcode template.
			 */
			return apply_filters( "{$this->tag}_shortcode_template_atts", $atts );
		}

		/* === BUILDERS SUPPORT === */

		/**
		 * Performs required tweaks before builder rendering
		 *
		 * @param string $shortcode Tag being rendered.
		 */
		public function builder_render_tweaks( $shortcode ) {
			if ( ! $this->has_shortcode( $shortcode ) ) {
				return;
			}

			$action  = current_action();
			$builder = str_replace( array( 'yith_plugin_fw_', '_before_do_shortcode', '_after_do_shortcode' ), '', $action );
			$time    = str_replace( array( "yith_plugin_fw_{$builder}_", '_do_shortcode' ), '', $action );
			$time    = 'after' === $time ? 'post' : 'pre';
			$method  = "do_{$time}_builder_render_tweaks";

			if ( ! method_exists( $this, $method ) ) {
				return;
			}

			$this->$method( $builder, $shortcode );
		}

		/**
		 * Performs required tweaks before builder rendering
		 *
		 * @param string $builder   Specific builder.
		 * @param string $shortcode Specific shortcode.
		 */
		protected function do_pre_builder_render_tweaks( $builder, $shortcode ) {}

		/**
		 * Performs required tweaks after builder rendering
		 *
		 * @param string $builder   Specific builder.
		 * @param string $shortcode Specific shortcode.
		 */
		protected function do_post_builder_render_tweaks( $builder, $shortcode ) {}

		/**
		 * Returns configuration for builder integration
		 *
		 * @param string $builder Specific builder.
		 * @return array Array containing configuration
		 */
		protected function get_builder_config( $builder ) {
			/**
			 * APPLY_FILTERS: $tag_shortcode_$builder_config
			 *
			 * Filters the shortcode configuration for the integration with the builder.
			 * <code>$tag</code> will be replaced with the shortcode tag.
			 * <code>$builder</code> will be replaced with the builder name.
			 *
			 * @param array $shortcode_config Shortcode configuration.
			 */
			return apply_filters(
				"{$this->tag}_shortcode_{$builder}_config",
				array(
					'title'          => $this->title,
					'description'    => $this->description,
					'shortcode_name' => $this->tag,
					'style'          => 'yith-wcaf',
					'script'         => 'yith-wcaf-shortcodes',
					'elementor_icon' => $this->get_elementor_icon(),
					'attributes'     => $this->get_builder_atts( $builder ),
				)
			);
		}

		/**
		 * Returns attributes for Builder integration
		 *
		 * @param string $builder Specific builder.
		 * @return array Array of attributes
		 */
		protected function get_builder_atts( $builder ) {
			/**
			 * APPLY_FILTERS: $tag_shortcode_$builder_atts
			 *
			 * Filters the shortcode attributes for the integration with the builder.
			 * <code>$tag</code> will be replaced with the shortcode tag.
			 * <code>$builder</code> will be replaced with the builder name.
			 *
			 * @param array $shortcode_atts Shortcode attributes.
			 */
			return apply_filters(
				"{$this->tag}_shortcode_{$builder}_atts",
				wp_list_filter( $this->get_atts(), array( $builder => true ) )
			);
		}

		/**
		 * Returns Icon used for Elementor widget
		 *
		 * @return string Icon.
		 */
		protected function get_elementor_icon() {
			return 'yith-icon yith-icon-yith';
		}
	}
}
