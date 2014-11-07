var hideGroups=false;

//-- Constantes para mobile --//
(function(w,$){
	$.local.ce=/^(logged|host|firebug.*)$/i;//excepciones al borrar todos los locales
	$.cookie.ce=/^(kl|last|enableLogs|PHPSESSID)$/;//excepciones al borrar todas las cookies
	$.cookie.defaults={expires:(CORDOVA?365:15),path:'/'};//configuracion por defecto para cookies
	//loader
	var m,loader=function(mode){$.mobile.loading(mode);};
	$.loader=function(mode){
		if(m!==mode){$(function(){loader(mode);});m=mode;}
	};
	$(function(){
		$.loader=function(mode){if(m!==mode){loader(mode);m=mode;}};
	});
	$.mobile.defaultPageTransition='slide';//transicion por defecto
	$.mobile.ajaxEnabled=false;//is['android'];
	$.fn.jScroll.defaultOptions.forceIscroll=true;//ignora scroll nativo, obligando a utilizar iScroll
	//se eliminan algunas cookies cuando no viene de una transicion
	$.session('get',null);
	$.session('page',null);
	$.mobile.loader.prototype.options.text=lang.loading;
	$.mobile.loader.prototype.options.textVisible=true;
	$.mobile.loader.prototype.options.theme='a';
	$.mobile.listview.prototype.options.filterPlaceholder=lang.filter;
})(window,jQuery);
function redir(url,trans){
	if(offline){
		myDialog('#errorDialog',lang.noConnection);
	}else{
		//if(!url.match(/\.(html|php)/)) url='smt.html?page='+url;
		console.log('move to '+url);
		var goToURL=function(){
			if($.mobile.ajaxEnabled){
				//si estan activas las transiciones, se almacena el get en una cookie para poder utilizarla antes de que cargue la pagina (ver pageshow)
				var get=url.split('#')[0].split('?')[1];
				if(get&&get!='') $.session('get',get);
				$.mobile.changePage(url,{transition:(trans||'slide'),reloadPage:true});
			}else{
				window.location=url;
			}
		}
		if(menuVisible()){
			menuRun(goToURL);
		}else{
			goToURL();
		}
	}
}
function goBack(num){
	if(offline){
		myDialog('#errorDialog',lang.noConnection);
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
	}
	req.send();
	return txt;
}
//-- Menu --//
(function(document,window,$,console){
	function menuActions(data){
		//aqui se ejecutan las acciones aplicadas al menu
		console.log('menuActions');
		console.log(data);
		var func,$this=data.that;
		switch(data.opc){
			case 'home':case 'timeline':case 'news':
				func=function(){redir(PAGE[data.opc]);};
			break;
			case 'toptags'		:func=function(){redir(PAGE['toptags']);};break;
			case 'store'		:func=function(){redir(PAGE['storeCat']);};break;
			case 'cart'			:func=function(){redir(PAGE['shoppingCart']);};break;
			case 'wish'			:func=function(){redir(PAGE['storeOption']);};break;
			case 'myPubli'		:func=function(){redir(PAGE['storeMypubli']);};break;
			case 'notif'		:func=function(){redir(PAGE['notify']);};break;
			case 'friends'		:func=function(){redir(PAGE['userfriends']+'?type=friends&id_user='+$.local('code'));};break;
			case 'chat'			:func=function(){document.location=LOCAL?PAGE['chat']:'http://tagbum.com/cometchat/';};break;
			case 'profile'		:func=function(){redir(PAGE['profile']+'?id='+$.local('code'));};break;
			case 'profilepic'	:func=function(){redir(PAGE['profilepic']);};break;
			case 'myGroup'		:func=function(){redir(PAGE['tagslist']+'?current=group&id='+(data.group||$this.attr('group')));};break;
			case 'closedGroup'	:myDialog('#singleDialog','<sp>'+lang.GROUPS_CLOSE+'</sp><br><sp>'+lang.MSGGROUPS_CLOSE+'</sp>');break;
			case 'openGroup'	:func=function(){redir(PAGE['tagslist']+'?current=group&id='+idGroup)};break;
			case 'otherGroup'	:menuGroupsClose(data.group||$this.attr('group'));break;
			case 'moreGroups'	:func=function(){redir(PAGE['groupslist']+'?action='+(data.action||$this.attr('action')));};break;
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
						'<form role="search" action="'+PAGE['search']+'">'+
							'<input name="srh" type="search" class="ui-input-text ui-body-c" value="" onkeypress="return enterSubmit(event,this)" placeholder="'+lang.inputPlaceHolder+'"/>'+
						'</form>'+
					'</div>'+
			   '</li>'+
				'<li opc="timeline" onlyif="!window.location.href.match(/[\\/=]timeline/i)"><img src="img/home.png"/><div>'+lang.TIMELINE_TITLE+'</div><arrow/></li>'+
				'<li opc="toptags" onlyif="!window.location.href.match(/[\\/=]toptags/i)"><img src="img/topTags.png"/><div>'+lang.TOPTAGS_TITLE+'</div><arrow/></li>'+
				'<li opc="news" onlyif="!window.location.href.match(/[\\/=]news/i)"><img src="img/news.png"/><div>'+lang.NEWS+'</div><arrow/></li>'+
				'<li opc="notif" onlyif="!window.location.href.match(/[\\/=]notif/i)"><img src="img/notifications.png"/><div>'+lang.NOTIFICATIONS+'</div><span class="push-notifications"></span><arrow/></li>'+
				//'<li class="separator"></li>'+
				'<li opc="friends"><img src="img/friends.png"/><div>'+lan('friends','ucw')+'</div><arrow/></li>'+
				(PRODUCCION?
					'<li opc="chat"><img src="img/chat.png"/><div>'+lang.chat+'</div><arrow/></li>'
				:'')+
				//'<li opc="profilepic"><img src="img/profile.png"/><div>'+lan('Profile Picture')+'</div><arrow/></li>'+
				'<li opc="profile"><img src="img/profile.png"/><div>'+lang.profile+'</div><arrow/></li>'+
				'<li goto="store"><img src="img/store.png"/><div>'+lang.store+'</div><span class="icon"></span></li>'+
				'<li style="display:none;" goto="groups"><img src="img/group.png"/><div>'+lang.MAINMNU_GROUPS+'</div><span class="icon"></span></li>'+
				//'<li class="title"><img src="img/profile.png"/><div>Groups</div><span class="icon"/></li>'+
				//'<li goto="test"><div>test change menu</div><span class="icon"/></li>'+
				'<li opc="logout"><img src="img/logout.png"/><div>'+lang.logout+'</div><span class="icon"/></li>'+
			'</ul>'+
			'<ul id="store">'+
				'<li goback="main"><div>back to main</div><arrow/></li>'+
				'<li opc="store"><div>'+lan('store','ucw')+'</div><arrow/></li>'+
				'<li opc="cart"><div>'+lan('shopping cart','ucw')+'</div><arrow/></li>'+
				'<li opc="wish"><div>'+lan('wish list','ucw')+'</div><arrow/></li>'+
				'<li opc="myPubli"><div>'+lan('My publications','ucw')+'</div><arrow/></li>'+
			'</ul>'+
			//'<ul id="test">'+
			//	'<li goback="main"><div>back to main</div><arrow/></li>'+
			//'</ul>'+
			'';
		$('#menu .container').html(menu);
		$('#myMenu .container').html(menu);
		if(isLogged()&&!hideGroups) menuGroups($.local('code'));
		//out='<li goback="main"><div>'+lang.GROUPS_BACKMAIN+'</div><arrow/></li>';
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
							'<span>'+lang.MESSAGE_WELCOME+',</span><br/><em>'+($.local('full_name')||'')+'</em>'+
						'</div>'+
						'<div class="container"></div>'+
//						'<ul id="logout">'+
//							'<li opc="logout"><img src="img/logout.png"/><div>'+lang.logout+'</div><span class="icon"/></li>'+
//						'</ul>'+
					'</div>'+
					'<div class="overPage"/>'+
					'<div class="underPage"/>'+
				'</div>'
			);
			// Menu actions
			$('body')
				.on('pagebeforeshow','.ui-page',function(){console.log('beforeshow');hideMenu();})
				.on('swiperight','.ui-page-active .ui-header',function(){console.log('swipe right');showMenu();})
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
					{left:'-166px'},menuTime,function(){$(this).hide()}
				);
				$b.animate(
					{left:'0px'},menuTime
				);
			}).on('click','li[goback]',function(){
				var $a=$(this).parent(),
					$b=$('#menu .container #'+$(this).attr('goback'));
				$b.css('left','-166px').show();
				$a.animate(
					{left:'166px'},menuTime,function(){$(this).hide()}
				);
				$b.animate(
					{left:'0px'},menuTime
				);
			});
			hideMenu();
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
					var i,group,out='<li goback="main"><div>'+lang.GROUPS_BACKMAIN+'</div><arrow/></li>';
					if(data['myGroups']){
						out+='<li class="title"><div>'+lang.GROUPS_MYGROUPS+'</div><span class="icon"></span></li>';
						for(i in data['myGroups']){
							group=data['myGroups'][i];
							out+=
								'<li opc="otherGroup" group="'+md5(group['id'])+'">'+
									'<div style="font-size:12px;padding-left:10px">'+group['name']+'</div><span class="icon"></span>'+
								'</li>';
//							out+=
//								'<li opc="myGroup" group="'+md5(group['id'])+'" >'+
//									'<div style="font-size:12px;padding-left:10px">'+group['name']+'</div><span class="icon"></span>'+
//								'</li>';
						}
						out+='<li opc="moreGroups" action="3"><div style="font-size: 10px; padding-left: 65px">'+lang.GROUPS_MORE+'</div></li>';
					}
					if(data['allGroups']){
						out+='<li class="title"><div>'+lang.GROUPS_ALLGROUPS+'</div><span class="icon"></span></li>';
						for(i in data['allGroups']){
							group=data['allGroups'][i];
							out+=
								'<li opc="otherGroup" group="'+md5(group['id'])+'">'+
									'<div style="font-size: 12px; padding-left: 10px">'+group['name']+'</div><span class="icon"></span>'+
								'</li>';
						}
						out+='<li opc="moreGroups" action="2"><div style="font-size: 10px; padding-left: 65px">'+lang.GROUPS_MORE+'</div></li>';
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
				if(data['out']=='no'){
					menuActions({opc:'myGroup',group:id});
				}else{
					switch(data['out']){
						case 'si':myDialog('#singleDialog','<sp>'+lang.GROUPS_CLOSE+'</sp><br><sp>'+lang.MSGGROUPS_CLOSE+'</sp>');break;
						case 'invit':myDialog({
											id:'#singleDialog',
											content:'<div style="text-align:center;"><sp>'+lang.INVITE_GROUP_TRUE+'</sp><br>'+lang.CONFI_JOIN_TO_GROUPS+'</div>',
											buttons:[{
												name:lang.yes,
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
						case 'pend':myDialog('#singleDialog','<sp>'+lang.GROUPS_CLOSE+'</sp><br><sp>'+lang.MSGGROUPS_CLOSE_INVI_SED+'</sp>');break;
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
				myDialog('#singleDialog',lang.conectionFail);
			},
			success:function(data){
				if(data['accept']=='true'){
					menuActions({opc:'myGroup',group:id});
				}else if(data['accept']=='false'){

				}
				obje.close();
			}
		});
	}
	$(function(){
		putMenu();
		putMenuOptions();
	});
	window.showMenu=showMenu;
	window.hideMenu=hideMenu;
	window.menuVisible=function(){return menuStatus;}
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
			$(this).css({'font-size':(twidth/650)+'em'})
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
//		var actions=['pageshow'];
		if(is['device']){
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
	var thisPage=$.session('page')||arrayGet()['page'];
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
			myDialog('#errorDialog',lang.noConnection);
			return null;
		}
		if(more!=undefined){
			more.url=opc;
			opc=more;
		}
		//if($.local('host')) opc.url+=(opc.url.match(/\?/)?'&':'?')+'cors='+document.location.origin;
//		if($.local('enableLogs')&&!opc.noLog&&opc.log!==false){
		if($.local('enable_console')&&!opc.noLog&&opc.log!==false){
			var log={url:opc.url},s=opc.success,c=opc.complete;//,e=opc.error;
			if(opc.data) log.data=$.extend({},opc.data);
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
	var btnSponsor='',paypal='prueba';
	return(
	'<div tag="'+tag['id']+'" udate="'+tag['udate']+'">'+
		'<div class="minitag" style="background-image:url('+tag['imgmini']+')"></div>'+
		'<div class="tag" style="background-image:url('+tag['img']+')"></div>'+
		'<div class="bg"></div>'+
			(isLogged()?
		'<menu>'+
			'<ul>'+
				(tag['business']?
					'<li id="bcard" action="card,'+tag['business']+'" title="Bussines Card"><span>Bussines Card</span></li>'
				:'')+
				'<li id="like" action="like,'+tag['id']+'"'+(tag['likeIt']>0?' style="display:none;"':'')+' title="Like"><span>Like</span></li>'+
				'<li id="dislike" action="dislike,'+tag['id']+'"'+(tag['likeIt']<0?' style="display:none;"':'')+' title="Dislike"><span>Dislike</span></li>'+
				(!tag['popup']?
					'<li id="comment" title="Comment"><span>Comment</span></li>'
				:'')+(btn['redist']?
					'<li id="redistr" title="Redist"><span>Redist</span></li>'
				:'')+(btn['share']?
					'<li id="share" title="Share"><span>Share</span></li>'
				:'')+btnSponsor+(btn['trash']?
					'<li id="trash" title="Trash"><span>Trash</span></li>'
				:'')+((tag['product'])?(btn['edit']?
					'<li id="edit" action="editProductTag,'+tag['id']+','+tag['product']['id']+'" title="Edit"><span><?=$lang["MNUTAG_TITLEEDIT"]?></span></li>'
				:''):(btn['edit']?
					'<li id="edit" title="Edit2"><span>Edit2</span></li>'
				:''))+(btn['report']?
					'<li id="report" title="Report"><span>Report</span></li>'
				:'')+
			'</ul>'+
		'<div class="clearfix"></div></menu>'
		:'<div id="menuTagnoLogged"></div>')+
		'<div class="tag-icons">'+
			'<div id="sponsor" '+(tag['sponsor']?'':'style="display:none;"')+'></div>'+
			'<div id="redist" '+(tag['redist']?'':'style="display:none;"')+'></div>'+
			'<div id="likeIcon" '+(tag['likeIt']>0?'':'style="display:none;"')+'></div>'+
			'<div id="dislikeIcon" '+(tag['likeIt']<0?'':'style="display:none;"')+'></div>'+
		'</div>'+
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

function showTags(array){//tag list
	var i,tags='';
	for(i in array)
		tags+=showTag(array[i]);
//		tags+='<div class="tag-loading smt-container"><div class="smt-content" style="z-index:4;">Loading...</div></div>'+showTag(array[i]);
	return '<div class="tag-container">'+tags+'</div>';
}

(function(window,$,console){
	window.updateTags=function(action,opc,loader){
		if(!opc.on) opc.on={};
		var act,
			current=opc.current,
			on=opc.on,
			layer=opc.layer,
			get=opc.get||'',
			limit=opc.limit||'15',
			notag=opc.notag||lang.EMPTY_TAGS_LIST,
			//se cancela la action si no hay current o si se esta ejecutando reload
			cancel=function(){return current==''||opc.current!=current||(action!='reload'&&on['reload']);},
			//se asigna y/o devuelve el estatus de la accion actual
			onca=function(val){if(val!==undefined)on[action]=val;return on[action];};
		if(!cancel()&&!onca()){
			onca(true);
			if(!opc.actions||action=='reload'){
				opc.actions={refresh:{},more:{}};
				opc.date='';
				$(layer).html('');
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
				data:act||{},
				url:DOMINIO+'controls/tags/tagsList.json.php?limit='+limit+'&current='+current+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
				success:function(data){
					if(cancel()){
						console.log('Cancelada carga de '+current+'.'); return;
					}else{
						console.log(data)
						if(action=='more'&&(!data['tags']||data['tags'].length<1)) act.more=false;
						if(data['tags'] && data['tags'].length>0){
							opc.date=data['date'];
							if(data['sp']) act.sp=data['sp'];
							var tags='',i,len=data['tags'].length,$tag,$remove,sp;
							if(data['sponsors']) sp=data['sponsors'].length;
							else sp=0;
							act.start=(act.start||0)+data['tags'].length-sp;
							act.startsp=(act.startsp||0)+sp;
							act.idsponsor=data['idsponsor'];
							for(i=0;i<len;i++){
								$tag=$(layer).find('[tag="'+data['tags'][i]['id']+'"]');
								if($tag.length>0)
									if($remove) $remove.add($tag); else $remove=$tag;
							}
							tags+=showTags(data['tags']);
							if($remove) $remove.remove();
							if(action=='more')
								$(layer).append(tags);
							else
								$(layer).prepend(tags);
						}else if(action=='reload'){
							$(opc.layer).html(
								'<div><div class="tag-loading smt-container" style="max-height:300px;height:300px;"><div id="noTags" class="smt-content" style="z-index:4;">'+notag+'</div></div><div class="smt-tag"><img src="../img/placaFondo.png" class="tag-img" style="z-index:3;"></div></div>'
							);
							if(current=='group'){
								verifyGroupMembership(opc.id,opc.code,function(data){
//									alert(opc.code);
									if(data['isMember']){
										$('#noTags').html(lang.GROUPS_MESSAGE_TAGS);
									}else{
										$('#noTags').html(lang.GROUPS_MESSAGE_TAGS+' '+lang.GROUPS_MESSAGE_JOIN);
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
	}
	var on={};
	window.updateTagsOld=function(action,opc){
		var act,
			current=opc.current,
			layer=opc.layer,
			get=opc.get||'',
			limit=opc.limit||'15',
			cancel=function(){return current==''||(action!='reload'&&on['reload']);},//cancel action
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
				url:DOMINIO+'controls/tags/tagsList.json.php?current='+current+'&limit='+limit+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
				success:function(data){
					if(action=='more'&&(!data['tags']||data['tags'].length<1)) act.more=false;
					if(!cancel()){
						if(data['tags']&&data['tags'].length>0){
							opc.date=data['date'];
							if(data['sp']) act.sp=data['sp'];
							var tags='',i,len=data['tags'].length,$tag,sp,$remove;
							if(data['sponsors']) sp=data['sponsors'].length;
							else sp=0;
							act.startsp=(act.startsp||0)+sp;
							act.start=(act.start||0)+data['tags'].length-sp;
							act.idsponsor=data['idsponsor'];
							for(i=0;i<len;i++){
								$tag=$(layer).find('[tag="'+data['tags'][i]['id']+'"]');
								if($tag.length>0)
									if($remove) $remove.add($tag); else $remove=$tag;
							}
							console.log(data['tags']);
							tags+=showTags(data['tags']);
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
								'<div><div class="tag-loading smt-container" style="max-height:300px;height:300px;"><div id="noTags" class="smt-content" style="z-index:4;">'+lang.EMPTY_TAGS_LIST+'</div></div><div class="smt-tag"><img src="../img/placaFondo.png" class="tag-img" style="z-index:3;"></div></div>'
							);
							if(current=='group'){
								verifyGroupMembership(opc.id,opc.code,function(data){
//									alert(opc.code);
									if(data['isMember'])
										$('#noTags').html(lang.GROUPS_MESSAGE_TAGS);
									else
										$('#noTags').html(lang.GROUPS_MESSAGE_TAGS+' '+lang.GROUPS_MESSAGE_JOIN);
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
	}
})(window,jQuery,console);

function viewFriends(opc){
	console.log('viewfriends');
	myAjax({
		type:'POST',
		url:DOMINIO+'controls/users/people.json.php?nosugg&action=friendsAndFollow&code&mod='+opc.mod+opc.get,
		data: {uid: opc.user },
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success:function(data){
			if (data['error']) return;
			var i,friend,out='',divider;
			console.log(opc.user)
			// if($.local('code')==opc.user){
				switch(opc.mod){
					case 'friends':divider=lan('friends','ucw');break;
					case 'follow':divider=lan('admirers','ucw');break;
					case 'unfollow':divider=lan('admired','ucw');break;
				}
			// }
			divider='<li data-role="list-divider">'+(opc.mod=='find'?lang.FINDFRIENDS_LEGENDOFSEARCHBAR:divider+' <span class="ui-li-count">'+data['num']+'</span>')+'</li>';
			for(i=0;i<data['datos'].length;i++){
				friend=data['datos'][i];
				out+=
					'<li class="userInList">'+
						'<a code="'+friend['code_friend']+'" data-theme="e">'+
							'<img src="'+friend['photo_friend']+'"'+'class="ui-li-thumb userBR" width="60" height="60"/>'+
							'<h3 class="ui-li-heading">'+friend['name_user']+'</h3>'+
							'<p class="ui-li-desc">'+
								lan('friends','ucw')+' ('+(friend['friends_count']||0)+'), '+
								lan('admirers','ucw')+' ('+(friend['followers_count']||0)+'), '+
								lan('admired','ucw')+' ('+(friend['following_count']||0)+')'+
							'</p>'+
						'</a>'+
						//'<a>test</a>'+
					'</li>';
			}

			$(opc.layer).html(divider+out).listview('refresh');
			$('.list-wrapper').jScroll('refresh');
		}
	});
}

/**
 * Muestra contactos agregados en la agenda del telefono
 * @param  {string} idLayer [selector de elemnto donde se cargaran los contactos]
 * @param  {[string]} filter  [filter cadena para filtrar contactos a buscar por: email, numero telefonio o nombre]
 * @return {[boolean or none]}	[none]
 */
function viewContacsPhone(idLayer,filter){
	if(CORDOVA){
		filter=(filter||'');
		var out='';

		function onSuccess(contacts){
			var emailSent=$.local('emails_sent')||[];
			for(var i=0;i<contacts.length;i++){
				if(contacts[i].emails){
					var photo=(contacts[i].photos)?contacts[i].photos[0].value:'css/tbum/usr.png';
					out+=
					'<li class="userInList">'+
						'<a email="'+contacts[i].emails[0].value+'" data-theme="e">'+
							'<img src="'+photo+'"'+'class="ui-li-thumb" width="60" height="60"/>'+
							'<h3 class="ui-li-heading">'+contacts[i].name.formatted+'</h3>'+
							'<p class="ui-li-desc">'+
								'<img src="img/phone.png" alt="'+lang.FIENDFRIENDS_PHONECONTACT+'" widt="16" height="16" />'+
								lang.FIENDFRIENDS_PHONECONTACT+
								'<span class="status-invitation">&nbsp;'+($.inArray(contacts[i].emails[0].value,emailSent)>-1?lang.FIENDFRIENDS_INVITED:'')+'</span>'+
							'</p>'+
						'</a>'+
					'</li>';
				};
			}

			$(idLayer).html(out).listview('refresh');
			$('.list-wrapper').jScroll('refresh');
		};

		function onError(contactError){
			return false;
		};

		var options=new ContactFindOptions();
		options.filter=filter;
		options.multiple=true;
		var fields=["displayName","name","phoneNumbers","emails","photos"];
		navigator.contacts.find(fields,onSuccess,onError,options);
	}
}

function verifyGroupMembership(idGroup,code,func){
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/groups/menuGroupUser.json.php?action=6&code='+code+'&idGroup='+idGroup,
		dataType:'json',
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success:func
	});
}

function insertUserGroup(idGroup){
	var code=$.local('code');
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/groups/menuGroupUser.json.php?action=7&code='+code+'&idGroup='+idGroup,
		dataType:'json',
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
			if(data=='1')
				redir(PAGE['tagslist']+'?current=group&id='+idGroup);
		}
	});
}

function preferencesUsers(usr){
	var code=usr||$.local('code');
	myAjax({
		type	:'GET',
		url		:DOMINIO+'controls/users/preferences.json.php?action=1&code='+code,
		dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
			var i,pref,out='',text=['',lang.PREFERENCES_WHATILIKE,lang.PREFERENCES_WHATIWANT,lang.PREFERENCES_WHATINEED];
			for(i in data['dato']){
				out+='<li style="text-align:center;"><strong>'+text[i]+'</strong></li>';
				for(j in data['dato'][i]){
					pref=data['dato'][i][j];
					out+='<li>';
					if(code==$.local('code'))
						out+='<img src="img/trash.png" pref="'+pref['id']+'" type="'+i+'"/>&nbsp;';
					out+=pref['text']+'</li>';
				}
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
								myDialog('#singleDialog',lang.conectionFail);
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
	$.cookie('last',opc['last']||$.cookie('last'),{expires:navigator.app?365:15});
}
function delAllLocals(){
	$.session.clear();
	$.local.clear();
	$.cookie.clear();
}
function setAllLocals(opc){
	opc=opc||{};
	$.session.clear();
	//$.cookie.clear().set(opc['cookies']||{});
	$.local.clear().set(opc['locals']||{});
	//$.cookie('last',opc['cookies']['last']||$.cookie('last'),{expires:CORDOVA?365:15});
}

function login(opc){
	//console.log('Login.....o');
	if(opc&&opc.data){
		opc.data.lng=lang.actual;
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
					myDialog('#log-msg',lang['CON_ERROR']);
			},
			success:function(data){
				if(data&&data['logged']){
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
						myDialog('#log-msg',data['msg']);
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
			myDialog('#log-msg',lang.conectionFail);
		},
		success:function(data){
			if(data['logout']){
				isLogged(false);
				$.session.clear();
				$.local.clear();
				$.cookie.clear();
				if(move!==false) redir(PAGE['ini']);
			}else{
				myDialog('#log-msg',data['msg']);
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
	if(!is['android']&&(tecla==10||tecla==13)){
		$(obj).parents('form').submit();
	}
	return true;
}

function enterTab(e,obj){
	tecla=document.all?e.keyCode:e.which;
	if(!is['android']&&(tecla==10||tecla==13)){
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
	var $d=$(o.id);//dialog pointer
	if($('.buttons',$d).length<1){
		$('.window',$d).append('<div class="buttons"></div>');
	}
	if($('.closedialog',$d).length<1){
		$d.append('<div class="closedialog" style="display:none"></div>');
	}
	restoreInputs=disableInputs(o.id);
	o.close=function(calle){
		restoreInputs();
		$('.window',$d).fadeOut('fast',function(){
			if(typeof calle==='function')
				$d.fadeOut('fast',calle);
			else
				$d.fadeOut('fast');
		});
	};
	$('.closedialog',$d).one('click',o.close);
	if(!o.buttons){
		o.buttons={Ok:o.close};
	}
	if(!(o.buttons instanceof Array)){
		var i,button=[];
		for(i in o.buttons){
			button.push({
				text:i,
				click:o.buttons[i]
			});
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
	$('input:checkbox',container).each(function(){this.checked=value;});
	return false;
}

function getFriends(id,like){
	like=like?'&like='+like:'';
	var emails=[];
	$('#pictures_shareTag input').each(function(){
		emails.push($(this).val());
	});
	myAjax({
		loader	:true,
		type	:'POST',
		url		:DOMINIO+'controls/users/people.json.php?nosugg&action=friendsAndFollow&code'+like,
		data:{uid:id},
		dataType:'json',
		success	:function(data){
			var ret='';
			for(var i in data['datos']){
				if(emails.join().indexOf(data['datos'][i]['email'])<0)
				ret+=
					'<div onclick="$(\'input\',this).attr(\'checked\',($(\'input\',this).is(\':checked\'))?false:true);" style="height:60px;min-width:200px;padding:5px 0px 5px 0px;border-bottom:solid 1px #D4D4D4;">'+
						'<div style="float:right;padding-top:20px;margin-right:15px;">'+
							'<fieldset data-role="controlgroup">'+
								'<input value="'+data['datos'][i]['email']+'|'+data['datos'][i]['photo_friend']+'" type="checkbox" />'+
							'</fieldset>'+
						'</div>'+
						'<img src="'+data['datos'][i]['photo_friend']+'" style="float:left;width:60px;height:60px;" class="userBR"/>'+
						'<div style="float:left;margin-left:5px;font-size:10px;text-align:left;">'+
							'<spam style="color:#E78F08;font-weight:bold;">'+data['datos'][i]['name_user']+'</spam><br/>'+
							(data['datos'][i]['country']?lang.country+':'+data['datos'][i]['country']+'<br/>':'')+
							''+lan('friends','ucw')+'('+data['datos'][i]['friends_count']+')<br/>'+
							''+lan('admirers','ucw')+'('+data['datos'][i]['followers_count']+')'+
						'</div>'+
					'</div>';
			}
			$('.list-wrapper #scroller').html('<div style="padding:5px;text-align:center;">'+ret+'</div>');
			$('.list-wrapper').jScroll('refresh');
		},
		error	:function(){
			myDialog('#singleDialog','ERROR-getFriends');
		}
	});
}

function selectFriendsDialog(id){
	console.log('selectfriendsdialog');
	$('html,body').animate({scrollTop:0},'fast',function(){
		myDialog({
			id:'shareTagDialog',
			style:{'min-height':200},
			buttons:{},
			after:function(options,dialog){
				getFriends(id);
				var timer;
				$('#like_friend',dialog).unbind('keyup').bind('keyup',function(event){
					if(event.which==8||event.which>40){
						if(timer) clearTimeout(timer);
						timer=setTimeout(function(){
							getFriends(id,$('#like_friend',dialog).val());
						},1000);
					}
				});
			}
		});
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
	console.log('membersGroupDialog');
	$('.closedialog',idDialog).click();
}

function getDialogCheckedUsers(idDialog){
	console.log('getCheckedUsers');
	var paso=false;
	$('input:checkbox[checked]',idDialog).each(function(i,field){
		var userInfo=field['value'].split('|');
		if(userInfo[1]){
			$('#pictures_shareTag').append(
				'<span id="'+md5(userInfo[0])+'" onclick="removePicture(this)">'+
					'<input type="hidden" name="x" value="'+userInfo[0]+'" type="text"/>'+
					'<img src="'+userInfo[1]+'" width="40" style="margin-left: 5px; border-radius: 5px;" class="userBR"/>'+
				'</span>'
			);
			paso=true;
		}
	});
	if(paso) $('#title_pictures_shareTag').fadeIn('slow');
	$('.closedialog',idDialog).click();
	checkboxPublicPrivateTag();
}

function sendInvitationMemberGrp(idDialog){
	console.log('sendInvitationMemberGrp');
	var friends=$('input:checkbox[checked]',idDialog).length;
	$('input:checkbox[checked]',idDialog).each(function(i,field){
		var userInfo=field['value'].split('|');
		myAjax({
			url		:DOMINIO+'controls/groups/sendInvitacionGroup.json.php?idGroup='+userInfo[2]+'&idUser='+md5(userInfo[1]),
			dataType:'JSON',
			success	:function(data){
				if(data=='1'){
					if(i==(friends-1)){
						myDialog('#singleDialog',lang.GROUPS_SENDINVITATION);
					}
				}
			},
			error	:function(){
				myDialog('#singleDialog','ERROR-invitedFriends');
			}
		});
	});
	$('.closedialog',idDialog).click();
}

function sendadminGroup(idDialog){
	console.log('sendadminGroup');
	var friends=$('input:checkbox[checked]',idDialog);
	console.log('num friends='+friends.length);
	$.each(friends,function(i,field){
		//alert (field['value']);
		var userInfo=field['value'].split('|');
		myAjax({
			url		:DOMINIO+'controls/groups/sendAdminMemberGroup.json.php?idGroup='+userInfo[2]+'&idUser='+md5(userInfo[1])+'&code='+$.local('code'),
			dataType:'JSON',
			success	:function(data){
				//alert (data);
				if(data=='1'){
					if(i==(friends.length-1)){
						myDialog({
							id:'#invitationSending',
							content:lang.GROUPS_LEAVECCOMPLETE,
							buttons:{
								ok:function(){
									window.location=PAGE['groupslist']+'?action=2';
								}
							}
						});
					}
				}
			},
			error:function(){
				myDialog('#singleDialog','ERROR-AssignAdmin');
			}
		});
	});
	$('.closedialog',idDialog).click();
}

function checkboxPublicPrivateTag(){
	if($('#div_publicTag').length>0)
		$('#div_publicTag_checkbox').attr('checked',$('#pictures_shareTag').html()=='').checkboxradio('refresh');
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
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lang.SCROLL_PULLDOWN;
						}else if(pullUpEl.className.match('loading')){
							pullUpEl.className='';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lang.SCROLL_PULLUP;
						}
					},
					onScrollMove:function(){
						if(this.y>5&&!pullDownEl.className.match('flip')){
							pullDownEl.className='flip';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lang.SCROLL_RELEASE;
							this.minScrollY=0;
						}else if(this.y<5&&pullDownEl.className.match('flip')){
							pullDownEl.className='';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lang.SCROLL_PULLDOWN;
							this.minScrollY=-pullDownOffset;
						}else if(this.y<(this.maxScrollY-5)&&!pullUpEl.className.match('flip')){
							pullUpEl.className='flip';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lang.SCROLL_RELEASE;
							this.maxScrollY=this.maxScrollY;
						}else if(this.y>(this.maxScrollY+5)&&pullUpEl.className.match('flip')){
							pullUpEl.className='';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lang.SCROLL_PULLUP;
							this.maxScrollY=pullUpOffset;
						}
					},
					onScrollEnd:function(){
						if(pullDownEl.className.match('flip')){
							pullDownEl.className='loading';
							pullDownEl.querySelector('.pullDownLabel').innerHTML=lang.SCROLL_LOADING;
							if(typeof options.onPullDown=='function'){
								options.onPullDown.call(this,this);//Execute custom function (ajax call?)
							}else{
								setTimeout(this.refresh,1000);
							}
						}else if(pullUpEl.className.match('flip')){
							pullUpEl.className='loading';
							pullUpEl.querySelector('.pullUpLabel').innerHTML=lang.SCROLL_LOADING;
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
		}
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
			myDialog('#singleDialog',lang.conectionFail);
		},
		success:function(data){
			console.log(data);
			var out='',cate;
			if (data['data'].length>0){
				for(var i in data['data']){
					cate=data['data'][i];
					out+=
						'<li class="categorylist">'+
							'<a code='+cate['id']+' data-theme="e">'+
								(cate['photo']?'<img src="'+cate['photo']+'" style="width:80px;height:50px;margin:20px 0 0 8px;border-radius:10px">':'')+
								'<p><h3 class="ui-li-heading">'+cate['name']+'</h3>'+
								(cate['cant']?'<span class="ui-li-count">'+cate['cant']+'</span>':'')+
							'</p></a>'+
						'</li>';
				}
			}else{
				myDialog({
					id:'#idDontStore',
					content:'<center><strong>'+lang.STORE_NOSTORE_MESSAGE+'</strong></center>',
					scroll:true,
					buttons:{ ok:'close' }
				});
			}
			if(data['sCart']) $('#cart-footer').fadeIn();
			$(idLayer).html(out).listview('refresh');
			$('.list-wrapper').jScroll('refresh');
		}
	});
}
function bodyCart(data){
	var i,out='',num=0,outDivider='<li data-role="list-divider" class="titleDivider">'+lang.STORE_SHOPPING_TOTAL+' ('+data['nproduct']+')';
	for(i=0;i<data['datosCar'].length;i++){
		var select='';
		if(data['datosCar'][i]['place']=='1' && parseInt(data['datosCar'][i]['stock'])>0){
			$('#productApp').val('si');
			var option='';
			select='<select class="cant-product" name="select-choice-mini" id="select-choice-mini" data-mini="true" data-inline="true"'+
						' cantAct="'+(data['datosCar'][i]['sale_points']*data['datosCar'][i]['cant'])+'" precio="'+data['datosCar'][i]['sale_points']+'" '+((data['datosCar'][i]['formPayment']=='1')?'fr="1"':'fr="0"')+'>';
			for(var j=1;j<=(parseInt(data['datosCar'][i]['stock']));j++){
				option+='<option value="'+j+'" '+(data['datosCar'][i]['cant']==j?'selected':'')+'>'+j+'</option>';
			}
			select=select+option+'</select>';
		}else if(data['datosCar'][i]['place']=='1' && data['datosCar'][i]['stock']<=0){
			$('#productApp').val('si');
			select='<em class="info-top-p">'+lang.TAGS_WHENTAGNOEXIST+'</em><input type="hidden" class="cant-product"  value="'+data['datosCar'][i]['cant']+'">'
		}
		if(data['datosCar'][i]['formPayment']=='1'){ $('#dollarApp').val('si'); }
		out+='<li id="'+data['datosCar'][i]['mId']+'" >'+
				'<div class="contentItem">'+
					'<div class="itemPic">'+
						'<img src="'+data['datosCar'][i]['photo']+'"/>'+
					'</div>'+
					'<div class="itemDes">'+
						'<div class="name">'+data['datosCar'][i]['name']+'</div>'+
						'<div><strong>'+lang.STORE_SHOPPING_SELLER+':</strong> '+data['datosCar'][i]['nameUser']+'</div>'+
						'<div>'+data['datosCar'][i]['nameC']+' > '+data['datosCar'][i]['nameSC']+'</div>'+
						'<div class="price">'+lang.STORE_SHOPPING_VALUE+': '+data['datosCar'][i]['sale_points']+' '+(data['datosCar'][i]['formPayment']=='1'?lang.STORE_SHOPPING_DOLLARS:lang.STORE_SHOPPING_POINTSMA)+'</div>'+
						select+
					'</div>'+
				'</div><br/>'+
				'<div class="buttons">'+
					'<a func="details" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f"><span class="ui-btn-inner"><span class="ui-btn-text">'+lang.STORE_SHOPPING_DETAILS+'</span></span></a>'+
					'<a func="delete" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f"><span class="ui-btn-inner"><span class="ui-btn-text">'+lang.STORE_SHOPPING_ITEM+'</span></span></a>'+
					'<a func="sendWish" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f"><span class="ui-btn-inner"><span class="ui-btn-text">'+lang.STORE_WISH_LIST_MOVE+'</span></span></a>'+
				'</div>'+
			'</li>';
	}
	if(data['totalpoints']>0){
		outDivider+='<div class="point">'+
						lang.STORE_SHOPPING_TOTAL_PRODUCTS+
						'<span>'+data['totalpoints']+'</span>'+
						'<input type="hidden" value="'+data['totalpoints']+'">'+
					'</div>';
	}
	if(data['totalmoney']>0){
		outDivider+='<div class="money">'+
						lang.STORE_SHOPPING_TOTAL_PRODUCTSD+
						'<span>'+data['totalmoney']+'</span>'+
						'<input type="hidden" value="'+data['totalmoney']+'">'+
					'</div>';
	}
	outDivider+='</li>';
	return outDivider+out;
}
function actionButtonsStore(){
	$('#lstStoreOption .buttons a,#cartList .buttons a').click(function(){
			switch($(this).attr('func')){
				case 'details':redir(PAGE['detailsproduct']+'?id='+$(this).parents('li').attr('id'));break;
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
					console.log(auxi);
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
			myDialog('#singleDialog',lang.conectionFail);
		},
		success:function(data){
			console.log(data);
			if(data['del']!='1'){
				if(data['del']=='all'){
					if(obj.mod=='car'){redir(PAGE['storeCat']);}
				}else if(data['del']=='no-all'){

				}
			}else{
				var num=data['numR'];
				if(num!=0){
					if(obj.mod!='wish'){
						if(data['datosCar'][0]['name']){
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
						$('#lstStoreOption').html(data['wish']['body']).listview('refresh');
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
			diferencia=0,objeto=$(this),linea=$(this).parents('li').attr('id');
			diferencia=cantAct*$(this).attr('precio');
		myAjax({
			type:'POST',
			url:DOMINIO+'controls/store/shoppingCart.json.php?action=15&linea='+linea+'&cant='+objeto.val(),
			dataType:'json',
			success:function(data){
				console.log([diferencia,totalAct,totalAnt]);
				if(data['datosCar']=='update'){
					objeto.attr('cantAct',diferencia);
					if(tipo==1){
						var	totalAct=$('#cartList .titleDivider .money input').val();
						$('#cartList .titleDivider .money imput').val((totalAct-(totalAnt))+(diferencia));
						$('#cartList .titleDivider .money span').html((totalAct-(totalAnt))+(diferencia));
						//$('#totalPriceMoney').html((totalAct-(totalAnt))+(diferencia)).formatCurrency({symbol:''});
					}else{
						var	totalAct=$('#cartList .titleDivider .point input').val();
						$('#cartList .titleDivider .point imput').val((totalAct-(totalAnt))+(diferencia));
						$('#cartList .titleDivider .point span').html((totalAct-(totalAnt))+(diferencia));
						//$('#totalPrice').html((totalAct-(totalAnt))+(diferencia)).formatCurrency({symbol:''});
						//var auxi=$('#totalPrice').html().split('.');
	//														$('#totalPrice').html(auxi[0]);
					}
				}else{
					myDialog({
						content:lang.STORE_ORDER_EDIT_STOCK,
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
function getProducts(layer,category,subcategory){
	myAjax({
		type	:'GET',
		url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module=store&limit=0&c='+category+'&sc='+subcategory,
		dataType:'json',
		error	:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
			var out='',num=0,prod=data['prod'],category,idcategory;
			for(var i=0;i<prod.length;i++){
				out+=
					(num++<1?' <li data-role="list-divider">'+prod[i]['titleList']+'</li>':'')+
					'<li date="'+prod[i]['join_date']+'" idPro="'+prod[i]['id']+'">'+
						'<a><img src="'+prod[i]['photo']+'" style="width:100px;height:60px;margin:20px 0 0 8px;border-radius:10px">'+
							'<p id="nameProduct">'+prod[i]['name']+'</p>'+
							'<p id="descripProduct">'+prod[i]['description']+'</p>'+
							'<p class="date"><strong>Published:</strong> '+prod[i]['join_date']+'</p>'+
						'</a>'+
					'</li>';
				category=prod[i]['category'];
				idcategory=prod[i]['mid_category'];
			}
			$(layer).html(out).listview('refresh');
			$('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+category+'</span></span>').attr('code',idcategory);
			$('.list-wrapper').jScroll('refresh');
		}
	});
}
function addProductShoppingCart(id,wish){
	wish=wish?wish:'';
	myAjax({
		type:'GET',
		url:DOMINIO+'controls/store/shoppingCart.json.php?action=1&add=si&id='+id,
		dataType:'json',
		error:function(/*resp,status,error*/){myDialog('#singleDialog',lang.conectionFail);},
		success:function(data){
			if(data['datosCar2']['add']=='si'){
				if(data['datosCar2']['order']){
					myDialog({
						content:data['datosCar2']['order'],
						scroll:true,
						buttons:{ok:function(){redir(PAGE['shoppingCart']);}}
					});
				}else{redir(PAGE['shoppingCart']);}
			}else if(data['datosCar2']['add']=='no'){
				if(wish){$.each(wish,function(){$(this).attr('func',$(this).attr('func2')).removeAttr('func2');});}
				switch(data['datosCar2']['msg']){
					case 'no-disponible':
						myDialog({
							content	:lang.TAGS_WHENTAGNOEXIST,
							scroll:true,
							buttons:{'ok':function(){location.reload();}}
						});
						break;
					case 'backg':myDialog('#information',lang.STORE_UNI_BACKG);break;
					case 'no-stock':myDialog('#information',lang.STORE_PRODUCTO_NO_STOCK);break;
					case 'no-product':break;
				}
			}
		}
	});
}
function moveToWish(id,get){
		get=get?get:'';
		myAjax({
			type:'GET',
			url:DOMINIO+'controls/store/shoppingCart.json.php?action=14&id='+id+get,
			dataType:'json',
			success:function(data){
				var dato=data['listWish'];
				if(data['numRow']>0){
					if(data['datosCar']){
						if(data['datosCar'][0]['name']){
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
					if(data['wish']&&data['wish']['body']){
						//$('#list_orderProduct_wish ul').html(data['wish']['body']);
						//$('.button').button();
					}else{
						//$('#list_orderProduct_wish').empty().html('').css('display','none');
					}
				}else{
					if(data['wish']&&data['wish']['body']){
						//$('#list_orderProduct_wish ul').html(data['wish']['body']);
						//$('.button').button();
					}else{
						myDialog('#singleDialog','<div><strong>'+lang.STORE_NO_SC+'</strong></div>');
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
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
			if(data['productMobile']){$.loader('show');redir(PAGE['storeOption']+'?option=1');}
			else if(data['formPaymentD']){
				myDialog('#singleDialog',lang.STORE_NOT_CHET_DOLLAR);
			}else{
				//alert(data['nOrden']+'+++'+data['nproduct'])
				if(data['datosCar']=='noCredit'){
					myDialog({
						id:'#idCheckOutAppNo',
						style:{'min-height':80},
						content:lang.STORE_SHOPPING_NOPOINTS,
						scroll:true,
						buttons:{
							ok:'close'
						}
					});
					//alert(lang.STORE_SHOPPING_NOPOINTS);
				}else{
					myDialog({
						id:'#idCheckOutAppDone',
						style:{'min-height':80},
						content:lang.PUBLICITY_MSGSUCCESSFULLY+'. '+lang.RESET_PLEASECHECKEMAIL,
						scroll:true,
						buttons:{ok:function(){redir(PAGE['storeCat']);}}
					});
					//redir(PAGE['orderdetails']+'?nOrden='+data['nOrden']);
				}
			}
		}
	});
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
		'<li comment="'+comment['id']+'"'+(comment['short']?' class="more"':'')+'>'
			+'<img src="'+(comment['photoUser']||'css/tbum/usr.png')+'" class="ui-li-thumb" width="60" height="60" />'
			+(comment['delete']?''/*'<img src="css/smt/delete.png" class="del"/>'/**/:'')
			+'<em class="ui-li-asid">'+comment['commentDate']+'</em>'
			+'<div class="text">'
				+'<h4>'+comment['nameUser']+'</h4>'
				+'<p>'+comment['comment']+'</p>'
				+(comment['short']?'<p class="short">'+comment['short']+'</p>':'')
			+'</div>'
			+(comment['short']?'<div class="seemore">'+lan('see more','ucf')+'</div>':'')
			+'<div class="clearfix"></div>'
		+'</li>'
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
			cancel=function(){return (action!='reload'&&on['reload']);},//cancel action
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
			loader:action!='refresh',
			success:function(data){
				if(!data) return;
				if(data['deleted']){//si fue una eliminacion
					opc.start--;
					var $ul=protected.parent();
					protected.fadeOut(600,function(){
						console.log($ul.children(':visible').length);
						if(!$ul.children(':visible').length)
							$('.seemore',$header[0]).click();
					});
					return;
				}
				var head='<li data-role="list-divider">'+lan('Comments')
							+'<div id="numDislikes">'+(data['dislikes']||0)+'</div>'
							+'<div id="numLikes">'+(data['likes']||0)+'</div>'
						+'</li>'
						+'<li data-role="list-divider" data-theme="c" class="header">'
							+lan('see more','ucf')+' <span class="loader"/><div class="seemore">(<span class="count"></span>)</div>'
						+'</li>';
				if(cancel()){console.log('Cancelados comentarios: '+action);return;}
//				console.log(data);
				if(!data||!data['list']||!data['list'].length) return;
				var list='',len=data['list'].length,rep=0,i;
				for(i=len-1;i>=0;i--){//eliminar repeticiones
					if($list.find('[comment='+data['list'][i]['id']+']').length>0){
						rep++;
						data['list'].splice(i,1);
					}
				}
				list=showComments(data['list']);
				opc.date=data['date'];
				opc.start+=len-rep;
//				console.log(list);
				$list.find('.ui-li-divider').remove();
				if(action=='reload'){
					$list.html(list);
				}else if(action=='refresh'||action=='insert'){
					$list.append(list);
				}else{
					$list.prepend(list);
				}
				$list.prepend(head).listview('refresh');
				$header=$('.header',layer);
				if(action!='refresh'&&action!='insert'){
					opc.total=data['total']*1;
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
		if(opc.data.txt=='') return;
		return _getComments('insert',opc,true);
	};
	window.delComment=function(el,opc){
		var id=el.attr('comment');
		console.log('delcomment='+id);
		if(!id) return;
		opc.data.id=id;
		return _getComments('del',opc,el);
	};
})(window);
