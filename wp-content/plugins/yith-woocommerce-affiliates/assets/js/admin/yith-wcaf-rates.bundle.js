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
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/setPrototypeOf.js
function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };
  return _setPrototypeOf(o, p);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/inherits.js

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }
  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  Object.defineProperty(subClass, "prototype", {
    writable: false
  });
  if (superClass) _setPrototypeOf(subClass, superClass);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/assertThisInitialized.js
function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }
  return self;
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/possibleConstructorReturn.js


function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  } else if (call !== void 0) {
    throw new TypeError("Derived constructors may only return object or undefined");
  }
  return _assertThisInitialized(self);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/getPrototypeOf.js
function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/defineProperty.js

function _defineProperty(obj, key, value) {
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
;// CONCATENATED MODULE: ./assets/js/src/globals.js


/* global jQuery yith_wcaf yith */

// these constants will be wrapped inside webpack closure, to prevent collisions

var _yith_wcaf, _yith_wcaf2, _yith_wcaf3;
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
var $ = jQuery,
  $document = $(document),
  $body = $('body'),
  block = function block($el) {
    if ('undefined' === typeof $.fn.block) {
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
    if ('undefined' === typeof $.fn.unblock) {
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
      if ('undefined' === typeof ((_yith = yith) === null || _yith === void 0 || (_yith = _yith.ui) === null || _yith === void 0 ? void 0 : _yith.confirm)) {
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
  },
  ajaxUrl = (_yith_wcaf = yith_wcaf) === null || _yith_wcaf === void 0 ? void 0 : _yith_wcaf.ajax_url,
  nonces = (_yith_wcaf2 = yith_wcaf) === null || _yith_wcaf2 === void 0 ? void 0 : _yith_wcaf2.nonces,
  labels = (_yith_wcaf3 = yith_wcaf) === null || _yith_wcaf3 === void 0 ? void 0 : _yith_wcaf3.labels;

;// CONCATENATED MODULE: ./assets/js/src/modules/dependencies.js


/* global yith_wcaf */




var YITH_WCAF_Dependencies_Handler = /*#__PURE__*/function () {
  function YITH_WCAF_Dependencies_Handler($container) {
    var _this$$container, _this$$fields;
    _classCallCheck(this, YITH_WCAF_Dependencies_Handler);
    // container
    _defineProperty(this, "$container", void 0);
    // fields;
    _defineProperty(this, "$fields", void 0);
    // dependencies tree.
    _defineProperty(this, "dependencies", {});
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
        var newBranch = _defineProperty({}, id, $field.data('dependencies'));
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
        var newBranch = _defineProperty({}, target, _defineProperty({}, id, value.toString().split(',')));
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
        var $field = _this2.findField(field),
          fieldValue;
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
        } else if (0 === condition.indexOf(':')) {
          result = $field.is(condition);
        } else if (0 === condition.indexOf('!:')) {
          result = !$field.is(condition.toString().substring(1));
        } else if (0 === condition.indexOf('!')) {
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


/* global yith_wcaf */




var YITH_WCAF_Validation_Handler = /*#__PURE__*/function () {
  function YITH_WCAF_Validation_Handler($container) {
    var _this$$container;
    _classCallCheck(this, YITH_WCAF_Validation_Handler);
    // container
    _defineProperty(this, "$container", void 0);
    // error class to add/remove to fields wrapper
    _defineProperty(this, "ERROR_CLASS", 'woocommerce-invalid');
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
        if ('checkbox' === fieldType && !$field.is(':checked')) {
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
      if ('number' === fieldType) {
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
          msg = 'checkbox' === fieldType ? (_labels$errors = labels.errors) === null || _labels$errors === void 0 ? void 0 : _labels$errors.accept_check : (_labels$errors2 = labels.errors) === null || _labels$errors2 === void 0 ? void 0 : _labels$errors2.compile_field;
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


/* global yith_wcaf, selectWoo */

var enhanceSelect = function enhanceSelect(select, args) {
    if ('undefined' === typeof $.fn.selectWoo) {
      return;
    }
    var allowClear = !!select.data('allow_clear'),
      placeholder = select.data('placeholder'),
      minimumInputLength = select.data('minimum_input_length'),
      action = select.data('action'),
      ajax = !!action,
      config;
    config = {
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
    if ('undefined' === typeof $.fn.selectWoo) {
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


/* global yith_wcaf */

var enhanceDatepicker = function enhanceDatepicker(field) {
    if ('undefined' === typeof $.fn.datepicker) {
      return;
    }
    var format = field.data('format'),
      numberOfMonths = field.data('number-of-months'),
      maxDate = field.data('max-date'),
      minDate = field.data('min-date'),
      altField = field.data('altfield'),
      altFormat = field.data('altformat'),
      config;
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
    if ('undefined' === typeof $.fn.datepicker) {
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


/* global yith_wcaf, selectWoo */

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


/* global yith_wcaf, selectWoo */

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
        $fileList.length && $fileList.remove();
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


/* global jQuery */







var fields_initFields = function initFields($container) {
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
        return window.confirm($(this).data('confirm'));
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

;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-admin-panel.js


/* global yith_wcaf */





var YITH_WCAF_Admin_Panel = /*#__PURE__*/function () {
  function YITH_WCAF_Admin_Panel($container) {
    _classCallCheck(this, YITH_WCAF_Admin_Panel);
    // container object.
    _defineProperty(this, "$container", void 0);
    this.$container = $container;
    this.initFields();
    this.initBulkAction();
  }
  _createClass(YITH_WCAF_Admin_Panel, [{
    key: "initFields",
    value: function initFields() {
      fields_initFields(this.$container);
    }
  }, {
    key: "initBulkAction",
    value: function initBulkAction() {
      var $bulkActionSelect = $('#bulk-action-selector-top', this.$container);
      if (!$bulkActionSelect.length) {
        return;
      }
      enhanceSelect($bulkActionSelect, {
        minimumResultsForSearch: Infinity,
        minimumInputLength: 0
      });
    }
  }]);
  return YITH_WCAF_Admin_Panel;
}();

;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/superPropBase.js

function _superPropBase(object, property) {
  while (!Object.prototype.hasOwnProperty.call(object, property)) {
    object = _getPrototypeOf(object);
    if (object === null) break;
  }
  return object;
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/get.js

function _get() {
  if (typeof Reflect !== "undefined" && Reflect.get) {
    _get = Reflect.get.bind();
  } else {
    _get = function _get(target, property, receiver) {
      var base = _superPropBase(target, property);
      if (!base) return;
      var desc = Object.getOwnPropertyDescriptor(base, property);
      if (desc.get) {
        return desc.get.call(arguments.length < 3 ? target : receiver);
      }
      return desc.value;
    };
  }
  return _get.apply(this, arguments);
}
;// CONCATENATED MODULE: ./assets/js/src/modules/ajax.js


/* global yith_wcaf */

function ajax_ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function ajax_objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ajax_ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ajax_ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }

var request = function request(method, action, security, params, args) {
    // retrieve wrapper as current context.
    var $wrapper = $(this);
    if (params instanceof FormData) {
      params.append('action', "yith_wcaf_".concat(action));
      params.append('security', nonces !== null && nonces !== void 0 && nonces[security] ? nonces === null || nonces === void 0 ? void 0 : nonces[security] : security);
    } else {
      params = ajax_objectSpread({
        action: "yith_wcaf_".concat(action),
        security: nonces !== null && nonces !== void 0 && nonces[security] ? nonces === null || nonces === void 0 ? void 0 : nonces[security] : security
      }, params);
    }
    var ajaxArgs = ajax_objectSpread({
      url: ajaxUrl,
      data: params,
      method: method,
      beforeSend: function beforeSend() {
        return $wrapper.length && block($wrapper);
      },
      complete: function complete() {
        return $wrapper.length && unblock($wrapper);
      }
    }, args);
    return $.ajax(ajaxArgs);
  },
  get = function get() {
    for (var _len = arguments.length, params = new Array(_len), _key = 0; _key < _len; _key++) {
      params[_key] = arguments[_key];
    }
    return request.call.apply(request, [this, 'get'].concat(params));
  },
  post = function post() {
    for (var _len2 = arguments.length, params = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      params[_key2] = arguments[_key2];
    }
    return request.call.apply(request, [this, 'post'].concat(params));
  };
/* harmony default export */ const ajax = ({
  request: request,
  get: get,
  post: post
});
;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-admin-table.js


/* global yith_wcaf */





var YITH_WCAF_Admin_Table = /*#__PURE__*/function () {
  function YITH_WCAF_Admin_Table($context, args) {
    _classCallCheck(this, YITH_WCAF_Admin_Table);
    // context
    _defineProperty(this, "$context", null);
    // table
    _defineProperty(this, "$table", null);
    // args
    _defineProperty(this, "args", null);
    if (!$context.length) {
      return;
    }
    var $table = $('table.wp-list-table', $context);
    if (!$table.length) {
      $table = $('.no-items-found', $context);
    }
    if (!$table.length) {
      return;
    }
    this.$context = $context;
    this.$table = $table;
    this.args = $.extend({
      action_suffix: '',
      nonce_suffix: ''
    }, args || {});
    this.init();
  }
  _createClass(YITH_WCAF_Admin_Table, [{
    key: "init",
    value: function init() {}
  }, {
    key: "doButtonAction",
    value: function doButtonAction(action, $button, onSuccess) {
      var _this$args,
        _this$args2,
        _this$args3,
        _this = this;
      var $row = $button.closest('tr');
      if (!$row.length) {
        return;
      }
      var data = (_this$args = this.args) === null || _this$args === void 0 ? void 0 : _this$args.data;
      if ('function' === typeof data) {
        data = data.call(this, $row);
      }
      this.doAjax("".concat(action).concat(((_this$args2 = this.args) === null || _this$args2 === void 0 ? void 0 : _this$args2.action_suffix) || ''), "".concat(action).concat(((_this$args3 = this.args) === null || _this$args3 === void 0 ? void 0 : _this$args3.nonce_suffix) || ''), data, function (result) {
        if ('function' === typeof onSuccess) {
          onSuccess($row, result);
        }
        if (result !== null && result !== void 0 && result.template) {
          _this.replaceTable(result.template);
        }
      });
    }
  }, {
    key: "doAjax",
    value: function doAjax(action, security, data, onSuccess) {
      return ajax.post.call(this.$context, action, security, data).done(function (answerData) {
        if ('function' === typeof onSuccess && answerData !== null && answerData !== void 0 && answerData.success) {
          onSuccess(answerData === null || answerData === void 0 ? void 0 : answerData.data);
        }
      });
    }
  }, {
    key: "replaceTable",
    value: function replaceTable(newTable) {
      var $newTable = $(newTable).find('table');
      if (!$newTable.length) {
        return;
      }
      this.$table.replaceWith($newTable);
      this.$table = $newTable;
    }
  }]);
  return YITH_WCAF_Admin_Table;
}();

;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-admin-modal.js


/* globals yith_wcaf, yith */




function yith_wcaf_admin_modal_ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function yith_wcaf_admin_modal_objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? yith_wcaf_admin_modal_ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : yith_wcaf_admin_modal_ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }


var YITH_WCAF_Admin_Modal = /*#__PURE__*/function () {
  function YITH_WCAF_Admin_Modal($opener, args) {
    var _yith;
    _classCallCheck(this, YITH_WCAF_Admin_Modal);
    // modal opener
    _defineProperty(this, "$opener", null);
    // target of the open event
    _defineProperty(this, "$target", null);
    // modal object
    _defineProperty(this, "modal", null);
    // fields validator
    _defineProperty(this, "validator", null);
    // template variables.
    _defineProperty(this, "args", null);
    if (!($opener !== null && $opener !== void 0 && $opener.length) || 'undefined' === typeof ((_yith = yith) === null || _yith === void 0 || (_yith = _yith.ui) === null || _yith === void 0 ? void 0 : _yith.modal)) {
      return;
    }
    this.$opener = $opener;
    this.args = $.extend({
      title: '',
      content: false,
      footer: false,
      showClose: true,
      width: 500,
      onCreate: false,
      onClose: false,
      shouldOpen: null,
      template: false,
      titleTemplate: false,
      data: false,
      classes: {
        wrap: 'yith-wcaf-modal'
      }
    }, args || {});
    this.init();
  }

  // setters
  _createClass(YITH_WCAF_Admin_Modal, [{
    key: "addOpeners",
    value: function addOpeners($newOpeners) {
      this.$opener = this.$opener.add($newOpeners);
      this.reinit();
    }

    // init methods
  }, {
    key: "init",
    value: function init() {
      var _this = this;
      this.$opener.on('click', function (ev) {
        _this.$target = $(ev.target);
        if (!_this.shouldOpen()) {
          return;
        }
        ev.preventDefault();
        _this.onOpen();
      });
    }
  }, {
    key: "reinit",
    value: function reinit() {
      this.$opener.off('click');
      this.init();
    }
  }, {
    key: "initFields",
    value: function initFields() {
      var self = this,
        $fields = this.getFields();

      // init fields values.
      $fields.filter('[data-value]').each(function () {
        var $field = $(this),
          value = $field.data('value');
        if ($field.is('input[type="checkbox"]') || $field.is('input[type="radio"]')) {
          if ('boolean' === typeof value) {
            $field.prop('checked', value);
          } else if (value) {
            $field.prop('checked', value === $field.val());
          } else {
            $field.prop('checked', false);
          }
        } else if ($field.is('select') && Array.isArray(value)) {
          $field.val(value);
        } else if ($field.is('select') && 'object' === _typeof(value)) {
          for (var i in value) {
            var _$field$find;
            if (!((_$field$find = $field.find("[value=\"".concat(i, "\"]"))) !== null && _$field$find !== void 0 && _$field$find.length)) {
              $field.append($('<option/>', {
                value: i,
                text: value[i]
              }));
            }
          }
          $field.val(Object.keys(value));
        } else if ('boolean' === typeof value) {
          $field.val(value ? 1 : 0);
        } else if (value) {
          $field.val(String(value));
        }
        $field.trigger('change');
      });

      // init custom fields handling
      fields_initFields(this.modal.elements.content);
    }
  }, {
    key: "initSubmit",
    value: function initSubmit() {
      var $content = this.modal.elements.content,
        $form = $content.find('form');
      $form.on('submit', this.onSubmit.bind(this));
    }

    // events handling
  }, {
    key: "getData",
    value: function getData() {
      var _this$args;
      var data = ((_this$args = this.args) === null || _this$args === void 0 ? void 0 : _this$args.data) || {};
      if ('function' === typeof data) {
        data = data.call(this);
      }
      return data;
    }
  }, {
    key: "shouldOpen",
    value: function shouldOpen() {
      var _this$args2;
      if ('function' === typeof ((_this$args2 = this.args) === null || _this$args2 === void 0 ? void 0 : _this$args2.shouldOpen)) {
        return this.args.shouldOpen.call(this);
      }
      return true;
    }
  }, {
    key: "onOpen",
    value: function onOpen() {
      var args = yith_wcaf_admin_modal_objectSpread({}, this.args),
        template = (args === null || args === void 0 ? void 0 : args.template) || '',
        titleTemplate = (args === null || args === void 0 ? void 0 : args.titleTemplate) || '',
        data = this.getData();
      if (template) {
        args.content = wp.template(template)(data);
      } else if ('function' === typeof (args === null || args === void 0 ? void 0 : args.content)) {
        args.content = args.content.call(this, data);
      }
      if (titleTemplate) {
        args.title = wp.template(titleTemplate)(data);
      } else if ('function' === typeof (args === null || args === void 0 ? void 0 : args.title)) {
        args.title = args.title.call(this, data);
      }
      this.modal = yith.ui.modal(args);

      // init enhanced selects
      $(document.body).trigger('wc-enhanced-select-init');

      // trigger additional functionalities
      this.initFields();

      // trigger submit handling.
      this.initSubmit();
    }
  }, {
    key: "beforeSubmit",
    value: function beforeSubmit() {
      return true;
    }
  }, {
    key: "onSubmit",
    value: function onSubmit() {
      var _this$args3;
      if (!this.beforeSubmit()) {
        return false;
      }
      if ('function' === typeof ((_this$args3 = this.args) === null || _this$args3 === void 0 ? void 0 : _this$args3.onSubmitSuccess)) {
        var _this$args4;
        (_this$args4 = this.args) === null || _this$args4 === void 0 || _this$args4.onSubmitSuccess();
      }
    }

    // fields handling
  }, {
    key: "getField",
    value: function getField(fieldName) {
      return this.getFields().filter("[name=\"".concat(fieldName, "\"]")).first();
    }
  }, {
    key: "getFields",
    value: function getFields() {
      var $content = this.modal.elements.content;
      return $content.find(':input').not('button, input[type="submit"], .select2-search__field');
    }
  }, {
    key: "serialize",
    value: function serialize() {
      var $fields = this.getFields();
      var data = {};
      $fields.get().reduce(function (a, field) {
        var $field = $(field);
        var value;
        if ($field.is('input[type="checkbox"]')) {
          if (!$field.is(':checked')) {
            return a;
          }
          value = 1;
        } else {
          value = $field.val();
        }
        var name = $field.attr('name');
        if (-1 !== name.indexOf('[')) {
          // if name is composite, try to recreate missing structure
          var components = name.split('[').map(function (c) {
              return c.replace(/[\[, \]]/g, '');
            }),
            firstComponent = components.shift(),
            newItem = components.reverse().reduce(function (res, key) {
              return _defineProperty({}, key, res);
            }, value);
          if ('undefined' === typeof data[firstComponent]) {
            data[firstComponent] = newItem;
          } else {
            data[firstComponent] = $.extend(true, data[firstComponent], newItem);
          }
        } else {
          // else simply append value to result object
          data[name] = value;
        }
        return a;
      }, data);
      return data;
    }

    // modal level errors
  }, {
    key: "showErrorMessage",
    value: function showErrorMessage(message) {
      var $content = this.modal.elements.content,
        $error = $('<div/>', {
          "class": 'error-message form-row',
          text: message
        });
      this.hideErrorMessage();
      $content.prepend($error);
      $error.get(0).scrollIntoView();
    }
  }, {
    key: "hideErrorMessage",
    value: function hideErrorMessage() {
      var $content = this.modal.elements.content;
      $content.children('.error-message').remove();
    }
  }]);
  return YITH_WCAF_Admin_Modal;
}();

;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-admin-actions-table.js


/* global yith_wcaf */








function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }



var YITH_WCAF_Admin_Actions_Table = /*#__PURE__*/function (_YITH_WCAF_Admin_Tabl) {
  _inherits(YITH_WCAF_Admin_Actions_Table, _YITH_WCAF_Admin_Tabl);
  var _super = _createSuper(YITH_WCAF_Admin_Actions_Table);
  function YITH_WCAF_Admin_Actions_Table() {
    var _this;
    _classCallCheck(this, YITH_WCAF_Admin_Actions_Table);
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }
    _this = _super.call.apply(_super, [this].concat(args));
    // modal
    _defineProperty(_assertThisInitialized(_this), "modal", null);
    return _this;
  }
  _createClass(YITH_WCAF_Admin_Actions_Table, [{
    key: "init",
    value: function init() {
      this.initModal();
      this.initDragNDrop();
      this.initCloneButtons();
      this.initDeleteButtons();
      this.initEnableButtons();
      this.initRestoreDefaultButton();
    }
  }, {
    key: "initCloneButtons",
    value: function initCloneButtons() {
      var self = this;
      this.$context.on('click', '.clone a', function (ev) {
        ev.preventDefault();
        self.doButtonAction('clone', $(this));
      });
    }
  }, {
    key: "initDeleteButtons",
    value: function initDeleteButtons() {
      var self = this;
      this.$context.on('click', '.delete a', function (ev) {
        var _this2 = this;
        ev.preventDefault();
        globals_confirm().then(function () {
          self.doButtonAction('delete', $(_this2), function ($row) {
            return $row.remove();
          });
        });
      });
    }
  }, {
    key: "initEnableButtons",
    value: function initEnableButtons() {
      var self = this;
      this.$context.on('change', '.enabled input[type="checkbox"]', function (ev) {
        ev.preventDefault();
        var $field = $(this),
          action = $field.is(':checked') ? 'enable' : 'disable';
        self.doButtonAction(action, $field);
      });
    }
  }, {
    key: "initModal",
    value: function initModal() {
      var $openers = this.getModalOpeners();
      if ($openers.length) {
        this.modal = new YITH_WCAF_Admin_Modal($openers);
      }
    }
  }, {
    key: "initDragNDrop",
    value: function initDragNDrop() {
      var _this3 = this;
      this.$table.find('tbody').sortable({
        handle: '.drag',
        update: function update() {
          var _this3$args, _this3$args2;
          var $rows = _this3.$table.find('tbody').find('tr'),
            rows = $rows.get(),
            order = rows.map(function (item) {
              return item.getAttribute('data-id');
            });
          _this3.doAjax("sort".concat((_this3$args = _this3.args) === null || _this3$args === void 0 ? void 0 : _this3$args.action_suffix, "s"), "sort".concat((_this3$args2 = _this3.args) === null || _this3$args2 === void 0 ? void 0 : _this3$args2.nonce_suffix, "s"), {
            order: order
          });
        }
      });
    }
  }, {
    key: "initRestoreDefaultButton",
    value: function initRestoreDefaultButton() {
      var _this4 = this;
      $('#restore_defaults', this.$context).on('click', function (ev) {
        var _this4$args, _this4$args2;
        ev.preventDefault();
        _this4.doAjax("restore_default".concat((_this4$args = _this4.args) === null || _this4$args === void 0 ? void 0 : _this4$args.action_suffix, "s"), "restore".concat((_this4$args2 = _this4.args) === null || _this4$args2 === void 0 ? void 0 : _this4$args2.nonce_suffix, "s"), null, function (data) {
          if (data !== null && data !== void 0 && data.template) {
            _this4.replaceTable(data.template);
          }
        });
      });
    }
  }, {
    key: "getModalOpeners",
    value: function getModalOpeners() {
      return $('.edit', this.$table).add('#add_field', this.$context).add('.yith-add-button', this.$context);
    }
  }, {
    key: "refreshModalOpeners",
    value: function refreshModalOpeners() {
      this.modal.addOpeners(this.getModalOpeners());
    }
  }, {
    key: "replaceTable",
    value: function replaceTable(newTable) {
      _get(_getPrototypeOf(YITH_WCAF_Admin_Actions_Table.prototype), "replaceTable", this).call(this, newTable);

      // register new modal openers
      this.initModal();

      // re-init drag&Drop
      this.initDragNDrop();
    }
  }]);
  return YITH_WCAF_Admin_Actions_Table;
}(YITH_WCAF_Admin_Table);

;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-add-rate-rule-modal.js


/* global yith_wcaf */






function yith_wcaf_add_rate_rule_modal_ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function yith_wcaf_add_rate_rule_modal_objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? yith_wcaf_add_rate_rule_modal_ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : yith_wcaf_add_rate_rule_modal_ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function yith_wcaf_add_rate_rule_modal_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_add_rate_rule_modal_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function yith_wcaf_add_rate_rule_modal_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }



var YITH_WCAF_Add_Rate_Rule_Modal = /*#__PURE__*/function (_YITH_WCAF_Admin_Moda) {
  _inherits(YITH_WCAF_Add_Rate_Rule_Modal, _YITH_WCAF_Admin_Moda);
  var _super = yith_wcaf_add_rate_rule_modal_createSuper(YITH_WCAF_Add_Rate_Rule_Modal);
  function YITH_WCAF_Add_Rate_Rule_Modal($opener, args) {
    _classCallCheck(this, YITH_WCAF_Add_Rate_Rule_Modal);
    return _super.call(this, $opener, yith_wcaf_add_rate_rule_modal_objectSpread({
      template: 'yith-wcaf-add-rate-rule-modal',
      title: function title(data) {
        return data.name ? labels === null || labels === void 0 ? void 0 : labels.edit_rate_rule_title : labels === null || labels === void 0 ? void 0 : labels.add_rate_rule_title;
      },
      data: function data() {
        var $target = this.$target,
          $dataSource = $target === null || $target === void 0 ? void 0 : $target.closest('[data-item]');
        if (!$dataSource || !$dataSource.length) {
          return {};
        }
        return $dataSource.data('item');
      },
      width: 400
    }, args));
  }
  _createClass(YITH_WCAF_Add_Rate_Rule_Modal, [{
    key: "onSubmit",
    value: function onSubmit() {
      var _this = this;
      var $content = this.modal.elements.content;
      if (!this.beforeSubmit()) {
        return false;
      }
      this.hideErrorMessage();
      ajax.post.call($content, 'save_rate_rule', 'save_rate_rule', {
        rule: this.serialize()
      }).done(function (data) {
        var _this$args, _data$data;
        if ('function' === typeof ((_this$args = _this.args) === null || _this$args === void 0 ? void 0 : _this$args.onSubmitSuccess)) {
          var _this$args2;
          (_this$args2 = _this.args) === null || _this$args2 === void 0 || _this$args2.onSubmitSuccess(data === null || data === void 0 ? void 0 : data.data);
        }
        if (data !== null && data !== void 0 && data.success) {
          _this.modal.close();
        } else if (data !== null && data !== void 0 && (_data$data = data.data) !== null && _data$data !== void 0 && _data$data.message) {
          _this.showErrorMessage(data.data.message);
        }
      });
      return false;
    }
  }]);
  return YITH_WCAF_Add_Rate_Rule_Modal;
}(YITH_WCAF_Admin_Modal);

;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-rate-rules-table.js


/* global yith_wcaf */






function yith_wcaf_rate_rules_table_ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function yith_wcaf_rate_rules_table_objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? yith_wcaf_rate_rules_table_ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : yith_wcaf_rate_rules_table_ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function yith_wcaf_rate_rules_table_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_rate_rules_table_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function yith_wcaf_rate_rules_table_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }


var YITH_WCAF_Rate_Rules_Table = /*#__PURE__*/function (_YITH_WCAF_Admin_Acti) {
  _inherits(YITH_WCAF_Rate_Rules_Table, _YITH_WCAF_Admin_Acti);
  var _super = yith_wcaf_rate_rules_table_createSuper(YITH_WCAF_Rate_Rules_Table);
  function YITH_WCAF_Rate_Rules_Table($context, args) {
    _classCallCheck(this, YITH_WCAF_Rate_Rules_Table);
    return _super.call(this, $context, yith_wcaf_rate_rules_table_objectSpread({
      action_suffix: '_rate_rule',
      nonce_suffix: '_rate_rule',
      data: function data($row) {
        return {
          rule_id: $row.data('id')
        };
      }
    }, args));
  }
  _createClass(YITH_WCAF_Rate_Rules_Table, [{
    key: "initModal",
    value: function initModal() {
      var _this = this;
      var $openers = this.getModalOpeners();
      if ($openers.length) {
        this.modal = new YITH_WCAF_Add_Rate_Rule_Modal($openers, {
          onSubmitSuccess: function onSubmitSuccess(data) {
            if (!(data !== null && data !== void 0 && data.template)) {
              return;
            }
            _this.replaceTable(data === null || data === void 0 ? void 0 : data.template);
          }
        });
      }
    }
  }]);
  return YITH_WCAF_Rate_Rules_Table;
}(YITH_WCAF_Admin_Actions_Table);

;// CONCATENATED MODULE: ./assets/js/admin/src/rates.js


/* global yith_wcaf */





function rates_createSuper(Derived) { var hasNativeReflectConstruct = rates_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function rates_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }



var YITH_WCAF_Rates = /*#__PURE__*/function (_YITH_WCAF_Admin_Pane) {
  _inherits(YITH_WCAF_Rates, _YITH_WCAF_Admin_Pane);
  var _super = rates_createSuper(YITH_WCAF_Rates);
  function YITH_WCAF_Rates() {
    var _this;
    _classCallCheck(this, YITH_WCAF_Rates);
    _this = _super.call(this, $('#yith_wcaf_panel_affiliates-rates'));
    _this.initTable();
    return _this;
  }
  _createClass(YITH_WCAF_Rates, [{
    key: "initTable",
    value: function initTable() {
      var $context = $('#yith_wcaf_panel_affiliates-rates');
      new YITH_WCAF_Rate_Rules_Table($context);
    }
  }]);
  return YITH_WCAF_Rates;
}(YITH_WCAF_Admin_Panel);
$(function () {
  return new YITH_WCAF_Rates();
});
var __webpack_export_target__ = window;
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=yith-wcaf-rates.bundle.js.map