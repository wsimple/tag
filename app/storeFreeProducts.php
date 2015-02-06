<?php include 'inc/header.php'; ?>
<div id="page-freeProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div>
			<ul data-role="listview" id="infoList" data-inset="false" data-divider-theme="b" class="list-info"></ul>
		</div>
	</div><!-- content -->
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="storeNav">
				<li><a href="#" id="goBack" opc="1"></a></li>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		pageShow({
			id:'#page-freeProducts',
			title:lang['STORE_FREE_PRODUCTS'],
			showmenuButton:true,
			before:function(){
				//languaje
                $('#storeNav #goBack').html(lang.goback+' '+lang.store);
			},
			after:function(){
				var titles=[],indice=($_GET['module']!==undefined?$_GET['module']:'fp'),get='';
				titles['fp']=lang['STORE_FREE_PRODUCTS'];
				titles['myPartiFp']=lang['STORE_RAFFLES_PLAYS'];
				titles['myFp']=lang['STORE_RAFFLES_PLAYS'];
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
                $('#storeNav').on('click','li a[opc]',function(){
					 redir(PAGE['storeCat']);
				});
				switch(indice){
					case 'myPartiFp': get='&scc=2&myplays=1'; break;
					case 'myFp': get='&scc=2&myplays=1'; break;
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
					var out='',num=0,prod=data['prod'];
					if (prod){
						for(var i=0;i<prod.length;i++){
							out+=
								(num++<1?' <li data-role="list-divider" style="padding: 12px 0"></li>':'')+
								'<li date="'+prod[i]['start_date']+'" idPro="'+prod[i]['id']+'">'+
									'<a><img src="'+prod[i]['photo']+'" style="width:100px;height:60px;margin:20px 0 0 8px;border-radius:10px">'+
										'<p id="nameProduct">'+prod[i]['name']+'</p>'+
										'<p class="descripProduct"><strong>'+lang.STORE_SHOPPING_VALUE+':</strong>'+prod[i]['points']+'</p>'+
										'<p class="descripProduct"><strong>'+lang.STORE_FREE_PRODUCTS_NUM_USERS+':</strong>'+prod[i]['cant_users']+'</p>'+
										'<p class="date"><strong>'+lan('start date','ucw')+':</strong> '+prod[i]['start_date']+'</p>'+
									'</a>'+
								'</li>';
						}
						$(layer).html(out).listview('refresh');
						$('.list-wrapper').jScroll('refresh');
					}else myDialog('#singleDialog',lang.STORE_NOSTORE_MESSAGE);
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
