<?php
	session_start();
	include ('../../../includes/functions.php');
	include ('../../../includes/config.php');
	include ('../../../class/wconecta.class.php');
	include ('../../../includes/languages.config.php');
?>
<?=generateDivMessaje('divNoUser','300',PLEASE_INDICATE.' '.ADDRESSEE,false)?>
<div id="suggest_group">
	<table class="ui-smt-single">
		<tr>
			<td class="ui-smt-bold"><?=INVITEUSERS_FROM?>:</td>
			<td colspan="2"><?=$_SESSION['ws-tags']['ws-user']['full_name'].' ('.$_SESSION['ws-tags']['ws-user']['email'].')'?></td>
		</tr>
		<tr>
			<td class="ui-smt-bold"><?=INVITEUSERS_TO?>:</td>
			<td colspan="2" valign="top"><select name="txtEmails" id="txtEmails"></select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="ui-smt-comment" width="60%"><?=INVITEUSERS_HELPTO?></td>
			<td style=" padding-right: 13px;"><a href="#" class="ui-smt-float-right" id="view_friends"><?=BTN_VIEWFRIENDS?></a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="ui-smt-bold"><?=INVITEUSERS_LBLMSG?>:</td>
			<td colspan="2" rowspan="2">
				<textarea name="txtMsgMail" id="txtMsgMail" class="ui-single-box" rows="2" style="width:497px; height: 50px"></textarea>
			</td>
		</tr>
		<tr><td class="ui-smt-comment"><?=INVITEUSERS_HELPMSG?></td></tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" class="ui-smt-help"><?=INVITEUSERS_MSGVIEW?></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$(function(){
		$("#suggest_group #txtEmails").fcbkcomplete({
			json_url: "includes/friendsHelp.php?value=1",
			newel:true,
			filter_selected:true,
			addontab : true,
			filter_hide: true
		});
//        $("#view_friends").button().click(function() {
		$("#view_friends").click(function() {
			shareTag_friendsList("views/tags/share/friendsList.php", "<?=FRIENDS_SELECTFRIENDS_TITLE?>",'');
		});
	});
</script>
