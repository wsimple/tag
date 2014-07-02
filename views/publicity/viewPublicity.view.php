<?php
	    include ("../../includes/functions.php");
		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php");

		if ($_GET[p]!=""){
		    $datos = $GLOBALS['cn']->query("SELECT title,
			                                       link,
												   cost_investment,
												   message,
												   picture,
												   id_type_publicity AS type

											FROM users_publicity

											WHERE md5(id) = '".$_GET[p]."'

										   ");

			$dato = mysql_fetch_assoc($datos);

		}// if p
?>
<table class="fondo_secciones_tabs" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" style="font-size:11px; font-weight:bold">
<tr>
  <td colspan="2"><div id="sponsor_msgerror" style="background-color:#FF3F3A; border:1px solid #880000; color:#FFF; font-size:11px; padding:2px; font-weight:bold; display:none"><?=SPONSORTAG_SPANERROR?></div></td>
</tr>
<tr>
  <td colspan="2"><div id="sponsor_msgeexito" style="background-color:#00BB00; border:1px solid #007700; color:#FFF; font-size:11px; padding:2px; font-weight:bold; display:none"><?=SPONSORTAG_SPANEXITO?></div></td>
</tr>
<tr>
<td colspan="2"><strong><?=PUBLICITY_LBLTITLE?>:</strong>&nbsp;<span style="color:#CCC; font-size:10px; font-weight:normal; text-align:left">(<?=PUBLICITY_HELPTITLE?>)</span></td>
</tr>
<tr>
<td colspan="2" style="padding:5px; font-weight:normal"><?=$dato[title]?></td>
</tr>
<tr>
<td colspan="2"><strong><?=PUBLICITY_LBLLINK?>:</strong>&nbsp;<span style="color:#CCC; font-size:10px; font-weight:normal; text-align:left">(<?=SPONSORTAG_LBLLINKHELP?>)</span></td>
</tr>
<tr>
<td colspan="2" style="padding:5px; font-weight:normal"><?=$dato["link"]?></td>
</tr>
<tr>
<td colspan="2"><strong><?=PUBLICITY_LBLINVESTMENT?>:</strong>&nbsp;<span style="color:#CCC; font-size:10px; font-weight:normal; text-align:left">(<?=SPONSORTAG_LBLINVESTMENTHELP?>)</span></td>
</tr>
<tr>
<td colspan="2" style="padding:5px; font-weight:normal"><?=$dato[cost_investment]?></td>
</tr>
<tr>
<td colspan="2"><strong><?=PUBLICITY_LBLPICTURE?>:</strong>&nbsp;<span style="color:#CCC; font-size:10px; font-weight:normal; text-align:left">(<?=PUBLICITY_HELPPHOTO?>)</span></td>
</tr>

<?php if ($_GET[p]!="" && fileExistsRemote(FILESERVER."img/publicity/".$_SESSION['ws-tags']['ws-user'][code].'/'.$dato[picture])){?>
<tr>
  <td colspan="2" style="padding:5px; font-weight:normal"><img src="includes/imagen.php?tipo=1&porc=80&img=<?=FILESERVER?>img/publicity/<?=$_SESSION['ws-tags']['ws-user'][code].'/'.$dato[picture]?>" style="border:1px solid #CCC"  /></td>
</tr>
<?php } ?>

</table>
