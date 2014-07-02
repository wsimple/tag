/*
 * Manejo de variables de uso local y de sesion
 * NOTA: Campo ce (ej: $.local.ce) debe ser una expresion regular que indique las excepciones de borrado.
 *		 Si no se indican excepciones, seran borrados todos los elementos.
 */
(function($,window,document,JSON){
	//agregamos opciones de cookies: ingresar varias y limpiar todas las cookies
	if($.cookie){
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
				if( !$.cookie.ce || !name.match($.cookie.ce) ) $.cookie(name, null);
			}
			return $.cookie;
		};
	}
	//localStorage
	if('localStorage' in window && window['localStorage'] !== null) {
		var ls=window['localStorage'];
		$.local=function(key,value){
			if(typeof key == 'string'){
				if(value!==undefined){
					if(value===null)
						ls.removeItem(key);
					else
						ls[key]=JSON.stringify(value);
				}
				value=ls[key];
				if(typeof value != 'string') value='null';
				return JSON.parse(value);
			}else
				return true;
		};
		$.local.get=function(key,value,options){
			return $.local(key,value,options);
		};
		$.local.set=function(values,options){
			for(var key in values) $.local(key,values[key],options||{});
			return $.local;
		};
		$.local.clear=function(){
			var i,key;
			for(i=ls.length;i>0;i--){
				key=ls.key(i-1);
				if( !$.local.ce || !key.match($.local.ce) ) ls.removeItem(key);
			}
			return $.local;
		};
	} else {
		$.local=$.cookie;
	}
	//sessionStorage
	if('sessionStorage' in window && window['sessionStorage'] !== null) {
		var ss=window['sessionStorage'];
		$.session=function(key,value){
			if(typeof key == 'string'){
				if(value!==undefined){
					if(value===null)
						ss.removeItem(key);
					else
						ss[key]=JSON.stringify(value);
				}
				value=ss[key];
				if(typeof value != 'string') value='null';
				return JSON.parse(value);
			}else
				return true;
		};
		$.session.set=function(values,options){
			for(var key in values) $.session(key,values[key],options||{});
			return $.session;
		};
		$.session.clear=function(){
			var i,key;
			for(i=ss.length;i>0;i--){
				key=ss.key(i-1);
				if( !$.session.ce || !key.match($.session.ce) ) ss.removeItem(key);
			}
			return $.session;
		};
	}else{
		$.session=$.cookie;
	}
})(jQuery,window,document,JSON);
