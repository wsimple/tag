<title>Control Panel :: Login</title>

<link href="../css/estilo.css" rel="stylesheet" type="text/css"> 
<link href="../css/alert_box.css" rel="stylesheet" type="text/css"> 
<link rel="shortcut icon" href="../img/favicon.ico"/>
<!--[if lt IE 7]>
<link href="http://cdn.no-ip.com/styles/ie-fix-site.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript" src="../js/msgbox/mootools_.js"></script>
<script type="text/javascript" src="../js/msgbox/alert_box.js"></script>
<script type="text/javascript" src="../js/request.js"></script> 
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript">
window.addEvent('domready',function(){
Alert = new AlertBox();
});
</script>	
<br><br>

<?php
	include ('../includes/funciones.php');
	if($_REQUEST['msj']=='no')
		mensajes("Access denied", "?", "error");
?>

<form name="login" id="login" method="post" action="../controladores/login.control.php">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
	<tr>
		<td colspan="2">
			<img src="../img/logo.png" border="0" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" class="tablas" bgcolor="#FFFFFF">
				<tr>
					<td colspan="3" class="top_titulos">&nbsp;Login</td>
				</tr>
				<tr>
					<td width="114">&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td class="contenido">User:&nbsp;</td>
					<td width="122"><input name="user" type="text" id="user" size="20" maxlength="100" requerido="Usuario" class="tex_box"></td>
					<td width="544"><img src="../img/login.png" width="16" height="16" border="0"  /></td>
				</tr>
				<tr>
					<td class="contenido">Password:&nbsp;</td>
					<td><input name="clave" type="password" id="clave" size="20" maxlength="100" requerido="Clave" class="tex_box"></td>
					<td><img src="../img/password.png" width="16" height="16" border="0"  /></td>
				</tr>
				<tr>
					<td style="text-align:center">&nbsp;</td>
					<td colspan="2" style="padding-left:4px">
						<input name="guarda" type="button" id="guarda" value="Send" class="boton" style="width:80px;" onclick="if(valida()){ this.form.submit(); }" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td width="108">&nbsp;</td>
		<td width="692">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center; color: #999999; font-size:10px; height:30px">Developed By Websarrollo.com & Maoghost.com</td>
	</tr>
</table>
</form>

<!--
	+-------------------------------------------------------------------+
	|	Desarrollado por: websarrollo.com								|
	|	Telefono: 0414-4284230 / 0416-7301061							|
	|	Email: gustavoocanto@gmail.com - miharbihernandez@gmail.com		|
	+-------------------------------------------------------------------+
-->