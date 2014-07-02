<?php
	include '../../includes/session.php';
	include '../../includes/config.php';
	include '../../includes/functions.php';
	include '../../class/wconecta.class.php';

	switch ($_GET[action]) {

		case 'delete':
			$file	= $GLOBALS['cn']->query('SELECT image_path FROM images WHERE md5(id) = "'.$_GET[id_photo].'"');
			$file	= mysql_fetch_assoc($file);

			$file	= substr($file[image_path], 33);

			//deleting image and thumb
				deleteFTP($file, 'users', '../../');
				deleteFTP(generateThumbPath($file), 'users', '../../');
			// END - deleting image and thumb

			$GLOBALS['cn']->query('DELETE FROM images WHERE md5(id)="'.$_GET[id_photo].'"');
			$_SESSION['ws-tags']['ws-user'][showPhotoGallery] = true;

		break;

		case 'makeDefault':

			$file	= $GLOBALS['cn']->query('SELECT id, image_path FROM images WHERE md5(id) = "'.$_GET[id_photo].'"');
			$file	= mysql_fetch_assoc($file);
			$idImg	= $file[id];
			$file	= substr($file[image_path], 33);

			$GLOBALS['cn']->query('	UPDATE	users
									SET		profile_image_url = "'.$file.'"
									WHERE	id='.$_SESSION['ws-tags']['ws-user'][id]);

			$GLOBALS['cn']->query('	UPDATE	album
									SET		id_image_cover = "'.$idImg.'"
									WHERE	id_user = '.$_SESSION['ws-tags']['ws-user'][id].' AND
											name = "profile"');

			$_SESSION['ws-tags']['ws-user']['photo']=$file;
            $_SESSION['ws-tags']['ws-user']['pic']='img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'];
		break;
	}
?>
