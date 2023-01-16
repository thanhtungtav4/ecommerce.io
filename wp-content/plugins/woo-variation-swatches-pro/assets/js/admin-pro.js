/*!
 * Variation Swatches for WooCommerce - Pro v1.1.15 
 * 
 * Author: Emran Ahmed ( emran.bd.08@gmail.com ) 
 * Date: 4/24/2021
 * Released under the GPLv3 license.
 */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ 8:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(9);


/***/ }),

/***/ 9:
/***/ (function(module, exports) {

/* global wp, wvs_pro_product_variation_data, woocommerce_admin_meta_boxes_variations, woocommerce_admin, accounting */

jQuery(function ($) {

  $('#woocommerce-product-data').on('woocommerce_variations_loaded', function () {
    wp.ajax.send('wvs_pro_load_product_attributes', {
      success: function success(data) {
        $('#wvs-pro-product-variable-swatches-options').html(data);
        $(document.body).trigger('wvs_pro_product_swatches_variation_loaded');
      },
      data: {
        post_id: wvs_pro_product_variation_data.post_id,
        nonce: wvs_pro_product_variation_data.nonce
      }
    });
  });

  $(document.body).on('click', '.wvs_pro_save_product_attributes', function () {

    // let data = $('.wvs-pro-product-variable-swatches-options').find('input, select, textarea').serialize();
    // let data = $('.wvs-pro-product-variable-swatches-options').find(':input:not(.wvs-skip-field)').serialize();
    var data = $('#wvs-pro-product-variable-swatches-options').find(':input:not(.wvs-skip-field)').serializeJSON({
      disableColonTypes: true
    });
    var key = Object.keys(data) ? Object.keys(data).shift() : '_wvs_pro_swatch_option';

    // console.log(Object.fromEntries(new URLSearchParams(data)));

    $('#wvs-pro-product-variable-swatches-options').block({
      message: null,
      overlayCSS: {
        background: '#fff',
        opacity: 0.6
      }
    });

    wp.ajax.send('wvs_pro_save_product_attributes', {
      success: function success(data) {
        $('#wvs-pro-product-variable-swatches-options').unblock();
        $('#wvs-pro-product-variable-swatches-options-notice').removeClass('notice updated error').html(data.message).addClass(data.class);
      },
      error: function error(_error) {
        console.error(_error);
        $('#wvs-pro-product-variable-swatches-options').unblock();
        $('#wvs-pro-product-variable-swatches-options-notice').removeClass('notice updated error').html('Ajax error. Please check console').addClass('error');
      },

      data: {
        post_id: wvs_pro_product_variation_data.post_id,
        nonce: wvs_pro_product_variation_data.nonce,
        data: data[key]
      }
    });
  });

  $(document.body).on('click', '.wvs_pro_reset_product_attributes', function () {
    if (confirm(wvs_pro_product_variation_data.reset_notice)) {
      $('#wvs-pro-product-variable-swatches-options').block({
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      });
      wp.ajax.send('wvs_pro_reset_product_attributes', {
        success: function success(data) {
          $('#woocommerce-product-data').trigger('woocommerce_variations_loaded');
          $('#wvs-pro-product-variable-swatches-options').unblock();
        },
        error: function error(_error2) {
          console.error(_error2);
          $('#wvs-pro-product-variable-swatches-options').unblock();
        },

        data: {
          post_id: wvs_pro_product_variation_data.post_id,
          nonce: wvs_pro_product_variation_data.nonce
        }
      });
    }
  });

  $.fn.wvs_pro_product_attribute_type = function (options) {
    return this.each(function () {
      var _this = this;

      var $wrapper = $(this).closest('.wvs-pro-variable-swatches-attribute-wrapper');

      var change_classes = function change_classes() {
        var value = $(_this).val();
        var visible_class = 'visible_if_' + value;

        var existing_classes = Object.keys(wvs_pro_product_variation_data.attribute_types).map(function (type) {
          return 'visible_if_' + type;
        }).join(' ');

        $wrapper.removeClass(existing_classes).removeClass('visible_if_custom').addClass(visible_class);
        return value;
      };

      $(this).on('change', function (e) {
        var value = change_classes();
        $wrapper.find('.wvs-pro-swatch-tax-type').val(value).trigger('change.taxonomy');
      });

      $(this).on('change.attribute', function (e) {
        change_classes();
      });
    });
  };

  $.fn.wvs_pro_product_taxonomy_type = function (options) {
    return this.each(function () {
      var _this2 = this;

      var $wrapper = $(this).closest('.wvs-pro-variable-swatches-attribute-tax-wrapper');
      var $main_wrapper = $(this).closest('.wvs-pro-variable-swatches-attribute-wrapper');

      var change_classes = function change_classes() {
        var value = $(_this2).val();
        var visible_class = 'visible_if_tax_' + value;

        var existing_classes = Object.keys(wvs_pro_product_variation_data.attribute_types).map(function (type) {
          return 'visible_if_tax_' + type;
        }).join(' ');

        $wrapper.removeClass(existing_classes).addClass(visible_class);
        return value;
      };

      $(this).on('change', function (e) {

        change_classes();

        var allValues = [];
        $main_wrapper.find('.wvs-pro-swatch-tax-type').each(function () {
          allValues.push($(this).val());
        });

        var uniqueValues = _.uniq(allValues);
        var is_all_tax_same = uniqueValues.length === 1;

        if (is_all_tax_same) {
          $main_wrapper.find('.wvs-pro-swatch-option-type').val(uniqueValues.toString()).trigger('change.attribute');
        } else {
          $main_wrapper.find('.wvs-pro-swatch-option-type').val('custom').trigger('change.attribute');
        }
      });

      $(this).on('change.taxonomy', function (e) {
        change_classes();
      });
    });
  };

  $.fn.wvs_pro_product_taxonomy_item_tooltip_type = function (options) {
    return this.each(function () {
      var _this3 = this;

      var $wrapper = $(this).closest('tbody');

      var change_classes = function change_classes() {
        var value = $(_this3).val();
        var visible_class = 'visible_if_item_tooltip_type_' + value;

        var existing_classes = ['', 'text', 'image', 'no'].map(function (type) {
          return 'visible_if_item_tooltip_type_' + type;
        }).join(' ');

        $wrapper.find('.wvs-pro-item-tooltip-type-item').removeClass(existing_classes).addClass(visible_class);
        return value;
      };

      $(this).on('change', function (e) {
        change_classes();
      });

      $(this).trigger('change');
    });
  };

  $.fn.wvs_pro_product_taxonomy_item_dual_color = function (options) {
    return this.each(function () {
      var _this4 = this;

      var $wrapper = $(this).closest('tbody');

      var change_classes = function change_classes() {
        var value = $(_this4).val();
        var visible_class = 'visible_if_item_dual_color_' + value;

        var existing_classes = ['', 'yes', 'no'].map(function (type) {
          return 'visible_if_item_dual_color_' + type;
        }).join(' ');

        $wrapper.find('.wvs-pro-item-secondary-color-item').removeClass(existing_classes).addClass(visible_class);
        return value;
      };

      $(this).on('change', function (e) {
        change_classes();
      });

      $(this).trigger('change');
    });
  };

  $('.wvs-pro-swatch-option-type').wvs_pro_product_attribute_type();
  $('.wvs-pro-swatch-tax-type').wvs_pro_product_taxonomy_type();
  $('.wvs-pro-item-tooltip-type').wvs_pro_product_taxonomy_item_tooltip_type();
  $('.wvs-pro-item-tooltip-is-dual-color').wvs_pro_product_taxonomy_item_dual_color();

  // Re Init
  $(document.body).on('wvs_pro_product_swatches_variation_loaded', function () {
    $('.wvs-pro-swatch-option-type').wvs_pro_product_attribute_type();
    $('.wvs-pro-swatch-tax-type').wvs_pro_product_taxonomy_type();
    $('.wvs-pro-item-tooltip-type').wvs_pro_product_taxonomy_item_tooltip_type();
    $('.wvs-pro-item-tooltip-is-dual-color').wvs_pro_product_taxonomy_item_dual_color();
  });
});

/***/ })

/******/ });