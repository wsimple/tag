<?php
	global $dialog,$section,$params;
	if(is_debug()&&preg_match('/^\d+$/i',$params[0]))//solo se permite el id numerico para debug
		$tid=$params[0];
	elseif(preg_match('/^[0-9a-f]{32}$/i',$params[0]))
		$tid=$params[0];
	else
		$tid=isset($_GET['tag'])?$_GET['tag']:$_GET['id'];
	$tag=CON::getRow('
		SELECT id,id_user,status,id_group
		FROM tags
		WHERE md5(id)=?
	',array(intToMd5($tid)));
	if($tag['status']==''||$tag['status']=='2') unset($tag);
//	$num_comments = numRecord('comments', ' WHERE id_source = "'.$tag['id'].'" and id_type= "4"');
//	$num_likes = numRecord('likes', " WHERE id_source = '".$tag['id']."'");
?>
<div id="<?=$dialog?'tag-dialog':'tag-box'?>" class="<?=$dialog?'':'ui-single-box'?>">
<?php if(!$dialog){ ?>
	<div class="ui-single-box-title">
		<?='Tag View'?>
	</div>
<?php } ?>
	<div class="comments-tags">
		<div class="tag-box">
			<div id="layerTag<?=$dialog?'_':'';?>" class="tag-container"></div>
		</div>
		<div class="comments-box-c" tag="<?=$tag['id']?>">
			<?php
			if($tag['id']!=''){
				$id_source =$tag['id'];
				$id_type   =4;
				$id_user_to=md5(md5($tag['id_user']));
				include('views/comments/comments.php');
			}
			?>
		</div>
	</div>
	<p id="msgTagNologged">
		<?=TAGS_MSGTAGNOLOGGED?>
		<strong><a href="<?=base_url('signup')?>" style="color: #f82"><?=SIGNUP_BTNNEXT?></a></strong> o <strong><a href="#" style="color: #f82"><?=MNUUSER_TITLEHOME?></a></strong>.
		<?=TAGS_MSGTAGNOLOGGED2?>
	</p>
</div>
<script>
	$(function(){
		<?php if($tag['id']!=''){ ?>
		console.log('tag con un id registrado');
		$.ajax.log({
			type: 'GET',
			dataType: 'json',
			url: 'controls/tags/tagsList.json.php?id=<?=$tag['id']?>',
			success	: function(data){
				if (data['tags'].length>0){
					$('#layerTag<?=$dialog?'_':'';?>').html(showTags(data['tags']));
					//$('[title]',tlc).tipsy({html: true,gravity: 'n'});
					$("#menuTagnoLogged").click(function () {
						$("#msgTagNologged").toggle("fade");
					});
				}
			},
			complete:function(){
				iniallYoutube();
			}
		});
		<?php
		}else{
		?>	console.log('tag por defecto cuando el id no existe');
			$('#layerTag').html('<div class="tagNoExits"><?=TAGS_WHENTAGNOEXIST?>.</div>'
							   +'<img src="img/templates/defaults/346f3ee097c010b4ed71ce0fb08bbaf2.jpg">');
		<?php
		}
		?>
	});
</script>
