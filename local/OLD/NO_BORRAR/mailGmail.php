<?php

    include ("includes/session.php");

	include ("includes/config.php");

	include ("includes/functions.php");

	include ("class/wconecta.class.php");
	
	include ("class/class.phpmailer.php");

    
	define('GUSER', 'seemytag@gmail.com'); // Gmail username
    
	define('GPWD', ''); // Gmail password


	function smtpmailer($to, $from, $from_name, $subject, $body) { 
		 
			 $mail = new PHPMailer();  // create a new object
			 
			 $mail->PluginDir = "class/PHPMailer_v5.1/";
			 
			 $mail->IsSMTP(); // enable SMTP
			 
			 $mail->SMTPAuth = true;  // authentication enabled
			 
			 $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
			 
			 $mail->Host = 'smtp.gmail.com';
			 
			 $mail->Port = 587; 
			 
			 $mail->Username = GUSER;  
			 
			 $mail->Password = GPWD;    
			 
			 $mail->SetFrom('no-reply@seemytag.com','De Yo');
			 
			 $mail->AddReplyTo("info@websarrollo.com", "Websarrollo");
			 			 
			 $mail->IsHTML(true);
			 
			 $mail->Subject = $subject;
			 
			 $mail->Body = $body;
			 
			 $mail->AddAddress($to,'(Seemytag)');
			 
			 if (!$mail->Send()) {
			     echo 'Mail error: '.$mail->ErrorInfo; 
			     return false;
			 }else{
			     echo  'Message sent! - '.$mail->From;
				 
			     return true;
			 }
	}
	
	
	/*smtpmailer('gustavoocanto@gmail.com', 'no-reply@seemytag.com', 'no-reply@seemytag.com', 'Asunto de Prueba', 'test mail message', 'Hello World!');
	smtpmailer('miharbihernandez@gmail.com', 'no-reply@seemytag.com', 'no-reply@seemytag.com', 'Asunto de Prueba', 'test mail message', 'Hello World!');
	smtpmailer('luisarraezd@gmail.com', 'no-reply@seemytag.com', 'no-reply@seemytag.com', 'Asunto de Prueba', 'test mail message', 'Hello World!');
	smtpmailer('ertesteo.1@gmail.com', 'no-reply@seemytag.com', 'no-reply@seemytag.com', 'Asunto de Prueba', 'test mail message', 'Hello World!');
   
	
	
	//sendMail($body, "no-reply@seemytag.com", "Seemytag.com", MENUTAG_CTRSHAREMAILASUNTO, $per, "../../");
*/
   if (sendMail('prueba', 'no-reply@seemytag.com', 'Seemytag.com', 'Prueba>>> ', 'gustavoocanto@gmail.com', ''))
       echo 'bello';
   else
      echo 'fuck'; 


?>

















