<?php 
     if ($_REQUEST['action']!=''){
		 
		 switch ($_REQUEST['action']){
			     case 'insert': mysql_query("INSERT INTO currency SET name = '".$_REQUEST[name]."', status = '1'") or die (mysql_error());
								break;
								
			     case 'update': mysql_query("UPDATE currency SET name = '".$_REQUEST[name]."' WHERE id = '".$_REQUEST[id_consulta]."'") or die (mysql_error());
				                break;
		 }
		 
		 mensajes("Sucessfully Process", "?url=vistas/publicity/currency.php", "info");
		 
	 }
?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
			<?php
                  $frm = new formulario('Publicity Currency', '?url='.$_GET[url], 'Send', 'Publicity Currency', $metodo='post');
                  
				  $frm->inicio();
				  
			  
				  if ($_REQUEST['id_consulta']!=''){
				      $frm->consulta=true;
					  $where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					  $frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				  }else{
					  $where = "";  
				  }				  
				  
				  $frm->inputs("SELECT
								currency.name AS name_1
								FROM
								currency
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
								currency.name as name,
								(select status.name from status where status.id = currency.status) as status
								
								FROM
								
								currency
								
								ORDER BY currency.name
								
								",1);
            ?>
        </td>
    </tr>
</table>
