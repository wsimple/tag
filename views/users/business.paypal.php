<?php
if (!isset( $_SESSION['business_payment'] ) || $_GET['uid']==''){
	redirect('index.php');
	die();
}
$query  = 'SELECT u.id AS id, u.profile_image_url AS photo, u.email, 
			CONCAT(name," ",last_name) AS full_name, MD5(CONCAT(u.id,\'_\',u.email,\'_\',u.id)) AS code
			FROM users u 
			-- INNER JOIN users_plan_purchase p ON u.id = p.id_user
			WHERE md5(concat(u.id,\'_\',u.email,\'_\',u.id))="'.$_GET['uid'].'" LIMIT 1';
$result = $GLOBALS['cn']->query($query);
$result = mysql_fetch_assoc($result);
$fot_	= FILESERVER.getUserPicture($_GET['uid'].'/'.$result['photo'],'img/users/default.png');
$userId = md5($result['id']);

//Costo de suscipcion 
$subcriptionPrice = $GLOBALS['cn']->queryRow('SELECT cost_account_company FROM config_system WHERE id = 1 LIMIT 1;');
$subcriptionPrice = $subcriptionPrice['cost_account_company'];

//Verifica si ya a pagado suscripción tiene un plan
$plan = 3;
$query = "SELECT id_plan FROM users_plan_purchase WHERE id_user='".$result['id']."' AND id_plan > 0 ORDER BY id DESC LIMIT 1;";
$userPlan = $GLOBALS['cn']->query($query);
if(mysql_num_rows($userPlan) > 0){
	$userPlan = mysql_fetch_assoc($userPlan);
	$subcriptionPrice = 0;
	$plan = $userPlan['id_plan'];
}

//Tipos de cuentas business.
$query = 'SELECT *, p.id AS idPlan FROM subscription_plans p
		  INNER JOIN subscription_plans_detail d ON p.id=d.id_plan
		  WHERE p.status = 1 ORDER BY p.id DESC';
$types=$GLOBALS['cn']->query($query);
?>
<container id="paypal-help" class="bg cache">
	<content>
	<div class="pay-help ui-single-box">
		<div class="ui-single-box-title">
			<?=SIGNUP_SELECTPLANTITLE?><br>
		</div>
		<div class="pay-help-content">
			<div class="user-info">
				<div class="bg"><img src="<?=$fot_?>" width="60" height="60"></div>
				<div class="info">
					<strong><?=  formatoCadena($result['full_name'])?></strong>
					<br><span><?=$result['email']?></span>
				</div>
			</div>
			<form action="controls/users/nonprofitDocuments.php" method="POST" enctype="multipart/form-data" id="frmBusiness">
				<div class="account-types">
					<h4><?=SIGNUP_PLANS_INFO?></h4>
					<em>
						<?=MSG_PAYPAL_HELP?>
					</em>
					<ul class="plans clearfix">
					<?php
					while ( $type=mysql_fetch_assoc($types) ):
						//Verifica si los planes tienen traduccion
						$name = (defined($type['name'])) ? constant($type['name']) : $type['name'] ;
						$description = (defined($type['description'])) ? constant($type['description']) : $type['description'] ;

						//Checkeaa y activa un plan previamente comprado o selecciona el 1ero por defecto
						$selected = ( $type['idPlan'] == $plan ) ? 'checked="checked"' : '';

						$features = explode(',', $type['features']);

						//Dias de la suscripcion
						switch ($type['days']) {
							case 30:
								$subDays = TOPTAGS_MONTHLY;
							break;
							case 36:
								$subDays = TOPTAGS_QUARTERLY;
							break;
							case 365:
								$subDays = TOPTAGS_YEARLY;
							break;
							case 0:
								$subDays = SIGNUP_UNLIMITEDLBL;
							break;
						}
					?>

						<label>
							<li class="content-plan" title="<?=$type['description']?>">
								<h3>
									<input type="radio" name="plan" id="plan<?=$type['idPlan']?>" value="<?=$type['idPlan']?>" <?=$selected?> >
									<span id="name<?=$type['idPlan']?>"><?=$name?></span>
								</h3>
								<h5><?=SIGNUP_BENEFITSLBL?></h5>
								<ul class="benefits">
									<li><?=($type['ads'] < 1) ? 'No' : $type['ads'] ;?> Ad</li>
									<li><?=($type['banners'] < 1) ? 'No ' : $type['banners'] ;?> Banners</li>
								</ul>
								<h5><?=SIGNUP_FEATURESLBL?></h5>
								<ul class="features">
								<?php for ($i=0; $i < 8; $i++){
									$label = ($features[$i] == '') ? '<li style="list-style: none;">&nbsp;&nbsp;' : '<li>' ;
									echo $label.$features[$i].'</li>';
								} ?>
								</ul>
								<div class="plan-days"><?=$subDays?></div>
								<div id="price<?=$type['idPlan']?>" class="price color_green"><?=($type['price'] <= 0) ? SIGNUP_EXONERATEDLBL : $type['price'] ;?></div>
							</li>
						</label>
					<?php
					endwhile;
					?>
					</ul>
					<div id="calculator">
						<div class="hr-double"></div>
						<div class="total-details">
							<ul>
								<li class="detail-plan"><?=(true) ? 'Plan '.PUBLICITY_TITLETABLE_COST: PUBLICITY_TITLETABLE_COST.' Plan'; ?> <span></span></li>
								<li class="detail-subcription"><?=SIGNUP_FEELBL?>: <span><?=$subcriptionPrice?></span></li>
							</ul>
							<hr class="hr-medium">
							<?php echo EXPIREDACCOUNT_TITLEITEMSPAYPAL; ?>: <span></span>
						</div>
					</div>
					<div class="info-account-free">
						<ul>
							<li><?=SIGNUP_NONPROFIT_INFO?></li>
							<li>
							<label ><strong>(*) <?=SIGNUP_DOCSLBL?></strong></label>
							<?php 
								echo '<div>';
								for ($i=0;$i<5;$i++){
									echo '
										<div id="photoUpload'.($i+1).'" class="frmProfileBotones">
											<!--div id="photoDIVS-'.($i+1).'"></div-->
											<div class="prevPhotoStore">
												<div n="'.($i+1).'" title="'.NEWTAG_UPLOADBACKGROUND.'" class="bgS'.($i+1).'" '.(($photos[($i+1)])?'style="background-image: url(\''.FILESERVER."img/".$photos[($i+1)]['photo'].'\');background-size:100%;"':'').'>
												</div>
												<img id="loaderStore'.($i+1).'" style="display:none;position: relative;top:-25px;" src="img/loader.gif" width="25" height="25" />
											</div>
											<div id="photoDIV'.($i+1).'" class="invisible"><input accept="image/jpg,image/jpeg,image/png,image/bmp" type="file" id="photo'.($i+1).'" class="invisible" name="document[]" value="'.(($_GET[idProd])?$product['photo']:'').'" '.(($_GET[idProd])?'':'requerido="'.PRODUCTS_PICTURE.'"').'/></div>
											<input type="hidden" id="backgSelect_'.($i+1).'" name="backgSelect_'.($i+1).'" value="'.(($photos[($i+1)])?$photos[($i+1)]['photo']:'').'"/>
											<span id="photoSpan'.($i+1).'" class="photoSpan"></span>
											<!--span>'.GROUPS_NEWPHOTO.' ('.($i+1).'): '.STORE_ORDER.'</span-->
											<input name="txtOrder'.($i+1).'" type="hidden" id="txtOrder'.($i+1).'" size="3" maxlength="4"
											class="txt_box" value="'.($i+1).'" requerido="'.STORE_ORDER.' '.GROUPS_NEWPHOTO.' ('.($i+1).')"/>
										</div>
									';
								}
								echo '<div class="clearfix"></div></div>';
							 ?>
							 </li>
						</ul>
					</div>
				</div>
			</form>
			<button id="btnCancel"><?=JS_CANCEL?></button>
			<button id="btnPay"><?=SIGNUP_PAY_FOR_SUBSCRIPTION?></button>
		</div>
	</div>
	</content>
</container>

<script>
var subcriptionPrice = <?=$subcriptionPrice?>;

$(function() {
delete $.fullpage;

$.on({
	open:function(){
		$('footer').hide();
		$('container').fullpage = null;
	}
});
//Establece objetos por defecto
//	$("button, input:submit, input:reset, input:button").button();
	$('.info-account-free').hide();

	//Establece precio del plan por defecto y estilos
	var selectedPlan = $('.content-plan input[type=radio]:checked');
	// console.log("Plan seleccionado"+selectedPlan.val());
	var price = $( '#price'+selectedPlan.val() ).asNumber();
	var total = parseFloat(price+subcriptionPrice);
	$('.detail-plan>span').html( price );
	$('.total-details>span').html( total );
	selectedPlan.parents('li').addClass('selectedPlan');

	//Cambia estilo a marcado
	$('label').click(function(){
		$('li').removeClass('selectedPlan');
		$(this).children('li').addClass('selectedPlan');
	});

	// verifica cambio de estado entre planes 
	$('.content-plan input[type=radio]').change(function(e){
		var btnLabel = '<?=SIGNUP_PAY_FOR_SUBSCRIPTION?>';
		var btnState = ( $(e.target).is('#plan0:checked') && $("input.invisible[id^='photo']").val() == '' ) ? 'disable':'enable';
		var price = $( '#price'+this.value ).asNumber();
		var totalDetailsEle = $('#calculator').clone();
		console.log('Id seleccionado:'+this.value+' y el valor es: '+price);

		//Verifica opcion seleccionada para hacer accion correspondiente
		if ( $(e.target).is('#plan0:checked') ) {
			btnLabel = '<?=JS_CONTINUE?>';
			var total = parseFloat('0.00');

			$('.info-account-free').slideDown('fast');
			$('html,body').animate({
		    	scrollTop: $(".info-account-free").offset().top //Muevo scroll
			}, 2000);
			$('#calculator').remove(); 							//Quita la calculadore de precio
			$('#frmBusiness').append(totalDetailsEle);			//Muevo la calculadora bajo los file inputs

			$('.detail-subcription > span').html( '0.00' );    //Detalles de suscripcion
		}else{
			var total = parseFloat(price+subcriptionPrice);
			$('.info-account-free').slideUp('fast');
			$('#calculator').remove();
			$('.plans').after(totalDetailsEle);						//Muevo cal culadora a su lugar

			$('.detail-subcription > span').html( subcriptionPrice );    //Detalles de suscripcion
		}

		$('.detail-plan span').html( price );
		$('.total-details > span').html( total );
		$('.total-details span').formatCurrency();
		$('#btnPay > span.ui-button-text').html(btnLabel);  //Etiqueta del boton
//		$('#btnPay').button(btnState);						//Estado del boton
	});

	//Verifica inputs files
	$("input.invisible[id^='photo']").change(function(e){
		var inputsFile = $("input.invisible[id^='photo']");
		var item = $(this).attr('id').charAt( $(this).attr('id').length-1 );
		var isValidInput = false;

		//Verifica si almenos un campo file no esta vacio
		for (var i = 0; i < inputsFile.length; i++) {
			if( $(inputsFile[i]).val() != '' ){
				isValidInput = true;
				break;
			}
		};

		//Cambia imagen del file si se a seleccionado algo que subir
		if( $(e.target).val() != '' ){
			$('div.bgS'+item).css('background-image','url(css/smt/document_selected.png)');
		}else{
			$('div.bgS'+item).css('background-image','url(css/smt/document.png)');
		} 

		// activa el boton continuar si hay al menos un archivo que subir
//		if(isValidInput) $('#btnPay').button('enable');
//		else $('#btnPay').button('disable');
	});

	// Levanta cuadro de dialogo subir documento
	$('.prevPhotoStore div').click(function(){
		var num=$(this).attr('n');
		$('#photoDIV'+num+' input').click();
	});

	$('#btnCancel').click(function(e){
		document.location = '';
	});

	//Accion al enviar el formulario a paypal
	$$('#btnPay').click(function(e){
		var selectedPlan = $('.account-types input[name=plan]:checked').val();

		if(selectedPlan != 0 ){
			e.preventDefault();
			e.stopPropagation();
			document.location = "views/pay.view.php?uid="+'<?=$userId?>'+'&plan='+selectedPlan;
			return false;
		}

		$("input.invisible[id^='photo']").each(function(index, el) {
			if( $(el).val() != '' ) $('#loaderStore'+(index+1)).css('display','block');
		});

		//Mando Formulario en caso de cuenta NoN-Profit
		$$('#frmBusiness').ajaxSubmit({
			dataType: 'json',
			success: function(data){ // post-submit callback
				// console.log('La data es:'+data);
				var msgTitle = 'Error';
				var msgContent = '';
				switch(data.result){
					case -1:
						msgContent = '<?=SIGNUP_ERRORUPLOAD?>';
					break;
					case 0:
						msgContent = '<?=SIGNUP_ERRORREGISTER?>'
					break;
					case 1:
						msgTitle = '<?=JS_ALERT?>';
						msgContent = '<?=SIGNUP_SUCCESSREGISTERNONPROFIT?>';
					break;
				}

				if( data.result == 1) {
					$.dialog({
						title:msgTitle,
						resizable:false,
						width:320,
						height:300,
						modal:true,
						open:function(){
							$(this).html(msgContent);
						},
						close:function(){
							document.location='';
						},
						buttons:{
							'<?=JS_OK?>':function(){
								$(this).dialog('close');
							}
						}
					});
				}else{
					$('div.bgS'+item).css('background-image','url(css/smt/document.png)');
				}
			},//success
			error: function(data){
				message('<?=NEWTAG_LBLTEXT?>','Error','<?=JS_ERROR?>','','','','','');
			}
		});
	});
	$('.price, .total-details span').formatCurrency();
	$('#actualUrl').attr('value',document.location.href); //fix
}); //Document ready
</script>