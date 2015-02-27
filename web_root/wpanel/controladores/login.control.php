<?php
      session_start();
	  include ('../../includes/config.php');
	  include ('../../includes/conexion.php');
	  include ('../includes/funciones.php');
	  
	  $query = mysql_query("SELECT * FROM users_panel WHERE login = '".cls_string($_REQUEST['user'])."' AND password = '".cls_string($_REQUEST['clave'])."'") or die (mysql_error());
      if (mysql_num_rows($query) != 0){	  
	      $array = mysql_fetch_assoc($query);
		  $_SESSION['wpanel_user']['nombre'] = $array['nombres'].' '.$array['apellidos'];
		  $_SESSION['wpanel_user']['login']  = $array['login'];
		  $_SESSION['wpanel_user']['clave']  = $array['password'];
		  $_SESSION['wpanel_user']['tipo']   = $array['tipo'];
		  $_SESSION['wpanel_user']['code']   = $array['code'];
		  $modulos = explode(',', $array['modulos']);
		  foreach ($modulos as $view){
			  $_SESSION['wpanel_user']['uris'][] = trim($view);
		  }
		  echo "<META HTTP-EQUIV=\"refresh\" content=\"0; URL=../index.php\">";
		  
	  }else{
	      if (mysql_num_rows($query) == 0){	
		      echo "<META HTTP-EQUIV=\"refresh\" content=\"0; URL=../vistas/login.vista.php?msj=no\">";
		  }
	  }	  
?>