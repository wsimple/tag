<?php
	//valida el menu left
	$numIt=createSessionCar('','','count');
	$numOrder=$_SESSION['store']['order']?$_SESSION['store']['order']:'';
    $numWish=$_SESSION['store']['wish']?$_SESSION['store']['wish']:'';
	$numSales=$_SESSION['store']['sales']?$_SESSION['store']['sales']:'';

	$countries=$GLOBALS['cn']->query("SELECT p.id AS id, p.code_area AS code_area, p.name AS country FROM  `countries` p ");
	$numberh = explode('-',$_SESSION['ws-tags']['ws-user']['home_phone']);
	$numberw = explode('-',$_SESSION['ws-tags']['ws-user']['work_phone']);
	$numberm = explode('-',$_SESSION['ws-tags']['ws-user']['mobile_phone']);
	$numberp = $_SESSION['ws-tags']['ws-user']['country'];
	$options='';$tele_home='';$tele_mobile='';$tele_work;$num_pais='';
	while( $country = mysql_fetch_assoc($countries) ){
		if ($numberh[0]==$country['code_area']){
			$tele_home='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>'.'
						</option>';
		}
		if ($numberw[0]==$country['code_area']){
			$tele_work='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>'.'
						</option>';
		}
		if ($numberm[0]==$country['code_area']){
			$tele_mobile='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>'.'
						</option>';
		}
		if ($numberp==$country['id']){
			$num_pais='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>'.'
						</option>';
		}
		$options.='<option value="'.$country['code_area'].'---'.$country['id'].'" >
			'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>'.'
		</option>';
	}
?>
<div id="user_ShoppingCart" class="ui-single-box">
    <?php // user messages (top) ?>
    <!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
		<h3 class="ui-single-box-title">
			&nbsp;<?=STORE_SHIPPING?>
		</h3>
        <div id="frmProfileFormContainer">
			<?php  //echo _imprimir($_SESSION['ws-tags']['ws-user'])?>
			<?php  //echo _imprimir($_SESSION['car'])?>
			<form action="controls/store/shoppingCart.json.php?action=6" id="user_Shopping" name="user_Shopping" method="post" style="padding:0;  margin:0;">
				<?php // country ?>
				<div>
					<label ><strong>(*)&nbsp;<?=BUSINESSCARD_LBLCOUNTRY?>:</strong></label>
					<select name="country" id="country" requerido="<?=BUSINESSCARD_LBLCOUNTRY?>">
						<?=($num_pais!='')?$num_pais:'<option value="" ></option>'?>
						<?=$options?>
					</select>
				</div>
				<?php // cities ?>
				<div id="setCitys">
					<label ><strong>(*)&nbsp;<?=BUSINESSCARD_LBLCITY?>:</strong></label>
					<select name="city" id="city" requerido="<?=BUSINESSCARD_LBLCITY?>">
						<!--<option value="" ></option>-->
					</select>
				</div>
				<?php // zip code ?>
				<div>
					<label ><strong>(*)&nbsp;<?=SIGNUP_ZIPCODE?></strong></label>
					<input name="zipCode" type="text"
						   id="zipCode"
						   value="<?=$_SESSION['ws-tags']['ws-user']['zip_code']?>" requerido="<?=SIGNUP_ZIPCODE?>"/>
				</div>
				<?php // address ?>
				<div>
					<label ><strong>(*)&nbsp;<?=BUSINESSCARD_LBLADDRESS?></strong></label>
					<input name="addres" type="text" 
						   id="addres"
						   value="<?=$_SESSION['ws-tags']['ws-user']['address']?>" requerido="<?=BUSINESSCARD_LBLADDRESS?>"/>
				</div>


				<?php // home phone ?>
				<?php if( $_SESSION['ws-tags']['ws-user']['type']=='0' ) { ?>
					<div>
						<label ><strong>(*)&nbsp;<?=USERPROFILE_LBLHOMEPHONE?>:</strong></label>
						<select name="home_code" id="home_code">
							<?=($tele_home)?$tele_home:'<option value="">'.USERPROFILE_LBLCBOAREASCODE.'</option>'?>
							<?=$options?>
						</select>
						<input name="phoneHome" type="text" id="phoneHome" value="<?=$numberh[1]?>" />
						<em class="font-size3 color-d "><?=PROFILE_PHONELEYEND?></em>
					</div>
				<?php } ?>
				<?php // work phone ?>
				<div>
						<label ><strong>(*)&nbsp;<?=USERPROFILE_LBLWORKPHONE?>:</strong></label>
						<select name="work_code" id="work_code">
								<?=($tele_work!='')?$tele_work:'<option value="">'.USERPROFILE_LBLCBOAREASCODE.'</option>'?>
								<?=$options?>
						</select>
						<input name="phoneWork" type="text" id="phoneWork" value="<?=$numberw[1]?>" />
						<em class="font-size3 color-d "><?=PROFILE_PHONELEYEND?></em>
				</div>

				<?php // mobile phone ?>
				<div>
						<label ><strong>(*)&nbsp;<?=USERPROFILE_LBLMOBILEPHONE?>:</strong></label>
						<select name="mobile_code" id="mobile_code">
								<?=($tele_mobile!='')?$tele_mobile:'<option value="">'.USERPROFILE_LBLCBOAREASCODE.'</option>'?>
								<?=$options?>
						</select>
						<input name="phoneMobile" type="text" id="phoneMobile"  value="<?=$numberm[1]?>" />
						<em class="font-size3 color-d "><?=PROFILE_PHONELEYEND?></em>
				</div>
				<div class="color-a font-size3 border-botton-store" id="frmProfileRequiredMessaje"><?=REQUIRED?></div>
				<div class="frmProfileBotones" >
					<input type="button" id="btnBack" name="btnBack" value="<?=JS_BACK?>" />
					<input name="buyOrder" type="button" id="buyOrder" value="<?=JS_CONTINUE?>" />
				</div>
			</form>
		</div><?php // fin contenedor ?>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){  
        $.on({
            open:function(){
                //colocarle el numero al shoppinh car
                var numIt='<?=$numIt?>',numOrder='<?=$numOrder?>',numSales='<?=$numSales?>',numWish='<?=$numWish?>';
                if (numIt!='0' && numIt !=''){
                    $('#menu-lshoppingCart').html(numIt).css('display','block');
                    //$('#menu-l-li-shoppingCart').css('display','list-item');
                }else{ redir('store'); }
                if (numOrder!=''){ $('.menu-l-youOrders').css('display','list-item'); }
                //if (numWish!=''){ $('#menu-l-li-wishList').css('display','list-item'); }
                if (numSales!=''){ $('.menu-l-youSales').css('display','list-item'); }
                ////////////////////////////////////////////////////////////////////////////
                $$("[title]").tipsy({html: true,gravity: 'n'});
                //control del formulario perfil
                $('select#country,select#mobile_code,select#work_code,select#home_code').chosen({
                    menuWidth: 200,
                    width: 200,
                    disableSearch:true 
                });
                //acciones key
                //acciones de keydown para validar las entradas en el campo price
                $('#zipCode,#phoneHome,#phoneMobile,#phoneWork').keydown(function(e){
                    var caracter=e.keyCode
                    if ((!validaKeyCode('interger',caracter))&&(!validaKeyCode('direction',caracter))&&(!validaKeyCode('delete',caracter))&&(!validaKeyCode('escape',caracter))&&(!validaKeyCode('tab',caracter)))
                        e.preventDefault();
                    if ((($(this).val().length>15))&&(!validaKeyCode('direction',caracter))&&(!validaKeyCode('delete',caracter))&&(!validaKeyCode('escape',caracter))&&(!validaKeyCode('tab',caracter)))
                        e.preventDefault();
                    if (($(this).val()=='')&&((caracter==48)||(caracter==96)))
                        e.preventDefault();
                });
                //end acciones key
                var city='<?=$_SESSION['ws-tags']['ws-user']['city']?>'
                $('#city').fcbkcomplete({
                    json_url: 'controls/store/shoppingCart.json.php?action=11',
                    newel:true,
                    filter_selected:true,
                    firstselected: true,
                    addontab : false,
                    filter_hide: true,
                    maxitems:1
                });
                $('#setCitys').on('keydown','ul.holder li input',function(e){
                    var a=$('#setCitys select#city option').val();
                    if ((a)&&(!validaKeyCode('del',e.heyCode)))
                        e.preventDefault();
                });
                if (city && city!=''){
                    getCitys('#city',city);
                }


                //success despues del submit
                var options = {
                    success: function(data){ // post-submit callback
                        data=JSON.parse(data);
                        if (data['datosCar']){
                            var v=data['datosCar'].split('-');
                            if (v[1]!='noCart'){
                                if( data['havePaypalPayment'] ) {
                                    $.dialog({
                                        title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
                                        content	: data['havePaypalPayment'],
                                        height	: 200,
                                        close: function(){
                                            document.location = 'views/pay.view.php?payAcc=store';
                                        }
                                    });	
                                }else if (data['orderEdit']){
                                    $('html,body').animate({scrollTop:'50px'},'slow',function(){
                                        redir('shoppingcart?no-product=1');
                                    });
                                }else{ processOrderSC(2); }
                            }else{
                                $.dialog({
                                    title	: '<?=JS_ALERT?>',
                                    content	: '<?=STORE_PAY_DOUBLE?>'
                                });
                                redir('store');
                            }
                        }
                    }//success
                };//options
                $('#user_Shopping').ajaxForm(options);

                //TTHHUMMBB
                //control de los botones send y back
                $("#buyOrder").click(function() {
                        if( valida('user_Shopping')) {
                            var a=$('#setCitys select#city option').val();
                            if (a){
                                var b=$('#setCitys select#city option').html();
                                if (a!=b) $('#user_Shopping').submit();
                                else{
                                    $.dialog({
                                        title	: 'Alert',
                                        content	: '<?=CITY_INVALID?>',
                                        focus	: '#setCitys ul.holder li input'
                                    });
                                }
                            }else{
                                $.dialog({
                                    title	: 'Alert',
                                    content	: '<?=BUSINESSCARD_LBLCITY.' '.JS_REQUIRED?>',
                                    focus	: '#setCitys ul.holder li input'
                                });
                            }
                        }else{ /* $('#buyOrder').button("enable");*/  }
                });
                $('#btnBack').click(function(){
                     history.back(1);
                });
                //FIN control de los botones send y back
        },
		close:function(){
            $('#setCitys').off();
		}
	});
});
</script>
