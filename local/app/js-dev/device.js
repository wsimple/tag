//-- definimos header de app --//
(function(){
	$.ajaxSetup({
		type:'POST',
		dataType:'json',
		data:{'__is_app__':'1'},
		xhrFields:{withCredentials:true}
	});
})();
(function(w,$){
	$(function(){
		function cambiar(){
			if(DOMINIO!=='http://seemytag.com/'){
				DOMINIO='http://seemytag.com/';
				$.local('host',null)
				$('body > #menu .menu .header').css('color','');
			}else{
				DOMINIO=$.local('host','http://seemytag.com/wpruebas/');
				$('body > #menu .menu .header').css('color','#f00');
			}
		}
		setTimeout(function(){
			if(DOMINIO!=='http://seemytag.com/'){
				$('body > #menu .menu .header').css('color','#f00');
			}
		},3000);
		w.changeDomain=cambiar;
		var c={},gestures='swipeleft swiperight click';
		$('body').on(gestures,'#menu .menu .header',function(e){
			c[e.type]=true;
			var i,g=gestures.split(' ');
			for(i=0;i<g.length;i++) if(!c[g[i]]) return;
			cambiar();
			c={};
		});
	});
})(window,jQuery);
