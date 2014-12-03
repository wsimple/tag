<?php include 'inc/header.php'; ?>
<div id="page-friendUser" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown" style="display:none;"></div>
				<ul id="friendsList" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
				<div id="pullUp"><div class="smt-tag-content"><span class="pullUpIcon"></span><span class="pullUpLabel"></span></div></div>
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
		buttons:{showmenu:true,creation:true},
		before:function(){
			$('#seek').html(lang.seek);
			$('#friendsFooter,.list-content #friends ul').html(
				'<li><a href="#" opc="friends">'+lan('friends','ucw')+'</a></li>'+
				'<li><a href="#" opc="follow">'+lan('admirers','ucw')+'</a></li>'+
				'<li><a href="#" opc="unfollow">'+lan('admired','ucw')+'</a></li>'
			).find('li a:first').addClass('ui-btn-active');
		},
		after:function(){
			$('#page-friendUser .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
			var opc={layer:'#friendsList',mod:$_GET['type']||'friends',get:"",user:$_GET['id_user']||''},
			$wrapper=$('#pd-wrapper',this.id);

			$('#friendsFooter li a[opc='+$_GET['type']+']').addClass('ui-btn-active'); //Estilo de li activo
			// $(opc.layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
			// $('.list-wrapper').jScroll({hScroll:false});
			$('.list-content input').keyup(function() {
				// $('.list-wrapper').jScroll('refresh');
				$wrapper.jScroll('refresh');
			});
			$(opc.layer).on('click','[code]',function(){
				redir(PAGE['profile']+'?id='+$(this).attr('code'));
			});
			linkUser(opc.layer);

			$(this.id).on('click','.ui-navbar a[opc]',function(){
				opc.mod=$(this).attr('opc');
				viewFriends('refresh',opc);
				$('.list-content input').val('');
			});
			viewFriends('refresh',opc);
			var i = 1, page = 50;
			$wrapper.ptrScroll({
				onPullUp:function(){
					opc.get = '&limit='+(page*i++);
					console.log(opc.get)
					var response = viewFriends('more',opc);
					if (!response) {
						$wrapper.jScroll('refresh');
					}
				},
				onReload:function(){
					viewFriends('refresh',opc);
				}
			});
		}
	});
</script>
<?php include 'inc/footer.php'; ?>
