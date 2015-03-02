<?php
	include('../../../includes/session.php');
	include('../../../includes/config.php');
	include('../../../includes/functions.php');
	include('../../../class/wconecta.class.php');
	include('../../../includes/languages.config.php');
?>
<div id="msgBoxGroupInviteFriends"></div>
<form id="frmInviteGroup" name="frmInviteGroup" method="post" action="controls/groups/actionsGroups.json.php">
<table width="97%" border="0" cellspacing="0" cellpadding="0" class="table_frm_new_group" style="margin-top:0; border:1px solid #FFF;">
	<?php
		$brower_type=1;
		include ('../../users/browser/grid.view.php');
	?>
</table>
<input name="action" id="action" type="hidden" value="5" />
<input name="brower_type" id="brower_type" type="hidden" value="<?=$brower_type?>" />
<input name="grp" id="grp" type="hidden" value="<?=$_GET['grp']?>" />
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#sendInviteGroup").click(function(){
			$("#frmInviteGroup").submit();
		});
		function actionDialog(conten){
			$.dialog({
				title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
				content	: conten,
				height	: 200,
				width	: 300,
				close	: function(){
					$("#default-dialog").dialog('close');
				}
			});
		}
		var options = {
			dataType: 'json',
			success: function(data){ // post-submit callback
				console.log(data);
				switch (data['mensj']){
					case "invite":		actionDialog('<?=PASS_MESSAGEXITO?>'); break;
					case "no-invite":	actionDialog('<?=INVITEUSERTOSYSTEM_CTRSSENDMAILTOFRIENDERROR?>'); break;
					default:			actionDialog('<?=JS_ERROR?>');
				}//switch
			}//success
		};//options

		$("#frmInviteGroup").ajaxForm(options);

		//Busqueda de amigos
		$("#seek_friends").focus(function() {
			if ($.trim($("#seek_friends").val())=="<?=FRIENDS_FINDFRIEND_SEARCH?>")
				$("#seek_friends").val("");
		});
		$("#seek_friends").blur(function() {
			if ($.trim($("#seek_friends").val())=="")
				$("#seek_friends").val("<?=FRIENDS_FINDFRIEND_SEARCH?>");
		});
//		$("button, input:submit, input:reset, input:button").button();
	});
</script>
