<?php
session_start();
include ("../../../../includes/functions.php");
include ("../../../../includes/config.php");
include ("../../../../class/wconecta.class.php");
include ("../../../../includes/languages.config.php");

?>
<div id="content_payment_bc">
	<table width="350" border="0" align="center" cellpadding="3" cellspacing="3" style="margin-top:10px;">

		<tr>
			<td width="101">
				<img src="img/paypal-curved.png" width="101" height="64" border="0"/>
			</td>

			<td width="228" style="font-size:14px">
				<?=BUSINESSCARD_MESSAGEBOX_INSIDE?>
				<?="(<strong>".( ($_SESSION['ws-tags']['ws-user'][type]=='1') ? getCostCompanyBusinessCard() : getCostPersonalBusinessCard())."$</strong>)."?>
			</td>
		</tr>

		<tr>
			<td colspan="2" style="font-size:12px; color:#999999; text-align:center">
				<?=EXPIREDACCOUNT_MSGBOXWARNINGSORRYINCONVENIENCE?>
			</td>
		</tr>

	</table>
</div> 