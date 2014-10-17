<?php
//valida el menu left
$numOrder=$_SESSION['store']['order']?$_SESSION['store']['order']:'';
$numWish=$_SESSION['store']['wish']?$_SESSION['store']['wish']:'';
$numSales=$_SESSION['store']['sales']?$_SESSION['store']['sales']:'';
?>
<div id="productTabs">
	<div class="ui-single-box mini"> 
		<div class="ui-single-box-title limitTitle" id="titleProductSearch">
		</div>
		<div class="store-wrapper">
			<div class="product-list produc"></div>
            <div class="product-list sugest"></div>
            <div id="loaderStore" style="display:none;width: 600px;float: left;"><span class="store-span-loader"><?=JS_LOADING.' '.PRODUCTS_LIST?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>
			<div class="clearfix"></div>	
		</div>
	</div>
</div>
<script>
$(function(){
	$.on({
		open:function(){
			$('.store-wrapper .mainMenu a').css('margin-bottom:','0px');
			//variables necesarias para hacer todas las validaciones referentes a cada lista
			var band='',posi,limit=0,search = "<?=$srh?>".split('#'), search1=(location.href.split('h=#')[1]||'')||(location.href.split('h=%23')[1]||''),srh='',array=new Array(),hash=window.location.hash;
		

			//colocar el titulo de la vista anteriormente armado
			$('#titleProductSearch').html("<span><?=PRODUCTS_RELATEDPRODUCTS.' '.$srh?></span>");
			
			//gallery
			//srh = search.split('&');
			srh =(search[1])?search[1]+',':"<?=$srh?>";
			
			array['srh']='srh='+srh;
			
			band=armarGetBand(array);
			storeListProd('.product-list.produc', band,srh);
			$(document).on('click','div.miniCarStore div.bg-add',function(){
				var num=$(this).attr("h"),objeto=$(this);
				$$.ajax({
					type: 'GET',
					url: 'controls/store/shoppingCart.json.php?action=1&add=si&id='+num,
					dataType: 'json',
					success: function(data){
						if (data['datosCar2']['add']=='si'){
                            if (data['datosCar2']['order']){
                                $.dialog({
                                    title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                    content	: '<?=STORE_TIME_FROM_NEW?> '+data['datosCar2']['order']+' <?=STORE_TIME_END_CAR?>',
                                    height	: 220,
                                    width	: 300,
                                    close	: function(){
                                        $('html,body').animate({scrollTop:'50px'},'slow',function(){
                                            $('html,body').clearQueue();
                                            //showAndHide('massageItem',	'massageItem',	1500, true);
                                        });
                                    }
                                });
                            }else{
                                $('html,body').animate({scrollTop:'50px'},'slow',function(){
                                    $('html,body').clearQueue();
                                    //showAndHide('massageItem',	'massageItem',	1500, true);
                                });
                            }
                            if(data['datosCar2']['new']=='si'){
                                var menu=$('#menuLeft #store')[0];
                                if(!$(menu).hasClass('selected')){
                                    $(menu).addClass('selected').children('ul').show();
                                    //$('#menu-l-li-shoppingCart').css('display','list-item');
                                    var numOrder='<?=$numOrder?>',numSales='<?=$numSales?>',numWish='<?=$numWish?>';
                                    if (numOrder!=''){ $('.menu-l-youOrders').css('display','list-item'); }
                                    //if (numWish!=''){ $('#menu-l-li-wishList').css('display','list-item'); }
                                    if (numSales!=''){ $('.menu-l-youSales').css('display','list-item'); }
                                }
                                if (!data['datosCar2']['order']){ $('#menu-lshoppingCart').empty().html(data['datosCar2']['count']).css('display','block'); }
                                else{ $('#menu-lshoppingCart').empty().html('1'); }
                            }
                        }else if (data['datosCar2']['add']=='no'){
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
			$('.product-list').on('mouseover','ul li',function(){
				if ($(this).attr('r')=='1'){
//					$('.transparencia_hover').addClass('transparencia').removeClass('transparencia_hover');
					$('div.inputCreateRaffle',this).slideDown();
				}else if ($(this).attr('r')=='2'){
					$('div.miniCarStore',this).fadeIn();
				}
			}).on('mouseleave','ul li',function(){
				if ($(this).attr('r')=='1'){
//					$('.transparencia').addClass('transparencia_hover').removeClass('transparencia');
					$('div.inputCreateRaffle',this).slideUp();
				}else if ($(this).attr('r')=='2'){
					$('div.miniCarStore',this).fadeOut();
				}
			});
			$(document).on('scroll',function(){
			   if ($(document).scrollTop() >= ($(document).height() - $(window).height())*0.4){
				   if(!posi){
					   posi=true;
					   var vector=$('.product-list.produc ul li');
					   if (vector.length%9==0){
                           if ($('#pruebaList .product-list.produc .messageNoResultSearch').length==0){
                                limit=vector.length;
                                array['srh']='srh='+srh[0]+'|';
                                band=armarGetBand(array);
                                if (limit!=0){
                                    var modulo='store';
                                    seeMoreStore('.product-list.produc ul', band, limit, modulo,'#loaderStore');
                                }
                            }
					   }
				   }
			   }else{ posi=false; }
			});
			function armarGetBand(vector){
				var string='?';
				if (array['srh'] && array['srh']!='') string+=(string=='?'?'':'&')+array['srh'];
				string+=(string=='?'?'':'&');
				return string;
			}
		},
		close:function(){
			$('#menuStore').off();
			$(document).off('click','div.miniCarStore div.bg-add');
			$('.product-list').off();
			$('#clickNewProduct').die();
			$('#clickNewRaffle').die();
			$('#menuStore li a').die();;
			$('#divSubMenuAdminFilters select').die();;
			$('#divSubMenuAdminPublications select').die();
			$('div.miniCarStore div.bg-add').die();;
			$(document).off();
		}
	});
});
</script>
