<?php
if (!isset( $_SESSION['business_payment'] ) || $_GET['uid']==''){
	redirect('index.php');
	die();
}
// datos del usuario
$result=CON::getRow("SELECT u.id AS id, u.profile_image_url AS photo, u.email,
						CONCAT(name,' ',last_name) AS full_name, 
						MD5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code
 						FROM users u 
			 			WHERE md5(concat(u.id,'_',u.email,'_',u.id))=? LIMIT 1",array($_GET['uid']));
$fot_	= FILESERVER.getUserPicture($_GET['uid'].'/'.$result['photo'],'img/users/default.png');

//plan por defecto y costo de la inscripcion
$plan=CON::getVal("SELECT id_plan FROM users_plan_purchase 
				WHERE id_user=? ORDER BY id DESC LIMIT 1;",array($result['id']));
if ($plan!==null) $subcriptionPrice = 0;
else{
	$plan=1;
	$subcriptionPrice=CON::getVal('SELECT cost_account_company FROM config_system WHERE id = 1 LIMIT 1;');
}

//Tipos de cuentas business.
$query=CON::query("	SELECT *, p.id AS idPlan FROM subscription_plans p
			 		INNER JOIN subscription_plans_detail d ON p.id=d.id_plan
 		  			WHERE p.status = 1 ORDER BY p.id DESC");
?>
<container id="paypal-help" class="bg cache">
	<content>
	<div class="pay-help ui-single-box">
		<div class="ui-single-box-title"><?=SIGNUP_SELECTPLANTITLE?></div>
		<div class="pay-help-content">
			<div class="user-info">
				<div class="bg"><img src="<?=$fot_?>" width="60" height="60"></div>
				<div class="info">
					<strong><?=formatoCadena($result['full_name'])?></strong>
					<br><span><?=$result['email']?></span>
				</div>
			</div>
			<form action="controls/users/nonprofitDocuments.php" method="POST" enctype="multipart/form-data" id="frmBusiness">
				<div class="account-types">
					<h4><?=SIGNUP_PLANS_INFO?></h4>
					<em><?=MSG_PAYPAL_HELP?></em>
					<ul class="plans clearfix">
					<?php
					while ( $type=CON::fetchAssoc($query) ):
						//Verifica si los planes tienen traduccion
						$name = (defined($type['name'])) ? constant($type['name']) : $type['name'] ;
						$description = (defined($type['description'])) ? constant($type['description']) : $type['description'] ;
						//Checkeaa y activa un plan previamente comprado o selecciona el 1ero por defecto
						$selected = ( $type['idPlan'] == $plan ) ? 'checked="checked"' : '';
						$features = explode(',', $type['features']);
						//Dias de la suscripcion
						switch ($type['days']) {
							case 30: $subDays = TOPTAGS_MONTHLY; break;
							case 36: $subDays = TOPTAGS_QUARTERLY; break; 
							case 365: $subDays = TOPTAGS_YEARLY; break;
							case 0: $subDays = SIGNUP_UNLIMITEDLBL; break;
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
					<?php endwhile; ?>
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
											<div class="prevPhotoStore" style="width:87px;">
												<div n="'.($i+1).'" title="'.NEWTAG_UPLOADBACKGROUND.'" class="bgS'.($i+1).'" >
												</div>
												<img id="loaderStore'.($i+1).'" style="display:none;position: relative;top:-25px;" src="img/loader.gif" width="25" height="25" />
											</div>
											<div id="photoDIV'.($i+1).'" class="invisible"><input accept="image/jpg,image/jpeg,image/png,image/bmp" type="file" id="photo'.($i+1).'" class="invisible" name="document[]" requerido="'.SIGNUP_DOCSLBL.'"/></div>
											<input type="hidden" id="backgSelect_'.($i+1).'" name="backgSelect_'.($i+1).'" value=""/>
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
			document.location = "views/pay.view.php?uid=<?=md5($result['id'])?>"+'&plan='+selectedPlan;
			return false;
		}else{
			var band='<?=(($plan!==null && $plan==0)?"true":"false")?>';
			band=band=='true'?true:false;
			$("input.invisible[id^='photo']").each(function(index, el) {
				if( $(el).val() != '' ){
					$('#loaderStore'+(index+1)).css('display','block');
					band=true;
				}
			});
			if (band){
				//Mando Formulario en caso de cuenta NoN-Profit
				$('#frmBusiness').ajaxSubmit({
					dataType: 'json',
					success: function(data){ // post-submit callback
						console.log(data);
						// var msgTitle = 'Error',msgContent = '',location='';
						// switch(data.result){
						// 	case -1: 
						// 		msgContent = '<?=SIGNUP_ERRORUPLOAD?>'; 
						// 		location=document.location;
						// 	break;
						// 	case 0: msgContent = '<?=SIGNUP_ERRORREGISTER?>'; break;
						// 	case 1:
						// 		msgTitle = '<?=JS_ALERT?>';
						// 		msgContent = '<?=SIGNUP_SUCCESSREGISTERNONPROFIT?>';
						// 	break;
						// }
						// if( data.result == 1 || data.result == -1) {
						// 	$.dialog({
						// 		title:msgTitle,
						// 		resizable:false,
						// 		width:320,
						// 		height:300,
						// 		modal:true,
						// 		open:function(){ $(this).html(msgContent); },
						// 		close:function(){ document.location=location; },
						// 		buttons:{
						// 			'<?=JS_OK?>':function(){
						// 				$(this).dialog('close');
						// 			}
						// 		}
						// 	});
						// }else{
						// 	for (var i=0; i<5; i++) $('#loaderStore'+(i+1)).css('display','block'); 
						// 	// $('div.bgS'+item).css('background-image','url(css/smt/document.png)'); 
						// }
					},//success
					error: function(data){
						message('<?=NEWTAG_LBLTEXT?>','Error','<?=JS_ERROR?>','','','','','');
					}
				});
			}else{ message('<?=NEWTAG_LBLTEXT?>','Error','<?=$lang["NODOCUMENTSNONPROFIT"]!=""?$lang["NODOCUMENTSNONPROFIT"]:"Please enter the required documents to verify your account"?>','','','','',''); }
		}
	});
	$('.price, .total-details span').formatCurrency();
	$('#actualUrl').attr('value',document.location.href); //fix
	<?php if ($plan!==null && $plan==0){ ?>
	 $('.content-plan input[type=radio]').change();
	 <?php } ?>
}); //Document ready
</script>