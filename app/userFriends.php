<?php include 'inc/header.php'; ?>
<style>
	.ui-page .ui-content{
		margin: 4px 0;
	}
</style>
<div id="page-friendUser" data-role="page" data-cache="false">
	<div  data-role="header" data-theme="f" data-position="fixed">
		<div id="menu" class="ui-grid-c" style="top:0px;left:0;padding:0 5px;"></div>
	</div>
	<?php include 'inc/mainmenu.php'; ?>
	<div data-role="content" class="list-content">
		<div class="list-wrapper">
			<div id="scroller">
				<div id="friends" class="list">
					<ul class="list-friends ui-grid-b"></ul>
				</div>
				<div id="follow" class="list">
					<ul data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
				</div>
				<div id="unfollow" class="list">
					<ul data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
				</div>
			</div>
		</div>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="friendsFooter">
				<li><a href="#" id="seek" onclick="redir(PAGE['findfriends'])"></a></li>
			</ul>
		</div>
	</div>
</div>
<script>
	pageShow({
		id:'#page-friendUser',
		title:lan('friends','ucw'),
		buttons:{showmenu:false,creation:false},
		before:function(){
			$('#seek').html(lang.seek);
			$('#menu').html(
				'<span class="ui-block-a menu-button"><a href="#"><img src="css/newdesign/friends.png"><br>'+lan('friends','ucw')+'</a></span>'+
				'<span class="ui-block-b"></span>'+
				'<span class="ui-block-c menu-button">'+lan('Suggest','ucw')+'</span>'+
				'<span class="ui-block-d menu-button"><a href="#" title="Search"><img src="css/newdesign/search.png"><br>'+lan('search','ucw')+'</a></span>'
			);
			$('#friendsFooter').html(
				'<li><a href="#" opc="friends">'+lan('friends','ucw')+'</a></li>'+
				'<li><a href="#" opc="follow">'+lan('admirers','ucw')+'</a></li>'+
				'<li><a href="#" opc="unfollow">'+lan('admired','ucw')+'</a></li>'
			).find('li a:first').addClass('ui-btn-active');
		},
		after:function(){
			$('#page-friendUser .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
			var $wrapper=$('.list-wrapper'), pag=1,perpag=20,
				type=$_GET['type']||'friends',
				opc={wrapper: $wrapper,get:'&offset='+perpag,user:$_GET['id_user']||'',perpag:20},
				modaux='',layeraux=null;

			$('#friendsFooter li a[opc='+$_GET['type']+']').addClass('ui-btn-active'); //Estilo de li activo
			// $(opc.layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
			$('.list-wrapper').jScroll({hScroll:false});
			$('.list-content input').keyup(function() {
				$('.list-wrapper').jScroll('refresh');
			});


			$(this.id).on('click','#seemore', function(event) {
				opc.get = '&offset='+perpag+'&limit='+(perpag*pag++);
				viewFriends('more',$.extend({mod:modaux,layer:layeraux},opc));
			});
			
			$(this.id).on('click','.ui-navbar a[opc]',function(){
				type=$(this).attr('opc');
				modaux=type;
				layeraux='#'+type+' ul';
				pag = Math.round( $(layeraux+' .userInList').length/perpag );
				if (pag == 0) { pag = 1};
				$wrapper.jScroll(function(){
					this.scrollTo(0,0,100);
				}).jScroll('refresh');
				$('#scroller > .list').hide();
				$('#'+type+'.list').show();
				$('.list-content input').val('');
			});

			$('.ui-navbar a[opc='+type+']').click();
			viewFriends('refresh',$.extend({mod:'friends',layer:'#friends ul'},opc));
			viewFriends('refresh',$.extend({mod:'follow',layer:'#follow ul'},opc));
			viewFriends('refresh',$.extend({mod:'unfollow',layer:'#unfollow ul'},opc));

			$(this.id).on('click','[code]',function(){
				redir(PAGE['profile']+'?id='+$(this).attr('code'));
			});
			linkUser(this.id, $wrapper);
		}
	});
</script>
<?php include 'inc/footer.php'; ?>
