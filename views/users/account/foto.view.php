<script src="js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
<script>
	$(function(){
		$('#tabs').tabs();
		$('#send').click(function(){
			//if(checkCoords()){
				$('#formCoordenadas').submit();
			//}
		});
	});
	$('#formCoordenadas').ajaxForm({
		success:function(response){ //post-submit callback
			redir('profile');
		}
	});
</script>

<div id="tabs" style="width:878px;margin:0 auto 0 8px;height:auto;">
	<ul>
		<li style="border-left:0"><a href="#tabs-1" style="color:#fff"><?=USER_THUMBCREATION?></a></li>
	</ul>

	<div id="tabs-1">
		<form action="controls/users/crop.control.php" method="post" name="formCoordenadas" id="formCoordenadas" style="margin:0;padding:0;" class="fondo_secciones_tabs">
			<input name="send" type="button" id="send" style="float:right;" value="<?=USERPROFILE_SAVE?>"/>
			<!-- This is the image we're attaching Jcrop to -->
			<div style="padding-left:100px;">
				<?php //FILESERVER ?>
				<img src="<?=FILESERVER."img/users/".$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']?>" id="cropbox" style="margin:0;" />
			</div>

			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
		</form>
	</div>
</div>
	<!-- T$_GET[$_GET[$_GET[his is the form that our event handler fills -->

<script language="Javascript">

	var jcrop_api,boundx,boundy;

	$(function() {
		 $('#cropbox').Jcrop({
		  minSize:[ 60,60 ],
		  onSelect:updateCoords,
		   aspectRatio:1
		 });
	});

	function updateCoords( c ) {
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};

	function checkCoords() {
		if( parseInt($('#w').val()) ){
			return true;
		}else{
			message('messages','Alert','<?=USER_THUMBCREATIONERROR?>');
			return false;
		}
	};

</script>

</body>

</html>
<?php //THIS IS FOR CROPPING THE PROFILE PICTURE ?>