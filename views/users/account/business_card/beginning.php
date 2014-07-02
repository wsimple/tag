<?php
/*IF THE USER HAS PAID FOR A BUSINESS-CARD*/
				if ( getPayBussinesCard() || $_SESSION['ws-tags']['ws-user'][type]=='0' ) {


					if( isset($_GET["addToTag"]) ) { 

							$val = $GLOBALS['cn']->query("	SELECT id_business_card
															FROM tags
															WHERE md5(id) = '".substr($_GET["addToTag"], 0, 32)."'");

							$val = mysql_fetch_assoc($val);

							if( $val[id_business_card] ) {

								$idBC = '';

							} else {

								$idBC = substr($_GET["addToTag"], 32);

							}

							$update = $GLOBALS['cn']->query("	UPDATE tags SET id_business_card = '".$idBC."'
																WHERE md5(id) = '".substr($_GET["addToTag"], 0, 32)."'");

							redirect("?current=profile&activeTab=2");
							

					} elseif( isset($_GET["bc"]) ) {//WHEN CREATING OR EDITING A BUSINESS CARD


								if( $_GET[bc]=="new" ) {//CREATING A NEW BUSINESS CARD

									$result = $GLOBALS['cn']->query("	INSERT INTO business_card
																		SET
																			id_user			= '".$_SESSION['ws-tags']['ws-user'][id]."',
																			type			= '1',
																			email			= '".$_SESSION['ws-tags']['ws-user'][email]."',
																			home_phone		= '".$_SESSION['ws-tags']['ws-user'][home_phone]."',
																			work_phone		= '".$_SESSION['ws-tags']['ws-user'][work_phone]."',
																			mobile_phone	= '".$_SESSION['ws-tags']['ws-user'][mobile_phone]."'");
									if( $result ) {

											$bcID = md5( mysql_insert_id() );

											$result = $GLOBALS['cn']->query("UPDATE users SET pay_bussines_card = pay_bussines_card+1
																												WHERE id = '".$_SESSION['ws-tags']['ws-user'][id]."'");

											if( $result ) {
													//redirect("?current=profile&activeTab=2&bc=".$bcID);
											}

									} else { //CAN'T CREATE BUSINESS CARD ?>

											<script>alert("We can't create your new business card");</script><?php
											//redirect("?current=profile&activeTab=2");

									}

							} else {//NOT A NEW BUSINESS CARD -> LOAD EDIT VIEW

									include("businessCard.view.php");
							}


					} else { //NO ACTION DEFINED -> LOAD PICKER


						include("views/users/account/business_card/businessCardPicker.view.php");


					}

				} else { //WHEN NO PAYMENT RECEIVED 
                ///* *** This is the BC that is displayed to the user ********* */ 
                    addJs('js/funciones_bc.js');
                   
                    ?>
						<div class="ui-single-box" style="width: 800px; height: 730px; padding-top: 50px;">
							<h3 class="ui-single-box-title"><?=USERPROFILE_BUSINESSCARD?></h3>
							<div style="text-align: center;padding: 50px;">
								<?php
									$_GET[uid] = md5($_SESSION['ws-tags']['ws-user'][id]);
									$exclude = true;
									$noMenu = true;
									include('views/users/account/business_card/businessCard_dialog.view.php');
								?>
							</div>
							<?php /**** END - This is the BC that is displayed to the user ****/ ?>
							<div style="text-align:center; padding-top: 10px; padding-bottom: 25px">
								<a href="javascript:void(0);" onclick="paymentBusinessCard('<?=BUSINESSCARDPAYMENT_TITLEMSGBOX?>','<?=EXPIREDACCOUNT_MSGBOXWINDOWSWARNING?>');" onfocus="this.blur();">
									<img src="img/menu_users/paypal.png" border="0" /><br/>
									<?=BUSINESSCARDPAYMENT_BUTTON?>
									<br/><br/>
								</a>
							</div>
						</div>
						<?php
				}

?>
