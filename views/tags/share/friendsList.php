<?php
	include('../../../includes/session.php');
	include('../../../includes/functions.php');
	include('../../../includes/config.php');
	include('../../../class/wconecta.class.php');
	include('../../../includes/languages.config.php');
?>
<script type="text/javascript">
	$(document).ready(function(){		
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
<div class="table_frm_new_group" style="margin-top:-0px; padding:5px; height:auto; width:580px">
<table width="99%" border="0" cellspacing="0" cellpadding="0" class="table_frm_new_group" style="margin-top:-0px; border:1px solid #fff;">
	<?php
		unset($_SESSION['ws-tags']['lstUsrBrowser']);
		$lstUsrs = $GLOBALS['cn']->query('
			SELECT	id_user
			FROM users_groups
			WHERE md5(id_group) = "'.$_GET[grp].'" AND id_user != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
			GROUP BY id_user
		');

		$_SESSION['ws-tags']['lstUsrBrowser'] = mysqlFetchAssocToArray($lstUsrs, 'id_user'); //array de miembros del grupo
		$brower_type = 2;
		include ('../../users/browser/grid.view.php');
	?>
</table>
</div>