/*jshint eqnull:true */
/*!
 * jQuery Cookie Plugin v1.2
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2011, Klaus Hartl
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/GPL-2.0
 */
(function ($, document, undefined) {

	var pluses = /\+/g;

	function raw(s) {
		return s;
	}

	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	$.cookie = function (key, value, options) {

		// key and at least value given, set cookie...
		if (value !== undefined && !/Object/.test(Object.prototype.toString.call(value))) {
			options = $.extend({}, $.cookie.defaults, options);

			if (value === null) {
				options.expires = -1;
			}

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = String(value);

			return (document.cookie = [
				encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// key and possibly options given, get cookie...
		options = value || $.cookie.defaults || {};
		var decode = options.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		for (var i = 0, parts; (parts = cookies[i] && cookies[i].split('=')); i++) {
			if (decode(parts.shift()) === key) {
				return decode(parts.join('='));
			}
		}

		return null;
	};
	$.cookie.defaults = {};
	$.cookie.options=function(options,clear){
		if(clear) $.cookie.defaults={};
		$.cookie.defaults=$.extend($.cookie.defaults, options);
		return $.cookie;
	}
	$.cookie.set=function(values,options){
		for(var key in values) $.cookie(key,values[key],options||{});
		return $.cookie;
	};
	$.cookie.clear=function(){
		var i,cookies = document.cookie.split(';'),len=cookies.length;
		for (i = 0; i < len; i++) {
			var cookie = cookies[i],
				eqPos = cookie.indexOf('='),
				name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
			name = name.replace(/%20|\s/g,'');
			if( !$.cookie.clear.exceptions || !name.match($.cookie.clear.exceptions) ) $.cookie(name, null);
		}
		return $.cookie;
	};


	$.removeCookie = function (key, options) {
		if ($.cookie(key, options) !== null) {
			$.cookie(key, null, options);
			return true;
		}
		return false;
	};

})(jQuery, document);