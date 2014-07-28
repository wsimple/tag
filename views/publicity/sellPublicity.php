<?php
	session_start();
	include ("../../includes/functions.php");
	include ("../../includes/config.php");
	include ("../../class/wconecta.class.php");
	include ("../../includes/languages.config.php");

	$user_points = campo("users", "id", $_SESSION['ws-tags']['ws-user'][id], "current_points");

	if( $_GET[p] ) {

		$datos = $GLOBALS['cn']->query("SELECT	id,
												title,
												link,
												cost_investment,
												message,
												picture,
												id_currency,
												id_type_publicity AS type

										FROM users_publicity

										WHERE md5(id) = '".$_GET[p]."' AND id_user='".$_SESSION['ws-tags']['ws-user'][id]."'");

		$dato = mysql_fetch_assoc($datos);

	}// if update

	if( $_GET[n] ) {

		$datos = $GLOBALS['cn']->query("SELECT id, name AS 'title', url AS 'link', picture, description AS message

										FROM products_user

										WHERE md5(id) = '".$_GET['n']."' and id_user='".$_SESSION['ws-tags']['ws-user'][id]."'");

		$dato = mysql_fetch_assoc($datos);

	}// if new & prod

	$_SESSION['ws-tags'][chkpublicity] = 1;
?>

<script type="text/javascript">
	$(document).ready(function() {
		
		//contador de caracteres del title
		$('#theCountertitle').textCounter({
			target: '#publi_title', // required: string
			count: 25, // optional: integer [defaults 140]
			alertAt: 20, // optional: integer [defaults 20]
			warnAt: 10, // optional: integer [defaults 0]
			stopAtLimit: true // optional: defaults to false
		});
		
		//contador de caracteres del mensaje
		$('#theCounter').textCounter({
			target: '#publi_msg', // required: string
			count: 90, // optional: integer [defaults 140]
			alertAt: 20, // optional: integer [defaults 20]
			warnAt: 10, // optional: integer [defaults 0]
			stopAtLimit: true // optional: defaults to false
		});
	
		//Formatea la moneda 
		$('#publi_amount_1').blur(function(){
			$(this).val( ( $(this).val()<10?10:$(this).val() ) ); //Montoo minimo de inversion 10
        	$('#publi_amount_1').formatCurrency({symbol:''});
        	updateUI(parseFloat( $(this).val().replace(',','') ), 'showBuyedClicks');
        }).keyup(function(event) {
        	updateUI(parseFloat( $(this).val().replace(',','') ), 'showBuyedClicks');
        });

		if( '<?=($_GET[p] ? true : false)?>' ) {
			if( '<?=$dato[id_currency]=='3' ? true : false?>' ) {

				showHide('point_input', 'point_tittle', 'cost_input', 'cost_tittle');
				$('#payment').val('3');
				document.sell_publi.checkboxx.checked = true;
				document.sell_publi.number_of_points.value = '<?=$dato['cost_investment']?>';
				updateUI(document.sell_publi.number_of_points.value, 'showedClicks');

			} else {
				amount = '<?=$dato[cost_investment]?>';
				document.sell_publi.publi_amount_1.value = amount;
				$('#publi_amount_1').formatCurrency({symbol:''});
				// document.sell_publi.publi_amount_2.value = amount[1];
				updateUI(parseFloat(document.sell_publi.publi_amount_1.value), 'showBuyedClicks');
			}
		}

		$('#checkboxx').bind('change', function() {

			if( document.sell_publi.checkboxx.checked ) {

				showHide('point_input', 'point_tittle', 'cost_input', 'cost_tittle');
				$('#payment').val('3');

			} else {

				showHide('cost_input', 'cost_tittle', 'point_input', 'point_tittle');
				$('#payment').val('1');
			}
		});
		
		$('#buttonPubli').click(function(){
			$("#photoDIV input").trigger( "click" );
			//$("#photoDIV input").attr('type','file').trigger( "click" );
			 
			//console.log($('#photoDIV input[type="file"]').val());
			//$('#photoDIV input').click();
			
		});
		$('#publi_img').on('change',function(){
			$('#text_photo').html($('#photoDIV input').val());
		});
		$('#number_of_points').keyup(function() {
			foco = this.id;

			if( <?=$user_points?> >= document.sell_publi.number_of_points.value ) {

				updateUI(document.sell_publi.number_of_points.value, 'showedClicks');

			} else {

				$('#number_of_points').val('<?=$user_points?>');
				updateUI('<?=$user_points?>', 'showedClicks');
			}

		});

		
	});


</script>

<?php if(($_GET[p]!='')||($_GET[n]!='')) {?>

<script type="text/javascript">
	$(document).ready(function(){

		$("#sendPubliData").click(function(){

			if (valida('sell_publi')) $('#sell_publi').submit();
		});

		$("#cancelPubliData").click(function(){
			$("#sellpubliUpdate").dialog( "destroy" );
			$("#sellpubliUpdate").dialog( "close" );
		});

		var options = {
			success: function(data){ // post-submit callback
				//alert(data);

				if(data=='1'){
					showAndHide('sponsor_msgerror', 'sponsor_msgerror', 1500, true);
				}else{
					if(data=='2'){
						showAndHide('sponsor_msgerror2', 'sponsor_msgerror2', 1500, true);
					}else{
						if(data=='3'){
							showAndHide('sponsor_msgerror3', 'sponsor_msgerror3', 1500, true);
						}else{
							$("#sellpubliUpdate").dialog( "destroy" );
							setTimeout(function(){$("#sellpubliUpdate").dialog("close");}, 500);
							redir('publicity?'+Math.random());
						}

					}

				}

			}//success
		};//options

		$('#sell_publi').ajaxForm(options);

	});
</script>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function(){
//		$("button, input:submit, input:reset, input:button").button();
	});
</script>
<div id="addSellPublicity">

<!--<div id="send_mail">-->
	<form id="sell_publi" name="sell_publi" action="controls/publicity/sellPublicity.controls.php" method="post" enctype="multipart/form-data">
		<table border="0" align="center" cellpadding="1" cellspacing="1">
			<tr>
				<td colspan="2" id="cellErrorPublicity">
					<div id="sponsor_msgerror">	<?=SPONSORTAG_SPANERROR?>	</div>
					<div id="sponsor_msgerror2"><?=SPONSORTAG_SPANERROR2?>	</div>
					<div id="sponsor_msgerror3"><?=SPONSORTAG_SPANERROR3?>	</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" id="cellSuccessPublicity">
					<div id="sponsor_msgeexito"><?=SPONSORTAG_SPANEXITO?></div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					(*)&nbsp;<?=PUBLICITY_LBLTITLE?>:&nbsp;<span>(<?=PUBLICITY_HELPTITLE?>)</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="publi_title" id="publi_title" type="text" value="<?=$dato[title]?>" />
					<span id="theCountertitle"></span>&nbsp;max
				</td>
			</tr>
			<tr>
				<td colspan="2">
					(*)&nbsp;<?=PUBLICITY_LBLLINK?>:&nbsp;<span>(<?=SPONSORTAG_LBLLINKHELP?>)</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="publi_link" type="text" id="publi_link" value="<?=(($dato["link"]!="")?$dato["link"]:'http://')?>" tipo="url" />
				</td>
			</tr>
			<tr>
				<td id="cost_tittle" colspan="2" <?php if ($_GET[p]!="" && $_GET[resend]==''){?> class="displayNone" <?php } ?> >
					(*)&nbsp;<?=PUBLICITY_LBLINVESTMENT?>:&nbsp;<span>(<?php echo (!PAYPAL_PAYMENTS) ? USERPUBLICITY_POINTS_INVESTMENT_TITTLE : SPONSORTAG_LBLINVESTMENTHELP ; ?>)</span>
				</td>
<!--
				<td id="point_tittle" colspan="2" style="display:none">
					(*)&nbsp;<?=USERPUBLICITY_POINTS_INVESTMENT_TITTLE?>&nbsp;
				</td>-->
			</tr>
			<tr>
				<td colspan="2">
					<div id="cost_input">
						<div id="divInputCost">
							<input id="publi_amount_1" name="publi_amount_1"
								   <?=$_GET[p] && !isset($_GET[again]) ? 'disabled' : ''?>
								   onkeypress="return numbersonly(event, true);"
								   value="<?=( $dato[cost_investment] ? $dato[cost_investment] : '10.00')?>"/>
						</div>
						<div id="showClickPublicity">
							<div><?=PUBLICITY_AVAILABLE_CLICKS?>:</div>
							<div>
								<strong>
									<input id="showBuyedClicks" name="showBuyedClicks" disabled value="<?=factorPublicity(2, 10.00)?>"/>
								</strong>
							</div>
						</div>
					</div>

					<div style="height: 30px; display: none;" id="point_input">
						<div style="padding: 0px; width: 65px; height: 25px; float: left;">
							<input	id="number_of_points" name="number_of_points"
									type="text" <?=$_GET[p] && !isset($_GET[again]) ? 'disabled' : ''?>
									onkeypress="return numbersonly(event, true);"
									style="width:65px; text-align: center;"
									value="6"/>
						</div>

						<div style="padding: 2px; margin-left: 15px; width: 185px; float: left;">
							<div style="margin-top: 6px; width: 90px;float: left;"><?=PUBLICITY_AVAILABLE_CLICKS?>:</div>
							<div style="float: left;">
								<strong>
									<input	id="showedClicks" name="showedClicks"
											style="width: 80px; text-align: left; border: 0; color: #F58220; background-color: #eeeeee; text-align: left"
											value="<?=factorPublicityPoints(2, 6)?>"/>
								</strong>
							</div>
						</div>
					</div>

				</td>
			</tr>
			<tr>
				<td colspan="2">(*)&nbsp;<?=PUBLICITY_LBLPICTURE?>:&nbsp;<span>(<?=PUBLICITY_HELPPHOTO?>)</span>
				</td>
			</tr>
			<tr>
				<td>
					<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1) { $dato[picture] = 'prueba';?>
						<div  id="photoDIV"  class="invisible">
							<input name="publi_img" type="file" id="publi_img" value="<?=$dato[picture]?>" style="width:0px;height: 10px">
						</div>
						<input name="publi_img" type="button" id="buttonPubli" value="<?=NEWTAG_UPLOADBACKGROUND?>" style="width:150px;" />
						<span id="text_photo"></span>
					<?php } else {
						echo "&nbsp;";
					} ?>
				</td>
				<td>&nbsp;</td>
			</tr>


			<?php if( $_GET[p] || $_GET[n] ) { ?>
				<input type="hidden" name="picture" id="picture"
					   value="<?=(	fileExistsRemote(FILESERVER."img/".($_GET[p]!="" ? 'publicity' : 'products')."/".$dato[picture])?$dato[picture] : "")?>" />
				<tr>
					<td colspan="2">
						<?php if( fileExistsRemote(FILESERVER."img/".($_GET[p] ? 'publicity' : 'products')."/".$dato[picture])) { ?>
							<img src="includes/imagen.php?tipo=1&porc=50&img=<?=FILESERVER?>img/<?=($_GET[p] ? 'publicity' : 'products')?>/<?=$dato[picture]?>" />
						<?php } else {
							echo "&nbsp;";
						} ?>
					</td>
				</tr>
			<?php } ?>


			<tr>
				<td colspan="2">(*)&nbsp;<?=PUBLICITY_LBLMESAGGE?>:&nbsp;<span>(<?=PUBLICITY_HELPMESSAGE?>)</span></td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea name="publi_msg" id="publi_msg"><?=trim($dato[message])?></textarea><br>
					<span id="theCounter"></span>&nbsp;max
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<div class="textRequiredPublicity" align="center"> <?=REQUIRED?> </div>
					<input type="hidden" name="id_p" id="id_p" value="<?=$_GET[p]?>" />
					<input type="hidden" name="n" id="n" value="<?=$_GET[n]?>" />
					<input type="hidden" name="type_p" id="type_p" value="<?=$dato[type]?>" />
					<input type="hidden" name="op" id="op" value="<?=($_GET[p] && !$_GET[resend] ? 2 : '')?>" />
					<input type="hidden" name="resend" id="resend" value="<?=$_GET[resend]?>" />
					<?=(isset($_GET[again]) ? '<input type="hidden" name="do" id="do" value="'.$_GET[p].'"/>' : '')?>

				</td>
			</tr>
		</table>

		<div style=" <?=$_GET[p] || $_SESSION['ws-tags']['ws-user'][type]==1 ? 'display: none' : ''?>;">
			<input id="checkboxx" type="checkbox" name="checkboxx"/>
			<font class="textRequiredPublicity"><?=USERPUBLICITY_KINDOF_PAYMENT?></font>
			<input type="hidden" name="payment" id="payment" value="1"/>
		</div>
	</form>
<!--</div>-->
<div class="clearfix"></div>
<div class="space"></div>
</div>
<?php if($_GET[p]!='') {?>
<div style="float: right; margin-top: 10px">
	<input id="cancelPubliData" type="button" value="<?=JS_CANCEL?>">
	<input id="sendPubliData" type="button" value="<?=JS_CONFIG?>">
</div>
<?php } ?>