//-- extendemos String y Array --//
(function(){
	String.prototype.toUpperCaseFirst = function() {//mayuscula solo primera letra del parrafo
		return this.toLowerCase().replace(/\w\S*/, function(txt){
			return txt.charAt(0).toUpperCase() + txt.substr(1);
		});
	};
	String.prototype.toUpperCaseWords = function() {//mayuscula primera letra de cada palabra
		return this.toLowerCase().replace(/\w\S*/g, function(txt){
			return txt.charAt(0).toUpperCase() + txt.substr(1);
		});
	};
})();
(function(){
	if(!('forEach' in [])){
		Array.prototype.forEach=function(callback,a){
			for(var i=0;i<this.length;i++){
				callback.call(a||this, this[i], i, this);
			}
			return this;
		};
	}
	if(!('indexOf' in [])){
		Array.prototype.indexOf=function(el){
			for(var i=0;i<this.length;i++){
				if(this[i]==el) return i;
			}
			return -1;
		};
	}
})();
//-- get --//
var $_GET;
function arrayGet(get){
	var a=get||location.search.substring(1),b,c,d,e,f;
	a=a.split('&');
	$_GET={};
	for(b in a){
		c=a[b];
		if(c!=''){
			d=c.indexOf('=');
			e=c.substr(0,d<0?c.length:d);
			f=d<0?null:c.substr(d+1);
			$_GET[e]=f;
		}
	}
	return $_GET;
}
//-- push notifications --//
var defaultNotificationTypes={types:['usr','tag','group']};
(function(document,window,$,console){
	var running,val;
	var push=function(){
		if(isLogged()&&!running){
			running=true;
			myAjax({
				type	:'POST',
				url		:DOMINIO+'controls/notifications/notifications.json.php?action=push',
				dataType:'json',
				data	: defaultNotificationTypes,
				log		:false,
				loader	:false,
				success	:function(data){
					val=data.push;
					if(val&&val>0)
						$('.push-notifications').text(val).show();
					else
						$('.push-notifications').hide();
				},
				complete:function(/*xhr,status*/){
					running=false;
				}
			});
		}
	};
	$(function(){
		push();
		setInterval(push, 30000);
	});
})(document,window,jQuery,console);
//-- check notifications --//
(function(document,window,$,console){
    if ($.session('notif')){
        var data=$.session('notif');
        $(function(){
            myAjax({
				type	:'POST',
				url		: DOMINIO+'controls/notifications/notifications.json.php?check='+data.source+'&type='+data.type+'&action=push',
				dataType:'json',
				log		:false,
				loader	:false,
				complete:function(/*xhr,status*/){
					$.session('notif',null);
				}
			});
    	});
    }
})(document,window,jQuery,console);


//-- pageshow --//
(function(document,window,$,console){
	var comeFromAjax= false;
	var Login=function(logged){
		if(!logged) redir(PAGE['ini']);
	};
	//if(match) console.log('no necesita login. Url coincide con: '+match);
	//smt: contenedor para funciones de tagbum
	window.smt=function(opc){
		console.log(location);
		console.log(opc);
		opc=opc||{};
		if(opc.id.charAt(0)!='#') opc.id='#'+opc.id;
		if(opc.id.substr(0,6)!='#page-') opc.id='#page-'+opc.id.substr(1);
		if(!opc.disabled){
			arrayGet(comeFromAjax?$.session('get'):null);
			var runBefore=function(){
				if(opc.backButton||(opc.buttons&&opc.buttons.back))
					$('[data-role="header"]',opc.id).last().prepend('<a href="#" data-icon="arrow-l" onclick="goBack()">'+lan('Back')+'</a>');
				if(opc.homeButton||(opc.buttons&&opc.buttons.home))
					$('[data-role="header"]',opc.id).last().append('<div class="home" onclick="redir(PAGE[\'home\'])"></div>');
				if(typeof opc.before === 'function') opc.before.call(opc);
				loginState(opc.login||Login,opc.loginError);
			};
			if(comeFromAjax)
				$(runBefore);
			else
				runBefore();
			$.session('get',null);
		}
		var runAfter=function(){
			arrayGet();
			var title='Tagbum';
			if(navigator.app) title+=' App';
			if(typeof opc.title === 'function') opc.title=opc.title();
			if(opc.title){
				title+=': '+opc.title;
				$('.ui-page-active .ui-header h1').html(opc.title);
			}
			document.title=navigator.userAgent.match(/tagbum/i)?title:'Tagbum Web';
			$('.ui-page-active .ui-header,.ui-page-active .ui-footer').fixedtoolbar({ tapToggle: false });
			setTimeout(function(){
				if ($('.ui-page-active .ui-footer').length>0)
					$('.ui-page-active:not(.default) .ui-content').css('margin-bottom',$('.ui-page-active .ui-footer').height());
			}, 10);
			if(!opc.disabled&&typeof opc.after === 'function'){
//				if(CORDOVA)
//					document.addEventListener('deviceready',function(){opc.after.call(opc);},false);
//				else
					opc.after.call(opc);
			}
			windowFix();
		};
		if($.mobile.ajaxEnabled)
			$(opc.id).one('pageshow',runAfter);
		else
			$(runAfter);
		comeFromAjax=true;
		return opc;
	}
	window.pageShow=$.smt=window.smt;
})( document, window, jQuery, console );

//agregado agrupacion y numeracion en las etiquetas de lista
(function($){$(function(){
	$.mobile.document.delegate( "ul, ol", "listviewcreate", function() {
		var list = $( this ),
			listview = list.data( "mobile-listview" );
		if ( !listview || !listview.options.autodividers ) {
			return;
		}
		var replaceDividers = function () {
			list.find( "li:jqmData(role='list-divider')" ).remove();
			var lis = list.find( 'li' ),
				lastDividerText = null,
				i, j, li, divider, counter, counterValue = 0, dividerText;
			if(listview.options.autodividersGroup)
			for ( i = 0; i < lis.length ; i++, j=i+1 ) {
				if ( lis[j] && listview.options.autodividersSelector( $( lis[i] ) ) !== listview.options.autodividersSelector( $( lis[j] ) ) ) {
					for ( j++; j < lis.length ; j++ ) {
						if ( lis[j] && listview.options.autodividersSelector( $( lis[i] ) ) === listview.options.autodividersSelector( $( lis[j] ) ) ) {
							$(lis[j]).insertAfter(lis[i]);
							i++;
							lis = list.find( 'li' );
						}
					}
				}
			}
			lis = list.find( 'li' );
			for ( i = 0; i < lis.length ; i++ ) {
				li = lis[i];
				dividerText = listview.options.autodividersSelector( $( li ) );

				if ( dividerText && lastDividerText !== dividerText ) {
					counterValue = 0;
					divider = document.createElement( 'li' );
					divider.appendChild( document.createTextNode( dividerText ) );
					if(listview.options.autodividersCounter){
						counter = document.createElement( 'span' );
						counter.setAttribute( 'class', 'ui-li-count' );
						divider.appendChild( counter );
					}
					divider.setAttribute( 'data-' + $.mobile.ns + 'role', 'list-divider' );
					li.parentNode.insertBefore( divider, li );
				}
				if( listview.options.autodividersCounter ) {
					$( counter ).text( ++counterValue );
				}
				lastDividerText = dividerText;
			}
		};
		var afterListviewRefresh = function () {
			list.unbind( 'listviewafterrefresh', afterListviewRefresh );
			replaceDividers();
			listview.refresh();
			list.bind( 'listviewafterrefresh', afterListviewRefresh );
		};

		afterListviewRefresh();
	});
});})(jQuery);
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

//-- noRepeat --//
function noRepeat(fn){//se crea una funcion que no se repetira hasta que se reactive
	var running,
		enable=function(){running=false;},
		call=function(){
			if(!running){
				var a=[enable];
				for(var i=0;i<arguments.length;i++){
					a.push(arguments[i]);
				}
				running=true;
				fn.apply(null,a);
			}
			else console.log('norepeat:runing');
		};
	return call;
}
/* ejemplo de uso (noRepeat)
//creacion:
var test=noRepeat(function(enable,a,b){//primer argumento enable, despues agregamos los que queramos
	console.log('evento iniciado. a='+a+',b='+b);
	setTimeout(function(){
		enable();
	},100);
});
//llamado:
test(1,2);
//el segundo llamado no se ejecutara ya que la funcion enable se llama con un retrazo
test(3,4);
*/

(function($){
 
var hasTouch = /android|iphone|ipad/i.test(navigator.userAgent.toLowerCase()),
    eventName = hasTouch ? 'touchend' : 'click';
 
/**
 * Bind an event handler to the "double tap" JavaScript event.
 * @param {function} doubleTapHandler
 * @param {number} [delay=300]
 */
$.fn.doubletap = function(container, doubleTapHandler, singleTapHandler, delay){
    delay = (delay == null) ? 300 : delay;
 
    this.on(eventName, container, function(event){
        var now = new Date().getTime();
 
        // the first time this will make delta a negative number
        var lastTouch = $(this).data('lastTouch') || now + 1;
        var delta = now - lastTouch;
        if(delta < delay && 0 < delta){
            // After we detct a doubletap, start over
            $(this).data('lastTouch', null);
 
            if(doubleTapHandler !== null && typeof doubleTapHandler === 'function'){
                doubleTapHandler(event);
            }
        }else{
            $(this).data('lastTouch', now);
            if(singleTapHandler !== null && typeof singleTapHandler === 'function'){
                singleTapHandler(event);
            }
        }
    });
};
 
})(jQuery);