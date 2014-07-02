<?php 
	 //filtros
	 
	 $_fecha1 = explode(" ", $_POST[fecha1]);
	 $_fecha2 = explode(" ", $_POST[fecha2]);
	 
	 $fecha1  = $_fecha1[2].'-'.$_fecha1[0].'-'.$_fecha1[1];
	 $fecha2  = $_fecha2[2].'-'.$_fecha2[0].'-'.$_fecha2[1];
	 
	 $where = "";
	 
	 if ($_POST[fecha1]!="" && $_POST[fecha2]==""){
		 
		 $where = " WHERE DATE(fecha) = '".$fecha1."'"; 
		 
	 }elseif($_POST[fecha1]=="" && $_POST[fecha2]!=""){
		 
		 $where = " WHERE DATE(fecha) = '".$fecha2."'"; 
		 
	 }elseif($_POST[fecha1]!="" && $_POST[fecha2]!=""){
		 
		 $where = " WHERE DATE(fecha) BETWEEN '".$fecha1."' AND '".$fecha2."'"; 
		 
	 }
	 
	 $payments = mysql_query("SELECT *  FROM paypal ".$where." ORDER BY fecha DESC") or die (mysql_error());
?>

<form id="payments" name="payments" method="post" action="" class="formulario" enctype="multipart/form-data">

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
        <fieldset>
       	<legend>Filters</legend>
                <table width="680" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr>
                <td class="etiquetas" style="text-align:left">Date Range:</td>
                </tr>
                <tr>
                <td>
                  <input name="fecha1" type="text" id="fecha1" size="15" readonly="readonly" value="<?=(($_POST[fecha1]!="")?$_POST[fecha1]:date("m d Y"))?>"><img src="img/calendar.png" onClick="displayCalendar(document.payments.fecha1,'m d yyyy',this);" style="cursor:pointer" title="View calendar" width="16" height="16" border="0" />&nbsp;
                  <input name="fecha2" type="text" id="fecha2" size="15" readonly="readonly" value="<?=(($_POST[fecha2]!="")?$_POST[fecha2]:date("m d Y"))?>"><img src="img/calendar.png" onClick="displayCalendar(document.payments.fecha2,'m d yyyy',this);" style="cursor:pointer" title="View calendar" width="16" height="16" border="0" />
                  &nbsp;&nbsp;&nbsp;
                  <input type='button' class='boton' name='erase' id='erase' value='Clear' onclick="document.payments.fecha1.value='';document.payments.fecha2.value='';" />
                </td>
                </tr>
                
                <tr><td>&nbsp;</td></tr>
                
                <tr style="background-color:#F4F4F4">
                <td style="text-align:center">
                <input type='button' class='boton' name='atras' id='atras' value='Search' onclick='this.form.submit();' />  
                <input type='button' class='boton' name='atras' id='atras' value='Refresh' onclick="redirect('?url=<?=$_GET[url]?>');" />  
                </td>
                </tr>
                </table>
        </fieldset>
        </td>
    </tr>


    <tr>
        <td>
        <fieldset>
       	<legend>Payments</legend>
                <table width="680" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; margin-top:10px; margin-bottom:10px; font-weight:normal; text-align:left; border:1px solid #FBCBA4; border-bottom:none">
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center" width="27">Id</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="55">User</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="173">Publicity</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="67">Amount</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="124">Description</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center" width="91">Id Trasaction</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="54">Status</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="55">Date</td>
                </tr>  
                <?php 
					  while ($pay = mysql_fetch_assoc($payments)){ 
					         $users = mysql_query("
							                        SELECT CONCAT(name,' ',last_name) AS name
													
													FROM users
													
													WHERE id = '".$pay[id_user]."'
							                      
												  ") or die (mysql_error());
												  
							 $user = mysql_fetch_assoc($users);
							 
					         $publicitys = mysql_query("
							                             SELECT id, link, id_tag, click_max, click_current
													
													     FROM users_publicity
													
													     WHERE id = '".$pay[id_publicity]."'
							                      
												       ") or die (mysql_error());
												  
							 $publicity  = mysql_fetch_assoc($publicitys);
			    ?>              
                <tr valign="top">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center"><?=$pay[id]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center"><?=$user[name]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">
						<strong>Ref:</strong>&nbsp;<?=$publicity[id]?>
                        <br />
                        <strong>Type:</strong>&nbsp;<?=(($publicity[id]=='0')?'Tag':'Other')?>
                        <br />
                        <strong>Link:</strong>&nbsp;<a href="<?=$publicity[link]?>" onfocus="this.blur();" target="_blank" title="Click Here">See Site</a>
                        <br />
                        <strong>Click Max:</strong>&nbsp;<?=$publicity[click_max]?>
                        <br />
                        <strong>Click Current:</strong>&nbsp;<?=$publicity[click_current]?>
                        <br />
                        <strong style="color:#F00">Remaining:&nbsp;</strong>&nbsp;<?=($publicity[click_max]-$publicity[click_current])?>
                    </td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center"><?=$pay[amount]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center"><?=$pay[description]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center"><?=$pay[txn_id]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center"><?=campo("status", "id", $pay[status], "name")?></td>
                    <td style="border-bottom:1px solid #FBCBA4; text-align:center"><?=$pay[fecha]?></td>
                </tr>
                <?php } ?>                
                </table>
        </fieldset>
        </td>
    </tr>
</table>

</form>


