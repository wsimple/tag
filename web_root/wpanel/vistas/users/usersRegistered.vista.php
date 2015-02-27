<?php
	  $frm = new formulario('Registered Users', 
	  						'', 
							'Select', 
							'Select a client');
							
	  $frm->grillaDelete=false;
	  
	  $frm->destino = "?current=vistas/crew/add";
	  
	  $frm->fileRetorno = "vistas/crew/update";
	  
	  
	  $frm->grilla("SELECT
					id,
					name,
					last_name,
					email,
					date_birth,
					status,
					logins_count as logins,
					friends_count as links,
					created_at as 'sign up date'
					FROM users order by id desc ",5);
?>
