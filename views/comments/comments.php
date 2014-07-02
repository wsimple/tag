<?php
global $dialog;
$labelTxtComment=COMMENTS_LBLHELPIMPUTNEWCOMMENT.'...';
if($id_source!=''&&$id_type!=''&&$_SESSION['ws-tags']['ws-user']['id']!=''){
?>
<div class="comments-box" source="<?=$id_source?>" type="<?=$id_type?>">
<div class="header clearfix">
	<div class="title">
		<img src="css/smt/comment.png" width="12" height="12" border="0"/>
		<span class="seemore">
			<?=COMMENTS_LBLVIEWALL?> <span class="count"></span> <?=strtolower(COMMENTS_LBLCOMMENTS)?>
		</span>
		<span class="default"><?=COMMENTS_LBLCOMMENTS?></span>
		<!--<a href="javascript:void(0);" id="postAComment" onfocus="this.blur();" style="color:#F58220;">
			<?=NOTIFICATIONS_TITLECOMMENTSTAGMSJUSER?>
		</a>-->
		<img src="css/smt/loader.gif" width="10" class="loader" style="display:none;"/>
	</div>
	<?php
		if($store!='1'){
			if($id_type==4){
				$likes=CON::count('likes','id_source=?',array($id_source));
				$dislikes=CON::count('dislikes','id_source=?',array($id_source));
	?>
	<div class="likes">
		<span id="numLikes" onclick="viewUserLikedTag('<?=COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG?>','views/tags/viewUserLikedTag.php?g=true&t=<?=$id_source?>','numLikes');"><?=$likes?></span>
		<span id="numDislikes" onclick="viewUserLikedTag('<?=COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG?>','views/tags/viewUserLikedTag.php?g=false&t=<?=$id_source?>','numDislikes');"><?=$dislikes?></span>
	</div>
	<?php
			}
		}else{//if store
			echo "&nbsp;";
		}
	?>
</div>
<ul class="list clearfix">
</ul>
<div class="add clearfix">
	<textarea name="txtComment" id="txtComment" disabled="disabled" placeholder="<?=$labelTxtComment?>" cols="3" rows="3"></textarea>
	<input type="button" id="comment" style="float:right;" value="<?=COMMENTS_LBLNEWCOMMENT?>" disabled="disabled"/>
</div>
</div>
<script type="text/javascript">
	$(function(){
		var $layer=$('.comments-box[source=<?=$id_source?>][type=<?=$id_type?>]'),
			opc={
				layer:$layer,
				data:{
					type:'<?=$id_type?>',
					source:'<?=$id_source?>',
					to:'<?=$id_user_to?>',
					limit:5
				}
			};
<?php if(!$dialog){ ?>
		var interval;
		$.on({
			open:function(){
<?php }#!dialog ?>
				getComments('reload',opc);
				//acciones 
//				$("#new_comment").button();
//				$('.textareaComment').focus(function(){
//					showOrHide('1','#new_comment');
//				}).blur(function(){
//					showOrHide('0','#new_comment');
//				});
				var $btnComment=$('input#comment',$layer),
					$txtComment=$('#txtComment',$layer);
				$btnComment.click(function(){
					var txt=$.trim($txtComment.val());
					if(txt!=''&&insertComment(txt,opc))
						$txtComment.val('').keyup();
				});
				//new comment > enter
				$txtComment.keyup(function(key){
					var txt=$.trim($(this).val()),len=txt.length,$btn=$(this).next();
					$btn.prop('disabled',len<=0);
					if(key.keyCode==13) $btn.click();
				});
	//			$("#postAComment<?=$id_div_comments?>").click(function(){
	//						$("#tableCommentDiv<?=$id_div_comments?>").fadeIn('slow');
	//			});
				$layer.off('click').on('click','[comment] .del',function(){
					var $li=$(this).parents('[comment]');
					delComment($li,opc);
					if($('ul.list li',$layer).length==0&&opc.total>opc.actual)
						getComments('more',opc);
				}).on('click','[comment] .more',function(){
					$(this).prev('p').show().prev('p').add(this).remove();
				}).on('click','.seemore',function(){
					getComments('more',opc);
				});
<?php if(!$dialog){ ?>
				interval=setInterval(function(){
					getComments('refresh',opc);
				},5000);
			},
			close:function(){
				$(opc.layer).off();
				clearInterval(interval);
			}
		});
<?php }?>
	});
</script>
<?php } ?>
