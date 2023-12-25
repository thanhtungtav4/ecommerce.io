/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 61:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = (__webpack_require__(698)["default"]);
function _regeneratorRuntime() {
  "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */
  module.exports = _regeneratorRuntime = function _regeneratorRuntime() {
    return e;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  var t,
    e = {},
    r = Object.prototype,
    n = r.hasOwnProperty,
    o = Object.defineProperty || function (t, e, r) {
      t[e] = r.value;
    },
    i = "function" == typeof Symbol ? Symbol : {},
    a = i.iterator || "@@iterator",
    c = i.asyncIterator || "@@asyncIterator",
    u = i.toStringTag || "@@toStringTag";
  function define(t, e, r) {
    return Object.defineProperty(t, e, {
      value: r,
      enumerable: !0,
      configurable: !0,
      writable: !0
    }), t[e];
  }
  try {
    define({}, "");
  } catch (t) {
    define = function define(t, e, r) {
      return t[e] = r;
    };
  }
  function wrap(t, e, r, n) {
    var i = e && e.prototype instanceof Generator ? e : Generator,
      a = Object.create(i.prototype),
      c = new Context(n || []);
    return o(a, "_invoke", {
      value: makeInvokeMethod(t, r, c)
    }), a;
  }
  function tryCatch(t, e, r) {
    try {
      return {
        type: "normal",
        arg: t.call(e, r)
      };
    } catch (t) {
      return {
        type: "throw",
        arg: t
      };
    }
  }
  e.wrap = wrap;
  var h = "suspendedStart",
    l = "suspendedYield",
    f = "executing",
    s = "completed",
    y = {};
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}
  var p = {};
  define(p, a, function () {
    return this;
  });
  var d = Object.getPrototypeOf,
    v = d && d(d(values([])));
  v && v !== r && n.call(v, a) && (p = v);
  var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p);
  function defineIteratorMethods(t) {
    ["next", "throw", "return"].forEach(function (e) {
      define(t, e, function (t) {
        return this._invoke(e, t);
      });
    });
  }
  function AsyncIterator(t, e) {
    function invoke(r, o, i, a) {
      var c = tryCatch(t[r], t, o);
      if ("throw" !== c.type) {
        var u = c.arg,
          h = u.value;
        return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) {
          invoke("next", t, i, a);
        }, function (t) {
          invoke("throw", t, i, a);
        }) : e.resolve(h).then(function (t) {
          u.value = t, i(u);
        }, function (t) {
          return invoke("throw", t, i, a);
        });
      }
      a(c.arg);
    }
    var r;
    o(this, "_invoke", {
      value: function value(t, n) {
        function callInvokeWithMethodAndArg() {
          return new e(function (e, r) {
            invoke(t, n, e, r);
          });
        }
        return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
      }
    });
  }
  function makeInvokeMethod(e, r, n) {
    var o = h;
    return function (i, a) {
      if (o === f) throw new Error("Generator is already running");
      if (o === s) {
        if ("throw" === i) throw a;
        return {
          value: t,
          done: !0
        };
      }
      for (n.method = i, n.arg = a;;) {
        var c = n.delegate;
        if (c) {
          var u = maybeInvokeDelegate(c, n);
          if (u) {
            if (u === y) continue;
            return u;
          }
        }
        if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) {
          if (o === h) throw o = s, n.arg;
          n.dispatchException(n.arg);
        } else "return" === n.method && n.abrupt("return", n.arg);
        o = f;
        var p = tryCatch(e, r, n);
        if ("normal" === p.type) {
          if (o = n.done ? s : l, p.arg === y) continue;
          return {
            value: p.arg,
            done: n.done
          };
        }
        "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg);
      }
    };
  }
  function maybeInvokeDelegate(e, r) {
    var n = r.method,
      o = e.iterator[n];
    if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y;
    var i = tryCatch(o, e.iterator, r.arg);
    if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y;
    var a = i.arg;
    return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y);
  }
  function pushTryEntry(t) {
    var e = {
      tryLoc: t[0]
    };
    1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e);
  }
  function resetTryEntry(t) {
    var e = t.completion || {};
    e.type = "normal", delete e.arg, t.completion = e;
  }
  function Context(t) {
    this.tryEntries = [{
      tryLoc: "root"
    }], t.forEach(pushTryEntry, this), this.reset(!0);
  }
  function values(e) {
    if (e || "" === e) {
      var r = e[a];
      if (r) return r.call(e);
      if ("function" == typeof e.next) return e;
      if (!isNaN(e.length)) {
        var o = -1,
          i = function next() {
            for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next;
            return next.value = t, next.done = !0, next;
          };
        return i.next = i;
      }
    }
    throw new TypeError(_typeof(e) + " is not iterable");
  }
  return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", {
    value: GeneratorFunctionPrototype,
    configurable: !0
  }), o(GeneratorFunctionPrototype, "constructor", {
    value: GeneratorFunction,
    configurable: !0
  }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) {
    var e = "function" == typeof t && t.constructor;
    return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name));
  }, e.mark = function (t) {
    return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t;
  }, e.awrap = function (t) {
    return {
      __await: t
    };
  }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () {
    return this;
  }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) {
    void 0 === i && (i = Promise);
    var a = new AsyncIterator(wrap(t, r, n, o), i);
    return e.isGeneratorFunction(r) ? a : a.next().then(function (t) {
      return t.done ? t.value : a.next();
    });
  }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () {
    return this;
  }), define(g, "toString", function () {
    return "[object Generator]";
  }), e.keys = function (t) {
    var e = Object(t),
      r = [];
    for (var n in e) r.push(n);
    return r.reverse(), function next() {
      for (; r.length;) {
        var t = r.pop();
        if (t in e) return next.value = t, next.done = !1, next;
      }
      return next.done = !0, next;
    };
  }, e.values = values, Context.prototype = {
    constructor: Context,
    reset: function reset(e) {
      if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t);
    },
    stop: function stop() {
      this.done = !0;
      var t = this.tryEntries[0].completion;
      if ("throw" === t.type) throw t.arg;
      return this.rval;
    },
    dispatchException: function dispatchException(e) {
      if (this.done) throw e;
      var r = this;
      function handle(n, o) {
        return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o;
      }
      for (var o = this.tryEntries.length - 1; o >= 0; --o) {
        var i = this.tryEntries[o],
          a = i.completion;
        if ("root" === i.tryLoc) return handle("end");
        if (i.tryLoc <= this.prev) {
          var c = n.call(i, "catchLoc"),
            u = n.call(i, "finallyLoc");
          if (c && u) {
            if (this.prev < i.catchLoc) return handle(i.catchLoc, !0);
            if (this.prev < i.finallyLoc) return handle(i.finallyLoc);
          } else if (c) {
            if (this.prev < i.catchLoc) return handle(i.catchLoc, !0);
          } else {
            if (!u) throw new Error("try statement without catch or finally");
            if (this.prev < i.finallyLoc) return handle(i.finallyLoc);
          }
        }
      }
    },
    abrupt: function abrupt(t, e) {
      for (var r = this.tryEntries.length - 1; r >= 0; --r) {
        var o = this.tryEntries[r];
        if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) {
          var i = o;
          break;
        }
      }
      i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null);
      var a = i ? i.completion : {};
      return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a);
    },
    complete: function complete(t, e) {
      if ("throw" === t.type) throw t.arg;
      return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y;
    },
    finish: function finish(t) {
      for (var e = this.tryEntries.length - 1; e >= 0; --e) {
        var r = this.tryEntries[e];
        if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y;
      }
    },
    "catch": function _catch(t) {
      for (var e = this.tryEntries.length - 1; e >= 0; --e) {
        var r = this.tryEntries[e];
        if (r.tryLoc === t) {
          var n = r.completion;
          if ("throw" === n.type) {
            var o = n.arg;
            resetTryEntry(r);
          }
          return o;
        }
      }
      throw new Error("illegal catch attempt");
    },
    delegateYield: function delegateYield(e, r, n) {
      return this.delegate = {
        iterator: values(e),
        resultName: r,
        nextLoc: n
      }, "next" === this.method && (this.arg = t), y;
    }
  }, e;
}
module.exports = _regeneratorRuntime, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 698:
/***/ ((module) => {

function _typeof(o) {
  "@babel/helpers - typeof";

  return (module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
    return typeof o;
  } : function (o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports), _typeof(o);
}
module.exports = _typeof, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 687:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// TODO(Babel 8): Remove this file.

var runtime = __webpack_require__(61)();
module.exports = runtime;

// Copied from https://github.com/facebook/regenerator/blob/main/packages/runtime/runtime.js#L736=
try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  if (typeof globalThis === "object") {
    globalThis.regeneratorRuntime = runtime;
  } else {
    Function("r", "regeneratorRuntime = r")(runtime);
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
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

;// CONCATENATED MODULE: ./assets/js/src/modules/enhanced-toggles.js


/**
 * Internal dependencies
 */

var enhanceToggle = function enhanceToggle($field) {
    if ($field.next('.toggle').length) {
      return;
    }
    var text_on = $field.data('text-on'),
      text_off = $field.data('text-off'),
      $toggle = $('<span/>', {
        "class": 'toggle',
        'data-text-on': text_on || labels.toggle_on,
        'data-text-off': text_off || labels.toggle_off
      });
    $field.after($toggle).addClass('enhanced');
  },
  enhanceToggles = function enhanceToggles($container) {
    var _$container;
    // init container
    if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
      $container = $document;
    }
    var $toggles = $('.yith-wcaf-toggle', $container).not('.enhanced');
    if (!$toggles.length) {
      return;
    }
    $toggles.each(function () {
      var $field = $(this);
      enhanceToggle($field);
    });
  };

// export utilities

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
;// CONCATENATED MODULE: ./assets/images/eye.svg
const eye_namespaceObject = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<svg width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">\n    <defs>\n        <rect id=\"path-1\" x=\"0\" y=\"0\" width=\"24\" height=\"24\"></rect>\n    </defs>\n    <g id=\"Symbols\" stroke=\"none\" stroke-width=\"1\">\n        <g id=\"edit-/-show\">\n            <mask id=\"mask-2\" fill=\"white\">\n                <use xlink:href=\"#path-1\"></use>\n            </mask>\n            <g id=\"edit-/-show-(Background/Mask)\"></g>\n            <path d=\"M9,12 C9,13.642 10.358,15 12,15 C13.641,15 15,13.642 15,12 C15,10.359 13.641,9 12,9 C10.358,9 9,10.359 9,12 Z M2.10543073,11.684 L2,12 L2.10443617,12.316 C2.12631801,12.383 4.40799665,19 12,19 C19.5920014,19 21.8736803,12.383 21.8945675,12.316 L22,12 L21.8955631,11.684 C21.8736813,11.617 19.5920014,5 12,5 C4.40799665,5 2.12631794,11.617 2.10543073,11.684 Z M4.11657,12 C4.617863,10.842 6.68072367,7 12,7 C17.322258,7 19.3841249,10.846 19.8834286,12 C19.3821356,13.158 17.3192744,17 12,17 C6.6777401,17 4.61587369,13.154 4.11657,12 Z\" fill=\"#000\" mask=\"url(#mask-2)\"></path>\n        </g>\n    </g>\n</svg>";
;// CONCATENATED MODULE: ./assets/js/src/modules/fields.js


/**
 * Internal dependencies
 */









var initFields = function initFields($container) {
  var _$container;
  // init container
  if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
    $container = $document;
  }

  // init toggles
  enhanceToggles($container);

  // init datepicker
  enhanceDatepickers($container);

  // init accordions
  enhanceAccordions($container);

  // init selects
  enhanceSelects($container);

  // attach field
  enhanceUploaders($container);

  // password field
  (function () {
    var $password = $('input[type="password"]', $container);
    if (!$password.length) {
      return;
    }
    $password.each(function () {
      var $field = $(this);
      if ($field.hasClass('enhanced')) {
        return;
      }
      var $wrapper = $('<div/>', {
          "class": 'password-wrapper'
        }),
        $toggleButton = $('<a/>', {
          "class": 'toggle-button click-to-show',
          role: 'button',
          href: '',
          html: eye_namespaceObject,
          title: (labels === null || labels === void 0 ? void 0 : labels.show_password_text) || 'Show/Hide password'
        });
      $field.wrap($wrapper);
      $field.after($toggleButton);
      $toggleButton.on('click', function (ev) {
        var type = $field.attr('type'),
          isPassword = type === 'password',
          newType = isPassword ? 'text' : 'password',
          newClass = isPassword ? 'click-to-hide' : 'click-to-show';
        ev.preventDefault();
        $field.attr('type', newType);
        $toggleButton.removeClass('click-to-show click-to-hide').addClass(newClass);
      });
      $field.addClass('enhanced');
    });
  })();

  // type field
  (function () {
    var $type = $('#invoice_type_field', $container);
    if (!$type.length || $type.hasClass('enhanced')) {
      return;
    }
    var cnt = 1;
    $type.addClass('enhanced').find('label').each(function () {
      var $label = $(this),
        $checkbox = $label.prev(),
        wrapperClass = "col".concat(cnt);
      $label.add($checkbox).wrapAll("<div class=\"".concat(wrapperClass, "\">"));
      cnt++;
    });
  })();

  // init validation/dependencies on forms
  (function () {
    var $form = $('form', $container);
    if (!$form.length) {
      return false;
    }
    initValidation($form);
    initDependencies($form);
  })();

  // trigger after init
  $document.trigger('yith_wcaf_init_fields');
};

// export utilities

;// CONCATENATED MODULE: ./assets/js/src/modules/ajax.js


/**
 * Internal dependencies
 */

function ajax_ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function ajax_objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ajax_ownKeys(Object(t), !0).forEach(function (r) { defineProperty_defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ajax_ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }

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
;// CONCATENATED MODULE: ./assets/js/src/modules/set-cookie.js


/* global yith_wcaf, location */

/**
 * Internal dependencies
 */


var set_cookie_setCookie = function setCookie() {
  if (!yith_wcaf.set_cookie_via_ajax || !yith_wcaf.referral_var) {
    return;
  }
  var urlParams = new URLSearchParams(location.search);
  if (!urlParams.has(yith_wcaf.referral_var)) {
    return;
  }
  ajax.get.call(null, 'set_cookie', '', defineProperty_defineProperty({}, yith_wcaf.referral_var, urlParams.get(yith_wcaf.referral_var)));
};

// export utilities

;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
  try {
    var info = gen[key](arg);
    var value = info.value;
  } catch (error) {
    reject(error);
    return;
  }
  if (info.done) {
    resolve(value);
  } else {
    Promise.resolve(value).then(_next, _throw);
  }
}
function _asyncToGenerator(fn) {
  return function () {
    var self = this,
      args = arguments;
    return new Promise(function (resolve, reject) {
      var gen = fn.apply(self, args);
      function _next(value) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
      }
      function _throw(err) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
      }
      _next(undefined);
    });
  };
}
// EXTERNAL MODULE: ./node_modules/@babel/runtime/regenerator/index.js
var regenerator = __webpack_require__(687);
var regenerator_default = /*#__PURE__*/__webpack_require__.n(regenerator);
;// CONCATENATED MODULE: ./assets/js/src/modules/yith-wcaf-copy-button.js


/* global navigator */

/**
 * Internal dependencies
 */




var YITH_WCAF_Copy_Button = /*#__PURE__*/function () {
  function YITH_WCAF_Copy_Button($trigger, $target) {
    _classCallCheck(this, YITH_WCAF_Copy_Button);
    // copy button
    defineProperty_defineProperty(this, "$trigger", void 0);
    // event initiator
    defineProperty_defineProperty(this, "$initiator", void 0);
    // target whose content should be copied
    defineProperty_defineProperty(this, "target", void 0);
    if (!$trigger.length) {
      return;
    }
    this.$trigger = $trigger;
    this.target = $target;
    this.init();
  }
  _createClass(YITH_WCAF_Copy_Button, [{
    key: "init",
    value: function init() {
      this.$trigger.off('click').on('click', this.onClick.bind(this));
    }
  }, {
    key: "onClick",
    value: function onClick(ev) {
      ev.preventDefault();
      this.$initiator = $(ev.target);
      if (this.copyContent(ev)) {
        this.outputNotification();
      }
    }
  }, {
    key: "copyContent",
    value: function copyContent(ev) {
      var target = this.target;
      var $target;
      if (typeof target === 'function') {
        $target = target(this.$trigger, ev);
      } else {
        $target = target;
      }
      if (!$target.length) {
        return false;
      }
      if ($target.is('input')) {
        this.copyInputContent($target);
      } else {
        this.copyAnyContent($target);
      }
      return true;
    }
  }, {
    key: "copyInputContent",
    value: function copyInputContent($target) {
      this.selectContent($target);
      document.execCommand('copy');
    }
  }, {
    key: "copyAnyContent",
    value: function copyAnyContent($target) {
      var $hidden = $('<input/>', {
        val: $target.text(),
        type: 'text'
      });
      $body.append($hidden);
      this.selectContent($hidden);
      document.execCommand('copy');
      $hidden.remove();
    }
  }, {
    key: "selectContent",
    value: function selectContent($target) {
      if (this.isIos()) {
        $target.get(0).setSelectionRange(0, 9999);
      } else {
        $target.select();
      }
    }
  }, {
    key: "outputNotification",
    value: function outputNotification() {
      if (!$document.triggerHandler('yith_wcaf_hide_link_copied_alert') && labels !== null && labels !== void 0 && labels.link_copied_message) {
        var $confirmBubble = $('<span/>', {
          "class": 'copy-confirmation',
          text: labels.link_copied_message
        });
        $confirmBubble.prependTo(this.$initiator).fadeIn(300, function () {
          setTimeout(function () {
            $confirmBubble.fadeOut(300, function () {
              $confirmBubble.remove();
            });
          }, 1000);
        });
      }
    }
  }, {
    key: "isIos",
    value: function isIos() {
      return navigator.userAgent.match(/ipad|iphone/i);
    }
  }]);
  return YITH_WCAF_Copy_Button;
}();

;// CONCATENATED MODULE: ./assets/js/src/modules/yith-wcaf-link-generator.js


/**
 * Internal dependencies
 */








var YITH_WCAF_Link_Generator = /*#__PURE__*/function () {
  function YITH_WCAF_Link_Generator($container) {
    _classCallCheck(this, YITH_WCAF_Link_Generator);
    // container
    defineProperty_defineProperty(this, "$container", void 0);
    // source input
    defineProperty_defineProperty(this, "$source", void 0);
    // username input, if any
    defineProperty_defineProperty(this, "$username", void 0);
    // destination input
    defineProperty_defineProperty(this, "$destination", void 0);
    // affiliate token
    defineProperty_defineProperty(this, "token", void 0);
    // query string for token
    defineProperty_defineProperty(this, "token_var", void 0);
    // affiliate id, if any
    defineProperty_defineProperty(this, "affiliate", void 0);
    // timeout used for debouncing
    defineProperty_defineProperty(this, "timeout", void 0);
    // timout interval for debouncing
    defineProperty_defineProperty(this, "timeoutInterval", 500);
    if (!($container !== null && $container !== void 0 && $container.length)) {
      return;
    }
    this.$container = $container;
    this.token = this.$container.data('token');
    this.token_var = this.$container.data('token-var');
    this.affiliate = this.$container.data('affiliate');
    this.init();
  }
  _createClass(YITH_WCAF_Link_Generator, [{
    key: "init",
    value: function init() {
      this.$source = $('.origin-url', this.$container);
      this.$destination = $('.generated-url', this.$container);
      this.$username = $('.username', this.$container);
      if (!this.$source.length || !this.$destination.length) {
        return;
      }
      this.initActions();
      this.initCopyButton();
    }
  }, {
    key: "initActions",
    value: function initActions() {
      this.$source.on('change keyup', this.onChange.bind(this)).trigger('change');
    }
  }, {
    key: "initCopyButton",
    value: function initCopyButton() {
      this.$container.find('.copy-trigger').each(function () {
        var $trigger = $(this),
          $target = $trigger.parent().find('.copy-target');
        if (!$target.length) {
          return;
        }
        new YITH_WCAF_Copy_Button($trigger, $target);
      });
    }
  }, {
    key: "onChange",
    value: function onChange() {
      // debounce
      if (this.timeout) {
        clearTimeout(this.timeout);
      }
      if (!this.$source.val()) {
        return;
      }
      this.timeout = setTimeout(this.updateUrl.bind(this), this.timeoutInterval);
    }
  }, {
    key: "updateUrl",
    value: function () {
      var _updateUrl = _asyncToGenerator( /*#__PURE__*/regenerator_default().mark(function _callee() {
        var base, url, user, affiliate;
        return regenerator_default().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              base = this.$source.val();
              if (!(this.token_var && this.token)) {
                _context.next = 5;
                break;
              }
              url = this.calculateUrl(base, this.token_var, this.token);
              _context.next = 9;
              break;
            case 5:
              user = this.$username.val(), affiliate = this.affiliate;
              _context.next = 8;
              return this.requestUrl(base, user, affiliate);
            case 8:
              url = _context.sent;
            case 9:
              this.$destination.val(url);
            case 10:
            case "end":
              return _context.stop();
          }
        }, _callee, this);
      }));
      function updateUrl() {
        return _updateUrl.apply(this, arguments);
      }
      return updateUrl;
    }()
  }, {
    key: "calculateUrl",
    value: function calculateUrl(base, token_var, token) {
      var url;
      try {
        url = new URL(base);

        // if passed url's origin is different from current one, return.
        if (url.origin !== window.location.origin) {
          return '';
        }

        // append referral param.
        url.searchParams.set(token_var, token);
      } catch (e) {
        return '';
      }
      return url.toString();
    }
  }, {
    key: "requestUrl",
    value: function requestUrl(base, user, affiliate_id) {
      var _this = this;
      return new Promise(function (resolve) {
        ajax.get.call(_this.$container, 'get_referral_url', 'get_referral_url', {
          base: base,
          user: user,
          affiliate_id: affiliate_id
        }).done(function (data) {
          var url;
          if (data !== null && data !== void 0 && data.success) {
            var _data$data;
            url = data === null || data === void 0 || (_data$data = data.data) === null || _data$data === void 0 ? void 0 : _data$data.url;
          } else {
            url = '';
          }
          resolve(url);
        }).fail(function () {
          return resolve('');
        });
      });
    }
  }]);
  return YITH_WCAF_Link_Generator;
}();

;// CONCATENATED MODULE: ./assets/js/src/modules/yith-wcaf-set-referrer.js


/**
 * Internal dependencies
 */





var YITH_WCAF_Set_Referrer = /*#__PURE__*/function () {
  function YITH_WCAF_Set_Referrer($container) {
    _classCallCheck(this, YITH_WCAF_Set_Referrer);
    // container
    defineProperty_defineProperty(this, "$container", void 0);
    // box opener
    defineProperty_defineProperty(this, "$opener", void 0);
    // form
    defineProperty_defineProperty(this, "$form", void 0);
    // token input
    defineProperty_defineProperty(this, "$token", void 0);
    if (!($container !== null && $container !== void 0 && $container.length)) {
      return;
    }
    this.$container = $container;
    this.$opener = this.$container.find('.show-referrer-form');
    this.$form = this.$container.find('form.referrer-form');
    this.$token = this.$form.find('input[name="referrer_code"]');
    this.init();
  }
  _createClass(YITH_WCAF_Set_Referrer, [{
    key: "init",
    value: function init() {
      this.$opener.on('click', this.onToggle.bind(this));
      this.$form.on('submit', this.onSubmit.bind(this));
    }
  }, {
    key: "onToggle",
    value: function onToggle(ev) {
      ev.preventDefault();
      this.toggleForm();
    }
  }, {
    key: "onSubmit",
    value: function onSubmit(ev) {
      var _this = this;
      ev.preventDefault();
      var referrer = this.$token.val();
      if (!referrer) {
        return false;
      }
      this.$form.addClass('processing');
      this.setReferrer(referrer).done(function (data) {
        _this.$form.removeClass('processing');
        _this.afterSubmit(data);
      });
    }
  }, {
    key: "afterSubmit",
    value: function afterSubmit(data) {
      var _data$data;
      this.$container.find('.woocommerce-error, .woocommerce-message').remove();
      if (data !== null && data !== void 0 && (_data$data = data.data) !== null && _data$data !== void 0 && _data$data.template) {
        var _data$data2;
        this.$form.before(data === null || data === void 0 || (_data$data2 = data.data) === null || _data$data2 === void 0 ? void 0 : _data$data2.template);
      }
      if (data !== null && data !== void 0 && data.success) {
        this.$form.slideUp();
        this.$token.prop('disabled', true);
        $document.trigger('yith_wcaf_referrer_set');
      }
    }
  }, {
    key: "toggleForm",
    value: function toggleForm() {
      this.$form.slideToggle();
    }
  }, {
    key: "setReferrer",
    value: function setReferrer(referrer) {
      return ajax.post.call(this.$container, 'set_referrer', 'set_referrer', {
        referrer: referrer
      });
    }
  }]);
  return YITH_WCAF_Set_Referrer;
}();

;// CONCATENATED MODULE: ./assets/js/src/modules/yith-wcaf-tooltip.js


/**
 * Internal dependencies
 */




var YITH_WCAF_Tooltip = /*#__PURE__*/function () {
  function YITH_WCAF_Tooltip($opener) {
    _classCallCheck(this, YITH_WCAF_Tooltip);
    // copy button
    defineProperty_defineProperty(this, "$opener", void 0);
    // tooltip
    defineProperty_defineProperty(this, "$tooltip", void 0);
    if (!$opener.length) {
      return;
    }
    this.$opener = $opener.first();
    this.init();
  }
  _createClass(YITH_WCAF_Tooltip, [{
    key: "init",
    value: function init() {
      this.$opener.on('mouseenter', this.onMouseEnter.bind(this)).on('mouseleave', this.onMouseLeave.bind(this));
    }
  }, {
    key: "hasTooltip",
    value: function hasTooltip() {
      return this.$opener.find('.tooltip').length;
    }
  }, {
    key: "onMouseEnter",
    value: function onMouseEnter() {
      if (!this.hasTooltip()) {
        this.attachTooltip();
      }
      this.showTooltip();
    }
  }, {
    key: "onMouseLeave",
    value: function onMouseLeave() {
      this.hideTooltip();
    }
  }, {
    key: "attachTooltip",
    value: function attachTooltip() {
      if (this.hasTooltip()) {
        return;
      }
      var $tooltip = this.maybeBuildTooltip();
      this.$opener.append($tooltip);
    }
  }, {
    key: "detachTooltip",
    value: function detachTooltip() {
      var _this$$tooltip;
      if (!((_this$$tooltip = this.$tooltip) !== null && _this$$tooltip !== void 0 && _this$$tooltip.length)) {
        return;
      }
      this.$tooltip.detach();
    }
  }, {
    key: "showTooltip",
    value: function showTooltip() {
      var _this$$tooltip2;
      if (!((_this$$tooltip2 = this.$tooltip) !== null && _this$$tooltip2 !== void 0 && _this$$tooltip2.length)) {
        return;
      }
      return this.$tooltip.show().animate({
        opacity: 1
      });
    }
  }, {
    key: "hideTooltip",
    value: function hideTooltip() {
      var _this$$tooltip3,
        _this = this;
      if (!((_this$$tooltip3 = this.$tooltip) !== null && _this$$tooltip3 !== void 0 && _this$$tooltip3.length)) {
        return;
      }
      return this.$tooltip.animate({
        opacity: 0
      }, {
        complete: function complete() {
          _this.$tooltip.hide();
          _this.detachTooltip();
        }
      });
    }
  }, {
    key: "maybeBuildTooltip",
    value: function maybeBuildTooltip() {
      var _this$$tooltip4;
      if (!((_this$$tooltip4 = this.$tooltip) !== null && _this$$tooltip4 !== void 0 && _this$$tooltip4.length)) {
        var content = this.$opener.data('tip');
        this.$tooltip = $('<span/>', {
          html: content,
          "class": 'tooltip'
        });
      }
      return this.$tooltip;
    }
  }]);
  return YITH_WCAF_Tooltip;
}();

;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/assertThisInitialized.js
function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }
  return self;
}
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/getPrototypeOf.js
function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}
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
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/possibleConstructorReturn.js


function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  } else if (call !== void 0) {
    throw new TypeError("Derived constructors may only return object or undefined");
  }
  return _assertThisInitialized(self);
}
;// CONCATENATED MODULE: ./assets/js/src/modules/yith-wcaf-modal.js


/**
 * Internal dependencies
 */




var YITH_WCAF_Modal = /*#__PURE__*/function () {
  function YITH_WCAF_Modal($opener, args) {
    _classCallCheck(this, YITH_WCAF_Modal);
    // modal opener
    defineProperty_defineProperty(this, "$opener", null);
    // target of the open event
    defineProperty_defineProperty(this, "$target", null);
    // modal object
    defineProperty_defineProperty(this, "$modal", null);
    // modal content
    defineProperty_defineProperty(this, "$content", null);
    if (!($opener !== null && $opener !== void 0 && $opener.length)) {
      return;
    }
    this.$opener = $opener;
    this.args = $.extend({
      title: false,
      shouldOpen: false,
      template: false,
      onOpen: false,
      onClose: false
    }, args || {});
    this.init();
  }
  _createClass(YITH_WCAF_Modal, [{
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

    // events handling
  }, {
    key: "shouldOpen",
    value: function shouldOpen() {
      var _this$args;
      if (typeof ((_this$args = this.args) === null || _this$args === void 0 ? void 0 : _this$args.shouldOpen) === 'function') {
        return this.args.shouldOpen.call(this);
      }
      return true;
    }
  }, {
    key: "onOpen",
    value: function onOpen() {
      var _this$args2, _this$$content;
      var template = ((_this$args2 = this.args) === null || _this$args2 === void 0 ? void 0 : _this$args2.template) || '',
        $content = null;
      if (typeof template === 'function') {
        template = template.call(this);
      }
      if (!((_this$$content = this.$content) !== null && _this$$content !== void 0 && _this$$content.length)) {
        var _template;
        if (!template) {
          return;
        } else if (typeof template === 'string') {
          $content = $(template).detach();
        } else if (typeof template === 'function') {
          $content = template().detach();
        } else if ((_template = template) !== null && _template !== void 0 && _template.lenght) {
          $content = template.detach();
        }
        this.$content = $content;
      }
      this.maybeOpenModal(this.$content);
    }
  }, {
    key: "onClose",
    value: function onClose() {
      this.maybeCloseModal();
    }
  }, {
    key: "maybeBuildModal",
    value: function maybeBuildModal() {
      var _this$$modal,
        _this$args3,
        _this2 = this;
      if ((_this$$modal = this.$modal) !== null && _this$$modal !== void 0 && _this$$modal.length) {
        return this.$modal;
      }
      var $modal = $('<div/>', {
          "class": 'yith-wcaf-modal'
        }),
        $contentContainer = $('<div/>', {
          "class": 'content pretty-scrollbar'
        }),
        $closeButton = $('<a/>', {
          "class": 'close-button main-close-button',
          html: '&times;',
          role: 'button',
          href: '#'
        });
      this.$modal = $modal;
      $modal.append($contentContainer).append($closeButton);
      if ((_this$args3 = this.args) !== null && _this$args3 !== void 0 && _this$args3.title) {
        var $title = $('<div/>', {
          "class": 'title',
          html: "<h3>".concat(this.args.title, "</h3>")
        });
        $modal.prepend($title);
      }
      $modal.on('click', '.close-button', function (ev) {
        ev.preventDefault();
        _this2.onClose();
      });
      this.$target.closest('.yith-wcaf-section').append($modal);
      return this.$modal;
    }
  }, {
    key: "maybeDestroyModal",
    value: function maybeDestroyModal() {
      var _this$$modal2;
      if (!((_this$$modal2 = this.$modal) !== null && _this$$modal2 !== void 0 && _this$$modal2.length)) {
        return;
      }
      this.$modal.remove();
    }
  }, {
    key: "maybeOpenModal",
    value: function maybeOpenModal(content) {
      var _this$$modal3,
        _this3 = this;
      if (!((_this$$modal3 = this.$modal) !== null && _this$$modal3 !== void 0 && _this$$modal3.length)) {
        this.maybeBuildModal();
      }
      if (this.$modal.hasClass('open')) {
        return;
      }
      this.$modal.find('.content').append(content).end().fadeIn(function () {
        var _this3$args;
        _this3.$modal.addClass('open');
        if (typeof ((_this3$args = _this3.args) === null || _this3$args === void 0 ? void 0 : _this3$args.onOpen) === 'function') {
          var _this3$args2;
          (_this3$args2 = _this3.args) === null || _this3$args2 === void 0 || _this3$args2.onOpen.call(_this3);
        }
      });
      $body.addClass('yith-wcaf-open-modal');
    }
  }, {
    key: "maybeCloseModal",
    value: function maybeCloseModal() {
      var _this$$modal4,
        _this4 = this;
      if (!((_this$$modal4 = this.$modal) !== null && _this$$modal4 !== void 0 && _this$$modal4.length)) {
        this.maybeBuildModal();
      }
      if (!this.$modal.hasClass('open')) {
        return;
      }
      this.$modal.fadeOut(function () {
        var _this4$args;
        _this4.$modal.removeClass('open');
        $body.removeClass('yith-wcaf-open-modal');
        if (typeof ((_this4$args = _this4.args) === null || _this4$args === void 0 ? void 0 : _this4$args.onClose) === 'function') {
          var _this4$args2;
          (_this4$args2 = _this4.args) === null || _this4$args2 === void 0 || _this4$args2.onClose.call(_this4);
        }
      });
    }
  }]);
  return YITH_WCAF_Modal;
}();

;// CONCATENATED MODULE: ./assets/js/src/modules/yith-wcaf-ajax-submit-modal.js


/**
 * Internal dependencies
 */










function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }




var YITH_WCAF_Ajax_Submit_Modal = /*#__PURE__*/function (_YITH_WCAF_Modal) {
  _inherits(YITH_WCAF_Ajax_Submit_Modal, _YITH_WCAF_Modal);
  var _super = _createSuper(YITH_WCAF_Ajax_Submit_Modal);
  function YITH_WCAF_Ajax_Submit_Modal($opener, args) {
    var _this;
    _classCallCheck(this, YITH_WCAF_Ajax_Submit_Modal);
    args = $.extend({
      beforeSubmit: false,
      afterSubmit: false
    }, args || {});
    _this = _super.call(this, $opener, args);
    // form to submit, if any
    defineProperty_defineProperty(_assertThisInitialized(_this), "$form", null);
    return _this;
  }

  // event handler
  _createClass(YITH_WCAF_Ajax_Submit_Modal, [{
    key: "maybeOpenModal",
    value: function maybeOpenModal(content) {
      // open modal.
      _get(_getPrototypeOf(YITH_WCAF_Ajax_Submit_Modal.prototype), "maybeOpenModal", this).call(this, content);

      // init fields once modal is completely shown
      this.$modal.promise().done(this.maybeInitForm.bind(this));
    }
  }, {
    key: "maybeInitForm",
    value: function maybeInitForm() {
      var _this$$form;
      // skip if we already processed form
      if ((_this$$form = this.$form) !== null && _this$$form !== void 0 && _this$$form.length) {
        return;
      }

      // init form, if any inside the modal
      var $form = this.$modal.find('form');
      if (!$form.length) {
        return;
      }

      // init fields
      initFields($form);

      // init form submit handling
      $form.on('submit', this.maybeSubmitForm.bind(this));
      this.$form = $form;
    }
  }, {
    key: "maybeSubmitForm",
    value: function () {
      var _maybeSubmitForm = _asyncToGenerator( /*#__PURE__*/regenerator_default().mark(function _callee(ev) {
        var _this$args,
          _this2 = this;
        var _this$args2, answer;
        return regenerator_default().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              ev.preventDefault();
              if (typeof ((_this$args = this.args) === null || _this$args === void 0 ? void 0 : _this$args.beforeSubmit) === 'function') {
                this.args.beforeSubmit.call(this);
              }
              _context.prev = 2;
              _context.next = 5;
              return this.ajaxSubmit();
            case 5:
              answer = _context.sent;
              if (typeof ((_this$args2 = this.args) === null || _this$args2 === void 0 ? void 0 : _this$args2.afterSubmit) === 'function') {
                this.args.afterSubmit.call(this, answer);
              }
              _context.next = 13;
              break;
            case 9:
              _context.prev = 9;
              _context.t0 = _context["catch"](2);
              this.reportError(_context.t0);
              return _context.abrupt("return");
            case 13:
              setTimeout(function () {
                // close modal
                _this2.maybeCloseModal();

                // reload page
                window.location.reload();
              }, 3000);
            case 14:
            case "end":
              return _context.stop();
          }
        }, _callee, this, [[2, 9]]);
      }));
      function maybeSubmitForm(_x) {
        return _maybeSubmitForm.apply(this, arguments);
      }
      return maybeSubmitForm;
    }() // error reporting
  }, {
    key: "reportError",
    value: function reportError(error) {
      var $errors = this.$form.find('.errors');
      if (!$errors.length) {
        this.$form.prepend($('<p/>', {
          "class": 'errors form-row woocommerce-invalid',
          text: error
        }));
      } else {
        $errors.text(error);
      }
      this.$form.closest('.content').animate({
        scrollTop: 0
      });
    }
  }, {
    key: "hideErrors",
    value: function hideErrors() {
      this.$form.find('.errors').remove();
    }

    // ajax handling
  }, {
    key: "ajaxSubmit",
    value: function ajaxSubmit() {
      var _this3 = this;
      var action = this.$form.data('action'),
        nonce = this.$form.data('security');
      return new Promise(function (resolve, fail) {
        if (!action || !nonce) {
          fail('');
        }
        _this3.hideErrors();
        ajax.post.call(_this3.$modal, action, nonce, new FormData(_this3.$form.get(0)), {
          processData: false,
          contentType: false
        }).done(function (data) {
          if (data !== null && data !== void 0 && data.success) {
            resolve(data === null || data === void 0 ? void 0 : data.data);
          } else {
            var _data$data;
            fail(data === null || data === void 0 || (_data$data = data.data) === null || _data$data === void 0 ? void 0 : _data$data.message);
          }
        }).fail(function () {
          return fail('');
        });
      });
    }
  }]);
  return YITH_WCAF_Ajax_Submit_Modal;
}(YITH_WCAF_Modal);

;// CONCATENATED MODULE: ./assets/js/src/shortcodes.js


/* global yith_wcaf */

/**
 * Internal dependencies
 */











var YITH_WCAF_Shortcodes = /*#__PURE__*/function () {
  function YITH_WCAF_Shortcodes($container) {
    _classCallCheck(this, YITH_WCAF_Shortcodes);
    defineProperty_defineProperty(this, "$container", void 0);
    if (!$container.length) {
      return;
    }

    // set container object.
    this.$container = $container;

    // start up.
    this.init();
  }
  _createClass(YITH_WCAF_Shortcodes, [{
    key: "init",
    value: function init() {
      // init sequence.
      this.initTooltips();
      this.initCopyButtons();
      this.initLinkGenerator();
      this.initSetReferrer();
      this.initWithdrawModal();
      this.initSettings();

      // set cookie via ajax.
      this.setCookie();
    }
  }, {
    key: "initTooltips",
    value: function initTooltips() {
      var $tooltips = $('[data-tip]', this.$container);
      if (!$tooltips.length) {
        return;
      }
      $tooltips.each(function () {
        new YITH_WCAF_Tooltip($(this));
      });
    }
  }, {
    key: "initCopyButtons",
    value: function initCopyButtons() {
      this.$container.find('.copy-trigger').each(function () {
        var $trigger = $(this),
          $target = $trigger.parent().find('.copy-target');
        if (!$target.length) {
          return;
        }
        new YITH_WCAF_Copy_Button($trigger, $target);
      });
    }
  }, {
    key: "initLinkGenerator",
    value: function initLinkGenerator() {
      var $linkGenerator = $('.link-generator', this.$container);
      if (!$linkGenerator.length) {
        return;
      }
      new YITH_WCAF_Link_Generator($linkGenerator);
    }
  }, {
    key: "initSetReferrer",
    value: function initSetReferrer() {
      var $setReferrer = $('.set-referrer-wrapper', this.$container);
      if (!$setReferrer.length) {
        return;
      }
      new YITH_WCAF_Set_Referrer($setReferrer);
    }
  }, {
    key: "initWithdrawModal",
    value: function initWithdrawModal() {
      var $modalOpener = $('#withdraw_modal_opener', this.$container);
      if (!$modalOpener.length) {
        return;
      }
      new YITH_WCAF_Ajax_Submit_Modal($modalOpener, {
        template: '#withdraw_modal',
        title: labels === null || labels === void 0 ? void 0 : labels.withdraw_modal_title,
        afterSubmit: function afterSubmit(answer) {
          if (answer !== null && answer !== void 0 && answer.template) {
            var $content = this.$modal.find('.content'),
              $title = this.$modal.find('.title');
            $title.fadeOut();
            $content.fadeOut(function () {
              $content.empty().html(answer === null || answer === void 0 ? void 0 : answer.template).fadeIn();
            });
          } else {
            this.maybeCloseModal();
          }
        }
      });
    }
  }, {
    key: "initSettings",
    value: function initSettings() {
      var $container = this.$container;
      if (!$container.length) {
        return;
      }
      initFields($container);
    }
  }, {
    key: "setCookie",
    value: function setCookie() {
      if (!yith_wcaf.set_cookie_via_ajax || !yith_wcaf.referral_var) {
        return;
      }
      set_cookie_setCookie();
    }
  }]);
  return YITH_WCAF_Shortcodes;
}(); // init on document ready.
$(function () {
  return new YITH_WCAF_Shortcodes($('.yith-wcaf'));
});
})();

var __webpack_export_target__ = window;
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=yith-wcaf-shortcodes.bundle.js.map