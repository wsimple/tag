<article class="side-box menu">
	<header><span></span></header>
	<ul id="menuLeft">
		<li id="cretationTag"><a href="<?=base_url('creation')?>"><?=MAINMNU_CREATETAG?></a></li>
		<li id="profile">
			<span><?=MAINMNU_ACCOUNT?></span>
			<ul>
				<li><a href="<?=base_url('profile?sc=1')?>"><?=USERPROFILE_PERSONALINFO?></a></li>
				<li><a href="<?=base_url('profile?sc=2')?>"><?=USERPROFILE_PREFERENCES?></a></li>
				<li><a href="<?=base_url('profile?sc=4')?>"><?=MAINSMNU_PASSWORD?></a></li>
				<li><a href="<?=base_url('profile?sc=3')?>"><?=USERPROFILE_BUSINESSCARD?></a></li>
			</ul>
		</li>
		<li id="friends">
			<span><?=USER_FINDFRIENDSTITLELINKS?></span>
			<ul>
				<li><a href="<?=base_url('friends?sc=1')?>"><?=MAINMNU_FINDFRIENDS?></a></li>
				<li><a href="<?=base_url('friends?sc=2')?>"><?=EDITFRIEND_VIEWTAB1?></a></li>
				<li><a href="<?=base_url('friends?sc=3')?>"><?=EDITFRIEND_VIEWTAB2?></a></li>
			</ul>
		</li>
		<li id="groups">
			<span><?=MAINMNU_GROUPS?></span>
			<ul>
				<li><a href="<?=base_url('groups?sc=1')?>"><?=GROUPS_LABELTABLSTMYGROUPS?></a></li>
				<li><a href="<?=base_url('groups')?>"><?=GROUPS_LABELTABLSTALL?></a></li>
			</ul>
		</li>
		<li id="setting">
			<span><?=MAINMNU_SETTINGLEFT?></span>
			<ul>
				<li><a href="<?=base_url('setting?sc=1')?>"><?=NOTIFICATIONS_CONFIGURATIONSECTION?></a></li>
				<!-- <li><a href="<?=base_url()?>"><?=MAINMNU_SETTINGLEFT?></a></li> -->
			</ul>
		</li>
		<li id="store">
			<a href="<?=base_url('store')?>"><span><?=STORE?></span></a>
			<ul>
				<li><a href="<?=base_url('store')?>"><?=PRODUCT_TITLE?></a></li>
				<?php if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
				<li><a href="<?=base_url('newproduct')?>"><?=PRODUCTS_ADD?></a></li>
				<li><a href="<?=base_url('mypublications')?>"><?=STORE_MISPUBLICATION?></a></li>
				<?php } ?>
				<li id="menu-l-li-shoppingCart" >
					<a href="<?=base_url('shoppingcart')?>"><?=STORE_SHOPPINGCART?></a>
					<div id="menu-lshoppingCart" class="menu-l-shoppingCart" style="display: none;"></div>
					<div class="clearfix"></div>
				</li>
				<li id="menu-l-li-wishList" ><a href="<?=base_url('wishList')?>"><?=STORE_WISH_LIST?></a></li>
				<li><a href="<?=base_url('freeproducts')?>"><?=PRODUCTS_RAFFLE?></a></li>
				<li class="menu-l-youOrders" style="display: none;"><a href="<?=base_url('orders')?>"><?=STORE_YOURORDES?></a></li>
				<?php if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
				<li class="menu-l-youSales" style="display: none;"><a href="<?=base_url('sales')?>"><?=STORE_SALES?></a></li>
				<?php } ?>

				<?php if (PAYPAL_PAYMENTS): ?>
					<li><a href="<?=HREF_DEFAULT?>" action="buyPoints"><?=STORE_SALE_POINTS?></a></li>	
				<?php endif ?>
			</ul>
		</li>
	</ul>
</article>
<article id="adsListPubli" class="side-box news">
	<header><span><?=MAINMNU_NEWS_TITLE?></span></header>
	<table width="155" border="0" align="left" cellpadding="0" cellspacing="0" class="tableNews" id="info-container">
		<tr id="noticeInsertTop" style="display:none;"><td><div class="clearfix"></div></td></tr>
		<tr id="news-loader" style="font-size:11px;color:#f82;"><td>&nbsp;&nbsp;&nbsp;<?=NEWS_RIGHTSIDE_LOADING?></td></tr>
		<tr id="waitNewsInfo" style="font-size:11px;color:#f82;display:none;"><td style="padding:10px;">&nbsp;&nbsp;&nbsp;<?=NEWS_WAITMESSAGEFRIENDS?></td></tr>
	</table>
</article>
<?php /*
<div id="title-menuLeft" class="title-the-box">
<div class="divImagen-title imagenCategory"><?=Category?></div>
<ul id="menuLeft">
	<li id="cretationTag"><a href="<?=base_url('creation')?>"><?=MAINMNU_CREATETAG?></a></li>
	<li id="profile">
		<span><?=MAINMNU_ACCOUNT?></span>
		<ul>
			<li><a href="<?=base_url('profile?sc=1')?>"><?=USERPROFILE_PERSONALINFO?></a></li>
			<li><a href="<?=base_url('profile?sc=2')?>"><?=USERPROFILE_PREFERENCES?></a></li>
			<li><a href="<?=base_url('profile?sc=4')?>"><?=MAINSMNU_PASSWORD?></a></li>
			<li><a href="<?=base_url('profile?sc=3')?>"><?=USERPROFILE_BUSINESSCARD?></a></li>
		</ul>
	</li>
	<li id="friends">
		<span><?=USER_FINDFRIENDSTITLELINKS?></span>
		<ul>
			<li><a href="<?=base_url('friends?sc=1')?>"><?=MAINMNU_FINDFRIENDS?></a></li>
			<li><a href="<?=base_url('friends?sc=2')?>"><?=EDITFRIEND_VIEWTAB1?></a></li>
			<li><a href="<?=base_url('friends?sc=3')?>"><?=EDITFRIEND_VIEWTAB2?></a></li>
		</ul>
	</li>
	<li id="groups">
		<span><?=MAINMNU_GROUPS?></span>
		<ul>
			<li><a href="<?=base_url('groups?sc=1')?>"><?=GROUPS_LABELTABLSTMYGROUPS?></a></li>
			<li><a href="<?=base_url('groups')?>"><?=GROUPS_LABELTABLSTALL?></a></li>
		</ul>
	</li>
	<li id="setting">
		<span><?=MAINMNU_SETTINGLEFT?></span>
		<ul>
			<li><a href="<?=base_url('setting?sc=1')?>"><?=NOTIFICATIONS_CONFIGURATIONSECTION?></a></li>
			<!-- <li><a href="<?=base_url()?>"><?=MAINMNU_SETTINGLEFT?></a></li> -->
		</ul>
	</li>
	<li id="store">
		<a href="<?=base_url('store')?>"><span><?=STORE?></span></a>
		<ul>
			<li><a href="<?=base_url('store')?>"><?=PRODUCT_TITLE?></a></li>
			<?php if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
			<li><a href="<?=base_url('newproduct')?>"><?=PRODUCTS_ADD?></a></li>
			<li><a href="<?=base_url('mypublications')?>"><?=STORE_MISPUBLICATION?></a></li>
			<?php } ?>
			<li id="menu-l-li-shoppingCart" >
				<a href="<?=base_url('shoppingcart')?>"><?=STORE_SHOPPINGCART?></a>
				<div id="menu-lshoppingCart" class="menu-l-shoppingCart" style="display: none;"></div>
				<div class="clearfix"></div>
			</li>
			<li id="menu-l-li-wishList" ><a href="<?=base_url('wishList')?>"><?=STORE_WISH_LIST?></a></li>
			<li><a href="<?=base_url('freeproducts')?>"><?=PRODUCTS_RAFFLE?></a></li>
			<li class="menu-l-youOrders" style="display: none;"><a href="<?=base_url('orders')?>"><?=STORE_YOURORDES?></a></li>
			<?php if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
			<li class="menu-l-youSales" style="display: none;"><a href="<?=base_url('sales')?>"><?=STORE_SALES?></a></li>
			<?php } ?>
			<li><a href="<?=HREF_DEFAULT?>" action="buyPoints"><?=STORE_SALE_POINTS?></a></li>
		</ul>
	</li>
</ul>
</div>
<div id="adsListPubli" style="display: none">
	<div id="infoListNews" class="title-the-box">
		<div class="divImagen-title imagenNew"><?=MAINMNU_NEWS_TITLE?></div>
		<table width="155" border="0" align="left" cellpadding="0" cellspacing="0" class="tableNews" id="info-container">
			<tr id="noticeInsertTop" style="display:none;"><td><div class="clearfix"></div></td></tr>
			<tr id="news-loader" style="font-size:11px;color:#f82;"><td>&nbsp;&nbsp;&nbsp;<?=NEWS_RIGHTSIDE_LOADING?></td></tr>
			<tr id="waitNewsInfo" style="font-size:11px;color:#f82;display:none;"><td style="padding:10px;">&nbsp;&nbsp;&nbsp;<?=NEWS_WAITMESSAGEFRIENDS?></td></tr>
		</table>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>
<?php /* */?>
<script type="text/javascript">
	$(function(){
		//event handlers
		var ns='.newsList',//namespace
		interval,clearEvents=function(){
			//$(window).off(ns);
			clearInterval(interval);
		};
        function newsFormat(d){return(
                '<tr'+d.clase+' data-info="'+d.id+'">'+
					'<td tipo="'+d.type+'" width="18" style="padding:10px; vertical-align:top; border-bottom: 1px solid #f8f8f8" align="center" width="16" height="16" border="0">'+
					'</td>'+
					'<td style="padding:4px 8px 2px 0; font-size:10px;  border-bottom: 1px solid #f8f8f8">'+
						d.txt+'(<em style="color:#CCC">'+d.date+'</em>)'+
						'<div class="extras">'+d.photos+'</div>'+
					'</td>'+
				'</tr>'
		);}
        function peopleFormat(usr,num,type){
			if(!usr) return '';
			num=num||usr.length;
			var	i,max=3,len=num>max?max:num,ult=len-1,
				usrs='',imgs='',action;
			for(i=0;i<len;i++){
				if(i===ult && num>max){
					usrs+=' [_AND_] <b>'+(num-ult)+' [_MORE_]</b>';
				}else{
					if(i>0) usrs+=i<ult?', ':' [_AND_] ';
					if (type && ['22','25','26','27'].indexOf(type)<0){ action=action||(' action="profile,'+usr[i]['uid']+'"'); }
                    else {action=''; }
					if(usr[i]['photo']) 
						imgs=imgs||('<div'+action+'  class="usr-pic" style="background-image:url('+usr[i]['photo']+');width:30px;height:30px;"'+'"></div>');
					usrs+='<span'+action+'>'+usr[i]['name']+'</span>';
				}
			}
			imgs=imgs||('<div'+action+' class="usr-pic"></div>');
			return [imgs,usrs];
		}
		function getNews(action,opc){

			if(!opc.on) opc.on={};
			var act,
				limit=3,
				on=opc.on,
				layer=opc.layer,
				get=opc.get||'',
				cancel=function(){return (action!='reload'&&on['reload']);},//cancel action
				onca=function(val){if(val!==undefined)on[action]=val; return on[action];};//on current action
			if(!cancel()&&!onca()){
				onca(true);
				if(!opc.actions || action=='reload'){
					opc.actions={refresh:{},more:{}};
					opc.date='';
				}
				act=opc.actions[action=='refresh'?'refresh':'more'];

				$.qajax('low',{
					type	: 'GET',
					url		: 'controls/news/news.json.php?limit='+limit+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
					dataType: 'json',
					data	: act||{},
					complete: function(/*resp, status, error*/) {
						onca(false);
					},
					success	: function(data){
                        eval(data.txtFormat);

						if(data['info'].length>0){
							var i,out='',info,txt,len,type,clase='';
							opc.date=data['date'];
							act.start=(act.start||0)+data['info'].length;
							len=data['info'].length;

							if(action!='reload') clase=' style="animation:myfirst 3s; -webkit-animation:myfirst 5s; background:#FFF;"';
							for(i=0;i<len;i++){
								info = data['info'][i];

                                d={
									type:info['id_type'],
									date:info['fdate'],
									source:info['source'],
                                    id:info['id'],
                                    clase:clase
								};
                                friends=peopleFormat(info['friends'],info['num_friends'],info['id_type']);
                                var people=peopleFormat(info['usr'],1);
                                switch(info['type']){
									case 'tag':
										    var ac=' action="comment,'+info['idsource']+'"',
												tag=' <img'+ac+' src="'+FILESERVER+'img/tags/'+info['source'].substr(-16)+'.m.jpg" style="height:25px;"/>';
											d.photos=friends[0]+tag;
                                            d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
                                                friends:friends[1],
												num:info['num_friends'],
												txt:data['txt'],
												tag:'<span'+ac+'>[_TAG_]</span>'
											});
											out+=newsFormat(d);
										
									break;
									case 'usr':
										d.photos = friends[0];
										d.txt=txtFormat({
											type:info['id_type'],
											people:people[1],
                                            friends:friends[1],
											txt:data['txt']
										});
										out+=newsFormat(d);
									break;

								}
								
							}
							$('#adsListPubli').show();
							$('#news-loader').fadeOut('slow',function(){$(layer).after(out);});
							$('#info-container tr:gt(3)').remove();
						}else{
							if(action=='reload')
							   $('#news-loader').fadeOut('slow',function(){$('#waitNewsInfo').fadeIn('fast');});
						}
					}
				});
			}
		}
		clearEvents();

		$.on({
			open:function(){

			//news
			var opc={
					layer:'#noticeInsertTop',
					get:''
				};
				//puntos
				this.intervalmsk = setInterval(function(){ mskPointsReload('#mskPoints'); },40000);

				interval=setInterval(function(){
					if($(opc.layer).length>0){
						//console.log('aqui')
						// getNews('refresh',opc);
					}else
						clearEvents();
				}, 30000);
				//first run
				if($.smt.news){
					$('#adsListPubli').show();
					$('#info-container').html($.smt.news);
					delete $.smt.news;
				}
				// getNews('reload',opc);
				//fin-news

				var menu=$('#menuLeft')[0];
				$(menu).on('click','li>span',function(){
					//buscamos ul hijo (submenu)
					var ul=$(this).parent().find('ul')[0];
					if(ul){
						$('ul',menu).not(ul).slideUp(300);
						$(ul).slideToggle(300);
					}
				});
				var el,section;
				if(document.location.href.match(/\.php/i)) section=document.location.href.split('.php')[1];
				else section=document.location.hash;
				section=section.substr(1).split('#')[0].split('?')[0].split('&')[0];
				if(section){
					switch(section){
						case 'myfreeproducts':
						case 'newproduct':
						case 'mypublications':
						case 'shoppingcart':
						case 'freeproducts':
						case 'orders':
						case 'myparticipation':
						case 'shippingaddress':
						case 'detailprod':
						case 'salepoints':
						case 'sales':
                        case 'wishList':
							el='store';
						break;
						case 'creation':
							el='cretationTag';
						break;
                        case 'groupsDetails':
							el='groups';
						break;
						default: el=section;//elemento del menu principal
					}
					$(menu).children('#'+el)//li
					.addClass('selected')
					.children('ul').show();
				}
			},
			close:function(){
				$('#menuLeft').off();
				$.smt.news = $('#info-container').html();
				//console.log($.smt.news)
				//$(window).off(ns);
				clearInterval(interval);
				clearInterval(this.intervalmsk);
			}
		})
	});
</script>
