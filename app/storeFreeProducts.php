<?php include 'inc/header.php'; ?>
<div id="page-freeProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1> -->
		<div id="menu" class="ui-grid-d"></div>
	</div>
	<div data-role="content" class="list-content">
		<div>
			<ul id="infoList" class="list-info ui-grid-a"></ul>
		</div>
	</div><!-- content -->
	<script type="text/javascript">
		pageShow({
			id:'#page-freeProducts',
			before:function(){
				newMenu();
                menuStore();
			},
			after:function(){
				var titles=[],indice=($_GET['module']!==undefined?$_GET['module']:'fp'),get='',action=3;
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
				switch(indice){
					case 'myPartiFp': get='&scc=2&myplays=1'; action=4; break;
					case 'myFp': get='&scc=2&my=1'; action=2; break;
				}
				getFreeProducts(layer,get,action);
			}
		});
		function getFreeProducts(layer,get,action){
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
					actionMenuStore(action);
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
