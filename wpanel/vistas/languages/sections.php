<?php 
     if ($_REQUEST['action']!=''){
		 
		 switch ($_REQUEST['action']){
			     case 'insert': mysql_query("INSERT INTO sections_page SET name = '".$_REQUEST[name]."'") or die (mysql_error());
								break;
								
			     case 'update': mysql_query("UPDATE sections_page SET name = '".$_REQUEST[name]."' WHERE id = '".$_REQUEST[id_consulta]."'") or die (mysql_error());
				                break;
		 }
		 
		 mensajes("Sucessfully Process", "?url=vistas/languages/sections.php", "info");
		 
	 }
?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
			<?php
                  $frm = new formulario('sections page', '?url=vistas/languages/sections.php', 'Send', 'Registers Languages', $metodo='post');
                  
				  $frm->inicio();
				  
			  
				  if ($_REQUEST['id_consulta']!=''){
				      $frm->consulta=true;
					  $where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					  $frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				  }else{
					  $where = "";  
				  }				  
				  
				  $frm->inputs("SELECT
								sections_page.name AS name_1
								FROM
								sections_page
								$where
                               ");
							   
				  $frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));
				  
                  $frm->fin(false);  	
            ?>
        </td>
    </tr>
    <tr>
        <td>
			<?php
				  $frm->grilla("SELECT
								id,
								sections_page.name as name
								
								FROM
								
								sections_page
								
								ORDER BY sections_page.name
								
								",1);
            ?>
        </td>
    </tr>
</table>
