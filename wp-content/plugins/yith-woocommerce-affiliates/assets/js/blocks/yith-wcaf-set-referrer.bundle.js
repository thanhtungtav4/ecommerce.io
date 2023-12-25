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

;// CONCATENATED MODULE: external ["wp","blocks"]
const external_wp_blocks_namespaceObject = window["wp"]["blocks"];
;// CONCATENATED MODULE: external ["wp","i18n"]
const external_wp_i18n_namespaceObject = window["wp"]["i18n"];
;// CONCATENATED MODULE: external ["wp","blockEditor"]
const external_wp_blockEditor_namespaceObject = window["wp"]["blockEditor"];
;// CONCATENATED MODULE: external ["wp","components"]
const external_wp_components_namespaceObject = window["wp"]["components"];
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




function slicedToArray_slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}
;// CONCATENATED MODULE: external ["wp","hooks"]
const external_wp_hooks_namespaceObject = window["wp"]["hooks"];
;// CONCATENATED MODULE: external ["wp","element"]
const external_wp_element_namespaceObject = window["wp"]["element"];
;// CONCATENATED MODULE: external ["wp","data"]
const external_wp_data_namespaceObject = window["wp"]["data"];
;// CONCATENATED MODULE: external ["wp","compose"]
const external_wp_compose_namespaceObject = window["wp"]["compose"];
;// CONCATENATED MODULE: external ["wc","blocksCheckout"]
const external_wc_blocksCheckout_namespaceObject = window["wc"]["blocksCheckout"];
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
    _useState2 = slicedToArray_slicedToArray(_useState, 2),
    referrer = _useState2[0],
    setReferrer = _useState2[1];
  var _useState3 = (0,external_wp_element_namespaceObject.useState)(false),
    _useState4 = slicedToArray_slicedToArray(_useState3, 2),
    isLoading = _useState4[0],
    setIsLoading = _useState4[1];
  var _useState5 = (0,external_wp_element_namespaceObject.useState)(!displayReferrerForm),
    _useState6 = slicedToArray_slicedToArray(_useState5, 2),
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
;// CONCATENATED MODULE: ./assets/js/blocks/src/set-referrer/edit.js
/**
 * External dependencies
 */




/**
 * Internal dependencies
 */

var Edit = function Edit(_ref) {
  var attributes = _ref.attributes;
  var referrer = attributes.referrer,
    className = attributes.className;
  var blockProps = (0,external_wp_blockEditor_namespaceObject.useBlockProps)();
  return /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement(external_wp_blockEditor_namespaceObject.InspectorControls, null, /*#__PURE__*/React.createElement(external_wp_components_namespaceObject.PanelBody, {
    title: (0,external_wp_i18n_namespaceObject._x)('Block options', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates')
  }, /*#__PURE__*/React.createElement(external_wp_components_namespaceObject.TextControl, {
    label: (0,external_wp_i18n_namespaceObject._x)('Initial affiliate token to show', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates'),
    type: "search",
    value: referrer
  }))), /*#__PURE__*/React.createElement(set_referrer_block, {
    className: className,
    referrer: referrer
  }));
};
var Save = function Save() {
  return /*#__PURE__*/React.createElement("div", external_wp_blockEditor_namespaceObject.useBlockProps.save());
};
;// CONCATENATED MODULE: ./assets/js/blocks/src/set-referrer/block.json
const set_referrer_block_namespaceObject = JSON.parse('{"apiVersion":2,"name":"yith/yith-wcaf-set-referrer","version":"2.16.0","title":"YITH Affiliates \\"Set Referrer\\" box","category":"yith","description":"Shows the \\"Set referrer\\" box, to allow customer set the user that suggested the site.","supports":{"html":false,"align":false,"multiple":false,"reusable":false},"parent":["woocommerce/checkout-totals-block","woocommerce/checkout-contact-information-block","woocommerce/checkout-shipping-address-block","woocommerce/checkout-billing-address-block","woocommerce/checkout-shipping-methods-block","woocommerce/checkout-payment-methods-block"],"textdomain":"yith-woocommerce-affiliates","editorStyle":"file:../../../../css/yith-wcaf.css"}');
;// CONCATENATED MODULE: external ["wp","url"]
const external_wp_url_namespaceObject = window["wp"]["url"];
;// CONCATENATED MODULE: ./plugin-fw/includes/builders/gutenberg/src/common/ajaxFetch.js
/**
 * Ajax Fetch
 */

/**
 * WordPress dependencies
 */


/**
 * Check status of ajax call
 * @param response
 * @returns {*}
 */
function ajaxCheckStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response;
  }
  throw response;
}

/**
 * Parse the response of the ajax call
 * @param response
 * @returns {*}
 */
function parseResponse(response) {
  return response.json ? response.json() : response.text();
}

/**
 * Fetch using WordPress Ajax
 *
 * @param {object} data The data to use in the ajax call.
 * @param {string} url The ajax URL.
 * @returns {Promise<Response>}
 */
var ajaxFetch = function ajaxFetch(data) {
  var _data$security;
  var url = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : yithGutenberg.ajaxurl;
  data.security = (_data$security = data.security) !== null && _data$security !== void 0 ? _data$security : yithGutenberg.ajaxNonce;
  url = addQueryArgs(url, data);
  return fetch(url).then(ajaxCheckStatus).then(parseResponse);
};
;// CONCATENATED MODULE: ./plugin-fw/includes/builders/gutenberg/src/common/icons.js
/**
 * SVG Icons
 */

/**
 * The YITH Logo Icon
 * @type {JSX.Element}
 */
var yith_icon = /*#__PURE__*/React.createElement("svg", {
  viewBox: "0 0 22 22",
  xmlns: "http://www.w3.org/2000/svg",
  width: "22",
  height: "22",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, /*#__PURE__*/React.createElement("path", {
  width: "22",
  height: "22",
  d: "M 18.24 7.628 C 17.291 8.284 16.076 8.971 14.587 9.688 C 15.344 7.186 15.765 4.851 15.849 2.684 C 15.912 0.939 15.133 0.045 13.514 0.003 C 11.558 -0.06 10.275 1.033 9.665 3.284 C 10.007 3.137 10.359 3.063 10.723 3.063 C 11.021 3.063 11.267 3.184 11.459 3.426 C 11.651 3.668 11.736 3.947 11.715 4.262 C 11.695 5.082 11.276 5.961 10.46 6.896 C 9.644 7.833 8.918 8.3 8.282 8.3 C 7.837 8.3 7.625 7.922 7.646 7.165 C 7.667 6.765 7.804 5.955 8.056 4.735 C 8.287 3.579 8.403 2.801 8.403 2.401 C 8.403 1.707 8.224 1.144 7.867 0.713 C 7.509 0.282 6.994 0.098 6.321 0.161 C 5.858 0.203 5.175 0.624 4.27 1.422 C 3.596 2.035 2.923 2.644 2.25 3.254 L 2.976 4.106 C 3.564 3.664 3.922 3.443 4.048 3.443 C 4.448 3.443 4.637 3.717 4.617 4.263 C 4.617 4.306 4.427 4.968 4.049 6.251 C 3.671 7.534 3.471 8.491 3.449 9.122 C 3.407 9.985 3.565 10.647 3.924 11.109 C 4.367 11.677 5.106 11.919 6.142 11.835 C 7.366 11.751 8.591 11.298 9.816 10.479 C 10.323 10.142 10.808 9.753 11.273 9.311 C 11.105 10.153 10.905 10.868 10.673 11.457 C 8.402 12.487 6.762 13.37 5.752 14.107 C 4.321 15.137 3.554 16.241 3.449 17.419 C 3.259 19.459 4.29 20.479 6.541 20.479 C 8.055 20.479 9.517 19.554 10.926 17.703 C 12.125 16.126 13.166 14.022 14.049 11.394 C 15.578 10.635 16.87 9.892 17.928 9.164 C 17.894 9.409 18.319 7.308 18.24 7.628 Z  M 7.393 16.095 C 7.056 16.095 6.898 15.947 6.919 15.653 C 6.961 15.106 7.908 14.38 9.759 13.476 C 8.791 15.221 8.002 16.095 7.393 16.095 Z"
}));
;// CONCATENATED MODULE: external "lodash"
const external_lodash_namespaceObject = window["lodash"];
;// CONCATENATED MODULE: ./plugin-fw/includes/builders/gutenberg/src/common/checkForDeps.js
/**
 * Check for dependencies
 *
 * @param {object} attributeArgs Attribute arguments.
 * @param {object} attributes The attributes.
 * @returns {boolean}
 */


var checkForSingleDep = function checkForSingleDep(attributes, dep, controlType) {
  var show = true;
  if (dep && dep.id && 'value' in dep) {
    var depValue = dep.value;
    if (['toggle', 'checkbox'].includes(controlType)) {
      depValue = true === depValue || 'yes' === depValue || 1 === depValue;
    }
    depValue = _.isArray(depValue) ? depValue : [depValue];
    show = typeof attributes[dep.id] !== 'undefined' && depValue.includes(attributes[dep.id]);
  }
  return show;
};
var checkForDeps_checkForDeps = function checkForDeps(attributeArgs, attributes) {
  var controlType = attributeArgs.controlType;
  var show = true;
  if (attributeArgs.deps) {
    if (_.isArray(attributeArgs.deps)) {
      for (var i in attributeArgs.deps) {
        var singleDep = attributeArgs.deps[i];
        show = checkForSingleDep(attributes, singleDep, controlType);
        if (!show) {
          break;
        }
      }
    } else {
      show = checkForSingleDep(attributes, attributeArgs.deps, controlType);
    }
  }
  return show;
};
;// CONCATENATED MODULE: ./plugin-fw/includes/builders/gutenberg/src/common/generateShortcode.js

/**
 * Internal dependencies
 */


/**
 * Generate the shortcode
 *
 * @param {object} blockArgs The block arguments.
 * @param {object} attributes The attributes
 * @returns {string}
 */
var generateShortcode = function generateShortcode(blockArgs, attributes) {
  var theShortcode = '';
  var callback = false;
  if (typeof blockArgs.callback !== 'undefined') {
    if (jQuery && blockArgs.callback in jQuery.fn) {
      callback = jQuery.fn[blockArgs.callback];
    } else if (blockArgs.callback in window) {
      callback = window[blockArgs.callback];
    }
  }
  if (typeof callback === 'function') {
    theShortcode = callback(attributes, blockArgs);
  } else {
    var shortcodeAttrs = blockArgs.attributes ? Object.entries(blockArgs.attributes).map(function (_ref) {
      var _ref2 = _slicedToArray(_ref, 2),
        attributeName = _ref2[0],
        attributeArgs = _ref2[1];
      var show = checkForDeps(attributeArgs, attributes);
      var value = attributes[attributeName];
      if (show && typeof value !== 'undefined') {
        var shortcodeValue = !!attributeArgs.remove_quotes ? value : "\"".concat(value, "\"");
        return attributeName + '=' + shortcodeValue;
      }
    }) : [];
    var shortcodeAttrsText = shortcodeAttrs.length ? ' ' + shortcodeAttrs.join(' ') : '';
    theShortcode = "[".concat(blockArgs.shortcode_name).concat(shortcodeAttrsText, "]");
  }
  return theShortcode;
};
;// CONCATENATED MODULE: ./plugin-fw/includes/builders/gutenberg/src/common/index.js




;// CONCATENATED MODULE: ./assets/js/blocks/src/set-referrer/index.js
/**
 * External dependencies
 */


/**
 * Internal dependencies
 */



(0,external_wp_blocks_namespaceObject.registerBlockType)(set_referrer_block_namespaceObject, {
  icon: {
    src: yith_icon
  },
  edit: Edit,
  save: Save
});
var __webpack_export_target__ = window;
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=yith-wcaf-set-referrer.bundle.js.map