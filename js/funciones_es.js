function pageAction(action,data){
	$.debug().log({action:action,data:data,opc:opc});
	data=''+(data||'');
	var $tag,capa,opc=data.split(',');
	switch(action){
		case 'redir'	:redir(data);break;
		case 'goHome'	:redir();break;
		case 'exProfile':redir(opc[0]);break;
		case 'linkUser' :
			if (!opc[1]) opc[1]=0;
			linkUser(opc[0],this,opc[1]);
		break;
		case 'banner'	:window.open(data,'_blank');break;
		case 'logout'	:if(isLogged()) logout();break;
		case 'profile'	:userProfile(opc[1]||'Perfil',opc[0]);break;
		case 'tag/comment':case 'comment':
			if(navigator.userAgent.match(/chrome/i))
				redir('tag/'+opc[0]);
			else
				commentTag(opc[1],opc[0]);
		break;
		case 'video'	:openVideo(this);break;
		case 'videoc'	:closeVideo(this);break;
		case 'card'		:message('messages','Mi tarjeta de negocio','','',450,300,DOMINIO+'views/users/account/business_card/businessCard_dialog.view.php?bc='+data,'');break;
		case 'share'	:shareTag('Compartir Tag','tag='+opc[0]);break;
		case 'group'	:shareTag('Compartir Tag','tag='+opc[0]);break;
		case 'sponsor'	:sponsorTag('views/tags/sponsor.php?type=4&tag='+opc[0],'Tag patrocinada',opc[0]);break;
		case 'report'	:bryTag('views/tags/report.php',8,opc[0],'Ocultar o reportar una tag','timeLine');break;
		case 'tag/edit':case 'editTag':redir('update?tag='+data);break;
		case 'tag/create':case 'createTag':
			if (opc[1]){
				$('#default-dialog').dialog('close');
				data=opc[0];
			}
			data=data?data:'';redir('creation'+data);break;
		case 'tag/bgselect':
			var img=$('#imgTemplate')[0];
			$.debug().log('bgselect',img);
			if(img){
				img.value=this.dataset.code+'/'+this.dataset.name;
				$('#bckSelected').css('background-image','url('+this.dataset.url+')');
				var $dialog=$(this).parents('.ui-dialog-content');
				if($dialog.length) $dialog.dialog('close');
			}
		break;
		case 'redeemPoinst':message('messages','Canjear mis puntos','<div class="font_size5"><div>Usted podr&aacute; cambiar sus puntos por los servicios y productos en Tagbum. Mientras mas puntos obtenga, m&aacute;s servicios y productos podr&aacute; obtener.</div></div>','',430,190,'');
		break;
		case 'increasePoints':message('messages','&#x00bf;C&#x00f3;mo aumentar mis puntos?','<div class="font_size5"><div><strong>Puedes obtener mas puntos:</strong> compartiendo tags ya sea publicando, redistribuyendo o enviandolas por correo electr&#x00f3;nico. <br><br> <strong>Acumula al menos 5000 puntos antes de 31 de diciembre </strong> y podr&#x00e1;s participar en el sorteo de gift cards de $500.</div></div>','',430,280,'');
		break;
		case 'comments/seemore': case 'commentsSeeMore':
			$(this).prev('p').show().prev('p').remove();
			$(this).remove();
		break;
		case 'tag/trash':
		case 'trash':trash(opc[0]);break;
		case 'viewNoti':
			if ($(this).hasClass('notiNoRevi')){ check_in_Notifications(opc[0],opc[1],$(this)); }
			break;
		case 'editProductTag':redir('update?tag='+opc[0]+'&product='+opc[1]);break;
		case 'tagsUser': if(opc[0]>0) redir('tags?uid='+opc[2]); break;
		case 'personalTags': redir('tags?personal&uid='+opc[1]); break;

		//actions de los grupos
		case 'acceptInv':var obj='';
			if (opc[1]){
				if(opc[1]=='list'){
					obj={
						btnJ:'#acep'+opc[0]+',#acepNo'+opc[0]+',#msg'+opc[0],
						autori:'#joinGroup'+opc[0]+',#tabs-5 #joinGroup'+opc[0],
						actionDiv:'div.bckOvergroup[h="'+opc[0]+'"]',
						actionDivN:'groupsAction,'+opc[0]
					};
					var get=opc[2]?'':'&accept=1';//$('#acep'+opc[0]+',#acepNo'+opc[0]).button('disable');
				}else{ var get='';/*$('.btn input').button('disable');*/ }
			}else{ var get='&accept=1';/*$('.btn input').button('disable');*/ }
			actionGroup(opc[0],7,get,obj);
		break;
		case 'groupSuggest'	:suggestGroup('Sugerir Grupo',data);break;
		case 'groupsDetails':redir('groupsDetails?grp='+data+'&'+Math.random());break;
		case 'groupsAction'	:opc[2]=$(this);confirJOINGroups(opc);break;
		case 'acceptUser'	:case 'acceptUserN':var acept=action=='acceptUserN'?'0':'1';
			if (action=='acceptUserN'){
				/*$(this).button('disable');$(this).prev('input').button('disable');*/
			}
			else{ /*$(this).button('disable');$(this).next('input').button('disable');*/ }
			var obje=$(this);actionGroup(opc[0],8,'&accept='+acept+'&id='+opc[1],obje);break;

		//-- acciones especiales, unicas de las tags --//
		case 'redist'	:
			$tag=$('[tag="'+opc[0]+'"]');
			$('[tag="'+opc[0]+'"] #redistr').prop('disabled',true);
			capa=[$tag.find('.tag-icons #loader'),$tag.find('menu #redist').add(this),$tag.find('.tag-icons #redist')];
			send_ajax('controls/tags/actionsTags.controls.php?action=3&tag='+opc[0]+'&current=timeLine',capa,6,'html');
		break;
		case 'like':
			var $tag=$('[tag="'+opc[0]+'"]'),
				$hide=$tag.find('#dislikeIcon,menu #like'),
				$show=$tag.find('#likeIcon,menu #dislike'),
				$loader=$tag.find('.tag-icons #loader');
			$('[tag="'+opc[0]+'"] #like').prop('disabled',true);
			//console.log(opc[1]);
			if(!opc[1]) $hide.add(this);
			capa=[$loader,$hide,$show,$tag];
			console.log(capa);
			send_ajax('controls/tags/actionsTags.controls.php?action=4&news=1&tag='+opc[0]+'&current=timeLine',capa,8,'html');
			$('[tag="'+opc[0]+'"] #dislike').prop('disabled',false);
		break;
		case 'dislike':
			var $tag=$('[tag="'+opc[0]+'"]'),
				$hide=$tag.find('#likeIcon,menu #dislike'),
				$show=$tag.find('#dislikeIcon,menu #like'),
				$loader=$tag.find('.tag-icons #loader');
			$('[tag="'+opc[0]+'"] #dislike').prop('disabled',true);
			$tag=$('[tag="'+opc[0]+'"]');
			if(!opc[1])$hide.add(this);
			capa=[$loader,$hide,$show,$tag];
			//console.log(capa);
			send_ajax('controls/tags/actionsTags.controls.php?action=11&news=1&tag='+opc[0]+'&current=timeLine',capa,8,'html');
			$('[tag="'+opc[0]+'"] #like').prop('disabled',false);
		break;
		case 'UserLikedOrRaffle': UserLikedOrRaffle(this,opc[0],opc[1]); break;
		//actions del store
		case 'detailProd':
			var get='';
			if (opc[1]){
				if (opc[1]=='dialog') $('#default-dialog').dialog("close");
				else if(opc[1]=='order') get='&order=1';
				else if(opc[1]=='dialog-order'){ get='&order=1';$('#default-dialog').dialog("close"); }
				else get='&rfl=1';
			}
			redir('detailprod?prd='+opc[0]+''+get);
			break;
		case 'deleteItemCar':
			var obj={obje:$(this),mod:opc[1],monto:opc[2]},get='&mod='+opc[1];
			switch(opc[1]){
				case 'wish':get+='&lisWishsShow=1';break;
				case 'car':get+='&shop=1';break;
			}
			if ((opc[2]=='shop')&&(opc[1]=='wish')){ obj.shop='true';get+='&shopW=1'; }
			deleteItemCar(opc[0],get,obj);
			break;
		case 'newRaffle':
			if (opc[2]=='dialog'){ $('#default-dialog').dialog( "close" ); }
			addNewRaffleStore(opc[0],opc[1]);break;
		case 'revendProduct':
			$('#default-dialog').dialog( "close" );
			redir('newproduct?revend=1&idProd='+data);
			break;
		case 'buyPoints':buyPoints();break;
		case 'viewDetailsMySales':detailsSalesProcessed(data);break;
		case 'ordersViews':redir('orders?idOrdes='+data);break;
		case 'tourActive':
			tour(SECTION,true);break;
		case 'closeDialogs':
			var $dialogs=$('.ui-dialog');
			if($dialogs.length>0) $dialogs.find('.ui-dialog-content').dialog('close');
		break;
		default:console.log(action);
	}
}

var lastHash;//almacena el ultimo hash
function historyBack(num){
	if(isLogged()){
		if(lastHash){
			hashBack=true;
			history.back(num||-1);
			setTimeout(function(){ hashBack=false; },50);
		}else
			redir();
	}
}

function windowChange(){
	var height=$(window).height()+1,
		headerH=60+30,//height+padding-bottom
		footerH=$('footer',PAGE).height();//height
	$(PAGE).css('min-height',height-headerH);
	$('container,container content').css('min-height',height-headerH-(isLogged()?footerH:0));
}

(function(window,$,console){
	var lin,lout;
	window.login=function(opc){
		if(lin||!opc||!opc.data){console.log('login cancelado');return;}
		lin=true;
		$$.ajax({
			type:'POST',
			url:'controls/users/login.json.php',
			data:opc.data,
			dataType:'json',
			error:function(/*resp,status,error*/){
				console.log('login error');
//				logout();
				if(opc.fail){
					if(typeof opc.fail==='function'){
						opc.fail();
					}else{
						redir(opc.fail);
					}
				}else if(opc.error){
					if(typeof opc.error==='function'){
						opc.error();
					}else{
						redir(opc.error);
					}
				}
			},
			success:function(data){
//				alert(JSON.stringify(data));
				console.log('login success. logged='+data.logged);
				if(data['logged']){
					isLogged(true);
					setAllLocals(data);
					if(opc.success){
						if(typeof opc.success==='function'){
							opc.success(data);
						}else{
							redir(opc.success);
						}
					}else
						$(window).hashchange();
				}else{
					console.log('no cookies');
					if(opc.fail){
						if(typeof opc.fail==='function')
							opc.fail(data);
						else
							redir(opc.fail);
					}else if(opc.error){
						if(typeof opc.error==='function'){
							opc.error();
						}else{
							redir(opc.error);
						}
					}else
						$(window).hashchange();
				}
			},
			complete:function(){
				lin=false;
			}
		});
	};
	window.logout=function(){
		if(lout) return;
		lout=true;
		$$.ajax({
			type:'POST',
			url:'controls/users/logout.json.php',
			dataType:'json',
			success:function(data){
//				alert(JSON.stringify(data));
				if(data['logout']){
					delAllLocals();
					isLogged(false);
					//$(window).hashchange();
					redir();
				}
			},
			complete:function(){
				lout=false;
			}
		});
	};
})( window,jQuery,console );

function message(id,titulo,contenido,id_control,width,height,url,reload){
	$.dialog({
		id:id,
		title:titulo,
		resizable:false,
		width:width||320,
		height:height||300,
		modal:true,
		show:'fade',
		hide:'fade',
		open:function(){
			if(url)
				$(this).load(url);
			else
				$(this).html(contenido);
		},//insert html
		close:function(){
			if(id_control!=''){
				if((typeof id_control=='string')&&id_control.charAt(0)!='#') id_control='#'+id_control;
				$(id_control).focus();
			}
		},
		buttons:{
			'Ok':function(){
				if(reload) redir(reload);
				$(this).dialog('close');
			}
		}
	});
}

function redir(url){
	url=url||'.';
	if(url.substr(0,1).match(/\/|#/)){
		url=url.substr(1);
	}
	if(url.match(/:\/\//))
		document.location=url;
	else if(SECTION)
		document.location=BASEURL+url;
	else
		document.location='./#'+url;
}

function redirect(url,op){
	//console.log(url+'---'+op);
	if(op){
		console.log('redirect open');
		window.open(url);
	}else if(url.substr(0,1)=='#'){
		redir(url.substr(1));
	}else{
		console.log(' redirect location');
		document.location=url;
	}
}

function valida(form){//requerido=" label", opcional(tamanio="tamanio")
	if( typeof form==='string' ) form=$('#'+form);
	var i,msj,tamanio,paso;
	var inputs=$('[requerido]',form);
	for (i=0;i<inputs.length;i++){
		msj='<b>'+inputs[i].getAttribute('requerido')+'</b>&nbsp;es necesario. Complete el campo!\n';
		if(inputs[i].getAttribute('tamanio')){
			tamanio=inputs[i].getAttribute('tamanio');
			msj+='<br>And must contain at least \''+tamanio+'\' characters';
		}else tamanio=1;
		if(inputs[i].getAttribute('tipo')&&!validateForm(inputs[i])&&inputs[i].value!=''){
			msj+='<br><br>Value format: <b style="color:#FF0000">['+inputs[i].getAttribute('tipo').toUpperCase()+']</b>.';
			paso=true;
		}
		if(inputs[i].value.length<tamanio||inputs[i].value=='0,00'||paso==true){
//			focoActual=inputs[i].id;
//			message('messages','Alert',msj,inputs[i].id);
			$.dialog({
				title:'Alert',
				content:msj,
				focus:inputs[i].id
			});
			return false;
		}
	}
	return true;
}

function validateForm(Input,value){
	var regex,tipo_reporte;
	if(value!==undefined) tipo=Input;
	else{
		if( typeof Input==='string' ) Input=$('#'+Input)[0];
		tipo=$(Input).attr('tipo');
		value=Input.value;
	}
	value=value||'';
	switch(tipo){
		case 'string':		regex=/^[a-zA-Z]/;break;
		case 'words':		regex=/^([a-zA-Z]+\s*)+$/;break;
		case 'integer':		regex=/^\d*$/;break;
		case 'date':		regex=/^\d{1,2}\/\d{1,2}\/\d{2,4}$/;break;//01/01/2009
		case 'email':		regex=/^[a-zA-Z]([\.-]?\w+)*@[a-zA-Z]([\.-]?\w+)*(\.\w{2,3}){1,2}$/;break;
		case 'tlf':			regex=/^[0-9]{4,4}-?-?[0-9]{6,7}$/;break;
		case 'url':			regex=/^https?:\/\/[a-zA-Z]\w*([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/;break;
//		case 'url':			regex=/^https?:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&%\$#_]*)?$/;break;
		case 'ftp':			regex=/^ftp:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&%\$#_]*)?$/;break;
		case 'real':		regex=/^(?:\+|-)?\d+\.\d*$/;break;
		case 'excolor':		regex=/^#([0-9a-fA-F]{3}){1,2}$/;break;
		case 'todo':		regex=/./;break;
		case 'md5': 		regex=/^[0-9a-fA-F]{32}$/; break;
		case 'Alphanumeric':regex=/^[a-zA-Z0-9]+/;break;
		case 'video':		if(Input.value=='http://') return true;
							//regex=/\bhttps?:\/\/((m\.|www\.)?(youtube\.com\/)(embed\/|watch\?(.*&)*(v=))(.{11}).*)\b/i;	if(Input.value.match(regex))Input.value=Input.value.replace(regex,'http://youtu.be/$7');
							regex=/\bhttps?:\/\/(vimeo\.com\/.{8,}|youtu\.be\/.{11}.*|(m\.|www\.)?youtube\.com\/(.+)(v=.{11}).*)?\b/i;	//if(Input.value.match(regex))Input.value=Input.value.replace(regex,'http://$1');
		break;
	}
	return value.match(regex);
}

function validaImagen(imagen){
	var ext=imagen.split('.').pop().toLowerCase();
	return ['jpg','jpeg','png','gif'].indexOf(ext)>=0;
}
function validaVideo(video){
	var ext=video.split('.').pop().toLowerCase();
	return ['mp4','ogg','ogv','flv','webm','avi','mkv','3gp','wmv','mpg','mov','mpeg','m4v'].indexOf(ext)>=0;
}
function validaSize(archivo,max){
	max=max?max:62914560;
	if (archivo.size<max) return true;
	return ((max/1024)/1024);
}
function validaKeyCode(type,code){
	switch(type){
		case 'interger':
			if(((code>=48)&&(code<=57))||((code>=96)&&(code<=105)))
				return true;
			break;
		case 'letter':
			if((code>=65)&&(code<=90))
				return true;
			break;
		case 'direction':
			if((code>=37)&&(code<=40))
				return true;
			break;
		case 'delete':
			if((code==8)||(code==46))
				return true;
			break;
		case 'del':
			if(code==8)
				return true;
			break;
		case 'escape':
			if((code==27))
				return true;
			break;
		case 'tab':
			if((code==9))
				return true;
			break;
		case 'enter':
			if((code==13))
				return true;
			break;
		case 'coma':
			if((code==188))
				return true;
			break;
	}
	return false;
}
function openVideo(obje){
	var type=$(obje).attr('class');
	var content=$(obje).parents('div[tag]');
	$(content).find('.minitag,.tag,.extras').hide('slow',function(){ $(content).addClass('ativeVideo'); });
	switch(type){
		case 'youtube': actionyoutubevideo('play',$(content).find('.video iframe')); break;
		case 'vimeo': actionvimeovideo('play',$(content).find('.video iframe')); break;
		case 'local': actionlocalvideo('play',$(content).find('.video video').attr('id')); break;
	}
}
function closeVideo(obje){
	var type=$(obje).attr('class').replace("videominitag ","");
	var content=$(obje).parents('div[tag]');
	$(content).find('.minitag,.tag,.extras').show('slow');
	$(content).removeClass('ativeVideo');
	switch(type){
		case 'youtube': actionyoutubevideo('pause',$(content).find('.video iframe'));  break;
		case 'vimeo': actionvimeovideo('pause',$(content).find('.video iframe')); break;
		case 'local': actionlocalvideo('pause',$(content).find('.video video').attr('id')); break;
	}
}
function actionlocalvideo(action,id){
	if (!action || !id) return false;
	else{
		var video=document.getElementById(id);
		switch(action){
			case 'pause-play':
				if (video.paused) video.play();
	       		else video.pause();
          	break;
			case 'pause': video.pause(); break;
			case 'play': video.play(); break;
			case 'stop':
				video.pause();
				video.currentTime = 0;
			break;
		}
		return true;
	}
}
function actionvimeovideo(action,iframe){
	if (!action || !iframe) return false;
	else{
		var player = $f(iframe[0]);
		switch(action){
			case 'pause-play':
			player.api('paused', function (value, player_id){
	         	var acc = false;
	         	if (value) acc = true;
	         	player.api( (acc) ? 'play':'pause' );
	         	// $(that).text( (!acc) ? 'Play':'Pause' );
	         });
          	break;
			case 'pause': player.api('pause'); break;
			case 'play': player.api('play'); break;
			case 'stop': break;
		}
		return true;
	}
}
function iniallYoutube(){
	var vector=$('div.ytplayer');
	if (vector.length){
		$.each(vector, function(index, val) {
			 iniyoutubevideo(this);
		});
	}
}
function iniyoutubevideo(iframe){
	// function onYouTubeIframeAPIReady() {
		if (typeof YT.Player != "undefined"){
			var width=$(iframe).attr('width')?$(iframe).attr('width'):640;
			var height=$(iframe).attr('height')?$(iframe).attr('height'):360;
			var id=$(iframe).attr('id');

			player = new YT.Player(id,{
				width: width,
				height: height,
				videoId: $(iframe).attr('data-src'),
				playerVars: {
	                controls: 1,
	                showinfo: 0,
	                modestbranding: 1,
	                wmode: 'transparent'
	            }
			});
			window.players[id]=player;
		}else{
			$(iframe).parents('div.video').append('<div class="msgError">Disculpe, hemos tenido dificultades para conectarse al servidor de YouTube</div>');
		}
	// }
}
function actionyoutubevideo(action,iframe){
	if (!action || !iframe) return false;
	else{
		var vid=$(iframe).attr('id');
		if (window.players[vid]){
			switch(action){
				case 'pause-play':
					switch(window.players[vid].getPlayerState()){
						case 2: case 5:
							window.players[vid].playVideo();
							playing = true;
						break;
						case 1:
							window.players[vid].pauseVideo();
						break;
					}
	          	break;
	          	case 'pause': window.players[vid].pauseVideo(); break;
				case 'play': window.players[vid].playVideo(); break;
				case 'stop':break;
			}
		}
		return true;
	}
}
function htmlVideo(data,type,url,del){
	if(!(data instanceof Object))
		data={video:data};
	data.type=type||data.type;
	if(!data.video || !data.type) return;
	data.url=url||data.url;
	data.del=del||data.del;
	var html='';
	switch(data.type){
		case 'youtube':
			html='<div id="v'+Math.random()+'" data-src="'+data.video+'" class="ytplayer"></div>';
		break;
		case 'vimeo': html='<iframe src="'+data.video+'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';break;
		case 'local':
			html=$.debug.isEnabled('video')&&navigator.userAgent.match(/(chrome|opera|OPR)/i)?(
			'<object id="f4Player" width="650" height="300" type="application/x-shockwave-flash" data="css/player.swf?v1.3.5">'+
				'<param name="movie" value="css/player.swf?v1.3.5"/>'+
				'<param name="quality" value="high"/>'+
				'<param name="menu" value="false"/>'+
				'<param name="scale" value="noscale"/>'+
				'<param name="allowfullscreen" value="true"/>'+
				'<param name="allowscriptaccess" value="always"/>'+
				'<param name="cachebusting" value="true"/>'+
				'<param name="flashvars" value="skin=css/skin.swf&video='+data.video+'"/>'+
				// '<a href="http://www.adobe.com/go/flashplayer/">Download it from Adobe.</a>'+
				// '<a href="http://gokercebeci.com/dev/f4player" title="flv player">flv player</a>'+
			'</object>'
			// '<object type="application/x-shockwave-flash" data="css/smp10.1.swf" width="650" height="300">'+
			// 	'<param name="movie" value="css/smp10.1.swf"/>'+
			// 	'<param name="allowFullScreen" value="true"/>'+
			// 	'<param name="allowscriptaccess" value="always"/>'+
			// 	'<param name="playButtonOverlay" value="true"/>'+
			// 	'<param name="wmode" value="transparent"/>'+
			// 	'<param name="flashVars" value="src='+data.video+
			// 		'&playButtonOverlay=true&controlBarAutoHide=false"/>'+
			// 	//'<img alt="Big Buck Bunny" src="http://sandbox.thewikies.com/vfe-generator/images/big-buck-bunny_poster.jpg" width="640" height="360" title="No video playback capabilities, please download the video below" />'+
			// '</object>'
			):('<video id="v'+Math.random()+'" controls preload="metadata">'+
				'<source src="'+data.video+'" type="video/mp4"/>'+
				(data.video2?'<source src="'+data.video2+'" type="video/ogg"/>':'')+
			'</video>');
		break;
	}
	if(html!=''){
		extras='';
		if(data.url) extras='<button class="btn btn-primary start invisible" data-set="'+data.url+'" data-type="'+data.type+'" data-pre="'+data.video+'"><i class="glyphicon glyphicon-upload"></i></button>';
		if(data.del) extras+='<button class="btn btn-danger delete fright"><i class="glyphicon glyphicon-trash"></i></button>';
		html='<div class="video"><div class="placa"></div>'+extras+html+'</div>';
	}
	return html;
}
function validaImputPictureFile(id){
	var img=$(id).val();
	return !!img.match(/\.(png|gif|jpe?g)\s*$/i);
}
function showTag(tag){
	//hash en la tags
	function hash(data){
		if(!data||data.length<1) return '';
		var i,list=[];
		for(i=0;i<data.length;i++) list.push('<a href="'+BASEURL+'searchall?srh='+encodeURIComponent(data[i])+'&in=1">'+data[i]+'</a>');
		return '<div id="hashTashMenu"><span>'+list.join(' ')+'</span></div>';
	}
	var btn=tag['btn']||{};
	var btnSponsor='',paypal='';
	if(paypal!='')
		btnSponsor= (btn['sponsor']?'<li id="sponsors" action="sponsor,'+tag['id']+'" title="Tag patrocinada"><span>Tag patrocinada</span></li>':'');
	var video='',videomini='';
	if(tag['typeVideo']){
		if (!window.players){ window.players=[]; }
		video=htmlVideo(tag['video'],tag['typeVideo']);
		if (video!=''){
			if (tag['imgmini'])
				videomini='<div class="videominitag '+tag['typeVideo']+'"  action="videoc" style="background-image:url('+tag['imgmini']+')"></div>';
			else videomini='<div class="videominitag '+tag['typeVideo']+'" action="videoc" style="background-image:url('+tag['img']+')"></div>';
		}
	}
	return(
	'<div tag="'+tag['id']+'" udate="'+tag['udate']+'">'+
		'<div class="loader"></div>'+
		(tag['imgmini']?'<div class="minitag" style="background-image:url('+tag['imgmini']+')"></div>':'')+
		'<div class="tag" style="background-image:url('+tag['img']+')"></div>'+
		//'<img class="bg" src="'+tag['img']+'" />'+
		// '<div class="bg"></div>'+
		video+'<div class="bg"></div>'+
		(tag['rid']?
			'<div class="redist"><span action="profile,'+tag['rid']+'" title="Perfil">Redistribuida por '+tag['name_redist']+'</span></div>'
		:'')+
		'<div class="tagLink" action="comment,'+tag['id']+',Comparte tu opini&#x00f3;n sobre esta tag."></div>'+
		'<div class="tag-icons">'+
			'<span id="sponsor" '+(tag['sponsor']?'':'style="display:none;"')+'></span>'+
			'<span id="redist" '+(tag['redist']?'':'style="display:none;"')+'></span>'+
			'<span id="likeIcon" '+(tag['likeIt']>0?'':'style="display:none;"')+'></span>'+
			'<span id="dislikeIcon" '+(tag['likeIt']<0?'':'style="display:none;"')+'></span>'+
			videomini+
		'</div>'+
		'<div class="profilepic" action="profile,'+tag['uid']+'" title="Perfil"></div>'+
		'<div class="profile" action="profile,'+tag['uid']+'" title="Perfil"></div>'+
		((tag['product']||tag['typeVideo'])?
			'<div class="extras"><div>'+
				(tag['product']?
					'<a href="'+BASEURL+'detailprod?prd='+tag['product']['id']+'"><img class="product" src="'+tag['product']['qr']+'"/></a>'
				:'')+
				// (tag['typeVideo']?
				// 	'<span class="'+tag['typeVideo']+'" action="video,'+tag['video']+'" title="Ver video"></span>'
				// :'')+
				(tag['typeVideo']?
					'<span class="'+tag['typeVideo']+'" action="video" title="Ver video"></span>'
				:'')+
			'</div></div>'
		:'')+
		(isLogged()?
		'<menu>'+
			hash(tag['hashTag'])+
			'<ul>'+
				(tag['business']?
					'<li id="bcard" action="card,'+tag['business']+'" title="Bussines Card"><span>Bussines Card</span></li>'
				:'')+
				'<li id="like" action="like,'+tag['id']+'"'+(tag['likeIt']>0?' style="display:none;"':'')+' title="Like"><span>Like</span></li>'+
				'<li id="dislike" action="dislike,'+tag['id']+'"'+(tag['likeIt']<0?' style="display:none;"':'')+' title="Dislike"><span>Dislike</span></li>'+
				(!tag['popup']?
					'<li id="comment" action="comment,'+tag['id']+'" title="Comment"><span>Comment</span></li>'
				:'')+(btn['redist']?
					'<li id="redistr" action="redist,'+tag['id']+'" title="Re Distribuci&#x00f3;n"><span>Re Distribuci&#x00f3;n</span></li>'
				:'')+(btn['share']?
					'<li id="share" action="share,'+tag['id']+'" title="Compartir Tag"><span>Compartir Tag</span></li>'
				:'')+btnSponsor+(btn['trash']?
					'<li id="trash" action="trash,'+tag['id']+'" title="Eliminar tag"><span>Eliminar tag</span></li>'
				:'')+((tag['product'])?(btn['edit']?
					'<li id="edit" action="editProductTag,'+tag['id']+','+tag['product']['id']+'" title="Editar tag"><span>Editar tag</span></li>'
				:''):(btn['edit']?
					'<li id="edit" action="editTag,'+tag['id']+'" title="Editar tag"><span>Editar tag</span></li>'
				:''))+(btn['report']?
					'<li id="report" action="report,'+tag['id']+'" title="Ocultar o reportar una tag"><span>Ocultar o reportar una tag</span></li>'
				:'')+
			'</ul>'+
		'<div class="clearfix"></div></menu>'
		:'<div id="menuTagnoLogged"></div>')+
	'</div>'
	);
}

function showTags(array){//tag list
	var i,tags='';
	for(i=0;i<array.length;i++){
		tags+=showTag(array[i]);
	}
	return tags;
}
function showCarousel(array,layer){
	$(layer).off().html(showTags(array,false,false));
	if(array.length>1){
		$(layer).carouFredSel({
			items:1,
			direction:'up',
//			auto:{
//				onAfter:function(oldItem/*,newItem*/){
//					$(this).attr({ 'last':$(oldItem).attr('tag') });
//				}
//			},
			scroll:{
				duration:700
			}
		}).on('mouseover',function(){
			$(this).trigger('stop',true);
		}).on('mouseout',function(){
			$(this).trigger('play',true);
		});
	}
}

(function(window){
	var on={};
	window.updateTags=function(action,opc,loader){
		var act,pBox=(opc.current=='privateTags')?opc.pBox:'',
			current=opc.current,
			btncretagG=opc.btncretagG,
			idsearch=opc.idsearch||'',
			search=opc.search||'',
			radiobtn=opc.radiobtn||'',
			layer=opc.layer,
			get=opc.get||'',
			limit=opc.limit||15,
			cancel=function(){return !opc.force&&(current==''||opc.current!=current||(action!='reload'&&on['reload']));},//cancel action
			onca=function(val){if(val!==undefined)on[action]=val;return !opc.force&&on[action];};//on current action
		if(loader!==false) loader=$(layer).next()[0];
		$.debug('tag').log('cancel:',cancel(),'onca:',onca());
		if(cancel()||onca()) return false;
		$.debug('tag').log('runing updateTags. '+action);
		$.debug('tag').log(current);
		onca(true);
		if(!opc.actions||action=='reload'){
			opc.actions={refresh:{},more:{}};
			opc.date='';
			$(layer).html('');
		}
		act=opc.actions[action=='refresh'?'refresh':'more'];
		//si no hay mas tag, se cancela la consulta
		if(act.more===false){
			return onca(false);
		}
        if(loader) $(loader).show();
		$.ajax({
			type:'GET',
			dataType:'json',
			data:act||{},
			url:'controls/tags/tagsList.json.php?limit='+limit+'&current='+current+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
			success:function(data){
				if(cancel()){
					console.log('Cancelada carga de '+current+'.');
					return;
				}
				if(current=='privateTags'){
					opc.pCont--;
					if(opc.pBox!=pBox) return;
				}
				if(action=='more'&&(!data['tags']||data['tags'].length<1)) act.more=false;
				if(data['tags']&&data['tags'].length>0){ $(btncretagG).show().addClass('divctg');
					tour(SECTION);
					opc.date=data['date'];
					if(data['sp']) act.sp=data['sp'];
					var tags='',i,len=data['tags'].length,$el,$rep,sp;
					if(data['sponsors']) sp=data['sponsors'].length;
					else sp=0;
					act.start=(act.start||0)+data['tags'].length-sp;
					act.startsp=(act.startsp||0)+sp;
					act.idsponsor=data['idsponsor'];
					for(i=0;i<len;i++){//eliminar repeticiones
						$el=$(layer).find('[tag='+data['tags'][i]['id']+']');
						if($el.length>0)
							if($rep) $rep.add($el);else $rep=$el;
					}
					if($rep) $rep.remove();
					tags=showTags(data['tags']);
					if(action=='more')
						$(layer).append(tags);
					else
						$(layer).prepend(tags);
					$('[title]',layer).tipsy({html:true,gravity:'n'});
					$('.profile',layer).tipsy({html:true,gravity:'s'});
				}else if(action=='reload'){
					act.more=false;
					if(current=='group'){
						$(btncretagG).hide();
						$(layer).html('<div class="messageAdver">No hay tags creadas.&nbsp;Para crear una tag, haz clic aqui<a href="'+BASEURL+'creation?group='+opc['grupo']+'">A&#x00f1;adir Tag</a></div>');
					}else{
						if(idsearch=='1'){
							$(radiobtn).hide();
							$(layer).html('<div class="clearfix"></div><div class="messageNoResultSearch">Disculpe, no hay resultados para<span style="font-weight:bold"> '+search+'</span> <br><span style="font-size:12px">Compruebe su termino de busqueda e intentelo de nuevo.</span></div>');
						}else{
							$(layer).html('<div class="clearfix"></div><div class="messageNoResultSearch more">Disculpe, no hay tag que mostrar</div>');
						}
					}
				}else if(action=='more'){
					$(layer).append('<div class="clearfix"></div><div class="messageNoResultSearch more">Disculpe, no hay mas tag que mostrar</div>');
				}
			},
			complete:function(){
				if (opc.pCont){
					if (opc.pCont==0) if(loader) $(loader).hide();
				} else if(loader) $(loader).hide();
				onca(false);
				iniallYoutube();
			}
		});
		return true;
	}
})(window);

function commentTag(titulo,tag,old){
	if(old){ titulo=tag;tag=old; }
	$.dialog({
		title:titulo||'Comment Tag',
		altUrl:'tag/'+tag,
		open:function(){
			var $this=$(this);
			$this.load('dialog?pageid=comment&tag='+tag);
			$this.on('click','[tag] menu [action]',function(){
				console.log(this.id);
				if(this.id!='like'&&this.id!='dislike'&&this.id!='redistr'&&this.id!='trash'){
					$this.dialog('close');
				}
			});
		},
		close:function(){
			$(this).off();
		},
		resizable:false,
		width:720,
		height:600,
		modal:true,
		buttons:{}
	});
}

function trash(tag){
	$.dialog({
		title:'Deleting Tag',
		resizable:false,width:400,height:200,modal:true,
		content:'&iquest;Seguro que quiere borrar esta tag?',
		buttons:{
			'Si':function(){
				var $this=$(this);
				$.ajax({
					type:'GET',
					url:'controls/tags/actionsTags.controls.php?action=6&tag='+tag,
					dataType:'html',
					success:function(result){
						if(result==1){
							$('[tag="'+tag+'"]').fadeOut(600,function(){$(this).remove();});
							$this.dialog('close');
							$('#default-dialog').dialog("close");
						}else{
							$this.html(result);
						}
					},
					complete:function(){
						setTimeout(function(){
							$this.dialog('close');
						},1500);
					}
				});
			},
			'No':function(){
				$(this).dialog('close');
			}
		}
	});
	//actionsTags(6,opc+'|0',,'|timeLine');
}

var tourHash,dataHash;
function tour(hashActive,force){
	function struct(data,id){
		var ort='';
		if(id=='home'){
			ort=id;
		}else{
			// if(NOHASH)
				ort=window.location.pathname.split(BASEURL)[1].split('/')[0];
			// else{
			// 	ort=window.location.hash.substr(1);
			// 	var hashVerify=ort.match(/\?/);
			// 	ort=hashVerify?ort.split('?')[0]:ort;
			// }
		}
		//console.log('ori: '+window.location.hash+'---- hashdb: '+id+'----- comp: '+ort);
		if(id==ort){
			guidely.clear();
			$('html,body').scrollTop(0);
			$.each(data,function(id,tour){
			if($(tour['id_div']).length>0&&$(tour['id_div']).is(':visible')){
					guidely.add ({
						attachTo:tour['id_div'],
						anchor:tour['position'],
						title:tour['title'],
						text:tour['message']
					});
				}
			});

			guidely.init({showOnStart:true,welcome:false,startTrigger:false});
		}
	}

	if(!hashActive||hashActive=='#'||hashActive=='#home'){
		hashActive='home';
	}else{
		// if(!NOHASH) hashActive=hashActive.split('#')[1];
		var hashVerify=hashActive.match(/\?/);
		hashActive=hashVerify?hashActive.split('?')[0]:hashActive;
	}
	$.debug('tour').log('tour: '+hashActive);
	if(tourHash!=hashActive){
		$.ajax({
			type:'GET',
			url:'controls/tour/tour.php?hash='+md5(hashActive),
			dataType:'json',
			debug:'tour',
			success:function (data){
			tourHash=hashActive;
			dataHash=data;
			//console.log(data['liTour'].length);
			$.debug('tour').log('tour data:',data);
				guidely.clear();
				if(data!=null){//alert(data);
					if(force||dataHash['firstTime']){
						//$('body').css('padding-top','0');
						struct(dataHash['liTour'],hashActive);
					}
				}
			}//end success
		});
	}else{
		if(force||dataHash['firstTime']){
			//$('body').css('padding-top','0');
			struct(dataHash['liTour'],hashActive);
		}
	}
}

function pauseCarousels(action,old){//old: soporte para antiguas
	if(old) action=old;
	var $car=$('#carousel-box');
	if($car.length>0) $car.trigger(action,true);
}

function valor(id){
	if( typeof id==='string'&&id.charAt(0)!='#' ) id='#'+id;
	return $(id).val();
}

//message(id,titulo,contenido,id_control,width,height,url)
function actionsTags(op,dato,uri,more){
	var tmpDato=dato.split('|');
	var tag=(tmpDato[1]==1)?valor(tmpDato[0]) :tmpDato[0];//si [1]==1 (id), sino (dato)
	var valores=more.split('|');

	switch (op){
		//refresh
		case 1:
			redir('home');
		break;
		//coment
		case 2:
			commentTag(valores[0],tag);
		break;
		//re-send
		case 3:
			send_ajax(uri+"?action="+op+"&tag="+tag+"&current="+valores[1],"#re_distribuirTag"+valores[1]+"_"+tag,0,"html");
		break;
		//Like
		case 4:
			send_ajax(uri+"?action="+op+"&tag="+tag+"&current="+valores[1],"#start_favorite"+valores[1]+"_"+tag,0,"html");
			if (valores[2]=='1'){
				send_ajax("controls/tags/numLikes.cotrol.php?tag="+tag,"#tdNumLikes",0,"html");
			}
		break;

		//share
		case 5:
			shareTag(valores[0],"tag="+tag);
		break;

		//remove
		case 6:
			$.dialog({
				id:'messages',
				title:'Deleting Tag',
				resizable:false,width:400,height:200,modal:true,show:'fade',hide:'fade',
				content:lang.JS_DELETETAG,
				buttons:{
					'Si':function(){
						var delprivate=(valores[1]=="privateTags")?"&delprivate=1":"",
						$this=$(this);
						$.ajax	({
							type:'GET',
							url:uri+'?action='+op+'&tag='+tag+delprivate,
							dataType:'html',
							success:function(result){
								if(result==1){
									$.all('[tag="'+tag+'"]').fadeOut(600).remove();
								}else{
									$this.html(result);
								}
							},
							complete:function(){
								setTimeout(function(){
									$this.dialog('close').remove();
								},1000);
							}
						});
					},
					'No':function(){
						$(this).dialog('close').remove();
					}
				}
			});
		break;

		//contruction
		case 7:alert("Sponsor, Tag: "+tag);break;

		//denuncia
		case 8:
			bryTag(uri,op,tag,valores[0],valores[1]);//url,tag,titulo,pestania
		break;

		//sponsor
		case 9://alert(op+" | "+dato+" | "+uri+" | "+more);
			sponsorTag("views/tags/sponsorTags.view.php?type=4&tag="+tag,valores[0],tag);
		break;

		//editar
		case 10://alert("controls/tags/isMyTag.controls.php?code="+valores[0]+"&tag="+tag);

			$.ajax({
				type:"POST",
				url:"controls/tags/isMyTag.controls.php?code="+valores[0]+"&tag="+tag,
				dataType:"html",
				success:function(data){
					if(data==1)
						$.ajax({url:'views/tags/update.view.php?asyn&tag='+tag,success:function(){
							$("#previewTag").dialog("close");
							$('body #previewTag').remove();
							redir('update');
						}});
					else
						message("messages","Error",valores[1]);
				}
			});

		break;
		case 12:
			alert(tmpDato[0]);
		break;
	}
}

function sponsorTag(url_vista,titulo,tag,edit){
	$.dialog({
		id:"messages",
		title:titulo,
		resizable:false,
		width:500,
		height:450,
		modal:true,
		open:function(){
			$("#messages").load(url_vista);
		},
		buttons:[{
			text:lang.JS_CANCEL,
			click:function(){
				$(this).dialog("close");
			}
		},{
			text:lang.JS_CONFIRM,
			click:function(){
				_get=(edit)?"&update=1&p="+valor("p"):"";
				//validamos el link del anuncio
				if (valida("borderSpansorTag")){
					$.ajax({
						type:"POST",
						url:"controls/tags/actionsTags.controls.php?action=10&tag="+tag+"&link="+valor("sponsorLink")+"&inver="+valor("sponsorInversion")+_get,
						dataType:"html",
						success:function (data){
							$('[tag="'+tag+'"] .tag-icons #sponsor').fadeIn("fast");
//								showAndHide('sponsor_msgerror1','sponsor_msgerror1',1500,true);//error de link
							$("#sponsor_msgeexito").fadeIn(800);
							$("#sponsorTableTag").html(data);
							if (_get!=''){
								$("#messages").dialog('close');
								redir('publicity?'+Math.random());
							}else{
								setTimeout(function(){
									$("#messages").dialog('close')
								},2000);
							}
						}
					});
				}else{
					showAndHide('sponsor_msgerror1','sponsor_msgerror1',1500,true);//error de link
				}//else link
			}//boton Confirm
		}]
	});
}



function bryTag(url_vista,action,tag,titulo,tab){
	$.dialog({
		id:"messages",
		title:titulo,
		resizable:false,
		width:500,
		height:350,
		modal:true,
		open:function(){
			$("#messages").load(url_vista);
		},
		buttons:[{
			text:lang.JS_CANCEL,
			click:function(){
				$( this ).dialog( "close" );
			}
		},{
			text:lang.JS_CONTINUE,
			click:function(){
			$('.result_report').html('<img src="css/smt/loader.gif" width="20" height="20" border="0"/>');
				$.ajax({
					type:"POST",
					url:"controls/tags/actionsTags.controls.php?action="+action+"&tag="+tag+"&type_report="+valor("tipo_reporte"),
					dataType:"html",
					success:function(data){
						$('[tag='+tag+']').fadeOut(600,function(){$('.result_report').hide();$("#messages").dialog('close');});
//						setTimeout(function(){
//							$("#messages").dialog('close')
//						},1500);
					}
				});
			}
		}]
	});
}

function isMail(valor){
	return valor.match(/^[a-zA-Z]([\.-]?\w+)*@[a-zA-Z]([\.-]?\w+)*(\.\w{2,3}){1,2}$/);
}

function shareTag(titulo,get){
	$.dialog({
		title:titulo,
		url:'views/tags/share/tag.php?'+get,
		resizable:false,
		width:620,
		height:410,
		modal:true,
		buttons:[{
			text:lang.JS_CANCEL,
			click:function() {
				$(this).dialog('close');
			}
		},{
			text:lang.JS_SEND,
			click:function(){
				var mails=$('#txtEmails').val(),band=true;
				if (mails!=""){
					mails=mails.split(',');
					console.log(mails.length);
					for(var i=0;i<mails.length;i++){
						if (band && mails[i]!=""){
							if (!validateForm('email',mails[i]) && !validateForm('md5',mails[i])) band=false;
						}
					}
				}else band=false;
				if (band){
					var $this=$(this);
					$.ajax({
						type:'POST',
						url:'controls/tags/actionsTags.controls.php?'+get+'&action=5',
						data:{mails:mails.join(),msj:$('#txtMsgMail').val()},
						dataType:'text',
						success:function(data){
							$('button').hide();
							$('#share_tag').html(data);
							setTimeout(function(){//alert(data);
								$this.dialog('close');
							},1500);
						}
					});
				}else message('nouserprivate', 'Mensaje', 'Puedes escoger unos de tus amigos o indicar un correo externos a tagbum para enviar esta tag');
			}
		}]
	});
}

function send_ajax(url,capa,mode,data_type){
	if(mode<5)			$(capa).html('<img src="css/smt/loader.gif" width="10" height="10" border="0" />');
	else if(mode<10)	$(capa[0]).html('<img src="css/smt/loader.gif" width="10" height="10" border="0" />');
	else if(mode<15)	$(capa[0]).show();
	else				$('loader.page',PAGE).show();
	$.ajax({
		type:'POST',
		url:url,
		dataType:data_type,
		success:function (data){//alert(data);
			switch(mode){
				case 0://insert
					$(capa).html(data);
				break;
				case 1://prepend
					$(capa).prepend(data);
					$(capa).load();
				break;
				case 2://like-dislike
					$(capa).html(data.split('|')[0]);
					$(str_replace('Dis','',capa)).html(data.split('|')[1]);
				break;
				//a partir de 5:multiples capas
				case 5://0-insert, 1-hide
					$(capa[0]).html(data.split('|')[0]);
					$(capa[1]).fadeOut();
				break;
				case 6://0-loader, 1-fadeout, 2-fadein
					$(capa[0]).empty();
					$(capa[1]).fadeOut('slow',function(){
						$(capa[2]).fadeIn('slow');
					});
				break;
				case 7://0-loader, 1-fadeout
					$(capa[0]).empty();
					$(capa[1]).fadeOut('slow');
				break;
				case 8://like-dislike coment
					var $dislikes=capa[3].find('#numDislikes'),$likes=capa[3].find('#numLikes');
					//console.log([$dislikes[0],$likes[0]]);
					if($dislikes.length>0) $dislikes.html(data.split('|')[0]);
					if($likes.length>0) $likes.html(data.split('|')[1]);
					if(capa[0].length>0) $(capa[0]).hide();
					if(capa[1].length>0)
						$(capa[1]).fadeOut('slow',function(){
							if(capa[2].length>0) $(capa[2]).css('display','');//.fadeIn('slow');
						});
					else
						if(capa[2].length>0) $(capa[2]).css('display','');//.fadeIn('slow');
				break;
				case 10://0-inmediate hide (loader), 1-fadeout, 2-fadein
					$(capa[0]).hide();
					$(capa[1]).fadeOut('slow',function(){
						$(capa[2]).fadeIn('slow');
					});
				break;
				case 15://prepend
					$(capa).append(data);
					$('loader.page',PAGE).hide();
				break;
			}
		}
	});
}

var codeNotiUp=0;
function check_in_Notifications(source,type,objeto){
	$.ajax({
		type:'GET',
		url:'controls/notifications/notifications.json.php?check='+source+'&type='+type+'&action=push',
		dataType:'json',
		success:function (data){
			//alert(data);
			var aux,titulo,number;
			number=data['push'];
			//actualizamos el titulo de la pagina y el menu de usuarios
			if (number>0){
				titulo=document.title.split('-');
				//console.log(titulo);
				aux=titulo[0].split(')');
				if (aux[1]){ document.title=" ("+number+") "+aux[1]+' - '+titulo[1]; }
				else{ document.title=" ("+number+") "+titulo[0]+' - '+titulo[1]; }
				$('#numNoti').addClass('more').children().empty().html(number<999?number:999);
			}else{
				titulo=document.title.split('-');
				aux=titulo[0].split(')');//alert(aux[0]+','+aux[1]);
				document.title=(aux[1]?aux[1]:titulo[0])+' - '+titulo[1];
				$('#numNoti').removeClass('more').children().empty().html(0);
			}
			//cambiamos el fondo de la notificacion
			objeto.removeClass('notiNoRevi').addClass('notiRevi').removeAttr('action');
			//cambiamos la imagen de la notificaciones
			$('div[r="1"] img',objeto).attr('src','css/smt/news/finishedwork1.png');
			///codeNotiUp=source;//esta variable grobla no se para que es
		}
	});
}

var seeUp=0;
function seeMore(mobile,url,capa_prin,capa_word,capa_loading,size,width,opc){//alert(cant);
	if(opc&&!opc.on) opc.on={};
	var on=opc&&opc.on,
		action='refresh',
		cancel=function(){return (action!='new'&&on['new']);},//cancel action
		onca=function(val){if(val!==undefined)on[action]=val;return on[action];};//on current action

	$(capa_word).hide();
	$(capa_loading).html('<img src="css/smt/loader.gif" width="'+size+'" height="'+size+'" />');
	//alert(opc.srh);
	seeUp=1;

	if(!opc||(!cancel()&&!onca())){
		if (opc) onca(true);
		//alert(opc.srh+'--'+opc.seemore)
		$$.ajax({
			type:"POST",
			data:$.extend({},opc.data||{},{seemore:opc&&opc.seemore}),
			url:url,
			dataType:"text",
			success:function(data){
						data=data.split("|");
						if (opc) opc.seemore=data[0];
						if(data[2]!=0){
							$(capa_loading).html('');
							$(capa_prin).append('<div style="width:'+width+';" id="div_'+data[0]+'" >'+data[1]+'</div>');
							//$('button,input:submit,input:reset,input:button,#group-box .group_info a,#groupTabs .group_info a').button();
							$(capa_word).show();
						}else{
							$(capa_word).hide();
							$(capa_loading).html('');
						}
					},
			complete:function(){
				if(opc) onca(false);
			}
		});
	}
}

var seeUp=0;
function seemoreNew(mobile,url,capa_prin,capa_word,capa_loading,size,width,opc){//alert(cant);
	if(opc&&!opc.on) opc.on={};
	var on=opc&&opc.on,
		action='refresh',
		cancel=function(){return (action!='new'&&on['new']);},//cancel action
		onca=function(val){if(val!==undefined)on[action]=val;return on[action];};//on current action

	$(capa_word).hide();
	$(capa_loading).html('<img src="css/smt/loader.gif" width="'+size+'" height="'+size+'" />');
	//alert(opc.srh);
	seeUp=1;

	if(!opc||(!cancel()&&!onca())){
		if (opc) onca(true);
		//alert(opc.srh+'--'+opc.seemore)
		$$.ajax({
			type:"POST",
			data:$.extend({},opc.data||{},{seemore:opc&&opc.seemore}),
			url:url,
			dataType:"json",
			success:function (data){
				var datos='';
				switch(data['idsm']){
						case 'hash':
							var hash='';
							for(i=0;i<data['cant'];i++){
								hash=data['hash'].split("|");
								datos+=bodyhash(hash[i]);
							}
						break;
						case 'friends':
							var friends='';
							friends=data['friends'];
							//console.log(data);
							for(i=0;i<data['cant'];i++){

								followerLink=(friends[i]['follower'])?'display:none':'';
								followerUnlink=(friends[i]['follower'])?'':'display:none';
								datos+=bodyfriends(friends[i],followerLink,followerUnlink);
							}
						break;
						case 'groups':
							var groups='';
							groups=data['group'];
							console.log(data);
							for(i=0;i<data['cant'];i++){
								datos+=bodygroups(groups[i]);
							}
							//btn='';
						break;
				}

//				if (opc) opc.seemore=data[0];
				if(data['cant']!=0){
					$(capa_loading).html('');
					$(capa_prin).append('<div style="width:'+width+';" id="div_'+data['cant']+'" >'+datos+'</div>');
					//$('button,input:submit,input:reset,input:button,#group-box .group_info a,#groupTabs .group_info a').button();
					$(capa_word).show();
				}else{
					$(capa_word).hide();
					$(capa_loading).html('');
				}
			},
			complete:function(){
				if (opc) onca(false);
			}
		});
	}
}
function searchAll(dato){
	var lcurl = '...'; //Variable para optimizar consultas
	var $cont=$.div("#content_friends_search");
	$cont.fadeOut(200);
	if(lcurl != dato){
		lcurl=dato;
		$.ajax({
			type:"POST",
			url:"views/users/resultSearchAll.php?dato="+dato,
			dataType:"html",
			success:function(data){
				if(lcurl==dato){
					$cont.html(data).fadeIn(200);
				}
			}
		});
	}
}

function addSuggestFriends(id_capa,content){
	var capa=[];
	if(content){
		$('input[user]',content).each(function(){
			capa.push($(this).attr('user'));
		});
	}
	$$.ajax({
		type	:"POST",
		url		:"controls/users/addSuggestFriend.json.php",
		dataType:"json",
		data	:{user:capa},
		success	:function(data){
			var dato='', out='';
			dato=data['friend'][0];
			console.log(data['cad']);
			console.log(id_capa);
			if(dato){
				out+='<div class="divYourFriendsSuggestPhoto">'+
						'<img action="profile,'+dato['id_friend']+','+dato['name_user']+'" src="'+dato['photo_friend']+'" border="0"  width="50" height="50">'+
					'</div>'+
					'<div class="divYourFriendsSuggestInfo">'+
						'<div class="left">'+
							'<a href="javascript:void(0);" action="profile,'+dato['id_friend']+','+dato['name_user']+'">'+
								dato['name_user']+
							'</a>'+
						'</div>'+
						'<div class="right">'+
							'<input user="'+dato['id_friend']+'" class="ui-button ui-widget ui-state-default ui-corner-all" style="font-size: 9px; padding: 2px 5px; margin-left: 3px;" type="button" value="Link"  action="linkUser,'+id_capa+','+dato['id_friend']+',,.contentSuggestFriends">'+
					'</div>'+
					'<div class="clearfix"></div>';
					$(id_capa).html(out).show().css('border-bottom','1px solid #f8f8f8');
			}else{
				if(data['cad']!=''){
					$(id_capa).css('height','0').css('border-bottom','0').css('display','none');
				}else{
					$('#seeMoreSuggest').fadeOut('400',function(){ $('#inviteSuggest').show(); });
					$(id_capa).html('<div class="messageInviteSuggest">Invita a tus amigos para que disfruten junto a ti en tagbum.com</div>');
				}
			}
		}
	});
}

function linkUser(id_user,objet,action){
	action=action*1;
	$.ajax({
		type	:'GET',
		url		:'controls/users/follow.json.php?uid='+id_user,
		dataType:'json',
		success	:function(data){
			if (!data['error']){
				switch(action){
					case 0: //desaparecer un boton y aparecer el otro (sin desaparecer contenedor)
						if (data['unlink']) $('input[type="button"][action="linkUser,'+id_user+'"]').hide().prev('input[type="button"]').show();
						else $('input[type="button"][action="linkUser,'+id_user+'"]').hide().next('input[type="button"]').show();
					break;
					case 1: //desaparecer el contenedor del amigo
						//caso unico para la seccion de admirados con sugerencia
						var sectionA=$(objet).parents('div#tab.unfollow');
						if (sectionA.length && !data['unlink']){
							$(objet).hide().next('input[type="button"]').show();
							var estuHtml=$(objet).parents('.thisPeople').html();
							$('div.thisPeople input[type="button"][action="linkUser,'+id_user+',1"]').parents('.thisPeople').remove();
							$(sectionA).prepend('<div class="divYourFriends thisPeople">'+estuHtml+'</div>');
						}else  $('div.thisPeople input[type="button"][action="linkUser,'+id_user+',1"]').parents('.thisPeople').remove();
					break;
					case 2: case 3: //desaparecer un boton y aparecer el otro (desapareciendo el contenedor)
						if (data['unlink']) $('input[type="button"][action="linkUser,'+id_user+',2"],input[type="button"][action="linkUser,'+id_user+',3"]').hide().prev('input[type="button"]').show();
						else $('input[type="button"][action="linkUser,'+id_user+',2"],input[type="button"][action="linkUser,'+id_user+',3"]').hide().next('input[type="button"]').show();
						$('div.thisPeople input[type="button"][action="linkUser,'+id_user+',1"],div.thisPeople input[type="button"][action="linkUser,'+id_user+',2"]').parents('.thisPeople').remove();
					break;
				}
				if ($('#nf').length>0 && $('#tab .ui-single-box-title').length==0){
					$('#nf').html('('+$('#tab .divYourFriends').length+')');
				}
			}
		}
	});
}

function userProfile(titulo,id,close){
	if(close){
	//close eliminado, conservado solo por compatibilidad. Si se incluyen todos los parametros, se desplaza el ultimo elemento al anterior
		id=close;
	}
	pauseCarousels('#tagLineFavorites', 'stop', true);
	$.dialog({
		title:titulo,
		resizable:false,
		width:620,
		height:370,
		modal:true,
		url:'views/users/account/userProfile.view.php?id='+id,
		buttons:[{
			text:lang.JS_CLOSE,
			click:function(){
				pauseCarousels('#tagLineFavorites','play',true);
				$(this).dialog('close');
			}
		}]
	});
}

function friendsUser(titulo,uid,mod){
	var opc={mod:mod,html:''};
	$.ajax({
		url: 'controls/users/people.json.php?action=friendsAndFollow&withHtml&nolimit&nosugg&w=380&mod='+opc.mod,
		type: 'POST',
		dataType: 'json',
		data: {uid: uid },
		success:function(data){
			$.dialog({
				title:titulo,
				resizable:false,
				width:580,
				height:315,
				modal:true,
				open:function(){
					if (!data['html']) data['html']='<div class="messageAdver" style="width: 400px; margin: 70px auto;text-align: center;">Disculpe, no hay resultados para: '+titulo.split(':')[1]+'</div>';
					$(this).html(data['html']);
				},
				buttons:[{
					text:lang.JS_CLOSE,
					click:function(){
						$('#friendsUser').html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
						$(this).dialog('close');
					}
				}]
			});
		}
	});
}

function tagsUser(titulo,get){
	$.dialog({
		id:'tagsUser',
		title: titulo,
		resizable:false,
		width:720,
		height:410,
		modal:true,
		open:function(){
			$(this).load('view.php?page=tags/tagsList.php&popup'+get);
		},
		buttons:{
			'Cerrar':function(){
				$(this).dialog('close');
			}
		}
	});
}

var PUBLISH;
function previewTag(titulo,get,wedit,update){
	PUBLISH=false;
	$.dialog({
		title: titulo,
		resizable: false,
		width:720,
		height:460,
		modal:true,
		show:'fade',
		hide:'fade',
		open:function(){
			$(this).load('views/tags/new/viewTag.php'+get);
		},
		close:function(/*ui*/){
			if(wedit==1){
				redir('timeline?current=timeLine');
			}else{
				if(!PUBLISH){
					$.ajax({
						type:'POST',
						url:'controls/tags/actionsTags.controls.php'+get+'&action=6',
						dataType:'text'
					});//ajax
				}
			}
		},//close
		buttons:{
			'Cancelar':function(){
				$(this).dialog('close');
				redir('timeline?current=timeLine');
			},
			'Cambiar':function(){
				PUBLISH=true;
				redir('update'+get);
			},
			'Publicar':function(){
				//wedit es uno cuando se esta modificanto un tag
				if(wedit==1){
					//delete old tag
					$.ajax({
						type:'POST',
						url:'controls/tags/actionsTags.controls.php?tag="+update+"&action=6',
						dataType:'text'
					});
				}
				//activar new tag
				$.ajax({
					type:'POST',
					url:'controls/tags/actionsTags.controls.php'+get+'&action=9',
					dataType:'text',
					success:function(data){
						$('loader.page',PAGE).hide();
						PUBLISH=true;
						switch(data.split('|')[0]){
							case '7':redir('groupsDetails?grp='+data.split('|')[1]);break;
							case '9':
								if(data.split("|")[2]!=0){
									redir('profile?sc=3');
								}else{
									redir('taglist?current=personal');
								}
							break;
							case '10':redir('wpanel/?url=vistas/viewTagWpanel.php');break;
							default: redir('timeline?current=timeLine');
						}
					}
				});//ajax

			}//click publish
		}
	});
}

function showPublicityWb(p){
console.log('publiRight '+p);
	$.ajax({
		type:'GET',
		url:'controls/publicity/sellPublicity.controls.php?op=1&ajax=1&p='+p,
		dataType:'html',
		success:function(result){
			return true;
		}
	});
}

function viewPublicity(){
	$.dialog({
		id:'messages',
		title: titulo,
		resizable: false,
		width:400,
		height:200,
		modal:true,
		open:function(){
			$(this).html(conte);
		},
		buttons:[{
			text:lang.JS_YES,
			click:function(){redirect(url);}
		},
		{
			text:lang.JS_NO,
			click:function(){$(this).dialog('close');}
		}]
	});
}
function str_replace(inChar,outChar,conversionString){
	var convertedString=conversionString.split(inChar);
	convertedString=convertedString.join(outChar);
	return convertedString;
}

function actionCheckbox_listFriends(chk) {
	var aux = "";
	if (document.getElementById(chk).checked == false){
		//se verifica si el checkbox oculto no esta seleccionado
		document.getElementById(chk).checked = true;
		//se selecciona el checkbox
		$("#hiddenLstMails").val($("#hiddenLstMails").val()+$("#"+chk).val()+',');
		//se concatena en el hidden que esta el el archivo view/users/listFriends_sendTag.view.php, el valor del checkbox. En este caso es el email
	}else{ //cuando se desmarca un checkbox
		document.getElementById(chk).checked = false; //se desmarca el checkbox
		aux = str_replace($("#"+chk).val()+',', '', $("#hiddenLstMails").val());
		//se elimina el email relacionado a ese checkbox del hidden
		$("#hiddenLstMails").val(aux); //se actualiza el valor del hidden
	}
}

function shareTag_friendsList(url, titulo,share){
	$.dialog({
		id:"shareTag_friendsList",
		title:titulo,
		resizable:false,
		width:630,
		height:570,
		modal:true,
		share:share,
		open:function(){
			var mails=[],mails2='';;
			$("#txtEmails :selected").each(function(i, selected){
				mails[i]=escape($(selected).text())+','+$(selected).val();
			});
			if (mails.length==0) mails=null;
			else mails2=mails.join(',');
			if (!mails && $("#txtEmails").val()!='') mails2=$("#txtEmails").val();
			$(this).load(url+"?"+share+"mails="+mails2);
		},
		buttons:[{
			text:lang.JS_CANCEL,
			click:function(){$(this).dialog("close");}
		},{
			text:lang.JS_CONTINUE,
			click:function(){
				var extras=[];
				if($("#extramails").val()!="") extras=$("#extramails").val().split(",");
				$("#contentLstUsersSeemytag li").each(function(i,obj){
					$(":checkbox",this).attr("name",$("strong",this).text());
				});
				var fields = $("#contentLstUsersSeemytag :checkbox").serializeArray();
				var mail=$("#txtEmails");
				if ($('#s2id_txtEmails').length>0){
					var selects=[],j=0;
					$.each(extras,function(i, field){ selects[j++]={id: field,text: field}; });
					$.each(fields, function(i, field){ selects[j++]={id: field.value, text: field.name }; });
					$("#txtEmails").select2("data", selects);
				}else{
					mail.parent().find('.holder li a').click();
					$.each(extras,function(i, field){
						mail.trigger("addItem",[{"title":field,"value":field}]);
					});
					$.each(fields, function(i, field){
						mail.trigger("addItem",[{"title":field.name,"value":field.value}]);
					});
				}
				$(this).dialog("close");
			}
		}]
	});
}

function compareValues(val_01, val_02, msj){
	if ($(val_01).val() == $(val_02).val()){
		return true;
	}else{
		message("messages", "Error", msj);
		return false;
	}
}

function payMorePersonalTag(titulo, msj_send){
	$.dialog({
		id:'payNewPersonalTag',
		title:titulo,
		resizable:false,
		width:450,
		height:250,
		modal:true,
		open:function(){
			$(this).load('views/tags/payMorePersonalTag.view.php');
		},
		buttons:[{
			text:lang.JS_CANCEL,
			click:function(){$( this ).dialog('close');}
		},{
			text:lang.JS_PAY,
			click:function(){
				$('#content_blok #loading strong').html(msj_send);
				$.ajax({
					type	:'POST',
					url		:'views/tags/payMorePersonalTag.view.php?pay=1',
					dataType:'text',
					success	:function(data){
						$('#content_blok').append(data);
						$(this).dialog('close');
					}
				});
			}
		}]
	});
}

//refrescar
function loadOtherSocialNetworks() {
	$.ajax({
		type	: "POST",
		url		: "views/othersSocialNetworks.view.php",
		dataType: "text",
		success	: function (data){
			$("#table_footer").prepend(data);
		}
	});
}

//precarga de imagenes
$.preloadImages = function(){
	for(var i = 0; i<arguments.length; i++) {
		$("<img>").attr("src", arguments[i]);
	}
}

$.preloadImages("css/smt/loader.gif");

//selector de colores
function colorSelector(picker,imput){
	var $picker=$('#'+picker),
		$input=$('#'+imput);
	$picker.hide();
	$picker.farbtastic('#'+imput);
	$input.click(function(){$picker.show('slow');});
	$input.blur(function(){$picker.hide('slow');});
	$input.addClass('colorSelector');
}

function showOrHide(show, layer) {
	if (show==1)
		$(layer).fadeIn(600);
	else
		$(layer).fadeOut(600);
}

function showOrHideVideo(show, layer1, layer2) {
	if (show==1){
		$(layer2).fadeOut(300, function() {
			$(layer1).fadeIn(600);
		});
	}else{
		$(layer1).fadeOut(300, function() {
			$(layer2).fadeIn(600);
		});
	}
}

function deleteItemAjax (id, type, opc){
	opc = (opc)? '&opc='+opc:'';
	//if(opc!=''){'&opc='+opc;}else{''};
	// console.log("controls/delete.php?id="+id+"&type="+type+opc);
	$.ajax({
		type	: "POST",
		url		: "controls/delete.php?id="+id+"&type="+type+opc,
		dataType: "text",
		success	: function (data){
			//console.log(data);
			if (data=='ok') {
				location.reload()
			}else{
				$.dialog({
					id:'messages',
					title:'Messages',
					resizable:false,
					width:250,
					height:200,
					modal:true,
					open:function(){
						$(this).html(data);
					},
					buttons:[{
						text:'Ok',
						click:function(){$(this).dialog('close');}
					}]
				});
			};
		}
	});
}

function actionConfirm(conte, titulo, url, deletex,opc) {
	opc = (opc)? opc:'';
	$.dialog({
		id:'messages',
		title:titulo,
		resizable:false,
		width:400,
		height:300,
		modal:true,
		open:function(){
			$(this).html(conte);
		},
		buttons:[{
			text:lang.JS_YES,
			click:function(){
				if(deletex){
					vars=deletex.split('|');
					deleteItemAjax(vars[0],vars[1],opc);//url, layer, type
					$(this).dialog('close');
				}else{
					redirect(url);
				}
			}
		},{
			text:lang.JS_NO,
			click:function(){$(this).dialog('close');}
		}]
	});
}

function fixCommas(string){
	if(string.indexOf(",")>-1){
		splitted=string.split(",");
		string="";
		for(var i=0;i<splitted.length;i++){
			string+="#"+splitted[i];
			if(i<splitted.length-1){
				string+=", ";
			}
		}
	}else{
		string="#"+string;
	}
	return string;
}

/*if(order){
	muestra y oculta
}else{
	oculta y muestra
}*/
function showAndHide(toShow,toHide,speed,order){
	toShow=fixCommas(toShow);
	toHide=fixCommas(toHide);
	if(!order){
		$(toHide).fadeOut(speed,function(){$(toShow).fadeIn(speed);});
	}else{
		$(toHide).fadeIn(speed,function(){$(toShow).fadeOut(speed);});
	}
}

function actionComments(post,func){
	var URL='controls/comments/comment.json.php';
	$.ajax({
		type:'POST',
		url:URL,
		data:post,
		success:function(){
			if($.isFunction(func)) func.call();
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
		'<li comment="'+comment['id']+'">'
			+'<div class="usr-pic">'
				+'<div action="profile,'+comment['idUser']+'" class="usr-pic" style="background-image:url(\''+comment['photoUser']+'\')"></div>'
			+'</div>'
			+'<div class="text">'
				+(comment['delete']?'<img src="css/smt/delete.png" class="del"/>':'')
				+'<em class="date">'+comment['fdate']+'</em>'
				+'<span class="name" title="Ver perfil" >'+comment['nameUser']+'</span>'
				+(!comment['subComment']?'<p>'+comment['comment']+'</p>':
					'<p>'+comment['subComment']+'</p>'
					+'<p style="display:none;">'+comment['comment']+'</p>'
					+'<span class="more">Ver m&#x00e1;s</span>'
				)
			+'</div>'
		+'</li>'
	);}
	var on={},count=0;
	function _getComments(action,obj,protected){
		if(!protected&&(action=='insert'||action=='del')) return;
//		console.log('getcomments');
//		console.log(obj);
		var opc=obj.data,layer=$(obj.layer);
		if(!layer.length) return;
		var $header=$('.header .title',layer),
			$loader=$('.loader',layer),
			$list=$('ul.list',layer),
			cancel=function(){return (action!='reload'&&on['reload']);},//cancel action
			onca=function(val){if(val!==undefined)on[action]=val;return on[action];};//on current action
		if(action=='all'){action='more';opc.all=true;}
		if(action!='refresh') $loader.show();
		if(action=='reload') opc.start=0;
		opc.action=action;
		onca(true);
		count++;
		$.ajax({
			type:'POST',
			data:opc,
			url:'controls/comments/list.json.php',
			dataType:'json',
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
				if(data['likes']!==null){
					$('#numLikes',$header).text(data['likes']);
					$('#numDislikes',$header).text(data['dislikes']);
				}
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
//				console.log(list);
				if(action=='reload'){
					$list.html(list);
				}else if(action=='refresh'||action=='insert'){
					$list.append(list);
				}else{
					$list.prepend(list);
				}
			},
			complete:function(){
				onca(false);
				if(!(--count)){
					$loader.hide();
					delete opc.action;
					delete opc.id;
					delete opc.txt;
					delete opc.all;
				}
				$('#txtComment',layer).removeProp('disabled');
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

function UserLikedOrRaffle(obj,act,sou){
	if ($(obj).html()*1>0 || act=='r'){
		if (act!='l' && act!='r' && act!='d') return;
		var titulo=new Array();
		titulo['l']='Me Gusta';
		titulo['d']='No me gusta';
		titulo['r']='Numero de participantes';
		$.ajax({
			url: 'controls/users/people.json.php?action=usersLikesTags&withHtml&w=380&t='+act+'&s='+sou.trim(),
			type: 'POST',
			dataType: 'json',
			success:function(data){
				$.dialog({
					title:titulo[act],
					resizable:false,
					width:580,
					height:315,
					modal:true,
					open:function(){
						if (!data['html']) data['html']='<div class="messageAdver" style="width: 400px; margin: 70px auto;text-align: center;">No hay resultados</div>';
						$(this).html(data['html']);
					},
					buttons:[{
						text:lang.JS_CLOSE,
						click:function(){
							$(this).dialog('close');
						}
					}]
				});
			}
		});
	}
}

function sellPublicityUpdate(url_vista, titulo, edit) {
	$.dialog({
		id:"sellpubliUpdate",
		title:titulo,
		resizable:false,
		width:500,
		height:550,
		modal:true,
		open:function(){
			$(this).load(url_vista);
		}
	});
}


function sellPublicity(url_vista,titulo,edit){
	$.dialog({
		id:"messages",
		title: titulo,
		resizable: false,
		width: 500,
		height: 500,
		modal: true,
		open: function() {
			$(this).load(url_vista);
		},
		buttons: [
			{
				text: lang.JS_CANCEL,
				click: function() {
					//$( this ).dialog( "destroy" );
					$( this ).dialog( "close" );
				}
			},
			{
				text: lang.JS_CONTINUE,
				click: function() {
					//validamos el formato de la imagen
					if (validaImputPictureFile("#publi_img") || (edit && valor("picture")) ) {
						//validamos que todos los campos este llenos
						if( valor("publi_title") && valor("publi_link") && valor("publi_msg") ) {
							//validamos que se un enlace valido
							if( validateForm("publi_link") ) {
								$("#sell_publi").submit();
//								redir('myPubli');

							} else {
								$("#sponsor_msgerror").fadeOut(600);
								$("#sponsor_msgerror2").fadeOut(600);
								showAndHide('sponsor_msgerror3', 'sponsor_msgerror3', 2500, true);
								//$("#sponsor_msgerror3").fadeIn(600);
							}
						} else {//campos llenos
							$("#sponsor_msgerror2").fadeOut(600);
							$("#sponsor_msgerror3").fadeOut(600);
							showAndHide('sponsor_msgerror', 'sponsor_msgerror', 2500, true);
							//$("#sponsor_msgerror").fadeIn(600);
						}
					}else{//formato de imagen
						$("#sponsor_msgerror3").fadeOut(600);
						$("#sponsor_msgerror").fadeOut(600);
						showAndHide('sponsor_msgerror2', 'sponsor_msgerror2', 2500, true);
						//$("#sponsor_msgerror2").fadeIn(600);
					}
				}// boton confirm
			}
		]
	});
}//FIN sellPublicity

function sellPublicityProducts(url_vista,titulo,edit){
	$.dialog({
		id:"sellPublicityProducts",
		title:titulo,
		resizable:false,
		width:500,
		height:570,
		modal:true,
		show:"fade",
		hide:"fade",
		open:function(){
			$(this).load(url_vista);
		},
		buttons:[{
			text:lang.JS_CANCEL,
			click:function(){
				//$(this).dialog("destroy");
				$(this).dialog("close");
			}
		},{
			text:lang.JS_CONFIG,
			click:function(){
				//validamos el formato de la imagen
				if(validaImputPictureFile("#publi_img")||(edit&&valor("picture"))){
					//validamos que todos los campos este llenos
					if(valor("publi_title")&&valor("publi_link")&&valor("publi_msg")){
						//validamos que se un enlace valido
						//alert($("#publi_link").val());
						if(validateForm("#sell_publi")){
							$("#sell_publi").submit();
//								redir('myPubli');

						}else{
							$("#sponsor_msgerror").fadeOut(600);
							$("#sponsor_msgerror2").fadeOut(600);
							showAndHide('sponsor_msgerror3','sponsor_msgerror3',2500,true);
							//$("#sponsor_msgerror3").fadeIn(600);
						}
					}else{//campos llenos
						$("#sponsor_msgerror2").fadeOut(600);
						$("#sponsor_msgerror3").fadeOut(600);
						showAndHide('sponsor_msgerror','sponsor_msgerror',2500,true);
						//$("#sponsor_msgerror").fadeIn(600);
					}
				}else{//formato de imagen
					$("#sponsor_msgerror3").fadeOut(600);
					$("#sponsor_msgerror").fadeOut(600);
					showAndHide('sponsor_msgerror2','sponsor_msgerror2',2500,true);
					//$("#sponsor_msgerror2").fadeIn(600);
				}
			}// boton confirm
		}]
	});
}//FIN sellPublicity

function actionSellPublicity(opc,id_publicity){
	switch(opc){
		//play publicity
		case 0:
			$.ajax({
				type:"POST",
				url:"controls/publicity/play_pause.control.php?action=play&id_publicity="+id_publicity,
				dataType:"text",
				success:function(){
					$("#"+id_publicity).html('<img src = "img/publicity/publicity_pause.png" width = "16" height = "16" border	= "1" title	= "Continue promoting" style = "cursor:pointer; border-radius: 4px;" onclick= "actionSellPublicity(1, \''+id_publicity+'\');"/>');
				}
			});
		break;
		//pause publicity
		case 1:
			$.ajax({
				type	:	"POST",
				url		:	"controls/publicity/play_pause.control.php?action=pause&id_publicity="+id_publicity,
				dataType:	"text",
				success	:	function(  ) {
								$("#"+id_publicity).html('<img src = "img/publicity/publicity_play.png" width = "16" height = "16" border	= "1" title	= "Continue promoting" style = "cursor:pointer; border-radius: 4px;" onclick= "actionSellPublicity(0, \''+id_publicity+'\');"/>');
							}
			});
		break;
	}
}

//publicity
function updateUI(value, location) {
	$.ajax({
		type	:	"POST",
		url		:	"controls/publicity/calculateClicks.control.php?investment="+value+"&action="+location,
		dataType:	"html",

		success	:	function (data) {
			$('#'+location).val(data);
		}
	});
}

function numbersonly(e, allowPoint) {
	// allowPoint = allowPoint || true;
	allowPoint = (allowPoint) ? 46 : 44;
	var key;
	var keychar;
	if (window.event)	{key = window.event.keyCode;}
	else if (e)			{key = e.which;}
	else				{return true;}
	keychar = String.fromCharCode(key);
	// console.log('El keycode: '+ key);
	// if( keychar && key==0 ) {
	// 	switch( foco ) {
	// 		case 'publi_amount_1':document.sell_publi.publi_amount_2.focus();break;
	// 		case 'publi_amount_2':document.sell_publi.publi_amount_1.focus();break;
	// 	}
	// }
	if( key==null || key==0 || key==9 || key==13 || key==27 || key==44 ) {// control keys
		return true;
	} else if( ("0123456789").indexOf(keychar)>-1 || key==8 || key==allowPoint) { // numbers
		return true;
	}
	return false;
}

function showHide(inputShow, tittleShow, inputHide, tittleHide) {
	$('#'+tittleHide).fadeOut('fast',	function() {$('#'+tittleShow).fadeIn('fast');} );
	$('#'+inputHide	).fadeOut('fast',	function() {$('#'+inputShow ).fadeIn('fast');} );
}

//groups
function listGroups(layer,action,get,layerloader){
	get=get?'&'+get:''; //NOT_MY_GROUP ltNewGroup
	var limit=(action!=''&& action!='srh')?'?limit='+action:'?limit=0'
	$(layerloader).css('display','block');
	if (action=='srh') $(layer).empty().html('');
    $.ajax({
		type	:	"GET",
		url		:	"controls/groups/listGroups.json.php"+limit+get,
		dataType:	"json",
		success	:	function (data) {
			var html='',idPrivacy='',privacyGrp='';
			$(layerloader).css('display','none');
			if (data['numResult']>0){
				for (var i=0;i<data['list'].length;i++){
					html+=bodygroups(data['list'][i]);
				}
				if (action!='' && action!='srh') $(layer).append(html);
				else{
			         $(layer).html(html);
                     if (data['category'] && action!='srh'){
                        var groups=data['category'],html='';
                        for(var i=0;i<groups.length;i++){
                            html+='<li style="background-image: url('+groups[i]['cphoto']+');">'
        						+'	<span><a c="'+groups[i]['id']+'" >'
        						+     groups[i]['name']+'  <span>('+groups[i]['num']+')</span>'
        						+'	</a></span>'
        						+'</li>';
                        }
        				$('ul#menuGroups').append(html);
                        $('aside').css('display','block');
                     }
				}
			}else{
				if (data['msg']){
					$(layer).html(data['msg']);
					$('.messageAdver #ltNewGroup').click(function(){
						addNewGroup('Crear un Nuevo Grupo','');
						return false;
					});
				}
			}
		}
	});
}
function addNewGroup(titulo,gpr) {
	$.dialog({
		title: titulo,
		resizable: false,
		width: 640,
		height: 580,
		open: function() {
		 	// $(this).load('view.php?page=users/groups/newGroup.php'+gpr);
		 	$(this).load('dialog?pageid=newGroups'+gpr);
		 },
		buttons: [{
				text: lang.JS_CLOSE,
				click: function() {$( this ).dialog( "close" );}
			},{
				text: gpr?lang.JS_CONFIRM:lang.JS_ADD,
				click: function() {
					if (valida()) $("#frmAddGroup").submit();
				}
			}]
	});
}
function confirJOINGroups(opc) {
	$.dialog({
		title	: 'Informaci&#x00f3;n',
		content	: '&#x00bf;Deseas unirte a este grupo?',
		height	: 200,
		close	: function(){
			$(this).dialog('close');
		},
		buttons: [ {
			text: lang.JS_NO,
			click:function() { $(this).dialog('close'); }
			},{
				text: 'Si',
				click:function() {
					$(this).dialog('close');
					console.log(opc);
					var obje;
//					$(opc[2]).button('disable');
					if (opc[1]){
						obje={
						btnJ:'#joinGroup',
						autori:'#autoriGr',
						actionDiv:'div.bckOvergroup'};
					}else{
						obje={
						btnJ:'#joinGroup'+opc[0],
						autori:'#autoriGr'+opc[0],
						actionDiv:'div.bckOvergroup[h="'+opc[0]+'"]'};
					}
					actionGroup(opc[0],3,'',obje);
				}
			} ]
	});
}
function suggestGroup(titulo, get){
	$.dialog({
		title: titulo,
		url: 'views/users/groups/suggestGroup.php',
		resizable: false,
		width:620,
		height:400,
		modal: true,
		show: 'fade',
		hide: 'fade',
		buttons: [ {
				text: lang.JS_CANCEL,
				click:function() { $(this).dialog('close'); }
			},{
				text: lang.JS_SEND,
				click:function() {
					if ($('#txtEmails').val()){
						var mails=$('#txtEmails').val(),$this=$(this),obje={data:mails,msj:$('#txtMsgMail').val()};
						$$.ajax({
							type	: 'POST',
							url		: 'controls/groups/suggestGroup.json.php?grp='+get,
							data	:  obje,
							dataType: 'json',
							success	: function (data){
								$('#suggest_group').html(data['menjs']);
								setTimeout(function(){
									$this.dialog('close');
								}, 2500);
							}
						});
					}else{ showAndHide('divNoUser',	'divNoUser',	1500, true) }
				}
			} ]
	});
}
function actionGroup(id,action,get,obje){
		$$.ajax({
		type	:	'POST',
		url		:	'controls/groups/actionsGroups.json.php?action='+action+'&grp='+id+get,
		dataType:	'json',
		success	:	function (data) {
			switch (action) {
				case 3:
					if(data['join']=='true'){
						redir('groupsDetails?grp='+id+'&'+Math.random());
					}else if(data['join']=='private-sent'){
						message('confirmGroup',lang.JS_GROUPS_MESSAGETOENTERGROUPS,'<strong>'+lang.JS_GROUPS_MESSAGEAPPROBATION+'<strong>');
						$(obje.btnJ).fadeOut('fast',function(){
							$(obje.autori).fadeIn('fast');
						});
						$(obje.actionDiv).removeAttr('action');
					}else if (data['join']=='existe'){
						$.dialog({
							title	: 'Informaci&#x00f3;n',
							content	: 'Ya existe una solicitud de membres&iacute;a a este grupo',
							height	: 200,
							close	: function(){
								location.reload();
							}
						});
					}
				break;
				case 4:
					if (data['leave']=='leave'){
						asigAdmin('Leyenda - Abandonar Grupo',id);
					}else if (data['leave']=='true'){
						redir('groups');
					}
				break;
				case 7:
					if (obje.btnJ){
						if(data['accept']=='true'){
							if (data['invite']=='no-invite'){
								$.dialog({
									title	: 'Informaci&#x00f3;n',
									content	: 'Disculpe, su invitaci&oacute;n fue cancelada por un administrador.',
									height	: 200,
									close	: function(){
										location.reload();
									}
								});
							}else{ redir('groupsDetails?grp='+id+'&'+Math.random()); }
						}else if(data['accept']=='false'){
							$(obje.btnJ).fadeOut('fast',function(){
								$(obje.autori).fadeIn('fast');
							});
							$(obje.actionDiv).attr('action',obje.actionDivN)
						}
					}else{
						if(data['accept']=='true'){ location.reload(); }
						else if(data['accept']=='false'){ history.back(); }
					}
				break;
				case 8:
					console.log('users '+data['cug']);

					if (data['insert']=='insert'){
						if (data['cug']!=0) {
							if ($('#membersGroups div[h="active"]').length){
								obje.parents('.membersGroupsWindows').appendTo('#membersGroups div[h="active"]');
								obje.parents('div[h="3"]').css('display','none');
							}else{ obje.parents('.membersGroupsWindows').remove(); }
						}else{
							//$(this).dialog('close');
							$('.ui-dialog .ui-dialog-content').dialog('close');
						};
					}else{
						obje.parents('.membersGroupsWindows').remove();
						var actual=$('.titlesGroups span').html();
						$('.titlesGroups span').html(+actual-1);
					}
					if (data['num']=='0'){
						if ($('#membersGroups div[h="active"]').length){ $('#membersGroups div[h="resque"]').remove();
						}else{ $('#btnCloseMembers').click(); }
					}
				break;
			}
		}
	});
}
function asigAdmin(titulo,idGroup){
	$.dialog({
		title: titulo,
		resizable: false,
		width:580,
		height:270,
		modal: true,
		show: "fade",
		hide: "fade",
		open: function() {
			$(this).html('<div id="bordeasigAdmin">'
						+'			<div style=" margin: 0 auto; height: 110px">'
						+'				<div  style=" height: 30px;">'
						+'					<div class="title">'
						+'						Asignar Administrador(es)'
						+'					</div>'
						+'					<div class="text">'
						+'							Selecciona el(los) administrador(es) del grupo.'
						+'					</div>'
						+'				</div>'
						+'					<div class="clearfix"></div>'
						+'				<div style=" width: 500px; border-bottom: 1px solid #e5e3e3; margin-left: 10px;"></div>'
						+'				<div  style=" height: 40px; ">'
						+'					<div class="title">'
						+'						Abandonar'
						+'					</div>'
						+'					<div class="text">'
						+'						Usted es un administrador de este grupo. Si el grupo queda sin administrador, ser&#x00e1; eliminado. &#x00bf;Est&#x00e1; seguro que desea abandonar el grupo?'
						+'					</div>'
						+'				</div>'
						+'					<div class="clearfix"></div>'
						+'			</div>'
						+'		</div>');
		},
		buttons: [
			{
				text: lang.JS_GROUPS_ASIGADMINMEMBERS,
				click: function() {
					asigAllAdmin(lang.JS_GROUPS_ASIGADMINMEMBERS,idGroup);
					$(this).html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
					$(this).dialog("close");
				}
			},
			{
				text: lang.JS_GROUPS_LEAVEGROUPADMINMEMBERS,
				click: function() {
					actionGroup(idGroup,4,'&admin=1&force');
					$(this).html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
					$(this).dialog("close");
					redir('groups');
				}
			},
			{
				text: lang.JS_CLOSE,
				click: function() {
					$(this).html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
					$(this).dialog("close");
				}
			}
		]
	});
}
function asigAllAdmin(titulo,idGroup){
	$.dialog({
		title: titulo,
		resizable: false,
		width:700,
		height:595,
		open: function() {
			$(this).load("views/users/groups/lstAsigAdmin.php?grp="+idGroup);
		},
		buttons: [
			{
				text: lang.JS_CLOSE,
				click: function() {
					$("#asigAllAdmin").html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
					$(this).dialog("close");
					$('#default-dialog').dialog("close");
				}
			},
			{
				text: lang.JS_ASSIGN,
				click: function() {
						//valores del formulario
						var form = $('#frmInviteGroup :checkbox').serialize();
						// separar valores
						var chk = form.split("&");
						//arreglo para guardar valores
						var chkval=new Array();
						// alert ();
						for(i=0;i<chk.length;i++){
						var da = chk[i].split("=");
						//alert (d[i]);
						//armamos el arreglo
						chkval.push(da[1]);
						}

						//alert(chkval.join(','));
						var arrayVal = chkval.join(',');
						$.ajax({
							type	:	"GET",
							url		:	"controls/groups/actionsGroups.json.php?force=1&action=6&grp="+idGroup+"&chkVal="+arrayVal,
							dataType:	"json",
							success	:	function (data) {
								if(data['asig']=='true'){
									$("#asigAllAdmin").html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
									$('#default-dialog').dialog("close");
									redir('groups');
								}else if (data['asig']=='false'){
									$('#default-dialog').dialog("close");
								}
							}
						});
				}
			}
		]
	});
}
function det_info(data){
    return ('<article class="info side-box imagenSug">'+
            '<header><span>Informaci&#x00f3;n</span></header>'+
            '<div>'+
                '<ul>'+
                    '<li><label>Privacidad: </label>'+data['etiquetaPrivacidad']+'</li>'+
                    '<li><label>Orientaci&#x00f3;n: </label>'+data['des_o']+'</li>'+
                    '<li><label>Categor&#x00ed;a: </label>'+data['cname']+'</li>'+
                    '<li><a>Ver Detalles &raquo;</a></li>'+
                '</ul>'+
            '</div>'+
        	'<strong></strong>'+
        	'<div class="clearfix"></div></article>'+
            '<article class="member side-box imagenSug">'+
            '<header><span>Miembros</span></header>'+
            '<div>'+
                '<ul>'+
                    '<li><label>Creador: </label>'+data['name_create']+'</li>'+
                    '<li><label>Administradores: </label>'+data['num_admin']+'</li>'+
                    '<li><label>Miembros: </label>'+data['num_members']+'</li>'+
                    '<li><a>Ver Detalles &raquo;</a></li>'+
                '</ul>'+
            '</div>'+
        	'<strong></strong>'+
        	'<div class="clearfix"></div></article>');
}
function dialog_info(data){
    var conten='<div id="dialog_detail_group">'+
            '<header class="limitTitle" ><span>'+data['name']+'</span></header>'+
            '<div><img '+data['photoi']+' alt="Group Icons" /></div>'+
            '<div class="side-box">'+
                '<ul>'+
                    '<li><label>Privacidad: </label><div class="'+data['privacidad']+'"></div>'+data['etiquetaPrivacidad']+'</li>'+
                    '<li><label>Orientaci&#x00f3;n: </label>'+data['des_o']+'</li>'+
                    '<li><label>Categor&#x00ed;a: </label><img src="'+data['cphoto']+'" alt="Group Icons" title="'+data['ctitle']+'" width="30" height="30"/>'+data['cname']+'</li>'+
                    '<li><label>La fecha de su fundaci&#x00f3;n: </label>'+data['date']+'</li>'+
                    '<li><label>Fecha en que se uni&#x00f3;: </label>'+data['date_join']+'</li>'+
                    '<li><label>Descripci&#x00f3;n: </label><p>'+data['des']+'</p></li>'+
                '</ul>'+
            '</div>'+
        	'<div class="clearfix"></div></div>';
    message('#default','Grupo',conten,'',500,400);
}
function membersGroups(id,status){
    status=status?'&status='+status:'';
    var	opc={ actual:'',total:'',layer: '',grupo: id,status: status }
    $.dialog({
		title: 'Miembros',
		resizable: false,
		width: 680,
		height: 580,
		modal: true,
		open: function() {
            opc.layer=$(this);
			$.ajax({
				type	:	"GET",
				url		:	"controls/users/people.json.php?action=groupMembers&withHtml&idGroup="+opc.grupo+"&actual''"+status,
				dataType:	"json",
				success	:	function (data) {
					if (opc.actual==''){
						opc.total=data['num'];
						if (data['html']){
							opc.actual=data['actual'];
							$(opc.layer).html('<div id="member-list"><div id="membersGroups">'+data['html']+'</div></div>');
							if(data['totalP']) opc.total=data['total']-data['totalP'];
								
                            $('.ui-dialog-title').html('('+opc.total+') Miembros')
						}else{
							$(opc.layer).html('<div class="messageAdver">Disculpe, no hay resultados para</div>');
						}
					}else{
						opc.actual=opc.actual+data['actual'];
						$('#membersGroups',opc.layer).append(data['html']);
					}
				}
			});
		}
	});
}
(function(window,$,console){
	var band;
	window.inviteFriendsToGroup=function(titulo, groupId) {
		$.dialog({
			title: titulo,
			resizable: false,
			width: 680,
			height: 580,
			modal: true,
			show: "fade",
			hide: "fade",
			close:function(){
				$(this).dialog('close');
			},
			open: function() {
				var $this=$(this); band=false;
				$.ajax({
					url: 'views/users/groups/inviteFriendsToGroup.php?grp='+groupId,
					success: function(data) {
						$this.html(data);
					}
				});
			},
			buttons: [{
					text: lang.JS_CLOSE,
					click: function() {$( this ).dialog("close");}
				},{
					text: lang.JS_INVITEUSERS_BTNINVITE,
					click: function() {
						if (valida()){
							if (!band) $("form ",this).submit();
							band=true;
						}
					}
				}
			]
		});
	}
})( window, jQuery, console );

function mskPointsReload(id){
	$.ajax({
		type: 'POST',
		url: 'controls/users/getUserPoints.json.php',
		dataType: 'json',
		success: function(data){
			//console.log(data);
			$(id).html(data);
		}
	});
}

//store /////////////////////////////////////////////
function bodyListProd(prod,obje,i){
	//Formate el costo de producto en dollares
	var tempEle = $('<span>'+prod['cost']+'</span>');
	var costFormated = $(tempEle).formatCurrency({symbol:''});
	var cost = costFormated.html();
	if (prod['pago']=='0'){
		var auxi=cost.split('.');
		cost = auxi[0];
	}
	tempEle = costFormated = null;
	//variables requeridas
	var lst='',actionLi='',footerDiv='',inputCreate='',miniCar='',clasesLi='',attrR='',actionDiv='action="detailProd,'+prod['id']+'"';
	if (prod['type_user']=='1'){
		if (prod['p_adtb']){ footerDiv='<span class="footer color_orange">Producto de Tagbum</span>'; }
		else {footerDiv='<span class="footer color_blue">Producto de empresa</span>'; }
	}else if(prod['type_user']=='0'){ footerDiv='<span class="color_green footer">Producto de Usuario</span>'; }
	if (obje.layer=='#selectProducts .product-list' && !obje.noBorde){
		actionLi='action="newRaffle,'+prod['id']+',,dialog"';
		actionDiv='';
		footerDiv='';
	}else if (obje.layer=='#selectProductsTags .product-list' && !obje.noBorde){
		actionLi='action="createTag,?product='+prod['id']+',dialog"';
		actionDiv='';
		footerDiv='';
	}
	if (i>=(obje.numR-3)){ clasesLi+='border-botton-store'; }
	//else if (i>=(obje.numR-obje.limit)){ clasesLi+='border-botton-store'; }
	if ((i+1)%3==0 || i==(obje.numR-1)){ clasesLi+=(clasesLi!=''?' ':'')+'border-r-store'; }
	if (obje.more && (i>=0 && i<=2)){ clasesLi+=(clasesLi!=''?' ':'')+'border-t-store'; }
	if (obje.noBorde){ clasesLi='no-border-store'; }
	if (prod['raffle'] && !obje.noBorde){
		clasesLi+=(clasesLi!=''?' ':'')+'transparencia_hover';
		attrR='r="1"';
		var inputFooter='';
		if (prod['stock']=='0'){ inputFooter='<span class="nameSP" stock="0">Stock: 0</span>'; }
		else{
			if(obje.idUsr!=''){ inputFooter+='<span class="nameSP" action="newRaffle,'+prod['id']+'">Crear producto gratuito</span>'; }
			inputFooter='<br><span class="nameSP" action="createTag,?product='+prod['id']+'">Crear Tag</span>';
		}
		inputCreate='<div class="inputCreateRaffle">'
						+'<div>'
						+'<div class="inputTitleProduct"><span class="nameSP">'+prod['name']+'</span></div>'
						+'<div class="lis_product_store" style="background-image:url(\''+prod['photo']+'\');"></div>'
						+'<div class="clearfix"></div>'
					+'</div>'
					+'<div class="limitComent">'+prod['description']+'</div>'
					+'<div class="clearfix"></div>'
					+inputFooter
					+'<br><span class="nameSP" action="detailProd,'+prod['id']+'">Ver Detalles &raquo;</span>'
				+'</div>'
	}else if (!obje.noBorde){
		attrR='r="2"';
		miniCar='<div class="miniCarStore">'
					+'<div title="Add to Cart" class="bg-add" h="'+prod['id']+'"></div>'
				+'</div>';
	}
	lst =	'<li p="1" '+actionLi+' class="'+clasesLi+'" '+attrR+'>'
				+'<div '+actionDiv+' class="lis_product_store" style="background-image:url(\''+prod['photo']+'\');"></div>'
				+'<div '+actionDiv+' class="detail_store_product">'
					+'<span class="nameSP">'+prod['name']+'</span><br>'
					+'<span class="priceSP">Precio:</span><span> '+(prod['pago']==1?' $'+cost:cost+' Puntos')+'</span><br>'
					+'<span class="footer">Categor&iacute;a: '+prod['category']+((prod['subCategory'])?'<br> SubCategor&iacute;a: '+prod['subCategory']+'</span>':'')+'<br>'
					+footerDiv
				+'</div>'
				+inputCreate+''+miniCar
			+'</li>';
	return lst;
}
function storeListProd(layer,get,search){
	get=get?get:'';
	get+=search?'':'&sug=1&';
	search=search?search:'';
	if ($('#loaderStore2').length>0) $('#loaderStore2').css('display','block');
	if (layer!='#selectProducts .product-list' && layer!='#selectProductsTags .product-list'){
		$('div.product-list.produc,div.product-list.sugest').empty().html('');
		$('#loaderStore').css('display','block');
	}else{ $('#loaderStoreDialog').css('display','block'); }
	//$(layer).html('<span class="store-span-loader">Cargando </span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />');
	//console.log(' busqueda pro: '+search+'--'+get);
	$$.ajax({
		type:'POST',
		url:'controls/store/listProd.json.php'+get+'module=store&limit=0',
		dataType:'json',
		success:function(data){
			if(layer!='#selectProducts .product-list' && layer!='#selectProductsTags .product-list'){
				$('#loaderStore').css('display','none');
			}else{
				$('#loaderStoreDialog').css('display','none');
			}
			if($('#loaderStore2').length>0) $('#loaderStore2').css('display','none');
			var prod=data['prod'],lst='',idUsr=(data['adtb']?1:''),obje,option='';
			obje={layer:layer,idUsr:idUsr};
			if(prod){
				var numR=prod.length;
				obje.limit=numR%3;
				obje.numR=numR;
				lst = '<ul>';
				for(var i=0;i<numR;i++){ lst+=bodyListProd(prod[i],obje,i); }
				lst += '</ul>';
				if(search!=''){
					if(numR>=3){ obje.limit=1; obje.numR=3; }
					option='<ul>';
					for(var i=0;i<obje.numR;i++){ option+=bodyListProd(prod[i],obje,i); }
					option+='</ul>';
				}
				if(data['hash']){
					var out='', res='',sp = '';
					out +='<article id="storeTagsRealted" class="side-box">'
							+'<header><span>Related tags</span></header>';
							for(var i=0;i<data['hash'].length;i++){
								if(data['hash'][i].length>15){
									res = data['hash'][i].substr(0,15);
									sp  = '...';
								}else{
									res = data['hash'][i];
									sp  = '';
								}
								out+='<div class="searchHash"><a href="'+BASEURL+'searchall?srh='+data['hash'][i]+'&in=2">'+res+sp+'</a></div>';
							}
							out+='<div class="clearfix"></div>'
						+'</article>';
					$('#searchHashProduct').html(out);
				}

			}else if(layer!=''){
				if(search!=''){
					var cad=search.split(',');
					search=(cad[1])?'#'+cad[0]:search;
					lst='<div class="messageNoResultSearch">Disculpe, no hay resultados para<span id="valSearch"> '+search+'</span> <span style="font-size:12px">Compruebe su termino de busqueda e intentelo de nuevo.</span></div>'
					+'<div class="ui-single-box-title">Sugerencias</div>';
					option = '<div class="messageNoResultSearch">Disculpe, no hay resultados para<span style="font-weight:bold"> '+search+'</span> <span style="font-size:12px">Compruebe su termino de busqueda e intentelo de nuevo.</span></div>';
					storeListProd('.product-list.sugest','?rand=1&');
				}else{
					if (layer!='.product-list.sugest'){
						lst='<div class="noStoreProductsList messageAdver"><span>No hay productos disponibles</span>'+(data['empre']?', Si desea agregar un producto haga <span id="clickNewProduct">click aqui</span>':'')+'</div>'
							+'<div class="ui-single-box-title">Sugerencias</div>';
						storeListProd('.product-list.sugest','?rand=1&');
					}else{ $('.product-list.produc div.ui-single-box-title').remove(); }
				}
			}
			$(layer).html(lst);
			if(search!=''){
				$('#pruebaList '+layer).html(option);
				if(prod && prod.length>4){$('#clickproduct').show()}
			}
//			$('.button').button();
			if (data['asoWish'] && layer!='.product-list.sugest'){
				var prod=data['asoWish'];
				lst = '<ul>';
				obje={ layer:layer, idUsr:idUsr, noBorde:'true' };
				for(var i=0;i<prod.length;i++){
					lst+=bodyListProd(prod[i],obje,i);
				}
				lst += '</ul>';
				$('div.product-list.produc_sugg').html('<div class="ui-single-box-title" >Productos que te pueden interesar</div>'
														+'<div>'+lst+'</div>'
														+'<div class="clearfix"></div>');
			}
			if (data['asoSrh'] && layer!='.product-list.sugest'){
				var prod=data['asoSrh'];
				lst = '<ul>';
				obje={ layer:layer, idUsr:idUsr, noBorde:'true' };
				for(var i=0;i<prod.length;i++){
					lst+=bodyListProd(prod[i],obje,i);
				}
				lst += '</ul>';
				$('div.product-list.produc_suggSrh').html('<div class="ui-single-box-title" >Inspirado por su historial de b&uacute;squeda</div>'
														+'<div>'+lst+'</div>'
														+'<div class="clearfix"></div>');
			}
		}
	});
}

function storeRaffle(layer,get){
	$('#loaderStore').css('display','block');
	//$(layer).html('<span class="store-span-loader">Cargando Lista de productos</span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />');
	get=get?get:'';
	$.ajax({
		type: 'POST',
		url: 'controls/store/listProd.json.php'+get+'module=raffle&limit=0',
		dataType: 'json',
		success: function(data){
			$('#loaderStore').css('display','none');
			var lst='',prod=data['prod'];
			if (prod){
				lst = '<ul>';
				var limt=prod.length%3;
				for(var i=0;i<prod.length;i++){
					//Formate el costo de producto en dollares
					var tempEle = $('<span>'+prod[i]['points']+'</span>');
					var costFormated = $(tempEle).formatCurrency({symbol:''});
					var cost = costFormated.html();
					var auxi=cost.split('.');
					cost = auxi[0];
					lst +=	'<li p="1" '+((prod[i]['my'])?'action="newRaffle,'+prod[i]['id']+','+prod[i]['id_raffle']+'"':'action="detailProd,'+prod[i]['id']+',raffle"')+' class="'+((limt==1)?((i==(prod.length-1))?'border-botton-store':''):((limt==2)?(i>=(prod.length-2))?'border-botton-store':'':((limt==0)?(i>=(prod.length-3))?'border-botton-store':'':'')))+' '+(((i+1)%3==0)?'border-r-store':'')+'">'
								+'<div class="lis_product_store" style="background-image:url(\''+prod[i]['photo']+'\')";></div>'
								+'<div class="detail_store_product">'
									+'<span class="nameSP">'+prod[i]['name']+'</span><br>'
									+'<span>Costo: '+cost+' Puntos</span><br>'
									+'<span class="footer">Fecha de inicio: '+prod[i]['start_date']+'</span><br>'
									+((prod[i]['end_date'])?'<span class="footer">Fecha final: '+prod[i]['end_date']+'</span>':'<span class="footer">Numero de participantes: '+prod[i]['cant_users']+'</span>')
								+'</div>'
							+'</li>';
				}
				lst += '</ul>';
			}else{
				if (layer!='.product-list .product-list'){
					lst='<div class="noStoreProductsList messageAdver"><span>No hay productos gratis disponibles</span>'+(data['empre']?', Si desea agregar <span id="clickNewRaffle">click aqui</span>':'')+'<div class="product-list"></div>';
				}
			}
			$(layer).html(lst);
		}
	});
}

function seeMoreStore(layer,get,limit,module,loader){
	$('#loaderStore').css('display','block');
	$.ajax({
		type:'GET',
		url:'controls/store/listProd.json.php'+get+'module='+module+'&limit='+limit,
		dataType:'json',
		success:function(data){
			$('#loaderStore').css('display','none');
			var prod=data['prod'];
			if(prod){
				var lst='',idUsr=(data['adtb']?1:'');
				var limt=prod.length%3;
				if(module=='store'){
					var obje={ layer:layer, idUsr:idUsr,more:'true' };
					var numR=prod.length;
					obje.limit=numR%3;
					obje.numR=numR;
					for(var i=0;i<prod.length;i++){
						lst+=bodyListProd(prod[i],obje,i);
					}
				}else if(module=='raffle'){
					for(var i=0;i<prod.length;i++){
						lst +=	'<li action="detailProdRaffle,'+prod[i]['id']+'" class="'+((limt==1)?((i==(prod.length-1))?'border-botton-store':''):((limt==2)?(i>=(prod.length-2))?'border-botton-store':'':((limt==0)?(i>=(prod.length-3))?'border-botton-store':'':'')))+' '+(((i+1)%3==0)?'border-r-store':'')+'">'
									+'<div class="lis_product_store" style="background-image:url(\''+prod[i]['photo']+'\')";></div>'
									+'<div>'
										+'<span class="nameSP">'+prod[i]['name']+'</span><br>'
										+'<span>Costo: '+prod[i]['points']+' Puntos</span><br>'
										+'<span class="footer">Fecha de inicio: '+prod[i]['start_date']+'</span><br>'
										+'<span class="footer">Numero de participantes: '+prod[i]['cant_users']+'</span>'
									+'</div>'
								+'</li>';
					}
				}
				$(layer).append(lst);
			}
		}
	});
}

function deleteItemCar(id,get,obj){
	get=get?get:'';
	$$.ajax({
		type:'GET',
		url:'controls/store/shoppingCart.json.php?action=2&w=1&id='+id+get,
		dataType:'json',
		success: function(data){
		console.log(data);
			if (data['del']!='1'){
				if (data['del']=='all'){
					if (obj.mod!='wish'){
						$('#list_orderProduct').html('<div class="messageAdver">Disculpe, no hay art&#x00ed;culos disponibles en su carrito de compras.</div>');
						$('div.ui-single-box').removeAttr('style');
						$('#headerStoreCar').css('display','none');
						$('.menu-l-shoppingCart').css('display','none');
					}else{
						if(obj.shop&&obj.shop=='true'){
							if (data['wish'] && data['wish']['body']){
								$('#list_orderProduct_wish div.messageAdver').slideUp().empty().html('');
								$('#list_orderProduct_wish ul').empty().html(data['wish']['body']);
//								$('.button').button();
							}else{
								$('#list_orderProduct_wish').empty().html('').css('display','none');
							}
						}else{
							$('#list_orderProduct_wish').html('<div class="messageAdver">Disculpe, no hay articulo disponibles en su lista de deseos.</div>');
							$('div.ui-single-box').removeAttr('style');
						}
					}
				}else if (data['del']=='no-all'){
					var div='';
					if (obj.mod!='wish'){div='#list_orderProduct '; }else{ div='#list_orderProduct_wish ';}
					if ($(div+'.updateItems').length>0){ $(div+'div.noST').slideUp().empty().html('');}
					else{ $(div+'div.messageAdver').slideUp().empty().html(''); }
					var elementos='',can=0,can2=0,i;
					for (i=0; i<data['delete'].length;i++){
						elementos+=(elementos!=''?',':'')+div+'.messageAdver .updateItems span[h="'+data['delete'][i]+'"]';
						if ($(div+'.messageAdver .updateItems span[h="'+data['delete'][i]+'"]').length==1){ can++; }
					}
					can2=$(div+'.messageAdver .updateItems span[h]').length;
					if (can2==can){ $(div+'div.messageAdver').slideUp().empty().html(''); }
					else {
						$(elementos).slideUp().empty().html('').removeAttr('h');
						$(div+'.messageAdver .updateItems strong span.numI').html(can2-can);
					}
					if (obj.mod!='wish'){
						$('#menu-lshoppingCart').html(data['numR']);
						var lst='';
						for(var i=0;i<data['datosCar'].length;i++){
							lst+=bodyShopingCar(data['datosCar'][i],i);
						}
						$('#list_orderProduct ul').empty().html(lst);
//						$('.button').button();
						$('select.cant-product').chosen({ menuWidth: 60, width: 60,disableSearch:true });
						$('.chzn-results').css('width','inherit');
						$('.active-result').css('float','none').css('height','inherit').css('border-bottom','none');
						sumaryShopingCar(data);
					}else{
						$('#list_orderProduct_wish ul').empty().html(data['wish']['body']);
//						$('.button').button();
					}
				}
			}else{
				var num=data['numR'];
				if(num!=0){
					$('#ulToCar').attr('h',num); //$(this).parents('li').attr('class').split(' ')
					var div='';
					if (obj.mod!='wish'){div='#list_orderProduct '; }else{ div='#list_orderProduct_wish ';}
					var c=$(obj.obje).parents('li').attr('class').split(' '),fr=$(div+'li.'+c[1]+' .info-top-p select').attr('fr'),can2,can;
					$(div+'li.'+c[1]).slideUp().removeClass('noST').empty().html('');
					if ($(div+'div.messageAdver').length>0 && $(div+'li.noST').length==0){
						if ($(div+'.updateItems').length>0){ $(div+'div.noST').slideUp().empty().html('').removeClass('noST'); }
						else{ $(div+'div.messageAdver').slideUp().empty().html(''); }
					}
					can2=$(div+'.messageAdver .updateItems span[h]').length;
					can=$(div+'.messageAdver .updateItems span[h="'+data['delete']+'"]').length;
					if (can==1 && can2==1){
						if ($(div+'div.noST').length>0){ $(div+'div.messageAdver div.updateItems').slideUp().empty().html(''); }
						else{ $(div+'div.messageAdver').slideUp().empty().html(''); }
					}else if (can==1){ $(div+'div.messageAdver .updateItems strong span.numI').html(can2-can); }
					$(div+'.messageAdver .updateItems span[h="'+data['delete']+'"]').slideUp().empty().html('').removeAttr('h');
					$(div+'.messageAdver .noST span[h="'+data['delete']+'"]').slideUp().empty().html('').removeAttr('h');
					if (obj.mod!='wish'){
						$('#menu-lshoppingCart').html(data['numR']);
						var lst='';
						for(var i=0;i<data['datosCar'].length;i++){
							lst+=bodyShopingCar(data['datosCar'][i],i);
						}
						$('#list_orderProduct ul').empty().html(lst);
//						$('.button').button();
						$('select.cant-product').chosen({ menuWidth: 60, width: 60,disableSearch:true });
						$('.chzn-results').css('width','inherit');
						$('.active-result').css('float','none').css('height','inherit').css('border-bottom','none');
						sumaryShopingCar(data);
					}else{
						$('#list_orderProduct_wish ul').html(data['wish']['body']);
//						$('.button').button();
					}
				}else{ location.reload(); }
			}
		}
	});
}
function deleteOrderC(get,obj){
	$.dialog({
		title:'Eliminar Pedido',
		width:270,
		height:200,
		resizable:false,
		open:function(){
			$(this).html('&#x00bf;Est&aacute;s seguro de eliminar esta orden?');
		},
		buttons:[{
			text:'No',
			click:function(){$(this).dialog('close');}
		},{
			text:'Si',
			click:function(){
				deleteItemCar('1',get,obj);
				$('#default-dialog').dialog('close');
			}
		}]
	});
}
function bodyShopingCar(data,i){
	var tempEle= $('<span>'+data['sale_points']+'</span>');
	var costFormated = $(tempEle).formatCurrency({symbol:''});
	var cost=costFormated.html();
	if(data['formPayment']=='0'){
		var auxi=cost.split('.');
		cost=auxi[0];
	}
	tempEle=costFormated=null;
	var option='';
	if(data['place']=='1'&&parseInt(data['stock'])>0){ //TAGS_WHENTAGNOEXIST
		for(var j=1;j<=(parseInt(data['stock']));j++){
			option+='<option value="'+j+'" '+(data['cant']==j?'selected':'')+'>'+j+'</option>';
		}
	}
	var lst='<li class="carStore liVoid'+i+' '+((data['stock']==0)?'noST':'')+'">'
			+'	<div class="lis_product_store" style="background-image:url(\''+data['photo']+'\')";></div>'
			+'</li>'
			+'<li class="carStoreDetails liVoid'+i+' '+((data['stock']==0)?'noST':'')+'">'
			+'	<div class="lis_product_store_details">'
			+'		<span class="nameSP" action="detailProd,'+data['mId']+'">'+data['name']+'</span><br>'
			+'		<div title="Vendedor" '+((data['place']=='1')?'':'action="profile,'+data['idUser']+','+data['nameUser']+'"')+'>'
			+'			<div class="thumb" style="background-image: url(\''+data['imagenUser']+'\')"></div>'
			+'			<h5>'+data['nameUser']+'</h5>'
			+'			<div class="anytext">Admiradores ('+data['admirers']+')</div>'
			+'			<div class="anytext">Admirados ('+data['admired']+')</div>'
			+'		</div>'
			+'		<div class="clearfix"></div>'
			+'		<span class="footer">'+data['nameC']+((data['nameSC'])?((data['place'])?' | '+data['nameSC']+'</span>':'</span>'):'</span>')
			+'		<br><span class="deleteItemCar" action="deleteItemCar,'+data['mId']+',car,'+(data['sale_points']*data['cant'])+'">Borrar</span>'
			+'		<span class="addToWish" h="'+data['mId']+'">Mover a la lista de deseos</span>'
			+'	</div>'
			+'</li>'
			+'<li class="carStorePrice liVoid'+i+' '+((data['stock']==0)?'noST':'')+'">'
			+'	<div class="info-top-p">'+((data['formPayment']=='1')?'$ '+cost:cost+' Puntos')+'</div>'
			+'</li>'
			+'<li class="carStoreQuantity liVoid'+i+' '+((data['stock']==0)?'noST':'')+'">'
			+'	'+((data['place']=='1')?
					((data['stock']>0)?
						'<div class="info-top-p">'
							+'<select class="cant-product" cantAct="'+(data['sale_points']*data['cant'])+'" precio="'+data['sale_points']+'" linia="'+data['mId']+'" '+((data['formPayment']=='1')?'fr="1"':'fr="0"')+'>'
								+option
							+'</select>'
						+'</div>'
						:'<em class="info-top-p">Este contenido ya no esta disponible</em><input type="hidden" class="cant-product" linia="'+data['mId']+'" value="'+data['cant']+'">')
					:'')
			//+'	'+((data['place']=='1')?'<div class="info-top-p"><span class="cant-product" cantAct="1" precio="'+data['sale_points']+'" linia="'+data['mId']+'" '+((data['formPayment']=='1')?'fr="1"':'fr="0"')+' >1</span></div>':'')
			+'</li>';
	return lst;
}
function sumaryShopingCar(data){
	if (data['totalpoints']!=0 || data['totalmoney']!=0){
		if (data['totalpoints']!=0){
			$('#headerStoreCar .totalPointsSC #totalPrice').html(data['totalpoints']).formatCurrency({symbol:''});
			var auxi=$('#headerStoreCar .totalPointsSC #totalPrice').html().split('.');
			$('#headerStoreCar .totalPointsSC #totalPrice').html(auxi[0]);
			$('#headerStoreCar .totalPointsSC #moveTotal').val(data['totalpoints']);
		}else{
			$('#headerStoreCar .totalPointsSC #moveTotal').val(0);
			$('#headerStoreCar .totalPointsSC #spanTotalPrice').html('');
			$('#headerStoreCar .totalPointsSC #totalPrice').html('');
		}
		if (data['totalmoney']!=0){
			$('#headerStoreCar .totalPointsSC #totalPriceMoney').html(data['totalmoney']).formatCurrency({symbol:''});
			$('#headerStoreCar .totalPointsSC #moveTotalMoney').val(data['totalmoney']);
		}else{
			$('#headerStoreCar .totalPointsSC #moveTotalMoney').val(0);
			$('#headerStoreCar .totalPointsSC #totalPriceMoney').html('');
			$('#headerStoreCar .totalPointsSC #spanTotalPriceMoney').html('');
		}
	}else{
		$('#headerStoreCar .totalPointsSC #moveTotalMoney').val(0);
		$('#headerStoreCar .totalPointsSC #totalPriceMoney').html('');
		$('#headerStoreCar .totalPointsSC #spanTotalPriceMoney').html('');
		$('#headerStoreCar .totalPointsSC #moveTotal').val(0);
		$('#headerStoreCar .totalPointsSC #spanTotalPrice').html('');
		$('#headerStoreCar .totalPointsSC #totalPrice').html('No hay productos disponibles');
//		$('#buyOrder').button('disable');
	}
	$('#headerStoreCar').css('display','block');
}

function processOrderSC(paso,array){
	if (paso==1){
		var data;
		if (array.length>0){
			data={ data:array }
			$.ajax({
				type:'POST',
				url:'controls/store/shoppingCart.json.php?action=7',
				data:data,
				dataType:'json',
				success:function(data){
					if(data['datosCar']=='update'){
						redir('shippingaddress');
					}else{
						$.dialog({
							title	: 'Informaci&#x00f3;n',
							content	: 'Algunos productos ya no est&#x00e1;n disponibles, su pedido fue modificado.',
							close	:function(){ location.reload(); }
						});
						//message('information','','','',300,200,'','');
					}
				}
			});
		}else{ processOrderSC(2); }
	}else if(paso==2){
		$.ajax({
			type:'POST',
			url:'controls/store/shoppingCart.json.php?action=4',
			data:data,
			dataType:'json',
			success:function(data){
					if (data['datosCar']=='checked'){
						$.dialog({
							title:'Orden Enviada',
							resizable:false,
							width:270,
							height:190,
							open:function(){
								$(this).html('Verifique su bandeja de entrada para obtener mas informaci&#x00f3;n al respecto.');
							},
							close:function(){
								mskPointsReload('#mskPoints');
								redir('orders');
							},
							buttons:[{
								text:lang.JS_OK,
								click:function(){
									$(this).dialog('close');
								}
							}]
						});
					}else if (data['datosCar']=='noCredit'){
						message('Comprar','Mensaje Importante','Usted no posee suficientes puntos para enviar esta orden','',300,200);
//						$('#buyOrder').button("enable");
					}else if(data['datosCar']=='noCart'){
						$.dialog({
							title	: 'Alert',
							content	: 'Disculpe. esta orden ya ha sido procesada o eliminada.'
						});
//						$('#buyOrder').button("enable");
						redir('store');
					}else if(data['datosCar']=='order-alter'){
						redir('shoppingcart?no-product=1');
					}
			}
		});
	}

}

function addNewRaffleStore(getidProduct,getidRaffle) {
	getidRaffle=getidRaffle?getidRaffle:'';
	var buttonss={
		'Cerrar':function(){
			$(this).dialog("close");
		}
	};
	if(getidRaffle==''){
		buttonss['Continuar']=function(){
				if (valida('frmProducts')) $('#frmProducts').submit();
			};
	}
	$.dialog({
		title:'Crear producto gratuito',
		resizable:false,
		width:500,
		height:420,
		modal:true,
		open:function(){
			$(this).load('views/store/newRaffle.php?idProd='+getidProduct+(getidRaffle!=''?'&idRaffle='+getidRaffle:''));
		},
		buttons:buttonss,
		close:function(){
  //		if ($('.elementShadow label').length>0) $('.elementShadow label').button('enable');
		}
	});
}
function detailsSalesProcessed(get){
	get=get?get:'';
	$.ajax({
		type: 'GET',
		url: 'controls/store/shoppingCart.json.php?action=9&orderId='+get,
		dataType: 'json',
		success: function(data){
			if (data['datosCar'].length>0){
				var lst = '<div id="list_orderProduct">'
								+'<ul>',i;
				for (i=0;i<data['datosCar'].length;i++){
					//Formate el costo de producto en dollares
					var tempEle = $('<span>'+data['datosCar'][i]['product_price']+'</span>');
					var costFormated = $(tempEle).formatCurrency({symbol:''});
					var cost = costFormated.html();
					if (data['datosCar'][i]['product_formPayment']=='0'){
						var auxi=cost.split('.');
						cost = auxi[0];
					}
					tempEle = costFormated = null;

					lst +=	'<li class="carStore border-botton-store '+(i==0?'':'border-t-store')+'">'
							+'	<div class="lis_product_store" style="background-image:url(\''+data['datosCar'][i]['product_photo']+'\')";></div>'
							+'</li>'
							+'<li class="carStoreDetails border-botton-store '+(i==0?'':'border-t-store')+'">'
							+'	<div class="lis_product_store_details">'
							+'		<div class="clearfix"></div>'
							+'			<strong>Detalles del producto</strong><br/>'
							+'			<span class="footer"><span  class="nameSP">Nombre: </span><strong><span action="detailProd,'+data['datosCar'][i]['product_id']+',dialog-order">'+data['datosCar'][i]['product_name']+'</span></strong><br>'
							+'			<span class="footer"><span class="nameSP">Categor&iacute;a</span>: '+data['datosCar'][i]['product_category']+((data['datosCar'][i]['product_subCategory'])?((data['datosCar'][i]['product_place'])?'<br><span class="nameSP">SubCategor&iacute;a</span>: '+data['datosCar'][i]['product_subCategory']+'</span>':'</span>'):'</span>')+'<br>'
							+'			<strong>Detalles de la publicaci&oacute;n</strong><br/>'
							+'			<span class="footer"><span class="nameSP">Desde: </span>'+data['datosCar'][i]['inicio']+'</span><br>'
							+'			<span class="footer"><span class="nameSP">Hasta: </span>'+data['datosCar'][i]['fin']+'</span>'
							+'	</div>'
							+'</li>'
							+'<li class="carStorePrice border-botton-store '+(i==0?'':'border-t-store')+'">'
							+'	<div class="info-top-p"><strong>Precio</strong>:<br>'
							+	((data['datosCar'][i]['product_formPayment']=='1')?'$ '+cost:cost+' Puntos')+'</div>'
							+'	'+((data['datosCar'][i]['pago']=='12')?'<br><br><input type="button" action="revendProduct,'+data['datosCar'][i]['product_id']+'" value="Republicar">':'')
							+'</li>'
							+'<li class="carStoreQuantity border-botton-store '+(i==0?'':'border-t-store')+'">'
							+'	<div class="info-top-p"><strong>Cantidad:</strong></br>'+data['datosCar'][i]['product_cant']+'</div>'
							+'</li>';
				}
				lst+='</ul></div>';
			}else{
				lst='<div class="product-list"><div class="noStoreProductsList messageAdver"><span>No hay &oacute;rdenes disponibles, si deseas realizar una compra visite nuestra lista de productos en el store.</span></div></div>';
			}
			$.dialog({
				title:'Detalles de mis ventas',
				resizable:false,
				width:700,
				height:520,
				modal:true,
				open:function() {
					$(this).html(lst);
//					$('.button').button();
				},
				buttons:[{
					text: lang.JS_CLOSE,
					click: function() {$( this ).dialog( "close" );}
				}]
			});
		}
	});
}
function getCategorysStore(get,cate){
	get=get?get:'';cate=cate?cate:'';
	$$.ajax({
		type: 'GET',
		url: 'controls/store/listProd.json.php'+get+'categoryJSON=1',
		dataType: 'json',
		success: function(data){
			var prod=data['category'];
			if (prod){
				var html='',category='-1';
				if (prod[0]['id_category']=='1'){
					html='<li>'
						+'	<span><a id="C1" c="'+prod[0]['mId_category']+'" sc="'+prod[0]['sub_category_mId']+'">'
						+prod[0]['category_name']+'  <span>('+prod[0]['cantProduc']+')</span>'
						+'	</a></span>'
						+'</li>'
				}
				for(var i=0;i<prod.length;i++){
					if (prod[i]['id_category']!='1'){
						if(category!=prod[i]['id_category']){
							category=prod[i]['id_category'];
							html+=((category!='-1')?'</ul></li>':'')+'<li '+(prod[i]['photo']?'style="background-image: url(css/tbum/storeCategory/'+prod[i]['photo']+');"':'')+'><span>'+prod[i]['category_name']+'</span><ul '+((cate && cate==prod[i]['id_category'])?'h="1"':'')+' >';
						}
						html+='<li><a class="linkCategory" c="'+prod[i]['mId_category']+'" sc="'+prod[i]['sub_category_mId']+'">'+prod[i]['sub_category_name']+' <span>('+prod[i]['cantProduc']+')</span></a></li>';
					}
				}
				html+=((category!='-1')?'</ul></li>':'');
				$('ul#menuStore').append(html);
				if (cate){ $('#menuStore li ul[h="1"]').slideToggle(300); }
			}
		}
	});
}
function getCitys(layer,id){
	var da={'data':id};
	$.ajax({
		type: 'POST',
		url: 'controls/store/shoppingCart.json.php?action=11',
		data:da,
		dataType: 'json',
		success: function(data){
			$(layer).trigger("addItem",[{"title": data['datosCar']['city'], "value": data['datosCar']['idCities']}]);
		}
	});
}
function chooseProducts(tag){
	var get='?scc=2&allProducts=1&';
	$.dialog({
		title: 'Seleccione Un Producto',
		resizable: false,
		width: 700,
		height: 520,
		modal: true,
		open:function(){
			if(tag){
				$(this).html('<div id="selectProductsTags">'
								+'<div class="product-list"></div>'
								+'<div id="loaderStoreDialog" style="display:none;width: 555px;float: left;"><span class="store-span-loader">Cargando Lista de productos</span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>'
							+'</div>');
				storeListProd('#selectProductsTags .product-list',get);
			}else{
				$(this).html('<div id="selectProducts">'
								+'<div class="product-list"></div>'
								+'<div id="loaderStoreDialog" style="display:none;width: 555px;float: left;"><span class="store-span-loader">Cargando Lista de productos</span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>'
							+'</div>');
				storeListProd('#selectProducts .product-list',get);
			}
		},
		buttons:[{
			text:lang.JS_CLOSE,
			click:function(){$(this).dialog("close");}
		}]
	});
}

function buyPoints(){
	$.dialog({
		title:'Comprar Puntos',
		resizable:false,
		width:500,
		height:350,
		modal:true,
		open:function(){
			$(this).load('view.php?page=users/buyPoints.php');
		},
		buttons:[{
			text: lang.JS_CANCEL,
			click: function() {
				$( this ).dialog( "close" );
			}
		},{
			text:lang.JS_CONFIRM,
			click:function(){
				$.ajax({
					type:"POST",
					url:"controls/users/buyPoints.json.php?amount="+$('#amount').val(),
					dataType:"html",
					success:function(data){
						redir(data);
						$(this).dialog("close");
					}
				});
			} // boton Confirm
		}]
	});
}

function bodyhash(hash,id){
	var res='', sp='';
	if(hash.length>40){
		res = hash.substr(0,40);
		sp  = '...';
	}else{
		res = hash;
		sp  = '';
	}
	return('<div class="searchHash"><a href="'+BASEURL+'tagslist?current=hash&hash='+encodeURIComponent(hash)+'">'+res+sp+'</a></div>');
}

function bodyfriends(friends,Link,unLink){
	//console.log(friends);
	var username='',country='';
	if(friends['username']){
		username='<span class="titleField">Perfil externo:</span>&nbsp;<a style="color:#ccc; font-size:12px;" href="'+BASEURL+'eprofile?usr='+friends['username']+'" onFocus="this.blur();" target="_blank">'+BASEURL+friends['username']+'</a>'
				+ '<div class="clearfix"></div>';
	}
	if(friends['country']!=''){
		country='<span class="titleField">Pa&#x00ed;s:&nbsp;</span>'+friends['country']
				+ '<div class="clearfix"></div>';
	}

	return('<div class="divYourFriends thisPeople">'
		+	'<div style="float:left; width:65px; cursor:pointer;">'
		+		'<img action="profile,'+md5(friends['id_friend'])+','+friends['name_user']+'" src="'+friends['img']+'" border="0"  width="50" height="50" style="border: 1px solid #ccc" />'
		+	'</div>'
		+	'<div style="float:left; width:480px;">'
		+		'<div style="width:450px; float: left;">'
		+			'<a href="javascript:void(0);" action="profile,'+md5(friends['id_friend'])+','+friends['name_user']+'" style="font-size:14px;">'
		+				'<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">'
		+				friends['name_user']
		+			'</a><br>'
		+			username
		+			'<span class="titleField">Su Correo: </span>'+friends['email']
		+			'<div class="clearfix"></div>'
		+			'<span class="titleField">Admiradores ('+friends['followers_count']+')</span>'
		+			'<span class="titleField">Admirados ('+friends['friends_count']+')</span><div class="clearfix"></div>'
		+			country
		+		'</div>'
		+		'<div style="height:70px; width:0px; float: right; text-align: right;">'
		+			'<input style="margin-top: 20px;font-size:10px;'+Link+'" type="button" value="Link" action="linkUser,'+md5(friends['id_friend'])+',2" />'
		+			'<input style="margin-top: 20px;font-size:10px;'+unLink+'" type="button" value="Unlink" action="linkUser,'+md5(friends['id_friend'])+',2" />'
		+		'</div>'
		+	'</div>'
		+	'<div class="clearfix"></div>'
		+ '</div>');
}

function bodygroups(groups){
	var btn='',atc='';
	if(groups['privacy']==3){
		if(groups['myPrivateGroup']==1){
		btn=	'<div>'
				+		'<input action="groupSuggest,'+groups['id']+'" type="button" value="Sugerir grupo" name="suggestGroup'+groups['id']+'" id="suggestGroup'+groups['id']+'">'
				+		'<a href="'+BASEURL+'groupsDetails?grp='+groups['id']+'" class="viewGroup button">Ver Grupo</a>'
				+	'</div>'
				+ '<div class="clearfix"></div>';
		atc=	'action="groupsDetails,'+groups['id']+'"';
		}
	}else{
		if(groups['userInGroup']==0){
			if(groups['buttonGroup']==0){
				btn   = '<input type="button" value="Unirse" name="joinGroup'+groups['id']+'" id="joinGroup'+groups['id']+'" action="groupsAction,'+groups['id']+'">'
				+	'<div id="autoriGr'+groups['id']+'" class="messageSuccessGroupo" style="display: none">Esperar aprobaci&#x00f3;n</div>'
				atc	=	'action="groupsAction,'+groups['id']+'"';
			}else if(groups['buttonGroup']==1){
				btn   =		'<div id="btnJoinViewroup'+groups['id']+'">'
					+		'<input action="groupSuggest,'+groups['id']+'" type="button" class="viewGroup suggestGroup'+groups['id']+'" value="Sugerir grupo">'
					+		'<input action="groupsDetails,'+groups['id']+'" type="button" class="viewGroup" value="Ver Grupo"></div>';
				atc	='action="groupsDetails,'+groups['id']+'"';
			}else if(groups['buttonGroup']==2){
				btn   =		'<div id="btnJoinViewroup'+groups['id']+'">'
					+		'<input type="button" size="20" id="acep'+groups['id']+'"'
					+	'	value="Aceptar"'
					+	'	action="acceptInv,'+groups['id']+',list">'
					+	' <input type="button" size="20" id="acepNo'+groups['id']+'"'
					+	'	value="Rechazar"'
					+	'	action="acceptInv,'+groups['id']+',list,none">'
					+	'<span class="msg" id="msg'+groups['id']+'">Tienes una invitaci&oacute;n a este grupo</span>'
					+	'<input type="button" value="Unirse" name="joinGroup'+groups['id']+'" id="joinGroup'+groups['id']+'" action="groupsAction,'+groups['id']+'" style="display: none">'
					+	'<div id="autoriGr'+groups['id']+'" class="messageSuccessGroupo" style="display: none">Esperar aprobaci&#x00f3;n</div>'
					+	'</div>';
				atc	='action="acceptInv,'+groups['id']+',list"';
			}
			btn   +=  '<div class="clearfix"></div>';
		}else{
			btn = '<div class="messageSuccessGroupo">Esperar aprobaci&#x00f3;n</div>'
			+ '<div class="clearfix"></div>';
		}
	}
	return('<div class="group_info">'
		+	'<div class="bckOvergroup" '+atc+' h="'+groups['id']+'"title="'+groups['etiquetaPrivacidad']+'">'
		+	'<div class="bkgGroup" '+groups['photo']+'></div>'
		+		'<div class="DescripGroupType">'
		+			'<div class="TitleTypeGruop">'
		+				'<div class="limitTitle">'
		+					'<img src="'+groups['cphoto']+'" alt="Group Icons" title="'+groups['ctitle']+'" width="30" height="30"/> '+groups['name']
		+				'</div>'
		+				'<div class="'+groups['privacidad']+'"></div>'
		+			'</div>'
		+			'<div class="complementGruop">'+(groups['des']||'')+'</div>'
		+		'</div>'
		+		'<div class="GroupMembers">'
		+				'<div class="iconMember"><span>'+groups['members']+'</span></div>'
		+				'<div class="cantMember">Miembros</div>'
		+		'</div>'
		+	'</div>'
		+	btn
		+  '</div>');
}

function hashJson(id,loading,num,search,seemoreButton){
	console.log('hash');
	$$.ajax({
		type:"POST",
		url:"controls/search/hashTabs.json.php?search="+escape(search),
		dataType:"json",
		success:function(data){
			console.log(data);
			var out='';
			$(loading).fadeOut('fast',
			function(){
				console.log('Cantidad de hash'+data['cant']);
				if(data['cant']>0){
					out+='<div style="padding: 10px 0; width: 100%;">';
					for(var i=0;i<data['cant'];i++){
						console.log(data['hash'][i]);
						console.log('esto:'+search);
						(data['hash'][i])?out+=bodyhash(data['hash'][i],search):'';
					}
					out+='<div class="clearfix"></div></div>';
					$(id).html(out);
					if(data['cant']>=5)
						$(seemoreButton).fadeIn('fast');
				}
			});
		}
	});
}
function friendsJson(id,loading,num,search,seemoreButton){
	console.log('friends');
	$.ajax({
		type:"POST",
		url:"controls/search/friendTabs.json.php?search="+escape(search),
		dataType:"json",
		success:function(data){
			console.log(data);
			var out='',datos='',followerLink='',followerUnlink='';
			datos=data['friends'];
			$(loading).fadeOut('fast',function(){
				if(data['cant']!=0){
					for(i=0;i<data['friends'].length;i++){
						followerLink=(datos[i]['follower'])?'display:none':'';
						followerUnlink=(datos[i]['follower'])?'':'display:none';
						out+=bodyfriends(datos[i],followerLink,followerUnlink);
					}
					$(id).html(out);
//					$("button, input:submit, input:reset, input:button, .group_info a").button();
					if(data['cant']>=5) $(seemoreButton).fadeIn('fast');
				}
			});
		}
	});
}

function groupsJson(id,loading,num,search,seemoreButton){
	console.log('groups');
	$$.ajax({
		type:"POST",
		url:"controls/search/groupTabs.json.php?search="+escape(search),
		dataType:"json",
		success	:function(data){
			console.log('esto es grupos');
			console.log(data);
			var out='',datos='';
			datos=data['group'];
			$(loading).fadeOut('fast',function(){
				if(data['cant']!=0){
					for(i=0;i<data['group'].length;i++){
						out += bodygroups(datos[i]);
					}
					$(id).html(out);
//					$("button, input:submit, input:reset, input:button, .group_info a").button();
					if(data['cant']>=5)
						$(seemoreButton).fadeIn('fast');
				}
			});
		}
	});
}

function mascara(d,sep,pat,nums){
	console.log(d)
	if(d.valant!=d.value){
		var q,r,s,z,letra,val=d.value,val2='',val3=[];
		val=val.split(sep);
		for(r=0;r<val.length;r++){
			val2+=val[r];
		}
		if(nums){
			for(z=0;z<val2.length;z++){
				if(isNaN(val2.charAt(z))){
					letra=new RegExp(val2.charAt(z),"g");
					val2=val2.replace(letra,"");
				}
			}
		}
		val='';
		for(s=0;s<pat.length;s++){
			val3[s]=val2.substring(0,pat[s]);
			val2=val2.substr(pat[s]);
		}
		for(q=0;q<val3.length;q++){
			if(q==0){
				val=val3[q];
			}else if(val3[q]!=""){
				val+=sep+val3[q];
			}
		}
		d.value=val;
		d.valant=val;
	}
}