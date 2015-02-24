<?php include 'inc/header.php'; ?>
<div id="page-freeProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1> -->
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;padding:0 5px;"></div>
	</div>
	<div data-role="content" class="list-content">
		<div>
			<ul id="infoList" class="list-info ui-grid-a"></ul>
		</div>
	</div><!-- content -->
<!-- 	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="storeNav">
				<li><a href="#" id="goBack" opc="1"></a></li>
			</ul>
		</div>
	</div> -->
	<script type="text/javascript">
		pageShow({
			id:'#page-freeProducts',
			// title:lang['STORE_FREE_PRODUCTS'],
			// showmenuButton:true,
			before:function(){
				newMenu();
				//languaje
                // $('#storeNav #goBack').html(lang.goback+' '+lang.store);
                $('#menu').html(
					'<span class="ui-block-a menu-button hover"><a href="storeCategory.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
					// '<span class="ui-block-b menu-button" style="font-size: 9px;"><a href="storeMypublication.html" ><img src="css/newdesign/submenu/store.png"><br>'+lan('publications','ucw')+'</a></span>'+
					'<span class="ui-block-b"></span>'+
					'<span class="ui-block-c"></span>'+
					'<span class="ui-block-d menu-button"><a href="storeOption.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('wishes','ucw')+'</a></span>'+
					'<span class="ui-block-c menu-button cart" style="width: 20%;"><a href="storeCartList.html" title="cart"><span></span><img src="css/newdesign/menu/store.png"><br>'+lan('view cart','ucw')+'</a></span>'
				);
			},
			after:function(){
				var titles=[],indice=($_GET['module']!==undefined?$_GET['module']:'fp'),get='';
				titles['fp']=lang['STORE_FREE_PRODUCTS'];
				titles['myPartiFp']=lang['STORE_RAFFLES_PLAYS'];
				titles['myFp']=lang['STORE_MY_FREE_PRODUCTS'];
				console.log(titles[indice]);
				$('div[data-role="header"] h1').html(titles[indice]);
				var layer='#infoList';
				$(layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',layer).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(layer).on('click','li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro')+'&fp=1');
				});				
    //             $('#storeNav').on('click','li a[opc]',function(){
				// 	 redir(PAGE['storeCat']);
				// });
				switch(indice){
					case 'myPartiFp': get='&scc=2&myplays=1'; break;
					case 'myFp': get='&scc=2&my=1'; break;
				}
				getFreeProducts(layer,get);
			}
		});
		function getFreeProducts(layer,get){
			myAjax({
				type	:'GET',
				url		:DOMINIO+'controls/store/listProd.json.php?module=raffle&limit=0&source=mobile'+get,
				dataType:'json',
				error	:function(/*resp,status,error*/){
					myDialog('#singleDialog',lang.conectionFail);
				},
				success	:function(data){
					var out='',num=0,prod=data['prod'],a='c';
					if (prod){
						for(var i=0;i<prod.length;i++){
							switch(a){
								case 'a': a='b';break;
								// case 'b': a='c';break;
								case 'b': a='a';break;
							} 
							out+=
								// (num++<1?' <li data-role="list-divider" style="padding: 12px 0"></li>':'')+
								'<li date="'+prod[i]['start_date']+'" idPro="'+prod[i]['id']+'" class="ui-block-'+a+'">'+
									'<a data-theme="e">'+
										'<img src="'+prod[i]['photo']+'">'+
										'<h3 id="name">'+prod[i]['name']+'</h3>'+
										'<h3 class="costProduct">'+prod[i]['points']+' Pts</h3>'+
										// '<h3 class="descripProduct"><strong>'+lang.STORE_FREE_PRODUCTS_NUM_USERS+':</strong>'+prod[i]['cant_users']+'</h3>'+
										'<h3 class="date">'+lan('start','ucw')+': '+(prod[i]['start_date'].split(' '))[0]+'</h3>'+
									'</a>'+
								'</li>';
						}
						$(layer).html(out);
						$('.list-wrapper').jScroll('refresh');
					}else myDialog('#singleDialog',lang.STORE_NOSTORE_MESSAGE);
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
