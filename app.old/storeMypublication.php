<?php include 'inc/header.php'; ?>
<div id="page-lstMyStore" data-role="page" data-cache="false" class="no-footer no-header">
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
				<!--<li><a href="#"  opc="2"></a></li>-->
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		pageShow({
			id:'#page-lstMyStore',
			title:lang['STORE_MYPUBLICATIONS'],
			showmenuButton:true,
			before:function(){
                $('#storeNav #goBack').html(lang.goback+' '+lang.store);
			},
			after:function(){
				var layer='#infoList';
				$(layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',layer).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(layer).on('click','li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro'));
				});				
                $('#storeNav').on('click','li a[opc]',function(){
                	redir(PAGE['storeCat']); 
				});
				getMypublication(layer);
			}
		});
		function getMypublication(layer){
			//console.log(layer+'----'+id);
			myAjax({
				type	:'GET',
				url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module=store&limit=0&scc',
				dataType:'json',
				error	:function(/*resp,status,error*/){
					myDialog('#singleDialog',lang.conectionFail);
				},
				success	:function(data){
					if (!data['noB']){
						var out='',num=0,prod=data['prod'],category,idcategory;
						if (prod){
							for(var i=0;i<prod.length;i++){
								out+=
									(num++<1?' <li data-role="list-divider" style="padding: 12px 0"></li>':'')+
									'<li date="'+prod[i]['join_date']+'" idPro="'+prod[i]['id']+'">'+
										'<a><img src="'+prod[i]['photo']+'" style="width:100px;height:60px;margin:20px 0 0 8px;border-radius:10px">'+
											'<p id="nameProduct">'+prod[i]['name']+'</p>'+
											'<p id="descripProduct">'+prod[i]['description']+'</p>'+
											'<p class="date"><strong>Published:</strong> '+prod[i]['join_date']+'</p>'+
										'</a>'+
									'</li>';
								category=prod[i]['category'];
								idcategory=prod[i]['mid_category'];
							}
							$(layer).html(out).listview('refresh');
							//$('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+category+'</span></span>').attr('code',idcategory);
							$('.list-wrapper').jScroll('refresh');
						}else myDialog('#singleDialog',lang.STORE_NOSTORE_MESSAGE);
					}else myDialog('#singleDialog',lang.STORE_NO_AB);
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
