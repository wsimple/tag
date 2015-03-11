<?php include 'inc/header.php'; ?>
<div id="page-lstStoreSubCategory" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1> -->
		<div id="menu" class="ui-grid-d"></div>
	</div>
	<div data-role="content" class="list-content">
		<ul id="categotyList" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
	</div>
	<script>
		pageShow({
			id:'#page-lstStoreSubCategory',
			before:function(){
				newMenu();
				menuStore();
			},
			after:function(){
				var el='#categotyList';
				$(el).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',el).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(el).on('click','a[code]',function(){
					redir(PAGE['storePorduct']+'?sc='+$(this).attr('code')+'&c='+$_GET['id']);
				});
				viewCategories(2,el,$_GET['id']);				
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
