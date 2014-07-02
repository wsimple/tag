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
			buttons:{back:true,home:true},
			before:function(){
				$('#seek').html(lang.seek);
				$('#friendsFooter').prepend(
					'<li><a href="#" opc="1">'+lan('friends','ucw')+'</a></li>'+
					'<li><a href="#" opc="2">'+lan('admirers','ucw')+'</a></li>'+
					'<li><a href="#" opc="3">'+lan('admired','ucw')+'</a></li>'
				);
			},
			after:function(){
				var el='#friendsList';
				$(el).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('.list-content input').keyup(function() {
					$('.list-wrapper').jScroll('refresh');
				});
				$(el).on('click','a[code]',function(){
					redir(PAGE['profile']+'?id='+$(this).attr('code'));
				});
				$('#friendsFooter').on('click','a[opc]',function(){
					viewFriends($(this).attr('opc'),'',el, $_GET['id_user']);
					$('.list-content input').val('');
				});
				viewFriends($_GET['type']||1,'',el, $_GET['id_user']);
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
