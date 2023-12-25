<?php
class WooSEA_Caching {
        	
	/**
         * Exclude Feed URL from being cached by LiteSpeed
         *
         * @return false
         */
        function litespeed_cache() {
		if ( ! class_exists( 'LiteSpeed\Core' ) || ! defined( 'LSCWP_DIR' ) ) {
                       	return false;
               	}
		$litespeed_ex_paths = maybe_unserialize( get_option( 'litespeed.conf.cdn-exc' ) );
               	if ( $litespeed_ex_paths && is_array( $litespeed_ex_paths ) && ! in_array( '/wp-content/uploads/woo-product-feed-pro', $litespeed_ex_paths ) ) {
                       	$litespeed_ex_paths = array_merge(
                               	$litespeed_ex_paths,
                               	array( '/wp-content/uploads/woo-product-feed-pro' )
                       	);
                       	update_option( 'litespeed.conf.cdn-exc', $litespeed_ex_paths );
               	}
               	return false;
       	}

        /**
         * Exclude Feed URL from being cached by WP Fastest
         *
         * @return false
         */
        public function wp_fastest_cache() {

                if ( ! class_exists( 'WpFastestCache' ) ) {
                        return false;
                }
		
		$wp_fastest_cache_ex_paths = json_decode( get_option( 'WpFastestCacheExclude' ), false );
                if ( $wp_fastest_cache_ex_paths && is_array( $wp_fastest_cache_ex_paths ) ) {
			$feed_path_exist = false;

                        foreach ( $wp_fastest_cache_ex_paths as $path ) {
                                if ( 'woo-product-feed-pro' === $path->content ) {
                                        $feed_path_exist = true;
                                        break;
                                }
                        }

                        if ( ! $feed_path_exist ) {
                                $new_rule          = new stdClass();
                                $new_rule->prefix  = "contain";
                                $new_rule->content = 'woo-product-feed-pro';
                                $new_rule->type    = "page";

                                $wp_fastest_cache_ex_paths = array_merge(
                                        $wp_fastest_cache_ex_paths,
                                        [ $new_rule ]
                                );

                                update_option( 'WpFastestCacheExclude', wp_json_encode( $wp_fastest_cache_ex_paths ) );
                        }
                } elseif ( empty( $wp_fastest_cache_ex_paths ) ) {
                        $wp_fastest_cache_ex_paths = [];
                        $new_rule                  = new stdClass();
                        $new_rule->prefix          = "contain";
                        $new_rule->content         = 'woo-product-feed-pro';
                        $new_rule->type            = "page";

                        $wp_fastest_cache_ex_paths = array_merge(
                                $wp_fastest_cache_ex_paths,
                                [ $new_rule ]
                        );

                        update_option( 'WpFastestCacheExclude', wp_json_encode( $wp_fastest_cache_ex_paths ) );
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by WP Super
         *
         * @return false
         */
        public function wp_super_cache() {

                if ( ! function_exists( 'wpsc_init' ) ) {
                        return false;
                }

                $wp_super_ex_paths = get_option( 'ossdl_off_exclude' );
                if ( $wp_super_ex_paths && strpos( $wp_super_ex_paths, 'woo-product-feed-pro' ) === false ) {
                        $wp_super_ex_paths = explode( ',', $wp_super_ex_paths );
                        $wp_super_ex_paths = array_merge( $wp_super_ex_paths, [ 'woo-product-feed-pro' ] );
                        update_option( 'ossdl_off_exclude', implode( ',', $wp_super_ex_paths ) );
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by BREEZE
         *
         * @return false
         */
        public function breeze_cache() {

                if ( ! class_exists( 'Breeze_Admin' ) ) {
                        return false;
                }

                $breeze_settings = maybe_unserialize( get_option( 'breeze_cdn_integration' ) );
                if ( is_array( $breeze_settings ) ) {
                        $woo_product_feed_pro_files                         = [ '.xml', '.csv', '.tsv', '.txt', '.xls' ];
                        $woo_product_feed_pro_files                         = array_unique( array_merge( $woo_product_feed_pro_files, $breeze_settings['cdn-exclude-content'] ) );
                        $breeze_settings['cdn-exclude-content'] = $woo_product_feed_pro_files;
                        update_option( 'breeze_cdn_integration', $breeze_settings );
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by WP Optimize
         *
         * @return false
         */
        public function wp_optimize_cache() {

                if ( ! class_exists( 'WP_Optimize' ) ) {
                        return false;
                }

                $wp_optimize_ex_paths = maybe_unserialize( get_option( 'wpo_cache_config' ) );
                // If page Caching enabled
                if ( isset( $wp_optimize_ex_paths['enable_page_caching'] ) && $wp_optimize_ex_paths['enable_page_caching'] && is_array( $wp_optimize_ex_paths ) && ! in_array( '/wp-content/uploads/woo-product-feed-pro', $wp_optimize_ex_paths['cache_exception_urls'], true ) ) {
                        $woo_feed_ex_path['cache_exception_urls'] = [ '/wp-content/uploads/woo-product-feed-pro' ];
                        $wp_optimize_ex_paths                     = array_merge_recursive(
                                $wp_optimize_ex_paths,
                                $woo_feed_ex_path
                        );
                        update_option( 'wpo_cache_config', $wp_optimize_ex_paths );
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by Cache Enabler
         *
         * @return false
         */
        public function cache_enabler_cache() {

                if ( ! class_exists( 'Cache_Enabler' ) ) {
                        return false;
                }

                $cache_enabler_ex_paths = maybe_unserialize( get_option( 'cache_enabler' ) );
                if ( isset( $cache_enabler_ex_paths['excluded_page_paths'] ) && empty( $cache_enabler_ex_paths['excluded_page_paths'] ) ) {
                        $cache_enabler_ex_paths['excluded_page_paths'] = '/wp-content/uploads/woo-product-feed-pro/';
                        update_option( 'cache_enabler', $cache_enabler_ex_paths );
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by Swift Performance
         *
         * @return false
         */
        public function swift_performance_cache() {

                if ( ! class_exists( 'Swift_Performance_Lite' ) ) {
                        return false;
                }

                $swift_perform_ex_paths = maybe_unserialize( get_option( 'swift_performance_options' ) );

                if ( $swift_perform_ex_paths && isset( $swift_perform_ex_paths['exclude-strings'] ) ) {
                        $exclude_strings = $swift_perform_ex_paths['exclude-strings'];
                        if ( is_array( $exclude_strings ) && ! in_array( '/wp-content/uploads/woo-product-feed-pro', $exclude_strings, true ) ) {
                                $woo_feed_ex_path['exclude-strings'] = [ '/wp-content/uploads/woo-product-feed-pro' ];
                                $swift_perform_ex_paths              = array_merge_recursive(
                                        $swift_perform_ex_paths,
                                        $woo_feed_ex_path
                                );
                        } else {
                                $swift_perform_ex_paths['exclude-strings'] = [ '/wp-content/uploads/woo-product-feed-pro' ];
                        }
                        update_option( 'swift_performance_options', $swift_perform_ex_paths );
                } elseif ( empty( $swift_perform_ex_paths ) ) {
                        $swift_perform_ex_paths['exclude-strings'] = [ '/wp-content/uploads/woo-product-feed-pro' ];
                        update_option( 'swift_performance_options', $swift_perform_ex_paths );
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by Comet Cache
         *
         * @return false
         */
        public function comet_cache() {
                if ( ! is_plugin_active( 'comet-cache/comet-cache.php' ) ) {
                        return false;
                }

                $comet_cache_settings = maybe_unserialize( get_option( 'comet_cache_options' ) );

                if ( $comet_cache_settings && isset( $comet_cache_settings['exclude_uris'] ) ) {
                        $exclude_uris = $comet_cache_settings['exclude_uris'];
                        if ( strpos( $exclude_uris, '/wp-content/uploads/woo-product-feed-pro' ) === false ) {
                                $exclude_uris                         .= "\n/wp-content/uploads/woo-product-feed-pro";
                                $comet_cache_settings['exclude_uris'] = $exclude_uris;
                                update_option( 'comet_cache_options', $comet_cache_settings );
                        }
                }

                return false;
        }

        /**
         * Exclude Feed URL from being cached by Hyper Caching
         *
         * @return false
         */
        public function hyper_cache() {

                if ( ! class_exists( 'HyperCache' ) ) {
                        return false;
                }

                $hyper_cache_settings = maybe_unserialize( get_option( 'hyper-cache' ) );
                if ( $hyper_cache_settings && isset( $hyper_cache_settings['reject_uris'] ) ) {
                        $exclude_strings = $hyper_cache_settings['reject_uris'];
                        if ( is_array( $exclude_strings ) && ! in_array( '/wp-content/uploads/woo-product-feed-pro', $exclude_strings, true ) ) {
                                $woo_feed_ex_path['reject_uris']         = [ '/wp-content/uploads/woo-product-feed-pro' ];
                                $woo_feed_ex_path['reject_uris_enabled'] = 1;
                                $hyper_cache_settings                    = array_merge_recursive(
                                        $hyper_cache_settings,
                                        $woo_feed_ex_path
                                );
                        }
                        update_option( 'hyper-cache', $hyper_cache_settings );
                }

                return false;
        }

}
