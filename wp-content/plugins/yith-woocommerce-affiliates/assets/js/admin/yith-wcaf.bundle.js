/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

;// CONCATENATED MODULE: ./assets/js/src/globals.js


/* global yith_wcaf yith */

// these constants will be wrapped inside webpack closure, to prevent collisions

function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
var $ = jQuery,
  $document = $(document),
  $body = $('body'),
  block = function block($el) {
    if (typeof $.fn.block === 'undefined') {
      return false;
    }
    try {
      $el.block({
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      });
      return $el;
    } catch (e) {
      return false;
    }
  },
  unblock = function unblock($el) {
    if (typeof $.fn.unblock === 'undefined') {
      return false;
    }
    try {
      $el.unblock();
    } catch (e) {
      return false;
    }
  },
  globals_confirm = function confirm(title, message, args) {
    return new Promise(function (resolve, reject) {
      var _yith;
      // if can't display modal, accept by default
      if (typeof ((_yith = yith) === null || _yith === void 0 || (_yith = _yith.ui) === null || _yith === void 0 ? void 0 : _yith.confirm) === 'undefined') {
        reject(new Error('Missing yith.ui utilities'));
      }
      var options = _objectSpread({
        title: title || labels.generic_confirm_title,
        message: message || labels.generic_confirm_message
      }, args);
      options.onConfirm = function () {
        return resolve(true);
      };
      options.onCancel = reject;
      yith.ui.confirm(options);
    });
  };
var ajaxUrl, nonces, labels;
if (typeof yith_wcaf !== 'undefined') {
  var _yith_wcaf, _yith_wcaf2, _yith_wcaf3;
  ajaxUrl = (_yith_wcaf = yith_wcaf) === null || _yith_wcaf === void 0 ? void 0 : _yith_wcaf.ajax_url;
  nonces = (_yith_wcaf2 = yith_wcaf) === null || _yith_wcaf2 === void 0 ? void 0 : _yith_wcaf2.nonces;
  labels = (_yith_wcaf3 = yith_wcaf) === null || _yith_wcaf3 === void 0 ? void 0 : _yith_wcaf3.labels;
}

;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/classCallCheck.js
function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/typeof.js
function _typeof(o) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
    return typeof o;
  } : function (o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  }, _typeof(o);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/toPrimitive.js

function _toPrimitive(input, hint) {
  if (_typeof(input) !== "object" || input === null) return input;
  var prim = input[Symbol.toPrimitive];
  if (prim !== undefined) {
    var res = prim.call(input, hint || "default");
    if (_typeof(res) !== "object") return res;
    throw new TypeError("@@toPrimitive must return a primitive value.");
  }
  return (hint === "string" ? String : Number)(input);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js


function _toPropertyKey(arg) {
  var key = _toPrimitive(arg, "string");
  return _typeof(key) === "symbol" ? key : String(key);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/createClass.js

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor);
  }
}
function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  Object.defineProperty(Constructor, "prototype", {
    writable: false
  });
  return Constructor;
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/defineProperty.js

function defineProperty_defineProperty(obj, key, value) {
  key = _toPropertyKey(key);
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }
  return obj;
}
;// CONCATENATED MODULE: ./assets/js/src/modules/dependencies.js


/**
 * Internal dependencies
 */




var YITH_WCAF_Dependencies_Handler = /*#__PURE__*/function () {
  function YITH_WCAF_Dependencies_Handler($container) {
    var _this$$container, _this$$fields;
    _classCallCheck(this, YITH_WCAF_Dependencies_Handler);
    // container
    defineProperty_defineProperty(this, "$container", void 0);
    // fields;
    defineProperty_defineProperty(this, "$fields", void 0);
    // dependencies tree.
    defineProperty_defineProperty(this, "dependencies", {});
    this.$container = $container;
    if (!((_this$$container = this.$container) !== null && _this$$container !== void 0 && _this$$container.length)) {
      return;
    }
    this.initFields();
    if (!((_this$$fields = this.$fields) !== null && _this$$fields !== void 0 && _this$$fields.length)) {
      return;
    }
    this.initDependencies();
  }
  _createClass(YITH_WCAF_Dependencies_Handler, [{
    key: "initFields",
    value: function initFields() {
      this.$fields = this.$container.find(':input');
    }
  }, {
    key: "initDependencies",
    value: function initDependencies() {
      this.buildDependenciesTree();
      if (!Object.keys(this.dependencies).length) {
        return;
      }
      this.handleDependencies();
    }
  }, {
    key: "buildDependenciesTree",
    value: function buildDependenciesTree() {
      var self = this;
      this.$fields.closest('[data-dependencies]').each(function () {
        var $field = $(this),
          id = $field.attr('id');
        if (!id) {
          return;
        }
        var newBranch = defineProperty_defineProperty({}, id, $field.data('dependencies'));
        self.dependencies = $.extend(self.dependencies, newBranch);
      });

      // backward compatibility with plugin-fw
      this.$container.find('[data-dep-target]').each(function () {
        var $container = $(this),
          id = $container.data('dep-id'),
          target = $container.data('dep-target'),
          value = $container.data('dep-value');
        if (!id || !target || !value) {
          return;
        }
        var newBranch = defineProperty_defineProperty({}, target, defineProperty_defineProperty({}, id, value.toString().split(',')));
        self.dependencies = $.extend(self.dependencies, newBranch);
      });
    }
  }, {
    key: "handleDependencies",
    value: function handleDependencies() {
      this.$fields.on('change', this.applyDependencies.bind(this));
      this.applyDependencies();
    }
  }, {
    key: "applyDependencies",
    value: function applyDependencies() {
      var _this = this;
      $.each(this.dependencies, function (field, conditions) {
        var $container = _this.findFieldContainer(field);
        if (!$container.length) {
          return;
        }
        var show = _this.checkConditions(conditions);
        if (show) {
          $container === null || $container === void 0 || $container.fadeIn();
        } else {
          $container === null || $container === void 0 || $container.hide();
        }
      });
    }
  }, {
    key: "findField",
    value: function findField(field) {
      var $field = this.$container.find("#".concat(field));
      if (!$field.length) {
        $field = this.$container.find("#".concat(field, "_field"));
      }
      if (!$field.length) {
        return false;
      }
      if (!$field.is(':input')) {
        $field = $field.find(':input');
      }
      return $field;
    }
  }, {
    key: "findFieldContainer",
    value: function findFieldContainer(field) {
      var $field = this.findField(field);
      if (!($field !== null && $field !== void 0 && $field.length)) {
        return false;
      }

      // first of all search for container by id.
      var $container = $field.closest("#".concat(field, "_container"));

      // if we couldn't find item with correct id, search for a .form-row
      if (!$container.length) {
        $container = $field.closest('.form-row');
      }

      // finally, just assume closest table row is a valid container
      if (!$container.length) {
        $container = $field.closest('tr');
      }

      // if none of the previous worked, just fail to false
      if (!$container.length) {
        return false;
      }
      return $container;
    }
  }, {
    key: "checkConditions",
    value: function checkConditions(conditions) {
      var _this2 = this;
      var result = true;
      $.each(conditions, function (field, condition) {
        var $field = _this2.findField(field);
        var fieldValue;
        if (!result || !($field !== null && $field !== void 0 && $field.length)) {
          return;
        }
        if ($field.first().is('input[type="radio"]')) {
          var _$field$filter;
          fieldValue = (_$field$filter = $field.filter(':checked')) === null || _$field$filter === void 0 || (_$field$filter = _$field$filter.val()) === null || _$field$filter === void 0 ? void 0 : _$field$filter.toString();
        } else {
          var _$field$val;
          fieldValue = $field === null || $field === void 0 || (_$field$val = $field.val()) === null || _$field$val === void 0 ? void 0 : _$field$val.toString();
        }
        if (Array.isArray(condition)) {
          result = condition.includes(fieldValue);
        } else if (typeof condition === 'function') {
          result = condition(fieldValue);
        } else if (condition.indexOf(':') === 0) {
          result = $field.is(condition);
        } else if (condition.indexOf('!:') === 0) {
          result = !$field.is(condition.toString().substring(1));
        } else if (condition.indexOf('!') === 0) {
          result = condition.toString().substring(1) !== fieldValue;
        } else {
          result = condition.toString() === fieldValue;
        }
        if (typeof _this2.dependencies[field] !== 'undefined') {
          result = result && _this2.checkConditions(_this2.dependencies[field]);
        }
      });
      return result;
    }
  }]);
  return YITH_WCAF_Dependencies_Handler;
}();
function initDependencies($container) {
  var _$container;
  // init container
  if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
    $container = $document;
  }
  return new YITH_WCAF_Dependencies_Handler($container);
}
;// CONCATENATED MODULE: ./assets/js/src/modules/validation.js


/**
 * Internal dependencies
 */




var YITH_WCAF_Validation_Handler = /*#__PURE__*/function () {
  function YITH_WCAF_Validation_Handler($container) {
    var _this$$container;
    _classCallCheck(this, YITH_WCAF_Validation_Handler);
    // container
    defineProperty_defineProperty(this, "$container", void 0);
    // error class to add/remove to fields wrapper
    defineProperty_defineProperty(this, "ERROR_CLASS", 'woocommerce-invalid');
    this.$container = $container;
    if (!((_this$$container = this.$container) !== null && _this$$container !== void 0 && _this$$container.length)) {
      return;
    }
    this.initValidation();
  }

  // init validation.
  _createClass(YITH_WCAF_Validation_Handler, [{
    key: "initValidation",
    value: function initValidation() {
      this.initForm();
      this.initFields();
    }
  }, {
    key: "initForm",
    value: function initForm() {
      var $forms = this.$container.is('form') ? this.$container : this.$container.find('form');
      if (!$forms.length) {
        return;
      }
      var self = this;
      $forms.on('submit yith_wcaf_validate_fields', function (ev) {
        var $form = $(this),
          res = self.validateForm($form);
        if (!res) {
          ev.stopImmediatePropagation();
          return false;
        }
        return true;
      });
    }
  }, {
    key: "initFields",
    value: function initFields() {
      var $fields = this.getFields(this.$container);
      if (!$fields.length) {
        return;
      }
      var self = this;
      $fields.on('keyup change', function () {
        var $field = $(this);
        self.validateField($field);
      });
    }

    // fields handling.
  }, {
    key: "getFieldWrapper",
    value: function getFieldWrapper($field) {
      return $field.closest('.form-row, .yith-plugin-fw-panel-wc-row');
    }
  }, {
    key: "getFields",
    value: function getFields($container) {
      var $fields = $('input, select, textarea', $container);
      return $fields.not('input[type="submit"]').not('input[type="hidden"]').not('.select2-search__field');
    }
  }, {
    key: "getVisibleFields",
    value: function getVisibleFields($container) {
      var _this = this;
      var $fields = this.getFields($container);
      return $fields.filter(function (index, field) {
        var $field = $(field),
          $fieldWrapper = _this.getFieldWrapper($field);
        return $fieldWrapper.is(':visible');
      });
    }
  }, {
    key: "isFieldValid",
    value: function isFieldValid($field) {
      var $wrapper = this.getFieldWrapper($field),
        fieldType = $field.attr('type'),
        value = $field.val(),
        alwaysRequiredFields = ['reg_username', 'reg_email', 'reg_password'];

      // check for required fields
      if ($field.prop('required') || $wrapper.hasClass('required') || $wrapper.hasClass('validate-required') || $wrapper.hasClass('yith-plugin-fw--required') || alwaysRequiredFields.includes($field.get(0).id)) {
        if (fieldType === 'checkbox' && !$field.is(':checked')) {
          throw 'missing';
        } else if (!value) {
          throw 'missing';
        }
      }

      // check for patterns
      var pattern = $wrapper.data('pattern');
      if (pattern) {
        var regex = new RegExp(pattern);
        if (!regex.test(value)) {
          throw 'malformed';
        }
      }

      // check for min length
      var minLength = $wrapper.data('min_length');
      if (minLength && value.length < minLength) {
        throw 'short';
      }

      // check for max length
      var maxLength = $wrapper.data('max_length');
      if (maxLength && value.length > maxLength) {
        throw 'long';
      }

      // check for number
      if (fieldType === 'number') {
        var min = parseFloat($field.attr('min')),
          max = parseFloat($field.attr('max')),
          numVal = parseFloat(value);
        if (min && min > numVal || max && max < numVal) {
          throw 'overflow';
        }
      }

      // all validation passed; we can return true.
      return true;
    }
  }, {
    key: "validateField",
    value: function validateField($field) {
      try {
        this.isFieldValid($field);
      } catch (e) {
        this.reportError($field, e);
        return false;
      }
      this.removeError($field);
      return true;
    }
  }, {
    key: "validateForm",
    value: function validateForm($form) {
      var $visibleFields = this.getVisibleFields($form);
      if (!$visibleFields.length) {
        return true;
      }
      var self = this;
      var valid = true;
      $visibleFields.each(function () {
        var $field = $(this);
        if (!self.validateField($field)) {
          valid = false;
        }
      });
      if (!valid) {
        // scroll top.
        this.scrollToFirstError($form);

        // stop form submitting.
        return false;
      }
      return true;
    }

    // error handling.
  }, {
    key: "getErrorMsg",
    value: function getErrorMsg($field, errorType) {
      var _labels$errors, _labels$errors2, _labels$errors3, _labels$errors4, _labels$errors5;
      // check if we have a field-specific error message.
      var msg = $field.data('error');
      if (msg) {
        return msg;
      }

      // check if message is added to wrapper.
      var $wrapper = this.getFieldWrapper($field);
      msg = $wrapper.data('error');
      if (msg) {
        return msg;
      }

      // check if message is added to label.
      var $label = $wrapper.find('label');
      msg = $label.data('error');
      if (msg) {
        return msg;
      }
      if (!(labels !== null && labels !== void 0 && labels.errors)) {
        return false;
      }
      switch (errorType) {
        case 'missing':
          var fieldType = $field.attr('type');
          msg = fieldType === 'checkbox' ? (_labels$errors = labels.errors) === null || _labels$errors === void 0 ? void 0 : _labels$errors.accept_check : (_labels$errors2 = labels.errors) === null || _labels$errors2 === void 0 ? void 0 : _labels$errors2.compile_field;
          if (msg) {
            return msg;
          }

        // fallthrough if we didn't find a proper message yet.
        default:
          msg = (_labels$errors3 = labels.errors) !== null && _labels$errors3 !== void 0 && _labels$errors3[errorType] ? (_labels$errors4 = labels.errors) === null || _labels$errors4 === void 0 ? void 0 : _labels$errors4[errorType] : (_labels$errors5 = labels.errors) === null || _labels$errors5 === void 0 ? void 0 : _labels$errors5.general_error;
          break;
      }
      return msg;
    }
  }, {
    key: "reportError",
    value: function reportError($field, errorType) {
      var $wrapper = this.getFieldWrapper($field),
        errorMsg = this.getErrorMsg($field, errorType);
      $wrapper.addClass(this.ERROR_CLASS);
      if (!errorMsg) {
        return;
      }

      // remove existing errors.
      $wrapper.find('.error-msg').remove();

      // generate and append new error message.
      var $errorMsg = $('<span/>', {
        "class": 'error-msg',
        text: errorMsg
      });
      $wrapper.append($errorMsg);
    }
  }, {
    key: "removeError",
    value: function removeError($field) {
      var $wrapper = this.getFieldWrapper($field),
        $errorMsg = $wrapper.find('.error-msg');
      $wrapper.removeClass(this.ERROR_CLASS);
      $errorMsg.remove();
    }
  }, {
    key: "scrollToFirstError",
    value: function scrollToFirstError($form) {
      var $firstError = $form.find(".".concat(this.ERROR_CLASS)).first();
      if (!$firstError.length) {
        return;
      }
      var $target = this.findScrollableParent($form);
      if (!$target || !$target.length) {
        $target = $('html, body');
      }
      var scrollDiff = $firstError.offset().top - $target.offset().top;
      var scrollValue = scrollDiff;
      if (!$target.is('html, body')) {
        scrollValue = $target.get(0).scrollTop + scrollDiff;
      }
      $target.animate({
        scrollTop: scrollValue
      });
    }
  }, {
    key: "findScrollableParent",
    value: function findScrollableParent($node) {
      var node = $node.get(0);
      if (!node) {
        return null;
      }
      var overflowY, isScrollable;
      do {
        if (document === node) {
          return null;
        }
        overflowY = window.getComputedStyle(node).overflowY;
        isScrollable = overflowY !== 'visible' && overflowY !== 'hidden';
      } while (!(isScrollable && node.scrollHeight > node.clientHeight) && (node = node.parentNode));
      return $(node);
    }
  }]);
  return YITH_WCAF_Validation_Handler;
}();
function initValidation($container) {
  var _$container;
  // init container
  if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
    $container = $document;
  }
  return new YITH_WCAF_Validation_Handler($container);
}
;// CONCATENATED MODULE: ./assets/js/src/modules/enhanced-selects.js


/**
 * Internal dependencies
 */

var enhanceSelect = function enhanceSelect(select, args) {
    if (typeof $.fn.selectWoo === 'undefined') {
      return;
    }
    var allowClear = !!select.data('allow_clear'),
      placeholder = select.data('placeholder'),
      minimumInputLength = select.data('minimum_input_length'),
      action = select.data('action'),
      ajax = !!action;
    var config = {
      allowClear: allowClear,
      placeholder: placeholder,
      minimumInputLength: minimumInputLength || 3
    };
    if (ajax) {
      config.ajax = {
        url: ajaxUrl,
        dataType: 'json',
        delay: 250,
        data: function data(params) {
          return {
            term: params.term,
            action: action,
            security: select.data('security'),
            exclude: select.data('exclude'),
            include: select.data('include'),
            limit: select.data('limit')
          };
        },
        processResults: function processResults(data) {
          var terms = [];
          if (data) {
            $.each(data, function (id, text) {
              terms.push({
                id: id,
                text: text
              });
            });
          }
          return {
            results: terms
          };
        },
        cache: true
      };
    }
    config = $.extend(config, args || {});
    try {
      select.selectWoo(config).addClass('enhanced');
    } catch (e) {
      // skip to next.
    }
  },
  enhanceSelects = function enhanceSelects($container) {
    var _$container;
    if (typeof $.fn.selectWoo === 'undefined') {
      return;
    }

    // init container
    if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
      $container = $document;
    }
    var fieldToProcess = $('.yith-wcaf-enhanced-select', $container).not('.enhanced');
    fieldToProcess.each(function () {
      var select = $(this);
      enhanceSelect(select);
    });
  };

;// CONCATENATED MODULE: ./assets/js/src/modules/enhanced-datepickers.js


/**
 * Internal dependencies
 */

var enhanceDatepicker = function enhanceDatepicker(field) {
    if (typeof $.fn.datepicker === 'undefined') {
      return;
    }
    var format = field.data('format'),
      numberOfMonths = field.data('number-of-months'),
      maxDate = field.data('max-date'),
      minDate = field.data('min-date'),
      altField = field.data('altfield'),
      altFormat = field.data('altformat'),
      config = {
        dateFormat: format || 'yy-mm-dd',
        numberOfMonths: numberOfMonths || 1,
        maxDate: maxDate || null,
        minDate: minDate || null,
        altField: altField ? field.next(altField).get(0) : null,
        altFormat: altFormat || '',
        beforeShow: function beforeShow(input, inst) {
          var _inst$dpDiv;
          inst === null || inst === void 0 || (_inst$dpDiv = inst.dpDiv) === null || _inst$dpDiv === void 0 || (_inst$dpDiv = _inst$dpDiv.addClass('yith-wcaf-datepicker')) === null || _inst$dpDiv === void 0 || _inst$dpDiv.addClass('yith-plugin-fw-datepicker-div');
        },
        onClose: function onClose(input, inst) {
          var _inst$dpDiv2;
          inst === null || inst === void 0 || (_inst$dpDiv2 = inst.dpDiv) === null || _inst$dpDiv2 === void 0 || (_inst$dpDiv2 = _inst$dpDiv2.removeClass('yith-wcaf-datepicker')) === null || _inst$dpDiv2 === void 0 || _inst$dpDiv2.removeClass('yith-plugin-fw-datepicker-div');
        }
      };
    try {
      field.datepicker(config).addClass('enhanced');
    } catch (e) {
      // skip to next field.
    }
  },
  enhanceDatepickers = function enhanceDatepickers($container) {
    var _$container;
    if (typeof $.fn.datepicker === 'undefined') {
      return;
    }

    // init container
    if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
      $container = $document;
    }
    var fieldToProcess = $('.yith-wcaf-enhanced-date-picker', $container).add('.date-picker-field', $container).add('.date-picker', $container).not('.enhanced');
    fieldToProcess.each(function () {
      var field = $(this);
      enhanceDatepicker(field);
    });
  };

;// CONCATENATED MODULE: ./assets/js/src/modules/enhanced-accordion.js


/**
 * Internal dependencies
 */

var enhanceAccordion = function enhanceAccordion($field) {
    var $radio = $('.accordion-radio', $field);
    if (!$radio.length) {
      return;
    }
    $radio.on('change', function () {
      var $checked = $radio.filter(':checked'),
        $option = $checked.closest('.accordion-option'),
        $content = $option.find('.accordion-content');
      $('.accordion-content', $field).not($content).slideUp();
      $content.slideDown();
    }).trigger('change');
    $field.addClass('enhanced');
  },
  enhanceAccordions = function enhanceAccordions($container) {
    var _$container;
    // init container
    if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
      $container = $document;
    }
    var $accordion = $('.yith-wcaf-accordion', $container).not('.enhanced');
    if (!$accordion.length) {
      return;
    }
    $accordion.each(function () {
      var $field = $(this);
      enhanceAccordion($field);
    });
  };

// export utilities

;// CONCATENATED MODULE: ./assets/js/src/modules/enhanced-uploaders.js


/**
 * Internal dependencies
 */

var enhanceUploader = function enhanceUploader($anchor) {
    var $input = $anchor.parent().find('input[type="file"]');
    if (!$input.length) {
      return;
    }
    $anchor.on('click', function (ev) {
      ev.preventDefault();
      $input.trigger('click');
    }).addClass('enhanced');
    $input.on('change', function (ev) {
      var files = ev.target.files,
        fileNames = [];
      var $fileList = $anchor.next('small.files-list');
      for (var i in files) {
        if (!files.hasOwnProperty(i)) {
          continue;
        }
        fileNames.push(files[i].name);
      }
      if (!fileNames.length) {
        if ($fileList.length) {
          $fileList.remove();
        }
      } else {
        if (!$fileList.length) {
          $fileList = $('<small/>', {
            "class": 'files-list'
          });
          $anchor.after($fileList);
        }
        $fileList.text(fileNames.join(', '));
        if ($anchor.hasClass('auto-submit')) {
          var $form = $anchor.closest('form');
          if (!$form.length) {
            return;
          }
          $form.submit();
        }
      }
    });
  },
  enhanceUploaders = function enhanceUploaders($container) {
    var _$container;
    // init container
    if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
      $container = $document;
    }
    var $uploaders = $('.yith-wcaf-attach-file', $container).not('.enhanced');
    if (!$uploaders.length) {
      return;
    }
    $uploaders.each(function () {
      var $field = $(this);
      enhanceUploader($field);
    });
  };

// export utilities

;// CONCATENATED MODULE: ./assets/js/admin/src/modules/fields.js


/**
 * Internal dependencies
 */







var initFields = function initFields($container) {
  var _$container;
  // init container
  if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
    $container = $document;
  }

  // enhance selects
  enhanceSelects($container);

  // enhance datepicker
  enhanceDatepickers($container);

  // enhance toggles
  enhanceAccordions($container);

  // enhance uploader
  enhanceUploaders($container);

  // init dependencies
  initDependencies($container);

  // init validation
  initValidation($container);

  // enhance template fields
  (function () {
    var fieldToProcess = $('.yith-wcaf-enhanced-template', $container).not('.enhanced');
    fieldToProcess.each(function () {
      var $template = $(this),
        $editor = $template.find('.editor');
      $('a.toggle_editor', $template).text(function () {
        var $this = $(this);
        $this.text($this.data('view-label'));
      }).on('click', function () {
        var $this = $(this),
          editorVisible = $editor.is(':visible');
        $this.text($this.data("".concat(editorVisible ? 'view' : 'hide', "-label")));
        $editor.slideToggle();
        return false;
      });
      $('a.delete_template', $template).on('click', function () {
        return window.confirm($(this).data('confirm')); // eslint-disable-line no-alert
      });

      $('textarea', $editor).on('change', function () {
        var $this = $(this),
          name = $this.attr('data-name');
        if (name) {
          $this.attr('name', name);
        }
      });
      $template.addClass('enhanced');
    });
  })();

  // editable sections
  (function () {
    var $editable = $('.editable', $container).not('.enhanced');
    $editable.one('click', function () {
      var $trigger = $(this),
        $parent = $trigger.parent(),
        $target = $parent.find('.edit');
      if (!$target) {
        return;
      }
      var $edited = $parent.find('.edited');
      $edited.slideUp();
      $target.slideDown();
      $trigger.removeClass('editable');
    }).addClass('enhanced');
  })();

  // init custom fields postfix
  (function () {
    var $fields = $('[data-postfix]', $container).not('.enhanced');
    $fields.each(function () {
      var $field = $(this),
        $postfix = $('<span/>', {
          "class": 'field-postfix',
          text: $field.data('postfix'),
          style: 'line-height: 2.5; margin-left: 5px;'
        });
      $field.after($postfix);
    });
  })();

  // remove edit prompt when not needed (double $( fn ) is required to perform code after WC's handler)
  $(function () {
    // when field is contained in one of these items, onbeforeunload will be ignored
    var exceptions = ['.yith-plugin-fw-list-table-container'];
    $('input, textarea, select', $container).on('change', function () {
      var $closest = $(this).closest(exceptions.join(', '));
      if (!$closest.length) {
        return;
      }
      window.onbeforeunload = null;
    });
  });
};

// export utilities

;// CONCATENATED MODULE: ./assets/js/admin/src/admin.js


/**
 * Internal dependencies
 */


$(function () {
  return initFields();
});
var __webpack_export_target__ = window;
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=yith-wcaf.bundle.js.map