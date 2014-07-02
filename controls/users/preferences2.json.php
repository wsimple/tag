<?php
include '../header.json.php';

	if (quitar_inyect()){
		$users = $GLOBALS['cn']->query("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id)) = '".$_GET['code']."'");
		$user  = mysql_fetch_assoc($users);

		$id_user = $user[id];

		switch ($_GET[action]){

				//put preferences
				case '1':
					$query = $GLOBALS['cn']->query("
						SELECT id_user, id_preference AS id_prefe, preference AS detail
						FROM users_preferences
						WHERE id_preference = '".$_GET['type']."' AND id_user = '".$id_user."'
					");

					$prefe = mysql_fetch_assoc($query);
					$arrayDetail = explode(',',$prefe['detail']);
					$box = '';

					for ($i=0; $i<count($arrayDetail); $i++){
						if (!is_numeric($arrayDetail[$i])){
							$box .= trim($arrayDetail[$i]).',';
						}
					}

					$arrayPrefe[] = array(
						'id_prefe' => $prefe['id_prefe'],
						'detail' => htmlentities(formatoCadena(rtrim($box,',')))
					);


				break;

				//update
				case '2':

					//listado de preferencias seleccionadas de una lista predefinida
					$query = $GLOBALS['cn']->query("
						SELECT id_user, id_preference AS id_prefe, preference AS detail
						FROM users_preferences
						WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
					");

					$prefe = mysql_fetch_assoc($query);
					$arrayDetail = explode(',',$prefe['detail']);
					$box = '';

					for ($i=0; $i<count($arrayDetail); $i++){
						if (is_numeric($arrayDetail[$i])){
							$box .= trim($arrayDetail[$i]).',';
						}
					}

					$box = rtrim($box,',');

					//preferencias introducidas, sepradas por (,)

					$vectorText = explode('|',$_GET[text]);

					for ($i=0; $i<count($vectorText); $i++){
						$vectorText[$i] = trim($vectorText[$i]);
						if ($vectorText[$i]!=''){
							$stringSave .= formatoCadena($vectorText[$i]).',';
						}
					}

					if ($box!=''){

						$stringSave = rtrim($box.','.$stringSave,',');
					}else{
						$stringSave = rtrim($stringSave,',');
					}

					//update

					if (mysql_num_rows($query)==0){
						$GLOBALS['cn']->query("
							INSERT INTO users_preferences SET
								id_user = '".$id_user."',
								id_preference = '".$_GET[type]."',
								preference = '". $stringSave."'
						");
					}else{
						$GLOBALS['cn']->query("
							UPDATE users_preferences SET preference = '".$stringSave."'
							WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
						");
					}

				break;

				//touch
				case '3':

					$query = $GLOBALS['cn']->query("
						SELECT id_user, id_preference AS id_prefe, preference AS detail
						FROM users_preferences
						WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
					");

					if (mysql_num_rows($query)==0){

						$GLOBALS['cn']->query("
							INSERT INTO users_preferences SET
								id_user = '".$id_user."',
								id_preference = '".$_GET[type]."',
								preference = '".$_GET[p]."'
						");

					}else{
						$array = mysql_fetch_assoc($query);

						$preferences = explode(',', $array[detail]);

						if (!in_array($_GET[p], $preferences)){
							//$stringSave = $array[preference].','.$_get[p];

							$GLOBALS['cn']->query("
								UPDATE users_preferences SET preference = '".$array[detail].','.$_GET[p]."'
								WHERE id_preference = '".$_GET[type]."' AND id_user = '".$id_user."'
							");
						}



					}

				break;

				//listar preferencias del usuario
				case '4':
						//$arrayPrefe = array();
						$preferences = $GLOBALS['cn']->query("
							SELECT id_user, id_preference, preference
							FROM users_preferences
							WHERE id_user = '".$id_user."'
							ORDER BY id_preference
						");

						while ($prefe = mysql_fetch_assoc($preferences)){
							$prex = explode(',',$prefe['preference']);
							for ($i=0; $i<count($prex); $i++){
								if (trim($prex[$i])!=''){

									$query = $GLOBALS['cn']->query("
										SELECT id, detail
										FROM preference_details
										WHERE id = '".$prex[$i]."'
									");

									if (mysql_num_rows($query)>0){
										$array = mysql_fetch_assoc($query);
										$arrayPrefe[]=array(
											'id_layer'	=> 'myPrefe_'.$array[id],
											'type'		=> $prefe['id_preference'],
											'detail'	=> $array[detail]
										);
									}elseif(mysql_num_rows($query)==0){
										$arrayPrefe[] = array(
											'id_layer'	=> 'myPrefe_'.str_replace(' ', '_',$prex[$i]),
											'type'		=> $prefe['id_preference'],
											'detail'	=> $prex[$i]
										);
									}

								}//if trim($prex[$i])!=''
							}//for
						}//while users preferences

						$out = '';
				break;

				//delete
				case '5':
						//datos de la preferencia a borrar
						$preferences = $GLOBALS['cn']->query("
							SELECT id_user, id_preference, preference
							FROM users_preferences
							WHERE id_user = '".$id_user."' AND id_preference = '".$_GET[type]."'
							ORDER BY id_preference
						");

						$prefe = mysql_fetch_assoc($preferences);

						//seleccion de criterio a borrar
						$query = $GLOBALS['cn']->query("
							SELECT id, detail
							FROM preference_details
							WHERE id = '".$_GET[p]."'
						");

						// $datab = $prefe[preference];

						if (mysql_num_rows($query)>0){
							$array = mysql_fetch_assoc($query);
							$str = $array[id];
						}elseif(mysql_num_rows($query)==0){
							$str = $_GET['detail'];
						}

						$prefe[preference] = str_replace($str,'',$prefe[preference]);
						$prex = explode(',',$prefe[preference]);

						//armando cadena para actualizar la preferencia en cuestion
						for ($i=0; $i<count($prex); $i++){
							if ($prex[$i]!='')
								$str_preferences .= $prex[$i].',';
						}

						//update
						$str_preferences = rtrim($str_preferences,',');
						if (trim($str_preferences)!=''){
							$GLOBALS['cn']->query("
								UPDATE users_preferences SET preference = '".$str_preferences."'
								WHERE id_user = '".$id_user."' AND id_preference = '".$_GET[type]."'
							");
						}else{
							$GLOBALS['cn']->query("
								DELETE FROM users_preferences
								WHERE id_user = '".$id_user."' AND id_preference = '".$_GET[type]."'
							");
						}

						$out = $_GET[type].' | '.$str.' | '.rtrim($str_preferences,',');
				break;
		}

		die(jsonp(array(
			'preferences' => count($arrayPrefe)>0 ? $arrayPrefe : array() ,
			'out'	=> $out
		)));


	}//quitar_inyect
?>