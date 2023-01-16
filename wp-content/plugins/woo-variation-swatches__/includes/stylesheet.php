<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
?>
<style type="text/css">
    .wvs-archive-variation-wrapper .variable-item:not(.radio-variable-item) {
        width  : <?php echo $width ?>px;
        height : <?php echo $height ?>px;
        }

    .wvs-archive-variation-wrapper .variable-items-wrapper.squared .button-variable-item,
    .variable-items-wrapper.squared .button-variable-item {
        min-width : <?php echo $width ?>px;
        }

    .wvs-archive-variation-wrapper .button-variable-item span {
        font-size : <?php echo $font_size?>px;
        }

    .wvs-style-squared .button-variable-wrapper.rounded .button-variable-item {
        width : <?php echo $width ?>px !important;
        }

    .wvs-large-variable-wrapper .variable-item:not(.radio-variable-item) {
        width  : <?php echo $large_size_width?>px;
        height : <?php echo $large_size_height?>px;
        }

    .wvs-style-squared .wvs-large-variable-wrapper .button-variable-item {
        min-width : <?php echo $large_size_width?>px;
        }

    .wvs-large-variable-wrapper .button-variable-item span {
        font-size : <?php echo $large_size_font_size?>px;
        }

    .wvs-style-squared .button-variable-wrapper.rounded.wvs-large-variable-wrapper .button-variable-item {
        width : <?php echo $large_size_width?>px !important;
        }

    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item) {
        box-shadow : 0 0 0 <?php echo $border_size?>px <?php echo $border_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .button-variable-item span,
    .woo-variation-swatches .variable-items-wrapper .radio-variable-item label,
    .woo-variation-swatches .wvs-archive-variation-wrapper .reset_variations a {
        color : <?php echo $text_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item) {
        background-color : <?php echo $background_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .button-variable-item.selected span,
    .woo-variation-swatches .variable-items-wrapper .radio-variable-item.selected label {
        color : <?php echo $selected_text_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item).selected {
        background-color : <?php echo $selected_background_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item).selected {
        box-shadow : 0 0 0 <?php echo $selected_border_size?>px <?php echo $selected_border_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item):hover,
    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item).selected:hover {
        box-shadow : 0 0 0 <?php echo $hover_border_size?>px <?php echo $hover_border_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .button-variable-item:hover span,
    .woo-variation-swatches .variable-items-wrapper .button-variable-item.selected:hover span,
    .woo-variation-swatches .variable-items-wrapper .radio-variable-item:hover label,
    .woo-variation-swatches .variable-items-wrapper .radio-variable-item.selected:hover label {
        color : <?php echo $hover_text_color?> !important;
        }

    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item):hover,
    .woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item).selected:hover {
        background-color : <?php echo $hover_background_color?> !important;
        }
</style>