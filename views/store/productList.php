<?php 
//ALTER TABLE  `config_system` ADD  `time_in_minutes_shopping_cart_active` INT( 11 ) NOT NULL DEFAULT  '120',
//ADD  `time_in_minutes_pending_order_payable` INT( 11 ) NOT NULL DEFAULT  '120'

//valida el menu left
$numIt=createSessionCar('','','count');
$numOrder=$_SESSION['store']['order']?$_SESSION['store']['order']:'';
$numWish=$_SESSION['store']['wish']?$_SESSION['store']['wish']:'';
if (!isset($_SESSION['store']['sales']) && ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427')){
    $sql="  SELECT o.id 
            FROM store_orders o
            JOIN store_orders_detail od ON od.id_order=o.id
            WHERE od.id_user='".$_SESSION['ws-tags']['ws-user']['id']."' 
            AND od.id_status!='1' AND od.id_status!='2' AND od.id_status!='5' 
            LIMIT 1;";
    $result=$GLOBALS['cn']->queryRow($sql);
    $row=current($result);
    if ($row!='') @$_SESSION['store']['sales']='1';
}
$numSales=$_SESSION['store']['sales']?$_SESSION['store']['sales']:'';

//*******************************************************
//$GLOBALS['cn']->query("UPDATE `users` SET `status`='3' WHERE id IN ('437','438','439');");
//$GLOBALS['cn']->query("DELETE FROM `users_plan_purchase`  WHERE `id_user` IN ('437','438','439');");
//$GLOBALS['cn']->query("UPDATE  `users` SET  `logins_count` =  '0' WHERE `id_user` IN ('437','438','439');");
//*******************************************************
//variables necesarias para el armado del titulo
$titleCate='';$titleSubCate='';$href='';$idCate='';
//obtener el nombre de la categoria y subcategoria si son necesarias
if($_GET['cate']){
	$AND='';$select='';
	$href='?cate='.$_GET['cate'];
	if ($_GET['subcate']){
		$select=',s.name AS subCategory';
		$AND="AND md5(s.id)='".$_GET['subcate']."'";
	}
	$sql="SELECT c.name AS category,
				c.id AS id_category
             $select  
			FROM store_category c
			INNER JOIN store_sub_category s ON s.id_category=c.id
			WHERE md5(c.id)='".$_GET['cate']."'
			$AND LIMIT 0,1;";
	$category = $GLOBALS['cn']->query($sql); 
	$category = mysql_fetch_assoc($category);
	$titleCate=  constant($category['category']);
	$idCate=  $category['id_category'];
	if ($_GET['subcate']) $titleSubCate=constant($category['subCategory']);	
}
?>
<div class="ui-single-box mini" id="pageStore"> 
    <div class="ui-single-box-title limitTitle"></div>
    <div class="store-wrapper">
        <div class="product-list produc"></div>
        <div class="product-list sugest"></div>
        <div id="loaderStore" style="display:none;width: 555px;float: left;"><span class="store-span-loader"><?=JS_LOADING.' '.PRODUCTS_LIST?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>
        <div class="clearfix"></div>
        <br><div class="product-list produc_sugg" style="width: inherit;"></div><br>
        <div class="clearfix"></div>
        <br><div class="product-list produc_suggSrh" style="width: inherit;"></div><br>
        <div class="clearfix"></div>
    </div>
</div>
<script>	
$(function() {
		$.on({
            open:function(){
				$('.store-wrapper .mainMenu a').css('margin-bottom:','0px');$('aside').css('display','block');
				//variables necesarias para hacer todas las validaciones referentes a cada lista
				var subget='',band='',posi=false,limit=0,sc=false,array=new Array(),rifa=false,title='';
				var nameCate='<?=$titleCate?>',nameSubCate='<?=$titleSubCate?>',href='<?=$href?>',idcate='<?=$idCate?>';
				var typeUser='<?=$_SESSION['ws-tags']['ws-user']['type']?>';
				switch(SECTION){
					case 'mypublications':
						if (typeUser=='0') redir('store');
						sc='2';
						array['scc']='scc=2';
						array['srh']='';
						array['radio']='';
						array['raffle']='raffle=1';
						title='<a id="titleStoreA"><?=STORE_TITLE?></a><span>&nbsp;>&nbsp;</span>'
							 +((nameCate!='')?'<a href="'+BASEURL+'mypublications"><?=STORE_MISPUBLICATION?></a><span>&nbsp;>&nbsp;</span>'
							 +((nameSubCate!='')?'<a href="'+BASEURL+'mypublications'+href+'">'+nameCate+'</a><span>&nbsp;>&nbsp;</span><span>'+nameSubCate+'</span>':''
							 +'<span>'+nameCate+'</span>'):'<span><?=STORE_MISPUBLICATION?></span>');
					break; 
					case 'myfreeproducts':
						if (typeUser=='0') redir('store');
						rifa=true;
						array['scc']='scc=2';
						array['my']='my=1';
						array['raffle']='';
						array['radio']='';
						title='<a id="titleStoreA"><?=STORE_TITLE?></a><span>&nbsp;>&nbsp;</span>'
						 +((nameCate!='')?'<a href="'+BASEURL+'myfreeproducts"><?=STORE_MYRAFFLE?></a><span>&nbsp;>&nbsp;</span>'
						 +((nameSubCate!='')?'<a href="'+BASEURL+'myfreeproducts'+href+'">'+nameCate+'</a><span>&nbsp;>&nbsp;</span><span>'+nameSubCate+'</span>':''
						 +'<span>'+nameCate+'</span>'):'<span><?=STORE_MYRAFFLE?></span>');
					break;
					case 'myparticipation':
						rifa=true;
						array['scc']='scc=2';
						array['myplays']='myplays=1';
						array['raffle']='';
						array['radio']='';
						title='<a id="titleStoreA"><?=STORE_TITLE?></a><span>&nbsp;>&nbsp;</span>'
						 +((nameCate!='')?'<a href="'+BASEURL+'myparticipation"><?=STORE_RAFFLES_PLAYS?></a><span>&nbsp;>&nbsp;</span>'
						 +((nameSubCate!='')?'<a href="myparticipation#'+href+'">'+nameCate+'</a><span>&nbsp;>&nbsp;</span><span>'+nameSubCate+'</span>':''
						 +'<span>'+nameCate+'</span>'):'<span><?=STORE_RAFFLES_PLAYS?></span>');
					break;
					case 'freeproducts':	
						sc='5'
						rifa=true;
						array['scc']='';
						array['srh']='';
						array['radio']='';
						title='<a id="titleStoreA"><?=STORE_TITLE?></a><span>&nbsp;>&nbsp;</span>'
							 +((nameCate!='')?'<a href="'+BASEURL+'freeproducts"><?=PRODUCTS_RAFFLE?></a><span>&nbsp;>&nbsp;</span>'
							 +((nameSubCate!='')?'<a href="'+BASEURL+'freeproducts'+href+'">'+nameCate+'</a><span>&nbsp;>&nbsp;</span><span>'+nameSubCate+'</span>':''
							 +'<span>'+nameCate+'</span>'):'<span><?=PRODUCTS_RAFFLE?></span>');
					break;
					default:
						sc=false;
						array['scc']='';
						array['srh']='';
						array['radio']='<?=$_GET['radio']?$_GET['radio']:''?>';
						subget='<?=$_GET['radio']?'?radio='.$_GET['radio']:''?>';
						title=((nameCate!='')?'<a id="titleStoreA">00<?=STORE_TITLE?></a><span>&nbsp;>&nbsp;</span>'
							 +((nameSubCate!='')?'<a href="'+BASEURL+'store'+href+'">'+nameCate+'</a><span>&nbsp;>&nbsp;</span><span>'+nameSubCate+'</span>':''
							 +'<span>'+nameCate+'</span>'):'<span><?=STORE_TITLE.' > '.STORE_ALL_PRODUCT?></span>');
				}
				//colocar el titulo de la vista anteriormente armado
				$('div.ui-single-box-title').html(title);
				
				//menu de administracion de las rifas
				switch(SECTION){
					case 'mypublications': case 'myfreeproducts': case 'myparticipation': case 'freeproducts':
						var titleFreP=   '	<div>'
										+'	<select class="chzn-b">'
										+'		<option value=""><?=OPTIONS?></option>'
										+'		<option value="tag"><?=MAINMNU_CREATETAG?></option>'
										<?php // if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
										<?php  if ($_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
										<?php // if ($_SESSION['ws-tags']['ws-user']['id']=='-1000'){ ?>
										+'		<option value="create"><?=PRODUCTS_NEW_RAFFLE?></option>'
										+'		<option value="myraffles"		'+(SECTION=='#myfreeproducts'?'selected':'')+'><?=STORE_MYRAFFLE?></option>'
										<?php } ?>
										+'		<option value="rafflesplays"	'+(SECTION=='#myparticipation'?'selected':'')+'><?=STORE_RAFFLES_PLAYS?></option>'
										+'	</select>' 
										+'	</div>'
						$('#divSubMenuAdminPublications').empty().html(titleFreP);
                        $('#divSubMenuAdminPublications select').chosen({
                			menuWidth:172,
                			width:172,
                            disableSearch:true
                		});						
						break;
						default:
							var titleFreP='<div>'
										+'	<select class="chzn-b">'
										+'		<option value=""		'+(array['radio']==''?'selected':'')+'><?=STORE_SORT_BY?></option>'
										+'		<option value="points"	'+(array['radio']=='points'?'selected':'')+'><?=STORE_TITLEPOINTS?></option>'
										+'		<option value="dollas"	'+(array['radio']=='dollas'?'selected':'')+'><?=TYPEPRICEMONEY?></option>'
										+'		<option value="moreC"	'+(array['radio']=='moreC'?'selected':'')+'><?=STORE_FILTER_MOREEXPENSIVE?></option>'
										+'		<option value="moreE"	'+(array['radio']=='moreE'?'selected':'')+'><?=STORE_FILTER_MOREECONOMICAL?></option>'
										+'		<option value="moreR"	'+(array['radio']=='moreR'?'selected':'')+'><?=STORE_FILTER_MORERELEVANT?></option>'
										+'	</select>' 
										+'	</div>' 
						$('#divSubMenuAdminFilters').empty().html(titleFreP);
                        $('#divSubMenuAdminFilters select').chosen({
                			menuWidth:172,
                			width:172,
                            disableSearch:true
                		});
						
						var no_product='<?=$_GET['no-product']?$_GET['no-product']:''?>'
						if (no_product!=''){
							$.dialog({
								title	: 'Alert',
								content	: '<?=STORE_PAY_DOUBLE?>'
							});							
						}
				}
				//categorias y sub categorias
				var getCat=armarGetBand(array);
				getCat+=(sc=='5')?'module=raffle&':'';
				getCategorysStore(getCat,idcate);
				
				//colocarle el numero al shoppinh car
				var numIt='<?=$numIt?>',numOrder='<?=$numOrder?>',numSales='<?=$numSales?>',numWish='<?=$numWish?>';
				//Carrito de compra
				if (numIt!='0' && numIt !=''){
					$('#menu-lshoppingCart').html(numIt).css('display','block');
					//$('.shoppingCart').css('display', 'block');
					$('.shoppingCart').click(function(){
						redir('shoppingcart');
					});
					//$('#menu-l-li-shoppingCart').css('display','list-item');
				}
                $('.shoppingCart').click(function(){
                    redir('shoppingcart');
                });
				if (numOrder!=''){ $('.menu-l-youOrders').css('display','list-item'); }
                //if (numWish!=''){ $('#menu-l-li-wishList').css('display','list-item'); }
                if (numSales!=''){ $('.menu-l-youSales').css('display','list-item'); }
                
				//gallery
				<?php if($_GET['cate']){ ?>
					var c = '<?=$_GET['cate'] ?>'; 
					var subc = '<?=($_GET['subcate']?$_GET['subcate']:'all')?>';
					array['c']='c='+c;
					array['subc']='sc='+subc;
					array['srh']='';
					subget+=(subget?'&':'?')+'cate='+c+(subc!='all'?'&subcate='+subc:'');
					band=armarGetBand(array);
                    if (rifa) storeRaffle('.product-list.produc', band);
					else storeListProd('.product-list.produc', band);
				<?php }else{ ?>
					band=armarGetBand(array);
					if (rifa) storeRaffle('.product-list.produc', band);
					else storeListProd('.product-list.produc', band);
				<?php } ?>

			//acciones menu store
			//Carga Productos por categoria
			$('#menuStore li a').live('click',function(){
                if ($(this).attr('c')){
					var get='?cate='+$(this).attr('c')+'&subcate='+$(this).attr('sc');
                    if (array['radio'] && array['radio']!='') get+='&radio='+array['radio'];
					redir(SECTION+get);
				}else{ redir(SECTION); } 
				return false;
			});

			$('#divSubMenuAdminFilters select').live('change','select',function(){
				var value=$(this).val();
				redir('store'+(value!=''?'?radio='+value:''));
			});
			//end cliks del filtro del store
			$('#divSubMenuAdminPublications select').live('change','select',function(){
				var value=$(this).val(),string='';
				switch(value){
					case 'myraffles': string='myfreeproducts';break;
					case 'rafflesplays': string='myparticipation';break;
				}
				if (value=='create' || value=='tag'){
					var tag=value=='tag'?true:false,titleFreP='	<div>'
										+'	<select class="chzn-b">'
										+'		<option value=""><?=OPTIONS?></option>'
										+'		<option value="tag"><?=MAINMNU_CREATETAG?></option>'
										<?php // if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
										<?php  if ($_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
										<?php // if ($_SESSION['ws-tags']['ws-user']['id']=='-1000'){ ?>
										+'		<option value="create"><?=PRODUCTS_NEW_RAFFLE?></option>'
										+'		<option value="myraffles"		'+(SECTION=='#myfreeproducts'?'selected':'')+'><?=STORE_MYRAFFLE?></option>'
										<?php } ?>
										+'		<option value="rafflesplays"	'+(SECTION=='#myparticipation'?'selected':'')+'><?=STORE_RAFFLES_PLAYS?></option>'
										+'	</select>' 
										+'	</div>'
					$('#divSubMenuAdminPublications').empty().html(titleFreP);
                    $('#divSubMenuAdminPublications select').chosen({
            			menuWidth:172,
            			width:172,
                        disableSearch:true
            		});	
					chooseProducts(tag);
				}else if (string!=''){ redir(string); }
			});
			
			$('#titleStoreA').click(function(){
				redir('store');
			});
			//Carga productos por filtro
            var timeOut;
            function buscar(request,obj){
                limit=0;
                if (request!="" && obj.val().length>1) {
                    //request = encodeURIComponent(request).replace('%20','+');
                    array['srh']='srh='+request;
                    band=armarGetBand(array);
                    if (rifa) storeRaffle('.product-list.produc', band);
                    else storeListProd('.product-list.produc', band);
                    obj.show('slow');
                }else{
                    if (obj.val().length==0){
                        array['srh']='';
                        band=armarGetBand(array);
                        if (rifa) storeRaffle('.product-list.produc', band);
                        else storeListProd('.product-list.produc', band);
                    }
                }
            }
			$('#txtSearchProduct').keyup(function() {
				var request = $(this).val(),obj=$(this);
                timeOut&&clearTimeout(timeOut);
                timeOut=setTimeout(buscar(request,obj),1000);
			});

			$('#menuStore').on('click','li > span',function(){
				var that=$(this).parent().find('ul')[0];
				if(that){
					$('#menuStore ul').not(that).slideUp(300);
					$(that).slideToggle(300);
				}
			});
		   $('#clickNewProduct').live('click',function(){
				redir('newproduct');
			});
			$('#clickNewRaffle').live('click',function(){
				redir('mypublications');
			});
			$('div.miniCarStore div.bg-add').live('click',function(){
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
                                    content	: data['datosCar2']['order'],
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
                                if (!data['datosCar2']['order']){
                                    numIt=parseFloat(numIt)+1;
                                    $('#menu-lshoppingCart').empty().html(numIt);
                                    $('div.shoppingCart div.numCart span').empty().html(numIt);
                                }else{
                                    numIt=1;
                                    $('#menu-lshoppingCart').empty().html('1').css('display','block');
                                    //$('div.shoppingCart').css('display', 'block');
                                    $('div.shoppingCart div.numCart span').empty().html('1').css('display','inline-block');
                                    $('div.shoppingCart div.numCart').css('display','inline-block');
//                                    $('div.shoppingCart').click(function(){
//                                        redir('shoppingcart');
//                                    });
                                    $('#menu-l-li-shoppingCart').css('display','list-item');
                               }
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
			
			$('.product-list.produc ul li,.product-list.sugest ul li').live('mouseover',function(){ 
				if ($(this).attr('r')=='1'){
//					$('.transparencia_hover').addClass('transparencia').removeClass('transparencia_hover');
					$('div.inputCreateRaffle',this).slideDown();
				}else if ($(this).attr('r')=='2'){
					$('div.miniCarStore',this).fadeIn();
				}
			}).live('mouseleave',function(){
				if ($(this).attr('r')=='1'){
//					$('.transparencia').addClass('transparencia_hover').removeClass('transparencia');
					$('div.inputCreateRaffle',this).slideUp();
				}else if ($(this).attr('r')=='2'){
					$('div.miniCarStore',this).fadeOut();
				}
			});
			$(document).on('scroll',function(){
                // if (subget!=''){ var stringS1=SECTION+subget, stringS2=SECTION+subget; }
                // else{ var stringS1=SECTION, stringS2=SECTION+'?'; }
                // if (window.location.hash==stringS1||window.location.hash==stringS2){
                    if ($(document).scrollTop() >= ($(document).height() - $(window).height())*0.4){
                        if(!posi){
                            if ($('.product-list.produc .noStoreProductsList').length==0){
                                posi=true;
                                var vector=$('.product-list.produc ul li');
                                if (vector.length%9==0){
                                    limit=vector.length;
                                    band=armarGetBand(array);
                                    if (limit!=0){
                                        var modulo=rifa?'raffle':'store';
                                        seeMoreStore('.product-list.produc ul', band, limit, modulo,'#loaderStore');
                                    }
                                }
                            }
                        }
                    }else{ posi=false; }
                // }
		   });
			
			function armarGetBand(){
				var string='?';
				if (array['scc'] && array['scc']!='')string+=array['scc'];
				if (array['c'] && array['c']!='') string+=(string=='?'?'':'&')+array['c']+'&'+array['subc'];
				if (array['srh'] && array['srh']!='') string+=(string=='?'?'':'&')+array['srh'];
				if (array['my'] && array['my']!='') string+=(string=='?'?'':'&')+array['my'];
				if (array['raffle'] && array['raffle']!='') string+=(string=='?'?'':'&')+array['raffle'];
				if (array['myplays'] && array['myplays']!='') string+=(string=='?'?'':'&')+array['myplays'];
				if (array['radio'] && array['radio']!='') string+=(string=='?'?'':'&')+'radio='+array['radio'];
				string+=(string=='?'?'':'&');
				return string;
			}
            
		},
		close:function(){
			$('#menuStore').off();
			$('#clickNewProduct').die();
			$('#clickNewRaffle').die();
			$('.product-list.produc ul li').die();
			$('#menuStore li a').die();;
			$('#divSubMenuAdminFilters select').die();;
			$('#divSubMenuAdminPublications select').die();;
			$('div.miniCarStore div.bg-add').die();;
			$(document).off();
		}
	});
});
</script>
