<?php 
if ($_REQUEST['action']!=''){

	switch ($_REQUEST['action']){
		case 'insert': mysql_query("INSERT INTO cost_points SET points  = '".$_REQUEST['points']."',
		                price = '".$_REQUEST['price']."', description = '".$_REQUEST['description']."',
						status           = '1'
		            ") or die (mysql_error());
		break;
		case 'update': mysql_query("UPDATE cost_points SET points  = '".$_REQUEST['points']."',
		               price = '".$_REQUEST['price']."',
		               description = '".$_REQUEST['description']."',
		     		   status           = '".$_REQUEST['price']."'
					   WHERE id = '".$_REQUEST['id_consulta']."'
		            ") or die (mysql_error());
		break;
	}

	mensajes("Sucessfully Process", "?url=".$_REQUEST['url'], "info");
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

					$sql = "SELECT id AS valor, name AS descripcion FROM status WHERE id IN ('1','2')";  //Esto sera diferente

				}else{
					$sql = "SELECT id AS valor, name AS descripcion FROM status WHERE id IN ('1','2')";
				}				  

				$frm->inputs("SELECT p.points AS points_1,
				                   p.price AS price_1,
				                   p.description AS description_1
				            FROM cost_points p 
							$where
						   ");
				$frm->selects(array("status"=>$sql));
						   
				$frm->hidden('action',(($_REQUEST['id_consulta']!='')?'update':'insert'));

				$frm->hidden('url',$_GET[url]);

				$frm->fin(false);  	
            ?>
        </td>
    </tr>
    <tr>
        <td>
			<?php
				$frm->grilla("SELECT
							id,description,points,price,
							(SELECT name FROM status WHERE id = cost_points.status) AS status
							FROM
							cost_points 
							ORDER BY price DESC
							",1);
            ?>
        </td>
    </tr>
</table>