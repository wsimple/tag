<?php 
     if ($_REQUEST['action']!=''){
		 switch ($_REQUEST['action']){
			 
			     case 'insert': 
					 mysql_query("
						 INSERT INTO cost_points SET 
							id_typecurrency = '".$_REQUEST['currency']."',
							amount_from = '".$_REQUEST['costs-points_amount_from']."',
							amount_to = '".$_REQUEST['costs-points_amount_to']."',
							cost = '".$_REQUEST['cost']."',
							status = '1'
				     ") or die (mysql_error());
				 break;
								
			     case 'update': 
					 mysql_query("
						 UPDATE cost_points SET 
							id_typecurrency = '".$_REQUEST['currency']."',
							amount_from = '".$_REQUEST['costs-points_amount_from']."',
							amount_to = '".$_REQUEST['costs-points_amount_to']."',
							cost = '".$_REQUEST['cost']."',
							status = '1'
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
                  $frm = new formulario('Costs Points', '?url='.$_GET[url], 'Send', 'Costs Points', $metodo='post');
				  $frm->inicio();		  
			  
				  if ($_REQUEST['id_consulta']!=''){
				      $frm->consulta=true;
					  $where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					  $frm->hidden("id_consulta", $_REQUEST['id_consulta']);					  
					  $sql[0] = "
						  SELECT id AS valor, name AS descripcion 
						  FROM currency 
						  WHERE status = '1' | AND id = '".campo("cost_points", "id", $_REQUEST['id_consulta'], 1)."'
					  ";
				  }else{
					  $sql[0] = "
						  SELECT id AS valor, name AS descripcion 
						  FROM currency 
						  WHERE status = '1' 
						  ORDER BY name
					  "; 
				  }				  
				  
				  $frm->selects(array("currency"=>$sql[0]));
				  $frm->inputs("
						  SELECT 
							c.amount_from AS amount_from_1,
				            c.amount_to AS amount_to_1,
							c.cost AS cost_1
				          FROM cost_points c 
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
				$frm->grilla("
					SELECT
						id,
						(select name from currency  where id=cost_points.id_typecurrency) AS currency,
						amount_from,
						amount_to,
						cost,
						(select name from status where id = cost_points.status) as status		
					FROM cost_points 
					ORDER BY amount_from
				",1);
            ?>
        </td>
    </tr>
</table>