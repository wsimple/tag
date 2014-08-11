<div class="fotoCrop ui-single-box">
	<form action="" id="formCoordenadas" class="fondo_secciones_tabs">
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<div>
			<h3 class="ui-single-box-title" style="padding-left: 40px">
				&nbsp;<?=USER_THUMBCREATION?>
			</h3>
			<div class="menuProfileBack">
				<a href="<?=base_url('profile')?>"><?=USER_PROFILE?></a> > <?=USER_CROPPROFILE?>
			</div>
			<input name="send" type="button" id="send" style="float:right;" value="<?=USERPROFILE_SAVE?>"/>
		</div>
		<div>
			<div style="padding-left:100px;">
				<img src="<?=FILESERVER."img/users/".$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']?>" id="cropbox" style="margin:0;" />
			</div>
		</div>
	</form>
</div>

<script src="js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

<script language="Javascript">
	$(function(){
		var send=(function(){
			var disabled;
			return function(){
				if(disabled) return;
				disabled=true;
				var pdata={
					action:'picture'
				};
				//extraemos las dimenciones, posicion y escala de la imagen
				pdata['x']=$('input#x')[0].value;
				pdata['y']=$('input#y')[0].value;
				pdata['w']=$('input#w')[0].value;
				pdata['h']=$('input#h')[0].value;
				$.c().log('data:',pdata);
				$.ajax({
					url:'controls/users/profile.json.php',
					data:pdata,
					dataType:'json',
					type:'post',
					success:function(data){
						$.c().log('profile.json:',data);
						if(data['upload']=='done'||data['resize']=='done'){
							redir('user');
						}
					},
					complete:function(){
						disabled=false;
					}
				});
			};
		})();
		$('#send').click(send);
	});
	$('#formCoordenadas').ajaxForm({
		success:function(response){//post-submit callback
			redir('user');
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