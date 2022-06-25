<?php
    add_action( 'init', 'wc_remove_storefront_breadcrumbs');
    function wc_remove_storefront_breadcrumbs() {
        remove_action( 'storefront_before_content', 'woocommerce_breadcrumb', 10 );
    }
