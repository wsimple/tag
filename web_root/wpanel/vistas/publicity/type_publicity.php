<?php 
     if ($_REQUEST['action']!=''){
		 
		 switch ($_REQUEST['action']){
			     case 'insert': mysql_query("INSERT INTO type_publicity SET name = '".$_REQUEST[name]."', status = '1'") or die (mysql_error());
								break;
								
			     case 'update': mysql_query("UPDATE type_publicity SET name = '".$_REQUEST[name]."' WHERE id = '".$_REQUEST[id_consulta]."'") or die (mysql_error());
				                break;
		 }
		 
		 mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
		 
	 }
?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
			<?php
                  $frm = new formulario('Types Publicity', '?url='.$_GET[url], 'Send', 'Types Publicity', $metodo='post');
                  
				  $frm->inicio();
				  
			  
				  if ($_REQUEST['id_consulta']!=''){
				      $frm->consulta=true;
					  $where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					  $frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				  }else{
					  $where = "";  
				  }				  
				  
				  $frm->inputs("SELECT
								type_publicity.name AS name_1
								FROM
								type_publicity
								$where
                               ");
							   
				  $frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));
				  $frm->hidden('url',$_GET[url]);
				  
                  $frm->fin(false);  	
            ?>
        </td>
    </tr>
    <tr>
        <td>
			<?php
				  $frm->grilla("SELECT
								id,
								type_publicity.name as name,
								(select status.name from status where status.id = type_publicity.status) as status
								
								FROM
								
								type_publicity
								
								ORDER BY type_publicity.name
								
								",1);
            ?>
        </td>
    </tr>
</table>
