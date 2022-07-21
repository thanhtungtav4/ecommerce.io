/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 61:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = (__webpack_require__(698)["default"]);

function _regeneratorRuntime() {
  "use strict";
  /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */

  module.exports = _regeneratorRuntime = function _regeneratorRuntime() {
    return exports;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  var exports = {},
      Op = Object.prototype,
      hasOwn = Op.hasOwnProperty,
      $Symbol = "function" == typeof Symbol ? Symbol : {},
      iteratorSymbol = $Symbol.iterator || "@@iterator",
      asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator",
      toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    return Object.defineProperty(obj, key, {
      value: value,
      enumerable: !0,
      configurable: !0,
      writable: !0
    }), obj[key];
  }

  try {
    define({}, "");
  } catch (err) {
    define = function define(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator,
        generator = Object.create(protoGenerator.prototype),
        context = new Context(tryLocsList || []);
    return generator._invoke = function (innerFn, self, context) {
      var state = "suspendedStart";
      return function (method, arg) {
        if ("executing" === state) throw new Error("Generator is already running");

        if ("completed" === state) {
          if ("throw" === method) throw arg;
          return doneResult();
        }

        for (context.method = method, context.arg = arg;;) {
          var delegate = context.delegate;

          if (delegate) {
            var delegateResult = maybeInvokeDelegate(delegate, context);

            if (delegateResult) {
              if (delegateResult === ContinueSentinel) continue;
              return delegateResult;
            }
          }

          if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) {
            if ("suspendedStart" === state) throw state = "completed", context.arg;
            context.dispatchException(context.arg);
          } else "return" === context.method && context.abrupt("return", context.arg);
          state = "executing";
          var record = tryCatch(innerFn, self, context);

          if ("normal" === record.type) {
            if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue;
            return {
              value: record.arg,
              done: context.done
            };
          }

          "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg);
        }
      };
    }(innerFn, self, context), generator;
  }

  function tryCatch(fn, obj, arg) {
    try {
      return {
        type: "normal",
        arg: fn.call(obj, arg)
      };
    } catch (err) {
      return {
        type: "throw",
        arg: err
      };
    }
  }

  exports.wrap = wrap;
  var ContinueSentinel = {};

  function Generator() {}

  function GeneratorFunction() {}

  function GeneratorFunctionPrototype() {}

  var IteratorPrototype = {};
  define(IteratorPrototype, iteratorSymbol, function () {
    return this;
  });
  var getProto = Object.getPrototypeOf,
      NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype);
  var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype);

  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function (method) {
      define(prototype, method, function (arg) {
        return this._invoke(method, arg);
      });
    });
  }

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);

      if ("throw" !== record.type) {
        var result = record.arg,
            value = result.value;
        return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) {
          invoke("next", value, resolve, reject);
        }, function (err) {
          invoke("throw", err, resolve, reject);
        }) : PromiseImpl.resolve(value).then(function (unwrapped) {
          result.value = unwrapped, resolve(result);
        }, function (error) {
          return invoke("throw", error, resolve, reject);
        });
      }

      reject(record.arg);
    }

    var previousPromise;

    this._invoke = function (method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function (resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
    };
  }

  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];

    if (undefined === method) {
      if (context.delegate = null, "throw" === context.method) {
        if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel;
        context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);
    if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel;
    var info = record.arg;
    return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel);
  }

  function pushTryEntry(locs) {
    var entry = {
      tryLoc: locs[0]
    };
    1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal", delete record.arg, entry.completion = record;
  }

  function Context(tryLocsList) {
    this.tryEntries = [{
      tryLoc: "root"
    }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0);
  }

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) return iteratorMethod.call(iterable);
      if ("function" == typeof iterable.next) return iterable;

      if (!isNaN(iterable.length)) {
        var i = -1,
            next = function next() {
          for (; ++i < iterable.length;) {
            if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next;
          }

          return next.value = undefined, next.done = !0, next;
        };

        return next.next = next;
      }
    }

    return {
      next: doneResult
    };
  }

  function doneResult() {
    return {
      value: undefined,
      done: !0
    };
  }

  return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) {
    var ctor = "function" == typeof genFun && genFun.constructor;
    return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name));
  }, exports.mark = function (genFun) {
    return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun;
  }, exports.awrap = function (arg) {
    return {
      __await: arg
    };
  }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
    return this;
  }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    void 0 === PromiseImpl && (PromiseImpl = Promise);
    var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl);
    return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) {
      return result.done ? result.value : iter.next();
    });
  }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () {
    return this;
  }), define(Gp, "toString", function () {
    return "[object Generator]";
  }), exports.keys = function (object) {
    var keys = [];

    for (var key in object) {
      keys.push(key);
    }

    return keys.reverse(), function next() {
      for (; keys.length;) {
        var key = keys.pop();
        if (key in object) return next.value = key, next.done = !1, next;
      }

      return next.done = !0, next;
    };
  }, exports.values = values, Context.prototype = {
    constructor: Context,
    reset: function reset(skipTempReset) {
      if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) {
        "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined);
      }
    },
    stop: function stop() {
      this.done = !0;
      var rootRecord = this.tryEntries[0].completion;
      if ("throw" === rootRecord.type) throw rootRecord.arg;
      return this.rval;
    },
    dispatchException: function dispatchException(exception) {
      if (this.done) throw exception;
      var context = this;

      function handle(loc, caught) {
        return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i],
            record = entry.completion;
        if ("root" === entry.tryLoc) return handle("end");

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc"),
              hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
            if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
          } else {
            if (!hasFinally) throw new Error("try statement without catch or finally");
            if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
          }
        }
      }
    },
    abrupt: function abrupt(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];

        if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null);
      var record = finallyEntry ? finallyEntry.completion : {};
      return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record);
    },
    complete: function complete(record, afterLoc) {
      if ("throw" === record.type) throw record.arg;
      return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel;
    },
    finish: function finish(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel;
      }
    },
    "catch": function _catch(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];

        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;

          if ("throw" === record.type) {
            var thrown = record.arg;
            resetTryEntry(entry);
          }

          return thrown;
        }
      }

      throw new Error("illegal catch attempt");
    },
    delegateYield: function delegateYield(iterable, resultName, nextLoc) {
      return this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      }, "next" === this.method && (this.arg = undefined), ContinueSentinel;
    }
  }, exports;
}

module.exports = _regeneratorRuntime, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 698:
/***/ ((module) => {

function _typeof(obj) {
  "@babel/helpers - typeof";

  return (module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports), _typeof(obj);
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
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/createClass.js
function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
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
function _defineProperty(obj, key, value) {
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

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

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
    var _yith, _yith$ui;

    // if can't display modal, accept by default
    if ('undefined' === typeof ((_yith = yith) === null || _yith === void 0 ? void 0 : (_yith$ui = _yith.ui) === null || _yith$ui === void 0 ? void 0 : _yith$ui.confirm)) {
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
  // container
  // fields;
  // dependencies tree.
  function YITH_WCAF_Dependencies_Handler($container) {
    var _this$$container, _this$$fields;

    _classCallCheck(this, YITH_WCAF_Dependencies_Handler);

    _defineProperty(this, "$container", void 0);

    _defineProperty(this, "$fields", void 0);

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
      }); // backward compatibility with plugin-fw

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
          $container === null || $container === void 0 ? void 0 : $container.fadeIn();
        } else {
          $container === null || $container === void 0 ? void 0 : $container.hide();
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
      } // first of all search for container by id.


      var $container = $field.closest("#".concat(field, "_container")); // if we couldn't find item with correct id, search for a .form-row

      if (!$container.length) {
        $container = $field.closest('.form-row');
      } // finally, just assume closest table row is a valid container


      if (!$container.length) {
        $container = $field.closest('tr');
      } // if none of the previous worked, just fail to false


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
          fieldValue = $field.filter(':checked').val().toString();
        } else {
          var _$field$val;

          fieldValue = $field === null || $field === void 0 ? void 0 : (_$field$val = $field.val()) === null || _$field$val === void 0 ? void 0 : _$field$val.toString();
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
  // container
  // error class to add/remove to fields wrapper
  function YITH_WCAF_Validation_Handler($container) {
    var _this$$container;

    _classCallCheck(this, YITH_WCAF_Validation_Handler);

    _defineProperty(this, "$container", void 0);

    _defineProperty(this, "ERROR_CLASS", 'woocommerce-invalid');

    this.$container = $container;

    if (!((_this$$container = this.$container) !== null && _this$$container !== void 0 && _this$$container.length)) {
      return;
    }

    this.initValidation();
  } // init validation.


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
    } // fields handling.

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
          alwaysRequiredFields = ['reg_username', 'reg_email', 'reg_password']; // check for required fields

      if ($field.prop('required') || $wrapper.hasClass('required') || $wrapper.hasClass('validate-required') || $wrapper.hasClass('yith-plugin-fw--required') || alwaysRequiredFields.includes($field.get(0).id)) {
        if ('checkbox' === fieldType && !$field.is(':checked')) {
          throw 'missing';
        } else if (!value) {
          throw 'missing';
        }
      } // check for patterns


      var pattern = $wrapper.data('pattern');

      if (pattern) {
        var regex = new RegExp(pattern);

        if (!regex.test(value)) {
          throw 'malformed';
        }
      } // check for min length


      var minLength = $wrapper.data('min_length');

      if (minLength && value.length < minLength) {
        throw 'short';
      } // check for max length


      var maxLength = $wrapper.data('max_length');

      if (maxLength && value.length > maxLength) {
        throw 'long';
      } // check for number


      if ('number' === fieldType) {
        var min = parseFloat($field.attr('min')),
            max = parseFloat($field.attr('max')),
            numVal = parseFloat(value);

        if (min && min > numVal || max && max < numVal) {
          throw 'overflow';
        }
      } // all validation passed; we can return true.


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
        this.scrollToFirstError($form); // stop form submitting.

        return false;
      }

      return true;
    } // error handling.

  }, {
    key: "getErrorMsg",
    value: function getErrorMsg($field, errorType) {
      var _labels$errors, _labels$errors2, _labels$errors3, _labels$errors4, _labels$errors5;

      // check if we have a field-specific error message.
      var msg = $field.data('error');

      if (msg) {
        return msg;
      } // check if message is added to wrapper.


      var $wrapper = this.getFieldWrapper($field);
      msg = $wrapper.data('error');

      if (msg) {
        return msg;
      } // check if message is added to label.


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
      } // remove existing errors.


      $wrapper.find('.error-msg').remove(); // generate and append new error message.

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
  } catch (e) {// skip to next.
  }
},
    enhanceSelects = function enhanceSelects($container) {
  var _$container;

  if ('undefined' === typeof $.fn.selectWoo) {
    return;
  } // init container


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
      var _inst$dpDiv, _inst$dpDiv$addClass;

      inst === null || inst === void 0 ? void 0 : (_inst$dpDiv = inst.dpDiv) === null || _inst$dpDiv === void 0 ? void 0 : (_inst$dpDiv$addClass = _inst$dpDiv.addClass('yith-wcaf-datepicker')) === null || _inst$dpDiv$addClass === void 0 ? void 0 : _inst$dpDiv$addClass.addClass('yith-plugin-fw-datepicker-div');
    },
    onClose: function onClose(input, inst) {
      var _inst$dpDiv2, _inst$dpDiv2$removeCl;

      inst === null || inst === void 0 ? void 0 : (_inst$dpDiv2 = inst.dpDiv) === null || _inst$dpDiv2 === void 0 ? void 0 : (_inst$dpDiv2$removeCl = _inst$dpDiv2.removeClass('yith-wcaf-datepicker')) === null || _inst$dpDiv2$removeCl === void 0 ? void 0 : _inst$dpDiv2$removeCl.removeClass('yith-plugin-fw-datepicker-div');
    }
  };

  try {
    field.datepicker(config).addClass('enhanced');
  } catch (e) {// skip to next field.
  }
},
    enhanceDatepickers = function enhanceDatepickers($container) {
  var _$container;

  if ('undefined' === typeof $.fn.datepicker) {
    return;
  } // init container


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
}; // export utilities



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
}; // export utilities



;// CONCATENATED MODULE: ./assets/js/admin/src/modules/fields.js

/* global jQuery */









var fields_initFields = function initFields($container) {
  var _$container;

  // init container
  if (!((_$container = $container) !== null && _$container !== void 0 && _$container.length)) {
    $container = $document;
  } // enhance selects


  enhanceSelects($container); // enhance datepicker

  enhanceDatepickers($container); // enhance toggles

  enhanceAccordions($container); // enhance uploader

  enhanceUploaders($container); // init dependencies

  initDependencies($container); // init validation

  initValidation($container); // enhance template fields

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
  })(); // editable sections


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
  })(); // init custom fields postfix


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
  })(); // remove edit prompt when not needed (double $( fn ) is required to perform code after WC's handler)


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
}; // export utilities



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
;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/typeof.js
function _typeof(obj) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, _typeof(obj);
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



function ajax_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function ajax_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ajax_ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ajax_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }



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
  // context
  // table
  // args
  function YITH_WCAF_Admin_Table($context, args) {
    _classCallCheck(this, YITH_WCAF_Admin_Table);

    _defineProperty(this, "$context", null);

    _defineProperty(this, "$table", null);

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






function yith_wcaf_admin_modal_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function yith_wcaf_admin_modal_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? yith_wcaf_admin_modal_ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : yith_wcaf_admin_modal_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }




var YITH_WCAF_Admin_Modal = /*#__PURE__*/function () {
  // modal opener
  // target of the open event
  // modal object
  // fields validator
  // template variables.
  function YITH_WCAF_Admin_Modal($opener, args) {
    var _yith, _yith$ui;

    _classCallCheck(this, YITH_WCAF_Admin_Modal);

    _defineProperty(this, "$opener", null);

    _defineProperty(this, "$target", null);

    _defineProperty(this, "modal", null);

    _defineProperty(this, "validator", null);

    _defineProperty(this, "args", null);

    if (!($opener !== null && $opener !== void 0 && $opener.length) || 'undefined' === typeof ((_yith = yith) === null || _yith === void 0 ? void 0 : (_yith$ui = _yith.ui) === null || _yith$ui === void 0 ? void 0 : _yith$ui.modal)) {
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
  } // setters


  _createClass(YITH_WCAF_Admin_Modal, [{
    key: "addOpeners",
    value: function addOpeners($newOpeners) {
      this.$opener = this.$opener.add($newOpeners);
      this.reinit();
    } // init methods

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
          $fields = this.getFields(); // init fields values.

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
      }); // init custom fields handling

      fields_initFields(this.modal.elements.content);
    }
  }, {
    key: "initSubmit",
    value: function initSubmit() {
      var $content = this.modal.elements.content,
          $form = $content.find('form');
      $form.on('submit', this.onSubmit.bind(this));
    } // events handling

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

      this.modal = yith.ui.modal(args); // init enhanced selects

      $(document.body).trigger('wc-enhanced-select-init'); // trigger additional functionalities

      this.initFields(); // trigger submit handling.

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

        (_this$args4 = this.args) === null || _this$args4 === void 0 ? void 0 : _this$args4.onSubmitSuccess();
      }
    } // fields handling

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
    } // modal level errors

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
      _get(_getPrototypeOf(YITH_WCAF_Admin_Actions_Table.prototype), "replaceTable", this).call(this, newTable); // register new modal openers


      this.initModal(); // re-init drag&Drop

      this.initDragNDrop();
    }
  }]);

  return YITH_WCAF_Admin_Actions_Table;
}(YITH_WCAF_Admin_Table);


;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-add-profile-field-modal.js

/* global yith_wcaf */









function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function yith_wcaf_add_profile_field_modal_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function yith_wcaf_add_profile_field_modal_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? yith_wcaf_add_profile_field_modal_ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : yith_wcaf_add_profile_field_modal_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function yith_wcaf_add_profile_field_modal_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_add_profile_field_modal_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function yith_wcaf_add_profile_field_modal_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }





var YITH_WCAF_Add_Profile_Field_Modal = /*#__PURE__*/function (_YITH_WCAF_Admin_Moda) {
  _inherits(YITH_WCAF_Add_Profile_Field_Modal, _YITH_WCAF_Admin_Moda);

  var _super = yith_wcaf_add_profile_field_modal_createSuper(YITH_WCAF_Add_Profile_Field_Modal);

  function YITH_WCAF_Add_Profile_Field_Modal($opener, args) {
    _classCallCheck(this, YITH_WCAF_Add_Profile_Field_Modal);

    return _super.call(this, $opener, yith_wcaf_add_profile_field_modal_objectSpread({
      template: 'yith-wcaf-add-affiliate-field-modal',
      title: function title(data) {
        return data.name ? labels === null || labels === void 0 ? void 0 : labels.edit_field_modal_title : labels === null || labels === void 0 ? void 0 : labels.add_field_modal_title;
      },
      data: function data() {
        var $target = this.$target,
            $dataSource = $target === null || $target === void 0 ? void 0 : $target.closest('[data-item]');

        if (!$dataSource || !$dataSource.length) {
          return {};
        }

        return $dataSource.data('item');
      },
      width: 550
    }, args));
  }

  _createClass(YITH_WCAF_Add_Profile_Field_Modal, [{
    key: "initFields",
    value: function initFields() {
      this.initOptionsTable();
      this.initCarbonCopyFields();

      _get(_getPrototypeOf(YITH_WCAF_Add_Profile_Field_Modal.prototype), "initFields", this).call(this);
    }
  }, {
    key: "initOptionsTable",
    value: function initOptionsTable() {
      var _this = this;

      var $content = this.modal.elements.content,
          $optionsTable = $content.find('#options_table');

      if (!$optionsTable.length) {
        return;
      } // populate table with existing options.


      var data = this.getData(),
          options = data === null || data === void 0 ? void 0 : data.options;

      if (options !== null && options !== void 0 && options.length) {
        var _iterator = _createForOfIteratorHelper(options),
            _step;

        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var option = _step.value;
            this.addOption(option);
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }
      } else {
        this.addOption({});
      } // init add button.


      $content.find('#add_new_option').on('click', function (ev) {
        ev.preventDefault();

        _this.addOption({});
      }); // init delete buttons.

      $optionsTable.on('click', '.delete', function (ev) {
        ev.preventDefault();
        $(this).closest('tr').remove();
      }); // init drag&drop

      $optionsTable.find('tbody').sortable({
        handle: '.drag'
      });
    }
  }, {
    key: "addOption",
    value: function addOption(option) {
      var $content = this.modal.elements.content,
          optionsTable = $content.find('#options_table');

      if (!optionsTable.length) {
        return;
      }

      var id = optionsTable.data('id') || 0;
      var row = wp.template('yith-wcaf-add-affiliate-field-option')(yith_wcaf_add_profile_field_modal_objectSpread({
        id: id++
      }, option));
      optionsTable.data('id', id).find('tbody').append(row);
    }
  }, {
    key: "initCarbonCopyFields",
    value: function initCarbonCopyFields() {
      var self = this,
          $fields = this.getFields();
      $fields.on('keydown', function () {
        var $field = $(this),
            $copy_fields = $fields.filter('[data-copy-target]'),
            value = $field.val();
        $copy_fields.each(function () {
          var $copy_field = $(this),
              target = $copy_field.data('copy-target'),
              $target = $(target, self.modal.elements.content);

          if (!$target.length || !$target.is($field)) {
            return;
          }

          var currentValue = $copy_field.val();

          if (!currentValue || currentValue === value) {
            setTimeout(function () {
              $copy_field.val($field.val());
            }, 100);
          }
        });
      });
    }
  }, {
    key: "onSubmit",
    value: function onSubmit() {
      var _this2 = this;

      var $content = this.modal.elements.content;

      if (!this.beforeSubmit()) {
        return false;
      }

      this.hideErrorMessage();
      ajax.post.call($content, 'save_affiliate_profile_field', 'save_profile_field', {
        field_name: this.getField('prev_name').val(),
        field: this.serialize()
      }).done(function (data) {
        var _this2$args, _data$data;

        if ('function' === typeof ((_this2$args = _this2.args) === null || _this2$args === void 0 ? void 0 : _this2$args.onSubmitSuccess)) {
          var _this2$args2;

          (_this2$args2 = _this2.args) === null || _this2$args2 === void 0 ? void 0 : _this2$args2.onSubmitSuccess(data === null || data === void 0 ? void 0 : data.data);
        }

        if (data !== null && data !== void 0 && data.success) {
          _this2.modal.close();
        } else if (data !== null && data !== void 0 && (_data$data = data.data) !== null && _data$data !== void 0 && _data$data.message) {
          _this2.showErrorMessage(data.data.message);
        }
      });
      return false;
    }
  }]);

  return YITH_WCAF_Add_Profile_Field_Modal;
}(YITH_WCAF_Admin_Modal);


;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-profile-fields-table.js

/* global yith_wcaf */








function yith_wcaf_profile_fields_table_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function yith_wcaf_profile_fields_table_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? yith_wcaf_profile_fields_table_ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : yith_wcaf_profile_fields_table_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function yith_wcaf_profile_fields_table_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_profile_fields_table_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function yith_wcaf_profile_fields_table_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }




var YITH_WCAF_Profile_Fields_Table = /*#__PURE__*/function (_YITH_WCAF_Admin_Acti) {
  _inherits(YITH_WCAF_Profile_Fields_Table, _YITH_WCAF_Admin_Acti);

  var _super = yith_wcaf_profile_fields_table_createSuper(YITH_WCAF_Profile_Fields_Table);

  function YITH_WCAF_Profile_Fields_Table($context, args) {
    _classCallCheck(this, YITH_WCAF_Profile_Fields_Table);

    return _super.call(this, $context, yith_wcaf_profile_fields_table_objectSpread({
      action_suffix: '_affiliate_profile_field',
      nonce_suffix: '_profile_field',
      data: function data($row) {
        return {
          field_name: $row.data('id')
        };
      }
    }, args));
  }

  _createClass(YITH_WCAF_Profile_Fields_Table, [{
    key: "initModal",
    value: function initModal() {
      var _this = this;

      var $openers = this.getModalOpeners();

      if ($openers.length) {
        this.modal = new YITH_WCAF_Add_Profile_Field_Modal($openers, {
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

  return YITH_WCAF_Profile_Fields_Table;
}(YITH_WCAF_Admin_Actions_Table);


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
;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-admin-ajax-modal.js

/* global yith_wcaf */












function yith_wcaf_admin_ajax_modal_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_admin_ajax_modal_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function yith_wcaf_admin_ajax_modal_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }




var YITH_WCAF_Admin_Ajax_Modal = /*#__PURE__*/function (_YITH_WCAF_Admin_Moda) {
  _inherits(YITH_WCAF_Admin_Ajax_Modal, _YITH_WCAF_Admin_Moda);

  var _super = yith_wcaf_admin_ajax_modal_createSuper(YITH_WCAF_Admin_Ajax_Modal);

  // action used to retrieve template
  // security used to retrieve templates
  function YITH_WCAF_Admin_Ajax_Modal($opener, args) {
    var _this$$opener;

    var _this;

    _classCallCheck(this, YITH_WCAF_Admin_Ajax_Modal);

    _this = _super.call(this, $opener, args);

    _defineProperty(_assertThisInitialized(_this), "action", void 0);

    _defineProperty(_assertThisInitialized(_this), "security", void 0);

    if (!((_this$$opener = _this.$opener) !== null && _this$$opener !== void 0 && _this$$opener.length)) {
      return _possibleConstructorReturn(_this);
    }

    _this.action = _this.$opener.data('action');
    _this.security = _this.$opener.data('security');
    return _this;
  }

  _createClass(YITH_WCAF_Admin_Ajax_Modal, [{
    key: "onOpen",
    value: function () {
      var _onOpen = _asyncToGenerator( /*#__PURE__*/regenerator_default().mark(function _callee() {
        var template;
        return regenerator_default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!(this.action && this.security)) {
                  _context.next = 7;
                  break;
                }

                _context.next = 3;
                return this.loadTemplate();

              case 3:
                template = _context.sent;

                if (template) {
                  _context.next = 6;
                  break;
                }

                return _context.abrupt("return", false);

              case 6:
                this.args.content = template;

              case 7:
                _get(_getPrototypeOf(YITH_WCAF_Admin_Ajax_Modal.prototype), "onOpen", this).call(this);

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function onOpen() {
        return _onOpen.apply(this, arguments);
      }

      return onOpen;
    }()
  }, {
    key: "loadTemplate",
    value: function loadTemplate() {
      var _this$args,
          _this$args2,
          _this2 = this;

      var data = ((_this$args = this.args) === null || _this$args === void 0 ? void 0 : _this$args.data) || {};

      if ('function' === typeof data) {
        data = data.call(this);
      }

      var blockTarget = ((_this$args2 = this.args) === null || _this$args2 === void 0 ? void 0 : _this$args2.blockTarget) || this.$opener;

      if ('function' === typeof blockTarget) {
        blockTarget = blockTarget.call(this, data);
      }

      return new Promise(function (resolve) {
        ajax.get.call(blockTarget, _this2.action, _this2.security, data).done(function (result) {
          var _result$data;

          if (!(result !== null && result !== void 0 && result.success) || !(result !== null && result !== void 0 && (_result$data = result.data) !== null && _result$data !== void 0 && _result$data.template)) {
            resolve(false);
          }

          resolve(result.data.template);
        }).fail(function () {
          return resolve(false);
        });
      });
    }
  }]);

  return YITH_WCAF_Admin_Ajax_Modal;
}(YITH_WCAF_Admin_Modal);


;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-edit-gateway-modal.js

/* global yith_wcaf */











function yith_wcaf_edit_gateway_modal_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function yith_wcaf_edit_gateway_modal_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? yith_wcaf_edit_gateway_modal_ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : yith_wcaf_edit_gateway_modal_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function yith_wcaf_edit_gateway_modal_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_edit_gateway_modal_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function yith_wcaf_edit_gateway_modal_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }





var YITH_WCAF_Edit_Gateway_Modal = /*#__PURE__*/function (_YITH_WCAF_Admin_Ajax) {
  _inherits(YITH_WCAF_Edit_Gateway_Modal, _YITH_WCAF_Admin_Ajax);

  var _super = yith_wcaf_edit_gateway_modal_createSuper(YITH_WCAF_Edit_Gateway_Modal);

  function YITH_WCAF_Edit_Gateway_Modal($opener, args) {
    _classCallCheck(this, YITH_WCAF_Edit_Gateway_Modal);

    return _super.call(this, $opener, yith_wcaf_edit_gateway_modal_objectSpread({
      title: function title(data) {
        return data === null || data === void 0 ? void 0 : data.title;
      },
      blockTarget: function blockTarget() {
        return this.$target.closest('table');
      },
      data: function data() {
        var $tr = this.$target.closest('tr');

        if (!$tr.length) {
          return {};
        }

        return {
          gateway_id: $tr.data('id'),
          title: $tr.data('name')
        };
      },
      width: 450
    }, args));
  }

  _createClass(YITH_WCAF_Edit_Gateway_Modal, [{
    key: "onOpen",
    value: function () {
      var _onOpen = _asyncToGenerator( /*#__PURE__*/regenerator_default().mark(function _callee() {
        var $form, $content, $pSubmit, $submitButton;
        return regenerator_default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _get(_getPrototypeOf(YITH_WCAF_Edit_Gateway_Modal.prototype), "onOpen", this).call(this);

              case 2:
                // wrap content inside form.
                $form = $('<form/>'), $content = this.modal.elements.content;
                $content.children().wrapAll($form); // append save button to modal content

                $pSubmit = $('<p/>', {
                  "class": 'form-row submit'
                }), $submitButton = $('<button/>', {
                  "class": 'submit button-primary',
                  text: labels === null || labels === void 0 ? void 0 : labels.generic_save_button
                });
                $pSubmit.appendTo($content.find('form')).append($submitButton); // repeat submit button int after appending new one.

                this.initSubmit();

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function onOpen() {
        return _onOpen.apply(this, arguments);
      }

      return onOpen;
    }()
  }, {
    key: "onSubmit",
    value: function onSubmit() {
      var _this = this;

      var $content = this.modal.elements.content;

      if (!this.beforeSubmit()) {
        return false;
      }

      this.hideErrorMessage();
      ajax.post.call($content, 'save_gateway_options', 'save_gateway_options', yith_wcaf_edit_gateway_modal_objectSpread(yith_wcaf_edit_gateway_modal_objectSpread({}, this.args.data.call(this)), this.serialize())).done(function (data) {
        var _this$args, _data$data;

        if ('function' === typeof ((_this$args = _this.args) === null || _this$args === void 0 ? void 0 : _this$args.onSubmitSuccess)) {
          var _this$args2;

          (_this$args2 = _this.args) === null || _this$args2 === void 0 ? void 0 : _this$args2.onSubmitSuccess(data === null || data === void 0 ? void 0 : data.data);
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

  return YITH_WCAF_Edit_Gateway_Modal;
}(YITH_WCAF_Admin_Ajax_Modal);


;// CONCATENATED MODULE: ./assets/js/admin/src/modules/yith-wcaf-gateways-table.js

/* global yith_wcaf */









function yith_wcaf_gateways_table_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function yith_wcaf_gateways_table_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? yith_wcaf_gateways_table_ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : yith_wcaf_gateways_table_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function yith_wcaf_gateways_table_createSuper(Derived) { var hasNativeReflectConstruct = yith_wcaf_gateways_table_isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function yith_wcaf_gateways_table_isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }





var YITH_WCAF_Gateways_Table = /*#__PURE__*/function (_YITH_WCAF_Admin_Tabl) {
  _inherits(YITH_WCAF_Gateways_Table, _YITH_WCAF_Admin_Tabl);

  var _super = yith_wcaf_gateways_table_createSuper(YITH_WCAF_Gateways_Table);

  function YITH_WCAF_Gateways_Table($context, args) {
    var _this;

    _classCallCheck(this, YITH_WCAF_Gateways_Table);

    _this = _super.call(this, $context, yith_wcaf_gateways_table_objectSpread({
      action_suffix: '_gateway',
      nonce_suffix: '_gateway',
      data: function data($row) {
        return {
          gateway_id: $row.data('id')
        };
      }
    }, args));

    _defineProperty(_assertThisInitialized(_this), "modal", null);

    return _this;
  } // modal


  _createClass(YITH_WCAF_Gateways_Table, [{
    key: "init",
    value: function init() {
      this.initModal();
      this.initEnableButtons();
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
        this.modal = new YITH_WCAF_Edit_Gateway_Modal($openers);
      }
    }
  }, {
    key: "getModalOpeners",
    value: function getModalOpeners() {
      return $('.edit', this.$table);
    }
  }]);

  return YITH_WCAF_Gateways_Table;
}(YITH_WCAF_Admin_Table);


;// CONCATENATED MODULE: ./assets/js/admin/src/settings.js

/* global yith_wcaf */








var YITH_WCAF_Settings = /*#__PURE__*/function () {
  function YITH_WCAF_Settings() {
    _classCallCheck(this, YITH_WCAF_Settings);

    this.initFields();
    this.initAffiliateProfileFieldsTable();
    this.initGatewaysTable();
    $(document).on('click', '#yith-plugin-fw-float-save-button', function (ev) {
      var $form = $('#plugin-fw-wc'),
          valid = $form.triggerHandler('yith_wcaf_validate_fields');

      if (!valid) {
        ev.stopImmediatePropagation();
        return false;
      }
    });
  }

  _createClass(YITH_WCAF_Settings, [{
    key: "initFields",
    value: function initFields() {
      fields_initFields();
    }
  }, {
    key: "initAffiliateProfileFieldsTable",
    value: function initAffiliateProfileFieldsTable() {
      var $context = $('#yith_wcaf_profile_fields');
      new YITH_WCAF_Profile_Fields_Table($context);
    }
  }, {
    key: "initGatewaysTable",
    value: function initGatewaysTable() {
      var $context = $('#yith_wcaf_gateways'),
          $table = $('table.gateways', $context);

      if ($table.length) {
        new YITH_WCAF_Gateways_Table($context);
      }
    }
  }]);

  return YITH_WCAF_Settings;
}();

$(function () {
  return new YITH_WCAF_Settings();
});
})();

var __webpack_export_target__ = window;
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=yith-wcaf-settings.bundle.js.map