<?php
include('../header.json.php');
global $debug;

//JSON results
//-1 = error extension invalida
// 0 = error general
// 1 = exito

//$_FILES['document'.($i+1)]['name'];

//_imprimir($_FILES['document']);
$json=array('result'=>0);
for($i=0;$i<count($_FILES['document']);$i++){
	if($_FILES['document']['name'][$i]!=''){
		if($_FILES['document']['error'][$i]<=0){
			//extension
			//$filesAllowed=array('pdf','doc','docx','jpg','jpeg','png','tiff','odt');
			$filesAllowed=array('jpg','jpeg','png','bmp');
			$parts=explode('.',$_FILES['document']['name'][$i]);
			$ext=strtolower(end($parts));
			//validacion del formato de la imagen
			if(in_array($ext,$filesAllowed)){
				$path=RELPATH.'img/documents/'.$_SESSION['business_payment']['ws-user']['code'].'/';
				$doc='document_'.$i.'.jpg';
				//si la imagen pesa menos de 2,5mb
				if($_FILES['document']['size'][$i]<2500000){
					//existencia de la folder
					if(!is_dir($path)){
						$old=umask(0);
						mkdir($path,0777);
						umask($old);
						$fp=fopen($path.'index.html','w');
						fclose($fp);
					}//is_dir

					if(redimensionar($_FILES['document']['tmp_name'][$i], $path.$doc, 650)){
						//uploadFTP($doc,'documents','../../');
						uploadFTP($doc,'documents',RELPATH,1,$_SESSION['business_payment']['ws-user']['code']);
						$json['result']=1;
					}
				}
			}else{//if imagesAllowed
				$json['result']=-1;
			}
		}
	}
}
if($json['result']==1){
	//Actualiza status de usuario
	CON::update('users','type=2,status=5','id=?',array($_SESSION['business_payment']['ws-user']['id']));
	if($debug) $json['_sql_'][]=CON::lastSql();
	//Verificamos si ya tiene una cuenta nonprofit para no duplicarla en caso de que se acabe el plazo
	$idPlan=CON::getVal('SELECT id FROM users_plan_purchase WHERE id_user=? AND id_plan=0 LIMIT 1',array($_SESSION['business_payment']['ws-user']['id']));
	if($debug) $json['_sql_'][]=CON::lastSql();
	if($idPlan!=''){
		CON::update('users_plan_purchase','init_date=NOW()',"id=$idPlan");
		if($debug) $json['_sql_'][]=CON::lastSql();
	}else{
		CON::insert('users_plan_purchase','id_user=?,id_plan=0,init_date=NOW(),end_date=DATE_ADD(NOW(),INTERVAL 15 DAY)',
			array($_SESSION['business_payment']['ws-user']['id']));
		if($debug) $json['_sql_'][]=CON::lastSql();
	}
	$sesion=CON::getRow('SELECT *,CONCAT(name," ",last_name) AS full_name,MD5(CONCAT(id,"_",email,"_",id)) AS code FROM users WHERE id=? LIMIT 1',array($_SESSION['business_payment']['ws-user']['id']));
	if($debug) $json['_sql_'][]=CON::lastSql();

	//Liberamos session auxiliar
	unset($_SESSION['business_payment'],$_SESSION['ws-tags']);

	//Crea session para login automatico
	createSession($sesion);
}
die(jsonp($json));
?>