<?php
	session_start();
	include ('../../../includes/functions.php');
	include ('../../../includes/config.php');
	include ('../../../includes/languages.config.php');
?>
<div id="share_tag">
	<table class="ui-smt-single">
		<tr>
			<td class="ui-smt-bold"><?=INVITEUSERS_FROM?>:</td>
			<td colspan="2"><?=$_SESSION['ws-tags']['ws-user']['full_name'].' ('.$_SESSION['ws-tags']['ws-user']['email'].')'?></td>
		</tr>
		<tr>
			<td class="ui-smt-bold"><?=INVITEUSERS_TO?>:</td>
			<td colspan="2" valign="top"><input name="txtEmails" id="txtEmails"  style="width: 515px;" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="ui-smt-comment" width="60%"><?=INVITEUSERS_HELPTO?></td>
			<td style=" padding-right: 13px;"><input type="button" class="ui-smt-float-right" id="view_friends" value="<?=BTN_VIEWFRIENDS?>"/></td>
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
			<td colspan="3">
				<div style="float:right;width:470px;">
					<iframe src="views/tags/share/facebook.php?tag=<?=$_GET['tag']?>" width="170px" frameborder="0" scrolling="no" height="30px" allowtransparency="true" style="float:left;"></iframe>
					<iframe src="views/tags/share/twitter.php?tag=<?=$_GET['tag']?>" width="130px" frameborder="0" scrolling="no" height="30px" allowtransparency="true" style="float:right;"></iframe>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="ui-smt-help"><input id="urlTag" type="text" value="<?=DOMINIO.'tag/'.$_GET['tag']?>" style="width:200px;" /></td>
		</tr>
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
		$('input[type="text"]').select().focus(function(event) { 
			$(this).select(); event.preventDefault(); 
		});
		$('#share_tag #txtEmails').select2({
			placeholder:'<?=formatoCadena($lang["MAINMNU_FRIENDS"])." ".strtolower($lang["JS_OR"])." ".LBL_LOGIN."s"?>',
			minimumInputLength:1,
			multiple:true,
			maximumSelectionSize:15,
			formatInputTooShort:"<?=$lang['MINIMOCARACTERESSELECT2']?>",
			createSearchChoice:function(term, data) { 
				if ($(data).filter(function() { 
					return this.text.localeCompare(term)===0; 
				}).length===0) {return {id:term, text:term};} 
			},
			openOnEnter:true,
			ajax:{
				url:'includes/friendsHelp.php?value=1',
				data:function(term,page){ return { term: term }; },
				results:function(data,page){ return { results: data };}
			}
		});
		$("#view_friends").click(function() {
			shareTag_friendsList("views/tags/share/friendsList.php", "<?=FRIENDS_SELECTFRIENDS_TITLE?>",'share=0&');
		});
	});
</script>