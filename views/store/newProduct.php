<?php
if(($_SESSION['ws-tags']['ws-user']['home_phone']==""&&$_SESSION['ws-tags']['ws-user']['mobile_phone']==""&&$_SESSION['ws-tags']['ws-user']['work_phone']=="")
	||($_SESSION['ws-tags']['ws-user']['home_phone']=="-"&&$_SESSION['ws-tags']['ws-user']['mobile_phone']=="-"&&$_SESSION['ws-tags']['ws-user']['work_phone']=="-"))
	$noTele=1;
else $noTele=0;
//ALTER TABLE  `store_products` ADD  `video_url` VARCHAR( 200 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
if($_SESSION['ws-tags']['ws-user']['type']==1){
		//Categorias
	$sqlcats = 'SELECT s.id, s.id_category, s.name, c.name AS category_name FROM store_sub_category AS s
				JOIN store_category AS c ON c.id=s.id_category
				WHERE c.id_status=1 AND s.id_status=1 AND c.id!=1;';
	$store_categories = $GLOBALS['cn']->query( $sqlcats );
	$categorys=array();
	$q=array();$z=0;
	while($categoryss=mysql_fetch_assoc($store_categories)){
		$q=$categoryss;
		if(isset($categorys[$categoryss['id_category']])){
			$i=count($categorys[$categoryss['id_category']]['sub_category']);
			$categorys[$categoryss['id_category']]['sub_category'][$i]['id']=$categoryss['id'];
			$categorys[$categoryss['id_category']]['sub_category'][$i]['name']=  formatoCadena(constant($categoryss['name']));	
		}else{
			$categorys[$categoryss['id_category']]['id_category']=$categoryss['id_category'];
			$categorys[$categoryss['id_category']]['category_name']=  formatoCadena(constant($categoryss['category_name']));
			$categorys[$categoryss['id_category']]['sub_category'][0]['id']=$categoryss['id'];
			$categorys[$categoryss['id_category']]['sub_category'][0]['name']=  formatoCadena(constant($categoryss['name']));
		}
	}
	$categorys=json_encode($categorys);
	$photos=array();
}

if($_GET['idProd']){
	$result=$GLOBALS['cn']->query('
		SELECT p.id,
			(SELECT CONCAT(a.name," ",a.last_name) FROM users a WHERE a.id=p.id_user) AS seller,
			p.id_status AS status,
			p.id_category AS category,
			p.id_sub_category AS subCategory,
			p.name,
			p.description,
			p.sale_points AS cost,
			p.photo,
			p.stock,
			p.formPayment,
			p.video_url
		FROM `store_products` AS p
		WHERE md5(p.id)="'.$_GET['idProd'].'"
		LIMIT 1;
	');
	
	$product=mysql_fetch_assoc($result);
	$_GET['idProd']=$product['id'];
	if($_SESSION['ws-tags']['ws-user']['type']==1){
		$photoss=$GLOBALS['cn']->query("
			SELECT id,`order`,picture
			FROM store_products_picture
			WHERE id_product='".$product['id']."'
			ORDER BY `order` DESC	
		");
		while($arrays=mysql_fetch_assoc($photoss)){
			$photos[$arrays['id']]['photo']=$arrays['picture'];
			$photos[$arrays['id']]['order']=$arrays['order'];
		}
	}
}
//valida el menu left
$numIt=createSessionCar('','','count');
$numOrder=$_SESSION['store']['order']?$_SESSION['store']['order']:'';
$numWish=$_SESSION['store']['wish']?$_SESSION['store']['wish']:'';
$numSales=$_SESSION['store']['sales']?$_SESSION['store']['sales']:'';
?>


<div class="ui-single-box">
	<div class="ui-single-box-title"><?=($_GET['idProd'])?PRODUCTS_EDIT.' '.TOUR_CREATIONBACKGROUND_TITLE:PRODUCTS_ADD?></div>
	<div id="dialogBck"></div>
	<div>
		<form class="newStoreBack" method="post" enctype="multipart/form-data" name="frmProducts" id="frmProducts">
			<div id="fields_error" name="fields_error" class="error_addNewProductsView"> <?=ALLFIELDSAREREQUIRED ?>	</div>
			<div class="list_inline">
				<?php if($_SESSION['ws-tags']['ws-user']['type']==1){ ?>
					<div class="div-li">
						<label ><strong>(*) <?=STORE_CATEGORIES2?></strong></label><br/>
						<div id="category"></div>
						<input name="txtCategory" type="hidden" id="txtCategory" value="" requerido="<?=STORE_CATEGORIES2?>"/><br />
					</div>
					<div class="div-li">
						<label><strong>(*) <?=STORE_CATEGORIES3?></strong></label><br/>
						<div id="subCategory"></div>
						<input name="txtSubCategory" type="hidden" id="txtSubCategory" value="" requerido="<?=STORE_CATEGORIES3?>"/><br />
					</div>
				<?php } ?>
				<div class="div-li">
					<label><strong>(*) <?=PRODUCTS_PICTURE?></strong></label>
					<label><span><?=STORE_MSG_HELP_NEW_PRODUCT2?></span></label>
					<?php if(!$_SESSION['ws-tags']['ws-user']['type']==1){ ?>
						<div id="photoUpload">
							<!--<div id="photoDIVS"></div>-->
							<div id="photoDIV" class="invisible"><input type="file" id="photo" class="invisible"  name="photo" value="<?=($_GET[idProd])?$product['photo']:''?>" <?=($_GET[idProd])?'':'requerido="'.PRODUCTS_PICTURE.'"'?>/></div>
							<div id="div_backgroundUsersPrev" class="prevPhotoStore">
								<div title="<?=NEWTAG_UPLOADBACKGROUND?>" style="<?=($_GET['idProd'])?"background-image:url('".FILESERVER."img/".$product['photo']."');":""?> "></div>
								<img id="loaderStore" style="display:none;position:relative;top:-25px;" src="css/smt/loader.gif" width="25" height="25" />
							</div>							
							<input type="hidden" id="backgSelect_" name="backgSelect_" value="<?=($_GET[idProd])?$product['photo']:''?>"/>
							<span id="photoSpan" class="photoSpan"></span>
							<div class="clearfix"></div>
						</div>
						
					<?php }else{
						echo '<div>';
						for($i=0;$i<5;$i++){
							echo '
								<div id="photoUpload'.($i+1).'" class="frmProfileBotones">
									<!--div id="photoDIVS-'.($i+1).'"></div-->
									<div class="prevPhotoStore">
										<div n="'.($i+1).'" title="'.NEWTAG_UPLOADBACKGROUND.'" class="bgS'.($i+1).'" '.(($photos[($i+1)])?'style="background-image: url(\''.FILESERVER."img/".$photos[($i+1)]['photo'].'\');background-size:100%;"':'').'>
										</div>
										<img id="loaderStore'.($i+1).'" style="display:none;position: relative;top:-25px;" src="css/smt/loader.gif" width="25" height="25" />
									</div>
									<div id="photoDIV'.($i+1).'" class="invisible"><input type="file" id="photo'.($i+1).'" class="invisible" name="photo'.($i+1).'" value="'.(($_GET[idProd])?$product['photo']:'').'" '.(($_GET[idProd])?'':'requerido="'.PRODUCTS_PICTURE.'"').'/></div>
									<input type="hidden" id="backgSelect_'.($i+1).'" name="backgSelect_'.($i+1).'" value="'.(($photos[($i+1)])?$photos[($i+1)]['photo']:'').'"/>
									<span id="photoSpan'.($i+1).'" class="photoSpan"></span>
									<!--span>'.GROUPS_NEWPHOTO.' ('.($i+1).'): '.STORE_ORDER.'</span-->
									<input name="txtOrder'.($i+1).'" type="hidden" id="txtOrder'.($i+1).'" size="3" maxlength="4"
									class="txt_box" value="'.($i+1).'" requerido="'.STORE_ORDER.' '.GROUPS_NEWPHOTO.' ('.($i+1).')"/>
								</div>
							';
						}
						echo '<div class="clearfix"></div></div>';
					} ?>
				</div>
				<?php if($_SESSION['ws-tags']['ws-user']['type']==1){ ?>
				<div class="div-li">
					<label ><strong>(*) <?=TOUR_CREATIONVIDEO_TITLE?></strong></label> <br>
					<input name="txtVideo" type="text" id="txtVideo" size="40" maxlength="100"
						class="txt_box" value="<?=($_GET['idProd']?$product['video_url']:'http://')?>" placeholder="http://" requerido="<?=TOUR_CREATIONVIDEO_TITLE?>" tipo="video"/>
					<span class="help_info">?</span>
					<div><div class="messageHelp arrowLeft"><span><?=TOUR_CREATIONVIDEO_CONTENT?></span></div></div>
					<div id="vimeo">
						<div id="running" class="warning-box dnone"><?=VIMEO_PREMIUM_VERIFY?><span class="loader"></span></div>
						<div id="success" class="warning-box dnone"><?=VIMEO_PREMIUM_SUCCESS?></div>
						<div id="error" class="error-box dnone"><?=VIMEO_PREMIUM_DAMAGED?></div>
					</div>
					<br/>
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				<div class="div-li">
					<label ><strong>(*) <?=PRODUCTS_NAME?></strong></label>  <span class="nameSP">(<span id="nunCaracterName"></span>&nbsp;max)</span><br />
					<input name="txtName" type="text" id="txtName" size="40" maxlength="100"
						class="txt_box" value="<?=($_GET['idProd']?$product['name']:'')?>" requerido="<?=PRODUCTS_NAME?>"/>
					<span class="help_info">?</span>
					<div><div class="messageHelp arrowLeft"><span><?=STORE_MSG_HELP_NEW_PRODUCT?></span></div></div><br>
					<div class="clearfix"></div>
				</div>
					<?php if(($_SESSION['ws-tags']['ws-user']['id']=='427')&&($_SESSION['ws-tags']['ws-user']['paypal']!='')): ?>
					<div class="div-li">
						<label ><strong>(*) <?=STORE_METHODPAYMENT?></strong></label>
						<div id="selectTypePrice"></div>
					</div>
					<?php endif; ?>
					<input name="txtMethod" type="text" id="txtMethod" value="0" <?=!isset($_GET['activePayment'])?'disabled':''?>
							class="invisible" requerido="<?=STORE_METHODPAYMENT?>"/>
				<div class="div-li">
					<label ><strong>(*) <?=$_SESSION['ws-tags']['ws-user']['id']=='427'?MNUUSER_LABELPOINTER:PRODUCTS_PRICE?></strong></label><br />
<!--					<input name="txtPrice" type="text" id="txtPrice" size="3" maxlength="4"
						class="txt_box" value="<?=($_GET['idProd']?$product['cost']:'')?>" requerido="<?=PRODUCTS_PRICE?>"/><h6 id="value_Input_Price"><?=($_SESSION['ws-tags']['ws-user']['type']!=1)?' '.STORE_TITLEPOINTS:''?></h6>-->
					<input name="txtPrice" type="text" id="txtPrice" size="6" maxlength="7"
						onkeypress="return numbersonly(event,<?=($product['formPayment']==1)?'true':'false'?>);"
						class="txt_box" value="<?=($_GET['idProd']?$product['cost']:'')?>" requerido="<?=PRODUCTS_PRICE?>"/><h6 id="value_Input_Price"></h6>
					<br><label id="mPoints" ><span><?=STORE_MESSAGEPOINTS?></span></label>
				</div>
				<?php if ($_SESSION['ws-tags']['ws-user']['type']==1){ ?>
				<div class="div-li">
					<label ><strong>(*) <?=STORE_STOCK?></strong></label><br />
					<input name="txtStock" type="text" id="txtStock" size="3" maxlength="4"
						class="txt_box" value="<?=($_GET['idProd']  ? $product['stock'] : '' )?>" requerido="<?=STORE_STOCK?>"/>
				</div>
				<?php }else{ ?> <input name="txtStock" type="text" id="txtStock" size="3" maxlength="4"
						class="txt_box invisible" disabled value="100" requerido="<?=STORE_STOCK?>"/>
				<?php } ?>
				<div class="div-li">
					<label ><strong>(*) <?=PRODUCTS_DESCRIPTION?></strong>&nbsp;&nbsp;<span>(<?=PRODUCT_DESCRIPTION_MESSAGE?>)</span></label>
					<br/><label ><span><?=STORE_MSG_HELP_NEW_PRODUCT3?></span></label>
					<textarea name="txtDescription"  id="txtDescription" requerido="<?=PRODUCTS_DESCRIPTION?>"><?=trim(($_GET['idProd'] ? $product['description'] : '' ))?></textarea>
				</div>
			</div>
			<div class="footerStore">
				<label style="font-size: 11px;" ><strong><?=REQUIRED?></strong></label><br><br>
				<input type="button" id="btnBack" name="btnBack" value="<?=JS_BACK?>"/>
				<?php if($_GET['idProd']){?>
				<input type="button" id="btndelete" name="btndelete" value="<?=PRODUCTS_DELETE?>"/>
				<?php } ?>
				<input type="hidden" id="tipo" name="tipo" value="tag"/> <?php //tipo tag es el submit completo el tipo image es el submit del upload de la imagen ?>
				<input type="button" id="btnSend" name="btnSend" value="<?=NEWTAG_BTNPUBLISH?>" />
				<input type="hidden" name="id" id="id" value="<?=($_GET[idProd]?$_GET['idProd']:'')?>">
				<input type="hidden" name="status" id="status" value="">
				<input type="hidden" name="action" id="action" value="<?=($_GET['idProd']?'update':'insert')?>">
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		var getId='<?=$_GET['idProd']?$_GET['idProd']:''?>';
		if(getId!=''){
			$('#txtPrice').formatCurrency({symbol:''});
			var prodFp='<?=$product['formPayment']?>'
			if(prodFp=='0'){
				var auxi=$('#txtPrice').val().split('.');
				$('#txtPrice').val(auxi[0]);
			}
		}			
		$('#txtPrice').blur(function(){
			$(this).formatCurrency({symbol:''});
			var auxi=$(this).val().split('.');;
			$(this).val(auxi[0]);
		});
		$('#selectTypePrice').on('change','select',function(){
			if(this.value=='dollar'){ $('#txtPrice').blur(function(){ $(this).formatCurrency({symbol:''}); });
			}else{
				$('#txtPrice').blur(function(){
					$(this).formatCurrency({symbol:''});
					var auxi=$(this).val().split('.');;
					$(this).val(auxi[0]);
				});
			}
		});
		$('#nunCaracterName').textCounter({
			target:'#txtName',//required: string
			count:50,//optional: integer [defaults 140]
			alertAt:30,//optional: integer [defaults 20]
			warnAt:10,//optional: integer [defaults 0]
			stopAtLimit:true//optional: defaults to false
		});
		//inicializar caracteristicas de cada elemento unico
//		$("button,input:submit,input:reset,input:button").button();
		$('#btndelete,#btnBack,#btnSend').css('font-size','12px').css('font-weight','bold');
		$('#txtDescription').jqte();
		$('#txtName').css('width','250px');
		$('.newStoreBack div.list_inline div label span span').html('<?=($_SESSION['ws-tags']['ws-user']['type']!=1)?'1 '.PUBLICITY_LBLPICTURE:'5 '.PUBLICITY_LBLPICTURE.'s'?>');
		var category='',cat='',subcat='',fp='';
		
		//colocarle el numero al shoppinh car
		var numIt='<?=$numIt?>',numOrder='<?=$numOrder?>',numSales='<?=$numSales?>',numWish='<?=$numWish?>';
		if(numIt!='0'&&numIt!=''){ $('#menu-lshoppingCart').html(numIt).css('display','block'); }
		if(numOrder!=''){ $('.menu-l-youOrders').css('display','list-item'); }
		if(numSales!=''){ $('.menu-l-youSales').css('display','list-item'); }

		<?php if($_SESSION['ws-tags']['ws-user']['type']==1){ ?>
		//validacion de telefonos
		var noNUmTele='<?=$noTele?>';
		if(noNUmTele==1){
			$.dialog({
				title:'<?=RESET_TITLEALERTEMAILPASSWORD?>',
				resizable:false,
				width:350,
				height:220,
				modal:true,
				open:function(){
					$(this).html('<div syplay="text-aling:center;"><strong><?=STORE_PRODUCTS_ADD_NOTPERFIL?></trong></div>');
//					$('.button').button();
				},
				close:function(){ redir("profile?sc=1&store=1"); },
				buttons:[{
					text:'<?=formatoCadena(JS_COMPLETE)?>',
					click:function(){
						$(this).dialog("close");
					}
				}]
			});
		}else{
		<?php if(!$_SESSION['ws-tags']['ws-user']['type']==1){ ?>
				uploadPhoto()
		<?php }else{ ?>
				category='<?=$categorys?>';
				cat='<?=$product['category']?>';
				subcat='<?=$product['subCategory']?>';
				fp='<?=$product['formPayment']?>';
                console.log(category);
				console.log(cat);
                var v=JSON.parse(category);
				<?php if($_GET['idProd']){ ?>
					categorys(v,cat);
					subCategorys(cat,v,subcat);
					selectT_Price(fp);
				<?php }else{ ?>
					categorys(v);
					subCategorys();
					selectT_Price();
				<?php } ?>
				for(var i=1;i<6;i++){	uploadPhoto(i)}
		<?php } ?>
			//acciones click 
			$('#btnBack').click(function(){ history.back(1); });
			$('#btndelete').click(function(){
				$('#frmProducts').attr('action','controls/store/acctionsProducts.json.php?acc=2<?=($_GET['idProd']?'&id='.$_GET['idProd']:'')?>');
				$('#frmProducts').submit();
			});
			$('.prevPhotoStore div,#div_backgroundUsersPrev').click(function(){
				var num=$(this).attr('n')?$(this).attr('n'):'';
				$('#photoDIV'+num+' input').click();
			});

			//enviar el submit
			$('#btnSend').click(function(){
				if($('#txtName').val().length>=50){ $('#txtName').val($('#txtName').val().substring(0,50)); }				
//				$('#btnSend').button("disable");
				$('#txtMethod').removeAttr('disabled')
				$('#txtStock').removeAttr('disabled')
				$('#tipo').val('tag');
				if($('#txtVideo').val()=='') $('#txtVideo').val('http://');
				if(valida($('#frmProducts'))){
						if ($('#txtStock').val()=='0'){ $('#status').val('2'); }
						else{ $('#status').val('1') }
                        $('#frmProducts').attr('action','controls/store/acctionsProducts.json.php?acc=<?=($_GET['idProd']?($_GET['revend']?'0':'1&id='.$_GET['idProd']):'0')?>')
						$('#frmProducts').submit();
				}else{ /*$('#btnSend').button("enable"); */
				}
			});
			$('#txtVideo').click(function(){
				this.selectionStart = 0;
			});
			var vc=0,sto;//vimeo counter ajax
			$('#txtVideo').bind('change keyup',function(){
				var that=this,URL=that.value;
				console.log(URL);
				if(URL.match(/^https?:\/\/vimeo\.com\/.+\/.+/)){
					var $running=$('#vimeo #running'),
						$success=$('#vimeo #success'),
						$error=$('#vimeo #error');
					function hideMsgs(){
						if(sto) clearTimeout(sto);
						sto=setTimeout(function(){
							$success.fadeOut('slow');
							$error.fadeOut('slow');
						},3000);
					}
					pub=false;
					$success.hide();
					$error.hide();
					if(!vc) $running.show();
					vc++;
					$.ajax({
						url:'http://vimeo.com/api/oembed.json',
						type:'GET',
						data:{ url:URL },
						success:function(data){
							if(that.value==URL){
								that.value='http://vimeo.com/'+data['video_id'];
								$success.show();
								hideMsgs();
							}
						},
						error:function(){
							$error.show();
							hideMsgs();
						},
						complete:function(){
							vc--;
							if(!vc) $running.hide();
							pub=true;
						}
					});
				}
			}).trigger('change');
			//acciones key
			$('#txtStock').keydown(function(e){
				if($(this).val()=='0'){ $(this).val(''); }
				var caracter=e.keyCode
				if((!validaKeyCode('interger',caracter))&&(!validaKeyCode('direction',caracter))&&(!validaKeyCode('delete',caracter))&&(!validaKeyCode('escape',caracter))&&(!validaKeyCode('tab',caracter)))
					e.preventDefault();
				if((($(this).val().length>3))&&(!validaKeyCode('direction',caracter))&&(!validaKeyCode('delete',caracter))&&(!validaKeyCode('escape',caracter))&&(!validaKeyCode('tab',caracter)))
					e.preventDefault();
			});
			$('#txtPrice').keydown(function(e){
				var caracter=e.keyCode
				if(($(this).val()=='')&&((caracter==48)||(caracter==96)))
					e.preventDefault();
			});
			//acciones focus
			$("#txtName").keydown(function(e){
				var caracter=e.keyCode
				if($(this).val().length>=50&&!validaKeyCode('delete',caracter)&&(!validaKeyCode('direction',caracter))){
					e.preventDefault();
				}
			});
			//acciones de cambio (change)
			$('#selectTypePrice').on('change','select',function(){
				if(this.value=='dollar'){
					$('#value_Input_Price').html('$');
					$('#mPoints').slideUp();
					$('#txtMethod').val('1');
					$('#txtPrice').blur(function(){
						$(this).formatCurrency({symbol:''});
					});
				}else if(this.value=='points'){
					$('#value_Input_Price').html('<?=STORE_TITLEPOINTS?>');
					$('#mPoints').slideDown();
					$('#txtMethod').val('0');
				}else{
					$('#mPoints').slideUp();
					$('#txtMethod').val('');
					$('#value_Input_Price').html('');
				}
			});
			//success despues del submit
			var options={
                dataType:'json',
				success:function(data){ // post-submit callback
					console.log(data);
                    switch(data['action']){
                        case 'img': 
                            setBG(data['img']['img'],data['img']['pos']);
                            for(var x=1;x<6;x++){ $('#photo'+x).removeAttr('requerido'); }
                        break;
                        case 'insert': redir('mypublications?'); break;
                        case 'update': redir('detailprod?prd=<?=md5($_GET['idProd'])?>'); break;
                        case 'delete': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=STORE_DELETE_PROD_NOW?></trong></div>','','',250,'','detailprod?prd=<?=md5($_GET['idProd'])?>'); 
                        break;
//                        case 'insert': case 'update':  break;
                        case 'no-update': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=STORE_MESSAGE_NOT_DELETE?></trong></div>','','',200,'','detailprod?prd=<?=md5($_GET['idProd'])?>'); 
                        break;
                        case 'no-per-id-update': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=NOT_BELONG_PRODUCT?></trong></div>','','',200,'','mypublications?');  
                        break;//NOT_BELONG_PRODUCT colocar arriba 
                        case 'no-id-update': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=JS_ERROR?></trong></div>','','',200,'','store?');
                        break;
                        default:    message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<?=ALLFIELDSAREREQUIRED?>','','','','','');
                    }
				}//success
			};//options
			$('#frmProducts').ajaxForm(options);
		}
	//declaracion de funciones

	function setBG(img,id){
		$('#backgSelect_'+id).val(img);
		var url=(img.match(/default/i)?'<?=DOMINIO?>':'<?=FILESERVER?>')+'img/'+img;
		$('#loaderStore'+id).css('display','none');
        if (id!='') $('.bgS'+id).css('background-image','url('+url+')').css('background-size','100%');
        else $('#div_backgroundUsersPrev div').css('background-image','url('+url+')').css('background-size','100%');
	}

	function selectT_Price(fp){
		var option='';		
		option='<option id="dollar" value="dollar" '+((fp && fp==1)?'selected':'')+'><?=TYPEPRICEMONEY?></option>'+
				'<option id="points" value="points" '+((fp && fp==0)?'selected':'')+'><?=STORE_TITLEPOINTS?></option>';
		if(fp) $('#txtMethod').val(fp);	
		$('#selectTypePrice').empty().html(
			'<select>'+
				'<option value="...">...</option>'+
				option+
			'</select>'
		);
		$('#selectTypePrice select').chosen({ disableSearch:true,width:200 });
	}
	function categorys(vector,id){
		if(id){ $('#txtCategory').val(id);}
        else id='';
		var select='<select><option value="...">...</option>';
			for(var a in vector){
				select+='<option value="'+vector[a]['id_category']+'" '+((id==vector[a]['id_category'])?'selected':'')+'>'+vector[a]['category_name']+'</option>';
			}
			select=select+'</select>';
		$('#category').empty().html(select);
		$('#category select').chosen({ disableSearch:true,width:200 });
		changeCategorys(vector);
	}
	function subCategorys(id,vector,i){
		if(i){ $('#txtSubCategory').val(i); }
		else i='';
		var select='<select>'+
				'<option value="...">...</option>';
			if(id)
			for(var a in vector[id]['sub_category']){
				select+='<option value="'+vector[id]['sub_category'][a]['id']+'" '+((i==vector[id]['sub_category'][a]['id'])?'selected':'')+'>'+vector[id]['sub_category'][a]['name']+'</option>';
			}
			select=select+'</select>';
		$('#subCategory').empty().html(select);
		$('#subCategory select').chosen({ disableSearch:true,width:200 });
		changeSubCategorys();
	}
	function uploadPhoto(i){
		var i=i?i:'';
		$('#photo'+i).change(function(){
			var imagen=$(this).val();
			if(validaImagen(imagen)){
				var action='controls/store/acctionsProducts.json.php?acc=img'+(i?'&num='+i:'');
				$('#backgSelect_'+i).val("file");
				$('#frmProducts').attr('action',action);
				$('#loaderStore'+i).css('display', 'block');
				$('#frmProducts').submit();
			}else{
				
			}
		});
	}
	function changeCategorys(vector){
		$('#category').on('change','select',function(){
			$('#txtSubCategory').val('');
			if(this.value!='...'){
				$('#txtCategory').val(this.value);
				subCategorys(this.value,vector);
			}else{
				$('#txtCategory').val('');
				subCategorys();
			}
		});
	}
	function changeSubCategorys(){
		$('#subCategory').on('change','select',function(){
			$('#txtSubCategory').val(this.value!='...'?this.value:'');
		});
	}
	<?php }else{ ?>
        message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=NOT_BUSINEES_INCORRUP?></trong></div>','','',200,'','store?');
//		$.dialog({
//			title:'<?=RESET_TITLEALERTEMAILPASSWORD?>',
//			resizable:false,
//			width:350,
//			height:220,
//			modal:true,
//			open:function(){
//				$(this).html('<div syplay="text-aling:center;"><strong><?=NOT_BUSINEES_INCORRUP?></trong></div>');
//			},
//			close:function(){
//				redir("store?");
//			}
//		});
	<?php } ?>
	});
</script>
