<?php
	include '../../includes/session.php';
	include '../../includes/functions.php';
	include '../../includes/config.php';
	include '../../class/wconecta.class.php';
	if(isset($_GET['userCropPictureFailed'])){
		$GLOBALS['cn']->query('UPDATE users SET updatePicture=0,profile_image_url="" WHERE md5(id)="'.$_GET['userCropPictureFailed'].'"');
		$_SESSION['ws-tags']['ws-user']['updatePicture']='0';
		$_SESSION['ws-tags']['ws-user']['photo']='';
		redirect('../../index.php?current=profile&activeTab=0&showUploadError');
	}elseif($_POST['w']){//if necessary crop the profile picture
		// include '../../class/validation.class.php';
		// $photo='../../img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'];
		// $thumb=generateThumbPath($photo,true);
		// CreateThumb($photo,$thumb,60,$_POST['x'],$_POST['y'],$_POST['w'],$_POST['h']);

		// FTPupload('users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']);
		// $_SESSION['ws-tags']['ws-user']['updatePicture']=0;
		// $GLOBALS['cn']->query('
		// 	UPDATE users SET updatePicture=0
		// 	WHERE id='.$_SESSION['ws-tags']['ws-user']['id']
		// );
		#nuevo
		$data=$_POST;
		$code=$_SESSION['ws-tags']['ws-user']['code'];
		$photo="img/users/$code/".$_SESSION['ws-tags']['ws-user']['photo'];
		$thumb=generateThumbPath($photo,true);
		#se crea la thumb si se ha subido foto o si se cambio el tamaño
		if(!strpos($thumb,'default')&&in_array($res['upload'],array('','done'))){
			if($data['size']){
				$x=$data['x'];
				$y=$data['y'];
				$size=$data['size'];
			}elseif($data['w']){
				$x=$data['x'];
				$y=$data['y'];
				$size=$data['w']>$data['h']?$data['h']:$data['w'];
			}elseif(isset($data['img'])){
				$is=getimagesize(FILESERVER.$photo);
				$x=$y=abs($is[0]-$is[1])/2;
				if($is[0]>$is[1]){
					$y=0;
					$size=$is[1];
				}else{
					$x=0;
					$size=$is[0];
				}
			}
			CreateThumb(FILESERVER.$photo,RELPATH.$thumb,60,$x,$y,$size,$size);
			FTPupload(end(explode('img/',$thumb)));
			$_SESSION['ws-tags']['ws-user']['updatePicture']=0;
			// $GLOBALS['cn']->query("UPDATE users SET updatePicture=0 WHERE id='$myId'");
			CON::update('users','updatePicture=0','id=?',array($myId));
			$res['resize']='done';
		}
	}else{
		include('../../class/validation.class.php');
		//thumb image
		$photo='../../img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'];
		$thumb=generateThumbPath('/img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'],true);
		$is=getimagesize($photo);
		if($is[0]>$is[1]){
			$x=$is[0]-$is[1];
			$y=0;
			$size=$is[1];
		}else{
			$x=0;
			$y=$is[1]-$is[0];
			$size=$is[0];
		}
		CreateThumb($photo,$thumb,60,$x,$y,$size,$size);
		//uploadFTP(generateThumbPath($_SESSION['ws-tags']['ws-user']['photo']),'users','');
		$_SESSION['ws-tags']['ws-user']['updatePicture']=0;
		$GLOBALS['cn']->query('
			UPDATE users SET updatePicture=0
			WHERE id='.$_SESSION['ws-tags']['ws-user']['id']
		);
	}
?>
