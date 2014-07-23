<div class="fotoCrop">
	<form action="controls/users/crop.control.php" method="post" name="formCoordenadas" id="formCoordenadas" class="fondo_secciones_tabs">
		<div>
		<h3 class="ui-single-box-title" style="padding-left: 40px">
				&nbsp;<?=USER_THUMBCREATION?>
			</h3>
			<input name="send" type="button" id="send" style="float:right;" value="<?=USERPROFILE_SAVE?>"/>
		</div>
		<div>
			<div style="padding-left:100px;">
				<img src="<?=FILESERVER."img/users/".$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']?>" id="cropbox" style="margin:0;" />
			</div>
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
		</div>
	</form>
</div>

<script src="js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

<script language="Javascript">
	$(function(){
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