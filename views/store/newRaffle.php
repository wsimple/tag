<?php
	include('../../includes/session.php');
	include('../../includes/config.php');
	include('../../includes/functions.php');
	include('../../class/wconecta.class.php');
	include('../../includes/languages.config.php');
	$select='';$where='';$join='';$products_price='(*) '.MNUUSER_LABELPOINTER;$products_user_cant='(*) '.PRODUCTS_USER_CANT;
	if (isset($_GET['idRaffle'])){
		$products_price=MNUUSER_LABELPOINTER;
		$products_user_cant=PRODUCTS_USER_CANT;
		$select=',r.cant_users AS cant_users,
				r.points AS points,
				r.start_date AS start_date,
				r.end_date AS end_date';
		$where=' AND md5(r.id)="'.$_GET['idRaffle'].'"';
		$join=' INNER JOIN store_raffle r ON r.id_product=p.id';
	}
	$sql = 'SELECT  p.id,
        (SELECT CONCAT(a.name," ",a.last_name) FROM users a WHERE a.id=p.id_user) AS seller,
		p.id_status AS status,
        p.id_category AS category,
        p.id_sub_category AS subCategory,
		(SELECT name FROM store_category WHERE id=p.id_category) AS name_category,
		(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS name_subCategory,
        p.name,
        p.description,
        p.sale_points AS cost,
        p.photo
		'.$select.'
    FROM `store_products` AS p
	'.$join.'
    WHERE md5(p.id)="'.$_GET['idProd'].'" '.$where.'
    LIMIT 1;';
	$result = $GLOBALS['cn']->query($sql);
	$product = mysql_fetch_assoc($result);
?>
<div>
	<!--<div class="ui-single-box-title"><?=($_GET['idProd'])?PRODUCTS_EDIT_RAFFLE:PRODUCTS_NEW_RAFFLE?></div>-->
	<div id="dialogBck"></div>
	<div id="store">
		<form action="controls/store/acctionsProducts.json.php" method="get"  name="frmProducts" id="frmProducts">
			<div id="fields_error"	name="fields_error" class="error_addNewProductsView"> <?=ALLFIELDSAREREQUIRED ?>	</div>
			<div id="fields_error_repeat"	name="fields_error_repeat" class="error_addNewProductsView"> <?=STORE_DUPLICATERAFFLE ?>	</div>
			<div id="fields_error_notNable"	name="fields_error_notNable" class="error_addNewProductsView"> <?=STORE_NOT_AVAILABLE?>	</div>
			<div class="list_inline">
				<div class="detail-box limitComent raffle">
					<h3><?=formatoCadena($product['name'])?></h3>
					<div class="prevPhotoStore" style="display: block;"><div style="background-image: url('<?=FILESERVER."img/".$product['photo']?>');background-repeat:repeat;background-size:100%;"></div></div>
					<label><strong><?=STORE_CATEGORIES2?>:</strong><span><?=' '.constant($product['name_category'])?></span></label><br>
					<label><strong><?=STORE_CATEGORIES3?>:</strong><span><?=' '.constant($product['name_subCategory'])?></span></label><br>
					<a action="detailProd,<?=$_GET['idProd']?>,dialog"><?=TIMELINE_TITLETAGSPONSOR?></a>
				</div>
				<div class="detail-box raffle">
					<div>
						<label ><strong><?=$products_price?></strong></label><br />
						<?php if($_GET['idRaffle']){ ?>
						<label id="lblCost"><?=$product['points']?></label>
						<?php }else{ ?>
						<input name="txtPrice" type="text" id="txtPrice" size="5" class="txt_box" value="" requerido="<?=PRODUCTS_PRICE?>"/>
						<?php } ?>
					</div>
					<div>
						<label ><strong><?=$products_user_cant?></strong></label><br />
						<?php if($_GET['idRaffle']){ ?>
						<label><?=$product['cant_users']?></label>
						<?php }else{ ?>
						<input name="txtCant" type="text" id="txtCant" size="5" class="txt_box" value="" requerido="<?=PRODUCTS_USER_CANT?>"/>
						<?php } ?>
					</div>
					<?php if($_GET['idRaffle']){ ?>
					<div>
						<label ><strong><?=PRODUCTS_FECHA_INI?></strong></label><br />
						<label><?=$product['start_date']?></label>
					</div>
					<?php if($product['end_date']){ ?>
					<div>
						<label ><strong><?=PRODUCTS_FECHA_END?></strong></label><br />
						<label><?=$product['end_date']?></label>
					</div>
					<?php } 
					} ?>
				</div>
				<input type="hidden" name="id" id="id" value="<?=($_GET['idProd'] ? $_GET['idProd'] : '')?>">
				<input type="hidden" name="acc" id="acc" value="3">
			</div>
			<div class="clearfix"></div>
				
			<div class="footerStore">
				<br>
				<?php if(!$_GET['idRaffle']){ ?><label style="font-size: 11px;" ><strong><?=REQUIRED?></strong></label><br><?php } ?>
				<input type="hidden" id="idProduct" name="idProduct" value="<?=$product['id']?>"/> <?php //tipo tag es el submit completo el tipo image es el submit del upload de la imagen ?>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		//variables
		var idproduct='<?=$product['id']?>';
		//inicializar caracteristicas de cada elemento unico
		$('.prevPhotoStore div').css('cursor','initial');

		$('#lblCost').formatCurrency({symbol:''}); //Formato de moneda
	
		//formatear los precios
		$('#txtPrice').formatCurrency({symbol:''});
		$('#txtPrice').blur(function(){
			$(this).formatCurrency({symbol:''});
			var auxi=$(this).val().split('.');;
			$(this).val(auxi[0]);
		});
		
		//acciones key
		//acciones de keydown para validar las entradas en el campo price
		$('#txtPrice').keydown(function(e){
			var caracter=e.keyCode
			if ((!validaKeyCode('interger',caracter))&&(!validaKeyCode('direction',caracter))&&(!validaKeyCode('delete',caracter))&&(!validaKeyCode('escape',caracter))&&(!validaKeyCode('tab',caracter)))
				e.preventDefault();
			if ((($(this).val().length>3))&&(!validaKeyCode('direction',caracter))&&(!validaKeyCode('delete',caracter))&&(!validaKeyCode('escape',caracter))&&(!validaKeyCode('tab',caracter)))
				e.preventDefault();
			if (($(this).val()=='')&&((caracter==48)||(caracter==96)))
				e.preventDefault();
		});
		//end acciones key

		//success despues del submit
        var options={
            dataType:'json',
			success:function(data){ // post-submit callback
                switch(data['action']){
                    case 'rifa':  
                        if (window.location.hash='#myfreeproducts') location.reload();
    					else redir('myfreeproducts');
    					$('#default-dialog').dialog( "close" );
                    break;
                    case 'exist': showAndHide('fields_error_repeat', 'fields_error_repeat', 2500, true); break;
                    case 'no-stock': showAndHide('fields_error_notNable', 'fields_error_notNable', 2500, true); break;
                    case 'no-update': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=STORE_MESSAGE_NOT_DELETE?></trong></div>','','',200,'','detailprod?prd=<?=md5($_GET['idProd'])?>'); 
                    break;
                    case 'no-per-id-update': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=NOT_BELONG_PRODUCT_RAFFLE?></trong></div>','','',200,'','store?');  
                    break;//NOT_BELONG_PRODUCT_RAFFLE colocar arriba 
                    case 'no-id-update': message('#default','<?=RESET_TITLEALERTEMAILPASSWORD?>','<div syplay="text-aling:center;"><strong><?=JS_ERROR?></trong></div>','','',200,'','store?'); break;
                    default:    showAndHide('fields_error', 'fields_error', 2500, true);
                }
			}//success
		};
		$('#frmProducts').ajaxForm(options);
	});
</script>
