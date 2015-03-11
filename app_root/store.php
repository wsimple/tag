<?php include 'inc/header.php'; ?>
<div id="page-lstStore" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-d"></div>
	</div>
	<div data-role="content" class="list-content" style="margin: 50px 0 38px;">
		<div class="ui-listview-filter ui-bar-c" style="margin: auto;">
			<div id="rowTitle"><input type="search" name="search" id="searc-basic" value="" /></div>
		</div>
		<div class="list-wrapper"><div id="scroller">
			<div><ul id="infoList" class="list-info ui-grid-a"></ul></div>
		</div></div>
	</div><!-- content -->
	<script type="text/javascript">
		pageShow({
			id:'#page-lstStore',
			// title:lang['STORE'],
			// backButton:true,
			before:function(){
				newMenu();
                menuStore();
				$('#searc-basic').attr('placeholder',lan('product search','ucw'));
			},
			after:function(){
				var layer='#infoList',category='',subcategory='';
				// $(layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',layer).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(layer).on('click','li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro'));
				});
				if ($_GET['c']!==undefined){
					category='&c='+$_GET['c'];
					if ($_GET['sc']!==undefined) subcategory='&sc='+$_GET['sc'];
				}
				getProducts(layer,category,subcategory);
				actionMenuStore();
				var timeOut;
				function buscar(request,obj){
                limit=0;
                if (request!="" && obj.val().length>1) {
	                    getProducts(layer,category,subcategory,'&srh='+request);
	                }else if (obj.val().length==0){
                        getProducts(layer,category,subcategory);
	                }
	            }
				$('#searc-basic').keyup(function() {
					var request = $(this).val(),obj=$(this);
	                timeOut&&clearTimeout(timeOut);
	                timeOut=setTimeout(buscar(request,obj),1000);
				});
			}
		});
	function getProducts(layer,category,subcategory,get){
		myAjax({
			type	:'GET',
			url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module=store&limit=0'+category+subcategory+(get||''),
			// url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module=store&limit=0&c='+category+'&sc='+subcategory,
			dataType:'json',
			error	:function(/*resp,status,error*/){
				myDialog('#singleDialog',lan('conectionFail'));
			},
			success	:function(data){
				if (data.prod){
					var out='',num=0,prod=data.prod,a='c';
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

					$(layer).html(out);
					$('.costProduct').formatCurrency({symbol:''}); //Formato de moneda
			        var cost=$('.costProduct').html();
			        var aux=cost.split('.');
			        $('.costProduct').html(aux[0]+' '+lang.STORE_SHOPPING_POINTS);
					
				}else $(layer).html('');
				$('.list-wrapper').jScroll('refresh');
			}
		});
	}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
