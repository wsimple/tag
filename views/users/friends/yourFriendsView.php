<?php  
	$find=isset($sc)&&$sc=='2'?true:false;
?>
<div id="yourFriendsView" class="ui-single-box">
		<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
		<h3 class="ui-single-box-title" style="background-size: 50% 32px;">
			<div id="titleFriends" style="float: left;margin-right: 5px;"></div>
			<div id="nf"></div>
		</h3>
		<?php if (!$find): ?>
		<!-- RADIO BUTTONS NAV -->
		<form style="position: relative; float: right; top: -41px; display: inline-block;">
			<div id="radio-buttons">
				<input type="radio" id="friends" name="radio" checked="checked"><label for="friends"><?=USER_FINDFRIENDSTITLELINKS?></label>
				<input type="radio" id="unfollow" name="radio"><label for="follow"><?=USER_LBLFOLLOWERS?></label>
				<input type="radio" id="follow" name="radio"><label for="unfollow"><?=USER_LBLFRIENDS?></label>
			</div>
		</form>
		<!-- FIN RADIO BUTTONS NAV -->
        <div class="clearfix"></div>
		<h6>
		<?=YOURFRIENDSVIEW_MESSAGE1?>
			<a href="javascript:void(0);" onclick="message('messages', '<?=FRIENDS_LEARNMORETHIS?>', '<?=YOURFRIENDSVIEW_WHY?>', '', 500, 250);" onFocus="this.blur();"><?=YOURFRIENDSVIEW_MESSAGE2?></a>
		<?=YOURFRIENDSVIEW_MESSAGE3?>
		</h6>
		<?php else: ?>
		<input name="txtSearchFriend" id="txtSearchFriend" type="text" class="txt_box_seekFriendsBrowsers" placeholder="<?=USERS_BROWSERFRIENDSLABELTXT1?>" style="width:200px;position: relative;z-index: 200;left: 430px;top: -72px;background-repeat: no-repeat;">
		<h6  style="top: -10px;">
			<?=FINDFRIENDS_LEGENDOFSEARCHBAR?>
		</h6>		
		<?php endif ?>
		<div id="tab" class="friends" style="background:#FFF; width:98%; margin:5px;">
			<?=FRIENDS_COMMENTSDINAMICO?><!-- Aquí se carga el contenido dinamicamente...-->
		</div>
</div>
<script >
$(document).ready(function(){
	var title=new Array(),opc={mod : 'friends',get:""},find=('<?=$find?0:1?>')*1;
	title['friends'] = '<?=USER_FINDFRIENDSTITLELINKS?>';
	title['follow'] = '<?=USER_LBLFOLLOWERS?>';
	title['unfollow'] = '<?=USER_LBLFRIENDS?>';
	title['find'] = '<?=EDITFRIEND_VIEWLABELSEARCH?>';
	if (find!=0){
		//Acción botones para navegación
		$( "#radio-buttons" ).buttonset();
		$( "#radio-buttons label" ).click( function(){
			opc.mod = $(this).attr('for');
			$('#yourFriendsView div#tab').removeAttr('class').addClass(opc.mod);
			$('#titleFriends').html(title[opc.mod]);
			friendsAndF(opc);
		});
	}else{
		opc.mod='find';
		$('#txtSearchFriend').keyup(function() {
			opc.get = $.trim($(this).val());
			if (opc.get!="" && $(this).val().length>2)	{
				opc.get="&search="+opc.get;
				friendsAndF(opc);
			}
		});
	}
	opc.find=find;
	$('#titleFriends').html(title[opc.mod]);
	friendsAndF(opc);
	$('#tab').html('');
	function friendsAndF(opc){
		$('#tab').html('<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="margin: 0 auto;display:block;">');
		$.ajax({
			url: 'controls/users/people.json.php?action=friendsAndFollow&withHtml&mod='+opc.mod+opc.get,
			type: 'POST',
			dataType: 'json',
			success:function(data){
				if (data['html']){
					$('#tab').html(data['html']);
					if (opc.find!=0) $('#nf').html('('+data['num']+')');
				}else{
					if (opc.find==0){
						$('#nf').html('('+0+')');
						if (opc.get!='') $('#tab').html('<div class="messageAdver" style="width: 400px; margin: 70px auto;text-align: center;"><?=$lang["SEARCHALL_NORESULT"]?>: '+opc.get.replace('&search=','')+'</div>');
						else $('#tab').html('<div class="messageAdver" style="width: 400px; margin: 70px auto;text-align: center;"><?=$lang["FRIENDS_NORESULTS"]?></div>');
					}else $('#tab').html('');
				}
			}
		});
		
	}
});
</script>