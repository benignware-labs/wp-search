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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./features/suggestions/suggestions.css":
/*!**********************************************!*\
  !*** ./features/suggestions/suggestions.css ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = __webpack_require__.p + \"suggestions.css\";\n\n//# sourceURL=webpack:///./features/suggestions/suggestions.css?");

/***/ }),

/***/ "./features/suggestions/suggestions.js":
/*!*********************************************!*\
  !*** ./features/suggestions/suggestions.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }\n\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\n(function ($) {\n  console.log('INIT WIDGET');\n  $.widget(\"custom.catcomplete\", $.ui.autocomplete, {\n    _create: function _create() {\n      this._super();\n\n      this.widget().menu('option', 'items', '> :not(.ui-widget-header)');\n    },\n    _renderMenu: function _renderMenu(ul, items) {\n      var self = this;\n      var currentCategory = '';\n      $.each(items, function (index, item) {\n        if (item.category != currentCategory) {\n          var $header = $(\"<li class=\\\"ui-widget-header\\\">\".concat(item.category, \"</li>\"));\n          ul.append($header);\n          currentCategory = item.category;\n        }\n\n        self._renderItemData(ul, item);\n      });\n    },\n    _renderItem: function _renderItem(ul, item) {\n      return $('<li>').append(item.label).appendTo(ul);\n    }\n  });\n  $(function () {\n    var options = _objectSpread({}, JSON.parse(decodeURIComponent(SearchXtSuggestions.options)));\n\n    console.log('options', options, $.ui.version);\n    $('input[data-search-input]').each(function () {\n      var $instance = $(this).catcomplete(_objectSpread({\n        appendTo: $('<div></div>').insertAfter(this.form),\n        source: SearchXtSuggestions.url,\n        delay: 500,\n        minLength: 1,\n        select: function select(event, _ref) {\n          var item = _ref.item;\n\n          if (item.href) {\n            window.location.href = item.href;\n          }\n        }\n      }, options.autocomplete, {\n        classes: {\n          'ui-catcomplete': 'highlight',\n          'ui-autocomplete': 'highlight'\n        }\n      }));\n      return $instance;\n    });\n  });\n})(jQuery);\n\n//# sourceURL=webpack:///./features/suggestions/suggestions.js?");

/***/ }),

/***/ 0:
/*!******************************************************************************************!*\
  !*** multi ./features/suggestions/suggestions.js ./features/suggestions/suggestions.css ***!
  \******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("__webpack_require__(/*! ./features/suggestions/suggestions.js */\"./features/suggestions/suggestions.js\");\nmodule.exports = __webpack_require__(/*! ./features/suggestions/suggestions.css */\"./features/suggestions/suggestions.css\");\n\n\n//# sourceURL=webpack:///multi_./features/suggestions/suggestions.js_./features/suggestions/suggestions.css?");

/***/ })

/******/ });