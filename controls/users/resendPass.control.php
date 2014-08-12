<?php
	//session_start();
	include "../../includes/session.php";
	include "../../includes/config.php";
	include "../../includes/functions.php";
	include "../../class/wconecta.class.php";
	include "../../includes/languages.config.php";
	include "../../class/forms.class.php";
	include "../../class/validation.class.php";
	include "../../class/class.phpmailer.php";



	if( quitar_inyect() ) {
		$_SESSION['ws-tags']['resendPass']['email']      = $_POST['email'];
		//$_SESSION['ws-tags'][resendPass][txtCaptcha] = str_replace('-', ' ', strtolower($_POST[txtCaptcha]));
		$_SESSION['ws-tags']['resendPass']['error']      = array();

		$paso = 1;

		//Email
		if( !valid::isEmail($_SESSION['ws-tags'][resendPass][email]) ) {
			$paso  = 0;
			$_SESSION['ws-tags']['resendPass']['error'][]= "-&nbsp;".SIGNUP_CTRERROREMAIL.".<br/>";
		}

		//Email exists
		if( !existe("users", "email", " WHERE email LIKE '".$_SESSION['ws-tags'][resendPass][email]."'") ) {
			$paso  = 0;
			$_SESSION['ws-tags']['resendPass']['error'][]= "-&nbsp;".FORGOT_CTRERRORMAIL_NOEXISTE.".<br/>";
		}


		if( $paso==1 ) {
		    //enviamos el correo
			$query = $GLOBALS['cn']->query("SELECT
												md5(CONCAT(id, '+', id, '+', id)) AS code,
												CONCAT(name, ' ', last_name) AS name
											FROM users
											WHERE email LIKE '".$_SESSION['ws-tags'][resendPass][email]."'");

			$array = mysql_fetch_assoc($query);
			$body = '
						<table width="700" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
						<tr>
							<td style="text-align:left; font-size:18px; padding:0; color: #ff8a28;"><strong>'.formatoCadena($array[name]).', '.FORGOT_CTRMSGMAIL1.'</strong></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td style="font-size:11px; color:#000; padding:0; text-align:justify">
								'.FORGOT_CTRMSGMAIL2.'.<br />'.FORGOT_CTRMSGMAIL3.':<br /><br />
								<a href="'.DOMINIO.'resetPassword&usr='.$array['code'].'" target="_blank">'.DOMINIO.'/resetPassword&usr='.$array['code'].'</a>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td style="font-size:11px; color:#000; padding:0; text-align:justify">'.FORGOT_CTRMSGMAIL4.'. </td></tr>
						<tr><td style="text-align:left; font-size:14px; padding:0">&nbsp;</td></tr>
						<tr><td style="font-size:11px; color:#000; padding:0; text-align:justify">'.FORGOT_CTRMSGMAIL5.'</td></tr>
						<tr><td style="text-align:left; font-size:14px; padding:0">&nbsp;</td></tr>
						<tr><td>'.SIGNUP_BODYEMAIL4.'</td></tr>
						</table>
					';
			
			if( sendMail(formatMail($body, 800), 'no-reply@seemytag.com', 'Tagbum.com', 'Reset your Tagbum password', $_SESSION['ws-tags']['resendPass']['email'], '../../') ) {
				echo "1*".$_SESSION['ws-tags']['resendPass']['email'];
			} else { echo "0*"; }
		} else { echo "0*"; }

	}//quitar_inyect
?>