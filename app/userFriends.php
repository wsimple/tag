<?php include 'inc/header.php'; ?>
<div id="page-friendUser" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<ul id="friendsList" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="friendsFooter">
				<li><a href="#" id="seek" onclick="redir(PAGE['findfriends'])"></a></li>
			</ul>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-friendUser',
			title:lan('friends','ucw'),
			buttons:{showmenu:true,creation:true},
			before:function(){
				$('#seek').html(lang.seek);
				$('#friendsFooter').prepend(
					'<li><a href="#" opc="friends">'+lan('friends','ucw')+'</a></li>'+
					'<li><a href="#" opc="follow">'+lan('admirers','ucw')+'</a></li>'+
					'<li><a href="#" opc="unfollow">'+lan('admired','ucw')+'</a></li>'
				);
			},
			after:function(){
				$('#page-friendUser .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
				console.log($_GET['type'])
				var opc={layer:'#friendsList',mod:$_GET['type']||'friends',get:"",user:$_GET['id_user']||''};
				$('#friendsFooter li a[opc='+$_GET['type']+']').addClass('ui-btn-active'); //Estilo de li activo
				$(opc.layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('.list-content input').keyup(function() {
					$('.list-wrapper').jScroll('refresh');
				});
				$(opc.layer).on('click','[code]',function(){
					redir(PAGE['profile']+'?id='+$(this).attr('code'));
				});
				linkUser(opc.layer);
				$('#friendsFooter').on('click','a[opc]',function(){
					opc.mod=$(this).attr('opc');
					viewFriends(opc);
					$('.list-content input').val('');
				});
				viewFriends(opc);
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
