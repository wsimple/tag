//-- Consola --//
(function(w){
	if(!('console' in w)){
		var c={};
		c.log=c.alert=c.warn=c.error=c.show=c.hide=function(){return;};
		w.console=c;
	}
	w.log=function(name){
		$.cookie(name,1);
	};
	w.unlog=function(name){
		$.cookie(name,null);
	};
})( window );
