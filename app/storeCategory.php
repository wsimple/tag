<?php include 'inc/header.php'; ?>
<div id="page-lstStoreCategory" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-d"></div>
	</div>
	<div data-role="content" class="list-content">
		<ul id="categotyList" data-role="listview" data-filter="true" data-divider-theme="b" class="list-friends"></ul>
	</div>
	<script>
		pageShow({
			id:'#page-lstStoreCategory',
			title:lang.STORE_CATEGORYS,
			before:function(){
				newMenu();
				menuStore();
			},
			after:function(){
				$('#page-lstStoreCategory .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
				var el='#categotyList';
				$(el).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',el).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(el).on('click','a[code]',function(){
					redir(PAGE['storeSubCate']+'?id='+$(this).attr('code'));
				}).on('click','a[codePro]',function(){
					redir(PAGE['storePorduct']+'?idCat='+$(this).attr('codePro'));
				});
				viewCategories(1,el,'');			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
