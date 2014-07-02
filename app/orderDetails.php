<?php include 'inc/header.php'; ?>
<div id="page-lstStoreShoppingOrder" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="buttonClose" href="#" data-icon="arrow-l">&nbsp;</a>
	</div><!-- header -->
	<div data-role="content" class="list-content">
		<div>
			<div id="detailsTitle"></div>
			<div id="detailsOrder"></div>
			<ul data-role="listview" id="infoListShopping" class="list-info"></ul>
		</div>
	</div><!-- content -->
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar"></div>
	</div>
	<script type="text/javascript">
		pageShow({
			id:'#page-lstStoreShoppingOrder',
			title:lang.STORE_SHOPPING_ORDER,
			before:function(){
				//languaje
				$('#buttonBack_groups').html(lan('Back'));
				$('#buttonClose').html(lang.home);
				$('#category').html(lang.STORE_CATEGORY);
				$('#shopping').html(lang.STORE_SHOPPING_CART);
			},
			after:function(){

				var info='#infoListShopping';
				var detailstitle='#detailsTitle';
				var detailsOrder='#detailsOrder';

				$(info).wrap('<div class="list-wrapper" style="margin-top:100px"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',info).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});

				function getOrderDetails(info,detailsOrder,detailstitle,nOrden){
					myAjax({
						type	: 'GET',
						url		: DOMINIO+'controls/store/orderDetails.json.php?nOrden='+nOrden,
						dataType: 'json',
						error	: function(/*resp, status, error*/){
							myDialog('#singleDialog', lang.conectionFail);
						},
						success	: function(data){
								var out='',outDeOrder='',outDeTitle,order,details;
								outDeTitle ='<div>'+lang.STORE_SHOPPING_DETAILS+'<div>';
								details = data['datosOrder'][0];

								outDeOrder ='<div>'+lang.STORE_SHOPPING_NUMORDER+': <span style="color:#F82">'+details['id_order']+'</span> <span style="float:right; padding-right:15px">Fecha: <span style="color:#F82">'+data['orderDate']+'</span></span><div>'+
											'<div>'+lang.STORE_SHOPPING_TOTAL+' <span style="color:#F82">'+data['nproduct']+'</span><div>'+
											'<div>'+lang.STORE_SHOPPING_TOTAL_PRODUCTS+' <span style="color:#F82">'+data['total']+'</span><div><br>';

								$(detailstitle).html(outDeTitle);
								$(detailsOrder).html(outDeOrder);

								for(i in data['datosOrder']){
									order = data['datosOrder'][i];

									out +=
										'<li id="'+order['id_order']+'">'+
											'<div><div id="img">'+
												'<img src="'+order['photo']+'" style="border:1px solid #ccc; height:60px; border-radius: 10px">'+
											'</div>'+
											'<div id="content">'+
												'<div id="nameProduct">'+order['nameProduct']+'</div>'+
												'<div id="midleDescription">'+
													'<div id="descripProduct"><span style="font-size:12px">'+order['nameUser']+'</span><br>'+
													'<span style="color:#666">'+lang.STORE_SHOPPING_POINTSMA+': </span> '+order['sale_points']+'</div>'+
												'</div>'+
											'</div></div>'+

										'</li>';
								}
								$(info).html(out).listview('refresh');
								$('.list-wrapper').jScroll('refresh');

						}
					});
				}

				getOrderDetails(info,detailsOrder,detailstitle,$_GET['nOrden']);

				$('#buttonClose').click(function(){
					myAjax({
						type	: 'GET',
						url		: DOMINIO+'controls/store/orderDetails.json.php?outShopping=1',
						dataType: 'json',
						error	: function(/*resp, status, error*/) {
							myDialog('#singleDialog', lang.conectionFail);
						},
						success	: function(){
							redir(PAGE['timeline']);
						}
					});
				});

			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
