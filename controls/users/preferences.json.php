<?php
include '../header.json.php';

if (quitar_inyect()){
	$arrayPrefe=array();
	$users=$GLOBALS['cn']->query("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id)) = '".$_GET['code']."'");
	$user=mysql_fetch_assoc($users);

	$id_user=$user[id];

	//todas las preferencias
	switch($_GET[action]){
		//listado
		case '1':
			//ids preferences user
			$notIn = '';
				$arrayIdsPrefe = userPreferencesIds($_GET[type], $id_user);

			if(count($arrayIdsPrefe)>0){
				foreach ($arrayIdsPrefe as $key){
					if ($key!='')
						$notIn .= "'".$key."',";
				}
			}

			//query preferences
			$where = '';
			if (trim($_GET['txt'])!='' && $notIn!=''){
				$where = " WHERE b.id_preference = '".$_GET[type]."' AND b.detail LIKE '%".$_GET['txt']."%' AND b.id NOT IN (".rtrim($notIn,',').") ";
			}elseif(trim($_GET['txt'])!='' && $notIn==''){
				$where = " WHERE b.id_preference = '".$_GET[type]."' AND b.detail LIKE '%".$_GET['txt']."%' ";
			}elseif(trim($_GET['txt'])=='' && $notIn!=''){
				$where = " WHERE b.id_preference = '".$_GET[type]."' AND b.id NOT IN (".rtrim($notIn,',').") ";
			}elseif(trim($_GET['txt'])=='' && $notIn==''){
				$where = " WHERE b.id_preference = '".$_GET[type]."' ";
			}

			$preferences = $GLOBALS['cn']->query("
				SELECT b.id AS id,
					a.id AS id_prefe,
					b.detail AS detail
				FROM preferences a INNER JOIN preference_details b ON a.id = b.id_preference
				$where
				ORDER BY b.detail
				LIMIT 0 , 50
			");

			while ($prefe = mysql_fetch_assoc($preferences)){
				if (trim($prefe['detail'])!='' && $prefe['id']!=''){
					$arrayPrefe['id']=$prefe['id'];
					$arrayPrefe['id_prefe']=$prefe['id_prefe'];
					$arrayPrefe['detail']=htmlentities(formatoCadena($prefe['detail']));
				}//if
			}//while
			$out = '';
		break;
		//update
		case '2':
			//seleccionamos las preferencias introducidas
			$imput = explode(',', $_GET[imput]);

			foreach ($imput as $value){
				$value = trim($value);

				if ($value!=''){

					$exists = $GLOBALS['cn']->query("
						SELECT id
						FROM preference_details
						WHERE detail LIKE '%".$value."%'
					");

					if (mysql_num_rows($exists)==0){
						$arrayPreferences[] = trim($value);
					}else{
						$exist = mysql_fetch_assoc($exists);
						$arrayPreferences[] = trim($exist[id]);
					}//existe

				}//value != ''
			}//foreach

			//seleccionamos las preferencias del usuarios
			$preferences = $GLOBALS['cn']->query("
				SELECT id_user, id_preference, preference
				FROM users_preferences
				WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
			");

			$prefe = mysql_fetch_assoc($preferences);
			$str_preferences = '';

			foreach ($arrayPreferences as $i){
				$i = trim($i);
				if ($i!=''){
					$prefe['preference'] = str_replace($i, '', $prefe['preference']);
					$str_preferences .= $i.',';
				}
			}

			//armamos la cadena de preferencias a guardar
			$str_preferences = $str_preferences.','.$prefe['preference'];
			$arrayStr = explode(',', $str_preferences);
			$str_preferences = '';
			foreach($arrayStr as $i){
				if (trim($i)!='')
					$str_preferences .= $i.',';
			}

			//update
			$exists = $GLOBALS['cn']->query("
				SELECT id_preference
				FROM users_preferences
				WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
			");

			if(mysql_num_rows($exists)==0){
				$GLOBALS['cn']->query("
					INSERT INTO users_preferences SET
						preference = '".rtrim($str_preferences,',')."',
						id_preference = '".$_GET[type]."',
						id_user = '".$id_user."'
				");
			}else{
				$GLOBALS['cn']->query("
					UPDATE users_preferences SET preference = '".rtrim($str_preferences,',')."'
					WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
				");
			}

			$out = 1;

		break;
		//listar preferencias del usuario
		case '3':
			//$arrayPrefe = array();
			$preferences = $GLOBALS['cn']->query("
				SELECT id_user, id_preference, preference
				FROM users_preferences
				WHERE id_user = '".$id_user."'
				ORDER BY id_preference
			");
			while($prefe=mysql_fetch_assoc($preferences)){
				$prex=explode(',',$prefe['preference']);
				for($i=0;$i<count($prex);$i++){
					if(trim($prex[$i])!=''){
						$query = $GLOBALS['cn']->query("
							SELECT id, detail
							FROM preference_details
							WHERE id = '".$prex[$i]."'
						");
						if (mysql_num_rows($query)>0){
							$array=mysql_fetch_assoc($query);
							$arrayPrefe['id_layer']='myPrefe_'.$array['id'];
							$arrayPrefe['type']=$prefe['id_preference'];
							$arrayPrefe['detail']=$array['detail'];
						}elseif(mysql_num_rows($query)==0){
							$arrayPrefe['id_layer']='myPrefe_'.str_replace(' ', '_',$prex[$i]);
							$arrayPrefe['type']=$prefe['id_preference'];
							$arrayPrefe['detail']=$prex[$i];
						}
					}//if trim($prex[$i])!=''
				}//for
			}//while users preferences
			$out = '';
		break;

		//delete
		case '4':
			//datos de la preferencia a borrar
			$prefe=$GLOBALS['cn']->queryRow("
				SELECT id_user, id_preference, preference
				FROM users_preferences
				WHERE id_user = '".$id_user."' AND id_preference = '".$_GET[type]."'
				ORDER BY id_preference
			");

			//seleccion de criterio a borrar
			$query = $GLOBALS['cn']->query("
				SELECT id, detail
				FROM preference_details
				WHERE id = '".$_GET[p]."'
			");

			if (mysql_num_rows($query)>0){
				$array = mysql_fetch_assoc($query);
				$str = $array[id];
			}elseif(mysql_num_rows($query)==0){
				$str = $_GET[detail];
			}

			$prefe[preference] = str_replace($str,'',$prefe[preference]);
			$prex = explode(',',$prefe[preference]);

			//armando cadena para actualizar la preferencia en cuestion
			for($i=0;$i<count($prex);$i++){
				if($prex[$i]!='')
					$str_preferences.=$prex[$i].',';

			}

			//update
			$str_preferences = rtrim($str_preferences,',');
			if (trim($str_preferences)!=''){
				$GLOBALS['cn']->query("
					UPDATE users_preferences SET preference='".$str_preferences."'
					WHERE id_user='".$id_user."' AND id_preference='".$_GET[type]."'
				");
			}else{
				$GLOBALS['cn']->query("
					DELETE FROM users_preferences
					WHERE id_user = '".$id_user."' AND id_preference='".$_GET[type]."'
				");
			}

			$out=$_GET[type].' | '.$str.' | '.rtrim($str_preferences,',');
		break;
	}

	die(jsonp(array(
		'preferences' => $arrayPrefe,
		'out'	=> ''//$out
	)));
}
?>