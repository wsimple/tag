<?php
include '../header.json.php';

	$id_tag=campo('tags','md5(id)',intToMd5($_GET['id']),'id');
	if(isset($_GET['debug'])) echo 'idtag='.$id_tag.'<br/>';

	if (isset($_REQUEST['getReportCombo'])){
		$tipos	= 'SELECT id, descrip FROM type_tag_report ORDER BY id';
		$tipos	= $GLOBALS['cn']->query($tipos);

		unset($ret);
		while ($tipo=mysql_fetch_assoc($tipos)){
			$ret[] = $tipo['id'];
			$ret[] = lan($tipo['descrip']);
		}

		die(jsonp($ret));

	}// if getReportCombo

	$sql = $GLOBALS['cn']->query('
		SELECT
			CONCAT(u.name, " ", u.last_name) AS nameUsr,
			t.video_url,
			t.id,
			t.id_creator,
			t.id_user,
			t.status
		FROM tags t JOIN users u ON t.id_user=u.id
		WHERE t.id = "'.$id_tag.'"
		LIMIT 1
	');
	$tag = mysql_fetch_assoc($sql);
	$tag['tag']= createTag($id_tag);

	if (isset($_GET['id_user'])){
		$id_user=campo('users','md5(id)',  intToMd5($_GET['id_user']),'id');
		if(isset($_GET['debug'])) echo 'iduser='.$id_user.'<br/>';
		//redistribucion
		$canRedistribute = ($tag['status']!='4') ? true : false;

		//compartir
		$canSahre = false;
		if ($tag['status']=='4' && $tag[id_user] == $id_user) {
			$canSahre = true;
		}elseif ($tag['status']!='4'){
			$canSahre = true;
		}

		//borrar
		$canDelete = $GLOBALS['cn']->query("
			SELECT id
			FROM tags
			WHERE id='".$id_tag."' AND id_user='".$id_user."' AND id_user=id_creator
		");
		$canDelete = (mysql_num_rows($canDelete)>0) ? true : false;

		//denunciar
		$canBry = $GLOBALS['cn']->query("
			SELECT id
			FROM tags
			WHERE id='".$id_tag."' AND id_user='".$id_user."'
		");
		$canBry = (mysql_num_rows($canBry)==0) ? true : false;

		//icono de redistribuciÃ³n
		$showIconRedis = $GLOBALS['cn']->query("
			SELECT id
			FROM tags
			WHERE id_user = '".$id_user."' AND source = '".$id_tag."' AND id != '".$id_tag."'
		");

		if (mysql_num_rows($showIconRedis)>0||($id_user != $tag['id_creator'] && $tag['id_user'] == $id_user)){
			$showIconRedis = true;
		}else{
			$showIconRedis = false;
		}

		//likes
		$tag['likeIt'] =$id==''?0:
			(existe('likes', 'id_source', 'WHERE id_source='.$id_tag.' AND id_user="'.$id_user.'"')?1:
			(existe('dislikes','id_source', 'WHERE id_source="'.$id_tag.'" AND id_user="'.$id_user.'"')?-1:
			0));

		$num_likes= numRecord('likes', 'WHERE id_source="'.$tag['id'].'"');
		$num_disLikes= numRecord('dislikes', 'WHERE id_source="'.$tag['id'].'"');

		//video
		if(trim($tag['video_url'])!=''){
			if(isYoutubeVideo($tag['video_url'])){
				$video = 1;
			}elseif(isVimeoVideo($tag['video_url'])){
				$video = 2;
			}
		}

		//datos del usuario
		$user= $GLOBALS['cn']->query("
			SELECT md5(CONCAT(id, '_', email, '_', id)) AS code
			FROM users
			WHERE id = '".$tag['id_creator']."'
		");
		$user= mysql_fetch_assoc($user);
	}

	$ret = array(
		'outTemp' => $tag['status'].' == 4 && '.$tag['id_user'].' == '.$id_user,
		'idTag'				=> $id_tag,
		'tag'				=> $tag['tag'],
		'likeIt'			=> $tag['likeIt'],
		'showRedistributed'	=> $showIconRedis,
		'numLikes'			=> $num_likes,
		'numDislikes'		=> $num_disLikes,
		'nameUsr'			=> htmlentities($tag['nameUsr']),
		'id_creator'		=> $tag['id_creator'],
		'code_creator'		=> $user['code'],
		'val_video'			=> $video,
		'video_url'			=> $tag['video_url'],
		'canRedistribute'	=> $canRedistribute,
		'canShare'			=> $canSahre,
		'canBry'			=> $canBry,
		'canDelete'			=> $canDelete
	);

	die(jsonp($ret));

?>