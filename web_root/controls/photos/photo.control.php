<?php
include '../../includes/session.php';
include '../../includes/config.php';
include '../../includes/functions.php';
include '../../class/wconecta.class.php';

switch ($_GET['action']){
	case 'delete':
		$file=CON::getRow('SELECT image_path FROM images WHERE md5(id)=?',array($_GET['id_photo']));
		$file=substr($file['image_path'],33);
		//deleting image and thumb
		deleteFTP($file, 'users', '../../');
		deleteFTP(generateThumbPath($file), 'users', '../../');
		// END - deleting image and thumb
		CON::query('DELETE FROM images WHERE md5(id)=?',array($_GET['id_photo']));
		save_in_session(array('ws-tags'=>array('ws-user'=>array('showPhotoGallery'=>true))));
	break;
	case 'makeDefault':
		$file	= CON::getRow('SELECT id,image_path FROM images WHERE md5(id)=?',array($_GET['id_photo']));
		$idImg	= $file['id'];
		$file	= substr($file['image_path'], 33);
		CON::update('users','profile_image_url=?','id=?',array($file,$_SESSION['ws-tags']['ws-user']['id']));
		CON::update('album','id_image_cover=?','id_user=? AND name="profile"',array($idImg,$_SESSION['ws-tags']['ws-user']['id']));
		with_session(function(&$sesion)use($file){
			$sesion['ws-tags']['ws-user']['photo']=$file;
			$sesion['ws-tags']['ws-user']['pic']='img/users/'.$sesion['ws-tags']['ws-user']['code'].'/'.$sesion['ws-tags']['ws-user']['photo'];
		});
	break;
}
