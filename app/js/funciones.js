var hideGroups=false;

//-- Constantes para mobile --//
(function(w,$){
	$.local.clear.exceptions=/^(logged|host|firebug.*)$/i;//excepciones al borrar todos los locales
	$.cookie.clear.exceptions=/^(kl|last|enableLogs|PHPSESSID|_DEBUG_)$/;//excepciones al borrar todas las cookies
	$.cookie.options({expires:(CORDOVA?365:15),path:'/'});//opciones de cookies
	//loader
	var m,loader=function(mode){$.mobile.loading(mode);};
	$.loader=function(mode){
		if(m!==mode){$(function(){loader(mode);});m=mode;}
	};
	$(function(){
		$.loader=function(mode){if(m!==mode){loader(mode);m=mode;}};
	});
	$.mobile.defaultPageTransition='slide';//transicion por defecto
	$.mobile.ajaxEnabled=false;//is.android;
	$.fn.jScroll.defaultOptions.forceIscroll=true;//ignora scroll nativo, obligando a utilizar iScroll
	//se eliminan algunas cookies cuando no viene de una transicion
	$.session('get',null);
	$.session('page',null);
	//$.mobile.loader.prototype.options.text=lan('loading');
	$.mobile.loader.prototype.options.textVisible=false;
	$.mobile.loader.prototype.options.theme='a';
	$.mobile.listview.prototype.options.filterPlaceholder=lan('filter');
})(window,jQuery);
function redir(url,trans){
	if(offline){
		myDialog('#errorDialog',lan('noConnection'));
	}else{
		//if(!url.match(/\.(html|php)/)) url='smt.html?page='+url;
		console.log('move to '+url);
		var goToURL=function(){
			if($.mobile.ajaxEnabled){
				//si estan activas las transiciones, se almacena el get en una cookie para poder utilizarla antes de que cargue la pagina (ver pageshow)
				var get=url.split('#')[0].split('?')[1];
				if(get) $.session('get',get);
				$.mobile.changePage(url,{transition:(trans||'slide'),reloadPage:true});
			}else{
				window.location=url;
			}
		};
		if(menuVisible()){
			menuRun(goToURL);
		}else{
			goToURL();
		}
	}
}
function goBack(num){
	if(offline){
		myDialog('#errorDialog',lan('noConnection'));
	}else{
		num=num||-1;
		if(num<0){
			history.back(num);
		}
	}
}

//-- Lectura de archivos de texto --//
function readTxt(url){
	var req,txt='';
	if(typeof XDomainRequest!='undefined'){//para IE8
		req=new XDomainRequest();
	}else if(window.XMLHttpRequest){//para IE7, Firefox, Chrome, Opera, Safari
		req=new XMLHttpRequest();
	}else{//para IE6, IE5
		req=new ActiveXObject('Microsoft.XMLHTTP');
	}
	req.open('GET',url,false);
	req.onreadystatechange=function(){
		if(req.readyState!=4) return;
		if(req.status!=200) return;
		txt=req.responseText;
	};
	req.send();
	return txt;
}

//-- SearchPopUp --//
function createSearchPopUp(container){
	var popcontent = '	<div data-role="popup" id="searchPopUp" data-overlay-theme="a" data-transition="fade" >'+
		'<div style="height:120px;margin:19px;">'+
			'<div id="wrap">'+
				'<div id="contents">'+
						'<img src="css/newdesign/tagbum_orange_logo_letters.png" alt="" style="max-height:90px;">'+
						'<div style="clear: both;"></div>'+
				   '</div>'+
				'</div>'+
			'</div>'+
			'<div class="center-wrapper">'+
				'<div id="seacrh-btn2" data-role="button" data-theme="m" style="float:right;height:37px;width:37px;">'+
					'<div class="imagebox2"></div>'+
				'</div>'+
				'<ul id="autocomplete" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="Search..." data-filter-theme="d"></ul>'+
				'<div style="clear: both;"></div>'+
			'</div>'+
			'<div class="center-wrapper" style="margin:10px;">'+
				'<div id="seacrh-btn" data-role="button" data-theme="m" >'+
					'<div class="imagebox"></div>'+
				'</div>'+
			'</div>'+
			'<div style="height:90px;margin:40px;">'+
				'<div id="wrap">'+
				   '<div id="contents">'+
						'<div style="clear: both;"></div>'+
				   '</div>'+
				'</div>'+
			'</div>'+
		'</div>'+
	'</div>';
	$(container).append(popcontent);	
}

		$(document).on( "pageinit", function() {
			$('#searchPopUp input[data-type="search"]').on('keydown', function(e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 13) { //Enter keycode
					var seacrhq = $('#searchPopUp input[data-type="search"]').val();
					//alert(seacrhq);
					window.location.href = "search.html?srh="+seacrhq;
				}
			});

			$("#autocomplete").on("click","li",function() {
				var tipobox = $(this).attr('srctype');
				switch(tipobox){
					case 'people': redir(PAGE['profile']+'?id='+$(this).attr('code')); break;
					case 'group':redir('tagsList.html?current=group&id='+$(this).attr('code')); break;
					case 'hash': redir('tagsList.html?current=hash&hash='+$(this).attr('code')); break;
					case 'store': redir('detailsProduct.html?id='+$(this).attr('code')); break;
				};
			});

			$("#searchPopUp").on("click","#seacrh-btn",function() {
				var seacrhq = $('#searchPopUp input[data-type="search"]').val();
				window.location.href = "search.html?srh="+seacrhq;
			});

			$("#searchPopUp").on("click","#seacrh-btn2",function() {
				var seacrhq = $('#searchPopUp input[data-type="search"]').val();
				window.location.href = "search.html?srh="+seacrhq;
			});

		    $("#autocomplete").on("listviewbeforefilter", function (e, data) {
		        var $ul = $( this ),
		            $input = $( data.input ),
		            value = $input.val(),
		            html = "";
		        $ul.html( "" );
		        if ( value && value.length > 2 ) {
		            $ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
		            $ul.listview( "refresh" );
					myAjax({
                		type	:'POST',
                		url		:DOMINIO+'controls/search/search.json.php?mobile&search='+$input.val()+'&limit=basic',
                		error	:function(/*resp,status,error*/){
                			myDialog('#singleDialog',lang.conectionFail);
                		},		            
                		success	:function(data){
                			if (data['friends']!=''){
                				for(i=0;i<data['friends'].length;i++){
                					friend=data['friends'][i];
                					html += '<li srctype="people" code="'+friend.code_friend+'">'+lan('people','ucw')+': '+friend.name_user+'</li>';
                				}
                			}
                			if (data['groups']!=''){
                				for(i=0;i<data['groups'].length;i++){
                					group=data['groups'][i];
                					html += '<li srctype="group" code="'+group.id+'">'+lan('group','ucw')+': '+group.name+'</li>';
                				}
                			}
                			if (data['hash']!=''){
                				for(i=0;i<data['hash'].length;i++){
                					dato=data['hash'][i];
                					html += '<li srctype="hash" code="'+dato+'">'+lan('hashTags','ucw')+': '+dato+'</li>';
                				}
                			}
                			if (data['store']!=''){
                				for(i=0;i<data['store'].length;i++){
                					dato=data['store'][i];
                					html += '<li srctype="store" code="'+dato.id+'">'+lan('store','ucw')+': '+dato.name+'</li>';
                				}
                			}
			                $ul.html( html );
			                $ul.listview( "refresh" );
			                $ul.trigger( "updatelayout");
                		}
                	});
		        };
		    });
		});
//-- End Search PopUp --//

//-- Menu --//
function newMenu(){
	var menu = '<div id="bottom-menu"><span id="backbtn" onclick="goBack();"></span>'+
	'<div class="arrow"></div>'+
		'<ul>'+
			'<li class="timeline"><a href="timeLine.html">'+lan('time line','ucw')+'</a></li>'+
			'<li class="toptags"><a href="'+PAGE.toptags+'">'+lan('TOPTAGS_TITLE')+'</a></li>'+
			'<li class="hot"><a href="#">'+lan('hot','ucw')+'</a></li>'+
			// '<li class="news"><a href="news.html">'+lan('NEWS')+'</a></li>'+
			'<li class="notifications"><a href="'+PAGE.notify+'">'+lan('NOTIFICATIONS')+'</a></li>'+
			'<li class="groups"><a href="#">'+lan('groups','ucw')+'</a></li>'+
			'<li class="chat"><a href="cometchat/i.html">'+lan('chat')+'</a></li>'+
			'<li class="profile"><a href="'+PAGE.profile+'?id='+$.local('code')+'">'+lan('profile')+'</a></li>'+
			'<li class="friends"><a href="'+PAGE.userfriends+'?type=friends&id_user='+$.local('code')+'">'+lan('friends','ucw')+'</a></li>'+
			// '<li class="createtag"><a href="newtag.html">'+lan('newTag')+'</a></li>'+
			'<li class="store"><a href="store.html">'+lan('store')+'</a></li>'+
			'<li class="logout"><a href="#" onclick="javascript:logout();">'+lan('logout')+'</a></li>'+
		'</ul>'+
	'</div>';
	$('body').append(menu);
	$('#bottom-menu ul li.hot').click(function(){
		var content='',news=false,hot=false;
		if (!$('#page-news').length){
			news=true;
			content+='<di><h4>'+lang.NEWS+'</h4><ul id="newsInfo"></ul></div>';
		}
		if (!$('#page-trendings').length){
			hot=true;
			content+='<di><h4>'+lan('hot','ucw')+'</h4><ul id="trendings"></ul></div>';
		}
		myDialog({
            id:'prevNewsAndHot-dialogs',
            content :content,
            scroll:true,
            after:function(){
            	if (hot) getTrendings(3,true)
            	if (news){
            		var action={refresh:{refresh:true},more:{}},$info=$('#newsInfo'),on={};
            		getNews('reload',action.more,on,$info,true);
            		$info.on('click','li[data-type]',function(){
						var type=this.dataset.type,
							source=this.dataset.source,
							url='';
						switch(type){
							case 'tag':url=PAGE['tag']+'?id='+source; break;
							case 'usr':url=PAGE['profile']+'?id='+source; break;
							case 'product':url=PAGE['detailsproduct']+'?id='+source; break;
							default: alert(type);
						}
						if(url){ redir(url); }
					});
            	}
            },
            buttons:[],
            backgroundClose: true
        });
	});

	//Grupos
	$('#bottom-menu ul li.groups').click(function(){
		var content='';
		
		content+='<di><h4>'+lan('mygroups','ucw')+'</h4><ul id="myGroups"></ul></div>';
		content+='<di><h4>'+lan('allgroups','ucw')+'</h4><ul id="allGroups"></ul></div>';
		
		myDialog({
            id:'groups-dialogs',
            content :content,
            scroll:true,
            after:function(){
            	getGroups($.local('code'),true);
            },
            buttons:[],
            backgroundClose: true
        });
	});
}
function menuStore(hover){
	hover=hover?hover:1;
	$('#menu').html(
        '<span class="ui-block-a menu-button store '+(hover==1?'hover':'')+'" ><a href="#"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
        '<span class="ui-block-b menu-button cate '+(hover==2?'hover':'')+'"><a href="#"><img src="css/newdesign/category.png"><br>'+lang.STORE_CATEGORYS+'</a></span>'+
        '<span class="ui-block-c menu-button opc '+(hover==3?'hover':'')+'"><a href="#"><img src="css/newdesign/account_settings.png"><br>'+lan('options','ucw')+'</a></span>'+
        '<span class="ui-block-d menu-button wishes '+(hover==4?'hover':'')+'"><a href="storeOption.html"><img src="css/newdesign/invoice_history.png"><br>'+lan('wishes','ucw')+'</a></span>'+
        '<span class="ui-block-e menu-button cart '+(hover==5?'hover':'')+'"><a href="storeCartList.html"><span></span><img src="css/newdesign/menu/store.png"><br>'+lan('cart','ucw')+'</a></span>'
    );
    myAjax({
		type	:'POST',
		url		:DOMINIO+'controls/store/shoppingCart.json.php?numActShop=4',
		dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success	:function(data){
			if (data[0]*1!=1) $('#menu .opc').addClass('user');
			if (data[1]){
				if (data[1]*1>0) $('#menu .cart span').html(data[1]*1).addClass('active'); 
			}
		}
	});
}
function actionMenuStore(action){
    var opc={contentCategory:''};
    $('#menu').on('click','.cate',function(){
        dialogViewCategorys(action,opc);
    }).on('click','.store',function(){
        switch(action){
            case 1: //mis publicaciones
                redir(PAGE.storeMypubli); break;
            case 2: //mis productos gratis
                redir(PAGE.storeFreeProducts+'?module=myFp'); break;
            case 3: //productos gratis
                redir(PAGE.storeFreeProducts); break;
            case 4: //mis productos gratis
                redir(PAGE.storeFreeProducts+'?module=myPartiFp'); break;
            default: redir(PAGE.storePorduct); 
        }
    }).on('click','.opc',function(){
        myDialog({
            id:'cate-dialog',
            content :'<ul style="margin: 10px 0" '+($('#menu .opc').hasClass('user')?'class="user"':'')+'>'+
                        '<li class="c store"><a href="store.html">'+lan('store','ucw')+'</a></li><li></li>'+
                        '<li class="c myPubli"><a href="storeMypublication.html">'+lan('My publications','ucw')+'</a></li><li></li>'+
                        '<li class="c cart"><a href="storeCartList.html">'+lan('shopping cart','ucw')+'</a></li><li></li>'+
                        '<li class="c wish"><a href="storeOption.html">'+lan('wish list','ucw')+'</a></li><li></li>'+
                        '<li class="c freeP"><a href="storeFreeProducts.html">'+lan('STORE_FREE_PRODUCTS')+'</a></li><li></li>'+
                        '<li class="c myFP"><a href="storeFreeProducts.html?module=myFp">'+lan('STORE_MY_FREE_PRODUCTS')+'</a></li><li></li>'+
                        '<li class="c myPartFP"><a href="storeFreeProducts.html?module=myPartiFp">'+lan('STORE_RAFFLES_PLAYS')+'</a></li><li></li>'+
                        '<li class="c myOrders"><a href="myOrders.html">'+lan('my orders','ucw')+'</a></li><li></li>'+
                    '<div class="clearfix"></div></ul>',
            scroll:true,
            buttons:[],
            backgroundClose: true
        });
    });
    function dialogViewCategorys(action,opc){
        console.log('dialogViewCategorys');
        action=action?action:false;
        var go='store.html?a',get=''; //store
        switch(action){
            case 1: //mis publicaciones
                get='&scc=2&raffle=1'; go='storeMypublication.html?a';
            break;
            case 2: //mis productos gratis
                get='&scc=2&my=1'; go='storeFreeProducts.html?module=myFp';
            break;
            case 3: //productos gratis
                go='storeFreeProducts.html?a'; get='&module=raffle';
            break;
            case 4: //mis participaciones
                go='storeFreeProducts.html?module=myPartiFp'; get='&scc=2&myplays=1';
            break;
        }
        if (opc.contentCategory==''){
            myAjax({
                loader  : true,
                type    : 'POST',
                url     : DOMINIO+'controls/store/listProd.json.php?categoryJSON=1'+get,
                dataType: 'json',
                success : function(data) {
                    var options=[],cate,i,category=[],content='';
                    if (data.category && data.category.length>0){
                        for (i=0;i<data.category.length; i++) {
                            cate=data.category[i];
                            if (!category[cate.id_category]){
                                category[cate.id_category]=[cate.id_category,cate.category_name];
                                options[cate.id_category]='';
                            }
                            options[cate.id_category]+='<li><a href="'+go+'&c='+cate.mId_category+'&sc='+cate.sub_category_mId+'">'+cate.sub_category_name+'</a></li>';
                        };
                        category=category.sort();
                        for(i in category){
                            content+='<li class="c">'+category[i][1]+'<br>'+'<ul>'+options[category[i][0]]+'</ul></li><li></li>';
                        }
                        if (content!='') content='<ul style="margin: 10px 0">'+content+'<div class="clearfix"></div></ul>';
                        else content=lan('TAG_CONTENTUNAVAILABLE');
                        opc.contentCategory=content;
                        dialogViewCategorys(action,opc);
                    }
                },
                error   : function() { myDialog('#singleDialog', 'ERROR-getMemberGroup'); }
            });
        }else{
            myDialog({
                id:'cate-dialog',
                content :opc.contentCategory,
                after:function(){
                    $('#cate-dialog ul li.c').click(function(){
                    	if (!$(this).attr('href'))
	                    	if ($('ul li a',this).length>1){
	                            if ($(this).hasClass('active')) $(this).removeClass('active');
	                            else{
	                                $('#cate-dialog ul li.c.active').removeClass('active');
	                                $(this).addClass('active');
	                            }
                        	}else redir($('ul li a',this).attr('href'));
                    });
                },
                scroll:true,
                buttons:[],
                backgroundClose: true
            });
        }
    }
}
(function(document,window,$,console){
	function menuActions(data){
		//aqui se ejecutan las acciones aplicadas al menu
		console.log('menuActions');
		// console.log(data);
		var func,$this=data.that;
		switch(data.opc){
			case 'home':case 'timeline':case 'news': case 'trendings': case 'myOrders':
				func=function(){redir(PAGE[data.opc]);};
			break;
			case 'toptags'		:func=function(){redir(PAGE.toptags);};break;
			case 'store'		:func=function(){redir(PAGE.storePorduct);};break;
			case 'cart'			:func=function(){redir(PAGE.shoppingCart);};break;
			case 'wish'			:func=function(){redir(PAGE.storeOption);};break;
			case 'myPubli'		:func=function(){redir(PAGE.storeMypubli);};break;
			case 'freeP'		:func=function(){redir(PAGE.storeFreeProducts);};break;
			case 'myPartFreeP'	:func=function(){redir(PAGE.storeFreeProducts+'?module=myPartiFp');};break;
			case 'notif'		:func=function(){redir(PAGE.notify);};break;
			case 'friends'		:func=function(){redir(PAGE.userfriends+'?type=friends&id_user='+$.local('code'));};break;
			case 'friendsSearch':func=function(){redir(PAGE.findfriends);};break;
			case 'chat'			:func=function(){redir(PAGE.chat);};break;
			case 'videoUpload'	:func=function(){redir(PAGE.videoUpload);};break;
			case 'profile'		:func=function(){redir(PAGE.profile+'?id='+$.local('code'));};break;
			case 'profilepic'	:func=function(){redir(PAGE.profilepic);};break;
			case 'myGroup'		:func=function(){redir(PAGE.tagslist+'?current=group&id='+(data.group||$this.attr('group')));};break;
			case 'closedGroup'	:myDialog('#singleDialog','<sp>'+lan('GROUPS_CLOSE')+'</sp><br><sp>'+lan('MSGGROUPS_CLOSE')+'</sp>');break;
			case 'openGroup'	:func=function(){redir(PAGE.tagslist+'?current=group&id='+idGroup);};break;
			case 'otherGroup'	:menuGroupsClose(data.group||$this.attr('group'));break;
			case 'moreGroups'	:func=function(){redir(PAGE.groupslist+'?action='+(data.action||$this.attr('action')));};break;
			case 'logout'		:func=function(){logout();};break;
		}
		menuRun(func);
	}

	function putMenuOptions(){
		//aqui se montan los botones del menu
		var menu=
			'<ul id="main">'+
				'<li>'+
					'<div id="headerSearch" class="ui-input-search ui-shadow-inset ui-btn-corner-all ui-btn-shadow ui-icon-searchfield ui-body-c">'+
						'<form role="search" action="'+PAGE.search+'">'+
							'<input name="srh" type="search" class="ui-input-text ui-body-c" value="" onkeypress="return enterSubmit(event,this)" placeholder="'+lan('inputPlaceHolder')+'"/>'+
						'</form>'+
					'</div>'+
				'</li>'+
				'<li opc="videoUpload" onlyif="CORDOVA"><div>'+lan('video upload','ucw')+'</div><arrow/></li>'+
				'<li opc="timeline" ><img src="css/smt/home_.png"/><div>'+lan('TIMELINE_TITLE')+'</div><arrow/></li>'+
				'<li opc="toptags" ><img src="css/smt/topTags.png"/><div>'+lan('TOPTAGS_TITLE')+'</div><arrow/></li>'+
				'<li opc="news"><img src="css/smt/news.png"/><div>#'+lan('NEWS')+'</div><arrow/></li>'+
				'<li opc="trendings" ><img src="css/smt/on-fire.png"/><div>#'+lan('hot','ucw')+'</div><arrow/></li>'+
				'<li opc="notif" ><img src="css/smt/notifications.png"/><div>#'+lan('NOTIFICATIONS')+'</div><span class="push-notifications"></span><arrow/></li>'+
				//'<li class="separator"></li>'+
				'<li opc="friends"><img src="css/smt/friends.png"/><div>'+lan('friends','ucw')+'</div><arrow/></li>'+
				//'<li opc="friendsSearch"><img src="css/smt/friends.png"/><div>'+lan('friendSearh_title','ucw')+'</div><arrow/></li>'+
				(PRODUCCION?
					'<li opc="chat"><img src="css/smt/chat.png"/><div>'+lan('chat')+'</div><arrow/></li>'
				:'')+
				//'<li opc="profilepic"><img src="img/profile.png"/><div>'+lan('Profile Picture')+'</div><arrow/></li>'+
				'<li opc="profile"><img src="css/smt/profile.png"/><div>'+lan('profile')+'</div><arrow/></li>'+
				'<li goto="store"><img src="css/smt/store.png"/><div>'+lan('store')+'</div><span class="icon"></span></li>'+
				'<li style="display:none;" goto="groups"><img src="css/smt/group.png"/><div>#'+lan('MAINMNU_GROUPS')+'</div><span class="icon"></span></li>'+
				//'<li class="title"><img src="img/profile.png"/><div>Groups</div><span class="icon"/></li>'+
				//'<li goto="test"><div>test change menu</div><span class="icon"/></li>'+
				'<li opc="logout"><img src="css/smt/logout.png"/><div>'+lan('logout')+'</div><span class="icon"/></li>'+
			'</ul>'+
			'<ul id="store">'+
				'<li goback="main"><div>back to main</div><arrow/></li>'+
				'<li opc="store"><div>'+lan('store','ucw')+'</div><arrow/></li>'+
				'<li opc="myPubli"><div>'+lan('My publications','ucw')+'</div><arrow/></li>'+
				'<li opc="cart"><div>'+lan('shopping cart','ucw')+'</div><arrow/></li>'+
				'<li opc="wish"><div>'+lan('wish list','ucw')+'</div><arrow/></li>'+
				'<li opc="freeP"><div>'+lan('STORE_FREE_PRODUCTS')+'</div><arrow/></li>'+
				'<li opc="myPartFreeP"><div>'+lan('STORE_RAFFLES_PLAYS')+'</div><arrow/></li>'+
				'<li opc="myOrders"><div>'+lan('my orders','ucw')+'</div><arrow/></li>'+
			'</ul>'+
			//'<ul id="test">'+
			//	'<li goback="main"><div>back to main</div><arrow/></li>'+
			//'</ul>'+
			'';
		$('#menu .container').html(menu);
		$('#myMenu .container').html(menu);
		if(isLogged()&&!hideGroups) menuGroups($.local('code'));
		//out='<li goback="main"><div>'+lan('GROUPS_BACKMAIN')+'</div><arrow/></li>';
		//$('#menu .container').append('<ul id="groups">'+out+'</ul>');
	}
	var menuStatus;
	window.menuTime=300;//time for animation
	function hideMenu(){
		console.log('menu status='+(menuStatus?'visible':'hidden'));
		$('.ui-page-active').animate(
			{left:'0px'},menuTime,
			function(){
				if(menuStatus){
					console.log('hide menu');
					menuStatus=false;
					$('#menu').hide();
					$('.ui-page-active').css({position:''});
				}
			}
		);
	}
	function showMenu(){
		console.log('menu status='+(menuStatus?'visible':'hidden'));
		//cambiando cualquiero posible onclick por click
		$('#menu li[onclick]').each(function(){
			$(this).attr('click',$(this).attr('onclick'));
			$(this).removeAttr('onclick');
		});
		//evaluamos cada opcion para ver si debe ocultarse
		$('#menu [onlyif]').show().each(function(){
			var show=eval($(this).attr('onlyif'));
			if(!show) $(this).hide();
		});
		if(window.location.href.match(/[\/=](?:index|login|signup|resendPass)|\/app\/(?:\?|$)/i)){//disable menu
			$('.ui-page-active').css({left:'0px'});
			hideMenu();
		}else{
			if(!menuStatus){
				console.log('show menu');
				menuStatus=true;
				$('#menu').show();
				$('.ui-page-active').css({position:'fixed'});
			}
			$('.ui-page-active').animate(
				{left:'165px'},menuTime
			);
		}
	}
	function putMenu(){
		//monta la estructura del menu y las acciones aplicadas al mismo
		if($('#menu').length<1){
			$('body').prepend(
				'<div id="menu">'+
					'<div class="menu">'+
						'<div class="header">'+
							'<span>'+lan('MESSAGE_WELCOME')+',</span><br/><em>'+($.local('full_name')||'')+'</em>'+
							'<br><div id="userPoints" class="ui-btn-right" data-iconshadow="true" data-rapperels="span">'+
								'<span class="loader"></span>'+
							'</div>'+
						'</div>'+
						'<div class="container"></div>'+
//						'<ul id="logout">'+
//							'<li opc="logout"><img src="img/logout.png"/><div>'+lan('logout')+'</div><span class="icon"/></li>'+
//						'</ul>'+
					'</div>'+
					'<div class="overPage"/>'+
					'<div class="underPage"/>'+
				'</div>'
			);

			// Menu actions
			$('body')
				.on('pagebeforeshow','.ui-page',function(){console.log('beforeshow');hideMenu();})
				.on('swiperight','.ui-page-active .ui-header',function(){console.log('swipe right');if(isLogged()){showMenu();}})
				.on('swiperight','.myDialog',function(){console.log('swipe right in dialog');return false;})
				.on('swipeleft','#menu .overPage',function(){console.log('swipe left');hideMenu();})
				.on('click','#menu .overPage',function(){console.log('click to hide');hideMenu();})
				.on('click','.showMenu',function(){console.log('button showmenu');showMenu();});
			$('#menu').on('click','li',function(){
				var $li=$(this),
					active=$li.hasClass('active');
				$('#menu li').removeClass('active');
				if(!active&&!$li.hasClass('title')) $li.addClass('active');
			}).on('click','li[opc]',function(){
				menuActions({opc:$(this).attr('opc'),that:$(this)});
			}).on('click','li[click]',function(){
				var click=$(this).attr('click');
				hideMenu();
				setTimeout(function(){eval(click);},menuTime+100);
			}).on('submit','#headerSearch form',function(){
				$.loader('show');
			});
			$('#menu .container').on('click','li[goto]',function(){
				var $a=$(this).parent(),
					$b=$('#menu .container #'+$(this).attr('goto'));
				$b.css('left','166px').show();
				$a.animate(
					{left:'-166px'},menuTime,function(){$(this).hide();}
				);
				$b.animate(
					{left:'0px'},menuTime
				);
			}).on('click','li[goback]',function(){
				var $a=$(this).parent(),
					$b=$('#menu .container #'+$(this).attr('goback'));
				$b.css('left','-166px').show();
				$a.animate(
					{left:'166px'},menuTime,function(){$(this).hide();}
				);
				$b.animate(
					{left:'0px'},menuTime
				);
			});
			getUserPoints();
			hideMenu();
		}
	}
	function getUserPoints(){
		if (isLogged()){
			// $('#userPoints').html(lan('POINTS_USERS')+' <b><loader/></b>').css('font-weight', 'bold');
			$('#profile').on('click','span.info .points',function(){
			// $('#userPoints').click(function(){
				myDialog({
					id:'msg-points',
					open:true,
					content:
						'<p>'+lan('MAINMENU_POINTS_2')+'</p>'+
						'<p>'+lan('MAINMENU_POINTS_1')+'</p>',
					style:{
						'margin':10,
						'font-size':14
					}
				});
			});
			$.ajax({
				type	:'GET',
				url		:DOMINIO+'controls/users/getUserPoints.json.php',
				dataType:'json',
				success	:function(data){
					var datos='',pts='';
					pts=data.split(' ');
					//alert(pts[1]);
					if(pts[1]=='CONST_UNITMIL')
						datos=pts[0]+' K';
					else if(pts[1]=='CONST_UNITMILLON')
						datos=pts[0]+' M';
					else
						datos=data;
					$('span.info .points').html(datos+' Pts'); //Agregado V2 para los puntos
					// $('#userPoints b').html(datos);
				}
			});
		}
	}
	function menuRun(func){
		if(typeof func==='function'){
			hideMenu();
			setTimeout(func,menuTime+100);
		}
	}
	function menuGroups(code){
		code=code||$.local('code');
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/groups/menuGroupUser.json.php?action=1&code='+code,
			dataType:'json',
			success:function(data){
				if(data){
					$('#menu #main [goto=groups]').fadeIn();
					var i,group,out='<li goback="main"><div>'+lan('GROUPS_BACKMAIN')+'</div><arrow/></li>';
					if(data.myGroups){
						out+='<li class="title"><div>'+lan('GROUPS_MYGROUPS')+'</div><span class="icon"></span></li>';
						for(i in data.myGroups){
							group=data.myGroups[i];
							out+=
								'<li opc="otherGroup" group="'+md5(group.id)+'">'+
									'<div style="font-size:12px;padding-left:10px">'+group.name+'</div><span class="icon"></span>'+
								'</li>';
//							out+=
//								'<li opc="myGroup" group="'+md5(group.id)+'" >'+
//									'<div style="font-size:12px;padding-left:10px">'+group.name+'</div><span class="icon"></span>'+
//								'</li>';
						}
						out+='<li opc="moreGroups" action="3"><div style="font-size: 10px; padding-left: 65px">'+lan('GROUPS_MORE')+'</div></li>';
					}
					if(data.allGroups){
						out+='<li class="title"><div>'+lan('GROUPS_ALLGROUPS')+'</div><span class="icon"></span></li>';
						for(i in data.allGroups){
							group=data.allGroups[i];
							out+=
								'<li opc="otherGroup" group="'+md5(group.id)+'">'+
									'<div style="font-size: 12px; padding-left: 10px">'+group.name+'</div><span class="icon"></span>'+
								'</li>';
						}
						out+='<li opc="moreGroups" action="2"><div style="font-size: 10px; padding-left: 65px">'+lan('GROUPS_MORE')+'</div></li>';
					}
					$('#menu .container').append('<ul id="groups">'+out+'</ul>');
				}
			}
		});
	}
	function nameMenuGroups(idGroup,tag,func){
		var code=$.local('code');
		//alert(idGroup);
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/groups/menuGroupUser.json.php?action=4&idGroup='+idGroup+'&code='+code+'&tag='+tag,
			dataType:'json',
			success:func
		});
	}
	function menuGroupsClose(id){
		var code=$.local('code');
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/groups/menuGroupUser.json.php?action=5&idGroup='+id+'&code='+code,
			dataType:'json',
			success:function(data){
				if(data.out=='no'){
					menuActions({opc:'myGroup',group:id});
				}else{
					switch(data.out){
						case 'si':myDialog('#singleDialog','<sp>'+lan('GROUPS_CLOSE')+'</sp><br><sp>'+lan('MSGGROUPS_CLOSE')+'</sp>');break;
						case 'invit':myDialog({
											id:'#singleDialog',
											content:'<div style="text-align:center;"><sp>'+lan('INVITE_GROUP_TRUE')+'</sp><br>'+lan('CONFI_JOIN_TO_GROUPS')+'</div>',
											buttons:[{
												name:lan('yes'),
												action:function(){
													var obje=this,get='&accept=1';
													actionGroup(id,7,get,obje);
												}
											},{
												name:'No',
												action:function(){
													var obje=this,get='';
													actionGroup(id,7,get,obje);
												}
											}]
										});
							break;
						case 'pend':myDialog('#singleDialog','<sp>'+lan('GROUPS_CLOSE')+'</sp><br><sp>'+lan('MSGGROUPS_CLOSE_INVI_SED')+'</sp>');break;
					}
				}
			}
		});
	}
	function actionGroup(id,action,get,obje){
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/groups/actionsGroups.json.php?action='+action+'&grp='+id+get,
			dataType:'json',
			error:function(/*resp,status,error*/){
				myDialog('#singleDialog',lan('conectionFail'));
			},
			success:function(data){
				if(data.accept=='true'){
					menuActions({opc:'myGroup',group:id});
				}else if(data.accept=='false'){

				}
				obje.close();
			}
		});
	}
	function newMenuAction(menuInstance, show){
		// show = show||true;
		var positionY = 0, defaultAnimation1 = {rotate: '-180deg'}, defaultAnimation2 = {  borderSpacing: 0 };
		if (!show) {
			positionY = -114;
			// defaultAnimation1 = {rotate: '0deg'};
			defaultAnimation2 = {  borderSpacing: 180 };
		}
		$(menuInstance).animate({bottom: positionY},500);
    	// if(show) $(menuInstance).find('div.arrow').animate(defaultAnimation1,200);
    	$(menuInstance).find('div.arrow').animate(defaultAnimation2, {
		    step: function(now,fx) {
		      $(this).css('-webkit-transform','rotate('+now+'deg)'); 
		      $(this).css('-moz-transform','rotate('+now+'deg)');
		      $(this).css('transform','rotate('+now+'deg)');
		    },
		    duration:'slow'
		},'linear');
	}
	$(function(){
		getUserPoints();
		putMenu();
		putMenuOptions();
		// Menu actions design V2
		var statusMenu = false;
		$("#bottom-menu").on('click', function(event) {
			statusMenu = !statusMenu;
			newMenuAction(this,statusMenu);
		});
		$("#bottom-menu").swipe( {
	        swipeUp:function(event, direction, distance, duration, fingerCount, fingerData) {
	        	statusMenu = !statusMenu;
	        	newMenuAction(this,statusMenu);
	        },threshold:0,
	        swipeDown:function(event, direction, distance, duration, fingerCount, fingerData) {
	        	statusMenu = !statusMenu;
	        	newMenuAction(this,statusMenu);
	        },threshold:0
        });
        //END Menu actions design V2
	});
	window.showMenu=showMenu;
	window.hideMenu=hideMenu;
	window.menuVisible=function(){return menuStatus;};
	window.putMenuOptions=putMenuOptions;
	window.nameMenuGroups=nameMenuGroups;
	window.menuGroupsClose=menuGroupsClose;
})(document,window,jQuery,console);

(function(window,$){
	var width,height,fheight,dialog_h;
	function setSize(){
		width=$(window).width();
		height=$(window).height()-1;
		fheight=10;
		dialog_h=height-110;
		$(window).trigger('windowchange',{width:width,height:height});
	}
	window.windowFix=function(){
		$('.ui-page-active .ui-content').css('min-height',height-90-fheight);
		$('.tags-list').css('min-height',$(window).height()-50);
		$('.wrapper').css('max-height',height-200);
		$('.myDialog .window').css('max-height',dialog_h);
		$('.myDialog').each(function(){
			//console.log('dialog buttons height='+$('.buttons a',this).length*42);
			$('.container',this).css('max-height',dialog_h-$('.buttons',this).height());
		});
		//tag
		$('.tags-list,.tag-solo').each(function(){//escala de la tag
			var twidth=$(this).width();//ancho menos el margen lateral
			if(twidth>650) twidth=650;
//			alert((twidth/650)+'em');
			$(this).css({'font-size':(twidth/650)+'em'});
		});
		$('.smt-tag,.smt-tag-bg,.tag-loading').each(function(){//escala de la tag
			var width=$(this).width(),rel=width/650,height=width*300/650;
			$(this).css({'max-height':height,'height':height})
				.find('.tag-icons').css({'padding':Math.round(20*rel)+'px '+Math.round(25*rel)+'px'})
				.find('img').css({'width':Math.round(29*rel)+'px'});
		});
		//$('.search-all-none').width(width-300);
	};
	setSize();
	$(function(){
//		var actions=[ 'pageshow' ];
		if(is.device){
			$(window).bind('orientationchange',function(){
				setSize();
				windowFix();
				setTimeout(function(){
					setSize();
					windowFix();
				},300);
			});
			$(window).bind('resize',function(){
				if($(window).height()-1>height){
					setSize();
					windowFix();
				}
			});
		}else{
			$(window).bind('resize',function(){
				setSize();
				windowFix();
			});
		}
	});
})(window,jQuery);

//-- Scroll Simple (sin uso de iScroll) --//
$(function(){
	var scrollPosX,scrollPosY;
	if(navigator.userAgent.match(/android 2/i)){
		$('body').on('touchstart','.scroll,.scroll-x,.scroll-y',function(){
			event.preventDefault();
			scrollPosX=this.scrollLeft+event.touches[0].pageX;
			scrollPosY=this.scrollTop+event.touches[0].pageY;
		}).on('touchmove.scrolly','.scroll,.scroll-y',function(){
			event.preventDefault();
			this.scrollTop=scrollPosY-event.touches[0].pageY;
		}).on('touchmove.scrollx','.scroll,.scroll-x',function(){
			event.preventDefault();
			this.scrollLeft=scrollPosX-event.touches[0].pageX;
		});
	}
});

function $ifnot(id,type,container){//si el elemento no existe lo crea, del tipo especificado, dentro del container
	if(!id) return null;
	if(id.charAt(0)=='#') id=id.substr(1);
	if($('#'+id,container||'body').length<1)
		$(container||'body').append('<'+(type||'div')+' id="'+id+'"/>');
	return $('#'+id,container||'body').last();
}

function includePage(){
	var thisPage=$.session('page')||arrayGet().page;
	$.cookie('page',null);
	var that=pages[thisPage];
	if(that){
		console.log(thisPage+' loading...');
		document.title=that.title;
		$('#new-page').attr('id',that.id);
		var page=readTxt(that.url);
		//$('#'+that.id).html(page);
		$(page).appendTo('#'+that.id);
		//$('#'+that.id).page();
	}
}

//Esta linea permite cargar el contenido de las funciones localizadas en el server.
//eval(readTxt(DOMINIO+"controls/mobile/funciones.js.php"));

//-- Reconfiguracion de ajax jQuery --//
(function(window,$,console){
	var numCalls=0;
	$(document).ajaxSend(function(e,xhr,opc){
		if(opc.loader!==false&&numCalls++<1)$.loader('show');
	}).ajaxComplete(function(e,xhr,opc){
		if(opc.loader!==false&&--numCalls<1)$.loader('hide');
	});
	window.myAjax=function(opc,more){
		if(offline){
			myDialog('#errorDialog',lan('noConnection'));
			return null;
		}
		if(more!==undefined){
			more.url=opc;
			opc=more;
		}
		//if($.local('host')) opc.url+=(opc.url.match(/\?/)?'&':'?')+'cors='+document.location.origin;
//		if($.local('enableLogs')&&!opc.noLog&&opc.log!==false){
		if($.local('enable_console')&&!opc.noLog&&opc.log!==false){
			var log={url:opc.url},s=opc.success,c=opc.complete;//,e=opc.error;
			if(opc.data) log.data=$.extend({},opc.data);
			if(opc.type&&opc.type.match(/get/i)) opc.type='post';
			opc.success=function(data){
				log.success=data;
				if(typeof s==='function') s.call(this,data);
			};
//			opc.error=function(jqXHR,textStatus,errorThrown){
//				log.error={jqXHR:jqXHR,textStatus:textStatus,errorThrown:errorThrown,errorMsg:jqXHR.responseText};
//				if(typeof e==='function') e(jqXHR,textStatus,errorThrown);
//			};
			opc.complete=function(jqXHR,textStatus){
				log.complete={jqXHR:jqXHR,textStatus:textStatus,response:jqXHR.responseText};
				console.log(log);
				if(typeof c==='function') c.call(this,jqXHR,textStatus);
			};
		}
		return $.ajax(opc);
	};
})(window,jQuery,console);

function colorSelector(picker,inputField){
	var $picker=$('#'+picker);
	$picker.hide().farbtastic('#'+inputField);
	$('#'+inputField).addClass('colorSelector')
	.click(function(){$picker.show('slow');})
	.blur(function(){$picker.hide('slow');});
}

function showTag(tag){//individual tag
	var btn=tag['btn']||{};
	var btnSponsor='',hash='',paypal='prueba';
	if(tag['hashTag']){
		var i,hashS='';
		for(i=0;i<tag['hashTag'].length;i++)
			hashS+='<a href="#" hashT="'+tag['hashTag'][i]+'">'+tag['hashTag'][i]+'</a>&nbsp;&nbsp;';
		hash='<div class="clearfix"></div><div class="tag-hash">'+hashS+'</div>';
	}
	return(
	'<div tag="'+tag['id']+'" udate="'+tag['udate']+'">'+
		'<div class="minitag" style="background-image:url('+tag['imgmini']+')"></div>'+
		'<div class="tag" style="background-image:url('+tag['img']+')"></div>'+
		'<div class="bg"></div>'+
			(isLogged()?
		'<div id="panel"><menu>'+
			'<ul>'+
				'<li id="other-options">...'+
					'<div class="sub-menu-tag"><ul style="display:none;">'+
						(tag['uid']?
						'<li id="users" users="'+tag['uid']+'"><span>profile</span></li>':'')+
						(btn['redist']?
						'<li id="redistr" title="Redist"><span>Redist</span></li>':'')+
						btnSponsor+(btn['trash'] && tag.type != 'out'?
						'<li id="trash" title="Trash"><span>Trash</span></li>':'')+
						(tag['typeVideo']?
						'<li id="'+tag['typeVideo']+'" vUrl="'+tag['video']+'"><span>video</span><a href="'+tag['video']+' target="_blank" style="display:none"></a></li>':'')+
						(tag['product']?
						'<li id="qrcode" title="product" p="'+tag['product']['id']+'"><span>Product</span></li>'
						:'')+
						(btn['report']?
							'<li id="report" title="Report"><span>Report</span></li>'
						:'')+
					'</ul></div>'+
				'</li>'+
				(btn['share']?
					'<li id="share" title="Share"><span>Share</span></li>'
				:'')+(!tag['popup']?
					'<li id="comment" title="Comment"><span>Comment</span></li>'
				:'')+
				'<li id="like" title="Like"><div>'+tag.num_likes+'</div></li>'+
				'<li id="dislike" title="Dislike"><div>'+tag.num_disLikes+'</div></li>'+
			'</ul>'+hash+
		'<div class="clearfix"></div></menu></div>'
		:'<div id="menuTagnoLogged"></div>')+
		'<div class="tag-icons">'+
			'<div id="sponsor" '+(tag['sponsor']?'':'style="display:none;"')+'></div>'+
			'<div id="redist" '+(tag['redist']?'':'style="display:none;"')+'></div>'+
			'<div id="likeIcon" '+(tag['likeIt']>0?'':'style="display:none;"')+'></div>'+
			'<div id="dislikeIcon" '+(tag['likeIt']<0?'':'style="display:none;"')+'></div>'+
		'</div>'+
		// '<div class="tag-counts">'+
		// 	'<div id="likeIcon"></div><span>'+tag.num_likes+'</span>'+
		// 	'<div id="dislikeIcon"></div><span>'+tag.num_disLikes+'</span>'+
		// '</div>'+
		(tag['rid']?'<div class="redist"><div>'+lan('TXT_REDISTBY')+tag['name_redist']+'</div></div>':'')+
		((tag['product']||tag['typeVideo'])?
			'<div class="extras"><div>'+
				(tag['typeVideo']?
					'<span class="'+tag['typeVideo']+'"></span>'
				:'')+
			'</div></div>'
		:'')+
	'</div>'
	);
}

function mskPoints(num){
	//if(num<20000000){
		num = num+'';
		var len=num.length;
		if(num>=999&&len<7)
			return Math.round((num/1000),2)+'K';
		if(len>=7&&len<10)
			return Math.round((num/1000000),1)+'M';
		if(len>=10&&len<13)
			return Math.round((num/1000000000),1)+'G';
		if(len>=13&&len<16)
			return Math.round((num/1000000000000),1);
		if(len>=16&&len<20)
			return Math.round((num/1000000000000000),1);
		return num;
	//}
	//return 0;
}

function showTags(array,type){//tag list
	var i,tags='';
	for(i in array){
		array[i].type=type;
		tags+=showTag(array[i]);
	}
//		tags+='<div class="tag-loading smt-container"><div class="smt-content" style="z-index:4;">Loading...</div></div>'+showTag(array[i]);
	return '<div class="tag-container">'+tags+'</div>';
}
function bigLike(tagId, icon){
	$('#big-like').remove();
	$('[tag='+tagId+']').append('<div id="big-like"></div>');
	$('#big-like').addClass((icon == 'dislike' ? 'rotated': '' )).animate({
		'background-size': '15%',
		'-webkit-background-size': '15%',
		'opacity': 0.2},
		2000, function() {
		$(this).remove();
	});
}
function actionsTags(layer, forceComments){
	forceComments = forceComments || false;
	if(isLogged()){
		$(layer).doubletap('[tag] > .bg', function(e){
			var tagId = $(e.currentTarget).parents('[tag]').attr('tag');
			bigLike(tagId,'like');
			playLike(tagId,'likeIcon','dislikeIcon',forceComments);
		});
		$(layer).on('click', 'menu li', function(e){
			if ($(e.target).hasClass('canceled')) return false;

			var tagId = $(e.target).parents('[tag]').attr('tag');
			var actionId = e.target.id || $(e.target).parent('li').attr('id');
			switch(actionId){
				// case 'report':redir(PAGE['reporttag']+'?id='+tagId);break;
				case 'report':
					myDialog({
						id:'#reportTag-dialog',
						content: '<h3>'+lang.reportTagTitle+'</h3><div id="txt1" style="margin-top: 15px;">'+lang.MNUTAGREPORT_TEXT1+'</div>'+
								 '<div id="txt2" style="margin-top: 15px;">'+lang.MNUTAGREPORT_TEXT2+'</div>'+
								 '<div style="margin-top: 15px; margin-bottom: 30px;">'+
									'<label id="txt3"><strong>'+lang.ACTIONSTAGS_REPORTTAG_TITLESELECT+'</strong></label>'+
									'<div style="margin-top: 10px;">'+
										'<select id="selectReport" name="selectReport">'+
											'<option value="" selected id="selectReportFirst"></option>'+
										'</select>'+
									'</div>'+
								'</div>',
						after:function(){
			            	myAjax({
								type	: 'POST',
								url		: DOMINIO+'controls/tags/getTag.json.php?getReportCombo=A',
								dataType: 'json',
								success	: function( data ) {
									// Combo Month
									for(var x='',i=0; i<data.length; i+=2) {
										x += '<option value="' + data[i] + '">' + data[i+1] + '</option>';
									}
									$('#selectReport').html(x);
								}
							});
			            },
			            backgroundClose:true,					
						buttons:[{
							name:lang.report,
							action:function(){
								var firstDialog = this;
								myAjax({
									type	: 'POST',
									url		: DOMINIO+'controls/tags/actionsTags.controls.php?action=8&tag='+tagId+'&type_report='+md5($('#selectReport option:selected').val()),
									dataType: 'html',
									success	: function (data){
										firstDialog.close();
										myDialog({
											id:'#singleRedirDialogReport',
											content:data,
											buttons:{ 
												Ok:function(){redir(PAGE['timeline']);}
											}
										});
									}
								});
							}
						}]
					});
				break;
				case 'share':redir(PAGE['sharetag']+'?id_tag='+tagId);break;
				case 'comment':
					tagId = $(e.target).parents('[tag]').attr('tag');
					$(e.target).addClass('canceled');
					playComment(tagId);
				break;
				case 'like':case 'dislike':
					//$(e.target).addClass('canceled');
					bigLike(tagId, actionId);
					var that=actionId+'Icon',
						show=actionId!='like'?'likeIcon':'dislikeIcon';
						playLike(tagId,that,show);
				break;
				case 'redistr':
					myAjax({
						type:'POST',
						url:DOMINIO+'controls/tags/actionsTags.controls.php?action=3&tag='+tagId,
						dataType:'html',
						loader: false,
						success:function( data ){
							afterAjaxTags(data, tagId,'menu #redistr', '.tag-icons #redist');
						}
					});
				break;
				case 'trash':
					myDialog({
						id:'#singleRedirDialog',
						content:lan('JS_DELETETAG'),
						loader: false,
						buttons:[{
							name:lan('yes'),
							action:function(){
								var dialog = this;
								myAjax({
									type: 'POST',
									url: DOMINIO+'controls/tags/actionsTags.controls.php?action=6&tag='+tagId,
									dataType: 'html',
									success: function( data ) {
										$('[tag='+tagId+']').fadeOut('fast',function(){
											$(this).remove();
											dialog.close();
										});
									}
								});
							}
						},{
							name:'No',
							action:'close'
						}]
					});
				break;
				case 'youtube': case 'vimeo': 
						var video=$(e.target).attr('vUrl');
					if(openVideo){
						openVideo(video,'#popupVideo');
					}else{ 
						window.open(video,"_blank"); 
						// $(e.target).find('a').click(); 
					}
				break;
				case 'local': 
					var wi=$(e.target).parents('.tag-container').css('font-size'),video=$(e.target).attr('vUrl');
					if (wi.indexOf('px')!=-1){
						wi=(wi.replace('px','')*1)/2;
						wi=wi+'px';
					}else{
						wi=(wi.replace('em','')*1)-0.20;
						wi=wi+'em';
					}
					myDialog({
						id:'#singleVideoDialog',
						content:'<div class"tag-solo" style="font-size:'+wi+'"><div class="tag-container" style="margin:0 auto;"><div tag><div class="video"><div class="placa"></div>'+
									'<video id="v'+Math.random()+'" controls autoplay preload="metadata"><source src="'+video+'" type="video/mp4"/></video>'+
									'</div></div></div><div class="clearfix"></div></div>',
						buttons:[{
							name:'Ok',
							action:function(){
								var di=this;
								$('#singleVideoDialog video').each(function(index, el) {
									this.pause();
									this.src="";
								});
								di.close();
							}
						}]
					});
				break;
				case 'users': redir(PAGE['profile']+'?id='+$(e.target).attr('users')); break;
				case 'qrcode': redir(PAGE['detailsproduct']+'?id='+$(e.target).attr('p')); break;
			}
		}).on('click','.this_seemore',function(){
			$(this).parents('li.more').removeClass('more');
		}).on('click','div.tag-hash',function(){
			$(this).addClass('tag-hash-complete');
			var vector=$('a[hashT]',this);
			$.each(vector,function(key,value){
				$(this).attr('hash',$(this).attr('hashT')).removeAttr('hashT');
			});
		}).on('click','a[hash]',function(){//tag-hash-complete
			redir(PAGE['search']+'?srh='+$(this).attr('hash').replace('#','%23').replace('<br>',' '));
		})
	}
}
function afterAjaxTags(data, tagId, toHide,toShow){
	//console.log('tagID:'+tagId+'--'+toHide+'--'+toShow);
	if((typeof data == 'boolean' && data) || data.indexOf('ERROR')<0){
		$('[tag='+tagId+']').find(toHide).fadeOut('slow',function(){
			$('[tag='+tagId+']').find(toShow).fadeIn('slow');
		});
	}
}
function playLike(tagtId,that,show,comment){
	afterAjaxTags(true,tagtId,'.tag-icons #'+show,'.tag-icons #'+that);
	myAjax({
		type:'POST',
		url:DOMINIO+'controls/tags/actionsTags.controls.php?this_is_app&action='+(that=='likeIcon'?4:11)+'&tag='+tagtId,
		dataType:'json',
		loader: false,
		success:function(data){
			// if (data['success']=='likes') afterAjaxTags(data['success'], tagtId, 'menu #like', 'menu #dislike');
			// else afterAjaxTags(data['success'], tagtId,'menu #dislike', 'menu #like');
			$('#numDislikes').html(data['dislikes']); $('#numLikes').html(data['likes']);
			// $('[tag='+tagtId+'] .tag-counts').find('#dislikeIcon+span').html(data['dislikes']); $('[tag='+tagtId+'] .tag-counts').find('#likeIcon+span').html(data['likes']);
			// $('[tag='+tagtId+'] menu').find('#dislike').html(data['dislikes']); $('[tag='+tagtId+'] menu').find('#like').html(data['likes']);
			$('[tag='+tagtId+'] menu').find('#dislike').html('<div>'+data.dislikes+'</div>');
			$('[tag='+tagtId+'] menu').find('#like').html('<div>'+data.likes+'</div>');
			if (!comment && $('[tag='+tagtId+']').find('#comments').length == 0 ) {
				playComment(tagtId);
			}
		}
	});
}
function playComment(tagtId, opc){
	var defaults = {
		layer:'#comments',
		scroller:'.fs-wrapper',
		data:{
			type:4,
			source:tagtId,
			limit:4,
			mobile:1
		}
	};
	var options = opc || defaults;
	if ($('[tag='+tagtId+']').find(options.layer).length > 0) {
		$('#tagsList').off('keydown', '#commenting');
		//window.clearInterval(interval);
		$(options.layer).remove();
	}else{
		$(options.layer).remove();
		$('[tag='+tagtId+']').find('#panel').append(
				'<ul id="comments" style="display:none;" data-role="listview" data-inset="true" class="tag-comments ui-listview list" data-divider-theme="e"></ul>'
		);
		$(options.layer).listview();
		getComments('reload',options);
		// var interval=setInterval(function(){
		// 	if ( $(options.layer).length>0 ) getComments('refresh',options);
		// },20000);
	}
	$('[tag='+tagtId+']').find('menu #comment').removeClass('canceled');

	$('#tagsList, #page-tag').on('click', '#send-comment', function(e) {
		options.data.source = $(e.target).parents('[tag]').attr('tag');
		//alert(options.data.source)
		var comment=$.trim($('#commenting').val());
		if(comment!=''){
			$('#commenting').val('');
			insertComment(comment,options);
		}
		return false;
	}).on('click',options.layer+' div.seemore',function(){
		getComments('more',options);
	});
}
(function(window,$,console){
	window.updateTags=function(action,opc,loader){
		if(!opc.on) opc.on={};
		console.log(opc)
		var act,
			current=opc.current,
			on=opc.on,
			layer=opc.layer,
			get=opc.get||'',
			limit=opc.limit||'15',
			notag=opc.notag||lan('EMPTY_TAGS_LIST'),
			//se cancela la action si no hay current o si se esta ejecutando reload
			cancel=function(){return !current||opc.current!=current||(action!='reload'&&on.reload);},
			//se asigna y/o devuelve el estatus de la accion actual
			onca=function(val){if(val!==undefined)on[action]=val;return on[action];};
		if(!cancel()&&!onca()){
			onca(true);
			if(!opc.actions||action=='reload'){
				opc.actions={refresh:{},more:{}};
				opc.date='';
			}
			act=opc.actions[action=='refresh'?'refresh':'more'];
			if(loader) $.loader('show');
			//si no hay mas tag, se cancela la consulta
			if(act.more===false){
				return onca(false);
			}
			myAjax({
				type:'GET',
				dataType:'json',
				loader:true,
				data:act||{},
				url:DOMINIO+'controls/tags/tagsList.json.php?this_is_app&limit='+limit+'&current='+current+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
				success:function(data){
					if(cancel()){
						console.log('Cancelada carga de '+current+'.'); return;
					}else{
						if(action=='reload'){$(layer).html('');}
						if (action=='reload' && opc.title && data.rtitle) $('#rowTitleMove ul li.nameOwner').append(': '+data.rtitle);
						if(action=='more'&&(!data.tags||data.tags.length<1)) act.more=false;
						if(data.tags && data.tags.length>0){
							opc.date=data.date;
							if(data.sp) act.sp=data.sp;
							var tags='',i,len=data.tags.length,$tag,$remove,sp;
							if(data.sponsors) sp=data.sponsors.length;
							else sp=0;
							act.start=(act.start||0)+data.tags.length-sp;
							act.startsp=(act.startsp||0)+sp;
							act.idsponsor=data.idsponsor;
							for(i=0;i<len;i++){
								$tag=$(layer).find('[tag="'+data.tags[i].id+'"]');
								if($tag.length>0)
									if($remove) $remove.add($tag); else $remove=$tag;
							}
							tags+=showTags(data.tags,opc.type);
							if($remove) $remove.remove();
							if(action=='more')
								$(layer).append(tags);
							else
								$(layer).prepend(tags);
						}else if(action=='reload'){
							$(opc.layer).html(
								'<div><div class="tag-loading smt-container" style="max-height:300px;height:300px;"><div id="noTags" class="smt-content" style="z-index:4;">'+notag+'</div></div><div class="smt-tag"><img src="css/newdesign/placaFondo.png" class="tag-img" style="z-index:3;"></div></div>'+
									'<a href="newtag.html" id="noresult-tags" style="text-decoration: none;">'+
									'<button data-role="button" data-theme="f"  class="ui-btn"  data-icon="plus" data-iconpos="right">'+
										lan("Creates a tag")+
									'</button></a>'
							);
							$('#noresult-tags button').button();
							// $('#noresult-tags').click(function(){ redir(PAGE['newtag']); });
							if(current=='group'){
								verifyGroupMembership(opc.id,opc.code,function(data){
//									alert(opc.code);
									if(data.isMember){
										$('#noTags').html(lan('GROUPS_MESSAGE_TAGS'));
									}else{
										$('#noTags').html(lan('GROUPS_MESSAGE_TAGS')+' '+lan('GROUPS_MESSAGE_JOIN'));
									}
								});
							}
						}
					}
				},
				complete:function(){
					if(loader) $.loader('hide');
					onca(false);
					windowFix();
					$.jScroll('refresh');
				}
			});
			return true;
		}
		return false;
	};
	var on={};
	window.updateTagsOld=function(action,opc){
		var act,
			current=opc.current,
			layer=opc.layer,
			get=opc.get||'',
			limit=opc.limit||'15',
			cancel=function(){return !current||(action!='reload'&&on.reload);},//cancel action
			onca=function(val){if(val!==undefined)on[action]=val;return on[action];};//on current action
		if(!cancel()&&!onca()){
//			console.log('runing updateTags');
			onca(true);
			if(!opc.actions||action=='reload'){
				opc.actions={refresh:{},more:{}};
				opc.date='';
				$(layer).html('');
				$.loader('show');
			}
			act=opc.actions[action=='refresh'?'refresh':'more'];
			//si no hay mas tag, se cancela la consulta
			if(act.more===false){
				$.jScroll('refresh');
				return onca(false);
			}
			myAjax({
				data:act||{},
				url:DOMINIO+'controls/tags/tagsList.json.php?this_is_app&current='+current+'&limit='+limit+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
				success:function(data){
					if(action=='more'&&(!data.tags||data.tags.length<1)) act.more=false;
					if(!cancel()){
						if(data.tags&&data.tags.length>0){
							opc.date=data.date;
							if(data.sp) act.sp=data.sp;
							var tags='',i,len=data.tags.length,$tag,sp,$remove;
							if(data.sponsors) sp=data.sponsors.length;
							else sp=0;
							act.startsp=(act.startsp||0)+sp;
							act.start=(act.start||0)+data.tags.length-sp;
							act.idsponsor=data.idsponsor;
							for(i=0;i<len;i++){
								$tag=$(layer).find('[tag="'+data.tags[i].id+'"]');
								if($tag.length>0)
									if($remove) $remove.add($tag); else $remove=$tag;
							}
							tags+=showTags(data.tags);
							if($remove) $remove.remove();
							if(action=='more'){
								console.log(current+"=more");
								$(layer).append(tags);
							}else{
								console.log(current+"!=more");
								$(layer).prepend(tags);
							}
						}else if(action=='reload'){
							$(opc.layer).html(
								'<div><div class="tag-loading smt-container" style="max-height:300px;height:300px;"><div id="noTags" class="smt-content" style="z-index:4;">'+lan('EMPTY_TAGS_LIST')+'</div></div><div class="smt-tag"><img src="../img/placaFondo.png" class="tag-img" style="z-index:3;"></div></div>'
							);
							if(current=='group'){
								verifyGroupMembership(opc.id,opc.code,function(data){
//									alert(opc.code);
									if(data.isMember)
										$('#noTags').html(lan('GROUPS_MESSAGE_TAGS'));
									else
										$('#noTags').html(lan('GROUPS_MESSAGE_TAGS')+' '+lan('GROUPS_MESSAGE_JOIN'));
								});
							}
						}
					}
				},
				complete:function(){
//					if(opc.older<0)
//						$(opc.layer).parent().parent().find('#pullUp').hide();
//					else
//						$(opc.layer).parent().parent().find('#pullUp').show();
					windowFix();
					$.jScroll('refresh');
					if(action=='reload'&&opc.current==current) $.loader('hide');
					console.log(opc);
					on[action]=false;
				}
			});
			return true;
		}
		return false;
	};
})(window,jQuery,console);

function bodyFriendsList(friend, temp){
	temp = temp || 'a';
	// if (friend.conocido) var te="a",text=lan('unfollow');
	// else var te="e",text=lan('follow');
	var known = (friend.conocido)?1:0;
	//console.log('Resultado bodyFriendsList:'+friend.conocido);
	//console.log(friend);
	if(friend.follower > 0){
		//console.log('Si lo sigo');
		known = 1;
	}else{
		//console.log('No lo sigo');
		known = 0;
	}

	var out='<li '+(friend.iAm=="0"?'thisshow="1" ':'')+'class="userInList ui-block-'+temp+'" data-known="'+known+'" data-link="'+friend.code_friend+'" data-unlink="'+md5(friend.id)+'" data-role="fieldcontain" data-usrname="'+friend.name_user+'" >'+
		'<a '+(friend.iAm=="0"?'':'code="'+friend.code_friend+'"')+' data-theme="e">'+
			'<img src="'+friend.photo_friend+'"'+'class="userBR" width="60" height="60"/>'+
			'<h3 class="ui-li-heading">'+friend.name_user+'</h3>'+
			// '<p class="ui-li-desc">'+
			// 	lan('friends','ucw')+' <span class="ufriends">('+(friend.friends_count||0)+'),</span>  '+
			// 	lan('admirers','ucw')+' <span class="ufollowers">('+(friend.followers_count||0)+'),</span>  '+
			// 	lan('admired','ucw')+' <span class="ufollowing">('+(friend.following_count||0)+')</span> '+
			// '</p>'+
		'</a>'+
	'</li>'; //la maquetacion de este li se hizo con el jquerymobile ya cargado
	// (friend.iAm=="0"?'<div class="" style="display: none;">'+
	// 	'<fieldset class="ui-grid-a">'+
	// 		'<div class="ui-block-a">'+
	// 			'<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="d" data-disabled="false" class="ui-submit ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all" aria-disabled="false">'+
	// 				'<span class="ui-btn-inner"><span class="ui-btn-text">'+lan('USER_PROFILE')+'</span></span>'+
	// 				'<button code="'+friend.code_friend+'" type="submit" data-theme="d" class="ui-btn-hidden" data-disabled="false">'+lan('USER_PROFILE')+'</button>'+
	// 			'</div>'+
	// 		'</div>'+
	// 		'<div class="ui-block-b">'+
	// 			'<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="'+te+'" data-disabled="false" class="ui-submit ui-btn ui-shadow ui-btn-corner-all ui-btn-up-'+te+'" aria-disabled="false">'+
	// 				'<span class="ui-btn-inner"><span class="ui-btn-text">'+text+'</span></span>'+
	// 				'<button type="b" data-theme="'+te+'" userlink="'+md5(friend.id)+'" class="ui-btn-hidden" data-disabled="false">'+text+'</button>'+
	// 			'</div>'+
	// 		'</div>'+
	// 	'</fieldset>'+
	// '</div>':'');
	return out;
}

function bodyFriendsList2(friend){
	var known = (friend.conocido)?1:0;
	//console.log('Resultado bodyFriendsList2:'+friend.conocido);
	if (friend.conocido) var te="a",text=lan('unfollow');
	else var te="e",text=lan('follow');
	if(friend.follower > 0){
		//console.log('Si lo sigo');
		te="a";
		known = 1;
		text=lan('unfollow');
	}else{
		//console.log('No lo sigo');
		known = 0;
		te="e";
		text=lan('follow');
	}	
	var out='<li '+(friend.iAm=="0"?'thisshow="1" ':'')+'class="userInList" data-role="fieldcontain" '+
		'data-icon="info"  data-known="'+known+'" data-usrname="'+friend.name_user+'" >'+
		'<a '+(friend.iAm=="0"?'':'code="'+friend.code_friend+'"')+' data-username="'+friend.name_user+'" data-theme="e" class="ulbox">'+
			'<img src="'+friend.photo_friend+'"'+'class="ui-li-thumb userBR" width="60" height="60"/>'+
			'<h3 class="ui-li-heading">'+friend.name_user+'</h3>'+
			'<p class="ui-li-desc">'+
				lan('friends','ucw')+' <span class="ufriends">('+(friend.friends_count||0)+'),</span>  '+
				lan('admirers','ucw')+' <span class="ufollowers">('+(friend.followers_count||0)+'),</span>  '+
				lan('admired','ucw')+' <span class="ufollowing">('+(friend.following_count||0)+')</span> '+
			'</p>'+
		'</a>'+
	'</li>'+ //la maquetacion de este li se hizo con el jquerymobile ya cargado
	(friend.iAm=="0"?'<li class="ui-body ui-body-b" style="display: none;">'+
		'<fieldset class="ui-grid-a">'+
			'<div class="ui-block-a">'+
				'<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="d" data-disabled="false" class="ui-submit ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all" aria-disabled="false">'+
					'<span class="ui-btn-inner"><span class="ui-btn-text">'+lan('USER_PROFILE')+'</span></span>'+
					'<button code="'+friend.code_friend+'" type="submit" data-theme="d" class="ui-btn-hidden" data-disabled="false">'+lan('USER_PROFILE')+'</button>'+
				'</div>'+
			'</div>'+
			'<div class="ui-block-b">'+
				'<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="'+te+'" data-disabled="false" class="ui-submit ui-btn ui-shadow ui-btn-corner-all ui-btn-up-'+te+'" aria-disabled="false">'+
					'<span class="ui-btn-inner"><span class="ui-btn-text">'+text+'</span></span>'+
					'<button type="b" data-theme="'+te+'" userlink="'+md5(friend.id)+'" class="ui-btn-hidden" data-disabled="false">'+text+'</button>'+
				'</div>'+
			'</div>'+
		'</fieldset>'+
	'</li>':'');
	return out;
}

function viewFriends(method, opc){
	console.log('viewfriends');
	if(!opc.post) opc.post={};
	opc.get=opc.get||'';
	opc.post.uid=opc.user;
	myAjax({
		type:'POST',
		url:DOMINIO+'controls/users/people.json.php?nosugg&action=friendsAndFollow&code&mod='+opc.mod+opc.get,
		data:opc.post,
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success:function(data){
			if (data.error) return;
			var i,friend,out='',divider,count='';//' <span class="ui-li-count">'+data.num+'</span>';
			// if($.local('code')==opc.user){
			count = data.num;
			switch(opc.mod){
				case 'friends':divider=lan('friends','ucw');break;
				case 'follow':divider=lan('admirers','ucw');break;
				case 'unfollow':divider=lan('admired','ucw');break;
				case 'find':
					if(opc.divider){
						divider=opc.divider;
					}else{
						divider=lan('FINDFRIENDS_LEGENDOFSEARCHBAR','ucw');
						count='';
					}
				break;
			}
			// }
			divider=!opc.noCount?'<li data-role="list-divider">'+divider+(count!=''?' ('+count+')':'')+'</li>':'';
			divider = ''; //DesignV2 o comentar desde la linea 1091 hastas 1105
			if(data.datos.length>0){
				var char = ['a','b','c'], count = -1;
				for(i=0;i<data.datos.length;i++){
					if (i % 3 == 0) count = -1;
					count++;
					friend=data.datos[i];
					out+=bodyFriendsList(friend, char[count]);
				}
			}else{
				var mens='';
				switch(opc.mod){
					case 'friends':mens=lan('EMPTY_INFO_FRIENDS');break;
					case 'follow':mens=lan('EMPTY_INFO_ADMIRERS');break;
					case 'unfollow':mens=lan('EMPTY_INFO_ADMIRED');break;
					case 'find':mens=lan('EMPTY_INFO_FIND'); break;
				}
				mens+='<br><br>'+(opc.mod=='friends'||opc.mod=='unfollow'?'<div id="findFriends" style="font-weight:bold">'+lan('FIND_FRIENDS_NOTIFICATION')+'</div>':'');
				out+='<li>'+mens+'</li>';
				$(opc.layer+' #seemore').remove(); //Elimina boton seemore si no hay mas nada qwue ver
			};
			if (method=='refresh') {
				var seemore='';
				if (opc.perpag && data.datos.length>=opc.perpag) seemore='<li data-theme="f" data-icon="false" id="seemore" class="ui-block-d" style="width:100%;"><button data-theme="e">'+lan('see more','ucw')+'</button></li><div class="clearfix"></div>';
				//$(opc.layer).html(divider+out+seemore).listview('refresh');
				$(opc.layer).html(divider+out+seemore);
				$( "button",opc.layer).button();
			}else if(method=='more'){
				if ($('#findFriends').length == 0) {
					$(opc.layer+' #seemore').before(out);
					//$(opc.layer).listview('refresh');
				}
				$('#findFriends').click(function(event){
					redir(PAGE['findfriends']);
				});
			}
			if(opc.success) opc.success(data);
			if (opc.wrapper) opc.wrapper.jScroll('refresh');
		}
	});
}
function linkUser(layer,$wrapper){
	if ($wrapper) {
	// var footerPos = $('#friendsFooter').offset().top,//Para posicion del elemento
	// 	footerHeight = $('#friendsFooter').height();
	}
	$(layer).on('click','[userlink]',function(){
		var id=$(this).attr('userlink'),type=$(this).attr('type'),obj=this;
		var fr=$(obj).parents('li.ui-body').prev('li.userInList'),theme='e',text=lan('follow'),oldtheme="a",oldText=lan('unfollow');
		if($(obj).attr("data-theme")=="e"){
			theme='a';oldtheme="e";
			text=lan('unfollow');oldText=lan('follow');
		}
		$(obj).attr('data-theme',theme).prev('span.ui-btn-inner').find('.ui-btn-text').html(text)
		.parents('.ui-block-b').find('.ui-btn-up-'+oldtheme).attr('data-theme',theme).removeClass('ui-btn-hover-'+oldtheme+' ui-btn-up-'+oldtheme).addClass('ui-btn-up-'+theme);
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/users/follow.json.php?uid='+id,
			error:function(){
				console.log('follow button ERROR');
			},
			success:function(data){
				if(!data['error']){
					// var fr=$(obj).parents('li.ui-body').prev('li.userInList'),theme='e',text=lan('follow'),oldtheme="a";
					// if(!data.unlink){
					// 	theme='a';oldtheme="e";
					// 	text=lan('unfollow');
					// }
					// $(obj).attr('data-theme',theme).prev('span.ui-btn-inner').find('.ui-btn-text').html(text)
					// .parents('.ui-block-b').find('.ui-btn-up-'+oldtheme).attr('data-theme',theme).removeClass('ui-btn-hover-'+oldtheme+' ui-btn-up-'+oldtheme).addClass('ui-btn-up-'+theme);
					$('span.ufriends',fr).html('('+data.friend.friends+')');
					$('span.ufollowers',fr).html('('+data.friend.admirers+')');
					$('span.ufollowing',fr).html('('+data.friend.admired+')');
				}else{
					$(obj).attr('data-theme',oldtheme).prev('span.ui-btn-inner').find('.ui-btn-text').html(oldText)
					.parents('.ui-block-b').find('.ui-btn-up-'+theme).attr('data-theme',oldtheme).removeClass('ui-btn-hover-'+theme+' ui-btn-up-'+theme).addClass('ui-btn-up-'+oldtheme);
				}
			}
		});
	}).on('click','[thisshow]',function(e){
		// $('[thishide]',layer).removeAttr("thishide").attr("thisshow","1").next('li').hide();
		// $(this).removeAttr("thisshow").attr("thishide","1").next("li").show();
		//console.log('Posicion del click:'+e.pageY)
		var photo = $(this).find('a img').attr('src');
		var te="e",text=lan('follow'); 
		var perfiltag = lan('USER_PROFILE');
		var redirprofile = PAGE['profile']+'?id='+this.dataset.link;
		var redirSelfProfile = PAGE['profile'];
		var followButonAction = DOMINIO+'controls/users/follow.json.php?uid='+this.dataset.unlink;
		if (this.dataset.known == 1) te="a",text=lan('unfollow');
/*
			'<fieldset class="ui-grid-a">'+
				'<div class="ui-block-a">'+
					'<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="d" data-disabled="false" class="ui-submit ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all" aria-disabled="false">'+
						'<span class="ui-btn-inner"><span class="ui-btn-text">'+lan('USER_PROFILE')+'</span></span>'+
						'<button code="'+this.dataset.link+'" type="submit" data-theme="d" class="ui-btn-hidden" data-disabled="false">'+lan('USER_PROFILE')+'</button>'+
					'</div>'+
				'</div>'+
				'<div class="ui-block-b">'+
					'<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="'+te+'" data-disabled="false" class="ui-submit ui-btn ui-shadow ui-btn-corner-all ui-btn-up-'+te+'" aria-disabled="false">'+
						'<span class="ui-btn-inner"><span class="ui-btn-text">'+text+'</span></span>'+
						'<button type="b" data-theme="'+te+'" userlink="'+this.dataset.unlink+'" class="ui-btn-hidden" data-disabled="false">'+text+'</button>'+
					'</div>'+
				'</div>'+
			'</fieldset>'+
*/
		myDialog({
			id:'#friend-options',
			content:
			'<div>'+
			'<div class="photo"><img src="'+photo+'" alt="photo" /></div><br />'+
			'<div class="info">'+lan('name','ucf')+': '+this.dataset.usrname+'</div>'+
			'</div>',
			style:{'padding-right':5},
			btntext:{Profile:lan('USER_PROFILE'),Follow:text},
			buttons:{ 
				Profile:function(){ redir(redirprofile); },
				Follow:function(){ 
					myAjax({
						type:'GET',
						url:followButonAction,
						error:function() {
							console.log('follow button ERROR');
						},
						success:function(data){
							console.log('follow button OK');
							/*if(!data['error']){
								setFriendsButtons(data['friend']);
								// $follow.fadeOut('slow', function () {
									// setFollowButton(!data['unlink']);
									// $follow.fadeIn('slow');
								// });
							}else{
								$follow.fadeOut('slow', function () {
									setFollowButton($follow.attr('data-theme')=="u");
									$follow.fadeIn('slow');
								});u
							}*/
						}
					});
					redir(redirSelfProfile);
				}
			},
			backgroundClose: true
		});

		if ($wrapper) {
			// var eleHeight = $(this).height();
			// var broHeight = $(this).next().height();
			// var total = e.pageY-footerPos+eleHeight+broHeight;
			// //console.log('total:'+total,e);
			// if (total > 0 ) {
			// 	$wrapper.jScroll(function(){
			// 		//console.log(this)
			// 		this.scrollTo(0,total,100,true);
			// 	}).jScroll('refresh');	
			// };
			
		}else{
			$('.list-wrapper').jScroll('refresh');
		}
	}).on('click','[thishide]',function(){
		$(this).removeAttr("thishide").attr("thisshow","1").next("li").hide();
		$('.list-wrapper').jScroll('refresh');
	});
}
function verifyGroupMembership(idGroup,code,func){
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/groups/menuGroupUser.json.php?action=6&code='+code+'&idGroup='+idGroup,
		dataType:'json',
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success:func
	});
}
function preferencesUsers(usr,name){
	var code=usr||$.local('code');
	myAjax({
		type	:'GET',
		url		:DOMINIO+'controls/users/preferences.json.php?action=1&code='+code,
		dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success	:function(data){
			var i,j,pref,out='',text=['',lan('PREFERENCES_WHATILIKE'),lan('PREFERENCES_WHATIWANT'),lan('PREFERENCES_WHATINEED')];
			for(i in data.dato){
				out+='<li style="text-align:center;"><strong>'+text[i]+'</strong></li>';
				for(j in data.dato[i]){
					pref=data.dato[i][j];
					out+='<li>';
					if(code==$.local('code'))
						out+='<img src="css/smt/trash.png" pref="'+pref.id+'" type="'+i+'"/>&nbsp;';
					out+=pref.text+'</li>';
				}
			}
			if (out==''){
				if (code==$.local('code')) out=lan('SOONEXTERPREFERENCES3');
				else out=lan('soon','ucw')+' '+(name||lan('SOONEXTERPREFERENCES1'))+' '+lan('SOONEXTERPREFERENCES2');
				out='<div style="width: 80%;margin: 0 auto;text-align: center"><strong>'+out+'</strong></div>';
			} 
			myDialog({
				id:'#preferencesDialog',
				content:'<ul data-role="listview" id="ulMyPrefe" data-theme="c" style="padding:0 20px 20px;">'+out+'</ul>',
				scroll:true,
				style:{'padding-right':5,height:200},
				after:function(){
					$('.content ul',this.id).off('click').on('click','li img',function(){
						var obj=this;
						myAjax({
							type	:'GET',
							url		:DOMINIO+'controls/users/preferences.json.php?action=del&type='+$(obj).attr('type')+'&p='+$(obj).attr('pref')+'&code='+$.local('code'),
							dataType:'json',
							error	:function(/*resp,status,error*/){
								myDialog('#singleDialog',lan('conectionFail'));
							},
							success	:function(data){
								$(obj).parents('li').fadeOut('slow');
							}
						});
					});
				},
				buttons:{
					'Close':function(){
						if($.local('code')==code) location.reload();
						else this.close();
					}
				}
			});
		}
	});

}

function inArray(seed,array){
	for(var i in array){
		if(array[i]==seed) return true;
	}
	return false;
}

$.fn.focusNextInputField=function(){
	return this.each(function(){
		var fields=$(this).parents('form:eq(0),body').find('button,input,textarea,select');
		var index=fields.index(this);
		if(index>-1){
			if((index+1)<fields.length){
				fields.eq(index+1).focus();
			}else{
				fields.eq(0).focus();
			}
		}
		return false;
	});
};

function setAllCookies(opc){
	$.cookie.clear();
	if(!opc||opc===null) opc={};
	for(var i in opc) $.cookie(i,opc[i]);
	$.cookie('last',opc.last||$.cookie('last'),{expires:navigator.app?365:15});
}
function delAllLocals(){
	$.session.clear();
	$.local.clear();
	$.cookie.clear();
}
function setAllLocals(opc){
	opc=opc||{};
	$.session.clear();
	//$.cookie.clear().set(opc.cookies||{});
	$.local.clear().set(opc.locals||{});
	//$.cookie('last',opc.cookies.last||$.cookie('last'),{expires:CORDOVA?365:15});
}

function login(opc){
	//console.log('Login.....o');
	if(opc&&opc.data){
		opc.data.lng=lan('actual');
		myAjax({
			url:DOMINIO+'controls/users/login.json.php?mobile',
			data:opc.data,
			error:function(/*resp,status,error*/){
				console.error('login error');
				//logout(false);
				if(opc.error){
					if(typeof opc.error==='function'){
						opc.error();
					}else{
						redir(opc.error);
					}
				}else
					myDialog('#log-msg',lan('CON_ERROR'));
			},
			success:function(data){
				// console.log(data);
				if(data&&data.logged){
					isLogged(true);
					setAllLocals(data);
					if(opc.success)
						if(typeof opc.success==='function')
							opc.success(data);
						else
							redir(opc.success);
				}else{
					isLogged(false);
					if(opc.fail){
						if(typeof opc.fail==='function')
							opc.fail(data);
						else
							redir(opc.fail);
					}else
						myDialog('#log-msg',data.msg);
				}
			}
		});
	}else console.warn('No puede hacerse login.');
}
function logout(move){
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/users/logout.json.php',
		error:function(){
			myDialog('#log-msg',lan('conectionFail'));
		},
		success:function(data){
			if(data.logout){
				isLogged(false);
				$.session.clear();
				$.local.clear();
				$.cookie.clear();
				if(move!==false) redir(PAGE.ini);
			}else{
				myDialog('#log-msg',data.msg);
			}
		}
	});
}

function inputFocus(obj){
	if(obj.type=='password') obj.value='';
	else if(obj.value==obj.placeholder) obj.value='';
}

function isMail(valor){
	return valor.match(/^[a-zA-Z]([\.-]?\w+)*@[a-zA-Z]([\.-]?\w+)*(\.\w{2,3}){1,2}$/);
}

function enterSubmit(e,obj){
	tecla=document.all?e.keyCode:e.which;
	if(!is.android&&(tecla==10||tecla==13)){
		$(obj).parents('form').submit();
	}
	return true;
}

function enterTab(e,obj){
	tecla=document.all?e.keyCode:e.which;
	if(!is.android&&(tecla==10||tecla==13)){
		$(obj).focusNextInputField();
		return false;
	}
	return true;
}
function enterNumber(e){
	tecla=document.all?e.keyCode:e.which;
	if((tecla>=48&&tecla<=57)||(tecla==8)||(tecla==46)){
		return true;
	}
	return false;
}
function str_replace(inChar,outChar,conversionString){
	var convertedString=conversionString.split(inChar);
	convertedString=convertedString.join(outChar);
	return convertedString;
}

function myDialog(){
	//personal dialog
	var restoreInputs;
	var o={open:true},stro={style:{'text-align':'center'}};
	if(typeof arguments[0]==='string'&&typeof arguments[1]==='string'){
		//si los 2 primeros parametros son cadenas, el primero es el id y el segundo el contenido
		$.extend(o,stro,{id:arguments[0],content:arguments[1]},arguments[2]||{});
	}else if(typeof arguments[0]==='string'){
		if(arguments[1]){
			//si solo el primer parametro es cadena, se toma como id
			$.extend(o,stro,{id:arguments[0]},arguments[1]||{});
		}else{
			//si solo se ha pasado un parametro, se toma como el contenido
			$.extend(o,stro,{content:arguments[0]});
		}
	}else{
		//si el primer parametro no contiene texto se considera como las opciones
		$.extend(o,arguments[0]||{});
	}
	if(!o.id) o.id='#defaultDialog';
	if(o.id.charAt(0)!='#') o.id='#'+o.id;
	console.log('myDialog: id='+o.id);
	if($(o.id).length<1){
		$('body').append('<div id="'+o.id.substr(1)+'"></div>');
	}
	if($(o.id+'.myDialog').length<1){
		$(o.id).addClass('content')
		.attr('id','scroller').wrap(
			'<div id="'+o.id.substr(1)+'" class="myDialog">'+
				'<div class="table"><div class="cell"><div class="window"><div class="container">'+
				'</div></div></div></div>'+
			'</div>'
		);
	}
	var i,$d=$(o.id);//dialog pointer
	if($('.buttons',$d).length<1){
		$('.window',$d).append('<div class="buttons"></div>');
	}
	if($('.closedialog',$d).length<1){
		$d.append('<div class="closedialog" style="display:none"></div>');
	}
	restoreInputs=disableInputs(o.id);
	o.close=function(calle){
		console.log(calle);
		if(typeof calle !== 'undefined'){
			if(calle.type=='click'){
				//alert(calle.target.tagName+' = '+calle.target.className);
				//console.log('en click');
				//console.log(calle);
				if((calle.target.className=='closedialog')||(calle.target.className=='cell')||(calle.target.className=='table')||(calle.target.className=='div')){
					//alert('cerrar ' + calle.target.tagName+' = '+calle.target.className);
					//console.log(calle.target);
					$('.window',$d).fadeOut('fast',function(){
						if(typeof calle==='function')
							$d.fadeOut('fast',calle);
						else
							$d.fadeOut('fast');
					});
				}else{
					//alert('no cerrar');
					//alert(calle.target.tagName+' = '+calle.target.className);
					//console.log(calle);
				}
			}else{
				//alert('no es click');
				//console.log('no es click');
				//console.log(calle);
				$('.window',$d).fadeOut('fast',function(){
					if(typeof calle==='function')
						$d.fadeOut('fast',calle);
					else
						$d.fadeOut('fast');
				});
			}
		}else{
			//console.log('no es evento');
			//console.log(calle);
			$('.window',$d).fadeOut('fast',function(){
				if(typeof calle==='function')
					$d.fadeOut('fast',calle);
				else
					$d.fadeOut('fast');
			});
		}
		restoreInputs();
	};
	if(o.backgroundClose){
		$(o.id+'.myDialog>.table').on('click',o.close);
	}
	$('.closedialog',$d).on('click',o.close);
	if(!o.buttons){
		o.buttons={Ok:o.close};
	}
	if(!(o.buttons instanceof Array)){
		//console.log(o.buttons);
		//console.log(o.btntext);
		//Ejemplo de o.btntext en Profile para los amigos
		var button=[];
		for(i in o.buttons){
			if(typeof o.btntext !== 'undefined'){
				if(!(o.btntext instanceof Array)){
					console.log(o.btntext[i]);
					button.push({
						text:o.btntext[i],
						click:o.buttons[i]
					});
				}else{
					button.push({
						text:i,
						click:o.buttons[i]
					});
				}
			}else{
				button.push({
					text:i,
					click:o.buttons[i]
				});				
			}
		}
		o.buttons=button;
	}
	$('.buttons a[action]',$d).remove();
	for(i in o.buttons){
		$('.buttons',$d).append('<a action="'+i+'" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">'+(o.buttons[i].text||o.buttons[i].name)+'</span></span></a>');
	}
	$d.off().on('click','a[action]',function(){
		var b=o.buttons[$(this).attr('action')],click=b.click||b.action;
		if(typeof click==='string'&&click.match(/close/i)) o.close();
		else if(typeof click==='function') click.call(o,o);
	});
	if(o.content) $('.content',$d).html(o.content);
	if(o.style) $('.container',$d).css(o.style);
	if(typeof o.before=='function'){
		//params:options,dialog,content,buttons
		o.before(o,$d,$('.content',$d),$('.buttons',$d));
	}
	if(o.open) $d.fadeIn('fast',function(){ $('.window',$d).fadeIn('fast'); });
	if(o.scroll){
		console.log('creating iScroll');
		if(o.scroll===true) o.scroll={};
		$('.container',$d).jScroll($.extend({hScroll:false},o.scroll));
	}
	if(typeof o.after=='function') o.after.call(o,o,$d,$('#content',$d),$('#buttons',$d));
	windowFix();
}

function checkAllCheckboxs(value,container){
	$(container+' li').each(function(){
		if (value){
			$('input',this).prop('checked',true);
			$(this).addClass('ui-btn-active-checked');
		}else{
			$('input',this).prop('checked',false);
			$(this).removeClass('ui-btn-active ui-btn-active-checked');
		}
	});
	return false;
}
function getFriends(id,groups,like){
	console.log('getFriends');
	like=like?'&like='+like:'';
	var emails=[],content='.list-wrapper #scroller ul',
		url=DOMINIO+'controls/users/people.json.php?nosugg&action=friendsAndFollow&code'+like;
	$('#pictures_shareTag input').each(function(){
		emails.push($(this).val());
	});
	if (groups){
		if ($.isArray(groups))
			url=DOMINIO+'controls/users/people.json.php?action=groupMembers&code&noMy&idGroup='+groups[0]+like;
		else url+='&idGroup='+groups;
		// content='#friendsListDialog .container ul';
	} 	
	myAjax({
		loader	:true,
		type	:'POST',
		url		:url,
		data:{uid:id},
		dataType:'json',
		success	:function(data){
			var ret='';
			for(var i in data['datos']){
				if(emails.join().indexOf(data['datos'][i]['email'])<0)
				ret+='	<li data-icon="false" style="width: 24%;border: 1px solid #ccc;float: left;padding-left: 19%;">'+
							'<input value="'+data['datos'][i]['email']+'|'+data['datos'][i]['photo_friend']+'" type="checkbox" class="invisible"/>'+
							'<img src="'+data['datos'][i]['photo_friend']+'" style="float:left;width:50px;height:50px;" class="userBR"/>'+
							'<div style="float:left;margin-left:2px;font-size:8px;text-align:left;">'+
								'<spam style="color:#E78F08;font-weight:bold;">'+data['datos'][i]['name_user']+'</spam><br/>'+
								(data['datos'][i]['country']?lan('country')+':'+data['datos'][i]['country']+'<br/>':'')+
								''+lan('friends','ucw')+'('+data['datos'][i]['friends_count']+')<br/>'+
								''+lan('admirers','ucw')+'('+data['datos'][i]['followers_count']+')'+
							'</div>'+
						'</li>';
			}
			
			if(data['datos'].length===0){
					
					ret='</ul>'+
							'<div class="tcAlert">'+lang.GROUPS_MESSAGEMPTY+'</div>'+
							'<button id="noresult-findfriends" data-role="button" data-theme="f"  class="ui-btn"  data-icon="plus" data-iconpos="right">'+
								lan('friendSearh_title')+
							'</button>'+
						'<ul>';
			}
			

			$(content).html(ret).listview('refresh');
			$('.list-wrapper').jScroll('refresh');

			
			if(data['datos'].length===0){
				$('#noresult-findfriends').button();
				$('#noresult-findfriends').click(function(){ redir(PAGE.findfriends); });
			}	

			
	

			$(content+' li').click(function(){
				if (!$('input',this).is(':checked')){
					$('input',this).prop('checked',true);
					$(this).addClass('ui-btn-active-checked');
				}else{
					$('input',this).prop('checked',false);
					$(this).removeClass('ui-btn-active ui-btn-active-checked');
				} 
			});
		},
	
		
		error :function(){
			myDialog('#singleDialog','ERROR-getFriends');
		}
	});
}

function selectFriendsDialog(id,groups){
	console.log('selectfriendsdialog');
	var idDialog='shareTagDialog';
	if (groups) idDialog='friendsListDialog';

	myDialog({
		id:idDialog,
		style:{'min-height':200},
		buttons:{},
		after:function(options,dialog){
			getFriends(id,groups);
			
			var timer;
			$('#like_friend',dialog).unbind('keyup').bind('keyup',function(event){
				if(event.which==8||event.which>40){
					if(timer) clearTimeout(timer);
					timer=setTimeout(function(){
						
						getFriends(id,groups,$('#like_friend',dialog).val());
					},1000);
				}
			});
		}
	});
}

// removes a picture and check if there's no more pictures hide the title
function removePicture(item){
	$(item).remove();
	if(!$('#pictures_shareTag').html()){
		$('#title_pictures_shareTag').fadeOut('slow');
	}
	checkboxPublicPrivateTag();
}

function closeDialogmembersGroup(idDialog){
	console.log('closeDialogmembersGroup');
	$('.closedialog',idDialog).click();
}

function getDialogCheckedUsers(idDialog){
	console.log('getDialogCheckedUsers');
	var paso=false;
	$('input:checkbox',idDialog).each(function(i,field){
		if ($(field).is(':checked')){
			var userInfo=field.value.split('|');
			if(userInfo[1]){
				$('#pictures_shareTag').prepend(
					'<span id="'+md5(userInfo[0])+'" onclick="removePicture(this)">'+
						'<input type="hidden" name="x" value="'+userInfo[0]+'" type="text"/>'+
						'<img src="'+userInfo[1]+'" width="40" style="margin-left: 5px; border-radius: 5px;" class="userBR"/>'+
					'</span>'
				);
				paso=true;
			}
		}
	});
	if(paso) $('#title_pictures_shareTag').fadeIn('slow');
	$('.closedialog',idDialog).click();
	checkboxPublicPrivateTag();
}

function checkboxPublicPrivateTag(){
	if($('#div_publicTag').length>0)
		$('#div_publicTag_checkbox').attr('checked',$('#pictures_shareTag').html()==='').checkboxradio('refresh');
}
// END - friends

function limpiaTextComentarios(text){
	var replaced=text;
	//URLs starting with http://, https://
	replaced=replaced.replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\"/g,'&quot;').replace(/\'/g,'&apos;');
	replaced=escape(replaced);
	replaced=str_replace(' ','|',replaced);
	return replaced;
}

function convertirLinks(text){
	var replaced=text;
	replaced=replaced.replace(/\b(((https?):\/\/)\S*)\b/gim,'<a href="$1" target="_blank">$1</a>');
	//URLs starting with www.(optional) and contains ending web page (eg: .com.ve, .info, .net, .com)
	replaced=replaced.replace(/\b((?!(href=["']?)|(>))(www\.)?.+\.[a-zA-Z]{2,6}(\.[a-zA-Z]{2})?([\/#\?].*)?)\b/gim,'<a href="http://$1" target="_blank">$1</a>');
	//Change email addresses to mailto:: links
	replaced=replaced.replace(/((?!href=["']?)\w+@[0-9a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim,'<a href="mailto:$1">$1</a>');
	return replaced;
}

//Scrolls con "pull to refresh"
(function($,console){
	var reload=[];
	$.fn.ptrScroll=function(){
		console.log('ptrScroll');
		var action='scroll',options={};
		if(typeof arguments[0]==='function'){
			action='run';
			options.run=arguments[0];
		}else if(typeof arguments[0]==='string'){
			action=arguments[0];
			if(action=='run'&&typeof arguments[1]==='function')
				options.run=arguments[1];
			else
				options=arguments[1];
		}else{
			options=arguments[0];
		}
		console.log('action='+action);

		return this.each(function(){
			var i,pullDownEl,pullDownOffset,pullUpEl,pullUpOffset,$this=$(this);
			if(action=='scroll'){
				pullDownEl		=$('#pullDown',this)[0];
				pullDownOffset	=pullDownEl.offsetHeight;
				pullUpEl		=$('#pullUp',this)[0];
				pullUpOffset	=pullUpEl.offsetHeight;
				$this.jScroll({
					//snap:'.smt-tag',
					hScroll:false,
					useTransition:true,
					topOffset:pullDownOffset,
					run:function(){
						var scroll=this,i=reload.length,func;
						func=function(opc){
							scroll.scrollTo(0,0,100);
							options.onReload.call(scroll,opc);
						};
						$this.attr('ptr',i);
						reload[i]=func;
					},
					onRefresh:function(){
						if(pullDownEl.className.match('loading')){
							pullDownEl.className='';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lan('SCROLL_PULLDOWN');
						}else if(pullUpEl.className.match('loading')){
							pullUpEl.className='';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lan('SCROLL_PULLUP');
						}
					},
					onScrollMove:function(){
						if(this.y>5&&!pullDownEl.className.match('flip')){
							pullDownEl.className='flip';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lan('SCROLL_RELEASE');
							this.minScrollY=0;
						}else if(this.y<5&&pullDownEl.className.match('flip')){
							pullDownEl.className='';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lan('SCROLL_PULLDOWN');
							this.minScrollY=-pullDownOffset;
						}else if(this.y<(this.maxScrollY-5)&&!pullUpEl.className.match('flip')){
							pullUpEl.className='flip';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lan('SCROLL_RELEASE');
							this.maxScrollY=this.maxScrollY;
						}else if(this.y>(this.maxScrollY+5)&&pullUpEl.className.match('flip')){
							pullUpEl.className='';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lan('SCROLL_PULLUP');
							this.maxScrollY=pullUpOffset;
						}
					},
					onScrollEnd:function(){
						if(pullDownEl.className.match('flip')){
							pullDownEl.className='loading';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lan('SCROLL_LOADING');
							if(typeof options.onPullDown=='function'){
								options.onPullDown.call(this,this);//Execute custom function (ajax call?)
							}else{
								setTimeout(this.refresh,1000);
							}
						}else if(pullUpEl.className.match('flip')){
							pullUpEl.className='loading';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lan('SCROLL_LOADING');
							if(typeof options.onPullUp=='function'){
								options.onPullUp.call(this,this);//Execute custom function (ajax call?)
							}else{
								setTimeout(this.refresh,1000);
							}
						}
					}
				});
				i=$this.attr('ptr');
				reload[i]();
				setTimeout(function(){$this.css('left','0');},800);
			}else{
				if(action=='reload'){
					i=$this.attr('ptr');
					if(typeof reload[i]=='function'){
						$this.jScroll(function(){
							this.scrollTo(0,0,100);
							reload[i].call(this,options);
						});
					}
				}
			}
		});
	};
})(jQuery,console);
function paletteColorPicker(id_layer){
	var cs=['0','3','6','9','C','F'];
	function opc(a,b,c){
		var col;
		if(typeof a==='string')
			col=a;
		else
			col=cs[a%6]+cs[b%6]+cs[c%6];
		return '<option value="'+col+'">#'+col+'</option>';
	}
	function opc8(a,b,c){
		var o='',i;
		for(i=4;i>=0;i-=2) o+=opc(a<1?5:i,b<1?5:i,c<1?5:i);
		for(i=4;i>0; i-=2) o+=opc(a<1?i:0,b<1?i:0,c<1?i:0);
		return o;
	}
	function opcmid(a,b,c){
		for(var i=0,o='';i<6;i+=2,a=(a+2)%6,b=(b+2)%6,c=(c+2)%6)
			o+=opc(a,b,c);
		return o;
	}
	$(id_layer).find('select').html(
		opc8(0,0,1)+opc(0,0,0)+opc('F82')+opc('461')+opc('800')+
		opc8(0,1,0)+opc(1,1,1)+opcmid(2,3,4)+
		opc8(0,1,1)+opc(2,2,2)+opcmid(3,4,1)+
		opc8(1,0,0)+opc(3,3,3)+opcmid(1,0,5)+
		opc8(1,0,1)+opc(4,4,4)+opcmid(3,4,5)+
		opc8(1,1,0)+opc(5,5,5)+opcmid(3,1,5)
	);
}

function disableInputs(exceptions){
	var inputs=$('input,textarea,select').not(':disabled').not('.no-disable');
	if(inputs.length>0&&exceptions) inputs=inputs.not(exceptions);
	if(inputs.length>0){
		inputs.attr('disabled','disabled');
		return function(){
			if(inputs){
				inputs.removeAttr('disabled');
				inputs=false;
				return true;
			}
			return false;
		};
	}else{
		return function(){return false;};
	}
}

function htmlEncode(str){
	return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
function htmlDecode(str){
	return String(str).replace(/&amp;/g,'&').replace(/&quot;/g,'"').replace(/&gt;/g,'>').replace(/&lt;/g,'<');//.replace(/&lt;br\/?&gt;/g,'<br>');
}

function viewCategories(action,idLayer,id){
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/store/actionStoreApp.json.php?action='+action+(id?'&id='+id:''),
		dataType:'json',
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success:function(data){
			var out='',cate;
			if (data.data.length>0){
				if (data.data.length==1){
					if (action==1) redir(PAGE['storeSubCate']+'?id='+data.data[0].id);
					else if (action==2) redir(PAGE['storePorduct']+'?sc='+data.data[0].id+'&c='+id);
				}else
					for(var i in data.data){
						cate=data.data[i];
						out+=
							'<li class="categorylist">'+
								'<a code='+cate.id+' data-theme="e">'+
									(cate.photo?'<img src="'+cate.photo+'" style="width:80px;height:50px;margin:20px 0 0 8px;">':'')+
									'<p><h3 class="ui-li-heading">'+cate.name+'</h3>'+
									(cate.cant?'<span class="ui-li-count">'+cate.cant+'</span>':'')+
								'</p></a>'+
							'</li>';
					}
			}else{
				myDialog({
					id:'#idDontStore',
					content:'<center><strong>'+lan('STORE_NOSTORE_MESSAGE')+'</strong></center>',
					scroll:true,
					buttons:{ ok:'close' }
				});
			}
			// if(data.sCart) $('#cart-footer').fadeIn();
			$(idLayer).html(out).listview('refresh');
			$('.list-wrapper').jScroll('refresh');
			actionMenuStore();
		}
	});
}
function actionButtonsStore(){
	$('#lstStoreOption .buttons a,#cartList .buttons a').click(function(){
			switch($(this).attr('func')){
				case 'details':redir(PAGE.detailsproduct+'?id='+$(this).parents('li').attr('id'));break;
				case 'delete':
					var get='',obj={};
					switch($(this).parents('ul').attr('id')){
						case 'lstStoreOption':
							get='&mod=wish&lisWishsShow=1';
							obj.mod='wish';
							break;
						case 'cartList':
							get='&mod=car&shop=1';
							obj.mod='car';
							break;
					}
					deleteItemCar($(this).parents('li').attr('id'),get,obj);
				break;
				case 'sendWish':
					var auxi=$('#cartList .buttons a'),get='&shop=1&car=toWish';
					moveToWish($(this).parents('li').attr('id'),get);
				break;
				case 'sendCart':
					var auxi=$('#lstStoreOption .buttons a');
					$.each(auxi,function(){$(this).attr('func2',$(this).attr('func'));});
					addProductShoppingCart($(this).parents('li').attr('id'),auxi);
				break;
			}
			$('#lstStoreOption .buttons a,#cartList .buttons a').removeAttr('func');
	});
}
function deleteItemCar(id,get,obj){
	get=get?get:'';
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/store/shoppingCart.json.php?action=2&w=1&id='+id+get,
		dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success:function(data){
			if(data.del!='1'){
				if(data.del=='all'){
					if(obj.mod=='car'){redir(PAGE.storePorduct);}
					else if (obj.mod=='wish'){
						$('#lstStoreOption').html(data.wish.body).listview('refresh');
						actionButtonsStore();
						$('.list-wrapper').jScroll('refresh');
					}
				}else if(data.del=='no-all'){

				}
			}else{
				var num=data.numR;
				if(num){
					if(obj.mod!='wish'){
						if(data.datosCar[0].name){
							out=bodyCart(data);
							$('#cartList').html(out).listview('refresh');
							var myselect=$('select.cant-product');
							if(myselect){
								myselect.selectmenu();
								updateCantP(myselect);
							}
							$('.list-wrapper').jScroll('refresh');
							actionButtonsStore();
							if($('.money').length<1){$('#dollarApp').val('no');}
						}
					}else{
						$('#lstStoreOption').html(data.wish.body).listview('refresh');
						actionButtonsStore();
						$('.list-wrapper').jScroll('refresh');
					}
				}else{location.reload();}
			}
		}
	});
}
function updateCantP(myselect){
	myselect.change(function(){
		var cantAct=$(this).val(),tipo=$(this).attr('fr'),totalAnt=$(this).attr('cantAct'),
			diferencia=0,objeto=$(this),linea=$(this).parents('li').attr('id'),total,totalAct;
			diferencia=cantAct*$(this).attr('precio');
		myAjax({
			type:'POST',
			url:DOMINIO+'controls/store/shoppingCart.json.php?action=15&linea='+linea+'&cant='+objeto.val(),
			dataType:'json',
			success:function(data){
				if(data.datosCar=='update'){
					objeto.attr('cantAct',diferencia);
					if(tipo==1){
						totalAct=$('#data-header .total div .money input').val();
						total=(totalAct-(totalAnt))+(diferencia);
						$('#data-header .total div .money').remove();
						$('#data-header .total div').append('<div class="money">$'+total+'<input type="hidden" value="'+total+'"></div>');
						objeto.parents('li').find('.price').html('$'+total);
						// totalAct=$('#cartList .titleDivider .money input').val();
						// $('#cartList .titleDivider .money imput').val();
						// $('#cartList .titleDivider .money span').html((totalAct-(totalAnt))+(diferencia));
						//$('#totalPriceMoney').html((totalAct-(totalAnt))+(diferencia)).formatCurrency({symbol:''});
					}else{
						totalAct=$('#data-header .total div .points input').val();
						total=(totalAct-(totalAnt))+(diferencia);
						$('#data-header .total div .points').remove();
						$('#data-header .total div').append('<div class="points">$'+total+'Pts<input type="hidden" value="'+total+'"></div>');
						objeto.parents('li').find('.price').html(total+'Pts');
						// $('#cartList .titleDivider .point imput').val((totalAct-(totalAnt))+(diferencia));
						// $('#cartList .titleDivider .point span').html((totalAct-(totalAnt))+(diferencia));
						//$('#totalPrice').html((totalAct-(totalAnt))+(diferencia)).formatCurrency({symbol:''});
						//var auxi=$('#totalPrice').html().split('.');
						//$('#totalPrice').html(auxi[0]);
					}
				}else{
					myDialog({
						content:lan('STORE_ORDER_EDIT_STOCK'),
						name:'ok',
						action:function(){
							location.reload();
						}
					});
				}
			}
		});
	});
}
function addProductShoppingCart(id,wish){
	wish=wish?wish:'';
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/store/shoppingCart.json.php?action=1&add=si&id='+id,
		dataType:'json',
		error:function(/*resp,status,error*/){myDialog('#singleDialog',lan('conectionFail'));},
		success:function(data){
			if(data.datosCar2.add=='si'){
				if(data.datosCar2.order){
					myDialog({
						content:data.datosCar2.order,
						scroll:true,
						buttons:{ok:function(){redir(PAGE.shoppingCart);}}
					});
				}else{redir(PAGE.shoppingCart);}
			}else if(data.datosCar2.add=='no'){
				if(wish){$.each(wish,function(){$(this).attr('func',$(this).attr('func2')).removeAttr('func2');});}
				switch(data.datosCar2.msg){
					case 'no-disponible':
						myDialog({
							content	:lan('TAGS_WHENTAGNOEXIST'),
							scroll:true,
							buttons:{'ok':function(){location.reload();}}
						});
						break;
					case 'backg':myDialog('#information',lan('STORE_UNI_BACKG'));break;
					case 'no-stock':myDialog('#information',lan('STORE_PRODUCTO_NO_STOCK'));break;
					case 'no-product':break;
				}
			}
		}
	});
}
function moveToWish(id,get,details){
		get=get?get:'';
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/store/shoppingCart.json.php?action=14&id='+id+get,
			dataType:'json',
			success:function(data){
				var dato=data.listWish;
				if (details) redir(PAGE.storeOption);
				if(data.numRow>0){
					if(data.datosCar){
						if(data.datosCar[0].name){
							out=bodyCart(data);
							$('#cartList').html(out).listview('refresh');
							var myselect=$('select.cant-product');
							if(myselect){
								myselect.selectmenu();
								updateCantP(myselect);
							}
							$('.list-wrapper').jScroll('refresh');
							actionButtonsStore();
						}
					}
					if(data.wish&&data.wish.body){
						//$('#list_orderProduct_wish ul').html(data.wish.body);
						//$('.button').button();
					}else{
						//$('#list_orderProduct_wish').empty().html('').css('display','none');
					}
				}else{
					if(data.wish&&data.wish.body){
						//$('#list_orderProduct_wish ul').html(data.wish.body);
						//$('.button').button();
					}else{
						myDialog({
                            id:'#singleDialog',
                            content:'<div style="text-align: center;"><strong>'+lang.STORE_NO_SC+'</strong></div>',
                            buttons:[{
                                name:'Ok',
                                action:function(){ redir(PAGE.storePorduct); }
                            }]
                        });
						$('#cartList').empty().html('').listview('refresh');
					}
				}
			}
		});
}

function checkOutShoppingCart(get){
	get=get?get:'';
	myAjax({
		type	:'GET',
		url		:DOMINIO+'controls/store/shoppingCart.json.php?action=4'+get,
		dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lan('conectionFail'));
		},
		success	:function(data){
			if(data.productMobile){$.loader('show');redir(PAGE.storeOption+'?option=1');}
			else if(data.formPaymentD){
				myDialog('#singleDialog',lan('STORE_NOT_CHET_DOLLAR'));
			}else{
				//alert(data.nOrden+'+++'+data.nproduct)
				if(data.datosCar=='noCredit'){
					myDialog({
						id:'#idCheckOutAppNo',
						style:{'min-height':80},
						content:lan('STORE_SHOPPING_NOPOINTS'),
						scroll:true,
						buttons:{
							ok:'close'
						}
					});
					//alert(lan('STORE_SHOPPING_NOPOINTS'));
				}else{
					myDialog({
						id:'#idCheckOutAppDone',
						style:{'min-height':80},
						content:lan('STORE_ORDERS_THANKYOU_ORDER1')+'<br/><br/>'+lan('STORE_ORDERS_THANKYOU_ORDER2'),
						scroll:true,
						buttons:{ok:function(){ redir(PAGE["myOrders"]); }}
					});
					//redir(PAGE.orderdetails+'?nOrden='+data.nOrden);
				}
			}
		}
	});
}
function getGroups(code,preview){

	myAjax({
		type	:'POST',
		url		:DOMINIO+'controls/groups/menuGroupUser.json.php?action=1&code='+code,
        dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
            if(data.myGroups){
            	var group,outItemMyGroups='';
            	for(i in data.myGroups){
					group=data.myGroups[i];
					outItemMyGroups +='<li result="'+md5(group.id)+'"><a href="tagsList.html?current=group&id='+md5(group.id)+'">'+group.name+'</a></li>';
            	}
            	if (outItemMyGroups!=''){ 
                	$('#myGroups').append(outItemMyGroups); 
                	if (!preview) $('#myGroups').listview('refresh');
                	else $('#myGroups').append('<a href="lstgroups.html?action=3" class="more">'+lan('see more','ucw')+'</a>');
                }else if (!preview) myDialog('#singleDialog',lang.TAG_CONTENTUNAVAILABLE);
                $('.fs-wrapper').jScroll('refresh');
            }else if (!preview) myDialog('#singleDialog',lang.conectionFail);

            if(data.allGroups){
            	var group,outItemAllGroups=''
            	for(i in data.allGroups){
					group=data.allGroups[i];
					outItemAllGroups +='<li result="'+md5(group.id)+'"><a href="tagsList.html?current=group&id='+md5(group.id)+'">'+group.name+'</a></li>';
            	}
            	if (outItemAllGroups!=''){ 
                	$('#allGroups').append(outItemAllGroups); 
                	if (!preview) $('#allGroups').listview('refresh');
                	else $('#allGroups').append('<a href="lstgroups.html?action=2" class="more">'+lan('see more','ucw')+'</a>');
                }else if (!preview) myDialog('#singleDialog',lang.TAG_CONTENTUNAVAILABLE);
                $('.fs-wrapper').jScroll('refresh');
            }else if (!preview) myDialog('#singleDialog',lang.conectionFail);
        }
	}); 
}
function getTrendings(num,preview){
    myAjax({
		type	:'POST',
		url		:DOMINIO+'controls/search/search.json.php'+(num?'?num='+num:''),
        data    :{trendings:true},
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
            var outH='';
            if (data['trendings']){
                for(i in data['datos']) 
                    if(i){
						pref = data['datos'][i];  
						outH +='<li result="'+pref+'"><a href="search.html?srh='+pref.replace('#','%23').replace('<br>',' ')+'">'+pref+'</a></li>';
					}
                if (outH!=''){ 
                	$('#trendings').append(outH); 
                	if (!preview) $('#trendings').listview('refresh');
                	else $('#trendings').append('<a href="trendings.html" class="more">'+lan('see more','ucw')+'</a>');
                }else if (!preview) myDialog('#singleDialog',lang.TAG_CONTENTUNAVAILABLE); 
                $('.fs-wrapper').jScroll('refresh');
	        }else if (!preview) myDialog('#singleDialog',lang.conectionFail);
        }
	});   
}
function getNews(action,opc,on,$info,preview){
	function peopleFormat(usr,num){
		num=num||usr.length;
		var	txt='',len=num>3?3:num;
		for(var i=0; i<len; i++){
			if(i>1 && num>3)
				txt+='<b>'+(num-2)+' [_MORE_]</b>';
			else
				txt+='<b>'+usr[i]['name']+'</b>';
			if(len>1 && i<len-1)
				txt+=(i<len-2)?', ':' [_AND_] ';
		}
		return txt;
	}
	function newsFormat(d){return(
		'<li data-type="'+d.type+'" date="'+d.date+'" data-source="'+d.source+'">'+
			'<a>'+
				(!preview?'<img src="'+d.photo+'"/>':'')+
				'<p class="title">'+d.txt+'</p>'+
				'<p class="date">'+d.date+'</p>'+
			'</a>'+
		'</li>'
	);}
	var cancel=function(){return action!='reload'&&on['reload'];};
	if(!cancel()&&!on[action]&&opc.more!==false){
		on[action]=true;
		myAjax({
			url		: DOMINIO+'controls/news/newsjson.php?action='+action+(preview?'&limit=3':''),
			// url		: DOMINIO+'controls/news/news.json.php',
			dataType: 'json',
			data	: opc,
			error	: function(/*resp, status, error*/) {
				myDialog('#singleDialog', lang.conectionFail);
			},
			success	: function(data){
				eval(data.txtFormat);
				if(action=='more'&&(!data['info']||data['info'].length<1)) opc.more=false;
				if(!cancel()&&data['info']&&data['info'].length>0){
					opc.limit=data['numResult'];
					var i,j,out='',info,d;
					opc.date=data['fecha'];
					if(!opc.refresh) opc.start=(opc.start||0)+data['info'].length;
					for(i in data['info']){
						info = data['info'][i];
						d={
							type:info['type'],
							source:info['source'],
							// txt:lang.info({
							// 	type:info['id_type'],
							// 	friends:peopleFormat(info['friend']),
							// 	usr:'<b>'+info['usrs']['name']+'</b>'
							// }),
							date:info['fdate']
						};
						var friends=peopleFormat(info['usrs']),
                           	people=peopleFormat(info['friend']);
						switch(info['type']){
							case 'tag':
									d.photo=FILESERVER+'img/tags/'+info['source'].substr(-16)+'.m.jpg';
                                    d.txt=txtFormat({
										type:info['id_type'],
										people:people,
                                        friends:friends,
										txt:data['txt'],
										tag:'[_TAG_]'
									});
									out+=newsFormat(d);										
							break;
							case 'usr':
								d.source=info['keyUser'];
								d.photo =info['usrs'][0]['photo']+'" class="userBR" style="height:90%;';
								d.txt=txtFormat({
									type:info['id_type'],
									people:people,
                                    friends:friends,
									txt:data['txt']
								});
								out+=newsFormat(d);
							break;
							case 'product':
								d.photo = info['photoS']+'" style="height:90%;';
								d.txt=txtFormat({
									type:info['id_type'],
									people:people,
									txt:data['txt'],
									prod:'[_PROD_]'
								});
								out+=newsFormat(d);
							break;
						}
					}
//									if(opc.refresh)
//										$info.prepend(out).listview('refresh');
//									else
//										$info.append(out).listview('refresh');
					$info[opc.refresh?'prepend':'append'](out);
					if (!preview) $info.listview('refresh');
					else $info.append('<a href="news.html" class="more">'+lan('see more','ucw')+'</a>');
				}else{
					// console.log('aqui',$info);
					// $info.html('');
					if($info.html()==''){
						$info.append('<div class="emptyInfo">'+lang.EMPTY_INFO_NEWS+'<br><br><a href="findFriends.html" style="font-weight:bold">'+lang.FIND_FRIENDS_NOTIFICATION+'</a></div>');
						$('#pullUp').hide();
						$('#findFriends').click(function(event) {
							redir(PAGE['findfriends']);
						});
					}
				}
				on[action]=false;
				$('#pd-wrapper').jScroll('refresh');
			},
			complete:function(){
				on[action]=false;
			}
		});
	}
}
(function(window){//funciones de comentarios
	function showComments(comments){
		if(!comments||!comments.length) return '';
		var i,len=comments.length,html='';
		for(i=0;i<len;i++){
			html=showComment(comments[i])+html;
		}
		return html;
	}
	function showComment(comment){return(
		'<li comment="'+comment.id+'"'+(comment.short?' class="more"':'')+'>'+
			'<img src="'+(comment.photoUser||'css/tbum/usr.png')+'" class="ui-li-thumb userBR" width="50" height="50" />'+
			(comment.delete?''/*'<img src="css/smt/delete.png" class="del"/>'/**/:'')+
			'<em class="ui-li-asid">'+comment.commentDate+'</em>'+
			'<div class="text">'+
				'<h4>'+comment.nameUser+'</h4>'+
				'<p>'+comment.comment+'</p>'+
				(comment.short?'<p class="short">'+comment.short+'</p>':'')+
			'</div>'+
			(comment.short?'<div class="this_seemore">'+lan('see more','ucf')+'</div>':'')+
			'<div class="clearfix"></div>'+
		'</li>'
	);}
	var on={},count=0;
	function _getComments(action,obj,protected){
		if(!protected&&(action=='insert'||action=='del')) return;
//		console.log('getcomments');
//		console.log(obj);
		var opc=obj.data,layer=$(obj.layer),$scroller=$(obj.scroller);
		if(!layer.length) return;
		var $header=$('.header',layer),
			$list=layer,
			cancel=function(){return (action!='reload'&&on.reload);},//cancel action
			onca=function(val){if(val!==undefined)on[action]=val;return on[action];};//on current action
		if(action=='all'){action='more';opc.all=true;}
		if(action!='refresh') $('.loader',layer).show();
		if(action=='reload') opc.start=0;
		opc.action=action;
		onca(true);
		count++;
		myAjax({
			type:'POST',
			data:opc,
			url:DOMINIO+'controls/comments/list.json.php',
			dataType:'json',
			loader:false,
			success:function(data){
				//if(!data) return;
				if(data.deleted){//si fue una eliminacion
					opc.start--;
					var $ul=protected.parent();
					protected.fadeOut(600,function(){
						// console.log($ul.children(':visible').length);
						if(!$ul.children(':visible').length)
							$('.seemore',$header[0]).click();
					});
					return;
				}
				var head='<li data-role="list-divider" class="a">'+lan('Comments')+
							'<div id="numDislikes">'+(data.dislikes||0)+'</div>'+
							'<div id="numLikes">'+(data.likes||0)+'</div>'+
						'</li>'+
						'<li data-role="list-divider" data-theme="c" class="header">'+
							lan('see more','ucf')+' <span class="loader"/><div class="seemore">(<span class="count"></span>)</div>'+
						'</li>';
				if(cancel()){console.log('Cancelados comentarios: '+action);return;}
//				console.log(data);
				//if(!data||!data.list||!data.list.length) return;
				var list='',len=data.list.length,rep=0,i;
				for(i=len-1;i>=0;i--){//eliminar repeticiones
					if($list.find('[comment='+data.list[i].id+']').length>0){
						rep++;
						data.list.splice(i,1);
					}
				}
				list=showComments(data.list);
				opc.date=data.date;
				opc.start+=len-rep;
//				console.log(list);
				if(action=='more') $list.find('.ui-li-divider').remove();
				else $list.find('.ui-li-divider.a').remove();
				if(action=='reload'){
					$list.html(list+
						'<li id="comment-line"><form>'+
							'<img src="'+(data.userPic||'css/tbum/usr.png')+'" class="ui-li-thumb userBR" width="50" height="50" />'+
							//'<textarea id="commenting" rows="3" placeholder="Comentar..." name="comment"></textarea>'+
							'<input type="text" name="comment" id="commenting" />'+
							//'<a id="send-comment">Enviar</a>'+
							'<input id="send-comment" type="submit" value="Enviar" class="invisible"/>'+
						'</form></li>'
					).slideDown();
					//$('#send-comment').button();
				}else if(action=='refresh'||action=='insert'){
					// $list.append(list);
					$('#comment-line').before(list);
					if (action=='insert') $( "#commenting" ).blur();
				}else{
					$list.prepend(list);
				}
				$list.prepend(head).listview('refresh');
				$header=$('.header',layer);
				if(action!='refresh'&&action!='insert'){
					opc.total=data.total*1;
					var more=opc.total-opc.start;
					if(more>0){
						$header.addClass('more');
						$('.seemore .count',$header).html(more>opc.limit?opc.limit+'/'+more:more);
					}else{
						$header.removeClass('more');
					}
				}
			},
			complete:function(){
				onca(false);
				if(opc.complete) opc.complete();
				if(!(--count)){
					$('.loader',layer).hide();
					delete opc.action;
					delete opc.id;
					delete opc.txt;
					delete opc.all;
					delete opc.complete;
				}
				$('#txtComment',layer).removeProp('disabled');
				if($scroller.length) $scroller.jScroll('refresh');
			}
		});
		return true;
	}
	window.getComments=function(action,opc){
		return _getComments(action,opc);
	};
	window.insertComment=function(txt,opc){
		opc.data.txt=txt.replace(/^\s+|\s+$/gm,'');
		if(!opc.data.txt) return;
		return _getComments('insert',opc,true);
	};
	window.delComment=function(el,opc){
		var id=el.attr('comment');
		// console.log('delcomment='+id);
		if(!id) return;
		opc.data.id=id;
		return _getComments('del',opc,el);
	};
})(window);
