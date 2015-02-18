//-- Consola --//
console.log('Agent: '+navigator.userAgent);
(function(w){
	var c1,c2={};
	['log','alert','warn','error'].forEach(function(name){c2[name]=function(){return;};});
	if(!('console' in w)){
		['log','unlog'].forEach(function(name){w[name]=function(){return;};});
		c1=c2;
		w.console=c1;
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
		if(!$.local('enable_console')) w.console=c2;
	}
	if('hide' in console){
		w.enableConsole=w.enableLogs=function(){console.show();$.cookie('_DEBUG_',1);};
		w.disableConsole=w.disableLogs=function(){console.hide();$.cookie('_DEBUG_',null);};
	}
})( window );
