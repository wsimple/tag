<?php include 'inc/header.php'; ?>
<div id="page-lstStoreCategory" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
	</div>
	<div data-role="content" class="list-content">
		<ul id="categotyList" data-role="listview" data-filter="true" data-divider-theme="b" class="list-friends"></ul>
	</div>
	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div>
	<script>
		pageShow({
			id:'#page-lstStoreCategory',
			title:lang.STORE_CATEGORYS,
			showmenuButton:true,
			before:function(){
				$('#buttonShopping').html(lang.STORE_CART);
				$('#cart-footer ul').html(
					'<li>'+
						'<a class="ui-btn-active">'+
							lang.STORE_VIEWORDERINCART+
						'</a>'+
					'</li>'
				);
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
				$('#buttonShopping').click(function(){
					goShoppingCart();
				});
				$('#cart-footer ul li a').click(function(){
					redir(PAGE['shoppingCart']);
				});
				viewCategories(1,el,'');

			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
