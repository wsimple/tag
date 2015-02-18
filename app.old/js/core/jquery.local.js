/*
 * Manejo de variables de uso local y de sesion
 * NOTA: Campo ce (ej: $.local.clear.exceptions) debe ser una expresion regular que indique las excepciones de borrado.
 *		 Si no se indican excepciones, seran borrados todos los elementos.
 */
(function($,window,document,JSON){
	//localStorage
	if(!('localStorage' in window && window['localStorage'] !== null)){
		$.local=$.cookie;
		return;
	}
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
	$.local.get=function(key,value){
		return $.local(key,value);
	};
	$.local.set=function(values){
		for(var key in values) $.local(key,values[key]);
		return $.local;
	};
	$.local.clear=function(){
		var i,key;
		for(i=ls.length;i>0;i--){
			key=ls.key(i-1);
			if( !$.local.clear.exceptions || !key.match($.local.clear.exceptions) ) ls.removeItem(key);
		}
		return $.local;
	};
})(jQuery,window,document,JSON);
(function($,window,document,JSON){
	//sessionStorage
	if(!('sessionStorage' in window && window['sessionStorage'] !== null)){
		$.session=$.cookie;
	}
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
	$.session.get=function(key,value){
		return $.session(key,value);
	};
	$.session.set=function(values,options){
		for(var key in values) $.session(key,values[key],options||{});
		return $.session;
	};
	$.session.clear=function(){
		var i,key;
		for(i=ss.length;i>0;i--){
			key=ss.key(i-1);
			if( !$.session.clear.exceptions || !key.match($.session.clear.exceptions) ) ss.removeItem(key);
		}
		return $.session;
	};
})(jQuery,window,document,JSON);
