//-- Consola --//
(function(w,$){
	var c,fake={},typelist=[];
	['log','alert','warn','error'].forEach(function(name){fake[name]=function(){return;};});
	if('console' in w) c=w.console; else c=fake;
	$.debug=function(type){
		if($.cookie('_DEBUG_')===null) return fake;
		if(!type) return c;
		if(!$.cookie('_DEBUG_')) return !type?c:fake;
		var debuglist=$.cookie('_DEBUG_').split(','),types=type.split(','),len=types.length,show=false;
		for(var i=0;i<len;i++){
			if(typelist.indexOf(types[i])<0) typelist.push(types[i]);
			if(debuglist.indexOf(types[i])>=0) show=true;
		}
		return show?c:fake;
	};
	$.debug.show=function(type){
		$.cookie('_DEBUG_',type!==undefined?type:'');
		return ['Enabled',type||'Global','Logs'].join(' ');
	};
	$.debug.add=function(type){
		var debuglist=$.cookie('_DEBUG_')?$.cookie('_DEBUG_').split(','):[];
		if(!type) type=prompt('Actual values:\n'+debuglist.join(', '),'');
		var i=debuglist.indexOf(type);
		if(i<0&&type) debuglist.push(type);
		$.cookie('_DEBUG_',debuglist.join(','));
		return ['Added',type||'Global','to Logs'].join(' ');
	};
	$.debug.remove=function(type){
		var debuglist=$.cookie('_DEBUG_')?$.cookie('_DEBUG_').split(','):[];
		if(!type) type=prompt('Actual values:\n'+debuglist.join(', '),'');
		var i=debuglist.indexOf(type);
		if(i>=0) debuglist.splice(i,1);
		$.cookie('_DEBUG_',debuglist.join(','));
		return ['Removed',type||'Global','from Logs'].join(' ');
	};
	$.debug.hide=function(){
		$.cookie('_DEBUG_',null);
		c.log('Disabled all Logs');
	};
	$.debug.list=function(){ return typelist; };
	$.debug.isEnabled=function(){ return $.cookie('_DEBUG_')!==null; };
	$.debug.config=function(){ return $.cookie('_DEBUG_'); };
	w.debug=$.c=$.debug;
	w.enableConsole=w.enableLogs=function(type){$.debug.show(type);};
	w.disableConsole=w.disableLogs=function(){$.debug.hide();};

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
})( window, jQuery );
// $.debug().log('Agent: '+navigator.userAgent);
