


<?php
      include ("../../includes/functions.php");
	  include ("../config.php");
	  include ("../../class/class.phpmailer.php");
	  
	  
	  echo $body = formatMail("<br/><br/>Prueba del nuevo formato para los email, Seemytag. George Esperamos tu aprobacion para ir adaptando<br/><br/>", DOMINIO);
	  
	  sendMail($body, "no-reply@seemytag.com", "Seemytag.com", "Nuevo formato email", "gustavoocanto@gmail.com", "../../");
	  sendMail($body, "no-reply@seemytag.com", "Seemytag.com", "Nuevo formato email", "miharbihernandez@gmail.com", "../../");
	  sendMail($body, "no-reply@seemytag.com", "Seemytag.com", "Nuevo formato email", "jorge@icoffeemail.me", "../../");
	  
	  
	  
?>