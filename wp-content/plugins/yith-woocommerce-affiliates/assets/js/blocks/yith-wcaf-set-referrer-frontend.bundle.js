/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
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

;// CONCATENATED MODULE: external ["wc","blocksCheckout"]
const external_wc_blocksCheckout_namespaceObject = window["wc"]["blocksCheckout"];
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js
function _iterableToArrayLimit(arr, i) {
  var _i = null == arr ? null : "undefined" != typeof Symbol && arr[Symbol.iterator] || arr["@@iterator"];
  if (null != _i) {
    var _s,
      _e,
      _x,
      _r,
      _arr = [],
      _n = !0,
      _d = !1;
    try {
      if (_x = (_i = _i.call(arr)).next, 0 === i) {
        if (Object(_i) !== _i) return;
        _n = !1;
      } else for (; !(_n = (_s = _x.call(_i)).done) && (_arr.push(_s.value), _arr.length !== i); _n = !0);
    } catch (err) {
      _d = !0, _e = err;
    } finally {
      try {
        if (!_n && null != _i["return"] && (_r = _i["return"](), Object(_r) !== _r)) return;
      } finally {
        if (_d) throw _e;
      }
    }
    return _arr;
  }
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;
  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
  return arr2;
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/slicedToArray.js




function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}
;// CONCATENATED MODULE: external ["wp","i18n"]
const external_wp_i18n_namespaceObject = window["wp"]["i18n"];
;// CONCATENATED MODULE: external ["wp","hooks"]
const external_wp_hooks_namespaceObject = window["wp"]["hooks"];
;// CONCATENATED MODULE: external ["wp","element"]
const external_wp_element_namespaceObject = window["wp"]["element"];
;// CONCATENATED MODULE: external ["wp","data"]
const external_wp_data_namespaceObject = window["wp"]["data"];
;// CONCATENATED MODULE: external ["wp","compose"]
const external_wp_compose_namespaceObject = window["wp"]["compose"];
;// CONCATENATED MODULE: external ["wp","components"]
const external_wp_components_namespaceObject = window["wp"]["components"];
;// CONCATENATED MODULE: external "jQuery"
const external_jQuery_namespaceObject = window["jQuery"];
var external_jQuery_default = /*#__PURE__*/__webpack_require__.n(external_jQuery_namespaceObject);
;// CONCATENATED MODULE: ./assets/js/src/globals.js


/**
 * External dependencies
 */

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }


/* global yith_wcaf yith */

// these constants will be wrapped inside webpack closure, to prevent collisions

var $document = external_jQuery_default()(document),
  $body = external_jQuery_default()('body'),
  block = function block($el) {
    if (typeof (external_jQuery_default()).fn.block === 'undefined') {
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
    if (typeof (external_jQuery_default()).fn.unblock === 'undefined') {
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

;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/typeof.js
function _typeof(obj) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, _typeof(obj);
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
;// CONCATENATED MODULE: ./assets/js/src/modules/ajax.js


/**
 * Internal dependencies
 */

function ajax_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function ajax_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ajax_ownKeys(Object(source), !0).forEach(function (key) { defineProperty_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ajax_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

var request = function request(method, action, security, params, args) {
    // retrieve wrapper as current context.
    var $wrapper = external_jQuery_default()(this);
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
    return external_jQuery_default().ajax(ajaxArgs);
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
;// CONCATENATED MODULE: ./assets/js/blocks/src/set-referrer/block.js

/**
 * External dependencies
 */








/**
 * Internal dependencies
 */


var Block = function Block(_ref) {
  var instanceId = _ref.instanceId,
    className = _ref.className,
    defaultReferrer = _ref.defaultReferrer,
    displayReferrerForm = _ref.displayReferrerForm;
  var _useDispatch = (0,external_wp_data_namespaceObject.useDispatch)('core/notices'),
    createNotice = _useDispatch.createNotice;
  var _useState = (0,external_wp_element_namespaceObject.useState)(defaultReferrer),
    _useState2 = _slicedToArray(_useState, 2),
    referrer = _useState2[0],
    setReferrer = _useState2[1];
  var _useState3 = (0,external_wp_element_namespaceObject.useState)(false),
    _useState4 = _slicedToArray(_useState3, 2),
    isLoading = _useState4[0],
    setIsLoading = _useState4[1];
  var _useState5 = (0,external_wp_element_namespaceObject.useState)(!displayReferrerForm),
    _useState6 = _slicedToArray(_useState5, 2),
    isReferrerFormHidden = _useState6[0],
    setIsReferrerFormHidden = _useState6[1];
  var textInputId = "yith-block-components-set-referrer__input-".concat(instanceId);
  var formWrapperClass = "yith-block-components-set-referrer__content ".concat(isReferrerFormHidden ? 'screen-reader-text' : '');
  var handleReferrerAnchorClick = function handleReferrerAnchorClick(e) {
    e.preventDefault();
    setIsReferrerFormHidden(false);
  };
  var handleReferrerSubmit = function handleReferrerSubmit(e) {
    e.preventDefault();
    setIsLoading(true);
    ajax.post.call(null, 'set_referrer', 'set_referrer', {
      referrer: referrer
    }).done(function (data) {
      setIsLoading(false);
      if (data !== null && data !== void 0 && data.success) {
        var _data$data;
        setReferrer(referrer);
        setIsReferrerFormHidden(true);
        if (data !== null && data !== void 0 && (_data$data = data.data) !== null && _data$data !== void 0 && _data$data.message) {
          var _data$data2;
          createNotice('info', data === null || data === void 0 || (_data$data2 = data.data) === null || _data$data2 === void 0 ? void 0 : _data$data2.message, {
            id: 'coupon-form',
            type: 'snackbar',
            context: 'wc/checkout'
          });
        }
        $document.trigger('yith_wcaf_referrer_set');
      }
    });
  };
  var label = (0,external_wp_hooks_namespaceObject.applyFilters)('yith_wcaf_set_referrer_message', (0,external_wp_i18n_namespaceObject._x)('Did anyone suggest our site to you?', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates'));
  return /*#__PURE__*/React.createElement(external_wc_blocksCheckout_namespaceObject.TotalsWrapper, {
    className: className
  }, /*#__PURE__*/React.createElement("div", {
    className: "yith-block-components-set-referrer"
  }, isReferrerFormHidden ? /*#__PURE__*/React.createElement("a", {
    role: "button",
    href: "#yith-block-components-set-referrer__form",
    className: "yith-block-components-set-referrer-link",
    "aria-label": label,
    onClick: handleReferrerAnchorClick
  }, label) : /*#__PURE__*/React.createElement("div", {
    className: formWrapperClass
  }, /*#__PURE__*/React.createElement("form", {
    className: "yith-block-components-set-referrer__form",
    id: "yith-block-components-set-referrer__form"
  }, /*#__PURE__*/React.createElement(external_wc_blocksCheckout_namespaceObject.ValidatedTextInput, {
    id: textInputId,
    errorId: "coupon",
    className: "yith-block-components-set-referrer__input",
    label: (0,external_wp_i18n_namespaceObject._x)('Affiliate code', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates'),
    value: referrer,
    onChange: function onChange(newReferrer) {
      setReferrer(newReferrer);
    },
    focusOnMount: true,
    validateOnMount: false,
    showError: false
  }), /*#__PURE__*/React.createElement(external_wp_components_namespaceObject.Button, {
    className: "yith-block-components-set-referrer__button wp-element-button",
    disabled: isLoading || !referrer,
    onClick: handleReferrerSubmit,
    type: "submit"
  }, (0,external_wp_i18n_namespaceObject._x)('Set affiliate', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates'))))));
};
/* harmony default export */ const set_referrer_block = ((0,external_wp_compose_namespaceObject.withInstanceId)(Block));
;// CONCATENATED MODULE: ./assets/js/blocks/src/set-referrer/block.json
const set_referrer_block_namespaceObject = JSON.parse('{"apiVersion":2,"name":"yith/yith-wcaf-set-referrer","version":"2.16.0","title":"YITH Affiliates \\"Set Referrer\\" box","category":"yith","description":"Shows the \\"Set referrer\\" box, to allow customer set the user that suggested the site.","supports":{"html":false,"align":false,"multiple":false,"reusable":false},"parent":["woocommerce/checkout-totals-block","woocommerce/checkout-contact-information-block","woocommerce/checkout-shipping-address-block","woocommerce/checkout-billing-address-block","woocommerce/checkout-shipping-methods-block","woocommerce/checkout-payment-methods-block"],"textdomain":"yith-woocommerce-affiliates","editorStyle":"file:../../../../css/yith-wcaf.css"}');
;// CONCATENATED MODULE: ./assets/js/blocks/src/set-referrer/frontend.js
/**
 * External dependencies
 */


/**
 * Internal dependencies
 */


(0,external_wc_blocksCheckout_namespaceObject.registerCheckoutBlock)({
  metadata: set_referrer_block_namespaceObject,
  component: set_referrer_block
});
var __webpack_export_target__ = window;
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=yith-wcaf-set-referrer-frontend.bundle.js.map