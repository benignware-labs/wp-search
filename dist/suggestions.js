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

eval("(function ($) {\n  $(function () {\n    var options = {\n      linkClass: 'search-suggestions-link'\n    };\n    var url = SearchXtSuggestions.url + '?action=my_search';\n    $('input[name=\"s\"]').each(function () {\n      var $container = $(this).parents('form').next('*[data-suggestions]');\n      $container.addClass('search-suggestions-container');\n      var $instance = $(this).autocomplete({\n        appendTo: $container,\n        source: url,\n        delay: 500,\n        minLength: 3\n      });\n\n      $instance.data(\"ui-autocomplete\")._renderItem = function ($ul, item) {\n        var html = \"<span>\".concat(item.label, \"</span>\");\n\n        if (item.link) {\n          html = \"<a class=\\\"\".concat(options.linkClass, \"\\\" href=\\\"\").concat(item.link, \"\\\">\").concat(html, \"</a>\");\n        }\n\n        return $('<li class=\"ui-autocomplete-row list-group-item\"></li>').data(\"item.autocomplete\", item).append(html).appendTo($ul);\n      };\n\n      $instance.data(\"ui-autocomplete\")._renderMenu = function ($ul, items) {\n        var instance = this;\n        $.each(items, function (index, item) {\n          instance._renderItemData($ul, item);\n        });\n        $ul.addClass('search-suggestions list-group');\n      };\n\n      return $instance;\n    });\n  });\n})(jQuery);\n\n//# sourceURL=webpack:///./features/suggestions/suggestions.js?");

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