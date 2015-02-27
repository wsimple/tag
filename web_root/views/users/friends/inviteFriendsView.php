<script type="text/javascript">
	$(function(){
		// $("button, input:submit, input:reset, input:button").button();
		$("#frmInvite").submit(function(){
			$("#sendInvite").html("<img src=\"img/loader.gif\" width=\"16\" height=\"16\" border=\"0\"  />");
			dataString = $("#frmInvite").serialize();
			console.log(dataString);
			$.ajax({
				type    : "POST",
				url     : "controls/users/inviteFriends.control.php",
				data    : dataString,
				dataType: "html",
				success : function (data) {
					$("#sendInvite").html(data);
					$("#emails").val('');
					$("#message").val('');
					setTimeout(function(){ $("#sendInvite").html("&nbsp;"); }, 3500);
				}
			});
			return false;
		});
	});
</script>
<div id="inviteFriendsView" class="ui-single-box">
	<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
	<h3 class="ui-single-box-title">
		&nbsp;<?=EDITFRIEND_VIEWLABELSEARCH?>
	</h3>
	<!-- FIN BARRA TITULO Y BUSQUEDA DE AMIGO -->
	<form id="frmInvite" name="frmInvite" action="" method="post" class="fondo_secciones_tabs">
		<table width="100%" border="0" align="center" style="font-size:11px; font-weight:bold">
		<tr>
		<td colspan="2">
		<div style="font-weight:normal"><strong><?=INVITEUSERS_FROM?>:</strong>&nbsp;<?=$_SESSION['ws-tags']['ws-user'][full_name]." (".$_SESSION['ws-tags']['ws-user'][email].")"?></div>
		</td>
		</tr>
		<tr>
		<td width="182"><?=INVITEUSERS_TO?>:</td>
		<td width="808" rowspan="2" valign="top"><textarea name="emails" id="emails" class="txt_box" rows="2"></textarea></td>
		</tr>
		<tr>
		<td valign="top" style="color:#CCC; font-size:10px; font-weight:normal; text-align:left"><?=INVITEUSERS_HELPTO?></td>
		</tr>
		<tr>
		<td><?=INVITEUSERS_LBLMSG?>:</td>
		<td rowspan="2" valign="top"><textarea name="message" id="message" class="txt_box" rows="2"></textarea></td>
		</tr>
		<tr>
		<td valign="top" style="color:#CCC; font-size:10px; font-weight:normal; text-align:left"><?=INVITEUSERS_HELPMSG?></td>
		</tr>
		<tr>
		  <td colspan="2">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2" style="font-weight:normal; padding:5px; text-align:center; background-color:#F4F4F4">
		<?=INVITEUSERS_MSGVIEW?>    
		</td>
		</tr>
		<tr>
		  <td colspan="2">&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="2" style="text-align:center">
		    <input type="submit" name="btnInvite" id="btnInvite" value="<?=INVITEUSERS_BTNINVITE?>" />
		    &nbsp;
		    <input type="button" name="btnCancel" id="btnCancel" value="<?=INVITEUSERS_BTNCANCEL?>" onclick="redir('')" />
		</td>
		</tr>
		<tr>
		  <td colspan="2">&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="2" id="sendInvite" style="text-align:center">&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="2">&nbsp;</td>
		</tr>
		</table>
		</form>
</div>
