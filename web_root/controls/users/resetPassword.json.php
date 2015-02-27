<?php
//Includes a utilizar
include '../header.json.php';
include (RELPATH.'class/class.phpmailer.php');
include "../../class/validation.class.php";

$res['action']=$_POST['action'];
switch($_POST['action']){
    case '0': //enviar el code al correo del usuario 
        if(valid::isEmail($_POST['email'])) {
        	if(CON::exist("users","email LIKE ?",array($_POST['email']))) {
    			$query=CON::getRow("SELECT
										md5(CONCAT(id, '+', id, '+', id)) AS code,
										CONCAT(name, ' ', last_name) AS name
									FROM users
									WHERE email LIKE ?",array($_POST['email']));
                $body = '<table width="700" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
    					   <tr><td style="text-align:left; font-size:18px; padding:0; color: #ff8a28;"><strong>'.formatoCadena($query['name']).', '.FORGOT_CTRMSGMAIL1.'</strong></td></tr>
    					   <tr><td>&nbsp;</td></tr>
    					   <tr>
                                <td style="font-size:11px; color:#000; padding:0; text-align:justify">
                                    '.FORGOT_CTRMSGMAIL2.'.<br />'.FORGOT_CTRMSGMAIL3.':<br /><br />
        					        <a href="'.DOMINIO.'resetPassword?usr='.$query['code'].'" target="_blank">'.DOMINIO.'/resetPassword?usr='.$query['code'].'</a>
    					        </td>
    					   </tr>
    					   <tr><td>&nbsp;</td></tr>
    					   <tr><td>&nbsp;</td></tr>
    					   <tr><td style="font-size:11px; color:#000; padding:0; text-align:justify">'.FORGOT_CTRMSGMAIL4.'. </td></tr>
    					   <tr><td style="text-align:left; font-size:14px; padding:0">&nbsp;</td></tr>
    					   <tr><td style="font-size:11px; color:#000; padding:0; text-align:justify">'.FORGOT_CTRMSGMAIL5.'</td></tr>
    					   <tr><td style="text-align:left; font-size:14px; padding:0">&nbsp;</td></tr>
    					   <tr><td>'.SIGNUP_BODYEMAIL4.'</td></tr>
    					</table>';
                if( sendMail(formatMail($body, 800), EMAIL_NO_RESPONDA, 'Tagbum.com', 'Reset your Tagbum password',$_POST['email'], '../../',true) ) {
                    //sendMail(formatMail($body, 800), EMAIL_NO_RESPONDA, 'Tagbum.com', 'Reset your Tagbum password',$_POST['email'], '../../');
                    $res['exit']=$_POST['email'];
                }else{ $res['error']='notEmail'; }
    		}else{ $res['error']='emailNotExist'; }
        }else{ $res['error']='emailInvalid'; }
    break;
    case '1': 
        $test=isset($_POST['id'])?($mobile?'md5(CONCAT(id, "+", id, "+", id)) = ?':'id = ?'):'';

        // $post = isset($_POST['id'])?'post id activo':'post id activo';
        // $mo = isset($mobile)?"md5(CONCAT(id, '+', id, '+', id)) = ?":"id = ?";
        if ($test!=''){
            if((trim($_POST['clave1']) && trim($_POST['clave2'])) && ($_POST['clave1'] == $_POST['clave2'])) {
                $query = CON::getRow("SELECT id,password_user as password FROM users WHERE ".$test,array($_POST['id']));
                if ($query['id']!=''){
                    if (isset($_POST['out'])){ $clave=$query['password']; }
                    else{ $clave=$_POST['clave0']; }
                    if((trim($query['password'])==(trim($clave))) && ($query['password'] == $clave)) {
            			if(strlen($_POST['clave1'])>=6){
            						$GLOBALS['cn']->query("	UPDATE users
            												SET password_user = '".cls_string($_POST['clave1'])."'
            												WHERE id = '".$query['id']."'");
                            $res['exit']=true;
            			}else{ $res['error']='pasMenorleng'; }        
            		}else{ $res['error']='pasInvalid'; }
                }else{ $res['error']='noInvalid'; }
            }else{ $res['error']='noPasCoin'; }
        }else{ $res['error']='noIp'; }
    break;
}

// $res['mensaje'] = '<br>exit: '.$res['exit']'<br>action: '.$res['action'].'<br> id: '.$_POST['id'].'<br> mobile: '.$mobile.'<br> post: '.$post.'<br> mo: '.$mo;
die(jsonp($res));
?>
