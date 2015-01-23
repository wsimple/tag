<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-Type: text/javascript');
	// echo str_repeat("\n",7);
if(false){ ?><script><?php } ?>
/*
 * DOMINIO: Se utiliza para el llamado del controles y archivos que esten en el server.
 * FILESERVER: Se utiliza para el llamados de imagenes. (antiguo)
 * SERVERS: contiene los otros servidores (actualmente principal, de imagenes y de videos)
 */
(function(window){
	SERVERS={
		main:'http://tagbum.com/',
		app:'http://app.tagbum.com/',
		img:'http://i.tagbum.com',
		video:'http://v.tagbum.com'
	};
<?php if(isset($_GET['minify'])){ ?>
	LOCAL=true;
	PRODUCCION=true;
	// DOMINIO=$.local('host')||'http://tagbum.com/';
	DOMINIO='http://tagbum.com/';
	FILESERVER='http://i.tagbum.com/';
	CORDOVA=true;
<?php }else{ ?>
	if(window.location.href.match(/chat/i)){
		var $={local:function(){},session:function(){}};
		CORDOVA=true;
	}else{
		var $=jQuery;
		CORDOVA=$.session('cordova')||false;
		if(CORDOVA) $.session('cordova',CORDOVA);
	}
	var regex	=/(tagbum)\.com/i,
		pruebas	='',
		d		=window.location.host=='localhost'||(($.local('host')||'').match(regex)),
		dom		=d?'http://tagbum.com/':'../',
		prod	=!!(dom.match(regex)||window.location.host.match(regex));
	LOCAL=dom.match(regex)&&!window.location.host.match(regex);
	PRODUCCION=prod;
	DOMINIO=dom;
	FILESERVER=prod?'http://i.tagbum.com/':'http://68.109.244.201/';
<?php } ?>
	PAGE={
		ini:'index.html',
		chat:'<?=is_dir('../cometchat/extensions')?'cometchat/extensions/mobilewebapp/':'chat'?>',
		detailsproduct:'detailsProduct.html',
		home:'timeLine.html',
		findfriends:'findFriends.html',
		forGot:'resendPass.html',
		fullversion:"<?=isset($_GET['minify'])?'index.html':'../?fullVersion'?>",
		groupslist:'lstgroups.html',
		login:'login.html',
		news:'news.html',
		newtag:'newtag.html',
		notify:'notifications.html',
		orderdetails:'orderDetails.html',
		preferences:'preferences.html',
		profile:'profile.html',
		profilepic:'profilePicture.html',
		reporttag:'reportTag.html',
		seekpreferences:'seekPreferences.html',
		sharetag:'shareTag.html',
		shoppingCart:'storeCartList.html',
		signup:'signUp.html',
		storePorduct:'store.html',
		storeCat:'storeCategory.html',
		storeOption:'storeOption.html',
		storeSubCate:'storeSubCategory.html',
		storeMypubli:'storeMypublication.html',
		tag:'tag.html',
		tagslist:'tagsList.html',
		timeline:'timeLine.html',
		toptags:'topTags.html',
		userfriends:'userFriends.html',
		landding:'landding.html',
		trendings:'trendings.html',
		search:'search.html'
	};
<?php if(preg_match('/^app\./i',$_SERVER['SERVER_NAME'])){ ?>
	for(var i in PAGE){
		PAGE[i]='/'+PAGE[i];
	}
<?php } ?>
})(window);
