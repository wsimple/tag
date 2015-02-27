<?php
include '../header.json.php';
include(RELPATH.'class/class.phpmailer.php');
include(RELPATH.'class/validation.class.php');
if ( quitar_inyect() ){


	$msj = $_POST['msj'];
	$mails = $_POST['data'];

	if (count($mails)>0){
		//$personas = trim(trim($mails,','));
		//$persona  = explode(',', $personas);
		$correos="";
		$share=DOMINIO.'css/smt/tag/groups_default.png';

        if ($msj!=""){
            $trMsj = '<tr>
                        <td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.convertir_especiales_html($msj).'</td>
                     </tr>';
        } else { $trMsj = ''; }
        $queryGroup="SELECT name, photo, description AS des
                FROM  `groups`
                WHERE md5(id)='".$_GET['grp']."'
                LIMIT 1";
        $group=$GLOBALS['cn']->query($queryGroup);
        $group=  mysql_fetch_assoc($group);
       
        $groupPhoto= file_exists(RELPATH.'img/groups/'.$group['photo'])?DOMINIO.'img/groups/'.$group['photo']:DOMINIO.'css/smt/groups_default.png';
		$linkGroup = DOMINIO.base_url('groupsDetails?grp='.$_GET['grp']);
        foreach ($mails as $per){
            if (!strpos($per,'@')){ $per = campo("users", "md5(id)", $per, "email"); }
            if ($per!='' && valid::isEmail($per)) {
                //verificar si el correo esta registrado o no en tagbum
                $query = $GLOBALS['cn']->query('
                    SELECT 
                        u.id AS id,
                        u.email AS email 
                    FROM users u
                    WHERE u.email = "'.$per.'"
                ');

                //cuerpo del email
				$body  = '<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;border-radius:7px; background: #fff; padding-top:5px">
                            '.showInfoUser().'
                            <tr>
                                <td colspan="2" style="color:#000; padding-left:5px; font-size:14px">
                                    <table style="width:100%;"><tr>
                                        <td style="width:20px;">
                                            <img src="'.$share.'" width="16" height="16" border="0" />
                                        </td>
                                        <td style="text-align: left; width:450px;">
                                            <strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'</strong>'.GROUP_SHAREMAILTITLE1.'
                                        </td>
                                        <td background="'.DOMINIO.'css/smt/email/yellowbutton_get_started2.png" style="width: 140px; height: 22px;  display: inline-block; background-repeat: no-repeat; padding: 10px 14px 5px 5px;">
                                            <a style="font-weight: bold; color: #2d2d2d; font-size:12px; text-decoration: none" href="'.$linkGroup.'">'.GROUP_SHAREMAILTITLE2.'</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding-top: 25px;">
                                            <table style="width:100%;"><tr>
                                            <td style="width: 130px;"><img src="'.$groupPhoto.'" style="width:120px;height:80px;border-radius: 8px;-moz-border-radius: 8px; -ms-border-radius: 8px; -o-border-radius: 8px;overflow: hidden;"/></td>
                                            <td valign="top" align="left">
                                                <div><strong>
                                                    <img src="'.$GLOBALS['config']->main_server.'css/smt/menu_left/groups.png" alt="Group Icons" width="30" height="30">
                                                    '.$group['name'].'</strong>
                                                </div>
                                                <div style="font-size: 10px;">'.$group['des'].'</div>
                                            </td>
                                            </tr></table>
                                        </td>
                                    </tr></table>
                                </td>
                            </tr><tr>
                                <td colspan="2" valign="top"> 
        							<table width="100%">
        								<tr><td width="100%">'.$trMsj.'</td></tr>
        							</table>
                                </td>
                            </tr><tr>
        						<td colspan="2" valign="top">
        							<table width="100%">
        								<tr>
        									<td align="center"style="padding-left:5px; text-align:center">'.
        										GROUP_CTRSHAREMAILTITLE3.': <a href="'.$linkTag.'">Tagbum.com</a>
        									</td>
        								</tr>
        							</table>
        						</td>
                            </tr>
                        </table>';
				//envio del correo
				if (sendMail(formatMail($body, "790"),EMAIL_NO_RESPONDA,formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.GROUP_EMAILASUNTOSUGGEST, $per, "../../")){
					$correos .= "-&nbsp;".$per.".<br/>";
				}//end if envio de correo
			}//if per
		}//foreach
	}//if (count($mails)>0)
	//echo (($correos!="")?'<div class="div_exito"><strong>'.GROUP_SUGGESTOKMAIL.":</strong></div><br><br> ".$correos : '<div class="div_error">'.GROUP_SUGGESTERRORMAIL.'</div>');
	$res['menjs']= (($correos!="")?'<div class="div_exito"><strong>'.GROUP_SUGGESTOKMAIL.":</strong></div><br><br> ".$correos : '<div class="div_error">'.GROUP_SUGGESTERRORMAIL.'</div>');
}
die(jsonp($res));
?>
