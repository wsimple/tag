<?php include 'inc/header.php'; ?>
<div id="page-lstMyStore" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1> -->
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;padding:0 5px;"></div>
	</div>
	<div data-role="content" class="list-content" style="margin: 50px 0 38px;">
		<div class="ui-listview-filter ui-bar-c" style="margin: auto;">
			<div id="rowTitle"><input type="search" name="search" id="searc-basic" value="" /></div>
		</div>
		<!-- <div>
			<ul data-role="listview" id="infoList" data-inset="false" data-divider-theme="b" class="list-info"></ul>
		</div> -->
		<div class="list-wrapper"><div id="scroller">
			<div><ul id="infoList" class="list-info ui-grid-a"></ul></div>
		</div></div>
	</div><!-- content -->
	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar">
			<ul></ul>
		</div>
	</div>
	<?php include 'inc/mainmenu.php'; ?>
<!--     <div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="storeNav">
				<li><a href="#" id="goBack" opc="1"></a></li>
				<!--<li><a href="#"  opc="2"></a></li>-->
			</ul>
		</div>
	</div> -->
	<script type="text/javascript">
		pageShow({
			id:'#page-lstMyStore',
			// title:lang['STORE_MYPUBLICATIONS'],
			// backButton:true,
			before:function(){
				//languaje
//				$('#category').html(lang.STORE_CATEGORY);
//				$('#btnGroupCreated').html(lang.GROUPS_TITLEWINDOWSNEW);
//				$('#searchPreferences').attr('placeholder',lang.PREFERENCES_HOLDERSEARCH);
				$('#cart-footer ul').html(
					'<li>'+
						'<a class="ui-btn-active">'+
							lang.STORE_VIEWORDERINCART+
						'</a>'+
					'</li>' 
				); 
                $('#menu').html(
					'<span class="ui-block-a menu-button"><a href="storeCategory.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
					'<span class="ui-block-b menu-button hover" style="font-size: 9px;"><a href="#"><img src="css/newdesign/submenu/store.png"><br>'+lan('publications','ucw')+'</a></span>'+
					'<span class="ui-block-c"></span>'+
					'<span class="ui-block-d menu-button"><a href="storeOption.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('wishes','ucw')+'</a></span>'+
					'<span class="ui-block-e menu-button"><a href="storeCartList.html" title="cart"><img src="css/newdesign/menu/store.png"><br>'+lan('view cart','ucw')+'</a></span>'
				);
				$('#searc-basic').attr('placeholder',lan('product search','ucw'));
			},
			after:function(){
				var layer='#infoList';
				// $(layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',layer).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(layer).on('click','li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro'));
				});				
                $('#storeNav').on('click','li a[opc]',function(){
					switch($(this).attr('opc')){
                        case '1': redir(PAGE['storeCat']); break;
//                        case '2': redir(PAGE['storeSubCate']+'?id='+$(this).attr('code')); break;
                    }
				});
				getMypublication(layer);
				var timeOut;
				function buscar(request,obj){
                limit=0;
                if (request!="" && obj.val().length>1) {
	                    getMypublication(layer,'&srh='+request);
	                }else if (obj.val().length==0){
                        getMypublication(layer);
	                }
	            }
				$('#searc-basic').keyup(function() {
					var request = $(this).val(),obj=$(this);
	                timeOut&&clearTimeout(timeOut);
	                timeOut=setTimeout(buscar(request,obj),1000);
				});
			}
		});
		function getMypublication(layer,get){
			//console.log(layer+'----'+id);
			myAjax({
				type	:'GET',
				url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module=store&limit=0&scc'+(get||''),
				dataType:'json',
				error	:function(/*resp,status,error*/){
					myDialog('#singleDialog',lang.conectionFail);
				},
				success	:function(data){
					if (!data['noB']){
						var out='',num=0,prod=data.prod,a='c';
						if (prod){
							for(var i=0;i<prod.length;i++){
								switch(a){
									case 'a': a='b';break;
									// case 'b': a='c';break;
									case 'b': a='a';break;
								} 
								out+='<li date="'+prod[i].join_date+'" idPro="'+prod[i].id+'" class="ui-block-'+a+'">'+
										'<a data-theme="e">'+
											'<img src="'+prod[i].photo+'">'+
											'<h3 class="name">'+prod[i].name+'</h3>'+
											'<h3 class="costProduct">'+prod[i].cost+' '+(prod[i].pago=="0"?'Pts':'$')+'</h3>'+
										'</a>'+
									'</li>';
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
