<?php

// Adds a custom rule type.
add_filter( 'acf/location/rule_types', function( $choices ){
 $choices[ __("Other",'acf') ]['wc_prod_attr'] = 'WC Product Attribute';
 return $choices;
} );

// Adds custom rule values.
add_filter( 'acf/location/rule_values/wc_prod_attr', function( $choices ){
 foreach ( wc_get_attribute_taxonomies() as $attr ) {
 $pa_name = wc_attribute_taxonomy_name( $attr->attribute_name );
 $choices[ $pa_name ] = $attr->attribute_label;
 }
 return $choices;
} );

// Matching the custom rule.
add_filter( 'acf/location/rule_match/wc_prod_attr', function( $match, $rule, $options ){
 if ( isset( $options['taxonomy'] ) ) {
 if ( '==' === $rule['operator'] ) {
 $match = $rule['value'] === $options['taxonomy'];
 } elseif ( '!=' === $rule['operator'] ) {
 $match = $rule['value'] !== $options['taxonomy'];
 }
 }
 return $match;
}, 10, 3 );