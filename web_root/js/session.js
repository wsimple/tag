//-- Login --//
(function(w,$){
	var isLogged=function(val){
			if(val!==undefined) $.local('logged',val);
			return !!$.local('logged')||!!$.cookie('__logged__');
		},
		date=new Date(),lastCheck=date,
		loginAction,logChange=isLogged(),running,
		loginState=function(actions,error){
			if(actions) loginAction=actions;
			if(running) return;
			var opc={
				url:DOMINIO+'controls/users/logged.json.php',
				data:$.local('kldata')||{},
				loader:false,
				//global:false,
				success:function(data){
					lastCheck=date;
					isLogged(data['logged']);
					if(loginAction) loginAction(isLogged());
//					console.log('check loggin: logged='+l);
				},
				complete:function(/*xhr,status*/){
					running=false;
//					console.log(status);
				}
			};
			if(error) opc.error=error;
			running=true;
			$.ajax(opc);
		},
		time=15*60,
		dif=function(){ date=new Date(); return parseInt((date.getTime()-lastCheck.getTime())/(1000)); },
		checkLogin=function(){
			if(isLogged()!==logChange){
				if(loginAction) loginAction(isLogged());
				return false;
			}
			if(dif()>=time) loginState();
			return true;
		};
	if(w.ISLOGGED) isLogged(w.ISLOGGED);
	setInterval(checkLogin,5000);
	w.loginState=loginState;
	w.isLogged=isLogged;
})(window,jQuery);
