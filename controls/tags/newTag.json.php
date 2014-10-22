<?php
include '../header.json.php';
include RELPATH.'class/class.phpmailer.php';
function newTag_json($data,$mobile=false){
	global $debug;
	$res=array();
	if($debug){
		$res['_data_']=$data;
	}
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	$imagesAllowed=array('jpg','jpeg','png','gif');
	//acciones si solo se sube un archivo (picture upload)
	if($data['type']=='uploadfile'){
		$res['type']='uploadfile';
		if(isset($_FILES['picture'])&&$_FILES['picture']['error']==0){
			#extension
			$parts=explode('.',$_FILES['picture']['name']);
			$ext=strtolower(end($parts));
			#validacion del formato de la imagen
			if(in_array($ext,$imagesAllowed)){
				$path=RELPATH.'img/templates/'.$_SESSION['ws-tags']['ws-user']['code'].'/';//ruta para crear dir
				$foto=md5(date('Ymdgisu')).'.jpg';
				$photo=$_SESSION['ws-tags']['ws-user']['code'].'/'.$foto;
				/*existencia de la folder*/
				if(!is_dir($path)){
					$old=umask(0);
					mkdir($path,0777);
					umask($old);
					$fp=fopen($path.'index.html','w');
					fclose($fp);
				}//is_dir
				/*subiendo del archivo al servidor*/
				if(redimensionar($_FILES['picture']['tmp_name'],RELPATH.'img/templates/'.$photo,650)){
					FTPupload("templates/$photo");
					$res['done']=true;
					$res['bg']=$photo;
				}else{
					$res['done']=false;
					$res['msg']=NEWTAG_CTRERRORUPLOAD;
					$res['title']=NEWTAG_CTRTITLEERROR;
				}//copy
			}else{
				//extension
				$res['uploaded']=false;
				$res['msg']="-&nbsp;".NEWTAG_CTRERRORFILEFORMAT.".<br/>";
				$res['title']=NEWTAG_CTRTITLEERROR;
			}
			return $res;
		}
	}//endif(picture upload)

	//inicio
	switch($data['type']){
		case 'preview':$res['type']='preview';break;//Cuando es una preview
		case 'creation':case 'newtag':$res['type']='new';break;//Cuando es una tag nueva
		case 'update':case 'edit':$res['type']='update';break;//Cuando es una edicion
//		case 'redist':$res['redist']=true;break;//Cuando es una redistribucion
	}

	//validaciones.
	#si es una tag tipo producto
	if($data['product']){
		//$product=$GLOBALS['cn']->queryRow('SELECT id FROM products_user WHERE md5(id)="'.$data['product'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
		$product=$GLOBALS['cn']->queryRow('SELECT id FROM store_products WHERE md5(id)="'.$data['product'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
		$data['product']=$product['id'];
	}
	#si hay personas, se verifican
	if($data['status']!=4) unset($data['people']);
	if($data['people']){
		if(!is_array($data['people'])) $data['people']=explode(',',$data['people']);
		$_users=array();
		$_mails=array();
		$friends=$data['people'];
		if(!is_array($friends))	$friends=split(',',$friends);
		foreach($friends as $friend){
			if($friend!=''){
				if(!preg_match('/\D/',$friend)){//si es un id (numerico)
					$id_friend=get_campo('id','users','id="'.$friend.'"');
				}elseif(isValidEmail($friend)){//si es un correo registrado
					$id_friend=get_campo('id','users','email="'.$friend.'"');
					if($id_friend!=''&&!isFriend($id_friend,$myId)) unset($id_friend);
				}else{//si es un id en md5
					$id_friend=get_campo('id','users','md5(id)="'.$friend.'"');
				}
				if($id_friend!=''){//si es un usuario registrado y es mi amigo
					if(!in_array($id_friend,$_users)) $_users[]=$id_friend;
				}elseif(isValidEmail($friend)){//si es correo de un usuario no registrado
					if(!in_array($friend,$_mails)) $_mails[]=$friend;
				}
			}
		}
		if(count($_users)+count($_mails)>0){//si hay elementos validos
			$data['people']=array('users'=>$_users,'emails'=>$_mails);
		}else{//si ningun elemento es valido
			unset($data['people']);
			$data['status']=1;
		}
		unset($_users,$_mails);
	}
	#validamos el grupo
	if($data['group']!=''){
		$group=$GLOBALS['cn']->queryRow('SELECT id FROM groups WHERE md5(id)="'.intToMd5($data['group']).'"');
		$data['group']=$group['id'];
		$res['group']=$data['group'];
	}
	#validacion del video
	if($data['video']==''||!preg_match(regex('video'),$data['video'])) $data['video']=='http://';
//	$data['video']=preg_replace(regex('youtubelong'),'http://youtu.be/$6',trim($data['video']));
//	$data['video']=preg_replace(regex('video'),'http://$2',$data['video']);
	$res['video']=$data['video'];
	if(isVideo('vimeo',$res['video'])){
		if(preg_match('/vimeo.com\\/([^\\?\\&]+)/i',$res['video'],$matches)){
			$res['typeVideo']='vimeo';
			$vec=explode('/', $matches[1]);
			$code = end($vec);
			if (!$mobile) $res['video']='http://player.vimeo.com/video/'.$code.'?byline=0&badge=0&portrait=0&title=0';
			// $res['video']='http://player.vimeo.com/video/'.$code.'?byline=0&badge=0&portrait=0&title=0';
		}
	}elseif(isVideo('youtube',$res['video'])){
		if($data['embed'])
			$res['video']=preg_replace(regex('youtube'),'http://youtube.com/embed/$7$9',$res['video']);
		if(preg_match('/(youtube\\S*[\\/\\?\\&]v[\\/=]|youtu.be\\/)([^\\?\\&]+)/i',$res['video'],$matches)){
			$res['typeVideo']='youtube';
			$type='youtube';
			$code=$matches[2];
			if (!$mobile) $res['video']=$code;
			// if (!$mobile) $res['video']='http://www.youtube.com/embed/'.$code.'?rel=0&showinfo=0&cc_load_policy=0&controls=2';
			// $res['video']='http://www.youtube.com/embed/'.$code.'?rel=0&showinfo=0&cc_load_policy=0&controls=2';
		}
	}
	#image64 (usado para subir fotos en mobile)
	if($data['img64']!=''){
		$imgData=base64_decode(preg_replace('/^data:image\/\w*;base64,/i','',$data['img64']));
		$code=$_SESSION['ws-tags']['ws-user']['code'];
		$path=RELPATH.'img/templates/'.$code.'/';
		$photo=md5(date('Ymdgisu')).'.jpg';
		$_photo="$code/$photo";
		//if directory doesn't exist
		if(!is_dir($path)){
			$old=umask(0);
			mkdir($path,0777);
			umask($old);
			$fp=fopen($path.'index.html','w');
			fclose($fp);
		}
		$fp=fopen($path.$photo,'w');
		if($fp){
			$res['uploaded']=true;
			fwrite($fp,$imgData);
			fclose($fp);
			if(redimensionar($path.$photo,$path.$photo,650)){
				$res['redimensionar']=true;
				FTPupload("templates/$_photo",RELPATH);
			}
			$data['background']=$_photo;
		}else{
			$res['uploaded']=false;
			$res['msg']=NEWTAG_CTRERRORFILEFORMAT;
			$res['title']=NEWTAG_CTRTITLEERROR;
			return $res;
		}
	}
	#background
	if($data['background']==''&&isset($res['type'])){
		$folder=opendir(RELPATH.'img/templates/defaults/');
		$defaultbackgrounds=array();
		while($pic=@readdir($folder)){
			$args=explode('.',$pic);
			$extension=strtolower(end($args));
			if(in_array($extension,$imagesAllowed))
				$defaultbackgrounds[]=$pic;
		}
		$key=array_rand($defaultbackgrounds);
		$data['background']='defaults/'.$defaultbackgrounds[$key];
		$res['bg']=$data['background'];
	}
	#status
	$res['status']=$data['status'];

	if($res['type']=='preview'){//si es una preview de tag
		$date=CON::getVal('SELECT unix_timestamp(NOW())');// $GLOBALS['cn']->queryRow('SELECT unix_timestamp(NOW()) AS fecha;');
		$img=array(
			'fondoTag'=>$data['background'],
			'texto'=>$data['topText'],
			'color_code'=>$data['topColor'],
			'code_number'=>$data['middleText'],
			'color_code2'=>$data['middleColor'],
			'texto2'=>$data['bottomText'],
			'color_code3'=>$data['bottomColor'],
			'date'=>$date,//['fecha']
		);
//		SELECT
//				if(p.id is null,u.screen_name,p.name) as name,
//				if(p.id is null,if(u.profile_image_url="","",concat("img/users/",md5(CONCAT(u.id,"_",u.email,"_",u.id)),"/",u.profile_image_url)),concat("img/products/",p.picture)) as photo
//			FROM users u
//			LEFT JOIN products_user p ON p.id="'.$_POST['product'].'"
//			WHERE u.id="'.$data['id'].'" 
		$usr=$GLOBALS['cn']->queryRow('
			SELECT
				if(p.id is null,u.screen_name,p.name) as name,
				if(p.id is null,if(u.profile_image_url="","",concat("img/users/",md5(CONCAT(u.id,"_",u.email,"_",u.id)),"/",u.profile_image_url)),concat("img/store/",p.photo)) as photo
			FROM users u
			LEFT JOIN store_products p ON p.id="'.$data['product'].'"
			WHERE u.id="'.$myId.'" 
		');
		$img['nameOwner']=$usr['name'];
		$img['photoOwner']=getUserPicture($usr['photo']);
		$tag=createTag($img);
		$res['preview']=true;
		$res['img']=FILESERVER.'/img/tags/'.$tag.'.jpg';

	}elseif ($res['type']=='update') {
		
		$sql='UPDATE tags SET
				background		    ="'.$data['background'].'",
				text				="'.$data['topText'].'",
				code_number			="'.$data['middleText'].'",
				text2				="'.$data['bottomText'].'",
				color_code			="'.$data['topColor'].'",
				color_code2			="'.$data['middleColor'].'",
				color_code3			="'.$data['bottomColor'].'",
				video_url			="'.$data['video'].'"
			WHERE id = "'.$data['tag'].'"
		';
		//Usado para trending toping
		set_trending_topings($data['topText'].' '.$data['middleText'].' '.$data['bottomText'],true);
		
		$update=$GLOBALS['cn']->query($sql);
		$tag=createTag($data['tag'],true);

	}elseif($res['type']=='new'){//si es una creacion o edicion
		
		$topText    = explode(' ', $data['topText']);
		$bottomText = explode(' ', $data['bottomText']);
		
		for($i=0;$i<count($topText);$i++){
			if(strlen($topText[$i])>32){
				$topE[] = $topText[$i];
				$topR[] = substr($topText[$i], 0, 32);
			}
		}
		
		for($i=0;$i<count($bottomText);$i++){
			if(strlen($bottomText[$i])>40){
				$botE[] = $bottomText[$i];
				$botR[] = substr($bottomText[$i], 0, 40);
			}
		}
		
		$data['topText'] = str_replace($topE, $topR, $data['topText']);
		$data['bottomText'] = str_replace($botE, $botR, $data['bottomText']);
		 
		$sql='INSERT INTO tags SET
				id_creator			="'.$myId.'",
				id_user				="'.$myId.'",
				id_product			="'.$data['product'].'",
				background		    ="'.$data['background'].'",
				text				="'.$data['topText'].'",
				code_number			="'.$data['middleText'].'",
				text2				="'.$data['bottomText'].'",
				color_code			="'.$data['topColor'].'",
				color_code2			="'.$data['middleColor'].'",
				color_code3			="'.$data['bottomColor'].'",
				status				="'.$data['status'].'",
				profile_img_url		="'.$_SESSION['ws-tags']['ws-user']['photo'].'",
				video_url			="'.$data['video'].'",
				id_business_card	="'.$data['bcard'].'",
				points				="100",
				id_group			="'.$data['group'].'",
				geo_lat				="",
				geo_log				=""
		';

		//Usado para trending toping
		set_trending_topings($data['topText'].' '.$data['middleText'].' '.$data['bottomText'],true);

		$insert=$GLOBALS['cn']->query($sql);
		$tagId=mysql_insert_id();
		$GLOBALS['cn']->query('UPDATE tags SET source="'.$tagId.'" WHERE id="'.$tagId.'" AND id_user="'.$myId.'"');

		$res['idTag']=$tagId;
		$tag=createTag($tagId,true);
		$res['img']=FILESERVER.'/img/tags/'.$tag.'.jpg';
		if($data['tag']){//si es un update
//			$updateCom=$GLOBALS['cn']->queryRow('SELECT id FROM comments WHERE id_source="'.$data['tag'].'"');
//			if($updateCom['id']){
//				$GLOBALS['cn']->query('UPDATE comments SET id_source="'.$tagId.'" WHERE id_source="'.$data['tag'].'"');//actualiza la tabla comments con el id nuevo de la tag
//			}
// 			$redist=$GLOBALS['cn']->queryRow('SELECT * FROM tags WHERE source="'.$data['tag'].'" AND id!=source LIMIT 0,1');
// 			//updateTagData($data['tag'],$tagId);//cambia los id de la tag vieja por la nueva
// 			if($redist['id']){//si fue redistribuida se conserva y se le cambia el estado
// 				$update=$GLOBALS['cn']->query('UPDATE tags SET status="2" WHERE id="'.$data['tag'].'" AND (id_creator="'.$myId.'" OR id_user="'.$myId.'")');
// 			}else{//si no fue redistribuida, la eliminamos

// 				//obtenemos los datos de la tag vieja para hacer update con ellos en la tag nueva
// 				$idbackG=$GLOBALS['cn']->query('SELECT id,img,id_creator FROM tags WHERE id="'.$data['tag'].'"');
// 				$idbackGs=mysql_fetch_assoc($idbackG);

// 				//bbuscamos el nombre de la img que se acaba de crear
// 				$backGNew=$GLOBALS['cn']->query('SELECT img FROM tags WHERE id="'.$tagId.'"');
// 				$backGNews=mysql_fetch_assoc($backGNew);

// 				//eliminamos la tag vieja
// 				deleteFTP($idbackGs['img'].'.m.jpg','tags','../../');
// 				deleteFTP($idbackGs['img'].'.jpg','tags','../../');

// 				//renombramos la tag nueva con el nombre viejo de la tag
// 				renameFTP($backGNews['img'].'.jpg',$idbackGs['img'].'.jpg','tags','../../');
// 				renameFTP($backGNews['img'].'.m.jpg',$idbackGs['img'].'.m.jpg','tags','../../');
				
// 				if($data['wpanel']!='1'){
// 					$creator  = 'AND id_creator="'.$myId.'"';
// 					$satusTag = 'AND status!="4"';
// 				}else{
// 					if($idbackGs['id_creator']==$myId){
// 						$creator  = 'AND id_creator="'.$myId.'"';
// 					}else{
// 						$creator  = 'AND id_creator="'.$idbackGs['id_creator'].'"';
// 					}
// 					$satusTag = 'AND status="10"';
// 				}
				
// 				$GLOBALS['cn']->query('DELETE FROM tags WHERE id="'.$data['tag'].'" '.$creator.' '.$satusTag.' ');//se elimina la tag vieja
// 				$GLOBALS['cn']->query('UPDATE tags SET id="'.$idbackGs['id'].'",source="'.$idbackGs['id'].'",img="'.$idbackGs['img'].'" WHERE id="'.$tagId.'" AND id_user="'.$myId.'"');//se actualiza la tag nueva con el id viejo

// //				  $GLOBALS['cn']->query('UPDATE users_notifications SET id="'.$data['tag'].'" WHERE id="'.$data['tag'].'"');
// 				//$delete=$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE id_source="'.$data['tag'].'" AND id_type IN (1,2,4,7,8,9,10)');
// 			}
		}else{//si es una tag nueva se actualizan tags_count,accumulated_points y current_points
			$points=getCreatingTagPoints();
			updateUserCounters($myId,'tags_count','1','+');
			updateUserCounters($myId,'accumulated_points',$points,'+');
			updateUserCounters($myId,'current_points',$points,'+');
		}
		if($data['people']){//notificacion de tag privada
			foreach($data['people']['users'] as $friend){//amigos de Tagbum
				$insert=$GLOBALS['cn']->query('
					INSERT INTO tags_privates SET
						id_user		="'.$myId.'",
						id_friend	="'.$friend.'",
						id_tag		="'.$tagId.'",
						status_tag	="'.($data['status']==4?4:0).'"
				');
				notifications($friend,$tagId,1);
				$usersMail.=md5($friend).',';
			}//foreach
			tagToMail($tagId,implode(',',$data['people']['emails']),'css/smt/email/tags.png');//emails
			tagToMail($tagId,rtrim($usersMail,','),'css/smt/email/tags.png');//usuarios registrados
		}
		if($data['group']!=''){//notificacion para usuarios de grupo
			$users=$GLOBALS['cn']->query('SELECT u.id FROM users u JOIN users_groups g ON u.id=g.id_user WHERE g.id_group="'.$data['group'].'" AND u.id!="'.$myId.'" AND g.status="1"');
			while($user=mysql_fetch_assoc($users)){
				notifications($user['id'],$tagId,10);
			}
		}//if group
		$res['done']=true;
		$res['msj']=NEWTAG_CTRMSGDATASAVE;
		$res['title']=NEWTAG_CTRTITLEINFO;
	}else{
		if($data['bcard']){//asociamos business card
			$GLOBALS['cn']->query('UPDATE tags SET id_business_card="'.$data['bcard'].'" WHERE id="'.$data['bcard'].'"');
		}
		//unlink('img/templates/'.$photo);
		deleteFTP($photo,'templates','../../');
		$res['done']=false;
		$res['msj']=NEWTAG_CTRERRORNEWTAG;
		$res['title']=NEWTAG_CTRTITLEERROR;
	}
	return $res;
}
if(!$notAjax){
	$data=array();
	$data['debug']=isset($_GET['debug'])||isset($_POST['debug']);
	$data['id']=isset($_POST['id'])?$_POST['id']:$_SESSION['ws-tags']['ws-user']['id'];
	$bg=isset($_POST['template'])?$_POST['template']:$_POST['imgTemplate'];
	if($bg!=''&&strpos($bg,'img/templates/')!==false) $bg=substr($bg,strpos($bg,'img/templates/')+14);
	if($bg!='') $data['background']=$bg;
	$data['img64']=$_REQUEST['img64'];
	$data['topText']=$_POST['topText']!=''?cls_string($_POST['topText']):cls_string($_POST['txtMsg']);
	$data['topColor']=$_POST['topColor']!=''?cls_string($_POST['topColor']):cls_string($_POST['hiddenColor']);
	$data['middleText']=$_POST['middleText']!=''?cls_string($_POST['middleText']):cls_string($_POST['txtCodeNumber']);
	$data['middleColor']=$_POST['middleColor']!=''?cls_string($_POST['middleColor']):cls_string($_POST['hiddenColor2']);
	$data['bottomText']=$_POST['bottomText']!=''?cls_string($_POST['bottomText']):cls_string($_POST['txtMsg2']);
	$data['bottomColor']=$_POST['bottomColor']!=''?cls_string($_POST['bottomColor']):cls_string($_POST['hiddenColor3']);
	$data['status']=$_POST['status'];
	$data['type']=$_POST['type']!=''?$_POST['type']:$_GET['type'];
	$data['video']=$_POST['htxtVideo'];
	$data['group']=$_POST['group']!=''?$_POST['group']:$_GET['group'];
	$data['bcard']=$_POST['idBusinessC'];
	$data['tag']=$_POST['tag'];
	
	$data['wpanel']=$_POST['wpanel'];
	
	$data['product']=$_POST['product'];
	$data['people']=isset($_POST['people'])?$_POST['people']:(isset($_POST['cboPeoples'])?$_POST['cboPeoples']:false);
	die(jsonp(newTag_json($data,isset($_REQUEST['mobile']))));
}
?>
