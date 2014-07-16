<?php
	$select='';$join='';
	//valida el menu left
	$numIt=createSessionCar('','','count');
	$numOrder=$_SESSION['store']['order']?$_SESSION['store']['order']:'';
    $numWish=$_SESSION['store']['wish']?$_SESSION['store']['wish']:'';
	$numSales=$_SESSION['store']['sales']?$_SESSION['store']['sales']:'';
	incHitsTag($_GET['prd'],1,'store_products');
	if($_GET['rfl']=='1'){
		$select=',md5(a.id) as raffle_id,
				a.points as raffle_points,
				a.cant_users as raffle_cant_users,
				(SELECT aj.id_user FROM store_raffle_join aj WHERE aj.id_raffle=a.id AND aj.id_user='.$_SESSION['ws-tags']['ws-user']['id'].') AS raffle_join_user,
				a.start_date as raffle_start_date,
				(SELECT COUNT(aj.id)  FROM store_raffle_join aj WHERE aj.id_raffle=a.id) AS numParti'; 
		$join='	JOIN store_raffle a ON a.id_product=p.id
				';
	}
	$products = $GLOBALS['cn']->query("
		SELECT
			p.id AS id,
			p.id_user AS id_user,
			p.id_status AS status,
			(SELECT name FROM store_category WHERE id=p.id_category) AS category,
			(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
			p.name AS name,
			p.description AS description,
			p.sale_points AS cost,
			p.photo AS photo,
			p.place AS place,
			p.video_url AS video,
			p.stock AS stock,
			p.id_category AS id_category,
			p.formPayment AS formPayment,
			u.username AS username,
			concat(u.name,' ',u.last_name) AS user_name,
			u.followers_count AS user_admirers,
			u.following_count AS user_admired,
			u.profile_image_url as user_photo,
			md5(concat(u.id,'_',u.email,'_',u.id)) AS user_code
			".$select."
		FROM store_products p
		JOIN users u ON u.id=p.id_user
		".$join."
		WHERE md5(p.id) = '".$_GET['prd']."' 
		LIMIT 0,1
	");
	$product = mysql_fetch_assoc($products);
	
	//$bandb=createSessionCar('','','count',$_GET['prd']);
	if ($product['place']=='1'){
		$photosProduct=array();$i=0;
		$photos = $GLOBALS['cn']->query('
			SELECT id, `order`, picture
			FROM store_products_picture
			WHERE id_product="'.$product['id'].'"
			ORDER BY `order`
		');
		$bkg=''; $x=100;
		while($photo=mysql_fetch_assoc($photos)){
			if ($photo['order']<$x){
				$x = $photo['order'];
				$bkg = 'img/'.$photo['picture'];
			}
			$photosProduct[$i]['id']=$photo['id'];
			$photosProduct[$i]['order']=$photo['order'];
			$photosProduct[$i++]['picture']='img/'.$photo['picture'];
		}
	}
	if($_GET['rfl']=='1'){
		$dateIni = explode(' ',$product['raffle_start_date']);
		$product['raffle_start_date'] = $dateIni[0];

	}
?>
<div id="store" class="ui-single-box">
    <div class="ui-single-box-title limitTitle">
		<a href="<?php echo base_url(); ?>store"><?=STORE_TITLE.' '?></a><span>&nbsp;&gt;&nbsp;</span>
		<?=formatoCadena($product['name'])?>
	</div>
	<div>
		<div class="detail-box">
			<h4><?=STORE_DETPRDPUBLIBY?></h4>
			<div class="user-profile">
				<div class="thumb" style="background-image: url('<?=FILESERVER.getUserPicture($product['user_code'].'/'.$product['user_photo'],'img/users/default.png')?>')"></div>
				<h5 class="limitTitle"><?=  formatoCadena($product['user_name'])?></h5>
				<div class="anytext"><?=USER_LBLFOLLOWERS.' ('.$product['user_admirers'].')'?></div>
				<div class="anytext"><?=USER_LBLFRIENDS.' ('.$product['user_admired'].')'?></div>
				<div class="clearfix"></div>
				<div class="anytext limitComent">
					<strong><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</strong>
					<br/>
					<a href="<?=DOMINIO.$product['username']?>"><?=DOMINIO.$product['username']?></a>
				</div>
			</div>
			<h4><?=STORE_DETPRDDETAIL?></h4>
			<?php if($_GET['rfl']=='1'){?>
			<h3><?=STORE_TITLEPOINTS.': <span id="lblCost">'.$product['raffle_points'].'</span>'?></h3>
				<div class="anytext">* <strong><?=PRODUCTS_FECHA_INI?>: </strong><?=$product['raffle_start_date']?></div>
				<div class="anytext" action="userRaffle,<?=$product['raffle_id']?>">* <strong id="parTiUserRaffle"><?=STORE_PARTICIPANTS?>: </strong><?=$product['numParti']?></div>
				<div class="anytext" action="userRaffle,<?=$product['raffle_id']?>">* <strong id="parTiUserRaffle"><?=STORE_PLACES_A?>: </strong><?=  intval($product['raffle_cant_users'])-  intval($product['numParti'])?></div>
			<?php }else{ ?>
				<h3><?=(($product['formPayment']=='1')?TYPEPRICEMONEY.': <span id="lblCost">'.$product['cost'].'</span>':STORE_TITLEPOINTS.': <span id="lblCost">'.$product['cost'].'</span>')?></h3>
				<div class="anytext">* <strong><?=STORE_CATEGORIES2?>: </strong><?=formatoCadena(constant($product['category']))?></div>
				<div class="anytext">* <strong><?=STORE_CATEGORIES3?>: </strong><?=formatoCadena(constant($product['subCategory']))?></div>
				<?php if ($product['id_category']!=1){ ?><div class="anytext">* <strong><?=formatoCadena(STORE_STOCK)?>: </strong><span <?=($product['stock']<10?'class="color_red"':'')?>><?=$product['stock']?></span></div><?php }?>
				<?php if ($product['stock']<10 && $product['id_category']!='1'){ ?><div class="anytext color_red"><?=$product['stock']==0?STORE_NOT_STOCK_LIST:STORE_MESSAGE_STOCK_LOW?></div><?php }?>
			<?php } ?>
				<div id="detailsProduct-Radio" class="elementShadow">
					<?php if ($_GET['order']=='1'){ ?>
					<input id="btnBack" type="button" title="<?=JS_BACK?>" value="<?=JS_BACK?>"/>
					<?php }elseif ($product['id_user']!=$_SESSION['ws-tags']['ws-user']['id']){
						if ($_GET['rfl']=='1'){
                                if ($product['raffle_join_user']!=$_SESSION['ws-tags']['ws-user']['id']){ ?>
                                <input id="btnJoin" type="button" title="<?=GROUPS_JOINTOTHEGROUP?>" value="<?=GROUPS_JOINTOTHEGROUP?>"/><br>
						<?php   }
                         }else{ ?>
								<input id="btnBuyProd" type="button" title="<?=STORE_DETPRDDBTNADD?>" value="<?=BUY?>"/><br>
								<input id="addWish" type="button" title="<?=STORE_WISH_LIST_ADD?>" value="<?=STORE_WISH_LIST_ADD?>" style="padding: 6px 0px"/><br>
						<?php } ?>
								<input id="btnBack" type="button" title="<?=JS_BACK?>" value="<?=JS_BACK?>"/>
					<?php
					}else{
						if ($_GET['rfl']!='1'){ 
                            if ($_SESSION['ws-tags']['ws-user']['id']=='427'){ ?>
                            <input id="newRafle" type="button" title="<?=PRODUCTS_NEW_RAFFLE?>" value="<?=PRODUCTS_NEW_RAFFLE?>"/><br>
                            <?php } 
                            if ($product['stock']>0){ ?>
                            <input id="createTag" type="button" title="<?=MAINMNU_CREATETAG?>" value="<?=MAINMNU_CREATETAG?>"/><br>
                            <?php } ?>                            
							<input id="btnEdit" type="button" title="<?=PRODUCTS_EDIT?>" value="<?=PRODUCTS_EDIT?>"/><br>
						<?php } ?>
							<input id="btnBack" type="button" title="<?=JS_BACK?>" value="<?=JS_BACK?>"/>
					<?php  }  ?>
				</div>
		</div>

		<div class="gallery-box">
			<?php
				if ($product['place']=='1'){ $bkg=FILESERVER.$photosProduct[0]['picture']; }
                else{ $bkg=FILESERVER.'img/'.$product['photo']; }
			?>
			<div class="bg" style="background-image:url(<?=$bkg?>);"></div>
			<div class="thumbs">
			<?php
				if ($product['place']=='1'){
					foreach ($photosProduct AS $photoProduct){
			?>
				<div id="<?=$photoProduct['picture']?>" style="background-image: url('includes/imagen.php?tipo=2&ancho=60&alto=60&img=<?=FILESERVER.$photoProduct['picture']?>');"></div>
			<?php
					}
				}
			?>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="descriptionProd limitComent">
		<h4><?=STORE_DETPRDTITLEDES?></h4>
		<section><?=$product['description']?></section>
	</div>
    <div style="text-align: center;">
     <?php
        if (isset($product['video']) && $product['video']!='' && $product['video']!='http://'){
            $_GET['url']=$product['video'];
            require('views/tags/video.view.php');
        }
     ?>
	</div>
	<?php
	$textHash = get_hashtags($product['description']);
	$textHash = array_unique($textHash);
	if(count($textHash)!=0){
	?>
	<div class="descriptionProd limitComent">
		<h4><?=STORE_SUGGEST?></h4>
		<div><?php 
			foreach ($textHash as &$value){
				$value = rtrim($value,'\,\.');
				if((strlen($value)>20)){
					$hashP = substr($value, 0, 20);
					$sp = '...';
				}else{
					$hashP = $value;
					$sp = '';
				}
				echo '<div class="searchHash"><a href="'.base_url().'searchall?srh='.$value.'&in=2">'.$hashP.$sp.'</a></div>';
			}
		?></div>
	</div>
	<?php } ?>
	<div class="comentProd">
		<h4><?=STORE_DETPRDTITLEASK?></h4>
		<div>
			<?php
				$id_source=$product['id'];
				$id_type=15;
				$id_user_to=md5(md5($product['id_user']));
				$store=1;
				include('views/comments/comments.php');
			?>
		</div>
	</div>
    <br><div class="product-list produc_sugg" style="width: inherit;"></div><br>
    <div class="clearfix"></div>
    <br><div class="product-list produc_suggSrh" style="width: inherit;"></div><br>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
	$(function(){
		$('#lblCost').formatCurrency({symbol:''}); //Formato de moneda
		var forp='<?=$product['formPayment']?>';
		if(forp=='0'){
			var cost=$('#lblCost').html();
			var aux=cost.split('.');
			$('#lblCost').html(aux[0]);
		}
		//colocarle el numero al shoppinh car
		var numIt='<?=$numIt?>',numOrder='<?=$numOrder?>',numSales='<?=$numSales?>',numWish='<?=$numWish?>';
		if (numIt!='0' && numIt !=''){
			$('#menu-lshoppingCart').html(numIt).css('display','block');
			//$('#menu-l-li-shoppingCart').css('display','list-item');
		}
        if (numOrder!=''){ $('.menu-l-youOrders').css('display','list-item'); }
        //if (numWish!=''){ $('#menu-l-li-wishList').css('display','list-item'); }
        if (numSales!=''){ $('.menu-l-youSales').css('display','list-item'); }
		////////////////////////////////////////////////////////////////////////////
		//$('#detailsProduct-Radio').buttonset();
//		$('.elementShadow label').button();
		//gallery
		var interval,$thumbs=$('.gallery-box .thumbs div');
		$thumbs.first().addClass('selected');
        storeListProd('', '?noStore=1&idp=<?=md5($product['id'])?>&');
		$.on({
			open:function(){
				var getInterval=function(){};
				if($thumbs.length>1) getInterval=function(){
					interval=setInterval(function(){ //alert(clickPhoto);
						var $next=$thumbs.filter('.selected').next();
						if($next.length==0) $next=$thumbs.first();
						$next.click();
					},3000);
				};
				getInterval();
				$thumbs.on('mouseover',function(){
					clearInterval(interval);
				}).on('mouseout',function(){
					getInterval();
				}).on('click',function(){
					if($thumbs.length>1){
						$('.gallery-box .bg')
						.after('<div class="bg" style="background-image:url(<?=FILESERVER?>'+this.id+'); display:none;" ></div>')
						.next()
						.fadeIn('slow',function(){
							$(this).prev().remove();
						});
						$thumbs.removeClass('selected');
						$(this).addClass('selected');
					}
				});
			},
			close:function(){
				$thumbs.off();
				clearInterval(interval);
			}
		});
		//end gallery
		$('#btnBuyProd').click(function(){
			var num="<?=md5($product['id'])?>",boton=$(this);
//            $('.elementShadow label').button('disable');
            //$(boton).button('disable');
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
                                    redir('shoppingcart');
                                }
                            });
                        }else{ redir('shoppingcart'); }
                    }else if (data['datosCar2']['add']=='no'){
//                        $('.elementShadow label').button('enable');
//                        $(boton).button('disable');
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
		$('#addWish').click(function(){
			var num="<?=md5($product['id'])?>";
//            $('.elementShadow label').button('disable');
            $$.ajax({
                type: 'GET',
                url: 'controls/store/shoppingCart.json.php?action=14&id='+num,
                dataType: 'json',
                success: function(data){
                    var dato=data['listWish'];
                    if (dato=="si" || dato=='ya-existe'){
                        redir('wishList');
                    }else if (dato=="no-disponible"){
                        $.dialog({
                            title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                            content	: '<?=STORE_PRODUCTO_NO_STATUS?>',
                            height	: 200,
                            close	: function(){
                                redir('store');
                            }
                        });
                    }
                }
            });
		});
		$('#btnBack').click(function(){
//			 $('.elementShadow label').button('disable'); 
            history.back(1);
		});
		$('#btnEdit').click(function(){
//			$('.elementShadow label').button('disable');
            redir('newproduct?idProd=<?=md5($product['id'])?>');
		});
		$('#createTag').click(function(){
//			$('.elementShadow label').button('disable');
            redir('creation?product=<?=md5($product['id'])?>');
		});
		$('#newRafle').click(function(){
		//	$('.elementShadow label').button('disable');
            addNewRaffleStore('<?=md5($product['id'])?>');
		});

		$('#btnJoin').click(function(){
			//alert('<?=$product['raffle_id']?>');
            $.dialog({
                title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                content	: '<?=JOIN_CONFIN_R?>',
                height	: 200,
                close	: function(){ $(this).dialog('close'); },
                buttons: [{
                        text: lang.JS_CANCEL,
                        click: function() { $( this ).dialog( "close" ); }
                    }, {
                        text: lang.JS_CONTINUE,
                        click: function() {
                            $( this ).dialog( "close" );
//                            $('.elementShadow label').button('disable');
                           $$.ajax({
                                type: 'GET',
                                url: 'controls/store/acctionsProducts.json.php?acc=4&rfl=<?=$product['raffle_id']?>',
                                dataType: 'json',
                                success: function(data){
                                    $("#btnJoin").hide();
                                    switch(data['action']){
                                        case 'join':  message('store_thankyouRaffle', "<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', PRODUCTS_RAFFLE_TITLE))?>", "<?=STORE_THANKYOUMEMBERS?>",'',  350, 200); break;
                                        case 'end': message('store_thankyoufinalRaffle', "<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', PRODUCTS_RAFFLE_TITLE))?>", "<?=STORE_THANKYOUFINALMEMBERS?>",'', 350, 220); break;
                                        case 'no-points': message('store_nocreditRaffle', "<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', PRODUCTS_RAFFLE_TITLE))?>", "<?=STOREMESSAGENOPOINTSFORBUY.'<br/>'.STORE_MINIMUNREQUIRED?> "+data['PointReq'],'',  350, 200); break;
                                        case 'exist': message('store_nocreditRaffle', "<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', PRODUCTS_RAFFLE_TITLE))?>", "<?=STORE_EXIST_RAFFLE?> "+data['PointReq'],'',  350, 200); break;
                                        case 'no-id-update': default: message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=JS_ERROR?></trong></div>','','',200,'','store?');                                            
                                    }
                                }
                            });
                        }// boton confirm
                    }
                ]
            });
		});
});
</script>
