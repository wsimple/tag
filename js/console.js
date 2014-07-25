//-- Consola --//
console.log('Agent: '+navigator.userAgent);
(function(w,$){
	var c,fakec={},types=[];
	['log','alert','warn','error'].forEach(function(name){fakec[name]=function(){return;};});
	if('console' in w) c=w.console; else c=fakec;
	$.c=function(type){
		if($.cookie('_DEBUG_')===null) return fakec;
		if(type!==undefined&&types.indexOf(type)<0) types.push(type);
		return !type||$.cookie('_DEBUG_')==type?c:fakec;
	};
	$.c.show=function(type){
		$.cookie('_DEBUG_',type!==undefined?type:'');
		return ['Enabled ',type||'Global',' Logs'].join('');
	};
	$.c.hide=function(){
		$.cookie('_DEBUG_',null);
		c.log('Disabled all Logs');
	};
	$.c.list=function(){ return types; };

	var c1,c2={};
	['log','alert','warn','error'].forEach(function(name){c2[name]=function(){return;};});
	if(!('console' in w)){
		['log','unlog'].forEach(function(name){w[name]=function(){return;};});
		c1=c2;
	}else{
		w.log=function(name){
			$.local('disable_'+name,null);
		};
		w.unlog=function(name){
			$.local('disable_'+name,1);
		};
		c1=w.console;
		c1.show=function(){
			c1.log('Logs Already Enabled');
		};
		c1.hide=function(/*fn*/){
			w.console=c2;
			$.local('enable_console',null);
			c1.log('Logs Disabled');
//			if(typeof fn == 'function') setTimeout(fn,0);
		};
		c2.show=function(/*fn*/){
			w.console=c1;
			$.local('enable_console',true);
			c1.log('Logs Enabled');
//			if(typeof fn == 'function') setTimeout(fn,0);
		};
		c2.hide=function(){
			c1.log('Logs Already Disabled');
		};
		if($.cookie('_DEBUG_')===undefined) w.console=c2;
	}
	if('hide' in console){
		w.enableConsole=w.enableLogs=function(){console.show();$.cookie('_DEBUG_',1);};
		w.disableConsole=w.disableLogs=function(){console.hide();$.cookie('_DEBUG_',null);};
	}
})( window, jQuery );
