<?php
include '../header.json.php';

	//si se pasa la fecha por parametro, utilizamos esa fecha
	if(isset($_REQUEST['date'])) $res['date']=$_REQUEST['date'];
    else{
        //res guarda los datos json a enviar. se extrae la fecha de mysql
	   $res=$GLOBALS['cn']->queryRow('SELECT now() as date');
    }
	//otras variables generales
	if(isset($_REQUEST['action'])){
		$refresh=$_REQUEST['action']=='refresh';
		$more=$_REQUEST['action']=='more';
	}else{
		$refresh=isset($_REQUEST['refresh']);
		$more=isset($_REQUEST['more']);
	}
	$numfriends=is_numeric($_REQUEST['friends'])?intval($_REQUEST['friends']):3;
	$fecha=($more||$refresh)?('un.date'.($refresh?'>':'<=').'"'.$res['date'].'" AND'):'';
	$res['fecha'] = $fecha;
	$sql='
		SELECT
			un.id,
			un.id_friend AS id_user,
			un.revised,
			un.id_type,
			un.id_source,
			un.date,
            t.type_source AS type
		FROM users_notifications un
		JOIN type_actions t ON un.id_type = t.id
		WHERE
			'.$fecha.'
			un.id_type IN (2,4,5,8,9,11,22,25,26) AND
			un.id_source != 0 AND
			un.id_friend !="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND un.id_friend !="0" AND un.id_friend != un.id_user AND
			(un.id_user IN (SELECT id_friend FROM users_links WHERE id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'") OR 
            (un.id_friend IN (SELECT id_friend FROM users_links WHERE id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'") AND un.id_type IN (22,27,26,25))) AND
             un.id_user !="'.$_SESSION['ws-tags']['ws-user']['id'].'"
		GROUP BY un.id_type, un.id_source
		ORDER BY un.date DESC
		LIMIT '.intval($_REQUEST['start']).', '.(is_numeric($_REQUEST['limit'])?intval($_REQUEST['limit']):8);
	if(isset($_REQUEST['debug'])) echo $sql."\n<br/><br/>\n";
	$infos = $GLOBALS['cn']->query($sql);
	if($refresh) $res['date']='';
	$ainfo=array();
	while ($info = mysql_fetch_assoc($infos)){
		 $date=$info['date'];
		if (in_array($info['id_type'],array(22,25,26,27))){
            $aux=$info['id_user'];
            $info['id_user']=$info['is_friend'];
            $info['is_friend']=$aux;
        }
        //query para buscar datos de usuario
		if($info['type']=='tag'){ //si la notificacion es de una tag, buscamos al dueño
			$search = '(SELECT id_user FROM tags WHERE id="'.$info['id_source'].'")';
		}else{ //si es otro tipo de notificacion, usamos el id_user
			$search = '"'.$info['id_user'].'"';
		}
		unset($info['id_user']);
		$sql='
			SELECT
				id,
				md5(id) AS uid,
				md5(concat(id,"_",email,"_",id)) AS code,
				concat(name," ",last_name) AS name,
				concat("img/users/",md5(concat(id,"_",email,"_",id)),"/",profile_image_url) AS photo
			FROM users
			WHERE
				id='.$search;
		if(isset($_REQUEST['debug'])) echo '<pre>'.$sql."\n</pre>";
		$usr= $GLOBALS['cn']->queryRow($sql);
		if(count($usr)>0){
            $usr['name']=utf8_encode($usr['name']);
			$usr[0]['name'] = $usr['name'];
			$usr[0]['photo'] = FILESERVER.getUserPicture($usr['code'].'/'.$usr['photo'],'img/users/default.png');
			$usr[0]['is_friend'] = isFallowing($_SESSION['ws-tags']['ws-user']['id'], $usr['id']);
		}

		//control de la agrupación de nombres
		$sql='
			SELECT
				un.id_user AS id,
				md5(un.id_user) AS uid,
				(select md5(CONCAT(id, "_", email, "_", id)) from users where id=un.id_user) AS code,
				(select concat(a.name," ",a.last_name) from users a where a.id=un.id_user) AS name,
				'.//(select concat("img/users/",md5(CONCAT(id, "_", email, "_", id)),"/",profile_image_url) from users where id=un.id_user) as photo,
                '(SELECT profile_image_url FROM users WHERE id=un.id_user) as photo,
				un.date
			FROM users_notifications un
			WHERE
				un.date <= "'.$info['date'].'" AND'./*'
				'.($refresh?
					$fecha:'DATEDIFF("'.$date.'",un.date) BETWEEN 0 AND 7 AND' //agrupar si la diferencia de dias es menor a 1 semana
				).*/'
				un.id_source = "'.$info['id_source'].'" AND
				un.id_type = "'.$info['id_type'].'" AND
				un.id_friend != un.id_user AND
				un.id_user != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
			GROUP BY un.id_user
			ORDER BY un.id DESC
		';
		if(isset($_REQUEST['debug'])&&!$notFirst){ echo $sql."\n<br/><br/>\n"; $notFirst=true; }
		$friends = $GLOBALS['cn']->query($sql);
		if(mysql_num_rows($friends)>0){
			$afriends=array();
			$info['num_friends']=mysql_num_rows($friends);
			$friend = mysql_fetch_assoc($friends);
			$info['date']=$friend['date'];
			//Fecha formateada (fdate)
			$date = explode(' ', $info['date']); //fecha,hora
			$hora = $date[1]; //hora completa
			$date = explode('-', $date[0]); //año,mes,dia
			$sent = getMonth(intval($date[1])).' '.$date[2];
			if ($date[0]==date('Y') && $date[1]==date('m') && $date[2]==date('d'))
				$sent = NOTIFICATIONS_SENTDATE2;
			if ($date[0]==date('Y') && $date[1]==date('m') && $date[2]==(date('d')-1))
				$sent = NOTIFICATIONS_SENTDATE3;
			$info['fdate']=$sent.', '.$hora;
			do{
				$friend['name']=utf8_encode($friend['name']);
				$friend['photo'] = FILESERVER.getUserPicture($friend['code'].'/'.$friend['photo'],'img/users/default.png');
				$afriends[]=$friend;
			}while(count($afriends)<$numfriends && $friend = mysql_fetch_assoc($friends));
			$info['friends']=$afriends;
		}
		if ($usr['id']!=$_SESSION['ws-tags']['ws-user']['id']){
			$info['idsource']=$info['id_source'];
    		$info['source']=md5($info['id_source']);
            $info['usr']=$usr;
			$ainfo[]=$info;
		}
        
	}//while notifications
	$res['info']=$ainfo;

	//traduccion natural
	switch($_SESSION['ws-tags']['language']){
	case 'es':
//		$res['txt']['1'] ='[_UD_] recibi{&oacute;}{{eron}} una tag privada de [_FRIENDS_]';
		$res['txt']['2'] ='[_FRIENDS_] Le{{s}} gusta la [_TAG_] de [_PEOPLE_]';
		$res['txt']['4'] ='[_FRIENDS_] coment{&oacute;}{{aron}} la [_TAG_] de [_PEOPLE_]';
		$res['txt']['5'] ='[_FRIENDS_] ahora {es}{{son}} amigo{{s}} de [_PEOPLE_]';
//		$res['txt']['6'] ='[_FRIENDS_] [_TE_] agreg{&oacute;}{{aron}} [_A_] a un grupo';
//		$res['txt']['7'] ='[_FRIENDS_] comparti{&oacute;}{{eron}} [_TAG_]';
		$res['txt']['8'] ='[_FRIENDS_] redistribuy{&oacute;}{{eron}} una [_TAG_]';
		$res['txt']['9'] ='[_FRIENDS_] patrocin{&oacute;}{{aron}} una [_TAG_]';
//		$res['txt']['10']='[_FRIENDS_] agreg{&oacute;}{{aron}} una Tag de grupo';
		$res['txt']['11']='[_FRIENDS_] ahora admira{{n}} a [_PEOPLE_]';
//		$res['txt']['12']='[_FRIENDS_] quiere{{n}} unirse al grupo [_GROUP_]';
//		$res['txt']['13']='[_FRIENDS_] aprob&oacute; tu solicitud para unirte al grupo [_GROUP_]';
//		$res['txt']['14']='[_FRIENDS_] invited you to the Group [_GROUP_]';
//		$res['txt']['15']='[_YOU_] commented a [_PRODUCT_] in the store';
//		$res['txt']['16']='La orden [_ORDER_] ha sido procesada satisfactoriamente';
//		$res['txt']['17']='La orden [_ORDER_] está pendiente por pagar';
        $res['txt']['22']='La [_TAG_] de [_PEOPLE_] ha sido la ganadora del d&iacute;a';
        $res['txt']['25']='La [_TAG_] de [_PEOPLE_] ha sido la ganadora de la semana';
        $res['txt']['26']='La [_TAG_] de [_PEOPLE_] ha sido la ganadora del mes';
		$res['txt']['replace']=array(
			'[_TAG_]'	=>'Tag',
			'[_AND_]'	=>'y',
			'[_MORE_]'	=>'personas m&aacute;s'
		);
        
	break;
	default: 
//		$res['txt']['1'] ='[_YOU_] receibed a private tag from [_FRIENDS_]';Like the Tag of
		$res['txt']['2'] ='[_FRIENDS_] Like  the [_TAG_] of [_PEOPLE_]';
		$res['txt']['4'] ='[_FRIENDS_] comented the [_TAG_] of [_PEOPLE_]';
		$res['txt']['5'] ='[_FRIENDS_] {{are}} now {a} friend{{s}} of [_PEOPLE_]';
//		$res['txt']['6'] ='[_FRIENDS_] added [_YOU_] to a group';
//		$res['txt']['7'] ='[_FRIENDS_] shared [_YOUR_] Tag';
		$res['txt']['8'] ='[_FRIENDS_] redistributed a [_TAG_]';
		$res['txt']['9'] ='[_FRIENDS_] sponsored a [_TAG_]';
		//$res['txt']['10']='[_FRIENDS_] added a group Tag';
		$res['txt']['11']='[_FRIENDS_] now admire [_PEOPLE_]';
//		$res['txt']['12']='[_FRIENDS_] want to join to the group [_GROUP_]';
//		$res['txt']['13']='[_FRIENDS_] approved [_YOUR_] request to join to the group [_GROUP_]';
//		$res['txt']['14']='[_FRIENDS_] invited you to the Group [_GROUP_]';
//		$res['txt']['15']='[_YOU_] commented a [_PRODUCT_] in the store';
//		$res['txt']['16']='The order [_ORDER_] was processed successfully';
//		$res['txt']['17']='The order [_ORDER_] is pending for payment';
        $res['txt']['22']='The [_TAG_] to [_PEOPLE_] has been the winner day';
        $res['txt']['25']='The [_TAG_] to [_PEOPLE_] has been the winner week';
        $res['txt']['26']='The [_TAG_] to [_PEOPLE_] has been the winner month';
        $res['txt']['replace']=array(
			'[_TAG_]'	=>'Tag',
			'[_AND_]'	=>'and',
			'[_MORE_]'	=>'more people'
		);
	}
    $res['txtFormat']='function txtFormat(opc){
		var i,num=opc.num||1,info=opc.txt[opc.type],rep=opc.txt["replace"],find,el;
		if(num>1)
			info=info.replace(/{{([^}]*)}}/g,"$1").replace(/{([^}]*)}/g, "" );
		else
			info=info.replace(/{{([^}]*)}}/g, "" ).replace(/{([^}]*)}/g,"$1");
		find=info.match(/\[_\S+_\]/g);
		if(find) for(i=0;i<find.length;i++){
			el=find[i].replace(/\[_(\S+)_\]/,"$1").toLowerCase();
			if(opc[el]) info=info.replace(find[i], opc[el]);
		}
		for(i in rep) info=info.replace(i,rep[i]);
		return info;
	}';
	$res['txtFormat']=str_minify($res['txtFormat']);
	die(jsonp($res));
?>