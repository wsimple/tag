<?php
	include '../includes/config.php';
	include RELPATH.'class/wconecta.class.php';
	include RELPATH.'includes/functions.php';

	// getting images from phone
	if( $_REQUEST['image64'] ) {


		$imgData= base64_decode($_REQUEST['image64']);


		$path	= RELPATH.'img/templates/'.$_REQUEST['code'].'/';
		$photo	= md5(date('Ymdgisu')).'.jpg';


		// if directory doesn't exist
		if( !is_dir ($path) ) {
			$old= umask(0);
			mkdir($path, 0777);
			umask($old);
			$fp	= fopen($path.'index.html', 'w');
			fclose($fp);
		}


		$fp = fopen($path.$photo, 'w');

		if( $fp ) {

			fwrite($fp, $imgData);
			fclose($fp);

			if( redimensionar($path.$photo, $path.$photo, 650) ) {
				uploadFTP($photo, 'templates', RELPATH, 1, $_REQUEST['code']);
			}

			$response	= 'IMAGE_OK';
			$photo		= substr($path.$photo, 17);

		} else {

			$response	= 'IMAGE_ERROR';
			$photo		= '';
		}

	// getting images from Templates
	} elseif( $_REQUEST['imgTemplate'] ) {

		$response	= 'IMAGE_OK';
		$photo = $_REQUEST['imgTemplate'];

	// no image select a random one from defaults
	} else {

		$imagesAllowed = array('jpg', 'jpeg', 'png', 'gif');
		$folder = opendir(RELPATH.'img/templates/defaults/');
		unset($defaultbackgrounds);
		while ($pic = @readdir(&$folder)){
			$args = explode('.', $pic);
			$extension = strtolower(end($args));
			if( in_array($extension, $imagesAllowed) ){
				$defaultbackgrounds[]	= $pic;

			}
		}

		$response	= 'IMAGE_OK';
		$photo		= 'defaults/'.$defaultbackgrounds[ rand(0, (count($defaultbackgrounds)-1)) ];
	}

	$message[0]	= cls_string($_REQUEST['topMessage']);
	$message[0]	= ($message[0] ? $message[0] : '&nbsp');

	$message[1]	= cls_string($_REQUEST['middleMessage']);
	$message[1]	= ($message[1] ? $message[1] : '&nbsp');

	$message[2]	= cls_string($_REQUEST['bottomMessage']);
	$message[2]	= ($message[2] ? $message[2] : '&nbsp');

	$status = ($_REQUEST['idGroup']? 7 : 1);

	$idGroup	= $GLOBALS['cn']->query('SELECT id FROM groups WHERE md5(id)="'.$_REQUEST['idGroup'].'"');
	$idGroupTag = mysql_fetch_assoc($idGroup);

	$groupTag = ($idGroupTag['id']!=0 ? $idGroupTag['id'] : 0);

	$insert	= '	INSERT INTO
					tags
				SET
					id_user				= "'.$_REQUEST['id'].'",
					id_creator			= "'.$_REQUEST['id'].'",
					text				= "'.$message[0].'",
					code_number			= "'.$message[1].'",
					text2				= "'.$message[2].'",
					background			= "'.$photo.'",
					profile_img_url		= (SELECT profile_image_url FROM users WHERE id='.$_REQUEST['id'].'),
					status				= "'.$status.'",
					points				= "100",
					id_product			= "",
					color_code			= "'.$_REQUEST['topColor'].'",
					color_code2			= "'.$_REQUEST['middleColor'].'",
					color_code3			= "'.$_REQUEST['bottomColor'].'",
					geo_lat				= "",
					geo_log				= "",
					video_url			= "",
					id_business_card	= "",
					id_group		    = "'.$groupTag.'"';

	mysql_query($insert);

	$tag_insert_id	= mysql_insert_id();

	createTag($tag_insert_id);

	mysql_query('UPDATE tags SET source=id WHERE id='.$tag_insert_id);/**/


	if ($_REQUEST['idGroup']!=''){

		//aqui va la notificacion grupo
		$usersgroups = $GLOBALS['cn']->query("
					   SELECT t.id AS idUser
					   FROM users t inner JOIN users_groups u ON t.id = u.id_user
					   WHERE md5(id_group) = '".$_REQUEST['idGroup']."'"
		);

		while ($usersgroup = mysql_fetch_assoc($usersgroups)){

			if($usersgroup[idUser]!=$_REQUEST['id']){

				notifications($usersgroup[idUser], $tag_insert_id, 10,'',$_REQUEST['id']);

			}

		}

	}


	//private
		if( $_REQUEST['shareWith'] ) {

			$friends = split(',', $_REQUEST['shareWith']);
			$mail = '';
			$sent = false;

			foreach( $friends as $friend ) {

				if( $friend ) {

					$id_friend = campo('users', 'email', $friend, 'id');

					if( isFriend($id_friend, $_REQUEST['id']) ) {

						$GLOBALS['cn']->query('	INSERT INTO tags_privates
												SET	id_user		= '.$_REQUEST['id'].',
													id_friend	= '.$id_friend.',
													id_tag		= '.$tag_insert_id.',
													status_tag	= "4"');
						$sent = true;
						notifications($friend, $tag_insert_id, 1);
					} else {
						$mail .= $friend.',';
					}
				}
			}
			if( $sent ) {
				mysql_query('UPDATE tags SET status="4" WHERE id='.$tag_insert_id);/**/
			}
			$response.= '|'.substr($mail, 0, -1).'|'.$tag_insert_id;
		}
	// END - private

	echo $response;
?>