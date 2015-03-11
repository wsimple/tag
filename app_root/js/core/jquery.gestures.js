//(c) 2013 Willem Franco
//Basado en Zepto.js
//Fuente: https://github.com/madrobby/zepto/blob/master/src/gesture.js

;(function(window,document,$){
	var m = Math,
		gesture={},gestureTimeout,
		isTouchPad=(/hp-tablet/gi).test(navigator.appVersion);
	function parentIfText(node){
		return 'tagName' in node?node:node.parentNode;
	}
	function setPinch(){
		['pinch','pinchIn','pinchOut'].forEach(function(m){
			$.fn[m]=function(callback){
				return this.bind(m,callback);
			};
		});
	}
	function triggerPinch(){
		Math.abs(gesture.e1-gesture.e2)!=0&&$(gesture.target).trigger('pinch') &&
		$(gesture.target).trigger('pinch'+(gesture.e1-gesture.e2>0?'In':'Out'));
	}
	if ('ongesturestart' in window){
		$(document).bind('gesturestart',function(e){
			var now=Date.now(),delta=now-(gesture.last||now);
			gesture.target=parentIfText(e.target);
			gestureTimeout&&clearTimeout(gestureTimeout);
			gesture.e1=e.scale;
			gesture.last=now;
		}).bind('gesturechange',function(e){
			gesture.e2=e.scale;
		}).bind('gestureend',function(e){
			if(gesture.e2>0){
				triggerPinch();
				gesture.e1=gesture.e2=gesture.last=0;
			}else if('last' in gesture){
				gesture={};
			}
		});
		setPinch();
	}else if('ontouchstart' in window && !isTouchPad){
		var touchesDistStart,c1,c2;
		$(document).bind('ontouchstart',function(e){
			var now=Date.now(),delta=now-(gesture.last||now);
			gesture.target=parentIfText(e.target);
			gestureTimeout&&clearTimeout(gestureTimeout);
			gesture.e1=e.scale;
			gesture.last=now;
			if (e.touches.length > 1) {
				c1 = m.abs(e.touches[0].pageX-e.touches[1].pageX);
				c2 = m.abs(e.touches[0].pageY-e.touches[1].pageY);
				gesture.e1=e.scale;
				gesture.d1=m.sqrt(c1 * c1 + c2 * c2);

				that.originX = m.abs(e.touches[0].pageX + e.touches[1].pageX - that.wrapperOffsetLeft * 2) / 2 - that.x;
				that.originY = m.abs(e.touches[0].pageY + e.touches[1].pageY - that.wrapperOffsetTop * 2) / 2 - that.y;

				if (that.options.onZoomStart) that.options.onZoomStart.call(that, e);
			}
		}).bind('ontouchchange',function(e){
			if (e.touches.length > 1) {
				c1 = m.abs(e.touches[0].pageX - e.touches[1].pageX);
				c2 = m.abs(e.touches[0].pageY - e.touches[1].pageY);
				gesture.e2=e.scale;
				gesture.d2=m.sqrt(c1*c1+c2*c2);

				var scale=1/gesture.d1*gesture.d1;

				if (scale < that.options.zoomMin) scale = 0.5 * that.options.zoomMin * Math.pow(2.0, scale / that.options.zoomMin);
				else if (scale > that.options.zoomMax) scale = 2.0 * that.options.zoomMax * Math.pow(0.5, that.options.zoomMax / scale);

				that.lastScale = scale / this.scale;

				newX = this.originX - this.originX * that.lastScale + this.x;
				newY = this.originY - this.originY * that.lastScale + this.y;

				this.scroller.style[transform] = 'translate(' + newX + 'px,' + newY + 'px) scale(' + scale + ')' + translateZ;

				if (that.options.onZoom) that.options.onZoom.call(that, e);
				return;
			}
		}).bind('ontouchend',function(e){
			if(gesture.e2>0){
				Math.abs(gesture.e1-gesture.e2)!=0&&$(gesture.target).trigger('pinch') &&
				$(gesture.target).trigger('pinch'+(gesture.e1-gesture.e2>0?'In':'Out'));
				gesture.e1=gesture.e2=gesture.last=0;
			}else if('last' in gesture){
				gesture={};
			}
		});
		setPinch();
	}
})(window,document,jQuery);
