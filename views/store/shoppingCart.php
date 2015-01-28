<?php
	//valida el menu left
	$numIt=createSessionCar('','','count');
	$numOrder=$_SESSION['store']['order']?$_SESSION['store']['order']:'';
    $numWish=$_SESSION['store']['wish']?$_SESSION['store']['wish']:'';
	$numSales=$_SESSION['store']['sales']?$_SESSION['store']['sales']:''; 
	$radio='';
	if (!isset($_GET['radio'])){ $radio="all"; }
    else{
		switch ($_GET['radio']){
            case 'act':case 'pend':case 'fins': $radio=$_GET['radio']; break;
			default : $radio="all";
		}
	}
?>
<div id="shoppingCId" class="ui-single-box" style="min-height: 915px;">
	<div class="ui-single-box-title" >
		<a href="<?=base_url('store')?>"><?=STORE_TITLE.' '?></a><span>&nbsp;>&nbsp;</span>
		<span id="storeTitle"></span>
	</div>
	<div>
        <div id="list_orderProduct"></div>
        <div class="clearfix"></div>
        <div id="second-panel-shopping" style="display:none;">
            <div class="totalPointsSC">
                <input id="buyOrder2" type="button" value="<?=$lang['STORE_PROCEED']?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div id="list_orderProduct_wish" ></div>
        <div class="clearfix"></div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$.on({
			open:function(){
			     $('#totalANDsugestProduct').css('display','block');
				//colocarle el numero al shoppinh car
				var numIt='<?=$numIt?>',numOrder='<?=$numOrder?>',numSales='<?=$numSales?>',numWish='<?=$numWish?>';
				if (numIt!='0' && numIt !=''){
					$('#menu-lshoppingCart').html(numIt).css('display','block');
					$('#menu-l-li-shoppingCart').css('display','list-item');
				}
                if (numOrder!=''){ $('.menu-l-youOrders').css('display','list-item'); }
                //if (numWish!=''){ $('#menu-l-li-wishList').css('display','list-item'); }
                if (numSales!=''){ $('.menu-l-youSales').css('display','list-item'); } 
			////////////////////////////////////////////////////////////////////////////
				var noProduct="<?=$_GET['no-product']?$_GET['no-product']:''?>";
				if (noProduct!=''){ message('ordenAlter', '<?=SIGNUP_CTRTITLEMSGNOEXITO?>', '<?=STORE_ORDER_EDIT_STOCK?>', '', 250, 200); }
				switch(SECTION){
					case 'orders': case 'sales':
						var getyear="<?=($_GET['year']?$_GET['year']:'')?>",getmonth="<?=($_GET['month']?$_GET['month']:'')?>",idOrders="<?=($_GET['idOrdes']?$_GET['idOrdes']:'')?>",radio='<?=$radio?>',get='';
						
						//armar la caja de resumen
						$('#ordersProces').html('<article id="filter_by_date" class="side-box shop"">'
	                                               +'<header><span><?=STORE_SUMMARY?></span></header>'
            										+'<div id="filter_by_years"></div>'
            										+'<div id="filter_by_month"></div>'
            										+'<div id="summary">'
            											+'<strong><?=STORE_SUMMARY_QUANTITYORDERS.': '?></strong><br><span id="q_ordes" class="nameSP"></span><br>'
            											+'<strong><?=STORE_SUMMARY_QUANTITYITEMS.': '?></strong><br><span id="q_items" class="nameSP"></span><br>'
            											+'<span id="t_points" ><strong><?=TOTAL.' '.STORE_TITLEPOINTS.': '?></strong><br><span class="nameSP"></span><br></span>'
            											+'<span id="t_dollars" ><strong><?=TOTAL.' '.TYPEPRICEMONEY.': '?></strong><br><span class="nameSP"></span><br></span>'
            										+'</div>'
            										+'</article>');
						var option='';
						if (idOrders==''){
							get=((getyear!='')?'&year='+getyear+((getmonth!='')?'&month='+getmonth:''):'');
							if (radio!='all' && radio) get+='&radio='+radio;
						}else{
							get='&orderId='+idOrders+'&option=orders';
							//$('#divSubMenuAdminFilters').remove();
						}
						if (SECTION=='orders'){
							$('#storeTitle').html('<?=STORE_YOURORDES?>');
							option='orders';
							orderProcessed(get);
						}else{
							option='sales';
							$('#storeTitle').html('<?=STORE_SALES?>');
							salesProcessed(get);
							$('input#btnAct,label#labelAct').remove();
						}
						getfiltrosOrderOrSales(option,radio);
						//armar la lista de los años y meses
						var fechas=[];
						$.ajax({
							type: 'GET',
							url: 'controls/store/shoppingCart.json.php?action=10&option='+option+'&radio='+radio,
							dataType: 'json',
							success: function(data){
								fechas=data['datosCar'];
								armarSelect(fechas,getyear,getmonth);							
							}
						});

						$('#headerStoreCar').css('display','none');
						$('#makeSugesStoreProducts').css('margin-top','10px');
						$('#filter_by_date').css('margin-top','13px');
						$('.right-panel #totalANDsugestProduct').on('change','#filter_by_years select',function(){
							armarSelect(fechas,$(this).val());
                            if($('#filter_by_month select option').length==1){
                                redir(option+'?'+(radio!='all'?'radio='+radio+'&':'')+'year='+$(this).val()+'&month='+$('#filter_by_month select').val());
                            }
						}).on('change','#filter_by_month select',function(){
							redir(option+'?'+(radio!='all'?'radio='+radio+'&':'')+'year='+$('#filter_by_years select').val()+'&month='+$(this).val());
						}).on('change','#divSubMenuAdminFilters select',function(){
							var value=$(this).val();
							switch(value){
								case 'pend': redir(option+'?radio=pend');break;
								case 'fins': redir(option+'?radio=fins');break;
								default: redir(option);
							}
						});
//						$('#btnAll a').live('click',function(){
//							redir(option);
//						});
//						$('#btnPend a').live('click',function(){
//							redir(option+'?radio=pend');
////							redir(option+'?radio=pend'+((getyear!='')?'&year='+getyear+((getmonth!='')?'&month='+getmonth:''):''));
//						});
//						$('#btnFins a').live('click',function(){
//							redir(option+'?radio=fins');
////							redir(option+'?radio=fins'+((getyear!='')?'&year='+getyear+((getmonth!='')?'&month='+getmonth:''):''));
//						});
						$('#shoppingCId').on('click','span.nameSP a.delete',function(){
							var h=$(this).attr('h'), get='&all=1',obj={};
							if (h==1){ get+='&mod=car'; }
                            else{ get+='&mod=pay&idOrder='+h; }
                            deleteOrderC(get,obj);
						}).on('click','span.nameSP a.pay',function(){
							document.location = 'views/pay.view.php?payAcc=store&idOrder='+$(this).attr("h");
						});
					break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
					case 'wishList':
						makeListWish();
						$('#storeTitle').html('<?=STORE_WISH_LIST?>');
                        $('#headerStoreCar').css('display','none');
                        $('#shoppingCId').on('click','div.lis_product_store_details span.addToCar',function(){
                            var spanAction=$(this).next('span.deleteItemCar');
                            var actionspan=$(spanAction).attr('action');
                            $(spanAction).removeAttr('action');
                            $.ajax({
                                type: 'GET',
                                url: 'controls/store/shoppingCart.json.php?action=1&add=si&id='+$(this).attr("h"),
                                dataType: 'json',
                                success: function(data){
                                    if (data['datosCar2']['add']=='si'){
                                        if (data['datosCar2']['order']){
                                            $.dialog({
                                                title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                                content	: data['datosCar2']['order'],
                                                height	: 220,
                                                width	: 300,
                                                close	: function(){
                                                    redir('shoppingcart');
                                                }
                                            });
                                        }else{ redir('shoppingcart'); }
                                    }else if (data['datosCar2']['add']=='no'){
                                        $(spanAction).attr('action',actionspan);
                                        switch(data['datosCar2']['msg']){
                                            case 'no-disponible': 
                                                $.dialog({
                                                    title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                                    content	: '<?=STORE_PRODUCTO_NO_STATUS?>',
                                                    height	: 200,
                                                    close	: function(){
                                                        $.loader('show');
                                                        location.reload();
                                                    }
                                                });
                                                break;
                                            case 'backg': 
                                                    message('information','<?=SIGNUP_CTRTITLEMSGNOEXITO?>','<?=STORE_UNI_BACKG?>','',300,220);
                                                break;
                                            case 'no-stock': 
                                                $.dialog({
                                                    title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                                    content	: '<?=STORE_PRODUCTO_NO_STOCK?>',
                                                    height	: 200
                                                });
                                                break;
                                            case 'no-product': break;
                                        }
                                    }
                                }
                            });
                        });
					break;
//*****************************************************************shopping cart**********************************************//
					default:
						$('#storeTitle').html('<?=STORE_SHOPPINGCART?>'); 
						makeShopingCar();
						$('#shoppingCId').on('change','select.cant-product',function(){
							var cantAct=$(this).val(),tipo=$(this).attr('fr'),totalAnt=$(this).attr('cantAct'),
								price=$(this).attr('precio'),diferencia=0,objeto=$(this);
								diferencia=cantAct*price;
							$.ajax({
                                type: 'POST',
                                url: 'controls/store/shoppingCart.json.php?action=15&linea='+objeto.attr('linia')+'&cant='+objeto.val(),
                                dataType: 'json',
                                success: function(data){
                                    if (data['datosCar']=='update'){
                                        if (tipo==1){
                                            var	totalAct=$('#moveTotalMoney').val();
                                            objeto.attr('cantAct',diferencia);
                                            $('#moveTotalMoney').val((totalAct-(totalAnt))+(diferencia));
                                            $('#totalPriceMoney').html((totalAct-(totalAnt))+(diferencia)).formatCurrency({symbol:''});
                                        }else{
                                            var	totalAct=$('#moveTotal').val();
                                            objeto.attr('cantAct',diferencia);
                                            $('#moveTotal').val((totalAct-(totalAnt))+(diferencia));
                                            $('#totalPrice').html((totalAct-(totalAnt))+(diferencia)).formatCurrency({symbol:''});
                                            var auxi=$('#totalPrice').html().split('.');
                                            $('#totalPrice').html(auxi[0]);
                                        }
                                    }else{
                                        $.dialog({
                                            title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                            content	: '<?=STORE_ORDER_EDIT_STOCK?>',
                                            close	:function(){
                                                location.reload();
                                            }
                                        });
                                    }
                                }
                            });
						}).on('click','div.lis_product_store_details span.addToCar',function(e){
                            var spanAction=$(this).next('span.deleteItemCar');
                            var actionspan=$(spanAction).attr('action');
                            $(spanAction).removeAttr('action');
                            $.ajax({
                                type: 'GET',
                                url: 'controls/store/shoppingCart.json.php?action=1&add=si&id='+$(this).attr("h")+'&shop=1',
                                dataType: 'json',
                                success: function(data){
                                    if (data['datosCar2']['add']=='si'){
                                        $('#menu-lshoppingCart').html(data['numR']);
                                        var lst='';
                                        for(var i=0;i<data['datosCar'].length;i++){
                                            lst+=bodyShopingCar(data['datosCar'][i],i);
                                        }
                                        if ($('#list_orderProduct ul').length>0) $('#list_orderProduct ul').empty().html(lst);
                                        else $('#list_orderProduct').empty().html('<ul id="ulToCar" h="'+data['nproduct']+'">'+lst+'</ul>');
//                                        $('.button').button();
                                        $('select.cant-product').chosen({width: 60,disableSearch:true });
                                        $('.chzn-results').css('width','inherit');
                                        $('.active-result').css('float','none').css('height','inherit').css('border-bottom','none');
                                        sumaryShopingCar(data);
                                        $(spanAction).attr('action',actionspan);
                                    }else if (data['datosCar2']['add']=='no'){
                                        $(spanAction).attr('action',actionspan);
                                        switch(data['datosCar2']['msg']){
                                            case 'no-disponible': 
                                                $.dialog({
                                                    title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                                    content	: '<?=STORE_PRODUCTO_NO_STATUS?>',
                                                    height	: 200,
                                                    close	: function(){
                                                        $.loader('show');
                                                        location.reload();
                                                    }
                                                });
                                                break;
                                            case 'backg': 
                                                    message('information','<?=SIGNUP_CTRTITLEMSGNOEXITO?>','<?=STORE_UNI_BACKG?>','',300,220);
                                                break;
                                            case 'no-stock': 
                                                $.dialog({
                                                    title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                                    content	: '<?=STORE_PRODUCTO_NO_STOCK?>',
                                                    height	: 200
                                                });
                                                break;
                                            case 'no-product': break;
                                        }
                                    }
                                }
                            });
                        }).on('click','.carStoreDetails .addToWish',function(){
                            var spanAction=$(this).prev('span.deleteItemCar'), c=$(this).parents('li').attr('class').split(' ');
                            var actionspan=$(spanAction).attr('action'),noST=$(this).parents('li.noST'),get='';
                            //console.log(noST.length);
                            if (noST.length>0){ get='&noSTP=1'}
                            $(spanAction).removeAttr('action');
                            $.ajax({ 
                                type: 'GET',
                                url: 'controls/store/shoppingCart.json.php?action=14&id='+$(this).attr("h")+'&shop=1&lisWishsShow=1&car=toWish'+get,
                                dataType: 'json',
                                success: function(data){
                                    var dato=data['listWish'];
                                    if (data['numRow']>0){
                                        var fr=$('#list_orderProduct li.'+c[1]+' .info-top-p select').attr('fr'),can2,can;
                                        $('#list_orderProduct li.'+c[1]).slideUp().removeClass('noST').empty().html('');
                                        if ($('#list_orderProduct div.messageAdver').length>0 && $('#list_orderProduct li.noST').length==0){    
                                            if ($('#list_orderProduct .updateItems').length>0){ $('#list_orderProduct div.noST').slideUp().empty().html('').removeClass('noST'); }
                                            else{ $('#list_orderProduct div.messageAdver').slideUp().empty().html(''); }
                                        }
                                        can2=$('#list_orderProduct .messageAdver .updateItems span[h]').length;
                                        can=$('#list_orderProduct .messageAdver .updateItems span[h="'+data['delete']+'"]').length; 
                                        if (can==1 && can2==1){
                                            if ($('#list_orderProduct div.noST').length>0){ $('#list_orderProduct div.messageAdver div.updateItems').slideUp().empty().html(''); }
                                            else{ $('#list_orderProduct div.messageAdver').slideUp().empty().html(''); }
                                        }else if (can==1){ $('#list_orderProduct div.messageAdver .updateItems strong span.numI').html(can2-can); }
                                        $('#list_orderProduct .messageAdver .updateItems span[h="'+data['delete']+'"]').slideUp().empty().html('').removeAttr('h');
                                        $('#list_orderProduct .messageAdver .noST span[h="'+data['delete']+'"]').slideUp().empty().html('').removeAttr('h');
                                        if (data['datosCar']){
                                            $('#menu-lshoppingCart').html(data['numR']);
                                            var lst='';
                                            for(var i=0;i<data['datosCar'].length;i++){
                                                lst+=bodyShopingCar(data['datosCar'][i],i);
                                            }
                                            $('#list_orderProduct ul').empty().html(lst);
                                          //  $('.button').button();
                                            $('select.cant-product').chosen({width: 60,disableSearch:true });
                                            $('.chzn-results').css('width','inherit');
                                            $('.active-result').css('float','none').css('height','inherit').css('border-bottom','none');
                                            sumaryShopingCar(data);
                                        }
                                        if (data['wish'] && data['wish']['body']){
                                            $('#list_orderProduct_wish ul').html(data['wish']['body']);
                                            //$('.button').button();
                                            if (data['wish']['disable']){
                                                if ($('#list_orderProduct_wish .messageAdver').length>0){
                                                    $('#list_orderProduct_wish .messageAdver div.noST').empty().html('').removeAttr('class').remove();
                                                    $('#list_orderProduct_wish .messageAdver').prepend(data['wish']['disable']);
                                                }else{
                                                    $('#list_orderProduct_wish .ui-single-box-title').empty().html('').removeAttr('class').remove();
                                                    $('#list_orderProduct_wish').prepend('<div class="ui-single-box-title"><?=STORE_WISH_LIST?></div>'+
                                                                                        '<div class="messageAdver changeOrder">'+data['wish']['disable']+'<div>');
                                                }
                                            }
                                        }else{
                                            $('#list_orderProduct_wish').empty().html('').css('display','none');
                                        }
                                    }else{
                                        $('#list_orderProduct').html('<div class="messageAdver"><?=STORE_NO_SC?></div>');
                                        $('div#shoppingCId.ui-single-box').removeAttr('style');
                                        $('#headerStoreCar').css('display','none');
                                        $('.menu-l-shoppingCart').css('display','none');
                                        if (data['wish'] && data['wish']['body']){
                                            $('#list_orderProduct_wish ul').html(data['wish']['body']);
                                           // $('.button').button();
                                            if (data['wish']['disable']){
                                                if ($('#list_orderProduct_wish .messageAdver').length>0){
                                                    $('#list_orderProduct_wish .messageAdver div.noST').empty().html('').removeAttr('class').remove();
                                                    $('#list_orderProduct_wish .messageAdver').prepend(data['wish']['disable']);
                                                }else{
                                                    $('#list_orderProduct_wish .ui-single-box-title').empty().html('').removeAttr('class').remove();
                                                    $('#list_orderProduct_wish').prepend('<div class="ui-single-box-title"><?=STORE_WISH_LIST?></div>'+
                                                                                        '<div class="messageAdver changeOrder">'+data['wish']['disable']+'<div>');
                                                }
                                            }
                                        }else{
                                            $('#list_orderProduct_wish').empty().html('').css('display','none');
                                        }
                                    }
                                }
                            });
                        });
                        $('#buyOrder2').click(function(){ $('#buyOrder').click(); });
						$('.right-panel #totalANDsugestProduct').on('click','#buyOrder',function(){
							//	$(this).button('disable');
								var vector=$('.cant-product');
								var array = new Array();
								$.each(vector, function(key,value){
									array[key]={id:$(this).attr('linia'),cant:$(this).val()};
								});
								processOrderSC(1,array);
						}).on('click','#deleteOrderC',function(){
							var get='&all=1&mod=car',obj={mod:'car'};
							deleteOrderC(get,obj);
						});
					}

                makeSugesStoreProducts('#makeSugesStoreProducts .he','?aso=1&limit=5');
				var tops=0;

			},
			close:function(){
				if (SECTION=='wishList'){
					$('#shoppingCId').off();
				}else{
					$('#shoppingCId').off();
					$('.right-panel #totalANDsugestProduct').off();				
				}
			}
		})
	});
	function makeListWish(){
		$('#list_orderProduct_wish').html('<span class="store-span-loader"><?=$lang["JS_LOADING"].' '.$lang["PRODUCTS_LIST"]?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />');
		$.ajax({
			type: 'GET',
			url: 'controls/store/shoppingCart.json.php?lisWihs=1',
			dataType: 'json',
			success: function(data){
				if (data['wish'] && data['wish']['body']){
					$('#list_orderProduct_wish').html(data['wish']['body']);
					$('.lis_product_store_details .footer span[money]').formatCurrency({symbol:''});

					var auxi=$('.lis_product_store_details .footer span[money="p"]'),varx;
					$.each(auxi, function(){
						varx=$(this).html().split('.');
						$(this).html(varx[0]);
					});
					if ($('#deleteItemsNot').length>0){
						$('#deleteItemsNot').click(function(){
							var h=$(this).attr('h'), get='&all=1',obj={mod:'wish'};
							get+='&mod=wish-pend&lisWishsShow=1&idOrder='+h;
							deleteItemCar('1',get,obj);
						});
					}
				}else{
					$('#list_orderProduct_wish').html('<div class="messageAdver"><?=$lang["STORE_NO_WL"]?></div>');
					$('div#shoppingCId.ui-single-box').removeAttr('style');
				}
			}
		});
	}
	function makeShopingCar(){
		$('#list_orderProduct').html('<span class="store-span-loader"><?=$lang["JS_LOADING"].' '.$lang["PRODUCTS_LIST"]?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />');
		$.ajax({
			type: 'GET',
			url: 'controls/store/shoppingCart.json.php?shop=1&lisWihs=1',
			dataType: 'json',
			success: function(data){
				if (data['datosCar'][0]['name']){
					var lst = '<ul id="ulToCar" h="'+data['nproduct']+'">';
					for(var i=0;i<data['datosCar'].length;i++){
						lst+=bodyShopingCar(data['datosCar'][i],i);
					}
					lst +=	'</ul>';
					$('#headerShopingCar').attr('h', data['nproduct']);
					if (data['bodyEmerg']){ lst=data['bodyEmerg']+lst; }
					$('#list_orderProduct').html(lst);
					$('.button').prop('disabled','disabled');
					$('select.cant-product').chosen({width: 60,disableSearch:true });
					$('.active-result').css('float','none').css('height','inherit').css('border-bottom','none');
					$('.chzn-results').css('width','inherit');
                    $("#second-panel-shopping").show();
					sumaryShopingCar(data);
					if ($('div#actionItems').length>0){
						$('div#actionItems .deleteToCar').click(function(){
							var get='&all=1&shop=1&mod=car-pend',obj={mod:'car'};
							deleteItemCar('1',get,obj);
						});
						$('div#actionItems .addToWish').click(function(){
							$.ajax({
								type: 'GET',
								url: 'controls/store/shoppingCart.json.php?action=14&shop=1&id=1&car=toWish&noSTP=1&lisWishsShow=1',
								dataType: 'json',
								success: function(data){
									var dato=data['listWish'];
									if (dato=="si" || dato=='ya-existe'){
										if (data['numRow']==0){
											$('#list_orderProduct').html('<div class="messageAdver"><?=$lang["STORE_NO_SC"]?></div>');
											$('div#shoppingCId.ui-single-box').removeAttr('style');
											$('#headerStoreCar').css('display','none');
											$('.menu-l-shoppingCart').css('display','none');
											if (data['wish'] && data['wish']['body']){
												$('#list_orderProduct_wish ul').html(data['wish']['body']);
												if (data['wish']['disable']){
													if ($('#list_orderProduct_wish .messageAdver').length>0){
														$('#list_orderProduct_wish .messageAdver div.noST').empty().html('').removeAttr('class').remove();
														$('#list_orderProduct_wish .messageAdver').prepend(data['wish']['disable']);
													}else{
														$('#list_orderProduct_wish .ui-single-box-title').empty().html('').removeAttr('class').remove();
														$('#list_orderProduct_wish').prepend('<div class="ui-single-box-title"><?=$lang["STORE_WISH_LIST"]?></div>'+
																							'<div class="messageAdver changeOrder">'+data['wish']['disable']+'<div>');
													}
												}
											}else{
												$('#list_orderProduct_wish').empty().html('').css('display','none');
											}
										}else{
											if ($('.updateItems').length>0){ $('div.noST').slideUp().empty().html(''); }
											else{ $('div.messageAdver').slideUp().empty().html(''); }
											var elementos='',can=0,can2=0,i;
											for (i=0; i<data['delete'].length;i++){
												elementos+=(elementos!=''?',':'')+'.messageAdver .updateItems span[h="'+data['delete'][i]+'"]';
												if ($('.messageAdver .updateItems span[h="'+data['delete'][i]+'"]').length==1){ can++; }
											}
											can2=$('.messageAdver .updateItems span[h]').length;
											if (can2==can){ $('div.messageAdver').slideUp().empty().html(''); }
											else {
												$(elementos).slideUp().empty().html('').removeAttr('h');
												$('.messageAdver .updateItems strong span.numI').html(can2-can);
											}
											var lst='';
											for(var i=0;i<data['datosCar'].length;i++){
												lst+=bodyShopingCar(data['datosCar'][i],i);
											}
											$('#list_orderProduct ul').empty().html(lst);
	//										$('.button').button();
											$('select.cant-product').chosen({ menuWidth: 60, width: 60,disableSearch:true });
											$('.chzn-results').css('width','inherit');
											$('.active-result').css('float','none').css('height','inherit').css('border-bottom','none');
											sumaryShopingCar(data);
											$('#menu-lshoppingCart').html(data['numRow']);
										}
									}
								}
							});
						});
					}
					if(data['wish']['body']){
						$('#list_orderProduct_wish').html('<div class="ui-single-box-title"><?=$lang["STORE_WISH_LIST"]?></div>'
															+'<div>'+data['wish']['body']+'</div>');
						$('#list_orderProduct_wish').css('border','1px solid #E5E4E4').css('width','625px').css('margin-top','15px');
						var lastLI=$('#list_orderProduct_wish ul li');
						$(lastLI[lastLI.length-1]).css('border-bottom','1px transparent');
						$(lastLI[lastLI.length-2]).css('border-bottom','1px transparent');
						if ($('#deleteItemsNot').length>0){
							$('#deleteItemsNot').click(function(){
								var h=$(this).attr('h'), get='&all=1',obj={mod:'wish'};
								get+='&mod=wish-pend&lisWishsShow=1&idOrder='+h;
								deleteItemCar('1',get,obj);
							});
						}
					}
				}else{
					$('#list_orderProduct').html('<div class="messageAdver"><?=$lang["STORE_NO_SC"]?></div>');
					$('div#shoppingCId.ui-single-box').removeAttr('style');
				}
			}
		});
	}
	function getfiltrosOrderOrSales(option,radio){
		$.ajax({
			type: 'POST',
			url: 'controls/store/shoppingCart.json.php?action=13&option='+option,
			dataType: 'json',
			success: function(data){
				if (data['datosCar'].length>0){
					var i,titleFreP='<div style="display:inline-block;">'
									+'<select class="chzn-b">'
										+'<option value="all"><?=$lang["GROUPSALLSELECT"]?></option>'
										for(var i=0;i<data['datosCar'].length;i++){
											switch(data['datosCar'][i]['tipo']){
												case '11': titleFreP+='<option value="pend"	'+(radio=='pend'?'selected':'')+'><?=$lang["STORE_ORDERS_PENDING"]?></option>'; break;
												case '12': titleFreP+='<option value="fins"	'+(radio=='fins'?'selected':'')+'><?=$lang["STORE_ORDERS_FINALIZED"]?></option>'; break;
											}
										}
					titleFreP+='</select>'
							+'<div>'
						+'<br/>';
					$('.store-wrapper #divSubMenuAdminFilters').empty().html(titleFreP);
					$('#divSubMenuAdminFilters select').chosen({
						menuWidth:165,
						width:170,
						disableSearch:true
					});
				}
			}
		});
	}
	function armarSelect(fechas,getyear,getmonth){
		var i,year='-1',month='-1',selectYear='<select>',selectMonth='<select>';
			if (fechas.length>0){
				for (i=0;i<fechas.length;i++){
					if (year!=fechas[i]['year']){
						selectYear+='<option value="'+fechas[i]['year']+'" '+(getyear==fechas[i]['year']?'selected':'')+'>'+fechas[i]['year']+'</option>';
						year=fechas[i]['year'];
						getyear=!getyear?year:getyear
					}
					if((getyear==year && year==fechas[i]['year'])&&(month!=fechas[i]['month'])){
						selectMonth+='<option value="'+fechas[i]['month']+'" '+(getmonth==fechas[i]['month']?'selected':'')+'>'+fechas[i]['monthL']+'</option>';
						month=fechas[i]['month'];
					}
				}
			}else{
				selectYear+='<option value="all"><?=JS_SIGNUP_LBLYEAR?></option>';
				selectMonth+='<option value="..."><?=JS_SIGNUP_LBLMONTH?></option>';
			}
		selectMonth+='</select>';
		selectYear+='</select>';
		$('#filter_by_years').empty().html(selectYear);
		$('#filter_by_month').empty().html(selectMonth);
		$('#filter_by_years select').chosen({
			menuWidth: 60,
			width: 60,
	        disableSearch:true 
		});
		$('#filter_by_month select').chosen({
			menuWidth: 93,
			width: 93,
	        disableSearch:true 
		});
	}
	function makeSugesStoreProducts(layer,get){
		get=get?get:'';
		$.ajax({
			type: 'POST',
			url: 'controls/store/listProd.json.php'+get+'&module=store',
			dataType: 'json',
			success: function(data){
				var prod=data['aso'];
				if(prod){
					var lst = '<ul >';
					for(var i=0;i<prod.length;i++){
						var tempEle = $('<span>'+prod[i]['cost']+'</span>');
						var costFormated = $(tempEle).formatCurrency({symbol:''});
						var cost = costFormated.html();
						if (prod[i]['pago']=='0'){
							var auxi=cost.split('.');
							cost = auxi[0];
						}
						tempEle = costFormated = null;
						lst +=	'<li action="detailProd,'+prod[i]['id']+'" '+((i<=2)?'class="border-top-store"':'')+'>'
									+'<div class="lis_product_store" style="background-image:url(\''+prod[i]['photo']+'\')";></div>'
									+'<div>'
										+'<span class="nameSP">'+prod[i]['name']+'</span><br>' //formPayment
										+'<span><?=$lang["PUBLICITY_TITLETABLE_COST"]?>: '+(prod[i]['pago']==1?' $'+cost:cost+' <?=$lang["STORE_TITLEPOINTS"]?>')+' <?=$lang["STORE_TITLEPOINTS"]?></span><br>'
										+'<span class="colorSpanStore"><?=$lang["STORE_VIEWDETAILS"]?></span><br><br>'
									+'</div>'
									+'<div class="clearfix"></div>'
								+'</li>';
					}
					lst += '</ul>';
					$(layer).html(lst);
					$('#makeSugesStoreProducts').css('display','block');
				}else{ $('#makeSugesStoreProducts').css('display','none'); }
			}
		});
	}
	function orderProcessed(get){
		$('#list_orderProduct').html('<span class="store-span-loader"><?=$lang["JS_LOADING"].' '.$lang["PRODUCTS_LIST"]?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />');
		get=get?get:'';
		$.ajax({
			type: 'GET',
			url: 'controls/store/shoppingCart.json.php?action=9'+get,
			dataType: 'json',
			success: function(data){
			console.log(data);
				if (data['datosCar'].length>0){
					var lst = '<ul>',idOrder='-1',contadorOrders=0,acumuladorPoints=0,acumuladorDollars=0;
						for(var i=0;i<data['datosCar'].length;i++){
							//Formate el costo de producto en dollares
							var tempEle = $('<span>'+data['datosCar'][i]['product_price']+'</span>');
							var costFormated = $(tempEle).formatCurrency({symbol:''});
							var cost = costFormated.html();
							if (data['datosCar'][i]['product_formPayment']=='0'){
								var auxi=cost.split('.');
								cost = auxi[0];
							}
							tempEle = costFormated = null;
							if (idOrder!=data['datosCar'][i]['idOrder']){
								lst+='<li class="purchaseorder border-botton-store '+(i!=0?'border-t-store':'')+'">'
									+'	<div>'
									+'		<strong><?=$lang["STORE_PURCHASETITLE"]?></strong>'
									+		((data['datosCar'][i]['pago']=='1')?'&nbsp;&nbsp;<span class="nameSP"><a href="'+BASEURL+'shoppingcart"><?=$lang["STORE_PROCEED"]?></a></span>'
																				+'&nbsp;&nbsp;<span class="nameSP"><a class="delete" h="1" href="javascript:void(0);"><?=$lang["PRODUCTS_DELETE"]?></a></span>':'')
									+		((data['datosCar'][i]['pago']=='11')?'&nbsp;&nbsp;<span class="nameSP"><a class="pay" h="'+data['datosCar'][i]['idOrderM']+'" href="javascript:void(0);"><?=$lang["JS_PAY"]?></a></span>'
																				+'&nbsp;&nbsp;<span class="nameSP"><a class="delete" h="'+data['datosCar'][i]['idOrderM']+'" href="javascript:void(0);"><?=$lang["PRODUCTS_DELETE"]?></a></span>':'')
									+'		<span class="right"><?=$lang["DATE"]?>: '+data['datosCar'][i]['dateOrder']+'</span>'
									+'	</div>'
									+'</li>';
								idOrder=data['datosCar'][i]['idOrder'];
								contadorOrders++;
							}
							lst +=	'<li class="carStore border-botton-store">'
									+'	<div class="lis_product_store" style="background-image:url(\''+data['datosCar'][i]['product_photo']+'\')";></div>'
									+'</li>'
									+'<li class="carStoreDetails border-botton-store">'
									+'	<div class="lis_product_store_details">'
									+'		<span class="nameSP" action="detailProd,'+data['datosCar'][i]['product_id']+',order">'+data['datosCar'][i]['product_name']+'</span><br>'
									+'		<div title="<?=$lang["SELLER"]?>" action="profile,'+data['datosCar'][i]['product_seller']+','+data['datosCar'][i]['product_name_user']+'">'
									+'			<div class="thumb" style="background-image: url(\''+data['datosCar'][i]['product_imagenUser']+'\')"></div>'
									+'			<h5>'+data['datosCar'][i]['product_name_user']+'</h5>'
									+'		</div>'
									+'		<div class="clearfix"></div>'
									//+'		<span class="footer">'+data['datosCar'][i]['product_category']+((data['datosCar'][i]['product_subCategory'])?((data['datosCar'][i]['product_place'])?' | '+data['datosCar'][i]['product_subCategory']+'</span>':'</span>'):'</span>')
									+'			<span class="footer"><span class="nameSP"><?=formatoCadena($lang["STORE_FROM"])?>: </span>'+data['datosCar'][i]['inicio']+'</span><br>'
									+'			<span class="footer"><span class="nameSP"><?=formatoCadena($lang["STORE_TO"])?>: </span>'+data['datosCar'][i]['fin']+'</span>'
									+'	</div>'
									+'</li>'
									+'<li class="carStorePrice border-botton-store">'
									+'	<div class="info-top-p">'+((data['datosCar'][i]['product_formPayment']=='1')?'$ '+cost:cost+' <?=$lang["STORE_TITLEPOINTS"]?>')+'</div>'
									+'</li>'
									+'<li class="carStoreQuantity border-botton-store">'
									+'	<div class="info-top-p"><?=$lang["QUANTITYSTORE"]?>:<br/>'+data['datosCar'][i]['product_cant']+'</div>'
									+'</li>';
							if (data['datosCar'][i]['product_formPayment']=='1')
								acumuladorDollars+= +data['datosCar'][i]['product_price']* +data['datosCar'][i]['product_cant'];
	//							acumuladorDollars+=parseFloat(data['datosCar'][i]['product_price']*data['datosCar'][i]['product_cant']);
							else{
								acumuladorPoints+= +data['datosCar'][i]['product_price']* +data['datosCar'][i]['product_cant'];
	//							acumuladorPoints+=parseFloat(data['datosCar'][i]['product_price']*data['datosCar'][i]['product_cant']);
							}
						}
					lst +=	'</ul>'
					$('#q_items').html(data['datosCar'].length);
					$('#q_ordes').html(contadorOrders);
					if (acumuladorPoints!=0){
						$('#t_points span.nameSP').html(acumuladorPoints).formatCurrency({symbol:''});
						var aux=$('#t_points span.nameSP').html().split('.');
						$('#t_points span.nameSP').html(aux[0]);
					}else $('#t_points').html('');
					if (acumuladorDollars!=0){
						$('#t_dollars span.nameSP').html(acumuladorDollars).formatCurrency({symbol:''});
					}else $('#t_dollars').html('');
	//				$('.button').button();
				}else{
					$('#q_items,#q_ordes').html(0);	$('#t_points,#t_dollars').html('');
					lst='<div class="product-list"><div class="noStoreProductsList messageAdver"><span><?=$lang["NOORDERS_MESSAGE"]?></span></div></div>';
				}
				$('#list_orderProduct').html(lst);
			}
		});
	}
	function salesProcessed(get){
		$('#list_orderProduct').html('<span class="store-span-loader"><?=$lang["JS_LOADING"].' '.$lang["PRODUCTS_LIST"]?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />');
		get=get?get:'';
		$.ajax({
			type: 'GET',
			url: 'controls/store/shoppingCart.json.php?action=12'+get,
			dataType: 'json',
			success: function(data){
				console.log(data);
				if(data['datosCar'].length>0){
					var lst='<ul>',idOrder='-1',acumuladorPoints=0,acumuladorDollars=0,acumuladorItems=0;
					for(var i=0;i<data['datosCar'].length;i++){
							lst+='<li class="purchaseorder border-botton-store">'
								+'	<div>'
								+'		<strong><?=$lang["STORE_PURCHASETITLE"]?></strong>'
								+'		<span class="right"><?=$lang["DATE"]?>: '+data['datosCar'][i]['dateOrder']+'</span>'
								+'	</div>'
								+'</li>';
							idOrder=data['datosCar'][i]['idOrder'];
						lst +=	'<li class="carStoreDetails '+(i==(data['datosCar'].length-1)?'border-botton-store':'')+'">'
								+'	<div class="lis_product_store_details">'
								+'		<span class="nameSP" ><?=$lang["STORE_BUYER"].': '?></span><br>'
								+'		<div title="<?=$lang["STORE_BUYER"]?>" action="profile,'+data['datosCar'][i]['buyer']+','+data['datosCar'][i]['name_user']+'">'
								+'			<div class="thumb" style="background-image: url(\''+data['datosCar'][i]['imagenUser']+'\')"></div>'
								+'			<h5>'+data['datosCar'][i]['name_user']+'</h5>'
								+'			<span class="titleField">Email: </span>'+data['datosCar'][i]['email_seller']+'<br>'
								+'		</div>'
								+'		<div class="clearfix"></div>'
								+'	</div>'
								+'</li>'
								+'<li class="carStorePrice '+(i==(data['datosCar'].length-1)?'border-botton-store':'')+' sales">'
								+'	<div class="info-top-p">';
								for(var j=0; j<data['datosCar'][i]['f_pago'].length; j++){
									//Formate el costo de producto en dollares
									var tempEle = $('<span>'+data['datosCar'][i]['f_pago'][j]['total']+'</span>');
									var costFormated = $(tempEle).formatCurrency({symbol:''});
									var cost = costFormated.html();
									if (data['datosCar'][i]['f_pago'][j]['formPayment']=='0'){
											var auxi=cost.split('.');
											cost = auxi[0];
										}
									tempEle = costFormated = null;

									switch(data['datosCar'][i]['f_pago'][j]['formPayment']){
										case '0':
											lst+=cost+' <?=$lang["STORE_TITLEPOINTS"]?><br>';
											acumuladorPoints=acumuladorPoints+parseFloat(data['datosCar'][i]['f_pago'][j]['total']);
											break;
										case '1':
											lst+='$ '+cost+'<br>';
											acumuladorDollars=acumuladorDollars+parseFloat(data['datosCar'][i]['f_pago'][j]['total']);
											break;
									}
								}
						lst+=	'	</div>'
								+'</li>'
								+'<li class="carStoreQuantity '+(i==(data['datosCar'].length-1)?'border-botton-store':'')+' sales">'
								+'	<div class="info-top-p"><span class="colorSpanStore" action="viewDetailsMySales,'+data['datosCar'][i]['idOrderM']+'"><?=$lang["STORE_VIEWDETAILS"]?></span></div>'
								+'</li>';
						acumuladorItems=acumuladorItems+parseFloat(data['datosCar'][i]['numItems']);
					}
					lst +=	'</ul>'
					$('#q_items').html(acumuladorItems);
					$('#q_ordes').html(data['datosCar'].length);
					if (acumuladorPoints!=0){
						$('#t_points span.nameSP').html(acumuladorPoints).formatCurrency({symbol:''});
						var auxi=$('#t_points span.nameSP').html().split('.');
						$('#t_points span.nameSP').html(auxi[0]);
					}else $('#t_points').html('');
					if (acumuladorDollars!=0){
						$('#t_dollars span.nameSP').html(acumuladorDollars).formatCurrency({symbol:''});
					}else $('#t_dollars').html('');
				}else{
					$('#q_items,#q_ordes').html(0);		$('#t_points,#t_dollars').html('');
					lst='<div class="product-list"><div class="noStoreProductsList messageAdver"><span><?=$lang["NOORDERS_MESSAGE"]?></span></div></div>';
				}
				$('#list_orderProduct').html(lst);
			}
		});
	}
</script>