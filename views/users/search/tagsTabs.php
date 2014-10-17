<div id="tagTabs">
	<?php
		$hash=end(explode('#',$srh));
	?>
	<div class="group-details" id="taglist-box">
		<div class="ui-single-box-title">
			<form>
				<div class="tags-size">
					<?=RADIOBTN_VIEW?>:
					<input type="radio" name="radio" id="normal" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'checked="checked"':''?>/><label title="Normal Tags" for="normal">&nbsp;</label>
					<input type="radio" name="radio" id="mini" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']!=0?'checked="checked"':''?>/><label title="Mini Tags" for="mini">&nbsp;</label>
				</div>
			</form>
		</div>
		<br/><br/>
		<div class="tags-list" id="searchtags">
			<div class="tag-container" style="margin:0 auto;"></div>
			<img src="img/loader.gif" width="25" height="25" class="loader" style="display: none;"/>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<script type="text/javascript">
	//ScrollPane Favoroites
	$(function(){
		//event handlers
		var $box=$('#tagTabs #taglist-box').last();
		$('.tags-size,.tray').buttonset()
		.find('[title]').tipsy({html:true,gravity:'n'});
		var ns='.tagsList',//namespace
			layer=$box.find('.tag-container')[0],//container
			opc={
				current	:'hash',
				layer	:layer,
				idsearch:'1',
				radiobtn:'.tags-size',
				get		:"&hash=<?=$hash?>"
			};
			console.log('hast de tags = '+opc.hash);
		var sizeTags='<?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'normal':'mini'?>',interval,
//			firstTime=true,
			refresh=function(){
				//refresh the window
				updateTags('refresh',opc,false);
			};
		$.on({
			open:function(){
				updateTags('reload',opc);
				interval=setInterval(refresh, 30000);
				if(sizeTags=='normal'){
					$box.removeClass('mini');
				}else{
					$box.addClass('mini');
				}
				//scrolling
				$(window).on('scroll'+ns,function(){
					if(opc.actions.more.more===false){
						$(window).off('scroll'+ns);
					}else{
						var $layer=$('header',PAGE),//global
							scrollEnd=$(layer).height()-$layer.offset().top-$layer.height(),//window scroll ending position
							scroll=parseInt($(layer).offset().top),//actual content position
							offset=800;//when to
						//console.log('scrollEnd='+scrollEnd+',scroll='+scroll+',offset='+offset+',se+s='+(scrollEnd+scroll));
						if(scrollEnd+scroll<offset) updateTags('more',opc);
					}
				});
				var bandera=true;
				$('.tags-size').on('click','input',function(){
					var id=this.id;
					if(sizeTags!=id){
						if(id=='normal'){
							$box.removeClass('mini');
						}else{
							$box.addClass('mini');
						}
						console.log(bandera);
						sizeTags=id;
						if(bandera){
							bandera=false;
							$.ajax({
								url:'controls/users/viewTimeline.control.php?'+id,
								type:'get'
							}).done(function(){
								bandera=true;
							});
						}
					}
				});
			},
			close:function(){
				$(window).off(ns);
				$box.off();
				clearInterval(interval);
			}
		});
	});
</script>
