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
<div class="ui-single-box" style="min-height: 915px;">
	<div class="ui-single-box-title" >
		<a href="#store"><?=STORE_TITLE.' '?></a><span>&nbsp;>&nbsp;</span>
		<span id="storeTitle"></span>
	</div>
	<div>
            <div id="list_orderProduct"></div>
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
				var noProduct='<?=$_GET['no-product']?$_GET['no-product']:''?>';
				if (noProduct!=''){ message('ordenAlter', '<?=SIGNUP_CTRTITLEMSGNOEXITO?>', '<?=STORE_ORDER_EDIT_STOCK?>', '', 250, 200); }
				var hash=window.location.hash;
				hash=hash.split('?');
				switch(hash[0]){
					case '#orders': case '#sales':
						var getyear='<?=($_GET['year']?$_GET['year']:'')?>',getmonth='<?=($_GET['month']?$_GET['month']:'')?>',idOrders='<?=($_GET['idOrdes']?$_GET['idOrdes']:'')?>',radio='<?=$radio?>',get='';
						
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
							if (radio!='all' && radio){
								get+='&radio='+radio;
							}
						}else{
							get='&orderId='+idOrders+'&option=orders';
							//$('#divSubMenuAdminFilters').remove();
						}
						if (hash[0]=='#orders'){
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

						$('#headerStoreCar').css('display','none');
						$('#makeSugesStoreProducts').css('margin-top','10px');
						$('#filter_by_date').css('margin-top','13px');
						$('#filter_by_years select').live('change','select',function(){
							armarSelect(fechas,$(this).val());
                            if($('#filter_by_month select option').length==1){
                                redir('#'+option+'?'+(radio!='all'?'radio='+radio+'&':'')+'year='+$(this).val()+'&month='+$('#filter_by_month select').val());
                            }
						});
						$('#filter_by_month select').live('change','select',function(){
							redir('#'+option+'?'+(radio!='all'?'radio='+radio+'&':'')+'year='+$('#filter_by_years select').val()+'&month='+$(this).val());
						});
						$('#divSubMenuAdminFilters select').live('change','select',function(){
							var value=$(this).val();
							switch(value){
								case 'pend': redir('#'+option+'?radio=pend');break;
								case 'fins': redir('#'+option+'?radio=fins');break;
								default: redir('#'+option);
							}
						});
//						$('#btnAll a').live('click',function(){
//							redir('#'+option);
//						});
//						$('#btnPend a').live('click',function(){
//							redir('#'+option+'?radio=pend');
////							redir('#'+option+'?radio=pend'+((getyear!='')?'&year='+getyear+((getmonth!='')?'&month='+getmonth:''):''));
//						});
//						$('#btnFins a').live('click',function(){
//							redir('#'+option+'?radio=fins');
////							redir('#'+option+'?radio=fins'+((getyear!='')?'&year='+getyear+((getmonth!='')?'&month='+getmonth:''):''));
//						});
						$('span.nameSP a.delete').live('click',function(){
							var h=$(this).attr('h'), get='&all=1',obj={};
							if (h==1){ get+='&mod=car'; }
                            else{ get+='&mod=pay&idOrder='+h; }
                            deleteOrderC(get,obj);
						});
						$('span.nameSP a.pay').live('click',function(){
							document.location = 'views/pay.view.php?payAcc=store&idOrder='+$(this).attr("h");
						});
					break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
					case '#wishList':
						makeListWish();
                        $('#storeTitle').html('<?=STORE_WISH_LIST?>');
                        $('#headerStoreCar').css('display','none');
                        $('div.lis_product_store_details span.addToCar').live('click',function(){
                            var num=$(this).attr("h"),objeto=$(this),spanAction=$(this).next('span.deleteItemCar');
                            var actionspan=$(spanAction).attr('action');
//                            $(objeto).button('disable');
                            $(spanAction).removeAttr('action');
                            $$.ajax({
                                type: 'GET',
                                url: 'controls/store/shoppingCart.json.php?action=1&add=si&id='+num,
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
                                                    redir('#shoppingcart');
                                                }
                                            });
                                        }else{ redir('#shoppingcart'); }
                                    }else if (data['datosCar2']['add']=='no'){
                                        $(spanAction).attr('action',actionspan);
                                        //$(objeto).button('enable');
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
						$('#headerStoreCar').css('display','none');		
					break;
//*****************************************************************shopping cart**********************************************//
					default:
							$('#storeTitle').html('<?=STORE_SHOPPINGCART?>');
							makeShopingCar();
						$('.cant-product').live('change','select',function(){
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
						});

						$('#buyOrder').live('click',function(){
							//	$(this).button('disable');
								var vector=$('.cant-product');
								var array = new Array();
								$.each(vector, function(key,value){
									array[key]={id:$(this).attr('linia'),cant:$(this).val()};
								});
								processOrderSC(1,array);
						});
						$('#deleteOrderC').live('click',function(){
							var get='&all=1&mod=car',obj={mod:'car'};
							deleteOrderC(get,obj);
						});
                        $('div.lis_product_store_details span.addToCar').live('click',function(e){
                            var num=$(this).attr("h"),objeto=$(this),spanAction=$(this).next('span.deleteItemCar');
                            var actionspan=$(spanAction).attr('action');
                            //$(objeto).button('disable');
                            $(spanAction).removeAttr('action');
                            $$.ajax({
                                type: 'GET',
                                url: 'controls/store/shoppingCart.json.php?action=1&add=si&id='+num+'&shop=1',
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
                                        //$(objeto).button('enable');
                                    }else if (data['datosCar2']['add']=='no'){
                                        $(spanAction).attr('action',actionspan);
                                        //$(objeto).button('enable');
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
                        $('.carStoreDetails .addToWish').live('click',function(){
                            var num=$(this).attr("h"),objeto=$(this),spanAction=$(this).prev('span.deleteItemCar'), c=$(this).parents('li').attr('class').split(' ');
                            var actionspan=$(spanAction).attr('action'),noST=$(this).parents('li.noST'),get='';
                            //console.log(noST.length);
                            if (noST.length>0){ get='&noSTP=1'}
                            $(spanAction).removeAttr('action');
                            $$.ajax({ 
                                type: 'GET',
                                url: 'controls/store/shoppingCart.json.php?action=14&id='+num+'&shop=1&lisWishsShow=1&car=toWish'+get,
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
                                        $('div.ui-single-box').removeAttr('style');
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
				}
                makeSugesStoreProducts('#makeSugesStoreProducts .he','?aso=1&limit=5');
				var tops=0;

			},
			close:function(){
				var hash=window.location.hash;
				hash=hash.split('?');
				if (hash[0]=='#orders'||hash[0]=="#sales"){
					$('#filter_by_years select').die();
					$('#filter_by_month select').die();
					$('#btnAll a').die();
					$('#btnAct a').die();
					$('#btnPend a').die();
					$('#btnFins a').die();
					$('span.nameSP a.pay').die();
					$('span.nameSP a.delete').die();
					$('#divSubMenuAdminFilters select').die();
				}else if (hash[0]=='#wishList'){
					$('div.lis_product_store_details span.addToCar').die();
				}else{
					//$('.cant-product').off();
					$('.cant-product').die();
					$('#buyOrder').die();
					$('#deleteOrderC').die();
				}
			}
		})
	});
</script>