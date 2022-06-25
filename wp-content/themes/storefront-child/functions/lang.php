<?php
// https://wpml.org/documentation/support/wpml-coding-api/shortcodes/#wpml_language_selector_widget
add_action('wp_language_switcher', 'wpml_floating_language_switcher');
function wpml_floating_language_switcher() {
        do_action('wpml_language_switcher');
}
//WPML - Add a floating language switcher