<?php include 'inc/header.php'; ?>
<div id="page-lstStoreSubCategory" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1> -->
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;padding:0 5px;"></div>
	</div>
	<div data-role="content" class="list-content">
		<ul id="categotyList" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul>
	</div>
	<?php include 'inc/mainmenu.php'; ?>
	<!-- <div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div> -->
	<script>
		pageShow({
			id:'#page-lstStoreSubCategory',
			// title:lang.STORE_SUBCATEGORY,
			// backButton:true,
			before:function(){
				// $('#cart-footer ul').html(
				// 	'<li>'+
				// 		'<a class="ui-btn-active">'+
				// 			lang.STORE_VIEWORDERINCART+
				// 		'</a>'+
				// 	'</li>'
				// );
				$('#menu').html(
					'<span class="ui-block-a menu-button"><a href="storeCategory.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
					'<span class="ui-block-b menu-button hover" style="font-size: 9px;"><a href="storeMypublication.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('publications','ucw')+'</a></span>'+
					'<span class="ui-block-c"></span>'+
					'<span class="ui-block-d menu-button"><a href="storeOption.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('wishes','ucw')+'</a></span>'+
					'<span class="ui-block-e menu-button"><a href="storeCartList.html" title="cart"><img src="css/newdesign/menu/store.png"><br>'+lan('view cart','ucw')+'</a></span>'
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
				// $('#cart-footer ul li a').click(function(){
				// 	redir(PAGE['shoppingCart']);
				// });
				viewCategories(2,el,$_GET['id']);
				
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
