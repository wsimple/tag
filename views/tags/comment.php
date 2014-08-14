<?php
global $dialog;
//	$dialog=isset($_GET['popup'])||isset($_GET['dialog']);
	//echo $_GET['tag'];
	$_GET[tag]=intToMd5($_GET['tag']);
	$tag = $GLOBALS['cn']->queryRow('
		SELECT
			id_user AS idUser,
			id AS idTag,
			status AS status,
			id_group
		FROM tags
		WHERE md5(id) = "'.$_GET['tag'].'"
	');
	if(($tag['status']!='2')&&($tag['status']!='')){
		$idTag = $tag['idTag'];
	}else{
		$idTag = '';
	}

//	$num_comments = numRecord('comments', ' WHERE id_source = "'.$idTag.'" and id_type= "4"');
//	$num_likes = numRecord('likes', " WHERE id_source = '".$idTag."'");
	$_GET['current']='comments';
?>
<div id="<?=$dialog?'tag-dialog':'tag-box'?>" class="<?=$dialog?'':'ui-single-box'?>">
<?php if(!$dialog){ ?>
	<div class="ui-single-box-title">
		<?='Tag View'?>
	</div>
<?php } ?>
	<div class="comments-tags">
		<div class="tag-box">
			<div id="dialoglayerTag" class="tag-container"></div>
		</div>
		<div class="comments-box-c" tag="<?=$idTag?>">
			<?php
			if($idTag!=''){
				$id_source = $tag['idTag'];
				$id_type   = 4;
				$id_user_to = md5(md5($tag['idUser']));
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
		<?php
		if($idTag!=''){
		?>
		console.log('tag con un id registrado');
		$.ajax.log({
			type: 'GET',
			dataType: 'json',
			url: 'controls/tags/tagsList.json.php?id=<?=$idTag?>',
			success	: function(data){
				if (data['tags'].length>0){
					$('#dialoglayerTag').html(showTags(data['tags']));
					//$('[title]',tlc).tipsy({html: true,gravity: 'n'});
					$("#menuTagnoLogged").click(function () {
						$("#msgTagNologged").toggle("fade");
					});
				}
			}
		});
		<?php
		}else{
		?>	console.log('tag por defecto cuando el id no existe');
			$('#dialoglayerTag').html('<div class="tagNoExits"><?=TAGS_WHENTAGNOEXIST?>.</div>'
							   +'<img src="img/templates/defaults/346f3ee097c010b4ed71ce0fb08bbaf2.jpg">');
		<?php
		}
		?>
	});
</script>
