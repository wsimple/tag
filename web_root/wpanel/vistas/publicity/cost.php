<?php 
     if ($_REQUEST['action']!=''){
		 
		 switch ($_REQUEST['action']){
			 
			     case 'insert': mysql_query("INSERT INTO cost_publicity SET id_typecurrency  = '".$_REQUEST[currency]."',
				                                                            id_typepublicity = '".$_REQUEST[type]."',
																			click_from       = '".$_REQUEST[from]."',
																			click_to         = '".$_REQUEST[to]."',
																			cost         = '".$_REQUEST[cost]."',
																			status           = '1'
				                            ") or die (mysql_error());
								break;
								
			     case 'update': mysql_query("UPDATE cost_publicity SET id_typecurrency  = '".$_REQUEST[currency]."',
				                                                       id_typepublicity = '".$_REQUEST[type]."',
																	   click_from       = '".$_REQUEST[from]."',
																	   click_to         = '".$_REQUEST[to]."',
																	   cost         = '".$_REQUEST[cost]."'
											 WHERE id = '".$_REQUEST[id_consulta]."'
				                            ") or die (mysql_error());
								break;
		 }
		 
		mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
		 
	 }
?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
			<?php
                  $frm = new formulario('Costs Publicity', '?url='.$_GET[url], 'Send', 'Costs Publicity', $metodo='post');
                  
				  $frm->inicio();
				  
			  
				  if ($_REQUEST['id_consulta']!=''){
				      $frm->consulta=true;
					  $where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					  $frm->hidden("id_consulta", $_REQUEST['id_consulta']);
					  
					  $sql[0] = "SELECT id AS valor, name AS descripcion FROM currency WHERE status = '1' | AND id = '".campo("cost_publicity", "id", $_REQUEST['id_consulta'], 1)."'";
					   
					  $sql[1] = "SELECT id AS valor, name AS descripcion FROM type_publicity WHERE status = '1' | AND id = '".campo("cost_publicity", "id", $_REQUEST['id_consulta'], 2)."'";  
				  
				  }else{
					  
					  $sql[0] = "SELECT id AS valor, name AS descripcion FROM currency WHERE status = '1' ORDER BY name"; 
					   
					  $sql[1] = "SELECT id AS valor, name AS descripcion FROM type_publicity WHERE status = '1' ORDER BY name";  
				  }				  
				  
				  $frm->selects(array("currency"=>$sql[0]));
				  
				  $frm->selects(array("type"=>$sql[1]));
				  
				  
				  $frm->inputs("SELECT c.click_from AS from_1,
				                       c.click_to AS to_1,
									   c.cost AS cost_1
				                FROM cost_publicity c 
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
								(select name from currency  where id=cost_publicity.id_typecurrency) AS currency,
								(select name from type_publicity where id=cost_publicity.id_typepublicity) AS type_publicity,
								
								click_from,
								click_to,
								cost,
								(select name from status where id = cost_publicity.status) as status
								
								FROM
								
								cost_publicity 
								
								ORDER BY click_from
								
								",1);
            ?>
        </td>
    </tr>
</table>
