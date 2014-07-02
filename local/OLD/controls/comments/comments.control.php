<?php
	include ('../../includes/session.php');
	include ('../../class/Mobile_Detect.php');
	include ('../../includes/config.php');
	include ('../../includes/functions.php');
	include ('../../class/wconecta.class.php');
	include ('../../includes/languages.config.php');
	include ('../../class/forms.class.php');

	if(isset($_REQUEST['comments'])){
		$list=$_REQUEST['comments'];
		foreach($list as $_comment){
			echo '<div info="'.$_comment['id'].'" class="ncomment">';
			if(in_array($_comment['type'], array(2,4,7,8,9))){
				$id_source	= $_comment['id_source'];
				$id_type	= '4';
			}else{
				$id_source	= $_comment['id_source'];
				$id_type	= $_comment['type'];
			}
?>

<?php
	$id_div_comments='_'.$id_source.'_'.$id_type.'_'.  rand(1,1000);

	$min_limit = 2;

	$comments = $GLOBALS['cn']->query('
		SELECT c.id AS id
		FROM comments c
		WHERE c.id_source = "'.$id_source.'" AND c.id_type="'.$id_type.'"
		ORDER BY  c.id DESC
	');

	$num_comments = mysql_num_rows($comments);


	$limit='';
	if($num_comments>$min_limit){
		$limit='limit '.($num_comments-$min_limit).', '.$min_limit;
	}

	$comments = $GLOBALS['cn']->query('
		SELECT
			c.id_source AS id_tag,
			c.id_user_from AS id_from,
			c.id_user_to AS id_to,
			c.comment AS comment,
			c.date AS comment_date,
			(SELECT concat(u.name," ",u.last_name) FROM users u WHERE u.id = c.id_user_from)  AS user_from,
			(SELECT md5(CONCAT(u.id, "_", u.email, "_", u.id)) FROM users u WHERE u.id = c.id_user_from) AS codeUser,
			(SELECT u.profile_image_url FROM users u WHERE u.id = c.id_user_from) AS photoUser,
			c.id AS id
		FROM comments c
		WHERE c.id_source = "'.$id_source.'" AND c.id_type="'.$id_type.'"
		ORDER BY  c.id
		'.$limit);

	$role = true; //control para comentarios de tags de grupo

	$id_user_to = '';

	if (mysql_num_rows($comments)>0){

		switch ($id_type){

			case '4' :
			case '10':
			//datos de la tag
			$tags = $GLOBALS['cn']->query(' SELECT  t.id_user AS idUser, t.id_group FROM tags t WHERE t.id = "'.$id_source.'"');

				$time = @mysql_fetch_assoc($tags);

				$id_user_to = md5(md5($time['idUser']));

				if ($time['id_group']!=0){

					$_GET['current'] = 'groups';
					$role = isInTheGroup(md5($id_grupo));

				}
				break;//1

		}//switch

	}//if hay comments

	$labelTxtComment = COMMENTS_LBLHELPIMPUTNEWCOMMENT.'...';

?>
<div class="div_comments" data-type="<?=$id_type?>" data-source="<?=$_comment['id_source']?>" data-to="<?=$id_user_to?>">
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="list-comments">

	<tr>
		<td colspan="2" >
			<div style="float: left;">
				<img src="img/1320683008_comment.png" width="12" height="12" border="0" />
				<?php //echo $id_source.'-'.$id_type;
					if ($num_comments>$min_limit){ ?>
				<a href="javascript:void(0);" id="viewAllComments<?=$id_div_comments?>" class="view-all" onfocus="this.blur();" style="color:#F58220;">
					<?=COMMENTS_LBLVIEWALL.' <span>'.$num_comments.'</span> '.COMMENTS_LBLCOMMENTS?>
				</a>
				<?php }else{?>
				<a href="javascript:void(0);" id="postAComment<?=$id_div_comments?>" class="post-comment" onfocus="this.blur();" style="color:#F58220;">
					<?=NOTIFICATIONS_TITLECOMMENTSTAGMSJUSER?>
				</a>
				<?php }?>
				<img src="css/smt/loader.gif" width="10" class="loader" style="display: none" />
			</div>
			<?php
				if($id_type==4){
					$num_likes = numRecord("likes", " WHERE id_source = '".$id_source."'");
					$num_disLikes = numRecord("dislikes", " WHERE id_source = '".$id_source."'");
			?>
			<div style="float: right; margin-right: 10px;">
				<img src="img/dislike.png" style="cursor:pointer;" width="16" height="16" border="0" onclick="send_ajax('controls/tags/actionsTags.controls.php?news=1&action=11&tag=<?=$id_source?>', '#tdNumDisLikes_<?=$id_div_comments?>', 2, 'html');" />
				<span id="tdNumDisLikes_<?=$id_div_comments?>" style="color:#F58220;font-weight:bold;" ><?=$num_disLikes?></span>
				<img src="img/like.png" style="cursor:pointer;" width="16" height="16" border="0" onclick="send_ajax('controls/tags/actionsTags.controls.php?news=1&action=4&tag=<?=$id_source?>', '#tdNumDisLikes_<?=$id_div_comments?>', 2, 'html');" />
				<span id="tdNumLikes_<?=$id_div_comments?>" style="color:#F58220;font-weight:bold;" ><?=$num_likes?></span>
			</div>
			<?php
				}
			?>
		</td>
	</tr>
	<?php
		while ($comment = mysql_fetch_assoc($comments)){
			$foto_usuario  =FILESERVER.getUserPicture($comment['codeUser'].'/'.$comment['photoUser'],'img/users/default.png');
	?>
	<tr id="comment_<?=$comment['id']?>" class="tr-comment" comment="<?=$comment['id']?>">
		<td width="7%" style="padding-left:5px;" valign="top">
			<img class="imgUser"  src="<?=$foto_usuario?>" border="0" style="border:1px solid #999; cursor:pointer" title="<?=COMMENTS_FLOATHELPVIEWPROFILEUSER?>" width="40" height="40" command="profile" uname="<?=$comment['user_from']?>" uid="<?=md5($comment['id_from'])?>" />
		</td>
		<td width="93%" valign="top" style="border-bottom:1px solid #F4F4F4">
			<?php if ($comment['id_from']==$_SESSION['ws-tags']['ws-user']['id'] || $id_user_to==$_SESSION['ws-tags']['ws-user']['id']){ ?>
			<img src="img/delete_comment.png" width="8" height="8" style="float:right; margin-right:5px; cursor:pointer" border="0" title="<?=COMMENTS_FLOATHELPREMOVECOMMENT?>" class="del-comment" />
			<?php }//validamos la eliminacion del comentario ?>

			<a href="javascript:void(0);" command="profile" uname="<?=$comment['user_from']?>" uid="<?=md5($comment['id_from'])?>" onfocus="this.blur();" title="<?=COMMENTS_FLOATHELPVIEWPROFILEUSER?>" style="color:#F58220; font-weight:bold; text-decoration:none;"><?=formatoCadena($comment['user_from'])?></a><br />
			<?=strToLink($comment['comment'])?>
			<em style="font-size:9px; color:#CCC; float:right; margin-right:5px"><?=$comment['comment_date']?></em>
		</td>
	</tr>
	<?php
		}//while ?>

</table>
<?php if ($role){ //controles para agregar un nuevo comentario ?>
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" class="action-comment">
	<tr>
		<td colspan="2" valign="top">
			<textarea  class="textareaComment" name="txtComment<?=$id_div_comments?>" id="txtComment<?=$id_div_comments?>"  cols="3" rows="3"><?=$labelTxtComment?></textarea>
		</td>
	</tr>

	<tr id="tr_btn_write_comment_txtComment<?=$id_div_comments?>" class="td-btn-comment" style="display:none">
		<td colspan="2"  style="text-align:right;" >
			<a href="javascript:void(0);" class="btn-comment" id="new_comment<?=$id_div_comments?>"><?=COMMENTS_LBLNEWCOMMENT?></a>
		</td>
	</tr>
</table>
<?php }?>
</div>	
	
<?php
			echo '</div>';
		}
	}
?>
