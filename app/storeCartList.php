<?php include 'inc/header.php'; ?>
<div id="page-lstStoreCarList" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="buttonCheckOut" href="#" data-icon="arrow-r">&nbsp;</a>
        <input id="dollarApp" value="no" type="hidden"/>
        <input id="productApp" value="no" type="hidden"/>
	</div>
	<div data-role="content" class="list-content">
		<ul id="cartList" data-role="listview" data-filter="true" data-divider-theme="b" class="list-friends"></ul>
	</div>
    <div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul>
				<li><a href="#" id="gotoStore"></a></li>
				<li><a href="#" id="gotoWish"></a></li>
                <li><a href="#" id="deleteShopping"></a></li>
			</ul>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-lstStoreCarList',
			title:lang.STORE_SHOPPING_CART,
			backButton:true,
			before:function(){
				$('#buttonCheckOut').html(lang.STORE_SHOPPING_CHECKOUT);
                $('#gotoStore').html(lan('store','ucw'));
                $('#gotoWish').html(lan('wish list','ucw'));
                $('#deleteShopping').html(lang.STORE_SHOPPING_DELETE);
			},
			after:function(){
				var el=$('#cartList')[0],msgShipp={msg:''};
				$(el).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',el).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(el).on('click','a[code]',function(){
					redir(PAGE['storePorduct']+'?sc='+$(this).attr('code')+'&c='+$_GET['id']);
				});
				getCartList(msgShipp);
				$('#buttonCheckOut').click(function(){
				    if ($('#dollarApp').val()=='si'){ myDialog('#singleDialog',lang.STORE_NOT_CHET_DOLLAR);}
                    else {
                        if ($('#productApp').val()=='si'){ 
                            if (msgShipp.msg!=''){
                                myDialog({
                        			id:'defaultDialog',
                                    content:msgShipp.msg+'<div>'+lang.STORE_SHIPPING_CHANGE+'</div>',
                        			buttons:[{
                                			name:lang.yes,
                                			action:function(){ redir(PAGE['storeOption']+'?option=1'); }
                                		},{
                                			name:'No',
                                			action:function(){ checkOutShoppingCart('&ned=1'); }
                                		},{
                                			name:lang.cancel,
                                			action:'close'
                                		}]
                        		});
                            }else{ redir(PAGE['storeOption']+'?option=1'); }
                        }else{ checkOutShoppingCart(); } 
                      }
				});
                $('#footer').on('click','li a',function(){
					switch($(this).attr('id')){
                        case 'gotoStore':   redir(PAGE['storeCat']); break;
                        case 'gotoWish':    redir(PAGE['storeOption']); break;
                    }
				});
                function getCartList(msgShipp){
                	myAjax({
                		type	:'GET',
                		url		:DOMINIO+'controls/store/shoppingCart.json.php?action=16&noEditS=1&shop=1',
                		dataType:'json',
                		error	:function(/*resp,status,error*/){
                			myDialog('#singleDialog',lang.conectionFail);
                		},
                		success	:function(data){
                			var out='';
                            if (data['datosCar'][0]['name']){
                                msgShipp.msg=data['msgShipp'];
                                out=bodyCart(data);                            
                                $('#cartList').html(out).listview('refresh');
                                var myselect = $( "select.cant-product" );
                                if (myselect){
                                    myselect.selectmenu();
                                    updateCantP(myselect);
                                }
                    			$('.list-wrapper').jScroll('refresh');
                                actionButtonsStore();
                                $('#deleteShopping').click(function(){
                                    if ($('#cartList li').length>0){
                                        myDialog({
                        					id:'#idDontStore',
                        					content:'<center><strong>'+lang.STORE_DELETESHOPPING+'</strong></center>',
                        					scroll:true,
                    						buttons:[{
                                                name:lang.yes,
                                                action:function(){ deleteAllCar(); }
                                            },{
                                                name:'No',
                                                action: 'close'
                                            }]
                        				});   
                                    }else{ myDialog('#singleDialog','<div><strong>'+lang.STORE_NO_SC+'</strong></div>'); }
                                });
                                if (data['bodyEmerg']){  myDialog('#singleDialog',data['bodyEmerg']); }
                            }else{ myDialog('#singleDialog','<div><strong>'+lang.STORE_NO_SC+'</strong></div>'); }
                		}
                	});
                }
                function deleteAllCar(){
                    var get='&all=1&mod=car',obj={mod:'car'};
                     deleteItemCar('1',get,obj);
                }
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
