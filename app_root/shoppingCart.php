<?php include 'inc/header.php'; ?>
<div id="page-lstStoreShopping" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="buttonCheckOut" href="#" data-icon="arrow-l">&nbsp;</a>
	</div><!-- header -->
	<div data-role="content" class="list-content">
		<div>
			<div id="detailsShoppingCart"></div>
			<ul data-role="listview" id="infoListShopping" class="list-info"></ul>
		</div>
	</div><!-- content -->
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul>
				<li><a href="#" id="category"></a></li>
				<li><a href="#" id="deleteShopping"></a></li>
			</ul>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-lstStoreShopping',
			title:lang['STORE'],
			backButton:true,
			before:function(){
				//languaje
				$('#buttonCheckOut').html(lang.STORE_SHOPPING_CHECKOUT);
				$('#category').html(lang.STORE_SHOPPING_BACKLIST);
				$('#deleteShopping').html(lang.STORE_SHOPPING_DELETE);
				$('#shopping').html(lang.STORE_SHOPPING_CART);
				$('#btnGroupCreated').html(lang.GROUPS_TITLEWINDOWSNEW);
				$('#searchPreferences').attr('placeholder', lang.PREFERENCES_HOLDERSEARCH);
			},
			after:function(){
				var info='#infoListShopping';
				var details='#detailsShoppingCart';
				$(info).wrap('<div class="list-wrapper" style="margin-top:40px"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',info).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				function getShoppingProduct(info,details){
					myAjax({
						type	:'GET',
						url		:DOMINIO+'controls/store/shoppingCart.json.php?shop=1',
						dataType:'json',
						error	:function(/*resp,status,error*/){
							myDialog('#singleDialog', lang.conectionFail);
						},
						success	:function(data){
							if(data['nproduct']!='0'){
								var i,out='',outDe='',product,titleIndividual;
								for(i in data['datosCar']){
									product=data['datosCar'][i];
									titleIndividual=(product['nameSC'])?product['nameC']+'&nbsp;&nbsp;>&nbsp;&nbsp;'+product['nameSC']:product['nameC'];
									out+=
									'<li id="'+product['id']+'">'+
										'<div style=""><div id="img">'+
											'<img src="'+product['photo']+'" style="border:1px solid #ccc; height:60px; border-radius: 10px">'+
										'</div>'+
										'<div id="content">'+
											'<div id="nameProduct">'+product['name']+'</div>'+
											'<div id="midleDescription">'+
												'<div id="descripProduct"><span style="font-size:12px">'+product['nameUser']+'</span><br><span style="color:#666;">'+titleIndividual+'</span><br><span style="color:#666">'+lang.STORE_SHOPPING_POINTSMA+': </span> '+product['sale_points']+'</div>'+
												'<div id="trashShoppingCart" trash="'+product['id']+'"></div>'+
											'</div>'+
										'</div></div>'+
									'</li>';
								}
								outDe+=
								'<div>'+
									'<span>'+lang.STORE_SHOPPING_TOTAL+' '+data['nproduct']+'</span>'+
									'<span style="float:right;margin-right:10px"> '+lang.STORE_SHOPPING_TOTAL_PRODUCTS+' '+data['totalprice']+'<span>'+
								'</div>';
								$(details).html(outDe);
								$(info).html(out).listview('refresh');
								$('.list-wrapper').jScroll('refresh');
							}else{
								myDialog({
									id:'#emptyShopping',
									style:{'min-height':50},
									content:'<div id="emptyShopping"><span>'+lang.STORE_SHOPPING_NOITEMS+'</span></div>',
									scroll:true,
									buttons:{
										ok:function(){
											//redir(PAGE['storeCat']);
											goBack();
										}
									}
								});
							}
						}
					});
				}
				$(info).on('click','div[trash]',function(){
					var id=$(this).attr('trash');
					myAjax({
						type	:'GET',
						url		:DOMINIO+'controls/store/shoppingCart.json.php?action=3&id='+md5(id),
						dataType:'json',
						error	:function(/*resp, status, error*/){
							myDialog('#singleDialog', lang.conectionFail);
						},
						success	:function(data){
							myDialog({
								id:'#deleteIten',
								style:{'min-height':50},
								content:'<div id="deleteIten"><span>Delete Item: '+data['datosCar']+'?</span></div>',
								scroll:true,
								buttons:[{
									name:lang.yes,
									action:function(){
										var $this = this;
										myAjax({
											type	: 'GET',
											url		: DOMINIO+'controls/store/shoppingCart.json.php?action=2&id='+md5(id),
											dataType: 'json',
											error	: function(/*resp, status, error*/) {
												myDialog('#singleDialog', lang.conectionFail);
											},
											success: function(){
												$('#infoListShopping #'+id).fadeOut('slow');
												getShoppingProduct(info,details);
												$this.close();
											}
										});
									}
								},{
									name:'No',
									action: 'close'
								}]
							});
						}
					});
				});
				getShoppingProduct(info,details);
				$('#footer #category').click(function(){
					redir(PAGE['storeCat']);
				});
				$('#buttonCheckOut').click(function(){
					checkOutShoppingCart();
				});
				$('#footer #deleteShopping').click(function(){
					myDialog({
						id:'#deleteCart',
						style:{'min-height':50},
						content:'<div id="deleteCart"><span>'+lang.STORE_SHOPPING_DELETEALL+'</span></div>',
						scroll:true,
						buttons:[{
							name:lang.yes,
							action:function(){
								var $this = this;
								myAjax({
									type	:'GET',
									url		:DOMINIO+'controls/store/shoppingCart.json.php?action=2&all',
									dataType:'json',
									error	:function(/*resp,status,error*/){
										myDialog('#singleDialog',lang.conectionFail);
									},
									success	:function(){
										$('#infoListShopping').fadeOut('slow');
										getShoppingProduct(info,details);
										$this.close();
									}
								});
							}
						},{
							name:'No',
							action:'close'
						}]
					});
				});

			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
