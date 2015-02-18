<?php include 'inc/header.php'; ?>
<div id="page-lstStoreCategory" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1> -->
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;padding:0 5px;"></div>
	</div>
	<div data-role="content" class="list-content">
		<ul id="categotyList" data-role="listview" data-filter="true" data-divider-theme="b" class="list-friends"></ul>
	</div>
<!-- 	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div> -->
	<script>
		pageShow({
			id:'#page-lstStoreCategory',
			title:lang.STORE_CATEGORYS,
			// showmenuButton:true,
			before:function(){
				// $('#buttonShopping').html(lang.STORE_CART);
				newMenu();
				$('#menu').html(
					'<span class="ui-block-a menu-button hover"><a href="#"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
					// '<span class="ui-block-b menu-button" style="font-size: 9px;"><a href="storeMypublication.html" ><img src="css/newdesign/submenu/store.png"><br>'+lan('publications','ucw')+'</a></span>'+
					'<span class="ui-block-b"></span>'+
					'<span class="ui-block-c"></span>'+
					'<span class="ui-block-d menu-button"><a href="storeOption.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('wishes','ucw')+'</a></span>'+
					'<span class="ui-block-c menu-button cart" style="width: 20%;"><a href="storeCartList.html" title="cart"><span></span><img src="css/newdesign/menu/store.png"><br>'+lan('cart','ucw')+'</a></span>'
				);
				// $('#cart-footer ul').html(
				// 	'<li>'+
				// 		'<a class="ui-btn-active">'+
				// 			lang.STORE_VIEWORDERINCART+
				// 		'</a>'+
				// 	'</li>'
				// );
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
				// $('#buttonShopping').click(function(){
				// 	goShoppingCart();
				// });
				// $('#cart-footer ul li a').click(function(){
				// 	redir(PAGE['shoppingCart']);
				// });
				viewCategories(1,el,'');
				numItemsCart();
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
