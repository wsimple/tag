<?php include 'inc/header.php'; ?>
<div id="page-lstStoreSubCategory" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<ul id="categotyList" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
	</div>
	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div>
	<script>
		pageShow({
			id:'#page-lstStoreSubCategory',
			title:lang.STORE_SUBCATEGORY,
			backButton:true,
			before:function(){
				$('#cart-footer ul').html(
					'<li>'+
						'<a class="ui-btn-active">'+
							lang.STORE_VIEWORDERINCART+
						'</a>'+
					'</li>'
				);
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
				$('#cart-footer ul li a').click(function(){
					redir(PAGE['shoppingCart']);
				});
				viewCategories(2,el,$_GET['id']);
				
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
