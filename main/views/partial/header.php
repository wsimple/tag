<?php
$minify=!$setting->local&&!$control->is_debug('minify');
?>
<!DOCTYPE html>
<html lang="<?=$language?>">
	<head>
	<base href="<?=$setting->dominio?>" />
	<title><?=$lang->get('TITLE')?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=.5,maximum-scale=1.13,user-scalable=1"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<?php if($txnId===true){ ?>
		<meta HTTP-EQUIV="REFRESH" content="10;url=.?<?=end(explode('?',$_SERVER['REQUEST_URI']))?>">
	<?php } ?>
	<?php if(preg_match('/msie [6-8]/i',$_SERVER['HTTP_USER_AGENT'])&&preg_match('/chromeframe/i',$_SERVER['HTTP_USER_AGENT'])) { ?>
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<?php } ?>
	<link rel="apple-touch-startup-image" href="css/smt/main_bg.png"/>
	<link rel="icon" href="css/smt/icon.png" type="image/png"/>
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta name="robots" content="all,index,follow"/>
	<meta name="rating" content="General"/>
	<meta name="reply-to" content="<?=$lang->get('EMAIL_CONTACTO')?>"/>
	<meta name="copyright" content="<?=$lang->get('COPYRIGHT')?>"/>
	<meta name="Author" content="<?=$lang->get('AUTHOR')?>"/>
	<meta name="description" content="<?=$lang->get('DESCRIPTION')?>"/>
	<meta name="google-site-verification" content="OVxfKydQKcISwAEi9um6hz88kHTvsjXhay_PTsbMC1I"/>
	<link rel="shortcut icon" href="css/smt/icon.png"/>
	<link rel="apple-touch-icon" href="css/smt/icon.png"/>
	<script>
	<?php if(!$client->is_logged){ ?>'localStorage' in window && localStorage.removeItem('logged');<?php } ?>
	var BASEURL='./',FILESERVER='<?=$setting->img_server?>',DOMINIO='<?=$setting->dominio?>',SECTION='<?=$location->section?>',ISLOGGED=<?=$client->is_logged?'true':'false'?>;
	</script>
	<script src="min/?f=js/language_<?=$lang->code()?>.js" charset="utf-8"></script>
	<?php if($minify){ ?>
		<link href="min/?g=css" rel="stylesheet"/>
		<script src="min/?g=js" charset="utf-8"></script>
		<script src="http://www.youtube.com/iframe_api"></script>
		<script src="min/?f=js/funciones_<?=$lang->code()?>.js" charset="utf-8"></script>
	<?php }else{
		$cssJsLocal=(require 'min/groupsConfig.php');
		foreach($cssJsLocal['css'] as $css){
			echo '<link href="'.str_replace('//','',$css).'" rel="stylesheet">';
		}
		foreach($cssJsLocal['js'] as $js){
			echo '<script src="'.str_replace('//','',$js).'" charset="utf-8"></script>';
		}?>
		<script src="http://www.youtube.com/iframe_api"></script>
		<script src="js/funciones.js.php" charset="utf-8"></script>
	<?php } ?>

	<?php	if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
	<script type="text/javascript" src="<?=$minify?"min/?f=":""?>js/jquery.tipsy.js"></script>
	<?php	}
			if ( $client->is_logged && !$setting->local){ ?>
	<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8" />
	<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
	<?php	} ?>

	<?php if($lang->code()=='es') { ?><script src="js/chosen.es.js"></script><?php } ?>

	<?php if($client->is_logged){//si esta loggeado ?>
	<script	type="text/javascript"	src="<?=$minify?"min/?f=":""?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link	type="text/css"			href="<?=$minify?"min/?f=":""?>css/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet"/>
	<?php }else{//deslogeado ?>
	<link rel="stylesheet" type="text/css" href="<?=$minify?"min/?f=":""?>css/jquery.fullPage.css" />
	<script type="text/javascript" src="<?=$minify?"min/?f=":""?>js/jquery.fullPage.js"></script>
	<?php } ?>
	<!-- Compliance patch for Microsoft browsers -->
	<!--[---if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE9.js"></script><![endif]-->
</head>
<body lang="<?=$language?>" <?=$bg?>>
<div style="display:none;"><?=var_dump($client)?></div>
<page id="smt" class="<?=$client->is_logged?'logged':'unlogged'?>" data-logged="<?=$client->is_logged?1:0?>">

<header>
<content>
<?php if($client->is_logged){
	##
	## Menu logged
	## Menu logueado
	##
	//mouse action (en web: over, en mobile: click)
	$ma=$setting->is_mobile?'mc':'mo';
	?>
	<a href="."><logo></logo></a>
	<menu class="pa"><div class="_tt"><div class="_tc">
		<ul class="mainMenu">
			<li id="menu_notifications" style="display:none;">
				<a id="numNoti" class="fNiv mc"><span>0</span></a>
				<ul id="linknoti">
					<li class="arrow"></li>
					<li id="divNoti"></li>
					<li id="divAllNoti"><a id="backgroundA" href="carousel"><div><?=$lang->get('USER_BTNSEEMORE')?></div></a></li>
				</ul>
				<div id="tourNotifications"></div>
			</li>
			<li>
				<a class="user" href="<?=$client->username!=''?$client->username:'user/preview'?>">
					<img src="<?='img/users/default.png'//$setting->img_server.getUserPicture($client->profile_image_url,'img/users/default.png')?>"/>
					<?=$lang->get('Me')?>
				</a>
				<div id="tourProfile"></div>
			</li>
			<li>
				<a class="fNiv <?=$ma?>" href="friends?sc=1"><?=$lang->get('Friends')?></a>
				<ul>
					<li class="arrow"></li>
					<li><a href="friends?sc=1"><?=$lang->get('Friends')?></a></li>
					<li><a href="friends?sc=2"><?=$lang->get('FRIENDS_FINDFRIEND_MENUMAIN')?></a></li>
					<li><a href="friends?sc=3"><?=$lang->get('USERS_BROWSERFRIENDSLABELBTNINVITE')?></a></li>
				</ul>
				<div id="tourFriends"></div>
			</li>
			<li>
				<a class="fNiv <?=$ma?>" href="timeline">Tags</a>
				<ul>
					<li class="arrow"></li>
					<li><a href="carousel"><?=$lang->get('MAINMNU_CAROUSEL')?></a></li>
	                <li><a href="timeline"><?=$lang->get('TIMELINE_TITLE')?></a></li>
					<li><a href="timeline?current=myTags"><?=$lang->get('MAINMNU_MYTAGS')?></a></li>
					<li><a href="timeline?current=favorites"><?=$lang->get('TIMELINE_FAVORITES')?></a></li>
					<li><a href="timeline?current=personalTags"><?=$lang->get('MAINMNU_PERSONALTAGS')?></a></li>
					<li><a href="timeline?current=privateTags"><?=$lang->get('MAINMNU_PRIVATETAG')?></a></li>
				</ul>
				<div id="tourTimeline"></div>
			</li>
			<li>
				<a class="fNiv <?=$ma?>" href="toptag?sc=1"><?=$lang->get('TOPTAG_TITLE')?></a>
				<ul>
					<li class="arrow"></li>
					<li><a href="toptag?current=hits&range=1"><?=$lang->get('TOPTAGS_DAILY')?></a></li>
					<li><a href="toptag?current=hits&range=2"><?=$lang->get('TOPTAGS_WEEKLY')?></a></li>
					<li><a href="toptag?current=hits&range=3"><?=$lang->get('TOPTAGS_MONTHLY')?></a></li>
					<li><a href="toptag?current=hits&range=4"><?=$lang->get('TOPTAGS_YEARLY')?></a></li>
					<li><a href="toptag?current=hits&range=5"><?=$lang->get('TOPTAGS_ALWAYS')?></a></li>
				</ul>
				<div id="tourToptag"></div>
			</li>
			<?php
				if ($_SESSION['ws-tags']['ws-user']['type']==1){
			?>
					<li>
						<a href="publicity"><?=$lang->get('USERPUBLICITY_PAYMENT')?></a>
						<div id="tourPublicity"></div>
					</li>
			<?php	}
			?>
			<li>
				<a class="fNiv <?=$ma?>" id="lihome" href="home"><?=$lang->get('MNUUSER_TITLEHOME')?></a>
				<ul>
					<li class="arrow"></li>
					<li><a href="home"><?=$lang->get('MNUUSER_TITLEHOME')?></a></li>
					<li id="tourHelp"><a href="<?=$lang->get('HREF_DEFAULT')?>" action="tourActive"><?=$lang->get('HELP')?></a></li>
					<li><a href="logout.php"><?=$lang->get('MNUUSER_TITLELOGOUT')?></a></li>
				</ul>
				<div id="tourHome"></div>
			</li>
		</ul>
	</div></div></menu>
	<menu class="fright"><div class="_tt"><div class="_tc">
		<input type="search" id="txtSearchAll" name="txtSearchAll" placeholder="<?=$lang->get('FRIENDS_SEARCHFORFRIENDS_TITLEFOR')?>"/>
		<!-- <input type="submit" name="enviar" value="enviar"> -->
	</div></div></menu>
	<div class="fright loader"><loader class="page" style="display:none;"></loader></div>
	<script type="text/javascript">
		$(function(){
			$$.ajax({
				type	: 'GET',
				url		: 'controls/tour/tourHelp.json.php?section='+SECTION,
				dataType: 'json',
				success	: function (data){
				    // console.log(data);
					if (data=='no') {
						$('#tourHelp').hide();	
					};
				}
			});

			$('.mainMenu').jMenu();
			if (location.hash=='#carousel'){ $('#divAllNoti').slideUp(); }
	        else{ $('#divAllNoti').slideDown(); }
			$('#divNoti').load('view.php?page=users/notifications.php&dialog');
			$('#numNoti').click(function(){
	            var o=$(this);
				$$.ajax({
					type	: 'GET',
					url		: 'controls/notifications/notifications.json.php?checked=1&action=push',
					dataType: 'json',
					success	: function (data){
					    console.log(data);
						var aux,titulo;
						titulo = document.title.split('-');
						aux = titulo[0].split(')'); //alert(aux[0]+', '+aux[1]);
						document.title = (aux[1]?aux[1]:titulo[0]) +' - '+titulo[1];
						$(o).removeClass('more').children().empty().html(0);
					}
				});
				$('#linknoti').show();
				$('#divAllNoti').click(function(){
					$('html,body').animate({scrollTop:'470px'},'slow',function(){
						$('html,body').clearQueue();
					});
				});
			});
			$(window).hashchange(function(){
				$('.tipsy').remove();
				if (window.location.hash=='#carousel'){ $('#divAllNoti').slideUp(); }
	            else{ $('#divAllNoti').slideDown(); }
			});
			var $search=$('#txtSearchAll'),ac;
			$search.autocomplete({
	//			minLength:2,
				focus:function(ev,ui){
					ev.preventDefault(); // without this: keyboard movements reset the input to ''
				},
				select:function(ev,ui){
					$search.val('');
					if(ui.item.url) redir(ui.item.url);
				},
				source:function(req,add){
					//paso peticion al server
					req.term=req.term.trim();
					if(req.term=='') $search.autocomplete('close');
					$.getJSON('controls/resultSearchAll.json.php?callback=?',req,function(data){
						//Array para las respuestas
						var suggestions=[];
						//procesamos todas las repsuestas
						data.forEach(function(val){
							console.log(val)
							if(val.noresult)
								suggestions.push(val.noresult);
							if(val.people)
								suggestions.push(val.people);
							if(val.group)
								suggestions.push(val.group);
							if(val.hash)
								suggestions.push(val.hash);
							if(val.product)
								suggestions.push(val.product);
						});
						//paso array al callback
						add(suggestions);
					});
				}
			}).keypress(function(e){
				var kc=e.keyCode;
				if(kc==13){
					var val=$(this).val().trim(); //alert(escape(val))
					if(val!=''){
						$(this).val('').autocomplete('close');
						redir('searchall?srh=' + escape(val));
					}
	//				if(val.charAt(0)=='#')
	//					redir('timeline?current=' + val);
	//				else
					//alert(escape(val))
				}
			}).focus(function(){
				if(this.value!='') $(ac.menu.element).show();
			});
			ac=$.fn.jquery.versionLt('1.10')?$search.data('autocomplete'):$search.autocomplete('widget');
			ac._renderMenu=function(ul,items){
				var lastCategory='',that=this;
				items.push({category:"searchall",search:$search.val()});
				//console.log(['autocomplete',items]);
				items.forEach(function(item){
					if(lastCategory!==item.category && item.category!=='NORESULTS' && item.category!=='searchall'){
						lastCategory=item.category;
						ul.append('<li class="ui-autocomplete-category">'+lastCategory+'</li>');
					}
					that._renderItemData(ul,item);
				});
			};
			ac._renderItem=function(ul,item){		
				var $li=$('<li>'),res='',sp='';
				if(item.category==='<?=$lang->get('SEARCHALL_PEOPLES')?>'){
					item.url=BASEURL+'user/'+item.id;
					// alert('Encontrada una persona');
					$li.addClass('ui-autocomplete-person')
					.append('<a href="'+item.url+'">'+
								'<div class="quick-search-container">'+
									'<span class="info-quick-search">'+
										'<div>'+
											'<div style="float: left">'+
												'<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="12" height="12">'+
											'</div>'+
											'<div>'+item.name+'</div>'+
										'</div>'+
										'<div class="titleSearch">'+item.email+'</div>'+
									'</span>'+
									'<span><img src="'+item.photo+'" alt="User" width="50" height="50"></span>'+
								'</div>'+
							'</a>');
				}else if(item.category==='<?=$lang->get('SEARCHALL_GROUPS')?>'){
					item.url=BASEURL+'groupsDetails?grp='+item.id;
					$li.addClass('ui-autocomplete-group')
					.append('<a href="'+item.url+'"><img src="css/smt/menu_left/groups.png" alt="Groups Icons" title="Group" width="12" height="12">'+item.name+'</a>');
				}else if(item.category==='<?=$lang->get('SEARCHALL_HASTASH')?>'){
					if(item.hash.length>40){
						res = item.hash.substr(0,40);
						sp  = '...';
					}else{
						res = item.hash;
						sp  = '';
					}
					item.url=BASEURL+'searchall?srh='+encodeURIComponent(item.hash)+'&in=1';
					$li.addClass('ui-autocomplete-group')
					.append('<a href="'+item.url+'"><img src="css/smt/menu_left/groups.png" width="12" height="12">'+res+sp+'</a>');
				}else if(item.category==='<?=$lang->get('SEARCH_PRODUCT')?>'){
					item.url=BASEURL+'detailprod?prd='+item.id;
					$li.addClass('ui-autocomplete-person')
					.append('<a href="'+item.url+'">'+
								'<div class="quick-search-container">'+
									'<span class="info-quick-search">'+
										'<div>'+
											'<div style="float: left">'+
												'<img src="css/tbum/menu_left/cart_off.png" alt="Product Icon" title="Person" width="12" height="12">'+
											'</div>'+
											'<div>'+item.name+'</div>'+
										'</div>'+
										'<div class="titleSearch">'+item.cate+'</div>'+
									'</span>'+
									'<span><img src="'+item.photo+'" alt="'+item.name+'" width="50" height="50"></span>'+
								'</div></a>');
				}else if(item.category==='searchall'){
					item.url=BASEURL+'searchall?srh='+item.search;
					$li.addClass('ui-autocomplete-searchall')
					.append('<a href="'+item.url+'" title="<?=$lang->get('MNUUSER_SEARCHALL')?>"><?=$lang->get('MNUUSER_ALLRESULTS')?></a>');
				}else{
					$li.html(item.name);
				}
				return $li.appendTo(ul);
			};
		});
	</script>
<?php }else{
	##
	## Menu unlogged
	## Menu deslogueado
	##

//obtengo el nombre de usuario
$epro = $_SERVER['REQUEST_URI'];
$userp = explode('/', $epro);

$languages=$control->db->getObject('SELECT cod,name FROM languages');
?>
<a href="."><logo></logo></a>
<div class="fleft loader"><loader class="page" style="display:none;"></loader></div>
<menu class="fleft">
	<div class="_tt">
		<div class="_tc">
			<div id="titleNormal">
				<a href="#WhatIsIt" class="prinTitle prinTitleActive" id="1"><?=$lang->get('What is it?')?></a>
				<a href="#HowDoesWork" class="prinTitle" id="2"><?=$lang->get('How does it work?')?></a>
				<a href="#App" class="prinTitle" id="3"><?=$lang->get('App download')?></a>
				<a class="prinTitle" id="login"><span class=" iconLogin"></span><?=$lang->get('Login')?></a>
				<form method="post" action="//<?=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>">
					<select name="lang" id="lang_list" onchange="this.form.submit();">
						<option value="none" selected><?=$lang->get('Languages')?></option>
						<?php foreach($languages as $_lan){ ?>
							<option value="<?=$_lan->cod?>"><?=$_lan->name?></option>
						<?php } ?>
					</select>
				</form>
			</div>
		</div>
	</div>
</menu>
<div class="dnone" id="logindialog"><?php $control->load->view('partial/login'); ?></div>
<script>
	$(function(){
		$('#lang_list').chosen({disableSearch:true, width:100});
		var menu='#titleNormal a';
		$('page>header menu').on('click',menu,function(){
			//console.log('esta ahora en: '+this.id);
			$(menu).removeClass('prinTitleActive');
			$(this).addClass('prinTitleActive');
		});
		$('page').on('click','a#login',function(){
			$('#logindialog').dialog({
				title: 'Login',
				resizable: false,
				width:360,
				modal: true,
				show: 'fade',
				hide: 'fade',
				close:function() {
					$(this).dialog('close');
				}
			});
		});
		$(window).hashchange(function(){
			//alert(document.location.hash);
			var hash = document.location.hash.split('/')[0];
			if((hash=='#')||(hash=='')){
				hash = '#WhatIsIt';
			}
			$(menu).removeClass('prinTitleActive');
			$(menu).filter('[href="'+hash+'"]').addClass('prinTitleActive');
		});
	});
</script>
<?php } ?>
</content>
</header>

<wrapper data-section="<?=$location->section?>">
