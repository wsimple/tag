<?php
define('MAXSHOW', 5);
?>

<script type="text/javascript">
		$(document).ready(function()
		{
//			$("button, input:submit, input:reset, input:button").button();
			var msj = 'rbAmigos', title = '<?=USER_FINDFRIENDSTITLELINKS?>';

			//Acción botones para navegación
			$( "#radio-buttons" ).buttonset();
			$( "#radio-buttons input" ).click( function(){

				msj = $(this).attr('id');
				
				title = $(this).attr('titleBox');
				$('#titleFriends').html(title);
				$('#nf').html('');
			
				//alert(title);
				send_ajax('controls/users/yourFriends.control.php?tab='+msj, '#tab', 0, 'html');
			});
			$('#titleFriends').html(title);
			send_ajax('controls/users/yourFriends.control.php?tab='+msj, '#tab', 0, 'html');
		});

</script>
<div id="yourFriendsView" class="ui-single-box">
		<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
		<h3 class="ui-single-box-title" style="background-size: 50% 32px;">
			<div id="titleFriends" style="float: left;margin-right: 5px;"></div>
			<div id="nf"></div>
		</h3>

		<!-- RADIO BUTTONS NAV -->
		<form style="position: relative; float: right; top: -41px; display: inline-block;">
			<div id="radio-buttons">
				<input type="radio" titleBox="<?=USER_FINDFRIENDSTITLELINKS?>" id="rbAmigos" name="radio" checked="checked"><label for="rbAmigos"><?=USER_FINDFRIENDSTITLELINKS?></label>
				<input type="radio" titleBox="<?=USER_LBLFOLLOWERS?>" id="rbAdmiradores" name="radio"><label for="rbAdmiradores"><?=USER_LBLFOLLOWERS?></label>
				<input type="radio" titleBox="<?=USER_LBLFRIENDS?>" id="rbAdmirados" name="radio"><label for="rbAdmirados"><?=USER_LBLFRIENDS?></label>
			</div>
		</form>
		<!-- FIN RADIO BUTTONS NAV -->
        <div class="clearfix"></div>
		<h6>
		<?=YOURFRIENDSVIEW_MESSAGE1?>
			<a href="javascript:void(0);" onclick="message('messages', '<?=FRIENDS_LEARNMORETHIS?>', '<?=YOURFRIENDSVIEW_WHY?>', '', 500, 250);" onFocus="this.blur();"><?=YOURFRIENDSVIEW_MESSAGE2?></a>
		<?=YOURFRIENDSVIEW_MESSAGE3?>
		</h6>
		<div id="tab" style="background:#FFF; width:98%; margin:5px;">
			<?=FRIENDS_COMMENTSDINAMICO?><!-- Aquí se carga el contenido dinamicamente...-->
		</div>
</div>
