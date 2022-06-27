<?php
    
    defined( 'ABSPATH' ) || exit;
    
    if ( ! class_exists( 'Woo_Variation_Swatches_Compatibility' ) ) {
        class Woo_Variation_Swatches_Compatibility {
            
            protected static $_instance = null;
            
            protected function __construct() {
                $this->includes();
                $this->hooks();
                $this->init();
                do_action( 'woo_variation_swatches_manage_compatibility_loaded', $this );
            }
            
            public static function instance() {
                if ( is_null( self::$_instance ) ) {
                    self::$_instance = new self();
                }
                
                return self::$_instance;
            }
            
            protected function includes() {
            }
            
            protected function hooks() {
                add_filter( 'wp_kses_allowed_html', array( $this, 'elementor_pro_compatibility' ) );
            }
            
            protected function init() {
            
            }
            
            // Start
            
            public function elementor_pro_compatibility( $tags ) {
                if ( class_exists( 'ElementorPro\\Plugin' ) ) {
                    $tags[ 'select' ] = array(
                        'class'                 => array(),
                        'id'                    => array(),
                        'name'                  => array(),
                        'type'                  => array(),
                        'style'                 => array(),
                        'data-attribute_name'   => array(),
                        'data-show_option_none' => array(),
                    );
                    
                    $tags[ 'option' ] = array(
                        'selected' => array(),
                        'value'    => array(),
                    );
                }
                
                return $tags;
            }
        }
    }
	