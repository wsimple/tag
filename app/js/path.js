/*
 * DOMINIO: Se utiliza para el llamado del controles y archivos que esten en el server.
 * FILESERVER: Se utiliza para el llamados de imagenes.
 */
(function(window){
	if(window.location.href.match(/cometchat|chat\.html/i)){
		var $={local:function(){},session:function(){}};
		CORDOVA=true;
	}else{
		var $=jQuery;
		if(!is['support']&&!($.local('enableLogs')||$.cookie('_DEBUG_'))&&!window.location.host.match(/localhost|\d+(\.\d+)+/i)) window.location='..';
		CORDOVA=$.session('cordova')||false;
		if(CORDOVA) $.session('cordova',CORDOVA);
	}
	var regex	=/(seemytag|tagbum)\.com/i,
		pruebas	='wpruebas/'||'',
		d		=CORDOVA||window.location.host=='localhost'||(($.local('host')||'').match(regex)),
		dom		=d?'http://tagbum.com/'+pruebas:'../',
		prod	=!!(dom.match(regex)||window.location.host.match(regex));
	LOCAL=dom.match(regex)&&!window.location.host.match(regex);
	PRODUCCION=prod;
	DOMINIO=dom;
	FILESERVER=prod?'http://seemytagdemo.com/':'http://68.109.244.201/';
	PAGE={
		ini:'.',
		chat:'chat.html',
		detailsproduct:'detailsProduct.php',
		home:'timeLine.php',
		findfriends:'findFriends.php',
		forGot:'resendPass.php',
		fullversion:'../?fullVersion',
		groupslist:'lstgroups.php',
		login:'login.php',
		news:'news.php',
		newtag:'newtag.php',
		notify:'notifications.php',
		orderdetails:'orderDetails.php',
		preferences:'preferences.php',
		profile:'profile.php',
		profilepic:'profilePicture.php',
		reporttag:'reportTag.php',
		seekpreferences:'seekPreferences.php',
		sharetag:'shareTag.php',
		shoppingCart:'storeCartList.php',
		signup:'signUp.php',
		storePorduct:'store.php',
		storeCat:'storeCategory.php',
        storeOption:'storeOption.php',
		storeSubCate:'storeSubCategory.php',
		storeMypubli:'storeMypublication.php',
		tag:'tag.php',
		tagslist:'tagsList.php',
		timeline:'timeLine.php',
		toptags:'topTags.php',
		userfriends:'userFriends.php',
		landding:'landding.php',
        search:'search.php'
	};
})(window);
