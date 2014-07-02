<?php
session_start();
include ("../../includes/functions.php");
include ("../../includes/config.php");
include ("../../class/wconecta.class.php");
include ("../../includes/languages.config.php");

if ($_GET[p]!=""){
	$datos = $update = $GLOBALS['cn']->query("
			  SELECT cost_investment, link
			  FROM users_publicity
			  WHERE md5(id) = '".$_GET[p]."'
			 ");

	$dato = mysql_fetch_assoc($datos);
}

$precios = priceList();
?>
<div id="borderSpansorTag">
	<div id="sponsor_msgeexito">
		<div id="loading">
			<img src="css/smt/loader.gif" width="32" height="32" />
			<br/><strong><?=EXPIREDACCOUNT_MSGBOXWINDOWSWARNING?></strong>
		</div>
	</div>

	<div id="sponsorTableTag">
		<table width="100%" border="0" align="center">
		<tr>
		  <td>
				<div id="sponsor_msgerror1"><?=SPONSORTAG_SPANERROR3?></div>
		  </td>
		</tr>
		<?php if($_SESSION['ws-tags']['ws-user'][super_user]=='0') {?>
			<tr>
				<td <?php if ($_GET[p]!="" && $_GET[resend]==''){?> style="display:none" <?php } ?> >
					(*)&nbsp;<?=SPONSORTAG_LBLINVESTMENT?>:&nbsp;<span>(<?=SPONSORTAG_LBLINVESTMENTHELP?>)</span>
				</td>
			</tr>
			<tr>
				<td>
					<input name="sponsorInversion" type="text" id="sponsorInversion" <?php if ($_GET[p]!="" && $_GET[resend]==''){?>class="displayNone"<?php } ?> maxlength="15" value="<?=(($dato["cost_investment"]!="")?$dato["cost_investment"]:'10.00')?>"
						onkeypress="return numbersonly(event);"
					    tipo="real" />
					<span id="infoCantCost" <?php if ($_GET[p]!="" && $_GET[resend]==''){?> class="displayNone" <?php } ?>><?=str_replace("*", "($10.00)", SPONSORTAG_LBLINVESTMENTHELPMINIMOAINVERTIR)?></span>
					<br />
					<span <?php if ($_GET[p]!=""){?>class="displayNone"<?php } ?>><?=SPONSORTAG_LBLINVESTMENTHELPDECIMALES?></span>
				</td>
			</tr>
			<tr>
				<td id="titlePriceList"><?=SPONSORTAG_TITLELISTPRICE?></td>
			</tr>
			<tr>
				<td>
					<table id="tableCostListPrice" border="0" align="center" cellpadding="2" cellspacing="0">
						<tr id="titlePriceListSponsor">
							<td ><?=SPONSORTAG_TITLELISPRICECURRENCY?></td>
							<td ><?=SPONSORTAG_TITLELISPRICEPUBLICITY?></td>
							<td ><?=SPONSORTAG_TITLELISPRICERANGO?></td>
							<td style="border-right:0"><?=SPONSORTAG_TITLELISPRICECOSTOMIN?></td>
						</tr>
						<?php while( $precio = mysql_fetch_assoc($precios) ) { ?>
						<tr id="numbersPriceList">
							<td ><?=$precio['moneda']?></td>
							<td ><?=$precio['tipo_publi']?></td>
							<td ><?=$precio['rango']?></td>
							<td style="border-right:0"><?=$precio['costo']?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		<?php } ?>
		<tr>
		  <td>
			  <div class="text_content" align="center"> <?=REQUIRED?> </div>
			  <input type="hidden" name="p" id="p" value="<?=$_GET[p]?>" />
		  </td>
		</tr>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#sponsorInversion').blur(function()
		{
			$(this).val( ( $(this).val()<10?10:$(this).val() ) );
			$(this).formatCurrency({symbol:''});
		});

//		$("#borderSpansorTag").submit(function(){
//			return false;
//		});
	});
</script>
