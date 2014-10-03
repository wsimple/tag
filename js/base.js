//-- extendemos funciones de Array --//
(function(){
	if(!('forEach' in [])){
		Array.prototype.forEach=function(callback,a){
			for(var i=0,len=this.length;i<len;i++){
				callback.call(a||this, this[i], i, this);
			}
			return this;
		};
	}
	if(!('indexOf' in [])){
		Array.prototype.indexOf=function(el){
			for(var i=0,len=this.length;i<len;i++){
				if(this[i]==el) return i;
			}
			return -1;
		};
	}
})();
//-- extendemos funciones de String --//
(function(){
	//-- comparacion de versiones (numeros con puntos, ej: 1 < 1.5.1 < 1.10) --//
	if(!('compareVersion' in String)){
		String.prototype.compareVersion=function(el){
			var a,b,e1=this.split('.'),e2=el.split('.');
			for(var i=0,len=e1.length;i<len;i++){
				a=e1[i]*1;b=e2[i]*1;
				if(a>b) return 1;
				if(a<b) return -1;
			}
			if(e1.length>e2.length) return 1;
			if(e1.length<e2.length) return -1;
			return 0;
		};
		String.prototype.versionLt=function(el){
			return this.compareVersion(el)<0;
		};
		String.prototype.versionGt=function(el){
			return this.compareVersion(el)>0;
		};
	}
})();
//-- opciones en llamados ajax --//
(function($){
	$(document).ajaxSend(function(event,xhr,data){
		if(data.disablebuttons){//deshabilitar botones
			$.debug('disablebuttons').log('disabled ajax buttons. data:',data);
			data.disabled=$('[ajax]:not([disabled])');
			data.disabled.prop('disabled',true);
		}
	}).ajaxComplete(function(event,xhr,data){
		if(data.disabled){//habilitar botones
			$.debug('disablebuttons').log('enabled ajax buttons');
			data.disabled.prop('disabled',false);
		}
		$.debug('ajax').log('ajax sent:',data);
	});
})(jQuery);

//-- variables generales de pagina --//
var PAGE,wrapper,container,home,footer,INFO=[];

(function(window,$){
	//-- smt: objeto para uso global de Tagbum (en desarrollo) --//
	$.smt={};
	//-- $$ : selector alternativo --//
	window.$$=function(a,b){ if(b) return $(a,b); else return $(a); };
	//-- si no se puede usar tipsy, se crea una funcion vacia (para evitar errores) --//
	if(!$.fn.tipsy) $.fn.tipsy=function(){};
	$.cookie.defaults={expires:30,path:'/'};//configuracion por defecto para cookies
	//identificar navegador y sistema operativo
	var agent=window.navigator.userAgent,
		platform=window.navigator.platform;
	//browser (navegador)
	if(agent.match(/chrome/i))
		INFO[0]='chrome';
	else if(agent.match(/safari|applewebkit/i))
		INFO[0]='safari';
	else if(agent.match(/firefox|gecko/i))
		INFO[0]='firefox';
	else if(agent.match(/msie/i))
		INFO[0]='ie';
	else if(agent.match(/opera|presto/i))
		INFO[0]='opera';
	//OS (sistema operativo)
	if(platform.match(/ios|iphone|ipad|ipod/i))
		INFO[1]='ios';
	else if(platform.match(/android/i))
		INFO[1]='android';
	else if(platform.match(/win/i))
		INFO[1]='windows';
	else if(platform.match(/mac/i))
		INFO[1]='mac';
	else if(platform.match(/linux/i))
		INFO[1]='linux';
	//motor
	if(agent.match(/webkit/i))//chrome & safari
		INFO[2]='webkit';
	else if(agent.match(/gecko/i))//netscape, firefox
		INFO[2]='gecko';
	else if(agent.match(/presto/i))
		INFO[2]='presto';
	if($.cookie('__FV__')) INFO[3]='mobile';
	var $loader;
	$.loader=function(mode){
		if(mode=='show') $loader&&$loader.show();
		if(mode=='hide') $loader&&$loader.hide();
	};
	window.beforeInit=function(){
		PAGE=$('page')[0];
		wrapper=$(PAGE).children('wrapper')[0];
		footer=$('footer',PAGE)[0];
		container=$('container',wrapper)[0];
		//seran removidos
		home=$('container#home',PAGE)[0];
		$loader=$('loader.page',PAGE);
		delete window.beforeInit;
	}
	window.pageInit=function(){
		$('body').addClass(INFO.join(' '));
		var _logged=ISLOGGED;
		loginState(function(logged){
			if(logged!==_logged) window.location.reload();
		});
		$(document).on('click','[accion],[action]:not(form)',function(){
			var action=$(this).attr('action'),s=action.indexOf(','),data='';
			if(s>=0){
				data=action.substr(s+1);
				action=action.substr(0,s);
			}
			pageAction.call(this,action,data);
		});
		windowChange();
		$(window).resize(windowChange);
		//ajax loader = mostrar y ocultar loader cuando se ejecuta un llamado ajax.
		//$('header loader.page',PAGE).ajaxStart(function(){ $(this).show(); }).ajaxStop(function(){ $(this).hide(); });
		delete window.pageInit;
	};
	$.local.ce=/firebug/i;//excepciones al borrar todos los locales
	$.cookie.ce=/^(kl|last|enableLogs|PHPSESSID)$/;//excepciones al borrar todas las cookies
})( window, jQuery );

//-- funciones de scroll --//
//(function(window,$) {
//	$(window).on('scroll','.semi-fixed-wrapper',function(){
//		$(,container).each(function(){
//			var $this=$(this);
//		});
//	});
//	$.fn.semiFixed=function(offset){
//		var $this=$(this);
//		if(!$this.hasClass('semi-fixed')) $this.addClass('semi-fixed').wrap('<div class="semi-fixed-wrapper"></div>');
//	};
//})( window, jQuery );

//-- funciones de cookies --//
function delAllCookies(){
	var i,cookies=document.cookie.split(';'),len=cookies.length;
	for (i=0;i<len;i++){
		var cookie=cookies[i],
			eqPos=cookie.indexOf('='),
			name=eqPos>-1?cookie.substr(0,eqPos):cookie;
		name=name.replace(/%20|\s/g,'');
		if( name!='kl' && name!='last' && name!='enableLogs' && name!='PHPSESSID' ) $.cookie(name,null);
	}
}
function setAllCookies(opc){
	delAllCookies();
	if(!opc||opc==null) opc={};
	for(var i in opc) $.cookie(i,opc[i]);
	$.cookie('last',opc['last']||$.cookie('last'),{expires:90});
}
function delAllLocals() {
	var key,local=$.local(),session=$.session();
	if(local) for(key in local){
		if( key!='enableLogs' ) $.local(key,null);
		else $.cookie(key,null);
	}
}
function setAllLocals(opc){
	delAllLocals();
	var i,local=$.local();
	if(!opc||opc===null) opc={};
	if(opc['locals']){
		if(local){
			for(i in opc['locals']) $.local(i,opc['locals'][i]);
		}else{
			for(i in opc['locals']) $.cookie(i,opc['locals'][i]);
		}
	}
}

(function(window,$){
	if(!$.on)
	$.on=function(opc){
		$(function(){ opc.open.call(opc); });
	};
})(window,jQuery);

//-- funciones de consola y ajax personalizados --//
(function(w,$){
	//-- Ajax con registros de Log --//
	$.ajax.log=function(a,b){
		if(b!==undefined){
			b.url=a;
			a=b;
		}
		if($.local('enableLogs')&&!$.local('disable_')){
			var log={url:a.url};
			b={s:a.success,e:a.error,c:a.complete};
			if(a.data) log.data=$.extend({},a.data);
			a.success=function(data){
				log.success=data;
				if(typeof b.s=='function') b.s(data);
			};
			a.error=function(jqXHR,textStatus,errorThrown){
				log.error={jqXHR:jqXHR,textStatus:textStatus,errorThrown:errorThrown,errorMsg:jqXHR.responseText};
				if(typeof b.e=='function') b.e(jqXHR,textStatus,errorThrown);
			};
			a.complete=function(jqXHR,textStatus){
				console.log(log);
				if(typeof b.c=='function') b.c(jqXHR,textStatus);
			};
		}
		$.ajax(a);
	};
	//-- Ajax con loader --//
	var numCalls=0;
	$$.ajax=function(a,b){
		var loader=a.loader!==false;
		if(a.loader) delete a.loader;
		if(b!=undefined){
			b.url=a;
			a=b;
		}
		if(loader){
			b=a.complete;
			a.complete=function(jqXHR,textStatus){
				if(--numCalls<1) $.loader('hide');
				if(typeof b=='function') b(jqXHR,textStatus);
			};
		}
		if(loader&&numCalls++<1) $.loader('show');
		if(!$.local('enable_console'))
			return $.ajax(a);
		else
			return $.ajax.log(a);
	};
	//-- AjaxForm con registros de Log --//
	$.fn.ajaxFormLog=function(a,b){
		if(b!==undefined){
			b.url=a;
			a=b;
		}
		if(a.debug!==undefined&&$.local('enableLogs')){
			var log={};
			if(a.url) log.url=a.url;
			b={s:a.success,e:a.error,c:a.complete};
			if(a.data) log.data=$.extend({},a.data);
			a.success=function(data){
				log.success=data;
				if(typeof b.s=='function') b.s(data);
			};
			a.error=function(jqXHR, textStatus, errorThrown){
				log.error={jqXHR:jqXHR,textStatus:textStatus,errorThrown:errorThrown,errorMsg:jqXHR.responseText};
				if(typeof b.e=='function') b.e(jqXHR,textStatus,errorThrown);
			};
			a.complete=function(jqXHR, textStatus){
				$.debug(a.debug).log(log);
				if(typeof b.c=='function') b.c(jqXHR,textStatus);
			};
		}
		$(this).ajaxForm(a);
	};
	//-- load con registros de Log --//
	$.fn.loadLog=function(a,b,c){
		if(a.debug!==undefined&&$.local('enableLogs')){
			var log={url:a},complete=function(f){
				return function(responseText,textStatus,XMLHttpRequest){
					log.loaded=$(this).html();
					$.debug(a.debug).log(log);
					if(typeof f=='function') f(responseText,textStatus,XMLHttpRequest);
				};
			};
			if(c){
				c=complete(c);
				log.data=b;
			}else if(b){
				if(typeof b=='function')
					b=complete(b);
				else
					log.data=b;
			}
		}
		$(this).load(a,b,c);
	};
})(window,jQuery);

//-- permite cargar un objeto existente, y si no existe lo crea --//
(function(window,$){
	$.tmp=function(type,id){
		var obj=document.createElement(type||'div');
		if(id&&(typeof id=='string')&&id.charAt(0)=='#') id=id.substr(1);
		if(id) obj.id=id;
		return $(obj);
	};
	$.obj = function(type,id){
		if( id && (typeof id == 'string') && id.charAt(0)=='#' ) id=id.substr(1);
		var $obj,obj=id&&(type+'#'+id);
		if(!id||$(obj).length>0)
			$obj=$(obj).last();
		else{
			obj=document.createElement(type);
			obj.id=id;
			$('body').append(obj);
			$obj=$(obj);
		}
		return $obj;
	};
	$.div=function(id){
		return $.obj('div',id);
	};
})(window,jQuery);

//-- dialogo con loader --//
(function(window,document,$){
	$.dialog=function(opc){
		if(!opc.buttons) opc.buttons=[{
			text:lan('JS_OK'),
			click:function(){
				$(this).dialog('close');
			}
		}];
		var id=opc.id||'#new-dialog',
			remove=opc.remove||!opc.id,$overlay,
			$dialog=$.div(id).data('opc',opc);
		if($dialog.data('opc').clear!==false)
			$dialog.empty().html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /><br/><strong>'+lan('JS_LOADING')+'</strong></div>');
		return $dialog.dialog({
			resizable:false,
			width:opc.width||350,
			height:opc.height||250,
			modal:true,
			show:'fade',
			hide:'fade',
			title:opc.title,
			closeOnClickOutside:true,
			open:function(){
				$overlay=$('.ui-widget-overlay:visible');
				if($overlay.length>1){
					$overlay.filter(':not(:last)').fadeOut();
				}
				$overlay.last().mouseup(function(e){//close if you click outside of the dialog
					var $container=$dialog.parents('.ui-dialog');
					if($dialog.dialog('option','closeOnClickOutside')!==false //if not disabled click outside
						&&!$container.is(e.target) // the target of the click isn't the container...
						&& $container.has(e.target).length===0){ // ... nor a descendant of the container
						$dialog.dialog('close');
					}
				});
				if(!opc.id) this.id='default-dialog';
				if(opc.url)
					$(this).loadLog(opc.url);
				else if(opc.content)
					$(this).html(opc.content);
				if(opc.open) opc.open.call(this);
				if(opc.altUrl){
					var u=opc.altUrl||'';
					opc.altUrl=location.href;
					history.replaceState(null,'',u);
				}
			},
			beforeClose:function(){
				$overlay.filter(':not(:last)').last().fadeIn();
				if(opc.altUrl){
					var u=opc.altUrl;
					console.log(u);
					history.replaceState(null,'',u);
				}
			},
			close:function(){
				if(opc.focus){
					if((typeof opc.focus=='string')&&opc.focus.charAt(0)!='#') opc.focus='#'+opc.focus;
					$(opc.focus).focus();
				}
				if(opc.close) opc.close.call(this);
				else if(opc.hash) document.location.hash=opc.hash;
				if(remove) $(this).remove();
			},
			buttons:opc.buttons
		});
	}
})(window,document,jQuery);

//-- intervalos --//
(function(window,document,$){
	$.interval=function(func,time,cond){
		var value,c=container,f;
		if(cond===undefined){
			f=function(){
				if(c!=container) clearInterval(value);
				else func();
			};
		}else if(typeof cond==='function'){
			f=function(){
				if(cond()) clearInterval(value);
				else func();
			};
		}else{
			f=function(){
				if(cond) clearInterval(value);
				else func();
			};
		}
		value=setInterval(f,time||1000);
		return value;
	};
})(window,document,jQuery);

(function($){
	if($.ui.dialog.prototype.version==='1.9.2')
	$.ui.dialog.prototype._createButtons=function(buttons){
		var that=this,
			hasButtons=false;
		// if we already have a button pane, remove it
		this.uiDialogButtonPane.remove();
		this.uiButtonSet.empty();

		if(typeof buttons==='object'&&buttons!==null){
			$.each(buttons,function(){
				return !(hasButtons=true);
			});
		}
		if(hasButtons){
			$.each(buttons,function(name,props){
				var button,click;
				props=$.isFunction(props)?
					{ click:props,text:name }:
					props;
				// Default to a non-submitting button
				props=$.extend({type:'button'},props);
				// Change the context for the click callback to be the main element
				click=props.click;
				props.click=function(){
					click.apply(that.element[0],arguments);
				};
				button=$("<button></button>",props)
					.appendTo(that.uiButtonSet);
//				if($.fn.button) button.button();
			});
			this.uiDialog.addClass("ui-dialog-buttons");
			this.uiDialogButtonPane.appendTo(this.uiDialog);
		}else{
			this.uiDialog.removeClass("ui-dialog-buttons");
		}
	};
})(jQuery);
function textFormat(opc){
	var i,num=opc.num||1,info=opc.txt[opc.type],rep=opc.txt["replace"],find,el;
	if(num>1)
		info=info.replace(/{{([^}]*)}}/g,"$1").replace(/{([^}]*)}/g, "" );
	else
		info=info.replace(/{{([^}]*)}}/g, "" ).replace(/{([^}]*)}/g,"$1");
	find=info.match(/\[_\S+_\]/g);
	if(find) for(i=0;i<find.length;i++){
		el=find[i].replace(/\[_(\S+)_\]/,"$1").toLowerCase();
		if(opc[el]) info=info.replace(find[i], opc[el]);
	}
	for(i in rep) info=info.replace(i,rep[i]);
	return info;
}
