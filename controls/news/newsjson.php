<?php 
	include '../header.json.php';
	$res=array();
	if (!isset($_GET['date'])){
		$usdiffDate='DATEDIFF(NOW(),us.last_update)<=4';
		$undiffDate='DATEDIFF(NOW(),un.date)<=4';
	}else{
		$usdiffDate=safe_sql('us.last_update>=?',array($_GET['date']));
		$undiffDate=safe_sql('un.date>=?',array($_GET['date']));
		// $undiffDate='un.date>='.$_GET['date'];
	}
	$limit=(isset($_GET['limit']) && $_GET['limit']>0)?$_GET['limit']:false;
	// $limit=(isset($_GET['limit']) && $_GET['limit']>0)?'LIMIT 0,'.$_GET['limit']:'';
	$miId=$_SESSION['ws-tags']['ws-user']['id'];
	$query=CON::query("	SELECT us.id,NOW()
	 					FROM users us
	 					INNER JOIN users_links ul ON ul.id_friend= us.id
	 					WHERE ul.id_user=? AND $usdiffDate;",array($miId));
	// $res['sql-amigos']=CON::lastSql();
	if (CON::numRows($query)){
		$idIn='';$ainfo=array();
		while($row=CON::fetchAssoc($query)){
			$idIn.=($idIn!=''?',':'').$row['id'];
			$res['fecha']=$row['NOW()'];
		} 
		$new=CON::query("SELECT un.id_friend,
								un.id_user,
								un.id_type,
								un.id_source,
								un.date,
					            t.type_source AS type,
					            (SELECT CONCAT(u.name,' ',u.last_name) FROM users u WHERE u.id=un.id_user) AS nameUser,
					            (SELECT CONCAT(u.name,' ',u.last_name) FROM users u WHERE u.id=un.id_friend) AS nameFriend,
					            (SELECT md5(CONCAT(u.id,'_',u.email,'_',u.id))  FROM users u WHERE u.id=un.id_user) AS keyUser,
					            (SELECT md5(CONCAT(u.id,'_',u.email,'_',u.id))  FROM users u WHERE u.id=un.id_friend) AS keyFriend,
					            (SELECT u.profile_image_url FROM users u WHERE u.id=un.id_user) AS photoUser,
					            (SELECT u.profile_image_url FROM users u WHERE u.id=un.id_friend) AS photoFriend
							FROM users_notifications un
							INNER JOIN type_actions t ON un.id_type = t.id
							WHERE un.id_user!=? AND un.id_friend!=? AND un.id_friend!=0 AND un.id_friend!=un.id_user 
							AND un.id_type IN (2,4,5,8,9,11,22,25,26) 
							AND (un.id_friend IN ($idIn) OR un.id_user IN ($idIn)) AND $undiffDate
							ORDER BY un.date DESC", array($miId,$miId));
		$res['sql-noti']=CON::lastSql();
		$burro=array();
		while($row=CON::fetchAssoc($new)){
			$burro[]=$row;
			if (isset($infoa[$row['id_source'].'-'.$row['id_type']])){
				$band=false;
				$num=count($infoa[$row['id_source'].'-'.$row['id_type']]['usrs']);
				for ($i=0;$i<$num; $i++){
					if ($infoa[$row['id_source'].'-'.$row['id_type']]['usrs'][$i]['name']===utf8_encode($row['nameUser']))
						$band=true;
				}
				if (!$band){
					$infoa[$row['id_source'].'-'.$row['id_type']]['usrs'][$num]['name'] = utf8_encode($row['nameUser']);
					$infoa[$row['id_source'].'-'.$row['id_type']]['usrs'][$num]['uid'] = md5($row['id_user']);
					$infoa[$row['id_source'].'-'.$row['id_type']]['usrs'][$num]['photo'] = FILESERVER.getUserPicture('img/users/'.$row['keyUser'].'/'.$row['photoUser'],'img/users/default.png');
				}
			}else{
				//Fecha formateada (fdate)
				$date = explode(' ', $row['date']); //fecha,hora
				$hora = $date[1]; //hora completa
				$date = explode('-', $date[0]); //año,mes,dia
				$sent = getMonth(intval($date[1])).' '.$date[2];
				if ($date[0]==date('Y') && $date[1]==date('m') && $date[2]==date('d'))
					$sent = NOTIFICATIONS_SENTDATE2;
				if ($date[0]==date('Y') && $date[1]==date('m') && $date[2]==(date('d')-1))
					$sent = NOTIFICATIONS_SENTDATE3;
				$row['fdate']=$sent.', '.$hora;
				$usr[0]['name'] = utf8_encode($row['nameUser']);
				$usr[0]['uid'] = md5($row['id_user']);
				$usr[0]['photo'] = FILESERVER.getUserPicture('img/users/'.$row['keyUser'].'/'.$row['photoUser'],'img/users/default.png');
				$friend['name']=utf8_encode($row['nameFriend']);
				$friend['uid']=md5($row['id_friend']);
				$friend['photo'] = FILESERVER.getUserPicture($row['keyFriend'].'/'.$row['photoFriend'],'img/users/default.png');
				$afriends[0]=$friend;
				$row['usrs']=$usr;
				$row['friend']=$afriends;
				$row['idsource']=$row['id_source'];
	    		$row['source']=md5($row['id_source']);
				$infoa[$row['idsource'].'-'.$row['id_type']]=$row;
			}
			unset($row['date']); unset($row['KeyUser']); unset($row['keyFriend']);
			unset($row['nameUser']); unset($row['nameFriend']); unset($row['photoUser']);
			unset($row['photoFriend']); unset($row['nameFriend']);
			if ($limit && count($infoa)>=$limit) break;
		}
		if (count($infoa)>0) foreach ($infoa as $key){ $info[]=$key; } 
	}else{ $info=array(); }
	$res['info']=$info;
	// echo '<pre>';
	// print_r($infoa);
	// echo '</pre>';

//*******************************************************************************************************
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
        $res['txt']['22']='La [_TAG_] de [_FRIENDS_] ha sido la ganadora del d&iacute;a';
        $res['txt']['25']='La [_TAG_] de [_FRIENDS_] ha sido la ganadora de la semana';
        $res['txt']['26']='La [_TAG_] de [_FRIENDS_] ha sido la ganadora del mes';
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
        $res['txt']['22']='The [_TAG_] to [_FRIENDS_] has been the winner day';
        $res['txt']['25']='The [_TAG_] to [_FRIENDS_] has been the winner week';
        $res['txt']['26']='The [_TAG_] to [_FRIENDS_] has been the winner month';
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