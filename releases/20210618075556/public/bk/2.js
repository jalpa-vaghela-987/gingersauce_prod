(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./public/js/gpickr/dist/gpickr.min.js":
/*!*********************************************!*\
  !*** ./public/js/gpickr/dist/gpickr.min.js ***!
  \*********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(module) {/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function (t, e) {
  "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) && "object" == ( false ? undefined : _typeof(module)) ? module.exports = e() : "function" == typeof define && __webpack_require__(/*! !webpack amd options */ "./node_modules/webpack/buildin/amd-options.js") ? define([], e) : "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) ? exports.GPickr = e() : t.GPickr = e();
}(window, function () {
  return function (t) {
    var e = {};

    function o(n) {
      if (e[n]) return e[n].exports;
      var i = e[n] = {
        i: n,
        l: !1,
        exports: {}
      };
      return t[n].call(i.exports, i, i.exports, o), i.l = !0, i.exports;
    }

    return o.m = t, o.c = e, o.d = function (t, e, n) {
      o.o(t, e) || Object.defineProperty(t, e, {
        enumerable: !0,
        get: n
      });
    }, o.r = function (t) {
      "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
        value: "Module"
      }), Object.defineProperty(t, "__esModule", {
        value: !0
      });
    }, o.t = function (t, e) {
      if (1 & e && (t = o(t)), 8 & e) return t;
      if (4 & e && "object" == _typeof(t) && t && t.__esModule) return t;
      var n = Object.create(null);
      if (o.r(n), Object.defineProperty(n, "default", {
        enumerable: !0,
        value: t
      }), 2 & e && "string" != typeof t) for (var i in t) {
        o.d(n, i, function (e) {
          return t[e];
        }.bind(null, i));
      }
      return n;
    }, o.n = function (t) {
      var e = t && t.__esModule ? function () {
        return t["default"];
      } : function () {
        return t;
      };
      return o.d(e, "a", e), e;
    }, o.o = function (t, e) {
      return Object.prototype.hasOwnProperty.call(t, e);
    }, o.p = "dist", o(o.s = 2);
  }([function (t, e, o) {
    /*! Pickr 1.4.5 MIT | https://github.com/Simonwep/pickr */
    window, t.exports = function (t) {
      var e = {};

      function o(n) {
        if (e[n]) return e[n].exports;
        var i = e[n] = {
          i: n,
          l: !1,
          exports: {}
        };
        return t[n].call(i.exports, i, i.exports, o), i.l = !0, i.exports;
      }

      return o.m = t, o.c = e, o.d = function (t, e, n) {
        o.o(t, e) || Object.defineProperty(t, e, {
          enumerable: !0,
          get: n
        });
      }, o.r = function (t) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
          value: "Module"
        }), Object.defineProperty(t, "__esModule", {
          value: !0
        });
      }, o.t = function (t, e) {
        if (1 & e && (t = o(t)), 8 & e) return t;
        if (4 & e && "object" == _typeof(t) && t && t.__esModule) return t;
        var n = Object.create(null);
        if (o.r(n), Object.defineProperty(n, "default", {
          enumerable: !0,
          value: t
        }), 2 & e && "string" != typeof t) for (var i in t) {
          o.d(n, i, function (e) {
            return t[e];
          }.bind(null, i));
        }
        return n;
      }, o.n = function (t) {
        var e = t && t.__esModule ? function () {
          return t["default"];
        } : function () {
          return t;
        };
        return o.d(e, "a", e), e;
      }, o.o = function (t, e) {
        return Object.prototype.hasOwnProperty.call(t, e);
      }, o.p = "", o(o.s = 1);
    }([function (t) {
      t.exports = JSON.parse('{"a":"1.4.5"}');
    }, function (t, e, o) {
      "use strict";

      o.r(e);
      var n = {};

      function i(t, e) {
        var o = Object.keys(t);

        if (Object.getOwnPropertySymbols) {
          var n = Object.getOwnPropertySymbols(t);
          e && (n = n.filter(function (e) {
            return Object.getOwnPropertyDescriptor(t, e).enumerable;
          })), o.push.apply(o, n);
        }

        return o;
      }

      function r(t) {
        for (var e = 1; e < arguments.length; e++) {
          var o = null != arguments[e] ? arguments[e] : {};
          e % 2 ? i(o, !0).forEach(function (e) {
            s(t, e, o[e]);
          }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(t, Object.getOwnPropertyDescriptors(o)) : i(o).forEach(function (e) {
            Object.defineProperty(t, e, Object.getOwnPropertyDescriptor(o, e));
          });
        }

        return t;
      }

      function s(t, e, o) {
        return e in t ? Object.defineProperty(t, e, {
          value: o,
          enumerable: !0,
          configurable: !0,
          writable: !0
        }) : t[e] = o, t;
      }

      o.r(n), o.d(n, "on", function () {
        return c;
      }), o.d(n, "off", function () {
        return a;
      }), o.d(n, "createElementFromString", function () {
        return p;
      }), o.d(n, "removeAttribute", function () {
        return u;
      }), o.d(n, "createFromTemplate", function () {
        return h;
      }), o.d(n, "eventPath", function () {
        return d;
      }), o.d(n, "resolveElement", function () {
        return f;
      }), o.d(n, "adjustableInputNumbers", function () {
        return m;
      });
      var c = l.bind(null, "addEventListener"),
          a = l.bind(null, "removeEventListener");

      function l(t, e, o, n) {
        var i = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {};
        e instanceof HTMLCollection || e instanceof NodeList ? e = Array.from(e) : Array.isArray(e) || (e = [e]), Array.isArray(o) || (o = [o]);
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = e[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var _s = _step.value;
            var _iteratorNormalCompletion2 = true;
            var _didIteratorError2 = false;
            var _iteratorError2 = undefined;

            try {
              for (var _iterator2 = o[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                var _e = _step2.value;

                _s[t](_e, n, r({
                  capture: !1
                }, i));
              }
            } catch (err) {
              _didIteratorError2 = true;
              _iteratorError2 = err;
            } finally {
              try {
                if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
                  _iterator2["return"]();
                }
              } finally {
                if (_didIteratorError2) {
                  throw _iteratorError2;
                }
              }
            }
          }
        } catch (err) {
          _didIteratorError = true;
          _iteratorError = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion && _iterator["return"] != null) {
              _iterator["return"]();
            }
          } finally {
            if (_didIteratorError) {
              throw _iteratorError;
            }
          }
        }

        return Array.prototype.slice.call(arguments, 1);
      }

      function p(t) {
        var e = document.createElement("div");
        return e.innerHTML = t.trim(), e.firstElementChild;
      }

      function u(t, e) {
        var o = t.getAttribute(e);
        return t.removeAttribute(e), o;
      }

      function h(t) {
        return function t(e) {
          var o = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
          var n = u(e, ":obj"),
              i = u(e, ":ref"),
              r = n ? o[n] = {} : o;
          i && (o[i] = e);

          for (var _i = 0, _Array$from = Array.from(e.children); _i < _Array$from.length; _i++) {
            var _o = _Array$from[_i];

            var _e2 = u(_o, ":arr"),
                _n = t(_o, _e2 ? {} : r);

            _e2 && (r[_e2] || (r[_e2] = [])).push(Object.keys(_n).length ? _n : _o);
          }

          return o;
        }(p(t));
      }

      function d(t) {
        var e = t.path || t.composedPath && t.composedPath();
        if (e) return e;
        var o = t.target.parentElement;

        for (e = [t.target, o]; o = o.parentElement;) {
          e.push(o);
        }

        return e.push(document, window), e;
      }

      function f(t) {
        return t instanceof Element ? t : "string" == typeof t ? t.split(/>>/g).reduce(function (t, e, o, n) {
          return t = t.querySelector(e), o < n.length - 1 ? t.shadowRoot : t;
        }, document) : null;
      }

      function m(t) {
        var e = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function (t) {
          return t;
        };

        function o(o) {
          var n = [.001, .01, .1][Number(o.shiftKey || 2 * o.ctrlKey)] * (o.deltaY < 0 ? 1 : -1);
          var i = 0,
              r = t.selectionStart;
          t.value = t.value.replace(/[\d.]+/g, function (t, o) {
            return o <= r && o + t.length >= r ? (r = o, e(Number(t), n, i)) : (i++, t);
          }), t.focus(), t.setSelectionRange(r, r), o.preventDefault(), t.dispatchEvent(new Event("input"));
        }

        c(t, "focus", function () {
          return c(window, "wheel", o, {
            passive: !1
          });
        }), c(t, "blur", function () {
          return a(window, "wheel", o);
        });
      }

      var g = o(0);
      var v = Math.min,
          b = Math.max,
          _ = Math.floor,
          y = Math.round;

      function w(t, e, o) {
        e /= 100, o /= 100;

        var n = _(t = t / 360 * 6),
            i = t - n,
            r = o * (1 - e),
            s = o * (1 - i * e),
            c = o * (1 - (1 - i) * e),
            a = n % 6;

        return [255 * [o, s, r, r, c, o][a], 255 * [c, o, o, s, r, r][a], 255 * [r, r, c, o, o, s][a]];
      }

      function S(t, e, o) {
        var n = (2 - (e /= 100)) * (o /= 100) / 2;
        return 0 !== n && (e = 1 === n ? 0 : n < .5 ? e * o / (2 * n) : e * o / (2 - 2 * n)), [t, 100 * e, 100 * n];
      }

      function C(t, e, o) {
        var n, i, r;
        var s = v(t /= 255, e /= 255, o /= 255),
            c = b(t, e, o),
            a = c - s;
        if (0 === a) n = i = 0;else {
          i = a / c;

          var _r = ((c - t) / 6 + a / 2) / a,
              _s2 = ((c - e) / 6 + a / 2) / a,
              _l = ((c - o) / 6 + a / 2) / a;

          t === c ? n = _l - _s2 : e === c ? n = 1 / 3 + _r - _l : o === c && (n = 2 / 3 + _s2 - _r), n < 0 ? n += 1 : n > 1 && (n -= 1);
        }
        return [360 * n, 100 * i, 100 * (r = c)];
      }

      function k(t, e, o, n) {
        return e /= 100, o /= 100, _toConsumableArray(C(255 * (1 - v(1, (t /= 100) * (1 - (n /= 100)) + n)), 255 * (1 - v(1, e * (1 - n) + n)), 255 * (1 - v(1, o * (1 - n) + n))));
      }

      function A(t, e, o) {
        return e /= 100, [t, 2 * (e *= (o /= 100) < .5 ? o : 1 - o) / (o + e) * 100, 100 * (o + e)];
      }

      function O(t) {
        return C.apply(void 0, _toConsumableArray(t.match(/.{2}/g).map(function (t) {
          return parseInt(t, 16);
        })));
      }

      function j() {
        var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
        var e = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
        var o = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
        var n = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 1;

        var i = function i(t, e) {
          return function () {
            var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : -1;
            return e(~o ? t.map(function (t) {
              return Number(t.toFixed(o));
            }) : t);
          };
        },
            r = {
          h: t,
          s: e,
          v: o,
          a: n,
          toHSVA: function toHSVA() {
            var t = [r.h, r.s, r.v, r.a];
            return t.toString = i(t, function (t) {
              return "hsva(".concat(t[0], ", ").concat(t[1], "%, ").concat(t[2], "%, ").concat(r.a, ")");
            }), t;
          },
          toHSLA: function toHSLA() {
            var t = [].concat(_toConsumableArray(S(r.h, r.s, r.v)), [r.a]);
            return t.toString = i(t, function (t) {
              return "hsla(".concat(t[0], ", ").concat(t[1], "%, ").concat(t[2], "%, ").concat(r.a, ")");
            }), t;
          },
          toRGBA: function toRGBA() {
            var t = [].concat(_toConsumableArray(w(r.h, r.s, r.v)), [r.a]);
            return t.toString = i(t, function (t) {
              return "rgba(".concat(t[0], ", ").concat(t[1], ", ").concat(t[2], ", ").concat(r.a, ")");
            }), t;
          },
          toCMYK: function toCMYK() {
            var t = function (t, e, o) {
              var n = w(t, e, o),
                  i = n[0] / 255,
                  r = n[1] / 255,
                  s = n[2] / 255;
              var c, a, l, p;
              return [100 * (a = 1 === (c = v(1 - i, 1 - r, 1 - s)) ? 0 : (1 - i - c) / (1 - c)), 100 * (l = 1 === c ? 0 : (1 - r - c) / (1 - c)), 100 * (p = 1 === c ? 0 : (1 - s - c) / (1 - c)), 100 * c];
            }(r.h, r.s, r.v);

            return t.toString = i(t, function (t) {
              return "cmyk(".concat(t[0], "%, ").concat(t[1], "%, ").concat(t[2], "%, ").concat(t[3], "%)");
            }), t;
          },
          toHEXA: function toHEXA() {
            var t = function (t, e, o) {
              return w(t, e, o).map(function (t) {
                return y(t).toString(16).padStart(2, "0");
              });
            }(r.h, r.s, r.v),
                e = r.a >= 1 ? "" : Number((255 * r.a).toFixed(0)).toString(16).toUpperCase().padStart(2, "0");

            return e && t.push(e), t.toString = function () {
              return "#".concat(t.join("").toUpperCase());
            }, t;
          },
          clone: function clone() {
            return j(r.h, r.s, r.v, r.a);
          }
        };

        return r;
      }

      var x = function x(t) {
        return Math.max(Math.min(t, 1), 0);
      };

      function P(t) {
        var e = {
          options: Object.assign({
            lock: null,
            onchange: function onchange() {
              return 0;
            },
            onstop: function onstop() {
              return 0;
            }
          }, t),
          _keyboard: function _keyboard(t) {
            var n = t.type,
                i = t.key;

            if (document.activeElement === o.wrapper) {
              var _o2 = e.options.lock,
                  _r2 = "ArrowUp" === i,
                  _s3 = "ArrowRight" === i,
                  _c = "ArrowDown" === i,
                  _a = "ArrowLeft" === i;

              if ("keydown" === n && (_r2 || _s3 || _c || _a)) {
                var _t = 0,
                    _n2 = 0;
                "v" === _o2 ? _t = _r2 || _s3 ? 1 : -1 : "h" === _o2 ? _t = _r2 || _s3 ? -1 : 1 : (_n2 = _r2 ? -1 : _c ? 1 : 0, _t = _a ? -1 : _s3 ? 1 : 0), e.update(x(e.cache.x + .01 * _t), x(e.cache.y + .01 * _n2));
              } else i.startsWith("Arrow") && (e.options.onstop(), t.preventDefault());
            }
          },
          _tapstart: function _tapstart(t) {
            c(document, ["mouseup", "touchend", "touchcancel"], e._tapstop), c(document, ["mousemove", "touchmove"], e._tapmove), t.preventDefault(), e._tapmove(t);
          },
          _tapmove: function _tapmove(t) {
            var n = e.options.lock,
                i = e.cache,
                r = o.element,
                s = o.wrapper,
                c = s.getBoundingClientRect();
            var a = 0,
                l = 0;

            if (t) {
              var _e3 = t && t.touches && t.touches[0];

              a = t ? (_e3 || t).clientX : 0, l = t ? (_e3 || t).clientY : 0, a < c.left ? a = c.left : a > c.left + c.width && (a = c.left + c.width), l < c.top ? l = c.top : l > c.top + c.height && (l = c.top + c.height), a -= c.left, l -= c.top;
            } else i && (a = i.x * c.width, l = i.y * c.height);

            "h" !== n && (r.style.left = "calc(".concat(a / c.width * 100, "% - ").concat(r.offsetWidth / 2, "px)")), "v" !== n && (r.style.top = "calc(".concat(l / c.height * 100, "% - ").concat(r.offsetHeight / 2, "px)")), e.cache = {
              x: a / c.width,
              y: l / c.height
            };
            var p = x(a / s.offsetWidth),
                u = x(l / s.offsetHeight);

            switch (n) {
              case "v":
                return o.onchange(p);

              case "h":
                return o.onchange(u);

              default:
                return o.onchange(p, u);
            }
          },
          _tapstop: function _tapstop() {
            e.options.onstop(), a(document, ["mouseup", "touchend", "touchcancel"], e._tapstop), a(document, ["mousemove", "touchmove"], e._tapmove);
          },
          trigger: function trigger() {
            e._tapmove();
          },
          update: function update() {
            var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
            var o = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

            var _e$options$wrapper$ge = e.options.wrapper.getBoundingClientRect(),
                n = _e$options$wrapper$ge.left,
                i = _e$options$wrapper$ge.top,
                r = _e$options$wrapper$ge.width,
                s = _e$options$wrapper$ge.height;

            "h" === e.options.lock && (o = t), e._tapmove({
              clientX: n + r * t,
              clientY: i + s * o
            });
          },
          destroy: function destroy() {
            var t = e.options,
                o = e._tapstart;
            a([t.wrapper, t.element], "mousedown", o), a([t.wrapper, t.element], "touchstart", o, {
              passive: !1
            });
          }
        },
            o = e.options,
            n = e._tapstart,
            i = e._keyboard;
        return c([o.wrapper, o.element], "mousedown", n), c([o.wrapper, o.element], "touchstart", n, {
          passive: !1
        }), c(document, ["keydown", "keyup"], i), e;
      }

      function L() {
        var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        t = Object.assign({
          onchange: function onchange() {
            return 0;
          },
          className: "",
          elements: []
        }, t);
        var e = c(t.elements, "click", function (e) {
          t.elements.forEach(function (o) {
            return o.classList[e.target === o ? "add" : "remove"](t.className);
          }), t.onchange(e);
        });
        return {
          destroy: function destroy() {
            return a.apply(void 0, _toConsumableArray(e));
          }
        };
      }

      function E(_ref) {
        var t = _ref.el,
            e = _ref.reference,
            _ref$padding = _ref.padding,
            o = _ref$padding === void 0 ? 8 : _ref$padding;

        var n = {
          start: "sme",
          middle: "mse",
          end: "ems"
        },
            i = {
          top: "tbrl",
          right: "rltb",
          bottom: "btrl",
          left: "lrbt"
        },
            r = function () {
          var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
          return function (e) {
            var o = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : t[e];
            if (o) return o;

            var _e$split = e.split("-"),
                _e$split2 = _slicedToArray(_e$split, 2),
                n = _e$split2[0],
                _e$split2$ = _e$split2[1],
                i = _e$split2$ === void 0 ? "middle" : _e$split2$,
                r = "top" === n || "bottom" === n;

            return t[e] = {
              position: n,
              variant: i,
              isVertical: r
            };
          };
        }();

        return {
          update: function update(s) {
            var _r3 = r(s),
                c = _r3.position,
                a = _r3.variant,
                l = _r3.isVertical,
                p = e.getBoundingClientRect(),
                u = t.getBoundingClientRect(),
                h = function h(t) {
              return t ? {
                t: p.top - u.height - o,
                b: p.bottom + o
              } : {
                r: p.right + o,
                l: p.left - u.width - o
              };
            },
                d = function d(t) {
              return t ? {
                s: p.left + p.width - u.width,
                m: -u.width / 2 + (p.left + p.width / 2),
                e: p.left
              } : {
                s: p.bottom - u.height,
                m: p.bottom - p.height / 2 - u.height / 2,
                e: p.bottom - p.height
              };
            },
                f = {};

            function m(e, o, n) {
              var i = "top" === n,
                  r = i ? u.height : u.width,
                  s = window[i ? "innerHeight" : "innerWidth"];
              var _iteratorNormalCompletion3 = true;
              var _didIteratorError3 = false;
              var _iteratorError3 = undefined;

              try {
                for (var _iterator3 = e[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                  var _i2 = _step3.value;

                  var _e4 = o[_i2],
                      _c2 = f[n] = "".concat(_e4, "px");

                  if (_e4 > 0 && _e4 + r < s) return t.style[n] = _c2, !0;
                }
              } catch (err) {
                _didIteratorError3 = true;
                _iteratorError3 = err;
              } finally {
                try {
                  if (!_iteratorNormalCompletion3 && _iterator3["return"] != null) {
                    _iterator3["return"]();
                  }
                } finally {
                  if (_didIteratorError3) {
                    throw _iteratorError3;
                  }
                }
              }

              return !1;
            }

            for (var _i3 = 0, _arr2 = [l, !l]; _i3 < _arr2.length; _i3++) {
              var _t2 = _arr2[_i3];

              var _e5 = m(i[c], h(_t2), _t2 ? "top" : "left"),
                  _o3 = m(n[a], d(_t2), _t2 ? "left" : "top");

              if (_e5 && _o3) return;
            }

            t.style.left = f.left, t.style.top = f.top;
          }
        };
      }

      var R = function R(_ref2) {
        var t = _ref2.components,
            e = _ref2.strings,
            o = _ref2.useAsButton,
            n = _ref2.inline,
            i = _ref2.appClass,
            r = _ref2.theme,
            s = _ref2.lockOpacity;

        var c = function c(t) {
          return t ? "" : 'style="display:none" hidden';
        },
            a = h('\n      <div :ref="root" class="pickr">\n\n        '.concat(o ? "" : '<button type="button" :ref="button" class="pcr-button"></button>', '\n\n        <div :ref="app" class="pcr-app ').concat(i || "", '" data-theme="').concat(r, '" ').concat(n ? 'style="position: unset"' : "", ' aria-label="color picker dialog" role="window">\n          <div class="pcr-selection" ').concat(c(t.palette), '>\n            <div :obj="preview" class="pcr-color-preview" ').concat(c(t.preview), '>\n              <button type="button" :ref="lastColor" class="pcr-last-color" aria-label="use previous color"></button>\n              <div :ref="currentColor" class="pcr-current-color"></div>\n            </div>\n\n            <div :obj="palette" class="pcr-color-palette">\n              <div :ref="picker" class="pcr-picker"></div>\n              <div :ref="palette" class="pcr-palette" tabindex="0" aria-label="color selection area" role="widget"></div>\n            </div>\n\n            <div :obj="hue" class="pcr-color-chooser" ').concat(c(t.hue), '>\n              <div :ref="picker" class="pcr-picker"></div>\n              <div :ref="slider" class="pcr-hue pcr-slider" tabindex="0" aria-label="hue selection slider" role="widget"></div>\n            </div>\n\n            <div :obj="opacity" class="pcr-color-opacity" ').concat(c(t.opacity), '>\n              <div :ref="picker" class="pcr-picker"></div>\n              <div :ref="slider" class="pcr-opacity pcr-slider" tabindex="0" aria-label="opacity selection slider" role="widget"></div>\n            </div>\n          </div>\n\n          <div class="pcr-swatches ').concat(t.palette ? "" : "pcr-last", '" :ref="swatches"></div> \n\n          <div :obj="interaction" class="pcr-interaction" ').concat(c(Object.keys(t.interaction).length), '>\n            <input :ref="result" class="pcr-result" type="text" spellcheck="false" ').concat(c(t.interaction.input), '>\n\n            <input :arr="options" class="pcr-type" data-type="HEXA" value="').concat(s ? "HEX" : "HEXA", '" type="button" ').concat(c(t.interaction.hex), '>\n            <input :arr="options" class="pcr-type" data-type="RGBA" value="').concat(s ? "RGB" : "RGBA", '" type="button" ').concat(c(t.interaction.rgba), '>\n            <input :arr="options" class="pcr-type" data-type="HSLA" value="').concat(s ? "HSL" : "HSLA", '" type="button" ').concat(c(t.interaction.hsla), '>\n            <input :arr="options" class="pcr-type" data-type="HSVA" value="').concat(s ? "HSV" : "HSVA", '" type="button" ').concat(c(t.interaction.hsva), '>\n            <input :arr="options" class="pcr-type" data-type="CMYK" value="CMYK" type="button" ').concat(c(t.interaction.cmyk), '>\n\n            <input :ref="save" class="pcr-save" value="').concat(e.save || "Save", '" type="button" ').concat(c(t.interaction.save), ' aria-label="save and exit">\n            <input :ref="cancel" class="pcr-cancel" value="').concat(e.cancel || "Cancel", '" type="button" ').concat(c(t.interaction.cancel), ' aria-label="cancel and exit">\n            <input :ref="clear" class="pcr-clear" value="').concat(e.clear || "Clear", '" type="button" ').concat(c(t.interaction.clear), ' aria-label="clear and exit">\n          </div>\n        </div>\n      </div>\n    ')),
            l = a.interaction;

        return l.options.find(function (t) {
          return !t.hidden && !t.classList.add("active");
        }), l.type = function () {
          return l.options.find(function (t) {
            return t.classList.contains("active");
          });
        }, a;
      };

      function B(t, e, o) {
        return e in t ? Object.defineProperty(t, e, {
          value: o,
          enumerable: !0,
          configurable: !0,
          writable: !0
        }) : t[e] = o, t;
      }

      var D =
      /*#__PURE__*/
      function () {
        function D(t) {
          var _this = this;

          _classCallCheck(this, D);

          B(this, "_initializingActive", !0), B(this, "_recalc", !0), B(this, "_color", j()), B(this, "_lastColor", j()), B(this, "_swatchColors", []), B(this, "_eventListener", {
            init: [],
            save: [],
            hide: [],
            show: [],
            clear: [],
            change: [],
            changestop: [],
            cancel: [],
            swatchselect: []
          }), this.options = t = Object.assign({
            appClass: null,
            theme: "classic",
            useAsButton: !1,
            padding: 8,
            disabled: !1,
            comparison: !0,
            closeOnScroll: !1,
            outputPrecision: 0,
            lockOpacity: !1,
            autoReposition: !0,
            container: "body",
            components: {
              interaction: {}
            },
            strings: {},
            swatches: null,
            inline: !1,
            sliders: null,
            "default": "#42445a",
            defaultRepresentation: null,
            position: "bottom-middle",
            adjustableNumbers: !0,
            showAlways: !1,
            closeWithKey: "Escape"
          }, t);
          var _t3 = t,
              e = _t3.swatches,
              o = _t3.components,
              n = _t3.theme,
              i = _t3.sliders,
              r = _t3.lockOpacity,
              s = _t3.padding;
          ["nano", "monolith"].includes(n) && !i && (t.sliders = "h"), o.interaction || (o.interaction = {});
          var c = o.preview,
              a = o.opacity,
              l = o.hue,
              p = o.palette;
          o.opacity = !r && a, o.palette = p || c || a || l, this._preBuild(), this._buildComponents(), this._bindEvents(), this._finalBuild(), e && e.length && e.forEach(function (t) {
            return _this.addSwatch(t);
          });
          var _this$_root = this._root,
              u = _this$_root.button,
              h = _this$_root.app;
          this._nanopop = E({
            reference: u,
            padding: s,
            el: h
          }), u.setAttribute("role", "button"), u.setAttribute("aria-label", "toggle color picker dialog");
          var d = this;
          requestAnimationFrame(function e() {
            if (!h.offsetWidth && h.parentElement !== t.container) return requestAnimationFrame(e);
            d.setColor(t["default"]), d._rePositioningPicker(), t.defaultRepresentation && (d._representation = t.defaultRepresentation, d.setColorRepresentation(d._representation)), t.showAlways && d.show(), d._initializingActive = !1, d._emit("init");
          });
        }

        _createClass(D, [{
          key: "_preBuild",
          value: function _preBuild() {
            var t = this.options;

            for (var _i4 = 0, _arr3 = ["el", "container"]; _i4 < _arr3.length; _i4++) {
              var _e6 = _arr3[_i4];
              t[_e6] = f(t[_e6]);
            }

            this._root = R(t), t.useAsButton && (this._root.button = t.el), t.container.appendChild(this._root.root);
          }
        }, {
          key: "_finalBuild",
          value: function _finalBuild() {
            var t = this.options,
                e = this._root;

            if (t.container.removeChild(e.root), t.inline) {
              var _o4 = t.el.parentElement;
              t.el.nextSibling ? _o4.insertBefore(e.app, t.el.nextSibling) : _o4.appendChild(e.app);
            } else t.container.appendChild(e.app);

            t.useAsButton ? t.inline && t.el.remove() : t.el.parentNode.replaceChild(e.root, t.el), t.disabled && this.disable(), t.comparison || (e.button.style.transition = "none", t.useAsButton || (e.preview.lastColor.style.transition = "none")), this.hide();
          }
        }, {
          key: "_buildComponents",
          value: function _buildComponents() {
            var _this2 = this;

            var t = this,
                e = this.options.components,
                o = (t.options.sliders || "v").repeat(2),
                _ref3 = o.match(/^[vh]+$/g) ? o : [],
                _ref4 = _slicedToArray(_ref3, 2),
                n = _ref4[0],
                i = _ref4[1],
                r = function r() {
              return _this2._color || (_this2._color = _this2._lastColor.clone());
            },
                s = {
              palette: P({
                element: t._root.palette.picker,
                wrapper: t._root.palette.palette,
                onstop: function onstop() {
                  return t._emit("changestop", t);
                },
                onchange: function onchange(o, n) {
                  if (!e.palette) return;
                  var i = r(),
                      s = t._root,
                      c = t.options;
                  t._recalc && (i.s = 100 * o, i.v = 100 - 100 * n, i.v < 0 && (i.v = 0), t._updateOutput());
                  var a = i.toRGBA().toString(0);
                  this.element.style.background = a, this.wrapper.style.background = "\n                        linear-gradient(to top, rgba(0, 0, 0, ".concat(i.a, "), transparent),\n                        linear-gradient(to left, hsla(").concat(i.h, ", 100%, 50%, ").concat(i.a, "), rgba(255, 255, 255, ").concat(i.a, "))\n                    "), c.comparison ? c.useAsButton || t._lastColor || (s.preview.lastColor.style.color = a) : s.button.style.color = a;
                  var l = i.toHEXA().toString();
                  var _iteratorNormalCompletion4 = true;
                  var _didIteratorError4 = false;
                  var _iteratorError4 = undefined;

                  try {
                    for (var _iterator4 = t._swatchColors[Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
                      var _e7 = _step4.value;
                      var _t4 = _e7.el,
                          _o5 = _e7.color;

                      _t4.classList[l === _o5.toHEXA().toString() ? "add" : "remove"]("pcr-active");
                    }
                  } catch (err) {
                    _didIteratorError4 = true;
                    _iteratorError4 = err;
                  } finally {
                    try {
                      if (!_iteratorNormalCompletion4 && _iterator4["return"] != null) {
                        _iterator4["return"]();
                      }
                    } finally {
                      if (_didIteratorError4) {
                        throw _iteratorError4;
                      }
                    }
                  }

                  s.preview.currentColor.style.color = a, t.options.comparison || s.button.classList.remove("clear");
                }
              }),
              hue: P({
                lock: "v" === i ? "h" : "v",
                element: t._root.hue.picker,
                wrapper: t._root.hue.slider,
                onstop: function onstop() {
                  return t._emit("changestop", t);
                },
                onchange: function onchange(o) {
                  if (!e.hue || !e.palette) return;
                  var n = r();
                  t._recalc && (n.h = 360 * o), this.element.style.backgroundColor = "hsl(".concat(n.h, ", 100%, 50%)"), s.palette.trigger();
                }
              }),
              opacity: P({
                lock: "v" === n ? "h" : "v",
                element: t._root.opacity.picker,
                wrapper: t._root.opacity.slider,
                onstop: function onstop() {
                  return t._emit("changestop", t);
                },
                onchange: function onchange(o) {
                  if (!e.opacity || !e.palette) return;
                  var n = r();
                  t._recalc && (n.a = Math.round(100 * o) / 100), this.element.style.background = "rgba(0, 0, 0, ".concat(n.a, ")"), s.palette.trigger();
                }
              }),
              selectable: L({
                elements: t._root.interaction.options,
                className: "active",
                onchange: function onchange(e) {
                  t._representation = e.target.getAttribute("data-type").toUpperCase(), t._recalc && t._updateOutput();
                }
              })
            };

            this._components = s;
          }
        }, {
          key: "_bindEvents",
          value: function _bindEvents() {
            var _this3 = this;

            var t = this._root,
                e = this.options,
                o = [c(t.interaction.clear, "click", function () {
              return _this3._clearColor();
            }), c([t.interaction.cancel, t.preview.lastColor], "click", function () {
              _this3._emit("cancel", _this3), _this3.setHSVA.apply(_this3, _toConsumableArray((_this3._lastColor || _this3._color).toHSVA()).concat([!0]));
            }), c(t.interaction.save, "click", function () {
              !_this3.applyColor() && !e.showAlways && _this3.hide();
            }), c(t.interaction.result, ["keyup", "input"], function (t) {
              _this3.setColor(t.target.value, !0) && !_this3._initializingActive && _this3._emit("change", _this3._color), t.stopImmediatePropagation();
            }), c(t.interaction.result, ["focus", "blur"], function (t) {
              _this3._recalc = "blur" === t.type, _this3._recalc && _this3._updateOutput();
            }), c([t.palette.palette, t.palette.picker, t.hue.slider, t.hue.picker, t.opacity.slider, t.opacity.picker], ["mousedown", "touchstart"], function () {
              return _this3._recalc = !0;
            })];

            if (!e.showAlways) {
              var _n3 = e.closeWithKey;
              o.push(c(t.button, "click", function () {
                return _this3.isOpen() ? _this3.hide() : _this3.show();
              }), c(document, "keyup", function (t) {
                return _this3.isOpen() && (t.key === _n3 || t.code === _n3) && _this3.hide();
              }), c(document, ["touchstart", "mousedown"], function (e) {
                _this3.isOpen() && !d(e).some(function (e) {
                  return e === t.app || e === t.button;
                }) && _this3.hide();
              }, {
                capture: !0
              }));
            }

            if (e.adjustableNumbers) {
              var _e8 = {
                rgba: [255, 255, 255, 1],
                hsva: [360, 100, 100, 1],
                hsla: [360, 100, 100, 1],
                cmyk: [100, 100, 100, 100]
              };
              m(t.interaction.result, function (t, o, n) {
                var i = _e8[_this3.getColorRepresentation().toLowerCase()];

                if (i) {
                  var _e9 = i[n],
                      _r4 = t + (_e9 >= 100 ? 1e3 * o : o);

                  return _r4 <= 0 ? 0 : Number((_r4 < _e9 ? _r4 : _e9).toPrecision(3));
                }

                return t;
              });
            }

            if (e.autoReposition && !e.inline) {
              var _t5 = null;

              var _n4 = this;

              o.push(c(window, ["scroll", "resize"], function () {
                _n4.isOpen() && (e.closeOnScroll && _n4.hide(), null === _t5 ? (_t5 = setTimeout(function () {
                  return _t5 = null;
                }, 100), requestAnimationFrame(function e() {
                  _n4._rePositioningPicker(), null !== _t5 && requestAnimationFrame(e);
                })) : (clearTimeout(_t5), _t5 = setTimeout(function () {
                  return _t5 = null;
                }, 100)));
              }, {
                capture: !0
              }));
            }

            this._eventBindings = o;
          }
        }, {
          key: "_rePositioningPicker",
          value: function _rePositioningPicker() {
            var t = this.options;

            if (!t.inline) {
              var _e10 = this._root.app;
              matchMedia("(max-width: 576px)").matches ? Object.assign(_e10.style, {
                margin: "auto",
                height: "".concat(_e10.getBoundingClientRect().height, "px"),
                top: 0,
                bottom: 0,
                left: 0,
                right: 0
              }) : (Object.assign(_e10.style, {
                margin: null,
                right: null,
                top: null,
                bottom: null,
                left: null,
                height: null
              }), this._nanopop.update(t.position));
            }
          }
        }, {
          key: "_updateOutput",
          value: function _updateOutput() {
            var t = this._root,
                e = this._color,
                o = this.options;

            if (t.interaction.type()) {
              var _n5 = "to".concat(t.interaction.type().getAttribute("data-type"));

              t.interaction.result.value = "function" == typeof e[_n5] ? e[_n5]().toString(o.outputPrecision) : "";
            }

            !this._initializingActive && this._recalc && this._emit("change", e);
          }
        }, {
          key: "_clearColor",
          value: function _clearColor() {
            var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : !1;
            var e = this._root,
                o = this.options;
            o.useAsButton || (e.button.style.color = "rgba(0, 0, 0, 0.15)"), e.button.classList.add("clear"), o.showAlways || this.hide(), this._lastColor = null, this._initializingActive || t || (this._emit("save", null), this._emit("clear", this));
          }
        }, {
          key: "_parseLocalColor",
          value: function _parseLocalColor(t) {
            var _ref5 = function (t) {
              t = t.match(/^[a-zA-Z]+$/) ? function (t) {
                if ("black" === t.toLowerCase()) return "#000";
                var e = document.createElement("canvas").getContext("2d");
                return e.fillStyle = t, "#000" === e.fillStyle ? null : e.fillStyle;
              }(t) : t;

              var e = {
                cmyk: /^cmyk[\D]+([\d.]+)[\D]+([\d.]+)[\D]+([\d.]+)[\D]+([\d.]+)/i,
                rgba: /^((rgba)|rgb)[\D]+([\d.]+)[\D]+([\d.]+)[\D]+([\d.]+)[\D]*?([\d.]+|$)/i,
                hsla: /^((hsla)|hsl)[\D]+([\d.]+)[\D]+([\d.]+)[\D]+([\d.]+)[\D]*?([\d.]+|$)/i,
                hsva: /^((hsva)|hsv)[\D]+([\d.]+)[\D]+([\d.]+)[\D]+([\d.]+)[\D]*?([\d.]+|$)/i,
                hexa: /^#?(([\dA-Fa-f]{3,4})|([\dA-Fa-f]{6})|([\dA-Fa-f]{8}))$/i
              },
                  o = function o(t) {
                return t.map(function (t) {
                  return /^(|\d+)\.\d+|\d+$/.test(t) ? Number(t) : void 0;
                });
              };

              var n;

              t: for (var _i5 in e) {
                if (!(n = e[_i5].exec(t))) continue;

                var _r5 = function _r5(t) {
                  return !!n[2] == ("number" == typeof t);
                };

                switch (_i5) {
                  case "cmyk":
                    {
                      var _o6 = o(n),
                          _o7 = _slicedToArray(_o6, 5),
                          _t6 = _o7[1],
                          _e11 = _o7[2],
                          _r6 = _o7[3],
                          _s4 = _o7[4];

                      if (_t6 > 100 || _e11 > 100 || _r6 > 100 || _s4 > 100) break t;
                      return {
                        values: k(_t6, _e11, _r6, _s4),
                        type: _i5
                      };
                    }

                  case "rgba":
                    {
                      var _o8 = o(n),
                          _o9 = _slicedToArray(_o8, 7),
                          _t7 = _o9[3],
                          _e12 = _o9[4],
                          _s5 = _o9[5],
                          _c3 = _o9[6];

                      if (_t7 > 255 || _e12 > 255 || _s5 > 255 || _c3 < 0 || _c3 > 1 || !_r5(_c3)) break t;
                      return {
                        values: [].concat(_toConsumableArray(C(_t7, _e12, _s5)), [_c3]),
                        a: _c3,
                        type: _i5
                      };
                    }

                  case "hexa":
                    {
                      var _n6 = n,
                          _n7 = _slicedToArray(_n6, 2),
                          _t8 = _n7[1];

                      4 !== _t8.length && 3 !== _t8.length || (_t8 = _t8.split("").map(function (t) {
                        return t + t;
                      }).join(""));

                      var _e13 = _t8.substring(0, 6);

                      var _o10 = _t8.substring(6);

                      return _o10 = _o10 ? parseInt(_o10, 16) / 255 : void 0, {
                        values: [].concat(_toConsumableArray(O(_e13)), [_o10]),
                        a: _o10,
                        type: _i5
                      };
                    }

                  case "hsla":
                    {
                      var _o11 = o(n),
                          _o12 = _slicedToArray(_o11, 7),
                          _t9 = _o12[3],
                          _e14 = _o12[4],
                          _s6 = _o12[5],
                          _c4 = _o12[6];

                      if (_t9 > 360 || _e14 > 100 || _s6 > 100 || _c4 < 0 || _c4 > 1 || !_r5(_c4)) break t;
                      return {
                        values: [].concat(_toConsumableArray(A(_t9, _e14, _s6)), [_c4]),
                        a: _c4,
                        type: _i5
                      };
                    }

                  case "hsva":
                    {
                      var _o13 = o(n),
                          _o14 = _slicedToArray(_o13, 7),
                          _t10 = _o14[3],
                          _e15 = _o14[4],
                          _s7 = _o14[5],
                          _c5 = _o14[6];

                      if (_t10 > 360 || _e15 > 100 || _s7 > 100 || _c5 < 0 || _c5 > 1 || !_r5(_c5)) break t;
                      return {
                        values: [_t10, _e15, _s7, _c5],
                        a: _c5,
                        type: _i5
                      };
                    }
                }
              }

              return {
                values: null,
                type: null
              };
            }(t),
                e = _ref5.values,
                o = _ref5.type,
                n = _ref5.a,
                i = this.options.lockOpacity,
                r = void 0 !== n && 1 !== n;

            return e && 3 === e.length && (e[3] = void 0), {
              values: !e || i && r ? null : e,
              type: o
            };
          }
        }, {
          key: "_emit",
          value: function _emit(t) {
            var _this4 = this;

            for (var _len = arguments.length, e = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
              e[_key - 1] = arguments[_key];
            }

            this._eventListener[t].forEach(function (t) {
              return t.apply(void 0, e.concat([_this4]));
            });
          }
        }, {
          key: "on",
          value: function on(t, e) {
            return "function" == typeof e && "string" == typeof t && t in this._eventListener && this._eventListener[t].push(e), this;
          }
        }, {
          key: "off",
          value: function off(t, e) {
            var o = this._eventListener[t];

            if (o) {
              var _t11 = o.indexOf(e);

              ~_t11 && o.splice(_t11, 1);
            }

            return this;
          }
        }, {
          key: "addSwatch",
          value: function addSwatch(t) {
            var _this5 = this;

            var _this$_parseLocalColo = this._parseLocalColor(t),
                e = _this$_parseLocalColo.values;

            if (e) {
              var _t12 = this._swatchColors,
                  _o15 = this._root,
                  _n8 = j.apply(void 0, _toConsumableArray(e)),
                  _i6 = p('<button type="button" style="color: '.concat(_n8.toRGBA().toString(0), '" aria-label="color swatch"/>'));

              return _o15.swatches.appendChild(_i6), _t12.push({
                el: _i6,
                color: _n8
              }), this._eventBindings.push(c(_i6, "click", function () {
                _this5.setHSVA.apply(_this5, _toConsumableArray(_n8.toHSVA()).concat([!0])), _this5._emit("swatchselect", _n8), _this5._emit("change", _n8);
              })), !0;
            }

            return !1;
          }
        }, {
          key: "removeSwatch",
          value: function removeSwatch(t) {
            var e = this._swatchColors[t];

            if (e) {
              var _o16 = e.el;
              return this._root.swatches.removeChild(_o16), this._swatchColors.splice(t, 1), !0;
            }

            return !1;
          }
        }, {
          key: "applyColor",
          value: function applyColor() {
            var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : !1;

            var _this$_root2 = this._root,
                e = _this$_root2.preview,
                o = _this$_root2.button,
                n = this._color.toRGBA().toString(0);

            return e.lastColor.style.color = n, this.options.useAsButton || (o.style.color = n), o.classList.remove("clear"), this._lastColor = this._color.clone(), this._initializingActive || t || this._emit("save", this._color), this;
          }
        }, {
          key: "destroy",
          value: function destroy() {
            var _this6 = this;

            this._eventBindings.forEach(function (t) {
              return a.apply(void 0, _toConsumableArray(t));
            }), Object.keys(this._components).forEach(function (t) {
              return _this6._components[t].destroy();
            });
          }
        }, {
          key: "destroyAndRemove",
          value: function destroyAndRemove() {
            var _this7 = this;

            this.destroy();
            var _this$_root3 = this._root,
                t = _this$_root3.root,
                e = _this$_root3.app;
            t.parentElement && t.parentElement.removeChild(t), e.parentElement.removeChild(e), Object.keys(this).forEach(function (t) {
              return _this7[t] = null;
            });
          }
        }, {
          key: "hide",
          value: function hide() {
            return this._root.app.classList.remove("visible"), this._emit("hide", this), this;
          }
        }, {
          key: "show",
          value: function show() {
            return this.options.disabled || (this._root.app.classList.add("visible"), this._rePositioningPicker(), this._emit("show", this)), this;
          }
        }, {
          key: "isOpen",
          value: function isOpen() {
            return this._root.app.classList.contains("visible");
          }
        }, {
          key: "setHSVA",
          value: function setHSVA() {
            var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 360;
            var e = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
            var o = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
            var n = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 1;
            var i = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : !1;
            var r = this._recalc;
            if (this._recalc = !1, t < 0 || t > 360 || e < 0 || e > 100 || o < 0 || o > 100 || n < 0 || n > 1) return !1;
            this._color = j(t, e, o, n);
            var _this$_components = this._components,
                s = _this$_components.hue,
                c = _this$_components.opacity,
                a = _this$_components.palette;
            return s.update(t / 360), c.update(n), a.update(e / 100, 1 - o / 100), i || this.applyColor(), r && this._updateOutput(), this._recalc = r, !0;
          }
        }, {
          key: "setColor",
          value: function setColor(t) {
            var e = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : !1;
            if (null === t) return this._clearColor(e), !0;

            var _this$_parseLocalColo2 = this._parseLocalColor(t),
                o = _this$_parseLocalColo2.values,
                n = _this$_parseLocalColo2.type;

            if (o) {
              var _t13 = n.toUpperCase(),
                  _i7 = this._root.interaction.options,
                  _r7 = _i7.find(function (e) {
                return e.getAttribute("data-type") === _t13;
              });

              if (_r7 && !_r7.hidden) {
                var _iteratorNormalCompletion5 = true;
                var _didIteratorError5 = false;
                var _iteratorError5 = undefined;

                try {
                  for (var _iterator5 = _i7[Symbol.iterator](), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
                    var _t14 = _step5.value;

                    _t14.classList[_t14 === _r7 ? "add" : "remove"]("active");
                  }
                } catch (err) {
                  _didIteratorError5 = true;
                  _iteratorError5 = err;
                } finally {
                  try {
                    if (!_iteratorNormalCompletion5 && _iterator5["return"] != null) {
                      _iterator5["return"]();
                    }
                  } finally {
                    if (_didIteratorError5) {
                      throw _iteratorError5;
                    }
                  }
                }
              }

              return this.setColorRepresentation(_t13), this.setHSVA.apply(this, _toConsumableArray(o).concat([e]));
            }

            return !1;
          }
        }, {
          key: "setColorRepresentation",
          value: function setColorRepresentation(t) {
            return t = t.toUpperCase(), !!this._root.interaction.options.find(function (e) {
              return e.getAttribute("data-type").startsWith(t) && !e.click();
            });
          }
        }, {
          key: "getColorRepresentation",
          value: function getColorRepresentation() {
            return this._representation;
          }
        }, {
          key: "getColor",
          value: function getColor() {
            return this._color;
          }
        }, {
          key: "getSelectedColor",
          value: function getSelectedColor() {
            return this._lastColor;
          }
        }, {
          key: "getRoot",
          value: function getRoot() {
            return this._root;
          }
        }, {
          key: "disable",
          value: function disable() {
            return this.hide(), this.options.disabled = !0, this._root.button.classList.add("disabled"), this;
          }
        }, {
          key: "enable",
          value: function enable() {
            return this.options.disabled = !1, this._root.button.classList.remove("disabled"), this;
          }
        }]);

        return D;
      }();

      D.utils = n, D.libs = {
        HSVaColor: j,
        Moveable: P,
        Nanopop: E,
        Selectable: L
      }, D.create = function (t) {
        return new D(t);
      }, D.version = g.a, e["default"] = D;
    }])["default"];
  }, function (t, e, o) {}, function (t, e, o) {
    "use strict";

    var _marked =
    /*#__PURE__*/
    _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(a);

    o.r(e);
    o(1);

    var n = o(0),
        i = o.n(n),
        r = function r() {
      return n.utils.createFromTemplate("\n<div class=\"gpickr\" :ref=\"root\">\n\n    <div :ref=\"pickr\"></div>\n    <div :obj=\"gradient\" class=\"gpcr-interaction\">\n    <div :ref=\"result\" class=\"gpcr-result\">\n        \n         <div :ref=\"mode\" data-mode=\"linear\" class=\"gpcr-mode\"></div>\n\n            <div :ref=\"angle\" class=\"gpcr-angle\">\n                <div :ref=\"arrow\"></div>\n            </div>\n\n            <div :ref=\"pos\" class=\"gpcr-pos\">\n                ".concat(["tl", "tm", "tr", "l", "m", "r", "bl", "bm", "br"].map(function (t) {
        return "<div data-pos=\"".concat(t, "\"></div>");
      }).join(""), "\n            </div>\n        </div>\n\n        <div :obj=\"stops\" class=\"gpcr-stops\">\n            <div :ref=\"preview\" class=\"gpcr-stop-preview\"></div>\n            <div :ref=\"markers\" class=\"gpcr-stop-marker\"></div>\n        </div>\n       \n    </div>\n\n</div>\n"));
    },
        s = function s(t) {
      var e = t.touches && t.touches[0] || t;
      return {
        tap: e,
        x: e.clientX,
        y: e.clientY,
        target: e.target
      };
    };

    var c = document.createElement("p");

    function a(t, e) {
      var o,
          _n9,
          _args = arguments;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function a$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              o = _args.length > 2 && _args[2] !== undefined ? _args[2] : -1;

            case 1:
              if (!(_n9 = e.exec(t))) {
                _context.next = 6;
                break;
              }

              _context.next = 4;
              return ~o ? _n9[o].trim() : _n9.map(function (t) {
                return t.trim();
              });

            case 4:
              _context.next = 1;
              break;

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, _marked);
    }

    function l(t, e) {
      var o = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : -1;
      var n = t.match(e);
      return n ? ~o ? n[o] : n : null;
    }

    function p(t) {
      var e = "rgba(0, 0, 0, 0)";
      if (c.style.color = e, t === e) return t;
      c.style.color = t;
      var o = getComputedStyle(c).color;
      return o === e ? null : o;
    }

    function u(t) {
      if (!(t = function (t) {
        return c.style.backgroundImage = t, getComputedStyle(c).backgroundImage;
      }(t))) return null;

      var _ref6 = t.match(/^(\w+)-gradient\((.*)\)$/i) || [],
          _ref7 = _slicedToArray(_ref6, 3),
          e = _ref7[1],
          o = _ref7[2];

      if (!e || !o) return null;

      var n = _toConsumableArray(a(o, /(rgba?\(.*?\)|#?\w+)(.*?)(?=,|$)/gi)),
          i = [];

      var r = null,
          s = null;

      for (var _t15 = 0; _t15 < n.length; _t15++) {
        var _n$_t = _slicedToArray(n[_t15], 3),
            _e16 = _n$_t[0],
            _o17 = _n$_t[1],
            _c6 = _n$_t[2],
            _a2 = p(_o17),
            _u = _c6.split(/\s+/g).map(function (t) {
          return l(t, /^-?(\d*(\.\d+)?)%$/, 1);
        }).filter(Boolean).map(Number);

        if (!_u.length && _a2) i.push({
          loc: null,
          color: _a2
        });else if (_u.length) {
          var _iteratorNormalCompletion6 = true;
          var _didIteratorError6 = false;
          var _iteratorError6 = undefined;

          try {
            for (var _iterator6 = _u[Symbol.iterator](), _step6; !(_iteratorNormalCompletion6 = (_step6 = _iterator6.next()).done); _iteratorNormalCompletion6 = true) {
              var _t16 = _step6.value;
              i.push({
                loc: _t16,
                color: _a2 || s
              });
            }
          } catch (err) {
            _didIteratorError6 = true;
            _iteratorError6 = err;
          } finally {
            try {
              if (!_iteratorNormalCompletion6 && _iterator6["return"] != null) {
                _iterator6["return"]();
              }
            } finally {
              if (_didIteratorError6) {
                throw _iteratorError6;
              }
            }
          }
        } else r || (r = _e16);
        s = _a2 || s;
      }

      i[i.length - 1].loc || (i[i.length - 1].loc = 100);

      for (var _t17 = 0; _t17 < i.length; _t17++) {
        var _e17 = i[_t17];
        if (!_e17.loc) if (_t17) {
          var _o18 = 2,
              _n10 = _t17 + 1;

          for (; _n10 < i.length && !i[_n10].loc; _n10++) {
            _o18++;
          }

          _e17.loc = i[_t17 - 1].loc + (i[_n10].loc - i[_t17 - 1].loc) / _o18;
        } else _e17.loc = 0;
      }

      return {
        str: t,
        type: e,
        modifier: r,
        stops: i
      };
    }

    var h = function h(t) {
      document.body.appendChild(c);
      var e = u(t);
      return document.body.removeChild(c), e;
    },
        d = {
      angleToDegrees: function angleToDegrees(t) {
        var e = t.trim().toLowerCase().match(/^(-?\d*(\.\d+)?)(deg|rad|grad|turn)$/i);
        if (!e) return null;
        var o = Number(e[1]);

        switch (e[3]) {
          case "deg":
            return o;

          case "rad":
            return 180 / Math.PI * o;

          case "grad":
            return o / 400 * 360;

          case "turn":
            return 360 * o;
        }

        return null;
      }
    };

    function f(t, e, o) {
      return e in t ? Object.defineProperty(t, e, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
      }) : t[e] = o, t;
    }

    var m = i.a.utils,
        g = m.on,
        v = m.off;

    var b =
    /*#__PURE__*/
    function () {
      function b(t) {
        var _this8 = this;

        _classCallCheck(this, b);

        f(this, "_stops", []), f(this, "_angle", 0), f(this, "_angles", [{
          angle: 0,
          name: "to top"
        }, {
          angle: 90,
          name: "to right"
        }, {
          angle: 180,
          name: "to bottom"
        }, {
          angle: 270,
          name: "to left"
        }]), f(this, "_direction", "circle at center"), f(this, "_directions", [{
          pos: "tl",
          css: "circle at left top"
        }, {
          pos: "tm",
          css: "circle at center top"
        }, {
          pos: "tr",
          css: "circle at right top"
        }, {
          pos: "r",
          css: "circle at right"
        }, {
          pos: "m",
          css: "circle at center"
        }, {
          pos: "l",
          css: "circle at left"
        }, {
          pos: "br",
          css: "circle at right bottom"
        }, {
          pos: "bm",
          css: "circle at center bottom"
        }, {
          pos: "bl",
          css: "circle at left bottom"
        }]), f(this, "_focusedStop", null), f(this, "_mode", "linear"), f(this, "_modes", ["linear", "radial"]), f(this, "_root", null), f(this, "_eventListener", {
          init: [],
          change: []
        }), t = Object.assign({
          stops: [["#42445a", 0], ["#20b6dd", 1]]
        }, t), this._root = r(t), CSS.supports("background-image", "conic-gradient(#fff, #fff)") && this._modes.push("conic"), t.el = t.el.split(/>>/g).reduce(function (t, e, o, n) {
          return t = t.querySelector(e), o < n.length - 1 ? t.shadowRoot : t;
        }, document), t.el.parentElement.replaceChild(this._root.root, t.el), this._pickr = i.a.create({
          el: this._root.pickr,
          theme: "nano",
          inline: !0,
          useAsButton: !0,
          showAlways: !0,
          defaultRepresentation: "HEXA",
          components: {
            palette: !0,
            preview: !0,
            opacity: !0,
            hue: !0,
            interaction: {
              input: !0
            }
          }
        }).on("change", function (t) {
          _this8._focusedStop && (_this8._focusedStop.color = t.toRGBA().toString(0), _this8._render());
        }).on("init", function () {
          var _iteratorNormalCompletion7 = true;
          var _didIteratorError7 = false;
          var _iteratorError7 = undefined;

          try {
            for (var _iterator7 = t.stops[Symbol.iterator](), _step7; !(_iteratorNormalCompletion7 = (_step7 = _iterator7.next()).done); _iteratorNormalCompletion7 = true) {
              var _step7$value = _slicedToArray(_step7.value, 2),
                  _e18 = _step7$value[0],
                  _o19 = _step7$value[1];

              _this8.addStop(_e18, _o19, !0);
            }
          } catch (err) {
            _didIteratorError7 = true;
            _iteratorError7 = err;
          } finally {
            try {
              if (!_iteratorNormalCompletion7 && _iterator7["return"] != null) {
                _iterator7["return"]();
              }
            } finally {
              if (_didIteratorError7) {
                throw _iteratorError7;
              }
            }
          }

          _this8._bindEvents(), _this8._emit("init", _this8);
        });
      }

      _createClass(b, [{
        key: "_bindEvents",
        value: function _bindEvents() {
          var _this9 = this;

          var t = this._root.gradient;
          g(t.mode, ["mousedown", "touchstart"], function (t) {
            var e = _this9._modes.indexOf(_this9._mode) + 1;
            _this9._mode = _this9._modes[e === _this9._modes.length ? 0 : e], _this9._render(!0), t.stopPropagation();
          }), g(t.stops.preview, "click", function (t) {
            _this9.addStop(_this9._pickr.getColor().toRGBA().toString(), _this9._resolveColorStopPosition(t.pageX));
          }), g(t.result, ["mousedown", "touchstart"], function (e) {
            if (e.preventDefault(), "linear" !== _this9._mode) return;
            t.angle.classList.add("gpcr-active");
            var o = g(window, ["mousemove", "touchmove"], function (e) {
              var _s8 = s(e),
                  o = _s8.x,
                  n = _s8.y,
                  i = t.angle.getBoundingClientRect(),
                  r = i.left + i.width / 2,
                  c = i.top + i.height / 2,
                  a = Math.atan2(o - r, n - c) - Math.PI,
                  l = Math.abs(180 * a / Math.PI),
                  p = [1, 2, 4][Number(e.shiftKey || 2 * e.ctrlKey)];

              _this9.setLinearAngle(l - l % (45 / p));
            }),
                n = g(window, ["mouseup", "touchend", "touchcancel"], function () {
              t.angle.classList.remove("gpcr-active"), v.apply(void 0, _toConsumableArray(o)), v.apply(void 0, _toConsumableArray(n));
            });
          }), g(t.pos, ["mousedown", "touchstart"], function (t) {
            var e = t.target.getAttribute("data-pos"),
                o = _this9._directions.find(function (t) {
              return t.pos === e;
            });

            _this9.setRadialPosition(o && o.css || _this9._direction);
          });
        }
      }, {
        key: "_render",
        value: function _render() {
          var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : !1;
          var _this$_root$gradient = this._root.gradient,
              e = _this$_root$gradient.stops.preview,
              o = _this$_root$gradient.result,
              n = _this$_root$gradient.arrow,
              i = _this$_root$gradient.angle,
              r = _this$_root$gradient.pos,
              s = _this$_root$gradient.mode,
              c = this._stops,
              a = this._mode,
              l = this._angle;
          c.sort(function (t, e) {
            return t.loc - e.loc;
          });
          var _iteratorNormalCompletion8 = true;
          var _didIteratorError8 = false;
          var _iteratorError8 = undefined;

          try {
            for (var _iterator8 = c[Symbol.iterator](), _step8; !(_iteratorNormalCompletion8 = (_step8 = _iterator8.next()).done); _iteratorNormalCompletion8 = true) {
              var _step8$value = _step8.value,
                  _t18 = _step8$value.color,
                  _e19 = _step8$value.el,
                  _o20 = _step8$value.loc;
              Object.assign(_e19.style, {
                left: "".concat(100 * _o20, "%"),
                color: _t18
              });
            }
          } catch (err) {
            _didIteratorError8 = true;
            _iteratorError8 = err;
          } finally {
            try {
              if (!_iteratorNormalCompletion8 && _iterator8["return"] != null) {
                _iterator8["return"]();
              }
            } finally {
              if (_didIteratorError8) {
                throw _iteratorError8;
              }
            }
          }

          n.style.transform = "rotate(".concat(l - 90, "deg)"), e.style.background = "linear-gradient(to right, ".concat(this.getStops().toString("linear"), ")"), o.style.background = this.getGradient().toString(), r.style.opacity = "radial" === a ? "" : "0", r.style.visibility = "radial" === a ? "" : "hidden", i.style.opacity = "linear" === a ? "" : "0", i.style.visibility = "linear" === a ? "" : "hidden", s.setAttribute("data-mode", a), !t && this._emit("change", this);
        }
      }, {
        key: "_resolveColorStopPosition",
        value: function _resolveColorStopPosition(t) {
          var e = this._root.gradient.stops.markers,
              o = e.getBoundingClientRect();
          var n = (t - o.left) / o.width;
          return n < 0 && (n = 0), n > 1 && (n = 1), n;
        }
      }, {
        key: "addStop",
        value: function addStop(t) {
          var _this10 = this;

          var e = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : .5;
          var o = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : !1;
          var n = this._root.gradient.stops.markers,
              i = m.createElementFromString('<div class="gpcr-marker"></div>');
          n.appendChild(i), this._pickr.setColor(t), t = this._pickr.getColor().toRGBA().toString(0);
          var r = {
            el: i,
            loc: e,
            color: t,
            listener: g(i, ["mousedown", "touchstart"], function (t) {
              t.preventDefault();
              var e = n.getBoundingClientRect();
              _this10._pickr.setColor(r.color), _this10._focusedStop = r;
              var o = !1;
              var c = g(window, ["mousemove", "touchmove"], function (t) {
                var _s9 = s(t),
                    n = _s9.x,
                    c = _s9.y,
                    a = Math.abs(c - e.y);

                o = a > 50 && _this10._stops.length > 2, i.style.opacity = o ? "0" : "1", o || (r.loc = _this10._resolveColorStopPosition(n), _this10._render());
              }),
                  a = g(window, ["mouseup", "touchend", "touchcancel"], function () {
                v.apply(void 0, _toConsumableArray(c)), v.apply(void 0, _toConsumableArray(a)), o && (_this10.removeStop(r), _this10._render(!0));
              });
            })
          };
          return this._focusedStop = r, this._stops.push(r), this._render(o), this;
        }
      }, {
        key: "removeStop",
        value: function removeStop(t) {
          var e = this._stops,
              o = function () {
            return "number" == typeof t ? e.find(function (t) {
              return t.loc === t;
            }) : "string" == typeof t ? e.find(function (t) {
              return t.color === t;
            }) : "object" == _typeof(t) ? t : void 0;
          }();

          e.splice(e.indexOf(o), 1), o.el.remove(), v.apply(void 0, _toConsumableArray(o.listener)), this._focusedStop === o && (this._focusedStop = e[0]), this._render();
        }
      }, {
        key: "setGradient",
        value: function setGradient(t) {
          var e = h(t);
          if (!e || e.stops.length < 2) return !1;

          var o = e.type,
              n = e.stops,
              i = e.modifier,
              r = _toConsumableArray(this._stops);

          if (this._modes.includes(o)) {
            this._mode = o;
            var _iteratorNormalCompletion9 = true;
            var _didIteratorError9 = false;
            var _iteratorError9 = undefined;

            try {
              for (var _iterator9 = n[Symbol.iterator](), _step9; !(_iteratorNormalCompletion9 = (_step9 = _iterator9.next()).done); _iteratorNormalCompletion9 = true) {
                var _t19 = _step9.value;
                this.addStop(_t19.color, _t19.loc / 100);
              }
            } catch (err) {
              _didIteratorError9 = true;
              _iteratorError9 = err;
            } finally {
              try {
                if (!_iteratorNormalCompletion9 && _iterator9["return"] != null) {
                  _iterator9["return"]();
                }
              } finally {
                if (_didIteratorError9) {
                  throw _iteratorError9;
                }
              }
            }

            var _iteratorNormalCompletion10 = true;
            var _didIteratorError10 = false;
            var _iteratorError10 = undefined;

            try {
              for (var _iterator10 = r[Symbol.iterator](), _step10; !(_iteratorNormalCompletion10 = (_step10 = _iterator10.next()).done); _iteratorNormalCompletion10 = true) {
                var _t20 = _step10.value;
                this.removeStop(_t20);
              }
            } catch (err) {
              _didIteratorError10 = true;
              _iteratorError10 = err;
            } finally {
              try {
                if (!_iteratorNormalCompletion10 && _iterator10["return"] != null) {
                  _iterator10["return"]();
                }
              } finally {
                if (_didIteratorError10) {
                  throw _iteratorError10;
                }
              }
            }

            return "linear" === o ? (this._angle = 180, i && this.setLinearAngle(i)) : "radial" === o && (this._direction = "circle at center", i && this.setRadialPosition(i)), !0;
          }

          return !1;
        }
      }, {
        key: "getGradient",
        value: function getGradient() {
          var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this._mode;
          var e = this.getStops().toString(t);

          switch (t) {
            case "linear":
              return "linear-gradient(".concat(this._angle, "deg, ").concat(e, ")");

            case "radial":
              return "radial-gradient(".concat(this._direction, ", ").concat(e, ")");

            case "conic":
              return "conic-gradient(".concat(e, ")");
          }
        }
      }, {
        key: "getStops",
        value: function getStops() {
          var t = this._stops.map(function (t) {
            return {
              color: t.color,
              location: t.loc
            };
          }),
              e = this._mode;

          return t.toString = function () {
            var t = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : e;

            switch (t) {
              case "linear":
              case "radial":
                return this.map(function (t) {
                  return "".concat(t.color, " ").concat(100 * t.location, "%");
                }).join(",");

              case "conic":
                return this.map(function (t) {
                  return "".concat(t.color, " ").concat(360 * t.location, "deg");
                }).join(",");
            }
          }, t;
        }
      }, {
        key: "getLinearAngle",
        value: function getLinearAngle() {
          return "linear" === this._mode ? this._angle : -1;
        }
      }, {
        key: "setLinearAngle",
        value: function setLinearAngle(t) {
          return "number" == typeof (t = "number" == typeof t ? t : d.angleToDegrees(t) || (this._angles.find(function (e) {
            return e.name === t;
          }) || {}).angle) && (this._angle = t, this._render(), !0);
        }
      }, {
        key: "setRadialPosition",
        value: function setRadialPosition(t) {
          var e = this._directions.find(function (e) {
            return e.css === t;
          });

          if (!e) return !1;
          this._direction = e.css;

          for (var _i8 = 0, _Array$from2 = Array.from(this._root.gradient.pos.children); _i8 < _Array$from2.length; _i8++) {
            var _t21 = _Array$from2[_i8];

            _t21.classList[_t21.getAttribute("data-pos") === e.pos ? "add" : "remove"]("gpcr-active");
          }

          return this._render(), !0;
        }
      }, {
        key: "getRadialPosition",
        value: function getRadialPosition() {
          return "radial" === this._mode ? this._direction : null;
        }
      }, {
        key: "_emit",
        value: function _emit(t) {
          var _this11 = this;

          for (var _len2 = arguments.length, e = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
            e[_key2 - 1] = arguments[_key2];
          }

          this._eventListener[t].forEach(function (t) {
            return t.apply(void 0, e.concat([_this11]));
          });
        }
      }, {
        key: "on",
        value: function on(t, e) {
          return "function" == typeof e && "string" == typeof t && t in this._eventListener && this._eventListener[t].push(e), this;
        }
      }, {
        key: "off",
        value: function off(t, e) {
          var o = this._eventListener[t];

          if (o) {
            var _t22 = o.indexOf(e);

            ~_t22 && o.splice(_t22, 1);
          }

          return this;
        }
      }]);

      return b;
    }();

    b.Pickr = i.a;
    e["default"] = b;
  }])["default"];
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../../node_modules/webpack/buildin/harmony-module.js */ "./node_modules/webpack/buildin/harmony-module.js")(module)))

/***/ })

}]);