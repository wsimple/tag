//-- definimos header de app --//
(function(){
	var opc={
		type:'POST',
		dataType:'json'
	};
	if(LOCAL||location.host.match(/localhost/)){
		opc.xhrFields={withCredentials:true};
		opc.data={'CROSSDOMAIN':'1'};
	}else
		opc.headers={'SOURCEFORMAT':'mobile'};
	$.ajaxSetup(opc);
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
		},1000);
		w.changeDomain=cambiar;
	});
	function errorDialog(){
		if(offline) myDialog('#errorDialog','ERROR-invitedFriends');
	}
})(window,jQuery);
