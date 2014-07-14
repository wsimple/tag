<script type="text/javascript" src="js/farbtastic.js"></script>
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>
<link rel="stylesheet" href="css/farbtastic.css" type="text/css" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<script type="text/javascript">

	$(document).ready(function() {

		//text color selector
		colorSelector('hiddenColorDiv','hiddenColor');
		//END - text color selector

		//control de los botones send y back
			$("#frmBusinessCard_btnSend").click(function() {
				$('#frmBusinessCard').submit()
				setTimeout(function(){
					redir('profile?sc=3');
				}, 1000);
	//			$("#frmBusinessCard_btnSend").button("disable");
			});
			//Btn Home
			$("#frmBusinessCard_btnHome").click(function() {
				document.location.hash='profile?sc=3';
			});
		//FIN control de los botones send y back



		//control del formulario businessCard
		<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>

			$('#logoCompany, #newBackground').customFileInput();

			$('#newBackground, #logoCompany').bind('change', function(){
				//$("#frmBusinessCard").submit();
			});

			$("#setDefaultLogoDiv").click(function() {
				$('#bc_companyLogo_url').val("setDefault");
				//$("#frmBusinessCard").submit();
			});

			$("#setDefaultBgDiv, #setDefaultBgButton").click(function() {
				$('#bc_background').val("setDefault");
				//$("#frmBusinessCard").submit();
			});

			//this is for showing and hiding the file choosers
			$("#changeLogoButtonDiv").click(function() {
				$('#changeLogoButtonDiv, #setDefaultLogoDiv, #textColorBC').fadeOut('slow', function(){$('#changeLogoDiv').fadeIn('slow');});
			});

			$('#addBackground').click(function() {
				$("#setDefaultBgDiv, #setDefaultBgButton").fadeOut('slow', function() {
					$("#addBackground").fadeOut('slow', function() {
						$('#newBackgroundDiv').fadeIn('slow');
					});
				});
			});
			//END - this is for showing and hiding the file choosers

		<?php } ?>

		//FIN control del formulario businessCard
	});

	function setBCBackground(pic) { // this is for showing bc background live
		$('#bc_principal').css( {'background-image': 'url('+'<?=FILESERVER?>'+'img/bc_templates/'+pic+')'} );
		$('#bc_background').val(pic);
	}

</script>


<?php

	if( $_GET['bc']!="new" ) {


					$businessCardData = $GLOBALS['cn']->query("	SELECT
																	*
																FROM
																	business_card
																WHERE
																	md5(id) ='".$_GET['bc']."'");
	}

	if( $_GET['bc']=="new" || mysql_num_rows( $businessCardData )>0  ) { //This 'if' controls whether to show the form

		if($_GET['bc']!="new") {
			$bc = mysql_fetch_assoc($businessCardData);
			$bctipo=$bc['type'];
		}
?>


	<script>
		$(document).ready(function(){
			colorSelector('hiddenColorDiv','hiddenColor');			
		});



		$('#frmBusinessCard').ajaxForm({
			success : function(responseText) {
				if( responseText ) {

					//alert(responseText);

					responseText = responseText.split('|');
					$('#bc_embedded_middleText').css({ color: responseText[9] });
					$('#bc_embedded_middleText').html(responseText[2] ? responseText[2] : 'Tagbum.com');
					$('#bc_embedded_specialty').css({ color: responseText[9] });
					$('#bc_embedded_specialty').html(responseText[0]);
					$('#bc_embedded_company').css({ color: responseText[9] });
					$('#bc_embedded_company').html('<strong>'+(responseText[1] ? responseText[1] : 'Social Media Marketing')+'</strong>');

					if( responseText[3] ) {
						$('#addressLabel').css({ color: responseText[9]});
						$('#addressLabel').fadeIn('fast');
						$('#bc_embedded_address').css({ color: responseText[9] });
						$('#bc_embedded_address').html(responseText[3]);
					} else {
						$('#addressLabel').fadeOut('fast');

						$('#bc_embedded_address').html(null);
					}


					$('#bc_embedded_username').css({ color: responseText[9] });

					phone  = responseText[4] ? '<strong><?=HOMEPHONE?></strong>: '		+ responseText[4] : '';
					phone += responseText[5] ? ' <strong><?=WORKPHONE?></strong>: '		+ responseText[5] : '';
					phone += responseText[6] ? ' <strong><?=MOBILEPHONE?></strong>: '	+ responseText[6] : '';

					$('#bc_embedded_phones').css({ color: responseText[9] });
					$('#bc_embedded_phones').html((phone ? phone+'<br/>' : ' '));
					$('#bc_embedded_email').css({ color: responseText[9] });
					$('#bc_embedded_email').html(responseText[7] ? responseText[7] : '<?=$_SESSION['ws-tags']['ws-user'][email]?>');

					$('#bc_principal').css( {'background-image': 'url(<?=FILESERVER?>img/bc_templates/'+responseText[10]+')'} );

					$('#bc_embedded_logo').css( {'background-image': 'url('+(responseText[8] ? '<?=FILESERVER?>img/bc_logos/<?=$_SESSION['ws-tags']['ws-user'][code]?>/'+responseText[8] : 'imgs/logo_business_card.png')+')'} );

					$("#newBackgroundDiv").fadeOut('slow', function() {
						$("#addBackground, #setDefaultBgButton, #setDefaultBgDiv").fadeIn('slow');

					});
					$("#changeLogoDiv").fadeOut('slow', function(){$("#changeLogoButtonDiv, #setDefaultLogoDiv, #textColorBC").fadeIn('slow');});

					showAndHide('divSuccessBC', 'divSuccessBC', 1500, true);
					showAndHide('divSuccessBCC', 'divSuccessBCC', 1500, true);

				} else {
					showAndHide('divErrorBC', 'divErrorBC', 1500, true);
					showAndHide('divErrorBCC', 'divErrorBCC', 1500, true);
				}
			}
		});
	</script>
<div id="frmProfile_View" class="ui-single-box">
    	<?=generateDivMessaje('divSuccessBC',	'180', NEWTAG_CTRMSGDATASAVE) ?>
		<?=generateDivMessaje('divErrorBC',		'450', BUSINESS_CARD_ERROR,	false) ?>

    	<h3 class="ui-single-box-title">
			&nbsp;<?=USERPROFILE_BUSINESSCARD?>
		</h3>

		<form action="controls/business_card/businessCard.control.php" id="frmBusinessCard" name="frmBusinessCard" method="post" style="padding:0;  margin:0;" enctype="multipart/form-data">
			<?php $anchoImput=200;
			?>

				<table class="list_inline" style="margin-left:-10px; font-size:100%;" border="0">


					<tr rowspan="6">

						<?php //INPUT address ?>
						<td style="padding:5px">
							<label><strong>&nbsp;<?=ADDRESS_BC_USERPROFILE?>:</strong></label>

							<?php $var = BC_ADDRESS_NOTEXT;?>
							<input	type	= "text" class="txt_box" name="bc_address" id="bc_address" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['address'] ? htmlspecialchars($bc['address']) : $var) )?>"
									onblur	= "(this.value=='' ? this.value='<?=$var?>' : '')"
									onfocus	= "(this.value=='<?=$var?>' ? this.value='' : '' ) "/>

						</td>

						<?php //Business Card (inside the window) ?>
						<td class="text_content" colspan="3" rowspan="4" border="1" style="text-align:center">
							<?php
							$exclude = true;
							//include ('../../class/validation.class.php');
							include('businessCard_dialog.view.php');
							?>
						</td>

						<?php //background selector?>
						<td class="text_content" rowspan="8" width="180" style="text-align:center;">

							<h3 class="title_orange_section"><?=NEWTAG_LBLBACKGROUNDS?></h3>

							<div style="width:250px; height:420px; overflow:auto;">
								<div id="bc_backgrounds" style="width:230px; height: 450px;">
									<ul style=" margin:0; padding:0;">
										<?php //user backgrounds
										$allowedImages = array('jpg', 'jpeg', 'png', 'gif');
										$folder = opendirFTP((isset($_POST[asyn]) ? '../../' : '').'bc_templates/'.$_SESSION['ws-tags']['ws-user'][code].'/');
										while( $pic = readdirFTP($folder) )
										{
											$args = explode('.', $pic);
											$extension = strtolower( end($args) );
											if(in_array($extension,$allowedImages))
											{ ?>
												<li	onclick="setBCBackground('<?=$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>');"
													style="	background-image:url('includes/imagen.php?ancho=300&tipo=3&img=<?=FILESERVER."img/bc_templates/".$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>');
															background-position:0 50%; height:70px;
															cursor:pointer; width:235px;">
												</li>
											<?php }
										}

										//defaults backgrounds
										$folder = opendir((isset($_POST[asyn]) ? '../../' : '').'img/bc_templates/defaults/');
										while ($pic = readdir($folder))
										{
											$args = explode('.', $pic);
											$extension = strtolower(end($args));
											if( in_array($extension, $allowedImages) ) { ?>


												<li onclick="setBCBackground('<?='defaults/'.$pic?>')"
													style =	"	background-image:url(includes/imagen.php?ancho=300&tipo=3&img=<?='../img/bc_templates/defaults/'.$pic?>);
																background-position:0 50%; height:70px;
																cursor:pointer; width:235px; ">
												</li>
											<?php }
										} ?>
									</ul>
								</div>
							</div>
						</td>
					</tr>


					<?php //INPUT company ?>
					<tr>
						<td style="padding:5px">
							<label><strong>&nbsp;<?=COMPANY_BC_USERPROFILE?>:</strong></label>

							<?php $var = BC_COMPANY_NOTEXT; ?>
							<input	type	= "text" class="txt_box" name="bc_company" id="bc_company" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['company']?$bc['company']:$var))?>"
									onfocus	= "if(this.value=='<?=$var?>') this.value=''"
									onblur	= "if(this.value=='') this.value='<?=$var?>'"/>

						</td>
					</tr>


					<?php //INPUT specialty ?>
					<tr>
						<td style="padding:5px">
							<label><strong>&nbsp;<?=SPECIALTY_BC_USERPROFILE?>:</strong></label>

							<?php $var = BC_SPECIALTY_NOTEXT; ?>
							<input	id		= "bc_specialty" name="bc_specialty" type="text" class="txt_box" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['specialty']?$bc['specialty']:$var))?>"
									onfocus	= "if(this.value=='<?=$var?>') this.value=''"
									onblur	= "if(this.value=='') this.value='<?=$var?>'"/>

						</td>
					</tr>


					<?php //INPUT middle text ?>
					<tr>
						<td style="padding:5px;">
							<label><strong>&nbsp;<?=BC_MIDDLETEXT?>:</strong></label>

							<?php $var = BC_MIDDLETEXT_NOTEXT; ?>
							<input	id		= "bc_middleText" name="bc_middleText" type="text" class="txt_box" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['middle_text']?$bc['middle_text']:$var))?>"
									onfocus	= "if(this.value=='<?=$var?>') this.value=''"
									onblur	= "if(this.value=='') this.value='<?=$var?>'"/>
						</td>
					</tr>


					<?php //INPUT bc_homePhone ?>
					<tr>
						<td style="padding:5px; height: 65px;">
							<?php // the companies doesn't have a home number ?>
							<div style="<?=($_SESSION['ws-tags']['ws-user'][type]=='1' ? 'display: none;' : '')?>">
								<label><strong>&nbsp;<?=USERPROFILE_LBLHOMEPHONE?>:</strong></label>

								<?php $var = BC_HOMEPHONE_NOTEXT; ?>
								<input	id		= "bc_homePhone" name="bc_homePhone" type="text" class="txt_box" style="width:<?=$anchoImput?>"
										value	= "<?=($_GET['bc']=="new" ? $var : ($bc['home_phone']?$bc['home_phone']:$var))?>"
										onfocus	= "if(this.value=='<?=$var?>') this.value=''"
										onblur	= "if(this.value=='') this.value='<?=$var?>'"/>
							</div>
						</td>

						<?php //BUTTON change logo ?>
						<td style="vertical-align:bottom; width:150px; text-align: center" >
							<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
								<div id="changeLogoButtonDiv" <?=($_SESSION['ws-tags']['ws-user']['fullversion']==1 ? 'style="display: none;"' : '' )?>>
									<input style="display:none" name="bc_companyLogo_url" id="bc_companyLogo_url" type="text" value="<?=($_GET['bc']=="new" ? "" : ($bc['company_logo_url'] ? $bc['company_logo_url'] : ''))?>" />
									<input style="display:none" name="bc_background" id="bc_background" type="text" value="<?=($_GET['bc']=="new" ? "Company that your work for" : ($bc['background_url']!='' ? $bc['background_url'] : ''))?>" />
									<input title="<?=USERPROFILE_BUTTONCHANGELOGO_TITLE?>" type="button" value="<?=BC_CHANGELOGO?>" />
								</div>

								<div id="changeLogoDiv" style="width:90px; <?=($_SESSION['ws-tags']['ws-user']['fullversion']!=1 ? 'display:none;' : '' )?>">
									<input type="file" id="logoCompany" name="logoCompany"/>
								</div>
							<?php } ?>

						</td>

						<?php //BUTTON use default ?>
						<td style="vertical-align:bottom; width:150px; text-align: center">
							<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
								<div id="setDefaultLogoDiv">
									<input title="<?=USERPROFILE_BUTTONSETDEFAULT_TITLE?>" id="setDefaultButton" type="button" value="<?=BC_SETDEFAULTLOGO?>"/>
								</div>
							<?php } ?>

						</td>

						<?php //Text Color Selector ?>
						<td style="vertical-align:bottom; width:200px; text-align: center">

							<div id="editTag-box" style="margin-left: 40px; width: 40px; text-align: center; margin-bottom: 4px;border: 0px;">
								<!--div "<?php /*($bc[text_color] ? $bc[text_color] : '#000000')*/ ?>" -->
								<input tipo="excolor" requerido="<?=HEXADECIMAL_VALITACION?>" class="colorBG colorSelector" title="<?=TEXTCOLORVALUE?>"  type="text" id="hiddenColor" name="hiddenColor" value="#000000"/>
								<div id="hiddenColorDiv"></div>
							</div>
						</td>

					</tr>


					<tr>
						<?php //INPUT bc_workPhone ?>
						<td style="padding:5px;">
							<label><strong>&nbsp;<?=USERPROFILE_LBLWORKPHONE?>:</strong></label>

							<?php $var = BC_WORKPHONE_NOTEXT; ?>
							<input	id		= "bc_workPhone" name="bc_workPhone" type="text" class="txt_box" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['work_phone']?$bc['work_phone']:$var))?>"
									onfocus	= "if(this.value=='<?=$var?>') this.value=''"
									onblur	= "if(this.value=='') this.value='<?=$var?>'"/>
						</td>

						<?php //LOGO LEYEND ?>
						<td style="text-align:center;" colspan="3">

							<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
								<div class="color-a font-size3">
									<?=BC_LOGO_LEYEND?>
								</div>
							<?php } else { echo "&nbsp;"; } ?>
						</td>
					</tr>

					<?php //INPUT bc_mobilePhone ?>
					<tr>
						<td style="padding:5px;">
							<label><strong>&nbsp;<?=USERPROFILE_LBLMOBILEPHONE?>:</strong></label>

							<?php $var = BC_MOBILEPHONE_NOTEXT; ?>
							<input	id		= "bc_mobilePhone" name="bc_mobilePhone" type="text" class="txt_box" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['mobile_phone']?$bc['mobile_phone']:$var))?>"
									onfocus	= "if(this.value=='<?=$var?>') this.value=''"
									onblur	= "if(this.value=='') this.value='<?=$var?>'"/>
						</td>

						<?php //Add Background Button ?>
						<td colspan="3" style="vertical-align:bottom;">

							<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
								<input	name="addBackground" id="addBackground" type="button"
									   value="<?=BUSINESSCARD_ADDBACKGROUND?>" style="float: left; margin-right: 10px;"/>
								<div style="display:none" id="newBackgroundDiv">
									<input name="newBackground"  type="file" id="newBackground"/>
								</div>

								<div id="setDefaultBgDiv">
									<input id="setDefaultBgButton" title="Use Default Background" type="button" value="<?=BC_SETDEFAULTLOGO?>"/>
								</div>

							<?php } ?>
						</td>
					</tr>

					<?php //INPUT bc_email ?>
					<tr>
						<td style="padding:5px;">
							<label><strong>&nbsp;<?=SIGNUP_LBLEMAIL?>:</strong></label>

							<?php $var = BC_EMAIL_NOTEXT; ?>
							<input	id		= "bc_email" name="bc_email" type="text" class="txt_box" style="width:<?=$anchoImput?>"
									value	= "<?=($_GET['bc']=="new" ? $var : ($bc['email']?$bc['email']:$var))?>"
									onfocus	= "if(this.value=='<?=$var?>') this.value=''"
									onblur	= "if(this.value=='') this.value='<?=$var?>'"/>
						</td>

						<?php //BACKGROUND LEYEND ?>
						<td style="text-align:center" colspan="3">
							<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
								<div class="color-a font-size3">
									<?=BC_BACKGROUND_LEYEND?>
								</div>
							<?php } else { echo "&nbsp;"; } ?>
						</td>

					</tr>



				</table>




			<input style="display: none" id="frmSubmit" name="frmSubmit" value="yes"/>


			<?php //BOTH IMPUTS ARE USED IN businessCard.control ?>
			<input style="display: none" id="idBc"				name="idBc"				value="<?=$_GET['bc']?>"/>
			<input style="display: none" id="companyLogoUrl"	name="companyLogoUrl"	value="<?=$bc['company_logo_url']?>"/>
			<input type="hidden" id="type" name="type" value="<?=$bctipo?>">
			
			<div id="botonesForm" style="padding-top: 10px">
				<input name="frmBusinessCard_btnHome" type="button" id="frmBusinessCard_btnHome" value="<?=BC_BUTTON_BACK?>" />
				<input name="frmBusinessCard_btnSend" type="button" id="frmBusinessCard_btnSend" value="<?=USERPROFILE_SAVE?>" />
			</div>
		</form>
    <div class="clearfix"></div>
</div>





	<?php } else {
		echo BC_INVALIDURLBC;
	}
?>