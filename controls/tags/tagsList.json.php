<?php
include '../header.json.php';
include_once RELPATH.'includes/qr/qrlib.php';
include_once RELPATH.'main/controllers/video.php';
class TAG_controller{
	function __construct(){}
}
function tagsList_json($data,$mobile=false){
	global $debug; global $config;
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	//objeto que guarda los datos json a enviar
	$res=array();
	if(isset($_REQUEST['getReportCombo'])){
		$tipos=CON::query('SELECT id,descrip FROM type_tag_report ORDER BY id');
		while($tipo=CON::fetchAssoc($tipos)){
			$res[]=$tipo['id'];
			$res[]=constant($tipo['descrip']);
		}
		return $res;
	}
	//otras variables generales
	$data['id']=intToMd5($data['id']);
	$refresh=($data['action']=='refresh');
	$uid=$data['uid']==''?$myId:CON::getVal('SELECT id FROM users WHERE md5(id)=?',array(intToMd5($data['uid'])));
	$res['date']=$data['date'];
	$res['info']='';
	$res['request_id']=$data['id'];
	$start=intval($data['start']);
	$limit=(is_numeric($data['limit'])?intval($data['limit']):5);
	$sqlUid=isset($_GET['this_is_app'])?'md5(concat(t.id_creator,"_",(SELECT tu.email FROM users tu WHERE tu.id=t.id_creator),"_",t.id_creator))':'md5(t.id_creator)';
	$sqlUid2=isset($_GET['this_is_app'])?'md5(concat(t.id_user,"_",(SELECT tu.email FROM users tu WHERE tu.id=t.id_user),"_",t.id_user))':'md5(t.id_user)';
	$select='
		t.id,
		t.source,
		t.id_creator,
		'.$sqlUid.' as uid,
		t.id_user,
		'.$sqlUid2.' as rid,
		(t.id=(SELECT DISTINCT source FROM tags WHERE id!=t.id AND (source=t.id OR source=t.source) AND id_user="'.$myId.'")) as redist,
		t.id_product,
		t.id_group,
		t.id_business_card as business,
		t.video_url		as video,
		unix_timestamp(t.date) AS udate,
		t.status,
		t.date
	';
	$join='';
	$order='t.id DESC';
	if($myId!=''){//si hay usuario logeado
		$where=' t.source NOT IN (SELECT id_tag FROM tags_report WHERE id_user_report="'.$myId.'") ';//AND status = "8") ';
		if($res['date']!='') $where.=' AND t.date'.($refresh?'>':'<=').'"'.$res['date'].'" ';
		//amigos
		$friends=CON::query('SELECT id_user FROM users_links WHERE id_user = ?',array($uid));
		//una tag especifica
		if($data['id']!=''&&$data['current']==''){//se retorna una sola tag
			$select.=',md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code ';
			$res['info']='se retorna una sola tag -1-';
			$where .= ' AND md5(t.id) = "'.$data['id'].'"
			';
		}elseif($data['current']=='hash'){//Listado de hash
			$hash=end(explode('#',$data['hash']));
			$res['info']='listado de tags del HashTash #'.$hash;
	
			$where.='
				AND CONCAT_WS( " ",t.text,t.text2,t.code_number) LIKE "%#'.$hash.'%"
				AND t.status="1"';
			// 	OR t.id IN (SELECT cms.id_source 
			// 				FROM comments cms 
			// 				WHERE cms.comment 
			// 				LIKE "%#'.$hash.'%" AND cms.id_type=4)
			// ';
		}elseif($data['current']=='myTags'){//listado de tags del usuario logeado
			$res['info']='listado de tags del usuario logeado -2-';
			$where.=safe_sql(' AND t.id_user=? AND t.id_user=t.id_creator AND t.status=1 ',array($uid));
		}elseif($data['current']=='personalTags'||$data['current']=='personal'){//tags personales del usuario logeado";
			$res['info']='tags personales del usuario logeado -3-';
			$where.=safe_sql(' AND t.id_creator=? AND t.status=9 ',array($uid));
		}elseif($data['current']=='favorites'){//tags favoritas de un usuario
			$res['info']='listado de tags favoritas de un usuario -4-';
			$where.=safe_sql(' AND t.id IN (SELECT id_source FROM likes WHERE id_user=?) AND t.status IN (1,4) ',array($uid));
		}elseif($data['current']=='privateTags'){//tags privadas de un usuario
			$res['info']='tags privadas de un usuario -5-';
			if ($_GET['typeBox']=='outbox'||$_GET['type']=='outbox'){
				$where.=safe_sql(' AND t.status=4 AND t.id_creator=?',array($uid));
			}else{
				$where.=safe_sql(' AND ? IN (SELECT id_friend FROM tags_privates WHERE id_tag=t.id) ',array($uid));
			}
		}elseif($data['current']=='group'){//tag de grupo
			$res['info']='las tag de UN grupo -6-';
			$where.= '
				AND t.status="7"
				AND md5(t.id_group)="'.$data['grupo'].'"
			';
		}elseif($data['current']=='wpanel'){//tags de wpanel
			$res['info']='tags de wpanel -7-';
			$where.=' AND t.status="10"';
		}elseif($data['current']=='toptags'||$data['current']=='top'||$data['current']=='hits'){//mejores tags/top tags
			$res['info']='lista de las mejores tags -8-';
			//$where.=' AND t.status="1"';
			switch($data['range']){
				case '1': $where.=' AND th.date=DATE(NOW())';break;
				case '2': $where.=' AND th.date BETWEEN DATE_SUB(NOW(),INTERVAL 1 WEEK) AND NOW()';break;
				case '3': $where.=' AND th.date BETWEEN DATE(DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 30 DAY),"%Y-%m-01")) AND LAST_DAY(CURDATE())';break;
				case '4': $where.=' AND YEAR(th.date)=YEAR(CURDATE())';break;
			}
			$where .= ' AND th.hits !=0 AND t.status=1 ';
			$order='top DESC';
			$join.='LEFT JOIN tags_hits th ON th.id_tag=t.id';
			$select.=',SUM(th.hits) AS hits,SUM(th.hits) AS top';
		}elseif($data['current']=='personalTags'||$data['current']=='personal'){//tag personales de un usuario
			$res['info']='tag personales de un usuario -9-';
			$where.=safe_sql(' AND t.id_creator=? AND t.status=9 ',array($uid));
		}elseif($data['current']=='tagsUser'||$data['current']=='user'){//tags de un usuario
			$res['info']='tags de un usuario (tagsUser) -10-';
			$where.=safe_sql(' AND t.id_user=? AND t.status=1 ',array($uid));
		}elseif(CON::numRows($friends)>0){//TIMELINE: si el usuario tiene amigos
			$res['info']='timeline, y el usuario tiene amigos -15-';
			$join.=' LEFT JOIN users_links l ON t.id_user=l.id_friend ';
			$where.=safe_sql('
				AND DATEDIFF(NOW(),t.date)<15
				AND ? IN (t.id_user,l.id_user)
				AND t.status=1
			',array($uid));
		}else{//TIMELINE: si la persona es nueva en el sistema o no tiene amigos
			$res['info']='timeline, y la persona es nueva en el sistema o no tiene amigos -16-';
			//verificamos que el usuario tenga tags creadas
			$haveTags=CON::query('SELECT id_user,id_creator FROM tags WHERE ? IN (id_user,id_creator) AND status=1',array($uid));
			//condiciones del query
			if(CON::numRows($haveTags)==0){////// esto no aplica, el relleno se hace con tags patrocinadas
				$where.='
					AND t.id IN (SELECT id_tag FROM users_publicity WHERE status=1 AND id_tag!=0)
					AND t.status=1
				';
				$order='date DESC,rand()';

				$_SESSION['ws-tags']['is_sponsor']=1;
			}else{
				$where.=safe_sql(' AND t.status=1 AND ? IN (t.id_user,t.id_creator) ',array($uid));
			}
		//listado de tag del usuario de session (logeado)
		}
	}else{
		$where='t.id IS NOT NULL ';
		if($res['date']!='') $where.=' AND t.date'.($refresh?'>':'<=').'"'.$res['date'].'" ';
		if($data['id']!='' && $data['current']==''){//una tag especifica
			$res['info']='se retorna una sola tag -21-';
			$where.=' AND md5(t.id)="'.$data['id'].'"';
		}elseif($data['current']=='wpanel'){//tags de wpanel
			$res['info']='tags de wpanel -22-';
			$where.=' AND t.status="10"';
		}elseif($data['current']=='toptags'||$data['current']=='top'||$data['current']=='hits'){//mejores tags/top tags
			$res['info']='lista de las mejores tags -23-';
			//$where.=' AND t.status="1"';
			switch ($data['range']){
				case '1': $where.=' AND DATE(t.date)=DATE(NOW())';break;
				case '2': $where.=' AND t.date BETWEEN DATE_SUB(NOW(),INTERVAL 1 WEEK) AND NOW()';break;
				case '3': $where.=' AND t.date BETWEEN DATE(DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 30 DAY),"%Y-%m-01")) AND LAST_DAY(CURDATE())';break;
				case '4': $where.=' AND YEAR(t.date)=YEAR(CURDATE())';break;
			}
			$where.=' AND t.hits>0 AND t.status=1 ';
			$order='t.hits DESC';
		}elseif($data['current']=='personalTags'||$data['current']=='personal'){//tags personales de un usuario
			$res['info']='tag personales de un usuario -24-';
			$where.=safe_sql(' AND t.id_creator=? AND t.status=9 ',array($uid));
		}elseif($data['current']=='myTags'){//listado de tags del usuario deslogeado
			$res['info']='listado de tags del usuario logeado -2-';
			$where.=safe_sql(' AND t.id_user=? AND t.id_user=t.id_creator AND t.status=1 ',array($uid));
		}elseif($data['current']=='tagsUser'||$data['current']=='user'){//tags de un usuario
			$res['info']='tags de un usuario (tagsUser) -25-';
			$where.=safe_sql(' AND t.id_user=? AND t.status=1 ',array($uid));
		}else{//tags aleatorias
			$res['info']='tags aleatorias -26-';
			$where.=' AND t.status=1 ';
			$order='t.date DESC, rand()';
		}//else
	}//else si no esta logueado
//	if($debug) echo $res['info'];

	// +--------------------------------+
	// |                                |
	// | Seleccion de tags patrocinadas |
	// |                                |
	// +--------------------------------+
	//Se muestran patrocinantes solo en el time line
	if($data['current']=='timeLine'||($data['current']==''&&$data['id']=='')){
		$denominador=3;//por cada 3 tags, se agrega un sponsor
		$datasponsor=array("select"=>$select,"startsp"=>intval($data['startsp']),"numeroSponsor"=>ceil($limit/$denominador));
		$registrosfaltantes=0;
		$_sponsors=sponsor_json($data,$datasponsor);
		$res['sponsors']=$_sponsors;
	}
	$sql='
		SELECT DISTINCT '.$select.'
		FROM tags t '.$join.'
		WHERE '.$where.'
		GROUP BY t.id
		ORDER BY '.$order.'
		'.($data['nolimit']?'':'LIMIT '.$start.', '.$limit); //numero de registros a mostrar por consulta
	//Query - TimeLine
	$res['query'][]=str_minify($sql);
	$res['tags']=array();
	$timeLines=CON::query($sql);
	if(is_debug('taglist')) echo CON::lastSql();
	if(CON::numRows($timeLines)>0){
		//Limite de tags a mostrar
		$i=0;//contador de sponsors
		$n=$start;//contador de tags
		$PNG_WEB_DIR='img/temp/';
		if($data['action']=='reload'||$data['date']==''){//se guarda la fecha de la primera consulta
			$date=CON::getRow('SELECT NOW() as date');
			$res['date']=$date['date'];
		}
		while($tag=CON::fetchAssoc($timeLines)){
			//$tag['tag']=createTag($tag['id'],$data['force']);
			$tag['redist']=!!$tag['redist'];
			$tag['img']=tagURL($tag['id']);
			$tag['imgmini']=tagURL($tag['id'],true);
			$tag['uname']=ucwords($tag['uname']);
			if($tag['business']==0) unset($tag['business']);
			else $tag['business']=md5($tag['business']);
			$tag['likeIt']=likes($tag['id'],$myId);
			if($tag['uid']==$tag['rid'])
				unset($tag['rid']);
			else{
				$tag['rname']=$tag['uname'];
				$tag['name_redist']=$tag['uname'];//soporte para version vieja
				unset($tag['uname']);
			}
			if($data['popup']) $tag['popup']=true;
			// if($tag['sponsor']==null || ($tag['id_creator']!=$myId && $tag['id_user']!=$myId)) unset($tag['sponsor']);
			if($tag['id_product']!='0'){
				/*	sp.name as name_product,
				md5(sp.id) as store_p_id,
				store_products sp ON sp.id=t.id_product*/	
				$name=CON::getVal("SELECT name as name_product FROM store_products WHERE id=?",array($tag['id_product']));	
				$tag['name_product']=strtolower($name);
				$tag['name_product']=formatoCadena($tag['name_product']);
				$product=array(
					'id'	=> md5($tag['id_product']),
					'name'	=> $tag['name_product'],
					'url'	=> DOMINIO.'detailprod?prd='.md5($tag['id_product']),
					'app'	=> DOMINIO.'app/detailsProduct.php?id='.md5($tag['id_product'])
				);
				$product['qr']=$PNG_WEB_DIR.md5($product['url'].'|L|2').'.png';
				QRcode::png($product['app'],RELPATH.$product['qr'],'L',2,2);
				$tag['product']=$product;
			}
			$tag['num_likes']=numRecord('likes','WHERE id_source="'.$tag['id'].'"');
			$tag['num_disLikes']=numRecord('dislikes','WHERE id_source="'.$tag['id'].'"');

			//hastatash Tag
			$textTop=get_hashtags($tag['text'].' '.$tag['text2'].' '.$tag['code_number']);
			$result=count($textTop);
            if ($result>0){
                $textTop=explode(' ',implode(' ',$textTop));
                $tag['hashTag']=$textTop;
            }
			$tag['hashExCurrent']=$exCurrenHash;
			$tag['video']=trim($tag['video']);
			$headers=apache_request_headers();
			$validaVideo=new Video();
			if ($tag['video']!='') $_GET['thisvideo']=$tag['video'];
			else unset($_GET['thisvideo']);
			$validaVideo=$validaVideo->validate(0,0,1,(isset($_GET['this_is_app'])?true:false),$config,$data['embed']?true:false);
			if ($validaVideo['success']){
				$tag['typeVideo']=$validaVideo['type'];
				$tag['video']=$validaVideo['urlV'];
			}else $tag['video']=''; 
			$btn=buttons($tag,$myId);
			if($data['current']=='privateTags'){ $btn['trash']=true; }
			if(count($btn)>0){
				if($data['id']!=''){ unset($btn['comment']); }
				$tag['btn']=$btn;
			}
			if(!$debug) unset($tag['id_user'],$tag['id_creator'],$tag['id_product'],$tag['test']);
			$res['tags'][]=$tag; //almacenamos el array resultante en el vector

			//si ya se han mostrado 4 tags normales, agregamos una tag patrosinada (si quedan)
			if(++$n%3==0 && count($_sponsors)>$i && $n!=0) $res['tags'][]=$_sponsors[$i++];
		}
	}
	return $res;
}
function sponsor_json($data,$datasponsor,$_prefe=true,$noid=''){
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	$select=$datasponsor["select"]; $order="";
	if ($noid!='')
		if (isset($data['sp']) && $data['sp']!='') $data['sp'].=','.$noid;
		else $data['sp']=$noid;
	if (isset($data['sp']) && $data['sp']!='') $noId="AND t.id NOT IN (".$data['sp'].")";
	else $noId="";
	// $id_sponsors no recuerdo para que es eso
	// '.(count($id_sponsors)>0?'AND t.id NOT IN ('.implode(',',$id_sponsors).')':'').'
	$limit=$data['nolimit']?"":"LIMIT ".$datasponsor['startsp'].",".$datasponsor['numeroSponsor'];
	if ($_prefe){
		$prefe=users_preferences($usr);
		if (count($prefe)==0) $_prefe=false;
		else{
			$like=' AND (';$or='';
			foreach ($prefe as $typePre)
				foreach ($typePre as $row) {
					$like.=$or.safe_sql('t.text LIKE "%??%" OR t.text2 LIKE "%??%" OR t.code_number LIKE "%??%"',array($row->text,$row->text,$row->text));
					if (!$or) $or=' OR ';
				}
			$like.=')';
		}
	}
	if (!$_prefe){
		$like=""; $order='ORDER BY rand('.time().' * '.time().')';
	}
	$query=CON::query(" SELECT DISTINCT
				up.link as enlace,
				md5(up.id) as id_publicidad,
				$select
			FROM tags t
			LEFT JOIN users_publicity up ON up.id_tag = t.id
			WHERE up.status = '1'
			AND up.click_max >= up.click_current
			AND up.id_type_publicity = '4' $likes $noId
		GROUP BY t.id $order $limit");
	$info=array();$coma='';
	while ($row=CON::fetchAssoc($query)) {
		$row['uname']=ucwords($row['uname']);
		$row['img']=tagURL($row['id']);
		$row['imgmini']=tagURL($row['id'],true);
		if($row['business']==0) unset($row['business']);
		else $row['business']=md5($row['business']);
		$row['likeIt']=likes($row['id'],$myId);
		if($row['uid']==$row['rid']) unset($row['rid']);
		else{
			$row['rname']=$row['uname'];
			$row['name_redist']=$row['uname'];//soporte para version vieja
			unset($row['uname']);
		}
		if($row['id_product']!='0'){
			$name=CON::getVal("SELECT name as name_product FROM store_products WHERE id=?",array($row['id_product']));	
			$row['name_product']=strtolower($name);
			$row['name_product']=formatoCadena($row['name_product']);
			$product=array(
				'id'	=> md5($row['id_product']),
				'name'	=> $row['name_product'],
				'url'	=> DOMINIO.'detailprod?prd='.md5($row['id_product']),
				'app'	=> DOMINIO.'app/detailsProduct.php?id='.md5($row['id_product'])
			);
			$product['qr']=$PNG_WEB_DIR.md5($product['url'].'|L|2').'.png';
			QRcode::png($product['app'],RELPATH.$product['qr'],'L',2,2);
			$row['product']=$product;
		}
		unset($row['id_product']);
		$row['num_likes']=numRecord('likes', 'WHERE id_source="'.$row['id'].'"');
		$row['num_disLikes']=numRecord('dislikes', 'WHERE id_source="'.$row['id'].'"');
		if ($tag['video']!='') $_GET['thisvideo']=$row['video'];
		else unset($_GET['thisvideo']);
		$validaVideo=new Video();
		$validaVideo=$validaVideo->validate(0,0,1,(isset($_GET['this_is_app'])?true:false),$config);
		if ($validaVideo['success']){
			$row['typeVideo']=$validaVideo['type'];
			$row['video']=$validaVideo['urlV'];
		}else $row['video']='';
		$btn=buttons($row,$myId);
		if(count($btn)>0) $row['btn']=$btn;
		$noid.=$coma.$row['id']; $coma=',';
		$info[]=$row;
	}
	if ($_prefe && ($datasponsor['numeroSponsor'] && $datasponsor['numeroSponsor']<CON::numRows($query)))
		$info=array_merge($info,sponsor_json($data,$datasponsor,false,$noid));
	return $info;
}
function likes($tag,$user){
	return $user==''?0:
	(existe('likes','id_source','WHERE id_source='.$tag.' AND id_user='.$user)?1:
	(existe('dislikes','id_source','WHERE id_source="'.$tag.'" AND id_user="'.$user.'"')?-1:
	0));
}
function buttons($tag,$id=''){
	$btn=array();//arreglo de botones que se pueden mostrar
	if($id!=''){
		if(!$tag['redist']&&$tag['status']==1&&$tag['id_user']!=$id) $btn['redist']=true;
		if($tag['status']==1||$tag['status']==9) $btn['share']=true;
		if($tag['id_creator']==$id&&$tag['status']!=4) $btn['edit']=true;
		if($tag['id_user']==$id xor $tag['status']==4) $btn['trash']=true;
		if($tag['status']!=4&&$tag['status']!=7) $btn['sponsor']=true;//ni privada ni de grupo
		if($tag['id_user']!=$id) $btn['report']=true;
	}
	return $btn;
}
if(!$notAjax){
	$data=array();
	$data['id']=$_REQUEST['id'];
	$data['grupo']=$_REQUEST['grupo'];
	$data['force']=isset($_REQUEST['force']);
	$data['uid']=$_REQUEST['uid'];
	$data['range']=$_REQUEST['range'];
	$data['sp']=$_REQUEST['sp'];
	$data['idsponsor']=$_REQUEST['idsponsor'];
	$data['mobile']=isset($_REQUEST['mobile']);
	$data['popup']=isset($_REQUEST['popup']);
	//necesarios
	$data['action']=$_REQUEST['action'];
	$data['current']=$_REQUEST['current'];
	$data['hash']=$_REQUEST['hash'];
	$data['start']=$_REQUEST['start'];
	$data['startsp']=$_REQUEST['startsp'];
	$data['date']=$_REQUEST['date'];
	$data['limit']=$_REQUEST['limit'];
	$data['embed']=isset($_REQUEST['embed']);
	$data['nolimit']=isset($_REQUEST['nolimit']);
	$res=tagsList_json($data,isset($_REQUEST['mobile']));
	if(!$debug) unset($res['info'],$res['query'],$res['request_id']);
	die(jsonp($res));
}
?>
