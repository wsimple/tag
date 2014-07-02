
<div class="tags-list">
	<div class="tag-container noMenu">
	</div>
</div>

<script type="text/javascript">
	//ScrollPane Favoroites
	$(function() {
		var layer=$('#tagsUser .tag-container')[0];//container
		var current='<?=$_GET['current']?>',//current
			ns='.'+current,//namespace
			sizeTags='<?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'normal':'mini'?>',interval,
			opc={
				current:current,
				layer: layer,
				actions:{more:{}},//objeto de acciones para cada pestaña: reload=carga nueva, refresh=actualiza nuevas, more=actualiza viejas.
				on:{}
			};
			updateTags('reload',opc);
		<?php if (isset($_GET['select'])){ ?>
				$(layer).on('click','[tag]',function(){
					var uri='controls/business_card/addToAnExistingTag.controls.php?id_tag='+$(this).attr('tag')+'&id_bc=<?=$_GET['select']?>';
					$.ajax({
						url: uri,
						type: "GET",
						success: function(data){
							message('messages', data,data,'', 350, 220);
						}
					});

					$('#tagsUser').dialog('destroy');
				});
		<?php } ?>
	});
</script>