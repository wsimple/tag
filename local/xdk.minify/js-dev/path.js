/*
 * DOMINIO: Se utiliza para el llamado del controles y archivos que esten en el server.
 * FILESERVER: Se utiliza para el llamados de imagenes.
 */
var DOMINIO,PRODUCCION,LOCAL,FILESERVER,PAGE;
(function(window){
	LOCAL=true;
	PRODUCCION=true;
	DOMINIO=$.local('host')||'http://tagbum.com/';
	FILESERVER='http://i.tagbum.com/';
	PAGE={
		ini:'index.html',
		chat:'chat.html',
		detailsproduct:'detailsProduct.html',
		home:'timeLine.html',
		findfriends:'findFriends.html',
		forGot:'resendPass.html',
		fullversion:'../?fullVersion',
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
		search:'search.html'
	};
})(window);
