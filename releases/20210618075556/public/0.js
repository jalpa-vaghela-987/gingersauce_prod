(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./public/js/chromoselector/src/chromoselector.js":
/*!********************************************************!*\
  !*** ./public/js/chromoselector/src/chromoselector.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 //var jQuery = require('jquery');

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($, window, Math, defaults) {
  var document = window.document;
  /**
   * NAMESPACE for events and data
   */

  var NAMESPACE = 'chromoselector';
  var EVENTS = 'create|ready|update|destroy|show|beforeShow|hide|beforeHide|resize|resizeStart|resizeStop';

  var Throttle = __webpack_require__(/*! ./throttle.js */ "./public/js/chromoselector/src/throttle.js");

  var Color = __webpack_require__(/*! ./color.js */ "./public/js/chromoselector/src/color.js");

  var Panel = __webpack_require__(/*! ./panel.js */ "./public/js/chromoselector/src/panel.js");

  var Util = __webpack_require__(/*! ./util.js */ "./public/js/chromoselector/src/util.js");
  /**
   * 2D MATHS
   */


  function getPointOnCircle(radius, degrees, offset) {
    return [offset + radius * Math.cos(degrees), offset + radius * Math.sin(degrees)];
  }

  function pointInCircle(point, origin, radius) {
    return getDistance(point, [origin, origin]) <= radius;
  }

  function pointInTriangle(pt, v1, v2, v3) {
    var sign = function sign(p1, p2, p3) {
      return (p1[0] - p3[0]) * (p2[1] - p3[1]) - (p2[0] - p3[0]) * (p1[1] - p3[1]);
    };

    var b1 = sign(pt, v1, v2) < 0;
    var b2 = sign(pt, v2, v3) < 0;
    var b3 = sign(pt, v3, v1) < 0;
    return b1 === b2 && b2 === b3;
  }

  function getPerpedicularSlope(p1, p2) {
    return -1 / ((p2[1] - p1[1]) / (p2[0] - p1[0]));
  }

  function getDistance(p1, p2) {
    var m1 = p1[0] - p2[0];
    var m2 = p1[1] - p2[1];
    return Math.sqrt(m1 * m1 + m2 * m2);
  }

  function pointOnLine(point, slope) {
    // slope*slope is the same as Math.abs(slope)
    // but faster when checking if it's Infinity
    // See: http://jsperf.com/abs-test
    if (slope * slope === Infinity) {
      return [point[0], point[1] + 1];
    }

    return [point[0] + 1, slope + point[1]];
  }

  function intersectLineLine(a1, a2, b1, b2) {
    var u_b = (b2[1] - b1[1]) * (a2[0] - a1[0]) - (b2[0] - b1[0]) * (a2[1] - a1[1]);
    var ua_t = (b2[0] - b1[0]) * (a1[1] - b1[1]) - (b2[1] - b1[1]) * (a1[0] - b1[0]);
    var ua = ua_t / u_b;
    return [a1[0] + ua * (a2[0] - a1[0]), a1[1] + ua * (a2[1] - a1[1])];
  }
  /**
   * Sets a pixel on a canvas
   */


  function setPixel(imageData, x, y, pixel) {
    var i,
        index = (x + y * imageData.width) * 4;

    for (i = 0; i < 4; i++) {
      imageData.data[index + i] = pixel[i];
    }
  }
  /**
   * the following function is simplified
   * to account for the mask always being
   * straight relative to the x-axis
   */


  function getLuminosityPixel(point1, point2, point3, inputPoint) {
    var lumIntersectionPoint1 = intersectLineLine(inputPoint, [inputPoint[0] + 20, inputPoint[1]], point1, point2);
    var lumIntersectionPoint2 = intersectLineLine(inputPoint, [inputPoint[0] + 20, inputPoint[1]], point1, point3);
    var l;

    if (inputPoint[0] < lumIntersectionPoint1[0]) {
      l = 255;
    } else if (inputPoint[0] > lumIntersectionPoint2[0]) {
      l = 0;
    } else {
      l = (lumIntersectionPoint2[0] - inputPoint[0]) / (lumIntersectionPoint2[0] - lumIntersectionPoint1[0]) * 255;
    }

    return [l, l, l, 255];
  }
  /**
   * Draws the colorwheel background
   */


  var Cache = {//    ColorWheelBg: 0
  };

  function colorPicker_drawColorWheelBg(canvas, width) {
    var ctx = canvas.getContext("2d");
    var temp = $("<canvas>").attr("width", width).attr("height", width)[0];
    var tempCtx = temp.getContext("2d");

    if (!Cache.ColorWheelBg) {
      Cache.ColorWheelBg = ctx.createImageData(80, 80);
      var degree,
          i,
          j,
          x,
          y,
          r,
          g,
          b,
          rad2deg = 180 / Math.PI;

      var getValue = function getValue(degree) {
        degree %= 360;

        if (degree >= 240) {
          return 0;
        } else if (degree >= 180) {
          return 255 * ((240 - degree) / 60);
        } else if (degree >= 60) {
          return 255;
        }

        return 255 * (degree / 60);
      };

      for (i = 0; i < 80; i++) {
        x = i - 40;

        for (j = 0; j < 80; j++) {
          y = j - 40;
          degree = Math.atan2(x, y) * rad2deg + 270;
          r = getValue(degree + 120);
          g = getValue(degree);
          b = getValue(degree + 240);
          setPixel(Cache.ColorWheelBg, i, j, [r, g, b, 255]);
        }
      }
    }

    ctx.putImageData(Cache.ColorWheelBg, 0, 0);
    tempCtx.scale(width / 80, width / 80);
    tempCtx.drawImage(canvas, 0, 0);
    ctx.drawImage(temp, 0, 0);
  }
  /**
   * Draws the rainbow wheel
   */


  function colorPicker_drawHueSelector(self) {
    var width = self.Width;
    var ctx = self.canvases[1].getContext("2d");
    colorPicker_drawColorWheelBg(self.canvases[1], width);
    var origin = [width / 2, width / 2]; // cut out doughnut

    /** webkit bug prevents usage of "destination-in" */

    ctx['globalCompositeOperation'] = "destination-out";
    ctx['strokeStyle'] = 'rgba(0,0,0,1)';
    ctx.lineWidth = self.hueSelectorLineWidth;
    ctx.beginPath();
    ctx.arc(origin[0], origin[1], self.hueSelectorCircleRadius - self.hueSelectorLineWidth / 2, 0, Math.PI * 2, true);
    ctx.closePath();
    ctx.fill();
    var tempCanvas = $('<canvas/>').attr('width', width).attr('height', width)[0];
    var tempCtx = tempCanvas.getContext('2d');
    tempCtx['fillRect'](0, 0, width, width);
    tempCtx['globalCompositeOperation'] = "destination-out";
    tempCtx.beginPath();
    tempCtx.arc(origin[0], origin[1], self.hueSelectorCircleRadius + self.hueSelectorLineWidth / 2, 0, Math.PI * 2, true);
    tempCtx.closePath();
    tempCtx.fill();
    ctx.drawImage(tempCanvas, 0, 0); // shadow

    ctx = self.canvases[0].getContext("2d");
    ctx.lineWidth = self.hueSelectorLineWidth - 2;
    ctx.shadowColor = self.settings.shadowColor;
    ctx.shadowBlur = self.settings.shadow;
    ctx.beginPath();
    ctx.arc(origin[0], origin[1], self.hueSelectorCircleRadius, 0, Math.PI * 2, true);
    ctx.closePath();
    ctx.stroke();
  }
  /**
   * Draws the triangular selector
   */


  function colorPicker_drawSaturationLimunositySelector(self) {
    var hue = self.Color.getHsl().h;
    var canvas = self.canvases[2];
    var ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, self.Width, self.Width);
    var degrees = -Math.PI / 2;
    var points = colorPicker_getPoints(self, degrees);
    var tempCtx;

    if (!self.ready) {
      var maskImageData = ctx.createImageData(self.Width, self.Width); // triangle limits

      var limits = function limits(points, axis) {
        return {
          start: Math.round(Math.min(points[0][axis] - 3, points[1][axis] - 3, points[2][axis] - 3)),
          end: Math.round(Math.max(points[0][axis] + 3, points[1][axis] + 3, points[2][axis] + 3))
        };
      };

      var limitX = limits(points, 0);
      var limitY = limits(points, 1);
      var i, j; // draw

      for (i = points[0][0] - 3; i <= limitX.end; i++) {
        for (j = limitY.start + (1.7 * (i - points[0][0]) | 0) - 3; j <= limitY.end; j++) {
          setPixel(maskImageData, i, j, getLuminosityPixel(points[0], points[1], points[2], [i, j]));
        }
      }

      for (i = limitX.start; i <= points[0][0] - 3; i++) {
        for (j = limitY.start - (1.7 * (i - points[0][0]) | 0) - 3; j <= limitY.end; j++) {
          setPixel(maskImageData, i, j, getLuminosityPixel(points[0], points[1], points[2], [i, j]));
        }
      }

      tempCtx = self.tempCanvas.getContext('2d');
      tempCtx.putImageData(maskImageData, 0, 0);
      var lingrad = tempCtx.createLinearGradient(0, limitY.start, 0, limitY.end);
      lingrad['addColorStop'](1, 'rgba(0,0,0,0)');
      lingrad['addColorStop'](0, 'rgba(0,0,0,1)');
      tempCtx['fillStyle'] = lingrad;
      tempCtx['globalCompositeOperation'] = "destination-out";
      tempCtx['fillRect'](limitX.start, limitY.start, limitX.end, limitY.end);
      tempCtx['globalCompositeOperation'] = "source-over";
    }

    degrees = (1 - hue) * Math.PI * 2;
    points = colorPicker_getPoints(self, degrees); // Fill background

    ctx['fillStyle'] = new Color({
      h: hue,
      s: 1,
      l: 0.5
    }).getHexString();
    ctx['fillRect'](0, 0, self.Width, self.Width); // Copy rotated mask

    ctx.save();
    ctx.translate(self.Width / 2, self.Width / 2);
    ctx.rotate(degrees + Math.PI / 2);
    ctx.translate(-self.Width / 2, -self.Width / 2);
    ctx.drawImage(self.tempCanvas, 0, 0);
    ctx.restore(); // cut out triangle

    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineTo(points[1][0], points[1][1]);
    ctx.lineTo(points[0][0], points[0][1]);
    ctx.lineTo(points[2][0], points[2][1]);
    ctx.lineTo(points[1][0], points[1][1]);
    ctx.lineTo(0, 0);
    ctx.lineTo(0, self.Width);
    ctx.lineTo(self.Width, self.Width);
    ctx.lineTo(self.Width, 0);
    ctx.lineTo(0, 0);
    ctx.closePath();
    ctx['globalCompositeOperation'] = "destination-out";
    ctx['fillStyle'] = 'rgba(0,0,0,1)';
    ctx.fill(); // shadow

    var shadowPoint = function shadowPoint(index, axis) {
      var pixel = 1 / (self.Width / 2) * 2;
      return self.Width / 2 * pixel + points[index][axis] * (1 - pixel);
    };

    ctx['globalCompositeOperation'] = "destination-over";
    ctx.beginPath();
    ctx.moveTo(shadowPoint(0, 0), shadowPoint(0, 1));
    ctx.lineTo(shadowPoint(1, 0), shadowPoint(1, 1));
    ctx.lineTo(shadowPoint(2, 0), shadowPoint(2, 1));
    ctx.closePath();
    ctx['fillStyle'] = 'rgba(0,0,0,1)';
    ctx.shadowColor = self.settings.shadowColor;
    ctx.shadowBlur = self.settings.shadow;
    ctx.fill();
    ctx.shadowColor = 'rgba(0,0,0,0)';
    ctx.shadowBlur = 0;
    ctx['globalCompositeOperation'] = "source-over";
  }

  function colorPicker_drawIndicators(self) {
    var canvas = self.canvases[3];
    var ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, self.Width, self.Width);
    var degrees = (1 - self.Color.getHsl().h) * Math.PI * 2;
    var points = colorPicker_getPoints(self, degrees);
    /** get hue indicator position */

    var indicator = getPointOnCircle(self.hueSelectorCircleRadius, degrees, self.Width / 2);
    /** get draw sat/lum indicator position */

    var colorPoint = [points[1][0] * self.Color.getHsl().l + (1 - self.Color.getHsl().l) * points[2][0], points[1][1] * self.Color.getHsl().l + (1 - self.Color.getHsl().l) * points[2][1]];
    var m = getPerpedicularSlope(points[1], points[2]);
    var colorPoint2 = pointOnLine(colorPoint, m);
    var thePoint1 = intersectLineLine(colorPoint, colorPoint2, points[1], points[2]);
    var maxLength = getDistance(points[1], points[2]);
    var length = getDistance(points[2], thePoint1);
    var slopePoint = points[2];

    if (length >= maxLength / 2) {
      slopePoint = points[1];
    }

    var thePoint2 = intersectLineLine(colorPoint, colorPoint2, points[0], slopePoint);
    colorPoint = [thePoint2[0] * self.Color.getHsl().s + (1 - self.Color.getHsl().s) * thePoint1[0], thePoint2[1] * self.Color.getHsl().s + (1 - self.Color.getHsl().s) * thePoint1[1]];
    /** draw the indicators */

    $.each([indicator, colorPoint], function (i, indicator) {
      ctx['strokeStyle'] = "#fff";
      ctx.lineWidth = 1.5;
      ctx.beginPath();
      ctx.arc(indicator[0], indicator[1], 6, 0, Math.PI * 2, true);
      ctx.closePath();
      ctx.stroke();
      ctx.lineWidth = 2;
      ctx['strokeStyle'] = 'rgba(0,0,0,1)';
      ctx.beginPath();
      ctx.arc(indicator[0], indicator[1], 4.5, 0, Math.PI * 2, true);
      ctx.closePath();
      ctx.stroke();
    });
  }

  function drawResizer(self, canvas) {
    var ctx = canvas.getContext("2d");
    /** draw resizer */

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    if (self._root.css('border-bottom-color')) {
      ctx['strokeStyle'] = self._root.css('border-bottom-color');
    } else {
      ctx['strokeStyle'] = '#444';
    }

    ctx.lineWidth = 1;
    ctx.lineCap = "round";
    ctx.beginPath();
    ctx.moveTo(0, 18);
    ctx.lineTo(18, 0);
    ctx.moveTo(7, 18);
    ctx.lineTo(18, 7);
    ctx.moveTo(13, 18);
    ctx.lineTo(18, 13);
    ctx.closePath();
    ctx.stroke();
  }
  /** The color picker functions */


  function colorPicker_getPoints(self, hue) {
    var i,
        points = [];

    for (i = 0; i < 3; i++) {
      points[i] = getPointOnCircle(self.triangleRadius, hue, self.Width / 2);
      hue -= Math.PI * 2 / 3;
    }

    return points;
  }

  function colorPicker_reDrawHue(self, e) {
    var coords = Util.getEventPosition(self, e, self._picker);
    var angle = Math.atan2(coords[0] - self.Width / 2, coords[1] - self.Width / 2) * (180 / Math.PI) + 270;
    var hsla = self.Color.getHsla();
    self.Color.setColor({
      h: angle / 360,
      s: hsla.s,
      l: hsla.l,
      a: hsla.a
    });
    colorPicker_drawSaturationLimunositySelector(self);
    colorPicker_drawIndicators(self);
    self.valueRenderer(self);
  }

  function colorPicker_reDrawSatLum(self, s, l) {
    var hsla = self.Color.getHsla();
    self.Color.setColor({
      h: hsla.h,
      s: s,
      l: l,
      a: hsla.a
    });
    colorPicker_drawIndicators(self);
    self.valueRenderer(self);
  }

  function colorPicker_update(self) {
    if (self.settings.autosave) {
      colorPicker_save(self);
    }

    if (self.settings.preview) {
      self._previewColor.css('background', self.Color.getRgbaString());
    }

    self._source.trigger(self.settings.eventPrefix + 'update');
  }

  function colorPicker_save(self) {
    var str = "";

    if (typeof self.settings.color2str == 'function') {
      str = self.settings.color2str.call(null, self.Color);
    } else {
      str = self.Color.getHexString();
    }

    if (typeof self.settings.save == 'function') {
      self.settings.save.call(self._source[0], str);
    } else {
      self._source.val(str).html(str);
    }
  }

  function colorPicker_load(self, redraw) {
    var str;

    if (typeof self.settings.load == 'function') {
      str = self.settings.load.call(self._source);
    } else {
      str = self._source.val() || self._source.html();
    }

    if (typeof self.settings.str2color == 'function') {
      self.Color = new Color(self.settings.str2color.call(null, str));
    } else {
      self.Color = new Color(str);
    }

    if (self.settings.preview && self._preview) {
      self._previewColor.css('background', self.Color.getRgbaString());
    }

    if (self.panelApi) {
      self.panelApi.setColor(self.Color);
    }

    if (redraw) {
      colorPicker_drawSaturationLimunositySelector(self);
      colorPicker_drawIndicators(self);
    }
  }

  function colorPicker_show(self, speed) {
    if (self.showing || self._root.is(':visible')) {
      return;
    }

    self.showing = 1;

    if (self.hiding) {
      clearTimeout(self.hiding);
      self.hiding = 0;
      return;
    }

    if (!self.ready) {
      colorPicker_drawAll(self);
    } else {
      colorPicker_load(self);
      colorPicker_drawSaturationLimunositySelector(self);
      colorPicker_drawIndicators(self);
    }

    if (typeof speed !== 'undefined') {
      speed = parseInt(speed, 10);

      if (speed < 0 || isNaN(speed)) {
        speed = self.settings.speed;
      }
    } else {
      speed = self.settings.speed;
    }

    var retval = self._source.triggerHandler(self.settings.eventPrefix + 'beforeShow');

    if (typeof retval == 'undefined' || retval) {
      colorPicker_fixPosition(self);
      colorPicker_updatePreview(self);
      var effect = self.Effect === 'fade' ? 'fadeIn' : 'slideDown';

      self._root[effect].call(self._root, speed, function () {
        colorPicker_fixPosition(self);

        if (self.settings.resizable) {
          drawResizer(self, self._resizer[0]);
        }

        self._source.trigger(self.settings.eventPrefix + 'show');

        self.showing = 0;
      });

      if (self.panelApi) {
        self.panelApi.setHeight(self._container.height());
      }
    }
  }

  function colorPicker_hide(self, speed) {
    self.hiding = setTimeout(function () {
      if (self._panel && self._panel.find('select:focus').length) {
        return;
      }

      self.hiding = 0;

      if (typeof speed !== 'undefined') {
        speed = parseInt(speed, 10);

        if (speed < 0 || isNaN(speed)) {
          speed = self.settings.speed;
        }
      } else {
        speed = self.settings.speed;
      }

      var retval = self._source.triggerHandler(self.settings.eventPrefix + 'beforeHide');

      if (typeof retval == 'undefined' || retval) {
        var effect = self.Effect === 'fade' ? 'fadeOut' : 'slideUp';

        self._root[effect].call(self._root, speed, function () {
          colorPicker_fixPosition(self);

          self._source.trigger(self.settings.eventPrefix + 'hide');
        });
      }
    }, 100);
  }

  function colorPicker_toggle(self, speed) {
    if (self._root.is(':visible')) {
      colorPicker_hide(self, speed);
    } else {
      colorPicker_show(self, speed);
    }
  }

  function colorPicker_handleSatLumDrag(self, e) {
    var degrees = (1 - self.Color.getHsl().h) * Math.PI * 2;
    var points = colorPicker_getPoints(self, degrees);
    var inputPoint = Util.getEventPosition(self, e, self._picker);
    var sanitisedInputPoint = inputPoint;

    if (!pointInTriangle(inputPoint, points[0], points[1], points[2])) {
      var i,
          distances = [];

      for (i = 0; i < 3; i++) {
        distances[i] = getDistance(points[i], inputPoint);
      }

      var maxDistance = Math.max.apply(null, distances);

      for (i = 0; i < 3; i++) {
        if (distances[i] === maxDistance) {
          sanitisedInputPoint = colorPicker_sanitiseDragInput(inputPoint, points, distances, i);
          break;
        }
      }
    }

    var color = colorPicker_getSatLumColor(points[0], points[1], points[2], sanitisedInputPoint, self.Color.getHsl().h);
    colorPicker_reDrawSatLum(self, color.s, color.l);
  }

  function colorPicker_sanitiseDragInput(inputPoint, points, distances, index) {
    var vertices1 = [0, 1, 2];
    var vertices2 = [1, 0, 1];
    var vertices3 = [2, 2, 0];
    var intersect = intersectLineLine(inputPoint, points[vertices1[index]], points[vertices2[index]], points[vertices3[index]]);

    if (getDistance(intersect, points[vertices1[index]]) >= getDistance(points[0], points[1])) {
      var i,
          minDistance = Math.min.apply(null, distances);

      for (i = 0; i < 3; i++) {
        if (distances[i] === minDistance) {
          intersect = points[i];
          break;
        }
      }
    }

    return intersect;
  }

  function colorPicker_getSatLumColor(point1, point2, point3, inputPoint, hue) {
    var m = getPerpedicularSlope(point2, point3);
    var inputPoint2 = pointOnLine(inputPoint, m);
    var thePoint1 = intersectLineLine(inputPoint, inputPoint2, point2, point3);
    var maxWidth = getDistance(point2, point3);
    var width = getDistance(point3, thePoint1);
    var perpedicularPoint = point3;

    if (width >= maxWidth / 2) {
      perpedicularPoint = point2;
    }

    m = getPerpedicularSlope(point1, perpedicularPoint);
    inputPoint2 = pointOnLine(inputPoint, m);
    var thePoint2 = intersectLineLine(inputPoint, thePoint1, point1, perpedicularPoint);
    var height = getDistance(thePoint1, inputPoint);
    var maxHeight = getDistance(thePoint1, thePoint2);
    var s = height / maxHeight;

    if (isNaN(s)) {
      s = 0;
    }

    return {
      h: hue,
      s: s,
      l: width / maxWidth
    };
  }

  function colorPicker_drawAll(self) {
    colorPicker_drawHueSelector(self);
    colorPicker_drawSaturationLimunositySelector(self);
    colorPicker_drawIndicators(self);
    self.ready = 1;

    self._source.trigger(self.settings.eventPrefix + 'ready');
  }

  function colorPicker_handleResizeDrag(self, e) {
    var inputPoint = Util.getEventPosition(self, e, self._picker);

    if (self.settings.panel || self.settings.panelAlpha) {
      inputPoint[0] -= self.panelApi.getWidth();
    }

    var newDiameter = colorPicker_fixDiameter(self, Math.max(inputPoint[0], inputPoint[1]) + Math.max(self.resizeOffset[0], self.resizeOffset[1]));
    colorPicker_resizeContainer(self, newDiameter);

    self._source.trigger(self.settings.eventPrefix + 'resize');
  }

  function colorPicker_resizeContainer(self, width) {
    self._container.width(width).height(width + self._preview.outerHeight());

    if (self.settings.panel || self.settings.panelAlpha) {
      self._root.width(self.panelApi.getWidth() + self._container.width());

      self.panelApi.setHeight(self._container.height());
    } else {
      self._root.width(self._container.width());
    }

    self._picker.width(width).height(width);

    colorPicker_fixCorners(self, width);
    colorPicker_updatePreview(self);
  }

  function colorPicker_resize(self, width) {
    if (width !== self.Width) {
      self.ready = 0;
      self.Width = width;
      self.triangleRadius = width / 2 - 15 - self.settings.ringwidth;
      self.hueSelectorLineWidth = self.settings.ringwidth;
      self.hueSelectorCircleRadius = self.Width / 2 - self.hueSelectorLineWidth / 2 - 10;
      self.canvases.each(function () {
        this.width = width;
        this.height = width;
      }).add(self._container);
      self.tempCanvas.width = width;
      self.tempCanvas.height = width;
      colorPicker_resizeContainer(self, width);
      colorPicker_drawAll(self);
    }
  }

  function colorPicker_fixCorners(self, width) {
    if (self.settings.roundcorners) {
      width = width || self.Width;
      var borderRadius = '0px 0px 0px ' + width / 2 + 'px';

      if (!self.settings.resizable && !self.settings.panel && !self.settings.panelAlpha) {
        borderRadius = '0px 0px ' + width / 2 + 'px ' + width / 2 + 'px';
      }

      self._root.css({
        '-webkit-border-radius': borderRadius,
        'border-radius': borderRadius
      });
    }
  }

  function colorPicker_fixDiameter(self, width) {
    width = width | 0;

    if (self.settings.maxWidth < self.settings.minWidth) {
      self.settings.maxWidth = self.settings.minWidth;
    }

    if (width > self.settings.maxWidth) {
      width = self.settings.maxWidth;
    } else if (width < self.settings.minWidth) {
      width = self.settings.minWidth;
    }

    width = width + width % 2;
    return width;
  }

  function colorPicker_fixPosition(self) {
    var offset;

    try {
      offset = self._source.offset();
    } catch (e) {
      // called for setTimeout, but the object is destroyed
      return;
    }

    var targetOffset = self._target.offset();

    if (!self.haveTarget) {
      self._target.css({
        top: 0,
        left: 0
      }); // Following is the feature that keeps the picker in
      // the view by moving it around the input element


      var scrollTop = $(document).scrollTop();

      var outerHeight = self._root.height();

      var availableTop = offset.top - scrollTop;

      var availableBottom = scrollTop + $(window).height() - offset.top - self._source.outerHeight(); // do we need to flip the picker and if yes, will there be more space?


      if (availableBottom < outerHeight && availableTop > availableBottom) {
        self._root.css({
          top: offset.top - outerHeight
        });

        if (self._resizer) {
          self._resizer.hide();
        }

        self._root.css({
          '-webkit-border-radius': '',
          'border-radius': ''
        });
      } else {
        self._root.css({
          top: offset.top + self._source.outerHeight()
        });

        if (self._resizer) {
          self._resizer.show();
        }

        colorPicker_fixCorners(self);
      } // does the picker fit into the the viewport?


      var scrollLeft = $(document).scrollLeft();
      var availableLeft = offset.left - scrollLeft - 2;
      var outsideRight = offset.left + self._root.width() - (scrollLeft + $(window).width());

      if (outsideRight > 0 && availableLeft > 0) {
        var moveBy = 2;

        if (availableLeft < outsideRight) {
          moveBy += availableLeft;
        } else {
          moveBy += outsideRight;
        }

        self._root.css({
          left: offset.left - moveBy
        });
      } else {
        self._root.css({
          left: offset.left
        });
      }
    }

    if (self._source.is(':visible')) {
      self._icon.show().css('top', offset.top - targetOffset.top + (self._source.outerHeight() - self._icon.height()) / 2);

      if (self.settings.iconpos === 'left') {
        self._icon.css('left', offset.left - targetOffset.left - self._icon.outerWidth() - 2);
      } else {
        self._icon.css('left', offset.left - targetOffset.left + self._source.outerWidth() + 2);
      }
    } else {
      self._icon.hide();
    }
  }

  function colorPicker_sanitiseSettingsValue(index, value) {
    var retval = defaults[index];
    var intVal;
    var allModes = ['rgb', 'hsl', 'cmyk'];

    if (typeof value != 'undefined') {
      if (index === 'panelMode') {
        if ($.inArray(value, allModes)) {
          retval = value;
        }
      } else if (index === 'panelModes') {
        $.each(value, function (i, mode) {
          if (!$.inArray(mode, allModes)) {
            delete value[i];
          }
        });
        retval = value;
      } else if (index === 'panelChannelWidth') {
        intVal = parseInt(value) || 0;

        if (intVal >= 10 && intVal <= 40) {
          retval = intVal + intVal % 2;
        }
      } else if (index === 'panelChannelMargin') {
        intVal = parseInt(value) || 0;

        if (intVal >= 0 && intVal <= 50) {
          retval = intVal + intVal % 2;
        }
      } else if (index === 'panel' || index === 'panelAlpha') {
        retval = !!value;
      } else if (index === 'shadowColor' && typeof value === 'string' && value.length) {
        retval = new Color(value).getRgbaString();
      } else if (index === 'effect') {
        retval = value === 'slide' ? 'slide' : 'fade';
      } else if (index === 'iconpos') {
        retval = value === 'left' ? 'left' : 'right';
      } else if (index === 'target') {
        retval = null;

        if (typeof value === 'string' || _typeof(value) === 'object') {
          var target = $(value);

          if (target && _typeof(target[0]) === 'object') {
            retval = target;
          }
        }
      } else if (index === 'icon' && typeof value === 'string' && value.length) {
        retval = value;
      } else if (index === 'iconalt' && typeof value === 'string' && value.length) {
        retval = value;
      } else if (index === 'pickerClass' && typeof value === 'string' && value.length) {
        retval = value;
      } else if (index.match(/^autoshow|autosave|resizable|preview|roundcorners$/)) {
        retval = !!value;
      } else if (index.match(/^minWidth|maxWidth$/)) {
        intVal = parseInt(value, 10) || 0;
        retval = intVal > 100 ? intVal : 100;
      } else if (index.match(/^speed|width|shadow|ringwidth$/)) {
        intVal = parseInt(value, 10) || 0;
        retval = intVal > 0 ? intVal : 0;
      } else if (new RegExp('^' + EVENTS + '$').test(index) || /^save|load|str2color|color2str$/.test(index)) {
        if (typeof value === 'function') {
          retval = value;
        }
      } else if (index === 'eventPrefix' && typeof value === 'string' && /^\w*$/.test(value)) {
        retval = value;
      }
    }

    return retval;
  }

  function colorPicker_getWidth(self) {
    return self._root.width();
  }

  function colorPicker_getHeight(self) {
    return self._root.height();
  }

  function colorPicker_updatePreview(self) {
    var previewHeight = self._previewWidget.height();

    self._previewCanvas.height(previewHeight);

    self._previewColor.css('top', '-' + previewHeight + 'px').height(previewHeight);

    var ctx = self._previewCanvas[0].getContext('2d');

    self._previewCanvas[0].height = previewHeight;
    self._previewCanvas[0].width = 500;

    self._previewCanvas.css('width', '500px'); // Draw checkboard background


    var tempCanvas = document.createElement('canvas');
    tempCanvas.height = 10;
    tempCanvas.width = 10;
    var tempCtx = tempCanvas.getContext('2d');
    tempCtx['fillStyle'] = '#ccc';
    tempCtx['fillRect'](0, 0, 10, 10);
    tempCtx['fillStyle'] = '#888';
    tempCtx['fillRect'](0, 0, 5, 5);
    tempCtx['fillRect'](5, 5, 5, 5);
    var pattern = ctx.createPattern(tempCanvas, 'repeat');
    ctx['fillStyle'] = pattern;
    ctx['fillRect'](0, 0, self.Width, previewHeight);
  }

  function each(obj, fn) {
    return obj.each(fn);
  }

  ;
  /** The color picker object */

  var ColorPicker = function ColorPicker($this, settings) {
    var self = this;
    /**
    * Properties
    */

    self.ready = 0;
    self.settings = settings;
    self.draggingHue = 0;
    self.draggingHueRenderer = Throttle(colorPicker_reDrawHue);
    self.draggingSatLum = 0;
    self.draggingSatLumRenderer = Throttle(colorPicker_handleSatLumDrag);
    self.resizing = 0;
    self.resizingRenderer = Throttle(colorPicker_handleResizeDrag);
    self.valueRenderer = Throttle(colorPicker_update, 100);
    self.setColorRenderer = Throttle(function (self, value) {
      self.Color.setColor(value);
      colorPicker_drawSaturationLimunositySelector(self);
      colorPicker_drawIndicators(self);
      self.valueRenderer(self);
    });

    if (self.settings.ringwidth > self.settings.minWidth / 4) {
      self.settings.ringwidth = Math.floor(self.settings.minWidth / 4);
    }

    self.hiding = 0;
    self.showing = 0;
    self._source = $this;
    colorPicker_load(self); // sets self.Color

    self.Width = colorPicker_fixDiameter(self, self.settings.width);
    self.hueSelectorLineWidth = self.settings.ringwidth;
    self.hueSelectorCircleRadius = self.Width / 2 - self.hueSelectorLineWidth / 2 - 10;
    self.triangleRadius = self.Width / 2 - 15 - self.settings.ringwidth;
    var canvasString = '<canvas width="' + self.Width + '" height="' + self.Width + '"></canvas>';
    var staticClass = '';

    if (self.settings.target && self.settings.target.length) {
      self.haveTarget = 1;
      self._target = self.settings.target;
      staticClass = 'ui-cs-static';
    } else {
      self.haveTarget = 0;
      self._target = $('<div/>').prependTo('body').css({
        width: 0,
        height: 0,
        position: 'absolute',
        overflow: 'visible'
      });
    }

    self._picker = $('<div/>').addClass('ui-cs-widget').css({
      position: 'relative'
    }).width(self.Width).height(self.Width).html(canvasString + canvasString + canvasString + canvasString);
    self._container = $('<div/>').append(self._picker).width(self.Width).addClass('ui-cs-container');
    self._supercontainer = $('<div/>').addClass('ui-cs-supercontainer').append(self._container);
    self._root = $('<div/>').addClass('ui-cs-chromoselector').addClass(self.settings.pickerClass).addClass(staticClass).append(self._supercontainer);

    if (self.settings.panel || self.settings.panelAlpha) {
      self._panel = $('<div/>').addClass('ui-cs-panel');

      self._supercontainer.append(self._panel);

      self.panelApi = new Panel(self._panel, self.settings.panelMode, self.settings.panelModes, self.settings.panelAlpha, !self.settings.panel, 100, self.settings.panelChannelWidth, self.settings.panelChannelMargin, true, self.settings.shadow, self.settings.shadowColor);
      self.panelApi.setColor(self.Color);

      self._panel.bind(NAMESPACE + '.' + NAMESPACE, function () {
        self.setColorRenderer(self, self.panelApi.getColor().getHsla());
      });

      self._source.bind(self.settings.eventPrefix + 'update.' + NAMESPACE, function () {
        self.panelApi.setColor(self.Color);
      });

      self._panel.find('select').bind('blur.' + NAMESPACE, function () {
        if (!self.haveTarget) {
          colorPicker_hide(self);
        }
      }).bind('change.' + NAMESPACE, function () {
        self._root.width(self.panelApi.getWidth() + self._container.width());
      });
    }

    if (self.settings.icon) {
      self._icon = $('<a/>', {
        href: '#',
        tabindex: '999'
      }).addClass('ui-cs-icon').css('position', 'absolute').append($('<img/>', {
        alt: self.settings.iconalt,
        src: self.settings.icon
      }).load(function () {
        $(this).parent().height($(this).height());
        $(this).parent().width($(this).width());
        colorPicker_fixPosition(self);
      }));

      self._target.append(self._icon);
    } else {
      self._icon = $([]);
    }

    if (self.settings.resizable) {
      self._resizer = $('<canvas />').height(20).width(20).attr('height', 20).attr('width', 20).addClass('ui-cs-resizer').css({
        position: 'absolute',
        bottom: '0px',
        right: '0px'
      });
      drawResizer(self, self._resizer[0]);

      self._supercontainer.append(self._resizer);
    }

    self._supercontainer.append($('<div/>').css('clear', 'both'));

    self._previewWidget = $('<div/>').addClass('ui-cs-preview-widget').css('overflow', 'hidden');
    var shadowCssColor = new Color(self.settings.shadowColor);
    shadowCssColor.setAlpha(shadowCssColor.getAlpha() - 0.1);
    var shadowCss = '0 0 ' + Math.max(0, self.settings.shadow - 2) + 'px 0 ' + shadowCssColor.getRgbaString();
    self._preview = $('<div/>').addClass('ui-cs-preview-container').append(self._previewWidget.append($('<canvas/>').css({
      display: 'block'
    })).css('box-shadow', shadowCss).css('-webkit-box-shadow', shadowCss));

    if (self.settings.preview) {
      self._container.prepend(self._preview);
    }

    self._previewColor = $('<div/>').addClass('ui-cs-preview-color').css('width', '100%').css('background-color', self.Color.getRgbaString()).css('position', 'relative');

    self._previewWidget.append(self._previewColor);

    self._previewCanvas = self._previewWidget.find('canvas');
    colorPicker_updatePreview(self);
    colorPicker_fixCorners(self);

    self._picker.height(self.Width).add(self._container).width(self.Width);

    if (self.settings.panel || self.settings.panelAlpha) {
      self._root.width(self.panelApi.getWidth() + self._container.width());
    } else {
      self._root.width(self._container.width());
    }

    self._target.append(self._root.hide());

    self.canvases = self._picker.find('canvas').css({
      position: 'absolute',
      width: '100%',
      height: '100%'
    });
    self.tempCanvas = $(canvasString)[0];
    self.Effect = 'fade';

    if (self.settings.effect === 'slide') {
      self.Effect = 'slide';
    }

    if (self.settings.autoshow) {
      if (self.settings.lazy) {
        self._source.bind('mouseover.' + NAMESPACE, function () {
          if (!self.ready) {
            colorPicker_drawAll(self);
          }

          self._source.unbind('mouseover.' + NAMESPACE);
        });
      } else {
        colorPicker_drawAll(self);
      }

      var $initElement = self._source;

      if (self._icon.length) {
        $initElement = self._icon;
      }

      $initElement.bind('focus.' + NAMESPACE + ' click.' + NAMESPACE, function (e) {
        e.preventDefault();

        if (!self.ready) {
          colorPicker_drawAll(self);
        }

        colorPicker_show(self);
      }).bind('blur.' + NAMESPACE, function () {
        colorPicker_hide(self);
      });

      self._source.bind('keydown.' + NAMESPACE, function (e) {
        if (e.keyCode === 27) {
          colorPicker_hide(self);
        }
      });
    }
    /**
    * Register events
    */


    self._source.bind('keyup.' + NAMESPACE, function () {
      colorPicker_load(self);
      colorPicker_drawSaturationLimunositySelector(self);
      colorPicker_drawIndicators(self);

      self._source.trigger(self.settings.eventPrefix + 'update');
    });

    if (self.settings.resizable) {
      self._resizer.bind('mousedown.' + NAMESPACE + ' touchstart.' + NAMESPACE, function (e) {
        e.preventDefault();
        var inputPoint = Util.getEventPosition(self, e, self._picker);

        self._source.trigger(self.settings.eventPrefix + 'resizeStart');

        self.resizing = 1;
        self.resizeOffset = [self.Width - inputPoint[0], self.Width - inputPoint[1]];
      });
    }

    self._container.bind('mousedown.' + NAMESPACE + ' touchstart.' + NAMESPACE, function (e) {
      e.preventDefault();
      var inputPoint = Util.getEventPosition(self, e, self._picker);

      if (pointInCircle(inputPoint, self.Width / 2, self.hueSelectorCircleRadius + self.hueSelectorLineWidth) && !pointInCircle(inputPoint, self.Width / 2, self.hueSelectorCircleRadius - self.hueSelectorLineWidth)) {
        self.draggingHue = 1;
        self.draggingHueRenderer(self, e);
      } else {
        var degrees = (1 - self.Color.getHsl().h) * Math.PI * 2;
        var points = colorPicker_getPoints(self, degrees);

        if (pointInTriangle(inputPoint, points[0], points[1], points[2])) {
          self.draggingSatLum = 1;
          self.draggingSatLumRenderer(self, e);
        }
      }
    }).bind('mousemove.' + NAMESPACE + ' touchmove.' + NAMESPACE, function (e) {
      var inputPoint = Util.getEventPosition(self, e, self._picker);

      if (pointInCircle(inputPoint, self.Width / 2, self.hueSelectorCircleRadius + self.hueSelectorLineWidth / 2) && !pointInCircle(inputPoint, self.Width / 2, self.hueSelectorCircleRadius - self.hueSelectorLineWidth / 2)) {
        self._picker.css('cursor', 'crosshair');
      } else {
        var degrees = (1 - self.Color.getHsl().h) * Math.PI * 2;
        var points = colorPicker_getPoints(self, degrees);

        if (pointInTriangle(inputPoint, points[0], points[1], points[2])) {
          self._picker.css('cursor', 'crosshair');
        } else {
          self._picker.css('cursor', '');
        }
      }
    });

    $([window, document]).bind('mousemove touchmove', function (e) {
      if (self.draggingHue) {
        e.preventDefault();
        self.draggingHueRenderer(self, e);
      } else if (self.draggingSatLum) {
        e.preventDefault();
        self.draggingSatLumRenderer(self, e);
      } else if (self.resizing) {
        e.preventDefault();
        self.resizingRenderer(self, e);
      }
    }).bind('mouseup touchend', function (e) {
      if (self.draggingHue) {
        e.preventDefault();
        self.draggingHue = 0;
        colorPicker_reDrawHue(self, e);
      } else if (self.draggingSatLum) {
        e.preventDefault();
        self.draggingSatLum = 0;
        colorPicker_handleSatLumDrag(self, e);
      } else if (self.resizing) {
        e.preventDefault();
        self.resizing = 0;
        colorPicker_resize(self, self._picker.width());
        colorPicker_fixPosition(self);

        self._source.trigger(self.settings.eventPrefix + 'resizeStop');
      }
    }).bind('resize scroll', function (event) {
      if (event.target === window || event.target === document) {
        colorPicker_fixPosition(self);
      }
    });
    setTimeout(function () {
      colorPicker_fixPosition(self);
    }, 4);
  };

  var methods = {
    init: function init(options) {
      var settings = {};
      options = options ? options : {};
      $.each(defaults, function (index) {
        settings[index] = colorPicker_sanitiseSettingsValue(index, options[index]);
      });
      return each(this, function () {
        var $this = $(this);

        if (!$this.data(NAMESPACE)) {
          // Instantiate new ColorPicker
          $this.data(NAMESPACE, new ColorPicker($this, settings)); // Register callbacks for all events

          var events = EVENTS.split('|');
          $.each(events, function (i) {
            var name = events[i];
            var data = settings[name];

            if (typeof data === 'function') {
              $this.bind(settings.eventPrefix + name + '.' + NAMESPACE, data);
            }
          });
          $this.trigger(settings.eventPrefix + 'create');
        }
      });
    },
    show: function show(speed) {
      return each(this, function () {
        colorPicker_show($(this).data(NAMESPACE), speed);
      });
    },
    hide: function hide(speed) {
      return each(this, function () {
        colorPicker_hide($(this).data(NAMESPACE), speed);
      });
    },
    toggle: function toggle(speed) {
      return each(this, function () {
        colorPicker_toggle($(this).data(NAMESPACE), speed);
      });
    },
    save: function save() {
      return each(this, function () {
        colorPicker_save($(this).data(NAMESPACE));
      });
    },
    load: function load() {
      return each(this, function () {
        colorPicker_load($(this).data(NAMESPACE), 1);
      });
    },
    setColor: function setColor(value) {
      return each(this, function () {
        var self = $(this).data(NAMESPACE);
        self.setColorRenderer(self, value);
      });
    },
    getColor: function getColor() {
      return this.data(NAMESPACE).Color;
    },
    getWidth: function getWidth() {
      return colorPicker_getWidth($(this).data(NAMESPACE));
    },
    getHeight: function getHeight() {
      return colorPicker_getHeight($(this).data(NAMESPACE));
    },
    resize: function resize(width) {
      return each(this, function () {
        var self = $(this).data(NAMESPACE);

        self._source.trigger(self.settings.eventPrefix + 'resizeStart');

        colorPicker_resize(self, width);
        colorPicker_fixPosition(self);

        self._source.trigger(self.settings.eventPrefix + 'resize').trigger(self.settings.eventPrefix + 'resizeStop');
      });
    },
    reflow: function reflow() {
      return each(this, function () {
        colorPicker_fixPosition($(this).data(NAMESPACE));
      });
    },
    api: function api() {
      var retval = {},
          $obj = this;

      retval.show = function (speed) {
        methods.show.call($obj, speed);
        return this;
      };

      retval.hide = function (speed) {
        methods.hide.call($obj, speed);
        return this;
      };

      retval.toggle = function (speed) {
        methods.toggle.call($obj, speed);
        return this;
      };

      retval.save = function () {
        methods.save.call($obj);
        return this;
      };

      retval.load = function () {
        methods.load.call($obj);
        return this;
      };

      retval.getColor = function () {
        return methods.getColor.call($obj);
      };

      retval.getWidth = function () {
        return methods.getWidth.call($obj);
      };

      retval.getHeight = function () {
        return methods.getHeight.call($obj);
      };

      retval.setColor = function (color) {
        methods.setColor.call($obj, color);
        return this;
      };

      retval.destroy = function () {
        methods.destroy.call($obj);
      };

      retval.resize = function (size) {
        methods.resize.call($obj, size);
        return this;
      };

      retval.reflow = function () {
        methods.reflow.call($obj);
        return this;
      };

      return retval;
    },
    destroy: function destroy() {
      return each(this, function () {
        var self = $(this).data(NAMESPACE);
        var prefix = self.settings.eventPrefix;

        if (self.haveTarget) {
          if (self._container.siblings().length) {
            self._container.remove();
          } else {
            self._target.remove();
          }
        } else {
          self._target.remove();
        }

        self._source.add(self._icon).add(self._resizer).add(self._container).unbind('.' + NAMESPACE);

        for (var i in self) {
          delete self[i];
        }

        $(this).removeData(NAMESPACE).trigger(prefix + 'destroy').unbind('.' + NAMESPACE);
      });
    }
  };
  /** Extend jQuery */

  $.fn[NAMESPACE] = function (method) {
    var canvasSupport = 1;

    try {
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      context.createImageData(5, 5);
    } catch (e) {
      canvasSupport = 0;
    }

    if (!canvasSupport) {
      if (method === "getColor") {
        return new Color();
      } else if (method === "getWidth" || method === "getHeight") {
        return 0;
      } else {
        return this;
      }
    } else if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (_typeof(method) === 'object' || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.' + NAMESPACE);
    }
  };
  /** Access default settings */


  $.fn[NAMESPACE].defaults = function (index, value) {
    if (typeof value === 'undefined') {
      return defaults[index];
    } else {
      defaults[index] = colorPicker_sanitiseSettingsValue(index, value);
    }

    return this;
  };

  $.fn[NAMESPACE].Color = Color;
})(jQuery, window, Math, {
  autoshow: true,
  // bool
  autosave: true,
  // bool
  pickerClass: '',
  // string
  speed: 400,
  // pos int | 'fast' | 'slow' | 'medium'
  minWidth: 120,
  // pos int
  maxWidth: 400,
  // pos int
  width: 180,
  // pos int
  ringwidth: 18,
  // pos int
  resizable: true,
  // bool
  shadow: 6,
  // pos int
  shadowColor: 'rgba(0,0,0,0.6)',
  // string
  preview: true,
  // bool
  panel: false,
  // bool
  panelAlpha: false,
  // bool
  panelChannelWidth: 18,
  // pos int
  panelChannelMargin: 12,
  // pos int
  panelMode: 'rgb',
  panelModes: ['rgb', 'hsl', 'cmyk'],
  // array
  roundcorners: true,
  // bool
  effect: 'fade',
  // 'fade' | 'slide'
  icon: null,
  // string
  iconalt: 'Open Color Picker',
  // string
  iconpos: 'right',
  // string 'left' | 'right'
  lazy: true,
  // bool
  target: null,
  // selector | jQuery object | DOM object
  eventPrefix: '',
  // string that matches /^\w*$/
  create: null,
  // function
  ready: null,
  // function
  destroy: null,
  // function
  update: null,
  // function
  beforeShow: null,
  // function
  show: null,
  // function
  beforeHide: null,
  // function
  hide: null,
  // function
  resize: null,
  // function
  resizeStart: null,
  // function
  resizeStop: null,
  // function
  save: null,
  // function
  load: null,
  // function
  str2color: null,
  // function
  color2str: null // function

});

/***/ }),

/***/ "./public/js/chromoselector/src/color.js":
/*!***********************************************!*\
  !*** ./public/js/chromoselector/src/color.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var Color = function (Math) {
  // Shorthand
  var round = Math.round; // One level deep copy

  function clone(obj, callback) {
    var i,
        cloned = {};

    for (i in obj) {
      if (obj.hasOwnProperty(i)) {
        if (callback) {
          cloned[i] = callback(obj[i]);
        } else {
          cloned[i] = obj[i];
        }
      }
    }

    return cloned;
  } // Used to expand shorthand hex strings


  function replaceCallback(match) {
    return match + match;
  } // Channel validity checker


  function haveFields(value, fields) {
    var i,
        temp,
        arr = fields.split('');

    for (i in arr) {
      if (arr.hasOwnProperty(i)) {
        temp = parseFloat(value[fields[i]]);

        if (isNaN(temp) || temp < 0 || temp > 1) {
          return 0;
        }
      }
    }

    return 1;
  } // converters


  function rgb2hexa(input) {
    var value,
        _byte,
        retval = '',
        i = 0;

    for (; i < 4; i++) {
      _byte = round(input[['r', 'g', 'b', 'a'][i]] * 255);
      value = _byte.toString(16);

      if (_byte < 16) {
        value = "0" + value;
      }

      retval += value;
    }

    return '#' + retval;
  }

  function hexa2rgb(value) {
    var i = 0,
        retval = {};

    for (; i < 4; i++) {
      retval[i] = parseInt('0x' + value.substring(i * 2 + 1, i * 2 + 3), 16) / 255;
    }

    return {
      r: retval[0],
      g: retval[1],
      b: retval[2],
      a: retval[3]
    };
  }

  function rgb2hsl(value) {
    var r = value.r,
        g = value.g,
        b = value.b,
        max = Math.max(r, g, b),
        min = Math.min(r, g, b),
        h,
        s,
        l = (max + min) / 2;

    if (max === min) {
      h = s = 0; // achromatic
    } else {
      var d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

      switch (max) {
        case r:
          h = (g - b) / d + (g < b ? 6 : 0);
          break;

        case g:
          h = (b - r) / d + 2;
          break;

        case b:
          h = (r - g) / d + 4;
          break;
      }

      h /= 6;
    }

    return {
      h: h,
      s: s,
      l: l,
      a: value.a
    };
  }

  function hsl2rgb(value) {
    var r, g, b;

    if (value.s === 0) {
      r = g = b = value.l; // achromatic
    } else {
      var hue2rgb = function hue2rgb(p, q, t) {
        if (t < 0) {
          t += 1;
        } else if (t > 1) {
          t -= 1;
        }

        if (t < 1 / 6) {
          return p + (q - p) * 6 * t;
        }

        if (t < 1 / 2) {
          return q;
        }

        if (t < 2 / 3) {
          return p + (q - p) * (2 / 3 - t) * 6;
        }

        return p;
      };

      var q;

      if (value.l < 0.5) {
        q = value.l * (1 + value.s);
      } else {
        q = value.l + value.s - value.l * value.s;
      }

      var p = 2 * value.l - q;
      r = hue2rgb(p, q, value.h + 1 / 3);
      g = hue2rgb(p, q, value.h);
      b = hue2rgb(p, q, value.h - 1 / 3);
    }

    return {
      r: r,
      g: g,
      b: b,
      a: value.a
    };
  }

  function rgb2cmyk(value) {
    // achromatic
    if (value.r === value.g && value.g === value.b) {
      return {
        c: 0,
        m: 0,
        y: 0,
        k: 1 - value.r
      };
    }

    var k = Math.min(1 - value.r, 1 - value.g, 1 - value.b);
    return {
      c: (1 - value.r - k) / (1 - k),
      m: (1 - value.g - k) / (1 - k),
      y: (1 - value.b - k) / (1 - k),
      k: k
    };
  }

  function cmyk2rgb(value) {
    return {
      r: 1 - Math.min(1, value.c * (1 - value.k) + value.k),
      g: 1 - Math.min(1, value.m * (1 - value.k) + value.k),
      b: 1 - Math.min(1, value.y * (1 - value.k) + value.k),
      a: 1
    };
  } // Color parser


  function parseChannelValues(channels) {
    for (var i = 0; i < channels.length; i++) {
      if (channels[i].indexOf('%') !== -1) {
        channels[i] = channels[i].substr(0, channels[i].length - 1) / 100;
      } else {
        channels[i] = channels[i] / 255;
      }

      if (channels[i] > 1) {
        channels[i] = 1;
      }
    }

    return channels;
  }

  function parseHexString(value) {
    var retval;

    if (/^#([0-9a-f]{3}){1,2}$/i.test(value)) {
      if (value.length === 4) {
        value = value.replace(/[0-9a-f]/gi, replaceCallback);
      }

      retval = {
        r: hexa2rgb(value)
      };
      retval.r.a = 1;
    } else if (/^#([0-9a-f]{4}){1,2}$/i.test(value)) {
      if (value.length === 5) {
        value = value.replace(/[0-9a-f]/gi, replaceCallback);
      }

      retval = {
        r: hexa2rgb(value)
      };
    }

    return retval;
  }

  function parseRgbaString(value) {
    var parts, alpha;
    parts = value.match(/^rgba\((\d+%?),(\d+%?),(\d+%?),(\.\d+|\d+\.?\d*)\)$/);

    if (parts && parts.length === 5) {
      parts.shift();
      alpha = parts.pop() / 1; // Divide by 1 to convert string to number

      if (alpha > 1) {
        alpha = 1;
      }

      parts = parseChannelValues(parts);
      return {
        r: {
          r: parts[0],
          g: parts[1],
          b: parts[2],
          a: alpha
        }
      };
    }
  }

  function parseRgbString(value) {
    var parts;
    parts = value.match(/^rgb\((\d+%?),(\d+%?),(\d+%?)\)$/);

    if (parts && parts.length === 4) {
      parts.shift();
      parts = parseChannelValues(parts);
      return {
        r: {
          r: parts[0],
          g: parts[1],
          b: parts[2],
          a: 1
        }
      };
    }
  }

  function parseHslaString(value) {
    var parts, alpha, hue;
    parts = value.match(/^hsla\((-?\d+),(\d+%),(\d+%),(\.\d+|\d+\.?\d*)\)$/);

    if (parts && parts.length === 5) {
      parts.shift();
      hue = parts.shift() / 360;
      hue = hue - Math.floor(hue);
      alpha = parts.pop() / 1; // Divide by 1 to convert string to number

      if (alpha > 1) {
        alpha = 1;
      }

      parts = parseChannelValues(parts);
      return {
        h: {
          h: hue,
          s: parts[0],
          l: parts[1],
          a: alpha
        }
      };
    }
  }

  function parseHslString(value) {
    var parts, hue;
    parts = value.match(/^hsl\((-?\d+),(\d+%),(\d+%)\)$/);

    if (parts && parts.length === 4) {
      parts.shift();
      hue = parts.shift() / 360;
      hue = hue - Math.floor(hue);
      parts = parseChannelValues(parts);
      return {
        h: {
          h: hue,
          s: parts[0],
          l: parts[1],
          a: 1
        }
      };
    }
  }

  function parseCmykString(value) {
    var parts, i;
    parts = value.match(/^device-cmyk\((\.\d+|\d+\.?\d*),(\.\d+|\d+\.?\d*),(\.\d+|\d+\.?\d*),(\.\d+|\d+\.?\d*)\)$/);

    if (parts && parts.length === 5) {
      parts.shift();

      for (i = 0; i < parts.length; i++) {
        parts[i] = parts[i] / 1; // Divide by 1 to convert string to number

        if (parts[i] > 1) {
          parts[i] = 1;
        }
      }

      return {
        r: cmyk2rgb({
          c: parts[0],
          m: parts[1],
          y: parts[2],
          k: parts[3]
        })
      };
    }
  }

  function parseString(value) {
    var retval;
    value = value.replace(/\s+/g, '');

    if (/^#/.test(value)) {
      // hex
      retval = parseHexString(value);
    } else if (/^rgba/.test(value)) {
      retval = parseRgbaString(value);
    } else if (/^rgb/.test(value)) {
      retval = parseRgbString(value);
    } else if (/^hsla/.test(value)) {
      retval = parseHslaString(value);
    } else if (/^hsl/.test(value)) {
      retval = parseHslString(value);
    } else if (/^device-cmyk/.test(value)) {
      retval = parseCmykString(value);
    }

    return retval;
  }

  function parseObject(value) {
    var alpha, retval;
    value = clone(value, parseFloat);

    if (haveFields(value, 'sl') && !isNaN(value.h)) {
      value.h = value.h - Math.floor(value.h);
      retval = {
        h: value
      };
      alpha = 1;

      if (haveFields(value, 'a')) {
        alpha = value.a;
      }

      retval.h.a = alpha;
    } else if (haveFields(value, 'rgb')) {
      retval = {
        r: value
      };
      alpha = 1;

      if (haveFields(value, 'a')) {
        alpha = value.a;
      }

      retval.r.a = alpha;
    } else if (haveFields(value, 'cmyk')) {
      retval = {
        r: cmyk2rgb(value)
      };
    }

    return retval;
  }

  function parse(value) {
    var retval;

    if (typeof value === 'string') {
      retval = parseString(value);
    } else if (value instanceof Color) {
      retval = {
        r: value.getRgba(),
        h: value.getHsla()
      };
    } else if (_typeof(value) === 'object') {
      retval = parseObject(value);
    }

    return retval;
  } // Prepare values for display in strings


  function round1decimal(i) {
    return round(i * 100) / 100;
  }

  function getRgbaStringValues(color) {
    return [round(color.r * 255), round(color.g * 255), round(color.b * 255), round1decimal(color.a)];
  }

  function getHslaStringValues(color) {
    return [round(color.h * 360), round(color.s * 100) + '%', round(color.l * 100) + '%', round1decimal(color.a)];
  }

  function getCmykStringValues(color) {
    return [round1decimal(color.c), round1decimal(color.m), round1decimal(color.y), round1decimal(color.k)];
  }
  /**
   * COLOR MANAGEMENT
   */
  // Constructor


  function Color(value) {
    var self = this; // default to black

    var currentColor = {
      r: 0,
      g: 0,
      b: 0,
      a: 1
    };
    var currentHslColor = {
      h: 0,
      s: 0,
      l: 0,
      a: 1
    }; // Object getters

    self.getRgba = function () {
      return clone(currentColor);
    };

    self.getRgb = function () {
      var retval = clone(currentColor);
      delete retval.a;
      return retval;
    };

    self.getHsla = function () {
      return clone(currentHslColor);
    };

    self.getHsl = function () {
      var retval = clone(currentHslColor);
      delete retval.a;
      return retval;
    };

    self.getCmyk = function () {
      return rgb2cmyk(currentColor);
    }; // String getters


    self.getRgbaString = function () {
      return 'rgba(' + getRgbaStringValues(currentColor).join() + ')';
    };

    self.getRgbString = function () {
      var values = getRgbaStringValues(currentColor);
      values.pop();
      return 'rgb(' + values.join() + ')';
    };

    self.getHexaString = function () {
      return rgb2hexa(currentColor);
    };

    self.getHexString = function () {
      return rgb2hexa(currentColor).substring(0, 7);
    };

    self.getHslaString = function () {
      return 'hsla(' + getHslaStringValues(currentHslColor).join() + ')';
    };

    self.getHslString = function () {
      var values = getHslaStringValues(currentHslColor);
      values.pop();
      return 'hsl(' + values.join() + ')';
    };

    self.getCmykString = function () {
      // http://www.w3.org/TR/css3-gcpm/#cmyk-colors
      var values = getCmykStringValues(rgb2cmyk(currentColor));
      return 'device-cmyk(' + values.join() + ')';
    }; // Contrasting color getter


    self.getTextColor = function () {
      // See BT 709 color spec
      var luma = currentColor.r * 0.2126 + currentColor.g * 0.7152 + currentColor.b * 0.0722;
      return new Color(luma < 0.35 ? '#fff' : '#000');
    }; // Color setter


    self.setColor = function (color) {
      var retval = parse(color);

      if (retval) {
        if (retval.r && retval.h) {
          currentColor = retval.r;
          currentHslColor = retval.h;
        } else if (retval.r) {
          currentColor = retval.r;
          currentHslColor = rgb2hsl(retval.r);
        } else {
          currentColor = hsl2rgb(retval.h);
          currentHslColor = retval.h;
        }
      }

      return self;
    };

    self.setAlpha = function (value) {
      value = parseFloat(value);

      if (!isNaN(value) && value >= 0 && value <= 1) {
        currentColor.a = value;
        currentHslColor.a = value;
      }

      return self;
    };

    self.getAlpha = function () {
      return currentColor.a;
    }; // Set to input color


    self.setColor(value);
  }

  return Color;
}(Math);

module.exports = Color;

/***/ }),

/***/ "./public/js/chromoselector/src/panel.js":
/*!***********************************************!*\
  !*** ./public/js/chromoselector/src/panel.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Panel = function () {
  var NAMESPACE = 'chromoselector';

  var Color = __webpack_require__(/*! ./color.js */ "./public/js/chromoselector/src/color.js");

  var Throttle = __webpack_require__(/*! ./throttle.js */ "./public/js/chromoselector/src/throttle.js");

  var Util = __webpack_require__(/*! ./util.js */ "./public/js/chromoselector/src/util.js"); // return constructor


  return function ($target, inputMode, inputModes, alphaSupport, onlyAlpha, panelHeight, channelWidth, channelMargin, panelLabels, shadowBlur, shadowColor) {
    var self = this; // Declare functions

    var getPanelWidth = function getPanelWidth() {
      var offset = canvasPadding;

      if (alphaSupport) {
        offset += channelWidth + channelMargin;
      }

      if (onlyAlpha) {
        return canvasPadding + channelWidth;
      } else if (mode === 'cmyk') {
        return offset + channelWidth * 4 + channelMargin * 3;
      } else {
        return offset + channelWidth * 3 + channelMargin * 2;
      }
    };

    var toggleColor = function toggleColor(color, channel, value) {
      var retval = $.extend({}, color);
      retval[channel] = value;
      return new Color(retval);
    };

    var createGradient = function createGradient() {
      return ctx.createLinearGradient(0, canvasHeight - channelWidth / 2 - 10, 0, channelWidth / 2 + 10);
    };

    var setSimpleGradient = function setSimpleGradient(color1, color2) {
      lingrad = createGradient();
      lingrad['addColorStop'](0, color1.getHexString());
      lingrad['addColorStop'](1, color2.getHexString());
      ctx['strokeStyle'] = lingrad;
    };

    var setHueGradient = function setHueGradient() {
      lingrad = createGradient();
      lingrad['addColorStop'](0 / 6, '#f00');
      lingrad['addColorStop'](1 / 6, '#ff0');
      lingrad['addColorStop'](2 / 6, '#0f0');
      lingrad['addColorStop'](3 / 6, '#0ff');
      lingrad['addColorStop'](4 / 6, '#00f');
      lingrad['addColorStop'](5 / 6, '#f0f');
      lingrad['addColorStop'](6 / 6, '#f00');
      ctx['strokeStyle'] = lingrad;
    };

    var setLightnessGradient = function setLightnessGradient(color) {
      lingrad = createGradient();
      lingrad['addColorStop'](0, '#000');
      lingrad['addColorStop'](0.5, color.getHexString());
      lingrad['addColorStop'](1, '#fff');
      ctx['strokeStyle'] = lingrad;
    };

    var setKeyGradient = function setKeyGradient(color) {
      lingrad = createGradient();
      lingrad['addColorStop'](0, color.getHexString());
      lingrad['addColorStop'](1, '#000');
      ctx['strokeStyle'] = lingrad;
    };

    var drawPanel = function drawPanel() {
      ctx.clearRect(0, 0, getPanelWidth(), canvasHeight);
      drawShadows();
      var i, color1, color2, lighnessHsl, keyCmyk, cmy;
      var offset = 10;
      var channel = 0;

      var drawChannel = function drawChannel() {
        ctx.beginPath();
        ctx.moveTo(offset + channelWidth / 2, channelWidth / 2 + 10);
        ctx.lineTo(offset + channelWidth / 2, canvasHeight - channelWidth / 2 - 10);
        ctx.lineWidth = channelWidth;
        ctx.lineCap = 'round';
        ctx.stroke();
      };

      if (alphaSupport) {
        // Draw checkboard background
        var tempCanvas = document.createElement('canvas');
        tempCanvas.height = 10;
        tempCanvas.width = 10;
        var tempCtx = tempCanvas.getContext('2d');
        tempCtx['fillStyle'] = '#ccc';
        tempCtx['fillRect'](0, 0, 10, 10);
        tempCtx['fillStyle'] = '#888';
        tempCtx['fillRect'](0, 0, 5, 5);
        tempCtx['fillRect'](5, 5, 5, 5);
        var pattern = ctx.createPattern(tempCanvas, 'repeat');
        ctx['strokeStyle'] = pattern;
        drawChannel();
        lingrad = createGradient();
        lingrad['addColorStop'](0, new Color(currentColor).setAlpha(0).getRgbaString());
        lingrad['addColorStop'](1, currentColor.getHexString());
        ctx['strokeStyle'] = lingrad;
        drawChannel();
        offset += channelWidth + channelMargin;
        channel = 1;
      }

      if (onlyAlpha) {
        drawIndicators();
      } else if (mode === 'rgb') {
        $.each(indexes, function (i, index) {
          color1 = toggleColor(currentColor.getRgb(), index, 0);
          color2 = toggleColor(currentColor.getRgb(), index, 1);
          setSimpleGradient(color1, color2);
          drawChannel();
          offset += channelWidth + channelMargin;
          channel++;
        });
        drawIndicators(currentColor.getRgb());
      } else if (mode === 'hsl') {
        setHueGradient();
        drawChannel();
        channel++;
        offset += channelWidth + channelMargin;
        color1 = toggleColor(currentColor.getHsl(), 's', 0);
        color2 = toggleColor(currentColor.getHsl(), 's', 1);
        setSimpleGradient(color1, color2);
        drawChannel();
        channel++;
        offset += channelWidth + channelMargin;
        lighnessHsl = $.extend({}, currentColor.getHsl());
        lighnessHsl.l = 0.5;
        setLightnessGradient(new Color(lighnessHsl));
        drawChannel();
        drawIndicators(currentColor.getHsl());
      } else if (mode === 'cmyk') {
        $.each('cmy'.split(''), function (i, index) {
          color1 = toggleColor(currentColor.getCmyk(), index, 0);
          color2 = toggleColor(currentColor.getCmyk(), index, 1);
          setSimpleGradient(color1, color2);
          drawChannel();
          offset += channelWidth + channelMargin;
          channel++;
        });
        keyCmyk = $.extend({}, currentColor.getCmyk());
        keyCmyk.k = 0;
        keyCmyk = new Color(keyCmyk);
        setKeyGradient(keyCmyk);
        drawChannel();
        drawIndicators(currentColor.getCmyk());
      }
    };

    var drawIndicators = function drawIndicators(color) {
      var offset = 10,
          channel,
          x,
          y,
          verticalSpace;

      var indicator = function indicator(color, lineWidth, diameter) {
        ctx['strokeStyle'] = color;
        ctx.lineWidth = lineWidth;
        ctx.beginPath();
        ctx.arc(x, y, diameter, 0, Math.PI * 2, true);
        ctx.closePath();
        ctx.stroke();
      };

      if (alphaSupport) {
        x = offset + channelWidth / 2;
        verticalSpace = canvasHeight - channelWidth - 20;
        y = verticalSpace - verticalSpace * currentColor.getAlpha() + channelWidth / 2 + 10;
        offset += channelWidth + channelMargin;
        indicator("#fff", 1.5, 6);
        indicator("#000", 2, 4.5);
      }

      if (!onlyAlpha) {
        $.each(color, function (channel, value) {
          x = offset + channelWidth / 2;
          verticalSpace = canvasHeight - channelWidth - 20;
          y = verticalSpace - verticalSpace * value + channelWidth / 2 + 10;
          indicator("#fff", 1.5, 6);
          indicator("#000", 2, 4.5);
          offset += channelWidth + channelMargin;
        });
      }
    };

    var drawShadow = function drawShadow(x) {
      ctx.shadowColor = shadowColor;
      ctx.shadowBlur = shadowBlur;
      ctx.beginPath();
      ctx.moveTo(x, channelWidth / 2 + 10);
      ctx.lineTo(x, canvasHeight - channelWidth / 2 - 10);
      ctx.lineWidth = channelWidth - 2;
      ctx['strokeStyle'] = 'rgba(0,0,0,1)';
      ctx.lineCap = 'round';
      ctx.stroke();
      ctx.shadowBlur = 0;
    };

    var drawShadows = function drawShadows() {
      if (shadowBlur > 0) {
        var x,
            offset = 10,
            channel;

        if (alphaSupport) {
          x = offset + channelWidth / 2;
          drawShadow(x);
          offset += channelWidth + channelMargin;
        }

        if (!onlyAlpha) {
          $.each(indexes, function () {
            x = offset + channelWidth / 2;
            drawShadow(x);
            offset += channelWidth + channelMargin;
          });
        }
      }
    };

    var drawLabels = function drawLabels() {
      var j = 0;

      if (alphaSupport || onlyAlpha) {
        $labels.append($('<div />').text('A').width(channelWidth).css({
          'padding-left': 10
        }));
      } else if (!onlyAlpha) {
        $labels.append($('<div />').text(indexes[0].toUpperCase()).width(channelWidth).css({
          'padding-left': 10
        }));
        j++;
      }

      if (!onlyAlpha) {
        for (; j < indexes.length; j++) {
          $labels.append($('<div />').text(indexes[j].toUpperCase()).width(channelWidth).css({
            'padding-left': channelMargin
          }));
        }
      }
    };

    var draggingRenderer = Throttle(function (event) {
      var inputPoint = Util.getEventPosition(false, event, $canvas);
      var fullScaleValue = canvasHeight - channelWidth - canvasPadding;
      var position = fullScaleValue - Math.round(inputPoint[1] - channelWidth / 2 - canvasPadding / 2);

      if (position < 0) {
        position = 0;
      } else if (position > fullScaleValue) {
        position = fullScaleValue;
      }

      var value = position / fullScaleValue;

      if (alphaSupport && draggingChannel === 0) {
        currentColor.setAlpha(value);
      } else if (!onlyAlpha) {
        var index = draggingChannel;

        if (alphaSupport) {
          index--;
        }

        var functionToCall = 'get' + mode.charAt(0).toUpperCase() + mode.slice(1);
        var tempColor = currentColor[functionToCall]();
        tempColor[indexes[index]] = value;
        tempColor.a = currentColor.getAlpha();
        currentColor = new Color(tempColor);
      }

      drawPanel();
      $target.trigger(NAMESPACE + '.' + NAMESPACE);
    }); // API

    self.getColor = function () {
      return currentColor;
    };

    self.getWidth = function () {
      return getPanelWidth();
    };

    self.setAlpha = function (value) {
      currentColor.setAlpha(value);
      return self;
    };

    self.setColor = function (newColor) {
      // Throttle?
      currentColor = new Color(newColor);
      drawPanel();
      return self;
    };

    self.setHeight = function (newHeight) {
      ctx.clearRect(0, 0, getPanelWidth(), canvasHeight);
      labelsHeight = $labels.outerHeight(true);
      $select.width(getPanelWidth() - 20);
      canvasHeight = newHeight - $select.outerHeight(true) - labelsHeight;
      $canvas.attr('height', canvasHeight); //canvas.height = canvasHeight;

      drawPanel();
      return self;
    };

    self.setMode = function (newMode) {
      if ($.inArray(newMode, allModes) >= 0) {
        $select.val(newMode);
        mode = newMode;
        indexes = newMode.split('');
        $canvas.attr('width', getPanelWidth());
        drawPanel();

        if (panelLabels) {
          $labels.width(getPanelWidth()).children().remove();
          drawLabels();
        }

        $select.width(getPanelWidth() - 20);
      }

      return self;
    }; // Initialise variables. step 1


    var canvasPadding = 20;
    var lingrad;
    var currentColor = new Color();
    var mode = 'rgb';
    var indexes = mode.split('');
    var dragging = 0;
    var draggingChannel = 0;
    var selectHeight = 0;
    var allModes = ['rgb', 'hsl', 'cmyk'];
    var $select = $('<select/>'); // Build layout

    if (!onlyAlpha && inputModes.length) {
      var option = '<option/>';
      $.each(inputModes, function (i, mode) {
        $select.append($(option).html(mode));
      });
      $target.append($select);
      selectHeight = $select.outerHeight(true);
    }

    var canvasHeight = panelHeight - selectHeight;
    var $canvas = $('<canvas/>').attr('width', getPanelWidth()).attr('height', canvasHeight).css('display', 'block');
    $target.append($canvas);
    var $labels = $();
    var labelsHeight = 0;

    if (panelLabels) {
      $labels = $('<div />').addClass('ui-panel-labels').width(getPanelWidth());
      drawLabels();
      $target.append($labels);
    } // Initialise variables. step 2


    var canvas = $canvas[0];
    var ctx = canvas.getContext("2d"); // Initialises panel

    self.setMode(inputMode);

    if (!onlyAlpha) {
      // Bind events
      $select.change(function () {
        self.setMode($(':selected', this).val());
      });
    }

    $target.add($labels.find('div')).bind('mousedown touchstart', function (event) {
      if ($(this).is(event.target)) {
        event.preventDefault();
      }
    });
    $canvas.bind('mousedown touchstart', function (event) {
      event.preventDefault();
      draggingChannel = 0;
      var offset = 10;
      var inputPoint = Util.getEventPosition(false, event, $(this));

      while (draggingChannel < 5 && !dragging) {
        if (inputPoint[0] > offset && inputPoint[0] < offset + channelWidth) {
          dragging = 1;
          draggingRenderer(event);
        } else {
          draggingChannel++;
          offset += channelWidth + channelMargin;
        }
      }
    }).bind('mousemove touchmove', function (event) {
      var inputPoint = Util.getEventPosition(false, event, $canvas);
      var width = $canvas.width();
      var padding = canvasPadding / 2;

      if (inputPoint[0] > padding && inputPoint[1] > padding && inputPoint[0] < width - padding && inputPoint[1] < $canvas.height() - padding) {
        var offset = padding;

        while (offset < width) {
          if (inputPoint[0] > offset && inputPoint[0] < channelWidth + offset) {
            $canvas.css('cursor', 'crosshair');
            break;
          } else {
            $canvas.css('cursor', '');
          }

          offset += channelWidth + channelMargin;
        }
      } else {
        $canvas.css('cursor', '');
      }
    });
    $([window, document]).bind('mousemove touchmove', function (event) {
      if (dragging) {
        event.preventDefault();
        draggingRenderer(event);
      }
    }).bind('mouseup touchend', function (event) {
      if (dragging) {
        event.preventDefault();
        dragging = 0;
        draggingRenderer(event);
      }
    });
  };
}();

module.exports = Panel;

/***/ }),

/***/ "./public/js/chromoselector/src/throttle.js":
/*!**************************************************!*\
  !*** ./public/js/chromoselector/src/throttle.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Throttle = function () {
  return function (functionToCall, timeoutInMs) {
    timeoutInMs = timeoutInMs || 4;

    var timer,
        savedArguments,
        needInvokation,
        tick = function tick() {
      if (needInvokation) {
        functionToCall.apply({}, savedArguments);
        needInvokation = 0;
        timer = setTimeout(tick, timeoutInMs);
      } else {
        timer = 0;
      }
    };

    return function () {
      savedArguments = arguments;
      needInvokation = 1;

      if (!timer) {
        tick();
      }
    };
  };
}();

module.exports = Throttle;

/***/ }),

/***/ "./public/js/chromoselector/src/util.js":
/*!**********************************************!*\
  !*** ./public/js/chromoselector/src/util.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = {
  getEventPosition: function getEventPosition(self, e, $obj) {
    var x = 0,
        y = 0;
    var oe = e.originalEvent;
    var touch = oe.touches || oe.changedTouches;
    var offset;
    var previewHeight;

    if (self) {
      offset = $obj.parent().offset();
      previewHeight = self._preview.outerHeight();
    } else {
      offset = $obj.offset();
      previewHeight = 0;
    }

    if (touch) {
      // touchscreen
      x = touch[0].pageX - offset.left;
      y = touch[0].pageY - offset.top - previewHeight;
    } else if (oe.clientX) {
      // mouse
      x = oe.clientX + window.pageXOffset - offset.left;
      y = oe.clientY + window.pageYOffset - offset.top - previewHeight;
    }

    return [x, y];
  }
};

/***/ })

}]);