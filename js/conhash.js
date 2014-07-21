var hashBack;
(function(window,$,console){
//-- $.on permite cargar/descargar eventos al abrir/cerrar una pagina --//
	$.on=function(opc){
//		console.log('$.on');
		if(NOHASH){
			$(function(){ opc.open.call(opc); });
		}else{
			var $cont=$('wrapper container'),
				open =function(){ opc.open.call(opc);	},
				close=function(){ opc.close.call(opc);	};
			if(opc.open){	$cont.bind('pageopen', open); open();	};
			if(opc.close)	$cont.bind('pageclose',close);
		}
	};

	$(window).hashchange(function(){
		//console.log('hashchange');
		var doit=true;
		if($.hashExceptions&&($.hashExceptions instanceof Array)){
			$.hashExceptions.forEach(function(el){
				var re=new RegExp('^'+el);
				//console.log(re);
				if(document.location.hash.substr(1).match(re)) doit=false;
			});
		}
		if(doit) hashLoad();
	});

	var $_GET={},a=location.search.substring(1).split('&'),b,c,d,e,f;
	for(b=0;b<a.length;b++){
		c=a[b];
		if(c!=''){
			d=c.indexOf('=');
			e=c.substr(0,d<0?c.length:d);
			f=d<0?null:c.substr(d+1);
			$_GET[e]=f;
		}
	}
	var last,
		defaultPage=ISLOGGED?'timeline':'home',
		grupo=[//arreglos de ids que abren una pagina en comun. el primero es el default.
			['#home','#whatIsIt','#howDoesWork','#howDoesWork/1','#howDoesWork/2','#howDoesWork/3','#app']
		];
	function getHash(){
		var hash=(document.location.hash||'#')+'',get='',tmp;
		tmp=hash.split('?');
		if(!tmp[1]) tmp=tmp[0].split('&');
		if(tmp[1]){
			hash=tmp.shift();
			get='&'+tmp.join('&');
		}else
			hash=tmp[0];
		console.log(hash);
		return [hash,get];
	}
	last=getHash()[0];
	function hashLoad(){
		if(NOHASH) return;
		if(!hashBack){
			var tmp=getHash(),
				hash=tmp[0],
				get=tmp[1],
				str=document.location.pathname.match(/^(\/(seemytag|[\w\d\.]*tag[\w\d\.]*|wpruebas))?\/(.*)/i);
			grupo.forEach(function(el){
				if(el.indexOf(hash)>=0) hash=el[0];
			});
			if(str) str=str[str.length-1];
			console.log('hasload. str='+str+' hash='+hash);
			var $dialogs=$('.ui-dialog .ui-dialog-content');
			if($dialogs.length>0) $dialogs.dialog('close');
			if(hash=='#'&&str&&str!=''&&str!='index.php'){
//				console.log('-profile');
				//cargar perfil
				loadContent('profile','&sc=6&usr='+str+get);
			}else{
//				console.log('-hash: gettag='+$_GET['tag']);
				if(hash=='#'){
					if($_GET['tag']&&$_GET['tag']!='5de743f134186ab')
						get+='&tag='+$_GET['tag']+'&referee='+$_GET['referee']+'&email='+$_GET['email'];
					loadContent(defaultPage,get);
				}else
					loadContent(hash.substr(1),get);
			}
		}
	}

	var lc_url='first',
		c=[];//lista de containers cacheados
	function loadContent(id,get){
		get=get||'';
		var i,len=c.length,cont;
		console.log('loadcontent id: '+id+get);
		if($('container').data('id')==id+get) return;
		for(i=0;i<len&&!cont;i++){
			if($(c[i]).data('id')==id+get) cont=c.splice(i,1)[0];
		}
		if(cont){
			console.log('loaded cached page. id: '+$(cont).data('id'));
			changeContainer(cont);
		}else{
			var url='view.php?pageid='+id+get.replace('#','%23');
			console.log('loading page: '+url);
			lc_url=url;
			//$('#btnTourActive').hide();
			$$.ajax({
				type:'POST',
				url:url,
				dataType:'html',
				success:function(data){
					if(lc_url==url){
						if(data=='404')
						if(isLogged()){
							console.log('wrong');
							if($.local('enableLogs'))
								data='Error 404. Page not found.';
							else
								historyBack();
						}else
							return loadContent('home');
						if(data!='404'){
							window.lastPage=data;
							if(!data.match(/<container/i)) data='<container>'+data+'</container>';
							changeContainer(data,id+get);
						}
					}
				}
			});
		}
	}
	function changeContainer(newer,id/*+get*/){
		var older=container,cache=$(older).hasClass('cache');
		if(newer!=older) $(older).trigger('pageclose');
		older=$(older).detach();
		container=wrapper;
		if(typeof newer==='string'){
			var func=function(){
				$(container).html(newer);
				newer=$('container',wrapper)[0];
				$(newer).data('id',id);
				lastHash=document.location.hash;
			};
			if($.local('enableLogs')) func();
			else
				try{
					func();
				}catch(e){
					$(newer).remove();
					$(wrapper).append(older);
					newer=older;
					historyBack();
				}
		}else{
			$(wrapper).append(newer);
			lastHash=document.location.hash;
			if(!NOHASH) $(newer).trigger('pageopen');
		}
		container=newer;
		if(newer!=older){
//			var top=$('header',PAGE).offset().top;
//			$(older).data('top',top);
//			console.log(top);
			if(cache){
				console.log('se guarda cache de: '+id);
				c.push(older);
			}else $(older).remove();
			$('body').removeClass('bg');
			if($(newer).hasClass('bg')) $('body').css('background','').addClass('bg');
			windowChange();
//			$('html,body').animate({scrollTop:$(newer).data('top')||0},'slow');
			$('html,body').animate({scrollTop:0},'slow');
		}
	}
	$.all=function(selector,context){
		var i,len=c.length,$all=$(document);
		for(i=0;i<len;i++) $all.add(c[i]);
		if(!selector||selector=='') return $all;
		if( !context ) return $(selector,$all);
		return $(selector,$(context,$all));
	}
})( window,jQuery,console );
