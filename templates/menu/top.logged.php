<?php
if(@strpos($_SESSION['ws-tags']['ws-user']['pic'],FILESERVER)!==false){
	$_SESSION['ws-tags']['ws-user']['pic']=getUserPicture('img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'],'img/users/default.png');
}
//$fot_=FILESERVER.generateThumbPath('img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']).'?'.time();
//detectar si es mobile
$detect=new Mobile_Detect();
//mouse action (en web: over, en mobile: click)
$ma=$detect->isMobile()?'mc':'mo';
unset($detect);
?>
<menu class="pa"><div class="_tt"><div class="_tc">
	<ul class="mainMenu">
		<li id="menu_notifications" style="display:none;">
			<a id="numNoti" class="fNiv mc"><span>0</span></a>
			<ul id="linknoti">
				<li class="arrow"></li>
				<li id="divNoti"></li>
				<li id="divAllNoti"><a id="backgroundA" href="<?=base_url('carousel?')?>"><div><?=USER_BTNSEEMORE?></div></a></li>
			</ul>
			<div id="tourNotifications"></div>
		</li>
		<li>
			<a class="user" href="<?=base_url(($_SESSION['ws-tags']['ws-user']['username']!=''?$_SESSION['ws-tags']['ws-user']['username']:'user/preview'))?>">
				<img src="<?=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['pic'],'img/users/default.png')?>"/>
				<?=MENU_MAINME?>
			</a>
			<div id="tourProfile"></div>
		</li>
		<li>
			<a class="fNiv <?=$ma?>" href="<?=base_url('friends')?>"><?=USER_FINDFRIENDSTITLELINKS?></a>
			<ul>
				<li class="arrow"></li>
				<li><a href="<?=base_url('friends')?>"><?=USER_FINDFRIENDSTITLELINKS?></a></li>
				<li><a href="<?=base_url('friends/find')?>"><?=FRIENDS_FINDFRIEND_MENUMAIN?></a></li>
				<li><a href="<?=base_url('friends/invite')?>"><?=USERS_BROWSERFRIENDSLABELBTNINVITE?></a></li>
			</ul>
			<div id="tourFriends"></div>
		</li>
		<li>
			<a class="fNiv <?=$ma?>" href="<?=base_url('timeline?')?>"><?=MAINMNU_HOME?></a>
			<ul>
				<li class="arrow"></li>
				<li><a href="<?=base_url('carousel?')?>"><?=MAINMNU_CAROUSEL?></a></li>
                <li><a href="<?=base_url('timeline?')?>"><?=TIMELINE_TITLE?></a></li>
				<li><a href="<?=base_url('timeline?current=myTags')?>"><?=MAINMNU_MYTAGS?></a></li>
				<li><a href="<?=base_url('timeline?current=favorites')?>"><?=TIMELINE_FAVORITES?></a></li>
				<li><a href="<?=base_url('timeline?current=personalTags')?>"><?=MAINMNU_PERSONALTAGS?></a></li>
				<li><a href="<?=base_url('timeline?current=privateTags')?>"><?=MAINMNU_PRIVATETAG?></a></li>
			</ul>
			<div id="tourTimeline"></div>
		</li>
		<li>
			<a class="fNiv <?=$ma?>" href="<?=base_url('toptag')?>"><?=TOPTAG_TITLE?></a>
			<ul>
				<li class="arrow"></li>
				<li><a href="<?=base_url('toptag/daily')?>"><?=TOPTAGS_DAILY?></a></li>
				<li><a href="<?=base_url('toptag/weekly')?>"><?=TOPTAGS_WEEKLY?></a></li>
				<li><a href="<?=base_url('toptag/monthly')?>"><?=TOPTAGS_MONTHLY?></a></li>
				<li><a href="<?=base_url('toptag/yearly')?>"><?=TOPTAGS_YEARLY?></a></li>
				<li><a href="<?=base_url('toptag/always')?>"><?=TOPTAGS_ALWAYS?></a></li>
			</ul>
			<div id="tourToptag"></div>
		</li>
		<?php
			if ($_SESSION['ws-tags']['ws-user']['type']==1){
		?>
				<li>
					<a href="<?=base_url('publicity')?>"><?=USERPUBLICITY_PAYMENT?></a>
					<div id="tourPublicity"></div>
				</li>
		<?php	}
		?>
		<li>
			<a class="fNiv <?=$ma?>" id="lihome" href="<?=base_url('home')?>"><?=MNUUSER_TITLEHOME?></a>
			<ul>
				<li class="arrow"></li>
				<li><a href="<?=base_url('home')?>"><?=MNUUSER_TITLEHOME?></a></li>
				<li id="tourHelp"><a href="<?=HREF_DEFAULT?>" action="tourActive"><?=HELP?></a></li>
				<li><a href="logout.php"><?=MNUUSER_TITLELOGOUT?></a></li>
			</ul>
			<div id="tourHome"></div>
		</li>
	</ul>
</div></div></menu>
<menu class="fright"><div class="_tt"><div class="_tc">
	<input type="search" id="txtSearchAll" name="txtSearchAll" placeholder="<?=FRIENDS_SEARCHFORFRIENDS_TITLEFOR?>"/>
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
				if (data=='no') {
					$('#tourHelp').hide();	
				};
			}
		});

		$('.mainMenu').jMenu();
		if (location.hash=='#carousel'){ $('#divAllNoti').slideUp(); }
        else{ $('#divAllNoti').slideDown(); }
		$('#divNoti').load('dialog?pageid=notifications');
		// $('#divNoti').load('view.php?page=users/notifications.php&dialog');
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
			if(item.category==='<?=SEARCHALL_PEOPLES?>'){
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
								'<span><img src="'+item.photo+'" alt="User" class="user" width="50" height="50"></span>'+
							'</div>'+
						'</a>');
			}else if(item.category==='<?=SEARCHALL_GROUPS?>'){
				item.url=BASEURL+'groupsDetails?grp='+item.id;
				$li.addClass('ui-autocomplete-group')
				.append('<a href="'+item.url+'"><img src="css/smt/menu_left/groups.png" alt="Groups Icons" title="Group" width="12" height="12">'+item.name+'</a>');
			}else if(item.category==='<?=SEARCHALL_HASTASH?>'){
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
			}else if(item.category==='<?=SEARCH_PRODUCT?>'){
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
				.append('<a href="'+item.url+'" title="<?=MNUUSER_SEARCHALL?>"><?=MNUUSER_ALLRESULTS?></a>');
			}else{
				$li.html(item.name);
			}
			return $li.appendTo(ul);
		};
	});
</script>
