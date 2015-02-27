<?php
include '../header.json.php';
	global $debug;
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	if(isset($_REQUEST['refresh']))	$action='refresh';
	if(isset($_REQUEST['more']))	$action='more';
	if(isset($_REQUEST['action']))	$action=$_REQUEST['action'];
	$res=array();
	#filtros de source
	$types='1';
	if(is_array($_POST['types'])){
		$types='type_source IN ("'.implode('","',CON::cleanStrings($_POST['types'])).'")';
	}elseif(is_array($_POST['notypes'])){
		$types='type_source NOT IN ("'.implode('","',CON::cleanStrings($_POST['notypes'])).'")';
	}
	if($types!='1'){
		$atypes=array();
		$query=CON::query("SELECT id FROM type_actions WHERE $types");
		while($val=CON::fetchAssoc($query)) $atypes[]=$val['id'];
		$types='id_type IN ('.implode(',',$atypes).')';
	}
	unset($query,$atypes);
	//marcado de notificaciones
	if(isset($_REQUEST['checked'])){//si reviso las notificaciones generales
		$res['checked']=!!CON::update('users_notifications','revised=1',"revised=0 AND $types AND id_friend=?",array($myId));
		if($debug) $res['_sql_'][]=CON::lastSql();
	}elseif($_REQUEST['check']!=''){//si reviso una notificacion especifica
		$res['check']=!!CON::update('users_notifications','revised=2','revised<2 AND id_type=? AND id_friend=? AND md5(id_source)=?',
			array($_REQUEST['type'],$myId,$_REQUEST['check']));
		if($debug) $res['_sql_'][]=CON::lastSql();
	}
	#si no se indica accion, terminamos (solo se quiere chequear)
	if(!isset($action)) die(jsonp($done));
	//fecha
	$res['date']=isset($_REQUEST['date'])?CON::cleanStrings($_REQUEST['date']):CON::getVal('SELECT now()');
	#consultamos las push notificacions (cantidad de notificaciones nuevas)
	$res['push']=CON::count('users_notifications',"
		revised=0 AND $types AND id_friend=?
		GROUP BY id_type,id_source,DATE(date)
	",array($myId));
	if($debug) $res['_sql_'][]=CON::lastSql();
	#si queremos las push, terminamos
	if($action=='push') die(jsonp(array('push'=>$res['push'])));

	$limit=intval($_REQUEST['start']).','.(is_numeric($_REQUEST['limit'])?intval($_REQUEST['limit']):8);
	$numfriends=is_numeric($_REQUEST['friends'])?intval($_REQUEST['friends']):3;
	$dif=($action=='refresh')?'>':'<=';
	if($types!='1') $types="un.$types";
	$qinfo=CON::query("
		SELECT
			un.id
		,	un.date
		,	un.revised
		,	un.id_type
		,	(SELECT type_source FROM type_actions WHERE id=un.id_type) AS type
		,	un.id_source
		,	un.date
		,	un.revised
		,	DATE(un.date) AS fecha
		FROM users_notifications un
		JOIN users u ON u.id=un.id_user
		WHERE un.id_source!=0 AND un.id_user!=0 AND un.id_friend!=un.id_user
			AND $types
			AND un.id_friend=?
			AND un.date $dif ?
		GROUP BY un.id_type,un.id_source,DATE(un.date),un.revised
		ORDER BY un.id DESC
		LIMIT $limit
	",array(
		$myId,
		$res['date']
	));
	if($debug) $res['_sql_'][]=CON::lastSql();
	//if($action=='refresh') $res['date']='';
	$ainfo=array();
	while($info=CON::fetchAssoc($qinfo)){
		if($res['date']=='' && $action!='refresh') $res['date']=$info['date'];
		$info['icon']=$info['type'].$info['id_type'];

		if($info['type']=='tag'){
			if(!CON::exist('tags','id='.$info['id_source'])) continue;
		}elseif($info['type']=='group'){
			if($info['id_type']==10)
				$gid=CON::getVal('SELECT id_group FROM tags WHERE id=? AND status=7',array($info['id_source']));
			else
				$gid=$info['id_source'];
			$group=CON::getRow('
				SELECT
					id,
					name,
					md5(id) as Mid,
					(SELECT status FROM users_groups WHERE id_group=id AND id_user=?) AS ug_status
				FROM groups
				WHERE id=?
			',array($myId,$gid));
			if(count($group)>0){
				$group['name']=ucwords($group['name']);
				$info['group']=$group;
			}else{
				continue;
			}
		}elseif($info['type']=='order'){
			$info['order']=generaCodeId($info['id_source'],11);
		}elseif($info['type']=='raffle'){
			$sql = "SELECT MD5(id_product) as product, winner FROM store_raffle WHERE id='".$info['id_source']."' LIMIT 1";
			$raffle=CON::getRow($sql);
			$info['raffle']=$raffle;
		}

		if ($_GET['web']){
			$date=safe_sql('DATE(un.date) = ?',array($info['fecha']));
		}else{
			$date=safe_sql('un.date <= ?',array($info['date']));
		}

		#agrupacion de nombres
		$friends=CON::query('
			SELECT
				un.id_user AS id,
				md5(un.id_user) AS uid,
				md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code,
				concat(u.name," ",u.last_name) AS name,
				concat("img/users/",md5(CONCAT(u.id,"_",u.email,"_",u.id)),"/",u.profile_image_url) AS photo,
				un.date
			FROM users_notifications un
			JOIN users u ON u.id=un.id_user
			WHERE un.id_friend!=un.id_user AND '.$date.'
				AND un.id_user!=? AND un.id_source=? AND un.id_type=?
			GROUP BY un.id_user
			ORDER BY un.id DESC
		',array($myId,$info['id_source'],$info['id_type']));
		if($debug&&!$notFirst) $res['_sql_'][]=CON::lastSql();
		$info['num_friends']=CON::numRows($friends);
		if($info['num_friends']>0){
			$afriends=array();
			$friend=CON::fetchAssoc($friends);
			$info['date']=$friend['date'];
			//Fecha formateada (fdate)
			$date=explode(' ', $info['date']); //fecha,hora
			$hora=$date[1]; //hora completa
			$date=explode('-', $date[0]); //año,mes,dia
			$sent=getMonth(intval($date[1])).' '.$date[2];
			if($date[0]==date('Y')&&$date[1]==date('m')&&$date[2]==date('d'))
				$sent=NOTIFICATIONS_SENTDATE2;
			if($date[0]==date('Y')&&$date[1]==date('m')&&$date[2]==(date('d')-1))
				$sent=NOTIFICATIONS_SENTDATE3;
			$info['fdate']=$sent.', '.$hora;
			do{
				$friend['name']=ucwords($friend['name']);
				//$friend['pic']=FILESERVER.preg_replace('/(\.\S+)$/','_thumb$1',$friend['photo']);
				$friend['photo']=getUserPicture($friend['photo']);
				if($friend['photo']=='') unset($friend['photo']);
				$afriends[]=$friend;
			}while(count($afriends)<$numfriends && $friend=CON::fetchAssoc($friends));
			$info['friends']=$afriends;
		}
		$info['idsource']=$info['id_source'];
		$info['source']=md5($info['id_source']);
		unset($info['id_source']);
		$ainfo[]=$info;
	}//while notifications
	$res['info']=$ainfo;

	//traducciones con formato inteligente.
	//por la conplejidad de la estructura no se almacena en base de datos.
	switch($_SESSION['ws-tags']['language']){
	case 'es':
		$res['txt']['1'] ='Ud. recibi&oacute; una [_TAG_] privada de [_PEOPLE_]';
		$res['txt']['2'] ='a [_PEOPLE_] le{{s}} gusta tu [_TAG_]';
		$res['txt']['4'] ='[_PEOPLE_] coment{&oacute;}{{aron}} tu [_TAG_]';
		$res['txt']['5'] ='[_PEOPLE_] te agreg{&oacute;}{{aron}} como amigo';
		$res['txt']['6'] ='[_PEOPLE_] te agreg{&oacute;}{{aron}} al grupo [_GROUP_]';
		$res['txt']['7'] ='[_PEOPLE_] comparti{&oacute;}{{eron}} tu [_TAG_]';
		$res['txt']['8'] ='[_PEOPLE_] redistribuy{&oacute;}{{eron}} tu [_TAG_]';
		$res['txt']['9'] ='[_PEOPLE_] patrocin{&oacute;}{{aron}} una [_TAG_]';
		$res['txt']['10']='[_PEOPLE_] agreg{&oacute;}{{aron}} una [_TAG_] de grupo';
		$res['txt']['11']='[_PEOPLE_] te sigue{{n}}';
		$res['txt']['12']='[_PEOPLE_] quiere{{n}} unirse al grupo [_GROUP_]';
		$res['txt']['13']='[_PEOPLE_] aprob&oacute; tu solicitud para unirte al grupo [_GROUP_]';
		$res['txt']['14']='[_PEOPLE_] te invit&oacute; al grupo [_GROUP_]';
		$res['txt']['15']='[_PEOPLE_] coment{&oacute;}{{aron}} un [_PROD_] en el store';
		$res['txt']['16']='La orden [_ORDER_] fue procesada satisfactoriamente';
		$res['txt']['17']='La orden [_ORDER_] est&aacute; pendiente por pagar';
		$res['txt']['18']='[_PEOPLE_] es el ganador de [_RAFFLE_]';
		$res['txt']['19']='Usted fue el ganador de [_RAFFLE_]';
        $res['txt']['22']='Felicitaciones, su [_TAG_] ha sido la ganadora del d&iacute;a';
        $res['txt']['25']='Felicitaciones, su [_TAG_] ha sido la ganadora de la semana';
        $res['txt']['26']='Felicitaciones, su [_TAG_] ha sido la ganadora del mes';
        $res['txt']['27']='Felicitaciones, su [_TAG_] ha sido la ganadora del a&ntilde;o';
        $res['txt']['28']='[_PEOPLE_] ha{{n}} escrito en una [_TAG_] donde has comentado';
        $res['txt']['29']='[_PEOPLE_] ha{{n}} escrito en un [_PROD_] donde has comentado';
		$res['txt']['replace']=array(
			'[_TAG_]'	=>'Tag',
			'[_AND_]'	=>'y',
			'[_MORE_]'	=>'personas m&aacute;s',
			'[_PROD_]'	=>'producto',
			'[_RAFFLE_]'=>'esta rifa'
		);
	break;
	default:
		$res['txt']['1'] ='You receibed a private [_TAG_] from [_PEOPLE_]';
		$res['txt']['2'] ='[_PEOPLE_] like your [_TAG_]';
		$res['txt']['4'] ='[_PEOPLE_] comented your [_TAG_]';
		$res['txt']['5'] ='[_PEOPLE_] added you as friend';
		$res['txt']['6'] ='[_PEOPLE_] added you to the group [_GROUP_]';
		$res['txt']['7'] ='[_PEOPLE_] shared your [_TAG_]';
		$res['txt']['8'] ='[_PEOPLE_] redistributed your [_TAG_]';
		$res['txt']['9'] ='[_PEOPLE_] patrocinate your [_TAG_]';
		$res['txt']['10']='[_PEOPLE_] added a group [_TAG_]';
		$res['txt']['11']='[_PEOPLE_] follow you';
		$res['txt']['12']='[_PEOPLE_] want to join to the group [_GROUP_]';
		$res['txt']['13']='[_PEOPLE_] approved your request to join to the group [_GROUP_]';
		$res['txt']['14']='[_PEOPLE_] invited you to the Group [_GROUP_]';
		$res['txt']['15']='[_PEOPLE_] commented that [_PROD_] in the store';
		$res['txt']['16']='The order [_ORDER_] was processed successfully';
		$res['txt']['17']='The order [_ORDER_] is pending for payment';
		$res['txt']['18']='[_PEOPLE_] is the winner of [_RAFFLE_]';
		$res['txt']['19']='You are the winner of [_RAFFLE_]';
        $res['txt']['22']='Congratulations, your [_TAG_] is the winner of the day';
        $res['txt']['25']='Congratulations, your [_TAG_] is the winner of the week';
        $res['txt']['26']='Congratulations, your [_TAG_] is the winner of the month';
        $res['txt']['27']='Congratulations, your [_TAG_] is the winner of the year';
        $res['txt']['28']='[_PEOPLE_] wrote in a [_TAG_] you comented';
        $res['txt']['29']='[_PEOPLE_] wrote in a [_PROD_] you comented';
		$res['txt']['replace']=array(
			'[_TAG_]'	=>'Tag',
			'[_AND_]'	=>'and',
			'[_MORE_]'	=>'more people',
			'[_PROD_]'	=>'product',
			'[_RAFFLE_]'=>'this raffle'
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
