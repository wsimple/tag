<?php
/*******************************/
/*   Agerga, edita y elimina   */
/*   un producto o una rifa		*/
/*	de la store					*/
/*******************************/

//Includes a utilizar
include '../header.json.php';
include (RELPATH.'class/class.phpmailer.php');
$myId=$_SESSION['ws-tags']['ws-user']['id'];
// $_GET['acc']='0';
// $userId='1'; 
// $status='2'; 
// $txtCategory='3';
// $txtSubCategory='4';
// $txtName='5';
// $txtDescription='6'; 
// $txtStock='7'; 
// $txtPrice='8';
// $img='9';
// $place='10';
// $txtMethod='11';
// $txtVideo='12';

switch ($_GET['acc']) {
    case 'img': 
        $img = uploadPhoto();
        $res['action'] = 'img';
		$res['img'] = $img;
        break;
    case '0': //Agregar producto
		if( quitar_inyect() ) {
			$userId = $_SESSION['ws-tags']['ws-user']['id'];
			foreach ($_POST as $nameVar => $valueVar) ${$nameVar} = "$valueVar";
			$txtPrice = str_replace(',','',$txtPrice); //Formatea el tipo de dinero para ser insertado
			
            if (isset($backgSelect_)){
				$place='null';
				$txtCategory='1';
				$txtSubCategory='1';
				$txtMethod=0;
                $img=$backgSelect_;
			}else{ 
			    $place='1'; 
                for($i=1;$i<6;$i++){ if($_POST['backgSelect_'.$i]!='') { $img=$_POST['backgSelect_'.$i]; break; } }
				// echo $img;
            }
            if($txtVideo==''||!preg_match(regex('video'),$txtVideo)) $txtVideo=='http://';
            else $txtVideo=str_replace("'",'',$txtVideo);
            $txtDescription=str_replace("href=","",$txtDescription);
           	$idproduct=CON::insert('store_products','id_user=?,
									id_status=?,id_category=?,
									id_sub_category=?,name=?,
									description=?,stock=?,
									sale_points=?,photo=?,
									join_date=NOW(),update_date=NOW(),
									place=?,formPayment=?,
									video_url=?',array($userId,$status,$txtCategory,$txtSubCategory,formatText($txtName),($txtDescription),$txtStock,$txtPrice,$img,$place,$txtMethod,$txtVideo));
			if (!isset($backgSelect_)){
				$band=false;
				// $idproduct=mysql_insert_id();
				$sql='INSERT INTO `store_products_picture` (
						`id` ,`id_product` ,`picture` ,`order` ,`status` ) VALUES ';
				for ($y=1;$y<6;$y++){
					if ($_POST['backgSelect_'.$y]){
						$sql.=($band?',':'').safe_sql("(?,?,?,?,1)",array($y,$idproduct,$_POST['backgSelect_'.$y],$_POST['txtOrder'.$y]));
						$band=true;
					}
				}
				$sql.=';';
				$result = CON::query($sql);
			}
			if($result){ 
				$res['action'] = 'insert'; 
				$wid=CON::getVal('SELECT users.id FROM users JOIN store_raffle_users ON users.email=store_raffle_users.email WHERE store_raffle_users.email = "'.$_SESSION['ws-tags']['ws-user']['email'].'";');
				notifications($userId,$idproduct,30,"",$wid);
			}			
		}
    break;
    case '1': //Editar Producto
		if( quitar_inyect() ) {
		  if( isset($_GET['id']) ){
    		  if (existe('store_products', 'id', 'WHERE id= "'.$_GET['id'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"')){
    			if (!existe('store_orders o JOIN store_orders_detail od ON od.id_order=o.id', 'o.id', 'WHERE od.id_product= "'.$_GET['id'].'" AND ((o.id_status="1" AND od.id_status="11") OR (o.id_status="11" AND od.id_status="11"))')){
				    foreach ($_POST as $nameVar => $valueVar) ${$nameVar} = "$valueVar";
					if (isset($backgSelect_)){
        				$place='null';
        				$txtCategory='1';
        				$txtSubCategory='1';
        				$txtMethod=0;
                        $img=$backgSelect_;
        			}else{ 
        			    $place='1'; 
                        for($i=1;$i<6;$i++){ if($_POST['backgSelect_'.$i]!='') { $img=$_POST['backgSelect_'.$i]; break; } }
                    }
					$txtPrice = str_replace(',','',$txtPrice); //Formatea el tipo de dinero para ser insertado
                    if($txtVideo==''||!preg_match(regex('video'),$txtVideo)) $txtVideo=='http://';
                    else $txtVideo=str_replace("'",'',$txtVideo);
            		$txtDescription=str_replace("href=","",$txtDescription);
					$result = CON::update('store_products','id_status=?,name=?,id_category=?,id_sub_category=?,
										description=?,stock=?,sale_points=?,photo=?,update_date=NOW(),formPayment=?,video_url=?',
										'id=?',
										array($status,formatText($txtName),$txtCategory,$txtSubCategory,($txtDescription),$txtStock,$txtPrice,$img,$txtMethod,$txtVideo,$_GET['id']));
					if (!isset($backgSelect_)){
						$band=false;
						for ($y=1;$y<6;$y++){
							if ($_POST['backgSelect_'.$y])
								CON::insert_or_update('store_products_picture','picture=?,store_products_picture.order=?','id=?,id_product=?,status=1','id=? AND id_product=?',
									array($_POST['backgSelect_'.$y],$_POST['txtOrder'.$y],$y,$_GET['id'],$y,$_GET['id']));
						}
					}
                    if ($result) $res['action']='update';
    			  }else{ $res['action']='no-update'; }
                }else{$res['action']='no-per-id-update'; }
            }else{ $res['action']='no-id-update'; }
		}
    break;
    case '2': //Borrar Producto
        if(isset($_GET['id'])){
            if (existe('store_products', 'id', 'WHERE id= "'.$_GET['id'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"')){
                if (!existe('store_orders o JOIN store_orders_detail od ON od.id_order=o.id', 'o.id', 'WHERE od.id_product= "'.$_GET['id'].'" AND ((o.id_status="1" AND od.id_status="11") OR (o.id_status="11" AND od.id_status="11"))')){
    				$sql="  UPDATE store_products 
                            SET id_status='2', stock=0  
                            WHERE id= ".$_GET['id'];
    				$result = $GLOBALS['cn']->query($sql);
    				if( $result ) $res['action']='delete';
    			}else{ $res['action']='no-update'; }
            }else{$res['action']='no-per-id-update'; }
        }else{ $res['action']='no-id-update'; }
    break;
	case '3'://crear una nueva rifa
        if (isset($_GET['idProduct'])){
			if(!existe('store_raffle', 'id', 'WHERE id_product = "'.$_GET['idProduct'].'" AND id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'" AND status = 1')){
				$carrito=$GLOBALS['cn']->query('SELECT id_category,stock FROM store_products WHERE id="'.$_GET['idProduct'].'" AND id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'" AND id_status = 1 LIMIT 1;');				
                if (mysql_num_rows($carrito)>0){
                    $carrito=  mysql_fetch_assoc($carrito);
    				if ($carrito['id_category']!='1'){
    					$num=(intval($carrito['stock'])-1);
    					if ($num>=0){
    						$GLOBALS['cn']->query('	UPDATE store_products SET 
    													'.($num=='0'?'id_status="2",':'').'
    														stock='.$num.'
    												WHERE id="'.$_GET['idProduct'].'" 
    												AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'";');
    						$_GET['txtPrice'] = str_replace(',','',$_GET['txtPrice']); //Formatea el tipo de dinero para ser insertado
    						$GLOBALS['cn']->query("INSERT INTO store_raffle
    									   SET id_product = '".$_GET['idProduct']."',
    										   id_user    = '".$_SESSION['ws-tags']['ws-user']['id']."',
    										   points     = '".$_GET['txtPrice']."',
    										   cant_users = '".$_GET['txtCant']."',
    										   status     = '1'");
    						$res['action']='rifa';
    					}else{ $res['action']='no-stock'; }
    				}else{
    					$GLOBALS['cn']->query("INSERT INTO store_raffle
    									   SET id_product = '".$_GET['idProduct']."',
    										   id_user    = '".$_SESSION['ws-tags']['ws-user']['id']."',
    										   points     = '".$_GET['txtPrice']."',
    										   cant_users = '".$_GET['txtCant']."',
    										   status     = '1'
    					");
    					$res['action']='rifa';
    				}
                }else{ $res['action']='no-per-id-update'; }
			}else{ $res['action']='exist'; }
        }else{ $res['action']='no-id-update'; }
	break;
	case '4': //unirse a la rifa y sorteo de la rifa...
        if (isset($_GET['rfl'])){
            if (!CON::getVal("SELECT id FROM store_raffle_join WHERE md5(id_raffle)=? AND id_user=?",array($_GET['rfl'],$myId))){
				$Raffle = CON::getRow("SELECT 
											COUNT( rj.id ) AS cant_join, 
											r.cant_users, 
											r.points,
											r.id,
                                            r.id_user
										FROM store_raffle r
										LEFT JOIN store_raffle_join rj ON rj.id_raffle = r.id
										WHERE  md5(r.id)=?;",array($_GET['rfl']));
				$res['deb']=$Raffle;
				if($Raffle['cant_join']<$Raffle['cant_users']){
					//consultamos los puntos del usuario
					$pointsUser = CON::getRow("SELECT 	accumulated_points AS accumulated_points,
									   					current_points AS current_points
												FROM users a
												WHERE id = ?",array($myId));
						if($pointsUser['current_points']>$Raffle['points']){
							//ingresamos al usuario a la rifa
							$id =CON::insert("store_raffle_join","id_user=?,id_raffle=?",array($myId,$Raffle['id']));
							if ($id){
								//decrementar los puntos del usuario por ingresar a la rifa
								CON::update("users","accumulated_points=accumulated_points-?,current_points=current_points-?","id=?",array($Raffle['points'],$Raffle['points'],$myId));
								//aumentar los puntos del usuario dueño de la rifa
								CON::update("users","accumulated_points=accumulated_points+?,current_points=current_points+?","id=?",array($Raffle['points'],$Raffle['points'],$Raffle['id_user']));
								$res['action']='join';
								if(($Raffle['cant_join']+1)==$Raffle['cant_users']){
									$res['action'] = 'end';
									$array=CON::getAssoc("	SELECT r.id_user AS id, u.email 
															FROM store_raffle_join r
															JOIN (SELECT su.email, su.id FROM users su) u ON u.id=r.id_user
															WHERE r.id_raffle=?",array($Raffle['id']));
									$Winner=array_rand($array);
									CON::update("store_raffle","status='2',end_date=NOW(),winner=?","id=?",array($array[$Winner]['id'],$Raffle['id']));
									notifications($array[$Winner]['id'],$Raffle['id'],19,false,$Raffle['id_user'],$array);
							}
						}else $res['action']='error';
					}else{ $res['action']='no-points'; }
            	}else{ $res['action']='no-cupon'; }
            }else{ $res['action']='exist'; }
        }else{ $res['action']='no-id-update'; }
	break;
}

//Retorno al ajax
die(jsonp($res));

//Funciones necesartias
function uploadPhoto(){
    //Si todo salio bien (valor de retorno)
	$auxi='';
	if ($_SESSION['ws-tags']['ws-user']['type']==1){
		$auxi=$_GET['num'];
		$pa='store';
	} else { $pa='templates'; }
    $imagesAllowed = array('jpg','jpeg','png','gif');
    $parts         = explode('.', $_FILES['photo'.$auxi]['name']);
    $ext           = strtolower(end($parts));
    if (in_array($ext,$imagesAllowed)){
        $path  = RELPATH."img/".$pa."/".$_SESSION['ws-tags']['ws-user']['code'].'/';       //ruta para crear dir
        $photo = $_SESSION['ws-tags']['ws-user']['code'].'/'.md5($_FILES['photo'.$auxi]['name']).'.jpg';
        $photo_= md5($_FILES['photo'.$auxi]['name']).'.jpg';

        //existencia de la folder
        if (!is_dir ($path)){
            $old = umask(0);
            mkdir($path,0777);
            umask($old);
            $fp=fopen($path.'index.html',"w");
            fclose($fp);
        }// is_dir

        if (redimensionar($_FILES['photo'.$auxi]['tmp_name'], RELPATH."img/".$pa."/".$photo, 650)){
            uploadFTP($photo_,$pa,RELPATH);
            $r['img'] = $pa.'/'.$photo;
            $r['pos']=($auxi?$auxi:'');
        }
    }else {$r['img']=''; }
    return $r;
}
?>
